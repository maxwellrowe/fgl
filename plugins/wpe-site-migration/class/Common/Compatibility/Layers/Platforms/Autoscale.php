<?php

namespace DeliciousBrains\WPMDB\Common\Compatibility\Layers\Platforms;

class Autoscale extends AbstractPlatform {
	/**
	 * @var string
	 */
	protected static $key = 'autoscale';

	/**
	 * Maximum payload size in bytes for a single file transfer request on Autoscale.
	 */
	const TRANSFER_MAX_PAYLOAD_BYTES = 10 * MB_IN_BYTES;

	/**
	 * Maximum queue jobs considered per push transfer batch on Autoscale.
	 */
	const TRANSFER_FILE_BATCH_SIZE = 50;

	public function __construct() {
		parent::__construct();
		add_filter( 'wpmdb_is_muplugin_externally_managed', [ $this, 'filter_is_muplugin_externally_managed' ] );
		add_filter( 'wpmdb_version_mismatch_connecting_newer', [ $this, 'filter_version_mismatch_connecting_newer' ], 10, 2 );
		add_filter( 'wpmdb_use_staged_chunker', [ $this, 'filter_use_staged_chunker' ] );
		add_filter( 'wpmdb_file_batch_size', [ $this, 'filter_file_batch_size' ], 10, 2 );
		add_filter( 'wpmdb_transfers_max_payload_bytes', [ $this, 'filter_transfers_max_payload_bytes' ], 10, 2 );
	}

	/**
	 * Are we running on this platform?
	 *
	 * @return bool
	 */
	public static function is_platform() {
		$is_platform = defined( 'WPE_PLATFORM_NAME' ) && 'autoscale' === strtolower( (string) WPE_PLATFORM_NAME );

		return apply_filters( 'wpmdb_is_platform_autoscale', $is_platform );
	}

	/**
	 * Filters the current platform key.
	 *
	 * @param string $platform
	 *
	 * @return string
	 */
	public function filter_platform( $platform ) {
		if ( static::is_platform() ) {
			return static::get_key();
		}

		return $platform;
	}

	/**
	 * Filter whether the mu-plugin is externally managed.
	 *
	 * Autoscale pre-installs the compatibility mu-plugin on a read-only filesystem.
	 *
	 * @param bool $is_managed
	 *
	 * @handles wpmdb_is_muplugin_externally_managed
	 * @return bool
	 */
	public function filter_is_muplugin_externally_managed( $is_managed ) {
		if ( static::is_platform() ) {
			return true;
		}

		return $is_managed;
	}

	/**
	 * On Autoscale, replace the default (#196) mismatch HTML when the connecting site reports a newer plugin (deployment pipeline wording).
	 *
	 * @param string $message
	 * @param array  $version_mismatch_meta
	 *
	 * @handles wpmdb_version_mismatch_connecting_newer
	 * @return string
	 */
	public function filter_version_mismatch_connecting_newer( $message, $version_mismatch_meta ) {
		if ( ! static::is_platform() || ! is_string( $message ) ) {
			return $message;
		}

		return sprintf(
			/* translators: 1: Plugin title, 2: Remote plugin version, 3: Remote site URL, 4: Connecting site plugin version */
			__(
				'<b>Version Mismatch</b> &mdash; The source and destination must have the same version of the %1$s plugin installed. You have version %2$s installed at %3$s but are using %4$s here. Please run the deployment pipeline for %3$s to update the remote plugin to the latest version.',
				'wp-migrate-db'
			),
			$version_mismatch_meta['plugin_title'],
			$version_mismatch_meta['remote_version'],
			$version_mismatch_meta['remote_url'],
			$version_mismatch_meta['connecting_version']
		);
	}

	/**
	 * Use {@see \DeliciousBrains\WPMDB\Pro\Transfers\Files\StagedChunker} for chunked file receive on Autoscale.
	 *
	 * Per-chunk staging + merge is gcsfuse-friendly.
	 *
	 * @param bool $enabled
	 *
	 * @return bool
	 */
	public function filter_use_staged_chunker( $enabled ) {
		return static::is_platform() ? true : $enabled;
	}

	/**
	 * Limits push transfer batch size on Autoscale to reduce request timeouts.
	 *
	 * @param int   $count      Default 1000.
	 * @param array $state_data Migration state data.
	 *
	 * @handles wpmdb_file_batch_size
	 * @return int
	 */
	public function filter_file_batch_size( $count, $state_data ) {
		if ( ! $this->is_autoscale_push( $state_data ) ) {
			return $count;
		}

		return self::TRANSFER_FILE_BATCH_SIZE;
	}

	/**
	 * Caps push transfer payload size on Autoscale to reduce round-trip timeouts.
	 *
	 * @param int   $max_bytes  Default 0 (no cap).
	 * @param array $state_data Migration state data.
	 *
	 * @handles wpmdb_transfers_max_payload_bytes
	 * @return int
	 */
	public function filter_transfers_max_payload_bytes( $max_bytes, $state_data ) {
		if ( ! $this->is_autoscale_push( $state_data ) ) {
			return $max_bytes;
		}

		return self::TRANSFER_MAX_PAYLOAD_BYTES;
	}

	/**
	 * Whether the current migration is a push to Autoscale.
	 *
	 * @param array $state_data
	 *
	 * @return bool
	 */
	private function is_autoscale_push( $state_data ) {
		if ( ! is_array( $state_data ) || ! isset( $state_data['intent'] ) || 'push' !== $state_data['intent'] ) {
			return false;
		}

		if ( empty( $state_data['site_details']['remote']['platform'] ) ) {
			return false;
		}

		return 'autoscale' === $state_data['site_details']['remote']['platform'];
	}
}
