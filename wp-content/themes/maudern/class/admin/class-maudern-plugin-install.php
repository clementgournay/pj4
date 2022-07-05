<?php
/**
 * Maudern Plugin Install Class
 *
 * @package  maudern
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Maudern_Plugin_Install' ) ) :
	/**
	 * The Maudern plugin install class
	 */
	class Maudern_Plugin_Install {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			add_action( 'admin_init', array( $this, 'log_fresh_site_state' ) );

			/*
			* In case the WC Admin inbox is not available, show the admin notice.
			*/
			if ( $this->is_inbox_available() ) {
				add_action( 'admin_notices', array( $this, 'admin_inbox_messages' ), 99 );
			} else {
				add_action( 'admin_notices', array( $this, 'admin_notices' ), 99 );
			}

			add_action( 'wp_ajax_dismiss_notice', array( $this, 'dismiss_notice' ) );
		}

		/**
		 * Checks if WC Admin inbox is available. It might not be available if
		 * WooCommerce is not installed, in old versions of WC or if wc-admin
		 * has been disabled.
		 *
		 * @since 1.0.0
		 */
		private function is_inbox_available() {
			if (
				function_exists( 'WC' ) &&
				is_callable( array( WC(), 'is_wc_admin_active' ) ) &&
				WC()->is_wc_admin_active() &&
				version_compare( WC_VERSION, '4.8.0', '>=' )
			) {
				return true;
			}

			return false;
		}


		/**
		 * Update Maudern fresh site flag.
		 *
		 * @since 1.0.0
		 */
		public function log_fresh_site_state() {
			if ( ! maudern_is_wc_active() ) {
				return;
			}

			if ( ( (int) wp_count_posts( 'product' )->publish >= 6 ) && ( (int) wp_count_posts( 'page' )->publish >= 3 ) && has_nav_menu( 'primary' ) ) {
				update_option( 'fresh_site', 0 );
				update_option( 'maudern_notice_dismissed', 1 );

				return;
			}

			update_option( 'fresh_site', 1 );
		}

		/**
		 * Prints Maudern inbox messages.
		 *
		 * @since 1.0.0
		 */
		public function admin_inbox_messages() {
			// The setup already has happened. No inbox message needed.
			if ( true !== (bool) get_option( 'fresh_site' ) ) {
				return;
			}

			require 'class-maudern-inbox-messages-customize.php';
			Maudern_Inbox_Messages_Customize::possibly_add_note();
		}

		/**
		 * Prints admin notices.
		 *
		 * @since 1.0.0
		 */
		public function admin_notices() {
			global $pagenow;

			if ( true === (bool) get_option( 'maudern_notice_dismissed' ) ) {
				return;
			}

			// Coming from the WooCommerce Wizard?
			if ( wp_get_referer() && 0 === strpos( basename( wp_get_referer() ), 'index.php?page=wc-setup' ) && 'post-new.php' === $pagenow ) {
				return;
			}

			if ( ! maudern_is_wc_active() && current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) :
				?>
				<div class="notice maudern-notice is-dismissible">
					<span class="notice-thumb">
						<svg width="80px" height="43px" viewBox="0 0 109 59" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							<g id="maudern-logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<path d="M15.8067476,17.9029176 C21.7429667,17.9029176 26.5540384,22.6275938 26.5540384,28.4563024 L26.5299413,29.1698732 L26.5540384,29.1698732 L26.5547838,44.9731942 C26.5824213,51.6539072 27.395251,56.7288319 31.7608579,57.8310277 L31.7608579,58.8303909 L7.95807864e-13,58.8303909 L7.95807864e-13,57.8310277 C4.82868102,56.4603164 5.08355382,50.9701899 5.08355382,44.6072134 L5.08355382,29.1698732 L5.05945675,28.4563024 C5.05945675,22.6275938 9.87052838,17.9029176 15.8067476,17.9029176 Z M85.7728024,-1.4814816e-12 C95.5185507,-1.4814816e-12 103.69643,3.91848224 103.859013,18.5397969 L103.861479,18.9861501 L103.861479,44.5889342 C103.861479,51.3343958 104.573271,56.5154487 108.677516,57.7626448 L108.904764,57.8267581 L108.904764,58.8271801 L78.1414454,58.8271801 L78.1414454,57.8267581 C82.737297,56.4786677 83.0553413,51.1502227 83.0650862,44.9233582 L83.0653359,19.4845388 C83.0653359,12.3649603 81.83369,8.99286405 77.5283156,8.99286405 C76.258349,8.99286405 74.8810792,9.21308372 73.7012554,10.0626812 L73.4680135,10.2411137 L72.2354699,8.74230299 C75.3127893,3.62356842 79.9871189,-1.4814816e-12 85.7728024,-1.4814816e-12 Z M46.6730916,-1.4814816e-12 C56.4913951,-1.4814816e-12 64.7294145,3.91848224 64.8931931,18.5397969 L64.8956779,18.9861501 L64.8956779,44.5889342 C64.8956779,51.3343958 65.6127034,56.5154487 69.7471263,57.7626448 L69.9760457,57.8267581 L69.9760457,58.8271801 L38.986526,58.8271801 L38.986526,57.8267581 C43.6152822,56.4786677 43.9365223,51.1502227 43.9463692,44.9233582 L43.9466216,19.4845388 C43.9466216,12.3649603 42.7050152,8.99286405 38.3688879,8.99286405 C37.0895834,8.99286405 35.7021865,9.21308372 34.5129424,10.0626812 L34.2778263,10.2411137 L33.0362199,8.74230299 C36.1370709,3.62356842 40.8457706,-1.4814816e-12 46.6730916,-1.4814816e-12 Z" id="Shape" fill="#ffffff"></path>
							</g>
						</svg>
					</span>
					<div class="notice-content">
						<h2 class="notice-title"><?php echo esc_html_x( 'Welcome to Maudern!', 'Theme notification', 'maudern' ); ?></h2>
						<p class="notice-description"><?php echo esc_html_x( 'To enable eCommerce features you need to install the WooCommerce plugin.', 'Theme notification', 'maudern' ); ?></p>
						<p class="notice-buttons"><?php self::install_plugin_button( 'woocommerce', 'woocommerce.php', 'WooCommerce', array(), _x( 'WooCommerce activated', 'Theme notification', 'maudern' ), _x( 'Activate WooCommerce', 'Theme notification', 'maudern' ), _x( 'Install WooCommerce', 'Theme notification', 'maudern' ) ); ?></p>
					</div>
				</div>
				<?php
			endif;

			if ( maudern_is_wc_active() && current_user_can( 'manage_options' ) ) :
				?>
				<div class="notice maudern-notice is-dismissible">
					<span class="notice-thumb">
						<svg width="80px" height="43px" viewBox="0 0 109 59" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							<g id="maudern-logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<path d="M15.8067476,17.9029176 C21.7429667,17.9029176 26.5540384,22.6275938 26.5540384,28.4563024 L26.5299413,29.1698732 L26.5540384,29.1698732 L26.5547838,44.9731942 C26.5824213,51.6539072 27.395251,56.7288319 31.7608579,57.8310277 L31.7608579,58.8303909 L7.95807864e-13,58.8303909 L7.95807864e-13,57.8310277 C4.82868102,56.4603164 5.08355382,50.9701899 5.08355382,44.6072134 L5.08355382,29.1698732 L5.05945675,28.4563024 C5.05945675,22.6275938 9.87052838,17.9029176 15.8067476,17.9029176 Z M85.7728024,-1.4814816e-12 C95.5185507,-1.4814816e-12 103.69643,3.91848224 103.859013,18.5397969 L103.861479,18.9861501 L103.861479,44.5889342 C103.861479,51.3343958 104.573271,56.5154487 108.677516,57.7626448 L108.904764,57.8267581 L108.904764,58.8271801 L78.1414454,58.8271801 L78.1414454,57.8267581 C82.737297,56.4786677 83.0553413,51.1502227 83.0650862,44.9233582 L83.0653359,19.4845388 C83.0653359,12.3649603 81.83369,8.99286405 77.5283156,8.99286405 C76.258349,8.99286405 74.8810792,9.21308372 73.7012554,10.0626812 L73.4680135,10.2411137 L72.2354699,8.74230299 C75.3127893,3.62356842 79.9871189,-1.4814816e-12 85.7728024,-1.4814816e-12 Z M46.6730916,-1.4814816e-12 C56.4913951,-1.4814816e-12 64.7294145,3.91848224 64.8931931,18.5397969 L64.8956779,18.9861501 L64.8956779,44.5889342 C64.8956779,51.3343958 65.6127034,56.5154487 69.7471263,57.7626448 L69.9760457,57.8267581 L69.9760457,58.8271801 L38.986526,58.8271801 L38.986526,57.8267581 C43.6152822,56.4786677 43.9365223,51.1502227 43.9463692,44.9233582 L43.9466216,19.4845388 C43.9466216,12.3649603 42.7050152,8.99286405 38.3688879,8.99286405 C37.0895834,8.99286405 35.7021865,9.21308372 34.5129424,10.0626812 L34.2778263,10.2411137 L33.0362199,8.74230299 C36.1370709,3.62356842 40.8457706,-1.4814816e-12 46.6730916,-1.4814816e-12 Z" id="Shape" fill="#ffffff"></path>
							</g>
						</svg>
					</span>
					<div class="notice-content">
						<h2 class="notice-title"><?php esc_html_x( 'Design Your Store with Maudern!', 'Theme notification', 'maudern' ); ?></h2>
						<p class="notice-description"><?php esc_html_x( 'You\'ve set up WooCommerce, now it\'s time to give it some style!', 'Theme notification', 'maudern' ); ?></p>
						<p class="notice-buttons"><a href="<?php echo esc_url( admin_url( 'customize.php/?maudern_starter_content=1' ) ); ?>" class="maudern-starter-content"><?php echo esc_html_x( 'Let\'s go!', 'Theme starter content', 'maudern' ); ?></a></p>
					</div>
				</div>
				<?php
			endif;
		}

		/**
		 * AJAX dismiss notice.
		 *
		 * @since 1.0.0
		 */
		public function dismiss_notice() {
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce'] ) ), 'maudern_notice_dismiss' ) || ! current_user_can( 'manage_options' ) ) { // WPCS: input var ok.
				die();
			}

			update_option( 'maudern_notice_dismissed', 1 );
		}

		/**
		 * Output a button that will install or activate a plugin if it doesn't exist, or display a disabled button if the
		 * plugin is already activated.
		 *
		 * @param string $plugin_slug The plugin slug.
		 * @param string $plugin_file The plugin file.
		 * @param string $plugin_name The plugin name.
		 * @param string $classes CSS classes.
		 * @param string $activated Button activated text.
		 * @param string $activate Button activate text.
		 * @param string $install Button install text.
		 */
		public static function install_plugin_button( $plugin_slug, $plugin_file, $plugin_name, $classes = array(), $activated = '', $activate = '', $install = '' ) {
			if ( current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) {
				if ( is_plugin_active( $plugin_slug . '/' . $plugin_file ) ) {
					// The plugin is already active.
					$button = array(
						'message' => esc_attr_x( 'Activated', 'Theme notification', 'maudern' ),
						'url'     => '#',
						'classes' => array( 'maudern-button', 'disabled' ),
					);

					if ( '' !== $activated ) {
						$button['message'] = esc_attr( $activated );
					}
				} elseif ( self::is_plugin_installed( $plugin_slug ) ) {
					$url = self::is_plugin_installed( $plugin_slug );

					// The plugin exists but isn't activated yet.
					$button = array(
						'message' => esc_attr_x( 'Activate', 'Theme notification', 'maudern' ),
						'url'     => $url,
						'classes' => array( 'activate-now' ),
					);

					if ( '' !== $activate ) {
						$button['message'] = esc_attr( $activate );
					}
				} else {
					// The plugin doesn't exist.
					$url    = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'install-plugin',
								'plugin' => $plugin_slug,
							),
							self_admin_url( 'update.php' )
						),
						'install-plugin_' . $plugin_slug
					);
					$button = array(
						'message' => esc_attr_x( 'Install now', 'Theme notification', 'maudern' ),
						'url'     => $url,
						'classes' => array( 'maudern-install-now', 'install-now', 'install-' . $plugin_slug ),
					);

					if ( '' !== $install ) {
						$button['message'] = esc_attr( $install );
					}
				}

				if ( ! empty( $classes ) ) {
					$button['classes'] = array_merge( $button['classes'], $classes );
				}

				$button['classes'] = implode( ' ', $button['classes'] );

				?>
				<span class="plugin-card-<?php echo esc_attr( $plugin_slug ); ?>">
					<a href="<?php echo esc_url( $button['url'] ); ?>" class="<?php echo esc_attr( $button['classes'] ); ?>" data-originaltext="<?php echo esc_attr( $button['message'] ); ?>" data-name="<?php echo esc_attr( $plugin_name ); ?>" data-slug="<?php echo esc_attr( $plugin_slug ); ?>" aria-label="<?php echo esc_attr( $button['message'] ); ?>"><?php echo esc_html( $button['message'] ); ?></a>
				</span> <?php echo /* translators: conjunction of two alternative options user can choose (in missing plugin admin notice). Example: "Activate WooCommerce or learn more" */ esc_html_x( 'or', 'Theme notification', 'maudern' ); ?>
				<a href="https://wordpress.org/plugins/<?php echo esc_attr( $plugin_slug ); ?>" class="learn-more" target="_blank"><?php echo esc_html_x( 'learn more', 'Theme notification', 'maudern' ); ?></a>
				<?php
			}
		}

		/**
		 * Check if a plugin is installed and return the url to activate it if so.
		 *
		 * @param string $plugin_slug The plugin slug.
		 */
		private static function is_plugin_installed( $plugin_slug ) {
			if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_slug ) ) {
				$plugins = get_plugins( '/' . $plugin_slug );
				if ( ! empty( $plugins ) ) {
					$keys        = array_keys( $plugins );
					$plugin_file = $plugin_slug . '/' . $keys[0];
					$url         = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'activate',
								'plugin' => $plugin_file,
							),
							admin_url( 'plugins.php' )
						),
						'activate-plugin_' . $plugin_file
					);
					return $url;
				}
			}
			return false;
		}
	}

endif;

if ( is_admin() ) {
	return new Maudern_Plugin_Install();
}
