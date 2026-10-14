<?php

namespace DeliciousBrains\WPMDB\Common\Transfers\Files\Transport;

/**
 * An enum class for the status of a file that was transferred.
 *
 * @phpstan-type TransportedFileStatusName TransportedFileStatus::FILE_*
 */
class TransportedFileStatus {
	const FILE_OK = 'FILE_OK';
	const FILE_SKIPPED = 'FILE_SKIPPED';
	const FILE_SIZE_OFF_BY_ONE = 'FILE_SIZE_OFF_BY_ONE';
	const FILE_SIZE_OFF_BY_MANY = 'FILE_SIZE_OFF_BY_MANY';
	const FILE_HASH_MISMATCH = 'FILE_HASH_MISMATCH';
	const FILE_OTHER_ERROR = 'FILE_OTHER_ERROR';

	const VALID_STATUSES = [
		self::FILE_OK,
		self::FILE_SKIPPED,
		self::FILE_SIZE_OFF_BY_ONE,
		self::FILE_SIZE_OFF_BY_MANY,
		self::FILE_HASH_MISMATCH,
		self::FILE_OTHER_ERROR,
	];

	/**
	 * True if the provided parameter is a valid status string.
	 *
	 * @param string $statusAsString
	 *
	 * @return bool
	 */
	public static function is_valid( $statusAsString ) {
		return is_string( $statusAsString ) && in_array( $statusAsString, self::VALID_STATUSES );
	}
}
