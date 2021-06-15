<?php

	namespace SovereignStack\SecuritySafe;

	// Prevent Direct Access
	( defined( 'ABSPATH' ) ) || die;

	require_once( SECSAFE_DIR_ADMIN_TABLES . '/Table.php' );

	/**
	 * Class Table404s
	 * @package SecuritySafe
	 */
	final class TableActivity extends Table {

		/**
		 * Get a list of columns. The format is:
		 * 'internal-name' => 'Title'
		 *
		 * @return array
		 * @since 3.1.0
		 * @abstract
		 *
		 * @package WordPress
		 */
		function get_columns() {

			return [
				'date'       => __( 'Date', SECSAFE_SLUG ),
				'username'   => __( 'Username', SECSAFE_SLUG ),
				'ip'         => __( 'IP Address', SECSAFE_SLUG ),
				'user_agent' => __( 'User Agent', SECSAFE_SLUG ),
				'details'    => __( 'Details', SECSAFE_SLUG ),
				'status'     => __( 'Status', SECSAFE_SLUG ),
			];

		}

		/**
		 * Set the type of data to display
		 *
		 * @since  2.0.0
		 */
		protected function set_type() {

			$this->type = 'activity';

		}

		/**
		 * Get the array of searchable columns in the database
		 * @return  array An unassociated array.
		 * @since  2.0.0
		 */
		protected function get_searchable_columns() {

			return [
				'username',
				'ip',
				'details',
			];

		}

	}
