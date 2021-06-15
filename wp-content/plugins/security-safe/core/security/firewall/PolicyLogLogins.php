<?php

	namespace SovereignStack\SecuritySafe;

	// Prevent Direct Access
	( defined( 'ABSPATH' ) ) || die;

	use WP_Error;

	/**
	 * Class PolicyLogLogins
	 * @package SecuritySafe
	 * @since  2.0.0
	 */
	class PolicyLogLogins extends Firewall {

		/**
		 * PolicyLogLogins constructor.
		 */
		function __construct() {

			// Run parent class constructor first
			parent::__construct();

			add_action( 'authenticate', [ $this, 'blacklist_check' ], 88888, 3 );
			add_action( 'wp_login_failed', [ $this, 'failed' ], 99999, 1 );
			add_action( 'wp_login', [ $this, 'success' ], 10, 2 );

		}

		/**
		 * Logs a Failed Login Attempt
		 *
		 * @param string $username
		 *
		 * @uses  $this->record
		 *
		 * @since  2.0.0
		 */
		public function failed( $username ) {

			if ( ! Yoda::is_login_error() ) {

				$this->record( $username, 'failed' );

			}

		}

		/**
		 * Logs the login attempt.
		 *
		 * @param string $username
		 * @param string $status
		 *
		 * @since  2.0.0
		 */
		private function record( $username, $status ) {

			global $SecuritySafe;

			$args             = []; // reset
			$args['type']     = 'logins';
			$args['username'] = ( $username ) ? filter_var( $username, FILTER_SANITIZE_STRING ) : '';
			$args['status']   = ( $status == 'success' ) ? 'success' : 'failed';
			$args['score']    = 0;

			if ( ! $SecuritySafe->is_whitelisted() ) {

				if ( defined( 'XMLRPC_REQUEST' ) ) {

					$args['threats'] = 1;
					$args['score']   = 0;
					$args['details'] = ( $args['status'] == 'failed' ) ? __( 'XML-RPC Login Attempt.', SECSAFE_SLUG ) : __( 'XML-RPC Login Successful.', SECSAFE_SLUG );

				}

				// Check Status
				$args['score'] += ( $args['status'] == 'failed' ) ? 1 : 0;

				// Check usernames
				$username_threat = Threats::is_username( $username );

				if ( $args['status'] == 'success' && $username_threat ) {

					$args['details'] = __( 'This username is too common. Consider changing it.', SECSAFE_SLUG );

				}

				$args['score'] += ( $username_threat ) ? 1 : 0;
				$args['threats'] = ( $args['score'] > 0 ) ? 1 : 0;

			}

			//Janitor::log( $args['status'] . ' - record() =======' );

			// Log Login Attempt
			Janitor::add_entry( $args );

		}

		/**
		 * Logs a successful login
		 *
		 * @param string $username
		 * @param object $user
		 *
		 * @uses  $this->record
		 *
		 * @since  2.0.0
		 */
		public function success( $username, $user ) {

			$this->record( $username, 'success' );

		}

		/**
		 * Checks if IP has been blacklisted and if so, prevents the login attempt.
		 *
		 * @param object $user
		 * @param string $username
		 * @param string $password
		 *
		 * @uses  $this->block
		 *
		 * @return object
		 *
		 * @since 2.0.0
		 */
		public function blacklist_check( $user, $username, $password ) {

			global $SecuritySafe;

			//Janitor::log( 'running login blacklist_check()' );

			// Reset error status in case multiple login attempts are made during a single session
			$SecuritySafe->login_error = false; // Reset login errors

			// Update blacklist status in case multiple login attempts are made during a single session
			$firewall                  = new Firewall();
			$SecuritySafe->blacklisted = ( $firewall->is_blacklisted() ) ? true : false;

			if ( ! $SecuritySafe->is_blacklisted() ) {

				// Run Rate Limiting to see if use gets blacklisted
				$this->rate_limit();

			}

			// Final check of blacklisting to block login
			if ( $SecuritySafe->is_blacklisted() ) {

				//Janitor::log( 'login blacklisted!!!!' );

				$args             = [];
				$args['type']     = 'logins';
				$args['details']  = __( 'IP is blacklisted.', SECSAFE_SLUG ) . '[' . __LINE__ . ']';
				$args['username'] = ( $username ) ? filter_var( $username, FILTER_SANITIZE_STRING ) : '';

				// Block the attempt
				$this->block( $args, false );

				// Prevent default generic message
				$SecuritySafe->login_error = true;

				if ( isset( $SecuritySafe->date_expires ) && $SecuritySafe->date_expires ) {

					$secs = strtotime( $SecuritySafe->date_expires ) - time();
					$days = $secs / 86400;
					$hrs  = $secs / 3600;
					$mins = $secs / 60;

					if ( $days >= 1 ) {

						$wait = ( $days > 1 ) ? sprintf( __( '%d days', SECSAFE_SLUG ), $days ) : __( '1 day', SECSAFE_SLUG );

					} elseif ( $hrs >= 1 ) {

						$wait = ( $hrs > 1 ) ? sprintf( __( '%d hours', SECSAFE_SLUG ), $hrs ) : __( '1 hour', SECSAFE_SLUG );

					} else {

						$wait = ( $mins > 1 ) ? sprintf( __( '%d minutes', SECSAFE_SLUG ), $mins ) : __( '1 minute', SECSAFE_SLUG );

					}

					$user = new WP_Error();
					$user->add( 'wp_security_safe_lockout', sprintf( __( '<b>ERROR:</b> Too many failed login attempts. Please try again in %s.', SECSAFE_SLUG ), $wait ) );

				} else {

					$user = new WP_Error();
					$user->add( 'wp_security_safe_lockout', __( '<b>ERROR:</b> Too many failed login attempts. Please try again later.', SECSAFE_SLUG ) );

				}


			}

			return $user;

		}

	}
