<?php

namespace DeliciousBrains\WPMDB\Common\Transfers\Files\Transport;

/**
 * An object holding the result of a transported file.
 *
 * @phpstan-import-type TransportedFileStatusName from TransportedFileStatus
 */
class TransportedFileResult {
	/**
	 * The full file path
	 *
	 * @var string
	 */
	public $filepath;

	/**
	 * The status of the transported file.
	 *
	 * @var TransportedFileStatusName|null
	 */
	public $status = TransportedFileStatus::FILE_OK;

	/**
	 * The difference in size between the transported file and the saved file.
	 *
	 * @var int
	 */
	public $filesize_difference_in_bytes = 0;

	/**
	 * Error message - if the status is not OK this may be populated
	 *
	 * @var string
	 */
	public $error_message;

	/**
	 * Error code - if the status is not OK this may be populated and used
	 * by the caller to construct a WP_Error
	 *
	 * @var string
	 */
	public $error_code;


	/**
	 * Constructor only takes filepath and sets defaults.
	 *
	 * @param string $filepath
	 */
	public function __construct( $filepath ) {
		$this->filepath = $filepath;
	}

	/**
	 * Creates a TransportedFileResult from the provided array.
	 *
	 * Returns null if:
	 *  - Something other than an array is passed
	 *  - The array does not have a filepath - this is the only required part
	 *
	 * All other properties are checked for presence and coerced to the correct
	 * types.
	 *
	 * @param array $data
	 *
	 * @return TransportedFileResult|null
	 */
	public static function fromArray( $data ) {
		if ( ! is_array( $data ) || ! isset( $data['filepath'] ) ) {
			return null;
		}

		$result = new TransportedFileResult( $data['filepath'] );

		if ( isset( $data['status'] ) ) {
			$status_as_string = (string)$data['status'];
			if ( TransportedFileStatus::is_valid( $status_as_string ) ) {
				$result->status = $status_as_string;
			} else {
				error_log( "Invalid transported file status {$status_as_string} for file {$result->filepath}" );
				$result->status = null;
			}
		}

		if ( isset( $data['filesize_difference_in_bytes'] ) ) {
			$result->filesize_difference_in_bytes = (int)$data['filesize_difference_in_bytes'];
		}

		if ( isset( $data['error_message'] ) ) {
			$result->error_message = (string)$data['error_message'];
		}

		if ( isset( $data['error_code'] ) ) {
			$result->error_code = (string)$data['error_code'];
		}

		return $result;
	}

	/**
	 * Construct a TransportedFileResult from a WP_Error object.
	 *
	 * Uses FILE_OTHER_ERROR status by default but this can be overridden.
	 *
	 * @param string    $dest          - The full destination file path
	 * @param \WP_Error $wp_error      - The WP Error to construct from
	 * @param string    $result_status - Status to use, defaults to FILE_OTHER_ERROR
	 *
	 * @return TransportedFileResult
	 */
	public static function from_wp_error( $dest, $wp_error, $result_status = TransportedFileStatus::FILE_OTHER_ERROR ) {
		$result = new TransportedFileResult( $dest );
		$result->status = $result_status;
		$result->error_code = $wp_error->get_error_code();
		$result->error_message = $wp_error->get_error_message();
		return $result;
	}

	/**
	 * True if the transfer did not have any errors or issues.
	 *
	 * @return bool
	 */
	public function is_not_error() {
		return in_array( $this->status,
			[
				TransportedFileStatus::FILE_OK,
				TransportedFileStatus::FILE_SKIPPED,
			]
		);
	}

	/**
	 * True if the transfer had errors or issues.
	 *
	 * @return bool
	 */
	public function is_error() {
		return ! $this->is_not_error();
	}
}
