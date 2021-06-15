<?php

	namespace SovereignStack\SecuritySafe;

	// Prevent Direct Access
	( defined( 'ABSPATH' ) ) || die;

	/**
	 * Class AdminPage
	 * @package SecuritySafe
	 */
	class AdminPage {

		public $title = 'Page Title';
		public $description = 'Description of page.';
		public $slug = '';
		public $tabs = [];
		/**
		 * Contains all the admin message values for the page.
		 * @var array
		 */
		public $messages = [];
		protected $settings = [];

		/**
		 * AdminPage constructor.
		 *
		 * @param $settings
		 */
		function __construct( $settings ) {

			$this->settings = $settings;

			// Prevent Caching
			Janitor::prevent_caching();

			// Set page variables
			$this->set_page();

		}

		/**
		 * Placeholder intended to be used by pages to override variables.
		 * @since  0.1.0
		 */
		protected function set_page() {

			// This is overwritten by specific page.

		}

		/**
		 * Displays all the tabs set by the specific page
		 *
		 * @since  0.2.0
		 */
		public function display_tabs() {

			if ( ! empty( $this->tabs ) ) {

				$html = '<h2 class="nav-tab-wrapper">';
				$num  = 1;

				foreach ( $this->tabs as $t ) {

					if ( is_array( $t ) ) {

						$classes = 'nav-tab';

						// Add Active Class To Active Tab : Default First Tab
						if ( ( isset( $_GET['tab'] ) && $_GET['tab'] == $t['id'] ) || ( ! isset( $_GET['tab'] ) && $num == 1 ) ) {

							$classes .= ' nav-tab-active';

						}

						$html .= '<a href="?page=' . esc_html( $this->slug ) . '&tab=' . esc_html( $t['id'] ) . '" class="' . esc_html( $classes ) . '">' . esc_html( $t['label'] ) . '</a>';

						$num ++;

					}

				}

				$html .= '</h2>';

				echo $html;

			}

		}

		/**
		 * Display All Tabbed Content
		 *
		 * @since  0.2.0
		 */
		public function display_tabs_content() {

			if ( ! empty( $this->tabs ) ) {

				$num = 1;

				$html = '';

				foreach ( $this->tabs as $t ) {

					if ( ( isset( $_GET['tab'] ) && $_GET['tab'] == $t['id'] ) || ( ! isset( $_GET['tab'] ) && $num == 1 ) ) {

						$classes = 'tab-content';

						// Add Active Class To Active Tab : Default First Tab Content
						if ( ( isset( $_GET['tab'] ) && $_GET['tab'] == $t['id'] ) || ( ! isset( $_GET['tab'] ) && $num == 1 ) ) {
							$classes .= ' active';
						}

						// Adds Custom Classes
						if ( isset( $t['classes'] ) ) {

							if ( is_array( $t['classes'] ) ) {

								foreach ( $t['classes'] as $class ) {

									$classes .= ' ' . $class;

								}

							} else {

								$classes .= ' ' . $t['classes'];

							}

						}

						$html .= '<div id="' . esc_html( $t['id'] ) . '" class="' . esc_html( $classes ) . '">';

						// Display Title
						if ( isset( $t['title'] ) && $t['title'] ) {

							$html .= '<h2>' . esc_html( $t['title'] ) . '</h2>';

						}

						// Display Heading Text
						if ( isset( $t['heading'] ) && $t['heading'] ) {

							$html .= '<p class="new-description description">' . esc_html( $t['heading'] ) . '</p>';

						}

						// Display Intro Text
						if ( isset( $t['intro'] ) && $t['intro'] ) {

							/**
							 * @todo Need to sanitize this in a way that doesn't break the intro
							 */
							$html .= '<p>' . $t['intro'] . '</p>';

						}

						// Display Page Messages As A Log
						$html .= $this->display_messages();

						// Run Callback Method To Display Content
						if ( isset( $t['content_callback'] ) && $t['content_callback'] ) {

							$content = $t['content_callback'];
							$html    .= $this->$content();

						}

						$html .= '</div><!-- #' . esc_html( $t['id'] ) . ' -->';

						$num ++;

					}

				}

				echo $html;

			}

		}

		/**
		 * Displays this page's messages in a log format. Only used on file permissions page.
		 *
		 * @return string
		 *
		 * @since 1.1.0
		 */
		private function display_messages() {

			$html = '';

			if (
				isset( $_POST ) &&
				! empty( $_POST ) &&
				isset( $_GET['page'] ) &&
				$_GET['page'] == 'security-safe-files' &&
				isset( $_GET['tab'] ) &&
				$_GET['tab'] != 'settings'
			) {

				$html = '<h3>' . __( 'Process Log', SECSAFE_SLUG ) . '</h3>
					<p><textarea style="width: 100%; height: 120px;">';

				if ( ! empty( $this->messages ) ) {

					foreach ( $this->messages as $m ) {

						// Display Messages
						$html .= ( $m[1] == 3 ) ? "\n!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! \n" : '';
						$html .= '- ' . esc_html( $m[0] ) . "\n";
						$html .= ( $m[1] == 3 ) ? "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! \n\n" : '';

					}

				} else {

					$html .= __( 'No changes were made to file permissions.', SECSAFE_SLUG );

				}// ! empty()

				$html .= '</textarea></p>';

			}

			return $html;

		}

		/**
		 * Creates the opening and closing tags for the form-table
		 *
		 * @param string $rows
		 *
		 * @return string
		 *
		 * @since  0.2.0
		 */
		protected function form_table( $rows ) {

			return '<table class="form-table">' . $rows . '</table>';

		}

		/**
		 * Creates a new section for a form-table
		 *
		 * @param string $title
		 * @param string $desc
		 *
		 * @return string
		 *
		 * @since  0.2.0
		 */

		protected function form_section( $title, $desc ) {

			// Create ID to allow links to specific areas of admin
			$id = str_replace( ' ', '-', trim( strtolower( $title ) ) );

			$html = '<h3 id="' . esc_html( $id ) . '">' . esc_html( $title ) . '</h3>';
			$html .= '<p>' . esc_html( $desc ) . '</p>';

			return $html;

		}

		/**
		 * Displays form checkbox for a settings page.
		 *
		 * @param array $page_options An array of setting values specific to the particular page. This is not the full array of settings.
		 * @param string $name The name of the checkbox which corresponds with the setting name in the database.
		 * @param string $slug The value for the settings in the database.
		 * @param string $short_desc The text that is displayed to the right on the checkbox.
		 * @param string $long_desc The description text displayed below the title.
		 * @param string $classes
		 * @param bool $disabled
		 *
		 * @return string
		 *
		 * @since  0.1.0
		 */
		protected function form_checkbox( $page_options, $name, $slug, $short_desc, $long_desc, $classes = '', $disabled = false ) {

			$html = '<tr class="form-checkbox ' . $classes . '">';

			if ( is_array( $page_options ) && $slug && $short_desc ) {

				$html .= $this->row_label( $name );
				$html .= '<td>';

				$checked  = ( isset( $page_options[ $slug ] ) && $page_options[ $slug ] == '1' ) ? 'CHECKED' : '';
				$disabled = ( $disabled ) ? 'DISABLED' : '';

				/**
				 * @todo  Fix: Had to remove esc_html for short desc
				 */
				$html .= '<label><input name="' . esc_html( $slug ) . '" type="checkbox" value="1" ' . $checked . ' ' . $disabled . '/>' . $short_desc . '</label>';

				if ( $long_desc ) {
					/**
					 * @todo  Fix: Had to remove esc_html for long desc
					 */
					$html .= '<p class="description">' . $long_desc . '</p>';

				}

				// Testing Only
				//$html .= 'Value: ' . $page_options[ $slug ];

				$html .= '</td>';

			} else {

				$html .= '<td colspan="2"><p>' . __( 'Error: There are parameters missing to properly display checkbox.', SECSAFE_SLUG ) . '</p></td>';

			}

			$html .= '</tr>';

			return $html;

		}

		/**
		 * Adds row label
		 *
		 * @param $name
		 *
		 * @return string
		 */
		protected function row_label( $name ) {

			$html = '<th scope="row">';

			if ( $name ) {

				$html .= '<label>' . esc_html( $name ) . '</label>';

			}

			$html .= '</th>';

			return $html;

		}

		/**
		 * Adds custom message in a table row
		 *
		 * @param string $message
		 * @param string $class
		 * @param string $classes
		 *
		 * @return string
		 */
		protected function form_text( $message, $class = '', $classes = '' ) {

			$html = '<tr class="form-text ' . esc_html( $classes ) . '">';

			// Need to make sure message is sanitized when form_text is called
			$html .= '<td colspan="2"><p class="' . esc_html( $class ) . '">' . $message . '</p></td>';

			$html .= '</tr>';

			return $html;

		}

		/**
		 * Adds an input row
		 *
		 * @param $page_options
		 * @param $name
		 * @param $slug
		 * @param $placeholder
		 * @param $long_desc
		 * @param string $styles
		 * @param string $classes
		 * @param bool $required
		 *
		 * @return string
		 */
		protected function form_input( $page_options, $name, $slug, $placeholder, $long_desc, $styles = '', $classes = '', $required = false ) {

			$html = '<tr class="form-input ' . esc_html( $classes ) . '">';

			if ( is_array( $page_options ) && $slug ) {

				$value = ( isset( $page_options[ $slug ] ) ) ? $page_options[ $slug ] : '';

				$html .= $this->row_label( $name );

				$html .= '<td><input type="text" name="' . esc_html( $slug ) . '" placeholder="' . esc_html( $placeholder ) . '" value="' . esc_html( $value ) . '" style="' . esc_html( $styles ) . '">';

				if ( $long_desc ) {

					$html .= '<p class="description">' . esc_html( $long_desc ) . '</p>';

				}

				$html .= '</td>';

			} else {

				$html .= '<td>' . sprintf( __( 'Error: There is an issue displaying this form field: %s.', SECSAFE_SLUG ), 'input' ) . '</td>';

			}

			$html .= '</tr>';

			return $html;

		}

		/**
		 * Adds a select option row
		 *
		 * @param $page_options
		 * @param $name
		 * @param $slug
		 * @param $options
		 * @param $long_desc
		 * @param string $classes
		 * @param string $default
		 * @param false $disabled
		 * @param false $input_only
		 *
		 * @return string
		 */
		protected function form_select( $page_options, $name, $slug, $options, $long_desc, $classes = '', $default = '', $disabled = false, $input_only = false ) {

			$html = ( $input_only ) ? '' : '<tr class="form-select ' . esc_html( $classes ) . '">';

			if ( is_array( $page_options ) && $slug && $options ) {

				$use_default = ! isset( $page_options[ $slug ] ) || $page_options[ $slug ] == '' || $disabled;

				if ( ! $input_only ) {

					$html .= $this->row_label( $name );
					$html .= '<td>';

				}

				$html .= '<select name="' . esc_html( $slug ) . '">';

				if ( is_array( $options ) ) {

					foreach ( $options as $value => $label ) {

						$selected       = ( $use_default && $default == $value ) ? 'SELECTED' : '';
						$selected       = ( ! $use_default && isset( $page_options[ $slug ] ) && $page_options[ $slug ] == $value ) ? ' SELECTED' : $selected;
						$disable_option = ( $disabled && $default != $value ) ? 'DISABLED' : '';

						$html .= '<option value="' . esc_html( $value ) . '" ' . $selected . ' ' . $disable_option . '>' . esc_html( $label ) . '</option>';

					}

				} else {

					$html .= '<option>' . __( 'Error: Form field "select" is not an array.', SECSAFE_SLUG ) . '</option>';

				}

				$html .= '</select>';

				if ( ! $input_only ) {

					if ( $long_desc ) {

						$html .= '<p class="description">' . $long_desc . '</p>';

					}

					$html .= '</td>';

				}

			} else {

				$html .= '<td colspan="2">' . sprintf( __( 'Error: There is an issue displaying this form field: %s.', SECSAFE_SLUG ), 'select' ) . '</td>';

			}

			$html .= ( $input_only ) ? '' : '</tr>';

			return $html;

		}

		/**
		 *Add a row with custom HTML
		 *
		 * @param string $classes
		 * @param string $content
		 *
		 * @return string
		 *
		 * @since 2.4.0
		 */
		protected function row_custom( $classes, $content ) {

			$html = '<tr class="' . $classes . '">';
			$html .= ( $content ) ? $content : '';
			$html .= '</tr>';

			return $html;

		}

		/**
		 * Creates a File Upload Field
		 *
		 * @param $text
		 * @param $name
		 * @param string $long_desc
		 * @param string $classes
		 *
		 * @return string
		 */
		protected function form_file_upload( $text, $name, $long_desc = '', $classes = '' ) {

			$html = '<tr class="form-file-upload ' . esc_html( $classes ) . '">';
			$html .= '<div class="file-upload-wrap cf"><label>' . esc_html( $text ) . '</label><input name="' . esc_html( $name ) . '" id="' . esc_html( $name ) . '" type="file" class="file-input"><input type="button" class="file-select" value="' . __( 'Choose File', SECSAFE_SLUG ) . '"><span class="file-selected">' . __( 'No File Chosen', SECSAFE_SLUG ) . '</span>';
			$html .= '</div></tr>';

			return $html;

		}

		/**
		 * Creates Table Row For A Button
		 *
		 * @param $text
		 * @param $type
		 * @param $value
		 * @param false $long_desc
		 * @param string $classes
		 * @param bool $label
		 * @param false $name
		 *
		 * @return string
		 *
		 * @since  0.3.0
		 */
		protected function form_button( $text, $type, $value, $long_desc = false, $classes = '', $label = true, $name = false ) {

			$html = '<tr class="form-button ' . esc_html( $classes ) . '">';

			if ( $label ) {

				$html .= $this->row_label( $text );

			}

			$html .= '<td>';
			$html .= $this->button( $text, $type, $value, $name );

			if ( $long_desc ) {

				$html .= '<p class="description">' . esc_html( $long_desc ) . '</p>';

			}

			$html .= '</td>';
			$html .= '</tr>';

			return $html;

		}

		/**
		 * Return HTML for Submit Button
		 *
		 * @param string $text
		 * @param string $type
		 * @param string $value
		 * @param string $name
		 *
		 * @return string
		 *
		 * @since  0.3.0
		 */
		protected function button( $text = '', $type = '', $value = false, $name = false ) {

			// Default Values
			$text  = ( $text ) ? $text : __( 'Save Changes', SECSAFE_SLUG );
			$type  = ( $type ) ? $type : 'submit';
			$value = ( $value ) ? $value : $text;
			$name  = ( $name ) ? $name : $type;

			$html    = '<p class="' . esc_html( $type ) . '">';
			$classes = 'button ';

			if ( $type == 'submit' ) {

				$classes .= 'button-primary';
				$html    .= '<input type="' . esc_html( $type ) . '" name="' . esc_html( $name ) . '" id="' . esc_html( $type ) . '" class="' . esc_html( $classes ) . '" value="' . esc_html( $value ) . '" />';

			} elseif ( $type == 'link' ) {

				$classes .= 'button-secondary';
				$html    .= '<a href="' . esc_html( $value ) . '" class="' . esc_html( $classes ) . '">' . esc_html( $text ) . '</a>';

			} elseif ( $type == 'link-delete' ) {

				$classes .= 'button-secondary button-link-delete';
				$html    .= '<a href="' . esc_html( $value ) . '" class="' . esc_html( $classes ) . '">' . esc_html( $text ) . '</a>';

			}

			$html .= '</p>';

			return $html;

		}

	}
