<?php

	namespace SovereignStack\SecuritySafe;

	// Prevent Direct Access
	( defined( 'ABSPATH' ) ) || die;

	require_once( SECSAFE_DIR_ADMIN_TABLES . '/Table.php' );

	/**
	 * Class TableFilePerms
	 * @package SecuritySafe
	 */
	final class TableFilePerms extends Table {

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

			$columns = [
				'location' => __( 'Relative Location', SECSAFE_SLUG ),
				'type'     => __( 'Type', SECSAFE_SLUG ),
				'current'  => __( 'Current', SECSAFE_SLUG ),
				'status'   => __( 'Status', SECSAFE_SLUG ),
				'modify'   => __( 'Modify', SECSAFE_SLUG ),
			];

			return $columns;

		}

		function get_sortable_columns() {

			return [];

		}

		/**
		 * Set the type of data to display
		 *
		 * @since  2.0.0
		 */
		protected function set_type() {

			$this->type = '404s';

		}

		/**
		 * Get the array of searchable columns in the database
		 * @return  array An unassociated array.
		 * @since  2.0.0
		 */
		protected function get_searchable_columns() {

			return [];

		}

	}
