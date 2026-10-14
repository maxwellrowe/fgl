<?php

namespace DeliciousBrains\WPMDB\Pro\Transfers\Files;

use DeliciousBrains\WPMDB\Common\Filesystem\Filesystem;
use DeliciousBrains\WPMDB\Common\Migration\MigrationHelper;
use DeliciousBrains\WPMDB\Common\Transfers\Files\Util;
use DeliciousBrains\WPMDB\Data\Stage;
use WP_Error;

/**
 * Receive-side staged chunks: paths under {@see Util::get_fragment_staging_directory_name()},
 * merge into final media files, and teardown of staged fragment files.
 *
 * Complements {@see \DeliciousBrains\WPMDB\Common\Transfers\Files\Chunker} (send-side splitting).
 * Directory basename and uploads glob cleanup remain on {@see Util} (Common layer).
 */
class StagedChunker {

	/**
	 * @var Filesystem
	 */
	private $filesystem;

	/**
	 * @param Filesystem $filesystem Filesystem used for staging paths and merge I/O.
	 */
	public function __construct( Filesystem $filesystem ) {
		$this->filesystem = $filesystem;
	}

	/**
	 * Whether to write each chunk as a separate file under uploads and merge when complete.
	 *
	 * Filter `wpmdb_use_staged_chunker`. Default false.
	 *
	 * @return bool
	 */
	public function should_use_staged_chunker() {
		return (bool) apply_filters( 'wpmdb_use_staged_chunker', false );
	}

	/**
	 * Full path to root directory for chunk fragments under the WordPress uploads directory.
	 *
	 * @param array $state_data Migration state.
	 *
	 * @return string Full path with trailing slash
	 */
	public function staging_root_path( $state_data ) {
		$migration_id = isset( $state_data['migration_state_id'] ) ? $state_data['migration_state_id'] : MigrationHelper::get_current_migration_id();
		$dir_name     = Util::get_fragment_staging_directory_name( $migration_id );

		$uploads_base = trailingslashit(
			$this->filesystem->slash_one_direction( Util::get_wp_uploads_dir() )
		);

		return trailingslashit( $uploads_base . $dir_name );
	}

	/**
	 * Absolute directory holding staged chunk fragments for one logical destination file.
	 *
	 * @param array  $state_data           Migration state.
	 * @param string $staging_subdirectory Relative path under the migration staging root.
	 *                                     Includes a leading slash. (mirrors final file path; see Payload::get_payload_relative_destination_file()).
	 *
	 * @return string Path with no trailing slash.
	 */
	private function staged_content_directory( $state_data, $staging_subdirectory ) {
		$staging_root_path = untrailingslashit( $this->staging_root_path( $state_data ) );
		return untrailingslashit( $staging_root_path . $staging_subdirectory );
	}

	/**
	 * Full path for one chunk fragment file (staging root + staging subdirectory + chunk file).
	 *
	 * @param array  $state_data           Migration state.
	 * @param string $staging_subdirectory Relative path under the migration staging root
	 *                                     Includes a leading slash. (mirrors final file path; see Payload::get_payload_relative_destination_file()).
	 * @param int    $chunk_number         One-based chunk number.
	 *
	 * @return string
	 */
	public function chunk_file_path( $state_data, $staging_subdirectory, $chunk_number ) {
		$directory = trailingslashit( $this->staged_content_directory( $state_data, $staging_subdirectory ) );
		return $directory . 'chunk-' . sprintf( '%06d', (int) $chunk_number );
	}

	/**
	 * Full staging path for one chunk during receive from payload file meta.
	 *
	 * Staging subdirectory rules must match `Payload::get_payload_relative_destination_file()`.
	 *
	 * @param array $state_data Migration state.
	 * @param array $meta       Payload meta; expects `file.relative_path`, optional `file.chunk_number`.
	 *
	 * @return string
	 */
	public function chunk_path_from_receive_meta( $state_data, $meta ) {
		$staging_subdirectory = $this->staging_subdirectory_from_receive_meta( $state_data, $meta );
		$chunk_num            = isset( $meta['file']['chunk_number'] ) ? (int) $meta['file']['chunk_number'] : 1;

		return $this->chunk_file_path( $state_data, $staging_subdirectory, $chunk_num );
	}

	/**
	 * Relative path under the migration staging root for this file's chunk fragments.
	 *
	 * Mirrors the final file's relative path under uploads (same rules as Payload::get_payload_relative_destination_file()).
	 *
	 * @param array $state_data Migration state.
	 * @param array $meta       Payload meta; expects `file.relative_path`.
	 *
	 * @return string - This should have a leading slash, but that's dependent on the source sending it that way.
	 */
	private function staging_subdirectory_from_receive_meta( $state_data, $meta ) {
		$file = $this->filesystem->slash_one_direction( $meta['file']['relative_path'] );

		if ( Stage::MEDIA_FILES === $state_data['stage'] ) {
			$file = apply_filters( 'wpmdb_mf_destination_file', $file, $state_data );
		}

		return $file;
	}

	/**
	 * Merge staged chunk fragments into the final destination and clean staging.
	 *
	 * @param array  $state_data Migration state.
	 * @param array  $meta       Payload meta for the completed file.
	 * @param string $final_path Absolute final file path (parent directory must exist).
	 *
	 * @return true|WP_Error
	 */
	public function merge_staged_chunks_from_payload_meta( $state_data, $meta, $final_path ) {
		$total_chunks         = isset( $meta['file']['chunk_number'] ) ? (int) $meta['file']['chunk_number'] : 0;
		$staging_subdirectory = $this->staging_subdirectory_from_receive_meta( $state_data, $meta );

		return $this->merge_staged_fragments_to_final(
			$state_data,
			$staging_subdirectory,
			$final_path,
			$total_chunks
		);
	}

