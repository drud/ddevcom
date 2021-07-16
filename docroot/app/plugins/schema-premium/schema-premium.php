<?php
/**
 * Plugin Name: Schema Premium
 * Plugin URI: https://schema.press
 * Description: The next generation of Structured Data.
 * Author: Hesham
 * Author URI: http://zebida.com
 * Version: 1.2.2
 * Text Domain: schema-premium
 * Domain Path: languages
 *
 * Schema is distributed under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Schema is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Schema. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Schema
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Schema_Premium' ) ) :

/**
 * Main Schema_Premium Class
 *
 * @since 1.0.0
 */
final class Schema_Premium {

	/**
	 * @var Schema_Premium The one true Schema_Premium
	 * @since 1.0.0
	 */
	private static $instance;
	
	/**
	 * The store api url
	 *
	 * @since 1.0.0
	 */
	private $store = 'https://schema.press';
	
	/**
	 * The name 
	 *
	 * @since 1.0.0
	 */
	private $name = 'Schema Premium';

	/**
	 * The version number of Schema Premium
	 *
	 * @since 1.0.0
	 */
	private $version = '1.2.2';

	/**
	 * The settings instance variable
	 *
	 * @var Schema_WP_Settings
	 * @since 1.0.0
	 */
	public $settings;

	/**
	 * The rewrite class instance variable
	 *
	 * @var Schema_WP_Rewrites
	 * @since 1.0.0
	 */
	public $rewrites;
	
