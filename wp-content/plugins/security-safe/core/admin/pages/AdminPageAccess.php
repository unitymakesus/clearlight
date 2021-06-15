<?php

	namespace SovereignStack\SecuritySafe;

	// Prevent Direct Access
	( defined( 'ABSPATH' ) ) || die;

	/**
	 * Class AdminPageAccess
	 * @package SecuritySafe
	 * @since  0.2.0
	 */
	class AdminPageAccess extends AdminPage {

		/**
		 * This populates all the metaboxes for this specific page.
		 * @since  0.2.0
		 */
		function tab_settings() {

			$disabled = true;

			$upgrade = ' <a href="' . SECSAFE_URL_MORE_INFO_PRO . '">' . __( 'Upgrade to control this setting.', SECSAFE_SLUG ) . '</a>';

			if ( security_safe()->can_use_premium_code() ) {

				$disabled = false;
				$upgrade  = '';

			}

			$default_settings = Plugin::get_page_settings_min( 'access' );

			$html = '';

			// Shutoff Switch - All Access Policies
			$classes = ( $this->settings['on'] ) ? '' : 'notice-warning';
			$rows    = $this->form_select(
				$this->settings,
				__( 'User Access Policies', SECSAFE_SLUG ),
				'on',
				[ '0' => __( 'Disabled', SECSAFE_SLUG ), '1' => __( 'Enabled', SECSAFE_SLUG ) ],
				__( 'If you experience a problem, you may want to temporarily turn off all user access policies at once to troubleshoot the issue.', SECSAFE_SLUG ),
				$classes
			);
			$html    .= $this->form_table( $rows );

			// Login Security
			$html .= $this->form_section( __( 'Login Form', SECSAFE_SLUG ), '' );

			$rows = $this->form_checkbox(
				$this->settings,
				__( 'Login Errors', SECSAFE_SLUG ),
				'login_errors',
				__( 'Make login errors generic.', SECSAFE_SLUG ),
				__( 'When someone attempts to log in, by default, the error messages will tell the user that the password is incorrect or that the username is not valid. This exposes too much information to the potential intruder.', SECSAFE_SLUG )
			);

			$rows .= $this->form_checkbox(
				$this->settings,
				__( 'Password Reset', SECSAFE_SLUG ),
				'login_password_reset',
				__( 'Disable Password Reset', SECSAFE_SLUG ),
				__( 'If you are the only user of the site, you may want to disable this feature as you have access to the database and hosting control panel.', SECSAFE_SLUG )
			);

			$rows .= $this->form_checkbox(
				$this->settings,
				__( 'Remember Me', SECSAFE_SLUG ),
				'login_remember_me',
				__( 'Disable Remember Me Checkbox', SECSAFE_SLUG ),
				__( 'If the device that uses the remember me feature gets stolen, then the person in possession can now log in.', SECSAFE_SLUG )
			);
			$html .= $this->form_table( $rows );

			// Brute Force
			$html .= $this->form_section(
				__( 'Brute Force Protection', SECSAFE_SLUG ),
				__( 'Brute Force login attempts are repetitive attempts to gain access to your site using the login form.', SECSAFE_SLUG )
			);

			// Shutoff Switch - All Firewall Policies
			$classes = ( $this->settings['on'] ) ? '' : 'notice-warning';

			$rows = $this->form_select(
				$this->settings,
				__( 'Limit Login Attempts', SECSAFE_SLUG ),
				'autoblock',
				[ '0' => __( 'Disabled', SECSAFE_SLUG ), '1' => __( 'Enabled', SECSAFE_SLUG ) ],
				'',
				'',
				$default_settings['autoblock'],
				false );

			$rows .= $this->row_custom( 'lockout-condition', '<th scope="row"><label>Lockout Condition:</label></th>' );

			$content = '<td colspan="2"><p>Block an IP address after ';
			$content .= $this->form_select(
				$this->settings,
				__( 'Detection Threshold', SECSAFE_SLUG ),
				'autoblock_threat_score',
				[ 3 => '3', 5 => '5', 10 => '10', 15 => '15', 20 => '20', 25 => '25' ],
				'',
				'',
				$default_settings['autoblock_threat_score'],
				false, true );

			$content .= $this->form_select(
				$this->settings,
				__( 'Lockout Method', SECSAFE_SLUG ),
				'autoblock_method',
				[
					1 => __( 'Failed Logins', SECSAFE_SLUG ),
					2 => __( 'Threats', SECSAFE_SLUG ),
					3 => __( 'Threat Score', SECSAFE_SLUG ),
				],
				'',
				'',
				$default_settings['autoblock_method'],
				$disabled, true );

			$content .= ' within ';
			$content .= $this->form_select(
				$this->settings,
				__( 'Detection Timespan', SECSAFE_SLUG ),
				'autoblock_timespan',
				[
					1  => __( '1 minute', SECSAFE_SLUG ),
					2  => sprintf( __( '%d minutes', SECSAFE_SLUG ), 2 ),
					3  => sprintf( __( '%d minutes', SECSAFE_SLUG ), 3 ),
					4  => sprintf( __( '%d minutes', SECSAFE_SLUG ), 4 ),
					5  => sprintf( __( '%d minutes', SECSAFE_SLUG ), 5 ),
					10 => sprintf( __( '%d minutes', SECSAFE_SLUG ), 10 ),
				],
				'',
				'',
				$default_settings['autoblock_timespan'],
				false,
				true );

			$content .= '.</p><br /><p class="description">';
			$content .= ( security_safe()->can_use_premium_code() ) ? '' : '<a href="' . SECSAFE_URL_MORE_INFO_PRO . '">' . __( 'Upgrade:', SECSAFE_SLUG ) . '</a> ';
			$content .= __( 'Block IP addresses sooner using "threats" or "threats score" setting above.', SECSAFE_SLUG ) . '</p></td>';

			$rows .= $this->row_custom( 'lockout-condition', $content );

			$rows .= $this->form_select(
				$this->settings,
				__( 'First Lockout', SECSAFE_SLUG ),
				'autoblock_ban_1',
				[
					5  => sprintf( __( '%d minutes', SECSAFE_SLUG ), 5 ),
					10 => sprintf( __( '%d minutes', SECSAFE_SLUG ), 10 ),
					15 => sprintf( __( '%d minutes', SECSAFE_SLUG ), 15 ),
					30 => sprintf( __( '%d minutes', SECSAFE_SLUG ), 30 ),
					45 => sprintf( __( '%d minutes', SECSAFE_SLUG ), 45 ),
				],
				sprintf( __( '%d minutes is the default value.', SECSAFE_SLUG ), $default_settings['autoblock_ban_1'] ),
				'',
				$default_settings['autoblock_ban_1'],
				false );

			$rows .= $this->form_select(
				$this->settings,
				__( 'Second Lockout', SECSAFE_SLUG ),
				'autoblock_ban_2',
				[
					1  => __( '1 hour', SECSAFE_SLUG ),
					2  => sprintf( __( '%d hours', SECSAFE_SLUG ), 2 ),
					3  => sprintf( __( '%d hours', SECSAFE_SLUG ), 3 ),
					4  => sprintf( __( '%d hours', SECSAFE_SLUG ), 4 ),
					6  => sprintf( __( '%d hours', SECSAFE_SLUG ), 6 ),
					12 => sprintf( __( '%d hours', SECSAFE_SLUG ), 12 ),
				],
				__( '1 hour is the default value. 4 hours is recommended.', SECSAFE_SLUG ),
				'',
				$default_settings['autoblock_ban_2'],
				false );

			$rows .= $this->form_select(
				$this->settings,
				__( 'Third Lockout', SECSAFE_SLUG ),
				'autoblock_ban_3',
				[
					1   => __( '1 day', SECSAFE_SLUG ),
					2   => sprintf( __( '%d days', SECSAFE_SLUG ), 2 ),
					3   => sprintf( __( '%d days', SECSAFE_SLUG ), 3 ),
					7   => __( '1 week', SECSAFE_SLUG ),
					14  => sprintf( __( '%d weeks', SECSAFE_SLUG ), 2 ),
					30  => __( '1 month', SECSAFE_SLUG ),
					90  => __( '3 months', SECSAFE_SLUG ),
					180 => __( '6 months', SECSAFE_SLUG ),
				],
				__( '1 day is the default value. 3 days or greater is recommended.', SECSAFE_SLUG ) . $upgrade,
				'',
				$default_settings['autoblock_ban_3'],
				$disabled );

			$rows .= $this->form_checkbox(
				$this->settings,
				__( 'XML-RPC', SECSAFE_SLUG ),
				'xml_rpc',
				__( 'Disable XML-RPC', SECSAFE_SLUG ),
				__( 'The xmlrpc.php file allows remote execution of scripts. This can be useful in some cases, but most of the time it is not needed. Attackers often use XML-RPC to brute force login to your website.', SECSAFE_SLUG )
			);

			$html .= $this->form_table( $rows );

			// Save Button
			$html .= $this->button( __( 'Save Settings', SECSAFE_SLUG ) );

			return $html;

		}

		/**
		 * This tab displays the users.
		 * @since  2.1.3
		 */
		function tab_users() {

			/**
			 * @todo Create the ability to audit users
			 *
			 * require_once( SECSAFE_DIR_ADMIN_TABLES . '/TableUsers.php' );
			 *
			 * ob_start();
			 *
			 * include( ABSPATH . 'wp-admin/users.php' );
			 *
			 * return ob_get_clean();
			 */

		}

		/**
		 * This tab displays the login log.
		 * @since  2.0.0
		 */
		function tab_logins() {

			require_once( SECSAFE_DIR_ADMIN_TABLES . '/TableLogins.php' );

			ob_start();

			$table = new TableLogins();
			$table->display_charts();
			$table->prepare_items();
			$table->search_box( __( 'Search logins', SECSAFE_SLUG ), 'log' );
			$table->display();

			return ob_get_clean();

		}

		/**
		 * This tab displays the admin activity log.
		 * @since  2.0.0
		 */
		function tab_activity() {

			if ( ! SECSAFE_DEBUG ) {
				return;
			}

			require_once( SECSAFE_DIR_ADMIN_TABLES . '/TableActivity.php' );

			ob_start();

			$table = new TableActivity();
			$table->prepare_items();
			$table->search_box( __( 'Search activity', SECSAFE_SLUG ), 'log' );
			$table->display();

			return ob_get_clean();

		}

		/**
		 * This sets the variables for the page.
		 * @since  0.1.0
		 */
		protected function set_page() {

			$this->slug        = 'security-safe-user-access';
			$this->title       = 'User Access Control';
			$this->description = __( 'Control how users access your admin area.', SECSAFE_SLUG );

			/**
			 * @todo Create the ability to audit users
			 * disabled for now 20190722
			 */
			$notused = [
				'id'               => 'users',
				'label'            => __( 'Users', SECSAFE_SLUG ),
				'title'            => __( 'Users', SECSAFE_SLUG ),
				'heading'          => false,
				'intro'            => false,
				'classes'          => [ 'full' ],
				'content_callback' => 'tab_users',
			];

			$this->tabs[] = [
				'id'               => 'logins',
				'label'            => __( 'Logins', SECSAFE_SLUG ),
				'title'            => __( 'Login Log', SECSAFE_SLUG ),
				'heading'          => false,
				'intro'            => false,
				'classes'          => [ 'full' ],
				'content_callback' => 'tab_logins',
			];

			$this->tabs[] = [
				'id'               => 'settings',
				'label'            => __( 'Settings', SECSAFE_SLUG ),
				'title'            => __( 'User Access Settings', SECSAFE_SLUG ),
				'heading'          => false,
				'intro'            => false,
				'content_callback' => 'tab_settings',
			];

			if ( SECSAFE_DEBUG ) {

				$this->tabs[] = [
					'id'               => 'activity',
					'label'            => __( 'Activity Log', SECSAFE_SLUG ),
					'title'            => __( 'Admin Activity Log', SECSAFE_SLUG ),
					'heading'          => false,
					'intro'            => false,
					'classes'          => [ 'full' ],
					'content_callback' => 'tab_activity',
				];

			}

		}

	}