	/**
	 * After all chunks are present, concatenate fragment files into the final destination.
	 * Staged fragments and empty staging dirs are removed whether merge succeeds or fails.
	 *
	 * @param array  $state_data           Migration state.
	 * @param string $staging_subdirectory Relative path under the migration staging root
	 *                                     Includes a leading slash. (mirrors final file path; see Payload::get_payload_relative_destination_file()).
	 * @param string $final_path           Absolute final file path.
	 * @param int    $total_chunks         Number of chunk fragment files.
	 *
	 * @return true|WP_Error
	 */
	public function merge_staged_fragments_to_final( $state_data, $staging_subdirectory, $final_path, $total_chunks ) {
		if ( $total_chunks < 1 ) {
			return new WP_Error(
				'wpmdb-file_transfer-fragment_merge_invalid',
				__( 'Invalid chunk count for fragment merge.', 'wp-migrate-db' )
			);
		}

		$copied = $this->copy_staged_fragments_into_final_file( $state_data, $staging_subdirectory, $final_path, $total_chunks );

		$this->unlink_staged_fragment_files( $state_data, $staging_subdirectory, $total_chunks );
		$this->maybe_remove_empty_staging_dirs( $state_data, $staging_subdirectory );

		if ( is_wp_error( $copied ) ) {
			return $copied;
		}

		return true;
	}

	/**
	 * Stream staged chunk fragments in order into a new final file.
	 *
	 * Removes any existing final file first. On failure, deletes a partial final file before returning.
	 *
	 * @param array  $state_data           Migration state.
	 * @param string $staging_subdirectory Relative path under the migration staging root.
	 *                                     Includes a leading slash. (mirrors final file path; see Payload::get_payload_relative_destination_file()).
	 * @param string $final_path           Absolute final file path.
	 * @param int    $total_chunks         Number of chunk fragment files.
	 *
	 * @return true|WP_Error
	 */
	private function copy_staged_fragments_into_final_file( $state_data, $staging_subdirectory, $final_path, $total_chunks ) {
		if ( $this->filesystem->file_exists( $final_path ) ) {
			$this->filesystem->unlink( $final_path );
		}

		$final_handle = fopen( $final_path, 'wb' );

		if ( false === $final_handle ) {
			return new WP_Error(
				'wpmdb-file_transfer-fragment_merge_open_final',
				sprintf( __( 'Unable to open final file for merge: %s', 'wp-migrate-db' ), $final_path )
			);
		}

		for ( $i = 1; $i <= $total_chunks; $i++ ) {
			$fragment_path = $this->chunk_file_path( $state_data, $staging_subdirectory, $i );

			if ( ! is_file( $fragment_path ) ) {
				fclose( $final_handle );
				$this->filesystem->unlink( $final_path );

				return new WP_Error(
					'wpmdb-file_transfer-fragment_missing',
					sprintf( __( 'Missing chunk fragment %d at %s', 'wp-migrate-db' ), $i, $fragment_path )
				);
			}

			$fragment_handle = fopen( $fragment_path, 'rb' );

			if ( false === $fragment_handle ) {
				fclose( $final_handle );
				$this->filesystem->unlink( $final_path );

				return new WP_Error(
					'wpmdb-file_transfer-fragment_open',
					sprintf( __( 'Unable to open chunk fragment: %s', 'wp-migrate-db' ), $fragment_path )
				);
			}

			if ( false === stream_copy_to_stream( $fragment_handle, $final_handle ) ) {
				fclose( $fragment_handle );
				fclose( $final_handle );
				$this->filesystem->unlink( $final_path );

				return new WP_Error(
					'wpmdb-file_transfer-fragment_copy',
					sprintf( __( 'Could not merge chunk fragment into final file: %s', 'wp-migrate-db' ), $fragment_path )
				);
			}

			fclose( $fragment_handle );
		}

		fclose( $final_handle );

		return true;
	}

	/**
	 * Delete all staged chunk fragment files for one logical destination file.
	 *
	 * @param array  $state_data           Migration state.
	 * @param string $staging_subdirectory Relative path under the migration staging root.
	 *                                     Includes a leading slash. (mirrors final file path; see Payload::get_payload_relative_destination_file()).
	 * @param int    $total_chunks         Number of chunk fragment files.
	 *
	 * @return void
	 */
	private function unlink_staged_fragment_files( $state_data, $staging_subdirectory, $total_chunks ) {
		for ( $i = 1; $i <= $total_chunks; $i++ ) {
			$fragment_path = $this->chunk_file_path( $state_data, $staging_subdirectory, $i );

			if ( is_file( $fragment_path ) ) {
				$this->filesystem->unlink( $fragment_path );
			}
		}
	}

	/**
	 * Remove the per-file staging directory and migration staging root when both are empty.
	 *
	 * @param array  $state_data           Migration state.
	 * @param string $staging_subdirectory Relative path under the migration staging root.
	 *                                     Includes a leading slash. (mirrors final file path; see Payload::get_payload_relative_destination_file()).
	 *
	 * @return void
	 */
	private function maybe_remove_empty_staging_dirs( $state_data, $staging_subdirectory ) {
		$content_dir  = $this->staged_content_directory( $state_data, $staging_subdirectory );
		$staging_root = $this->staging_root_path( $state_data );

		if ( $this->filesystem->is_directory_empty( $content_dir ) ) {
			$this->filesystem->rmdir( $content_dir );
		}

		if ( $this->filesystem->is_directory_empty( $staging_root ) ) {
			$this->filesystem->rmdir( $staging_root );
		}
	}
}
