<?php

namespace DeliciousBrains\WPMDB\Common\Transfers\Files\Transport;

use DeliciousBrains\WPMDB\Common\Util\Util;
use WP_Error;
use WpOrg\Requests\Response;

/**
 * A data object for the value returned from a file transport push operation.
 */
class FileTransportResponse {
	/**
	 * The success value returned in the body.
	 *
	 * @var bool
	 */
	public $success;

	/**
	 * The body returned. This contains the `success` and `data` values.
	 *
	 * @var string
	 */
	public $body;

	/**
	 * HTTP response code.
	 *
	 * @var int
	 */
	public $code;

	/**
	 * The `data` value from the decoded body.
	 *
	 * This can be:
	 *  - an error string
	 *  - an array version of a WP_Error (see get_wp_error())
	 *  - an array of:
	 *    [
	 *       'transported_file_results' => [ <TransportedFileResult[]> ]
	 *    ]
	 *
	 * @var mixed
	 */
	public $data;

	/**
	 * Transported file statuses/results.
	 *
	 * @var TransportedFileResult[]
	 */
	public $transported_file_results = [];

	/**
	 * JSON-decoded body value.
	 *
	 * @var array
	 */
	public $decoded_body;

	/**
	 * The original response object.
	 *
	 * @var Response
	 */
	public $response;

	/**
	 * @param Response $response
	 */
	public function __construct( $response ) {
		$this->response = $response;
		$this->code     = $response->status_code;
		$this->body     = $response->body;

		$this->set_decode_body();
		$this->set_success();
		$this->set_data();
		$this->set_transported_file_results();
	}

	/**
	 * Decode the JSON body.
	 */
	private function set_decode_body() {
		$this->decoded_body = json_decode( $this->body, true );
	}

	/**
	 * Set the success property based on the decoded body.
	 */
	private function set_success() {
		$this->success = ! empty( $this->decoded_body['success'] ) ? (bool) $this->decoded_body['success'] : false;
	}

	/**
	 * Set the data property based on the decoded body.
	 */
	private function set_data() {
		$this->data = ! empty( $this->decoded_body['data'] ) ? $this->decoded_body['data'] : null;
	}

	/**
	 * Convert all the transported_file_results into objects
	 *
	 * @param array[] $results_as_arrays
	 * @return TransportedFileResult[]
	 */
	private function results_arrays_to_objects( $results_as_arrays ) {
		if ( ! is_array( $results_as_arrays ) ) {
			return [];
		}

		return array_map(
			function ( $result ) {
				return TransportedFileResult::fromArray( $result );
			},
			$results_as_arrays
		);
	}

	/**
	 * Sets the transported file results array based on the data.
	 */
	private function set_transported_file_results() {
		if ( !is_array( $this->data ) || ! isset( $this->data['transported_file_results'] ) ) {
			return;
		}

		// Convert items to the correct objects - this validates the data too.
		$transported_file_results_objects = $this->results_arrays_to_objects( $this->data['transported_file_results'] );

		// Filter out those that failed validation and returned null.
		$transported_file_results_objects = array_filter( $transported_file_results_objects );

		// Ensure sequential array keys as we assign
		$this->transported_file_results = array_values( $transported_file_results_objects );
	}

	/**
	 * Returns true if the decoded response has a legacy wpmdb_error property.
	 *
	 * @return bool
	 */
	public function has_error() {
		return ! empty( $this->decoded_body['wpmdb_error'] );
	}

	/**
	 * Returns the msg property of the decoded legacy JSON error response.
	 *
	 * @return mixed|null
	 */
	public function error_message() {
		if ( $this->has_error() ) {
			if ( ! empty( $this->decoded_body['msg'] ) ) {
				return $this->decoded_body['msg'];
			}

			return sprintf( 'File transport failed with code %s', $this->code );
		}

		return null;
	}

	/**
	 * If there is a WP_Error in the response data, return the WP_Error.
	 *
	 * @return false|WP_Error
	 */
	public function get_wp_error() {
		if ( Util::array_is_wp_error( $this->data ) ) {
			$data = empty( $this->data['data'] ) ? null : $this->data['data'];

			return new WP_Error( $this->data['code'], $this->data['message'], $data );
		}

		return false;
	}

	/**
	 * Returns the response as a formatted array
	 *
	 * @return array
	 **/
	public function get_error_array() {
		return [
			'body'     => $this->body,
			'response' => [
				'code' => $this->code,
			],
		];
	}
}