	/**
	 * Main Schema_Premium Instance
	 *
	 * Insures that only one instance of Schema_Premium exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0.0
	 * @static
	 * @staticvar array $instance
	 * @uses Schema_Premium::setup_globals() Setup the globals needed
	 * @uses Schema_Premium::includes() Include the required files
	 * @return Schema_Premium
	 */
	public static function instance() {
		
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Schema_Premium ) ) {
			self::$instance = new Schema_Premium;
			
			// Check if Schema free is activated
			if ( class_exists( 'Schema_WP' ) ) {
				return self::$instance;
			}
			
			if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
				add_action( 'admin_notices', array( self::$instance, 'below_php_version_notice' ) );
				return self::$instance;
			}
			
			// If free Schema plugin is installed, deactivate!
			add_action( 'admin_init', array( self::$instance, 'deactivate_if_free_plugin_active' ) );
			
			self::$instance->setup_constants();
			self::$instance->includes();

			add_action( 'plugins_loaded', array( self::$instance, 'updater' ), -1 );
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
			
			register_activation_hook( __FILE__, array( self::$instance, 'flush_rewrites' ) );
			register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
			
			// Initialize the classes
        	add_action( 'plugins_loaded', array( self::$instance, 'init_classes' ), 5 );
			
			// Make sure plugin loads first
			add_action( 'activated_plugin',  array( self::$instance, 'schema_premium_plugin_load_first' ), 10, 2 );

			// Init action.
			do_action( 'schema_premium_init' );

		}
		return self::$instance;
	}
	
	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'You don’t have permission to do this', 'schema-premium' ), '1.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'You don’t have permission to do this', 'schema-premium' ), '1.0' );
	}
	
	/**
	 * Load Schema Premium plugin first: this allow extensions to load after 
	 *
	 * @since 1.0.7
	 * @access public
	 * @return void
	 */
	public function schema_premium_plugin_load_first() {
		
		$path = str_replace( WP_PLUGIN_DIR . '/', '', __FILE__ );
		if ( $plugins = get_option( 'active_plugins' ) ) {
			if ( $key = array_search( $path, $plugins ) ) {
				array_splice( $plugins, $key, 1 );
				//array_unshift( $plugins, $path );
				// Change order to 3 
				// @since 1.2.2.8 
				array_splice($plugins, 3, 0, $path);
				update_option( 'active_plugins', $plugins );
			}
		}

		// debug
		//echo '<pre>'; print_r($plugins); echo '</pre>';exit;
	}
	
	/**
	 * Show a warning to sites running PHP < 5.4
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	public function below_php_version_notice() {
		echo '<div class="notice notice-error"><p>' . __( 'Your version of PHP is below the minimum version of PHP required by Schema Premium plugin. Please contact your host and request that your version be upgraded to 5.6.20 or later.', 'schema-premium' ) . '</p></div>';
	}
	
	/**
	 * Deactivate if Schema free plugin is active 
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function deactivate_if_free_plugin_active() {
	
		if ( class_exists( 'Schema_WP' ) ) {
			$plugins = array(
        		'schema-premium/schema-premium.php',
    		);
    		deactivate_plugins($plugins);
			wp_die( __('Schema Premium plugin can not be activated, and it has deactivated! To avoid any conflict, deactivate Schema free plugin and try again.', 'schema-premium') . ' <a href="'.admin_url('plugins.php').'">'.__('Go back!', 'schema-premium').'</a>' );
		}
	}
	
	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function setup_constants() {
		
		// Plugin Store API URL
		if ( ! defined( 'SCHEMAPREMIUM_STORE_API_URL' ) ) {
			define( 'SCHEMAPREMIUM_STORE_API_URL', $this->store );
		}
		
		// Plugin name
		if ( ! defined( 'SCHEMAPREMIUM_PLUGINNAME' ) ) {
			define( 'SCHEMAPREMIUM_PLUGINNAME', 'Schema Premium' );
		}
		
		// Plugin version
		if ( ! defined( 'SCHEMAPREMIUM_VERSION' ) ) {
			define( 'SCHEMAPREMIUM_VERSION', $this->version );
		}

		// Plugin Folder Path
		if ( ! defined( 'SCHEMAPREMIUM_PLUGIN_DIR' ) ) {
			define( 'SCHEMAPREMIUM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'SCHEMAPREMIUM_PLUGIN_URL' ) ) {
			define( 'SCHEMAPREMIUM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File
		if ( ! defined( 'SCHEMAPREMIUM_PLUGIN_FILE' ) ) {
			define( 'SCHEMAPREMIUM_PLUGIN_FILE', __FILE__ );
		}
	}

	/**
	 * Include required files
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function includes() {
		
		global $schema_wp_options;
		
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/settings/register-settings.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/class-capabilities.php';
		
		// Get settings
		$schema_wp_options = schema_wp_get_settings();
		
		$acf_load = isset($schema_wp_options['acf_load']) ? $schema_wp_options['acf_load'] : 'enabled'; // default
		
		// ACF PRO loader
		if ( ! class_exists('acf_pro') && $acf_load == 'enabled' ) {
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'vendors/loader.php';
		}

		// ACF Fields
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-custom-location-rules.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-styles.php';
		
		// ACF Extensions
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-extensions-loader.php';
		
		// ACF Blocks
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-blocks/acf-blocks-categories.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-blocks/class-acf-block-helper.php';
		
		// Schema post type
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/post-type/schema-post-type.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/post-type/schema-wp-submit.php';
		
		// Admin functions
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/admin-functions.php';
		
		// Schema types classes loader
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/loader.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/meta-types-properties.php';

		if( is_admin() ) {
			
			// Metas
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/meta/class-meta.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/meta-types-locations.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/meta-properties.php';			
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/meta-tax.php';
			
			// Settings
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/settings/display-settings.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/settings/contextual-help.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/admin-pages.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/extensions.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/scripts.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/class-menu.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/class-notices.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/class-xml-parser.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/class-setup-wizard.php';
			
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/post-type/class-columns.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/post-type/schema-columns.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/post-type/schema-all-button.php';
			
			// ACF Options
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/post-type/schema-create-new.php';
			
			// ACF PRO admin
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-admin-settings.php';
			require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-admin-menu.php';
		}
		
		// XML parser class
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/class-xml-parser.php';
		
		// Functions
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/functions.php';
		//require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/functions-deprecated.php';
		
		// Filters
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/filters.php';
		
		// Schema outputs
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/json/knowledge-graph.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/json/search-results.php';
		
		// Schema output classes
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-output.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-wpheader.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-author-archive.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-singular.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-blog.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-post-type-archive.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-page-about.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-page-contact.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-page-checkout.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-terms.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/class-schema-wpfooter.php';

		// Schema output properties
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schema-output/schema-properties.php';
		
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/admin-bar-menu.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/updater/class-license-handler.php';
		
		// Plugin Integrations
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/yoast-seo.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/amp.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/bbpress.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/wp-rich-snippets.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/seo-framework.php';
        require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/rank-math.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/thirstyaffiliates.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/woocommerce.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/edd.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/dw-question-answer.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/co-authors-plus.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/wp-job-manager.php';

		// Theme Integrations
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/genesis.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/integrations/thesis.php';
		
		// Premium Extensions
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/author.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/breadcrumbs.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/comment.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/sameAs.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/video-object.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/video-object-details.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/audio-object.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/OpeningHoursSpecification.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/default-image.php';
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/custom-markup.php';
		//require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/defragment.php';
		//require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/defragment-graph.php';
		//require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/extensions/defragment-breadcrumbs.php';

		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/developer/test-on-local-server.php';

		// Install
		require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/install.php';
	}
	
	/**
     * Init all the classes
     *
     * @return void
     */
    function init_classes() {
        if ( is_admin() ) {
			if ( class_exists('Schema_WP_Setup_Wizard') ) {
				// Configuration Wizard
				new Schema_WP_Setup_Wizard();
			}
        }
    }
	
	/**
	 * Updater
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function updater() {
		
		if( ! is_admin() || ! class_exists( 'Schema_Premium_License' ) ) {
			return;
		}
		
		//self::$instance->settings       = new Schema_Premium_Settings;
		
		// auto updater
		$edd_license = new Schema_Premium_License( __FILE__, SCHEMAPREMIUM_PLUGINNAME, SCHEMAPREMIUM_VERSION, 'Hesham Zebida' );
	}

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function load_textdomain() {

		// Set filter for plugin's languages directory
		$lang_dir = dirname( plugin_basename( SCHEMAPREMIUM_PLUGIN_FILE ) ) . '/languages/';
		$lang_dir = apply_filters( 'schema_wp_languages_directory', $lang_dir );

		// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale',  get_locale(), 'schema-premium' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'schema-premium', $locale );

		// Setup paths to current locale file
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/schema-premium/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/schema-premium/ folder
			load_textdomain( 'schema-premium', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/schema-premium/languages/ folder
			load_textdomain( 'schema-premium', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'schema-premium', false, $lang_dir );
		}
	}
	
	/**
	* Flush rewrites
	*
	* @return array
	*/
	function flush_rewrites() {
		
		flush_rewrite_rules();
	}
}

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true Schema_Premium
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $schema_premium = schema_premium(); ?>
 *
 * @since 1.0.0
 * @return Schema_Premium The one true Schema_Premium Instance
 */
function schema_premium() {
	return Schema_Premium::instance();
}
schema_premium();
