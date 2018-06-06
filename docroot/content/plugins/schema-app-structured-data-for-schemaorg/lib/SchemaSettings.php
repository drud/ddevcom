<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );
/**
 * Admin Settings for Schema
 * Modeled after example 2: http://codex.wordpress.org/Creating_Options_Pages
 * 
 * @author Mark van Berkel
 */
class SchemaSettings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $Settings;
    private $SettingsGenesis;
    private $license;
    private $PluginURL;
    private $PluginVersion;
    
    const SCHEMA_ITEM_NAME = "schemawoocommerce";    

    /**
     * Start up
     */
    public function __construct($HunchSchemaPluginURL, $HunchSchemaPluginVersion)
    {
        $this->PluginURL = $HunchSchemaPluginURL;
        $this->PluginVersion = $HunchSchemaPluginVersion;
        $this->Settings = get_option( 'schema_option_name' );
        $this->SettingsGenesis = get_option( 'schema_option_name_genesis' );
        $this->license = get_option( 'schema_option_name_license' );
        
        add_action( 'admin_init', array($this, 'admin_nag_handle'));
        add_action( 'admin_init', array( $this, 'page_init' ) );        
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
        add_action( 'admin_notices', array($this, 'admin_nag_set'));         
        register_activation_hook( __FILE__, array($this, 'welcome_screen_activate'));
        add_action( 'admin_init', array($this, 'welcome_screen_do_activation_redirect'));
    }


	/**
	 * HunchSchemaActivate, function to register the site with Schema App. 
	 * Used to cache schema app data locally as transients
	 * 
	 */
	function PluginActivate()
	{
		$Settings = get_option( 'schema_option_name' );

		if ( ! empty( $Settings['graph_uri'] ) )
		{
			$activationApi = "https://api.hunchmanifest.com/utility/template?template=http%3A%2F%2Fhunchmanifest.com%2Fontology%2Fschemarules%23AddSiteAccount&accountId=" . $Settings['graph_uri'] . "&siteUrl=" . site_url() . "&software=Wordpress";
			wp_remote_get( $activationApi, array( 'timeout' => 15, 'sslverify' => false ) );			
		}

		$Settings['Version'] = $this->PluginVersion;

		update_option( 'schema_option_name', $Settings );
	}


	public function hook_plugin_action_links( $links )
	{
		array_push( $links, sprintf( '<a href="%s">Settings</a>', admin_url( 'options-general.php?page=schema-app-setting' ) ) );

		return $links;
	}


    /**
     * 
     * @return type
     */
    public function welcome_screen_do_activation_redirect() {
        
        // Bail if no activation redirect
        if ( ! get_transient( '_welcome_screen_activation_redirect' ) ) {
            return;
        }

        // Delete the redirect transient
        delete_transient( '_welcome_screen_activation_redirect' );

        // Bail if activating from network, or bulk
        if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
            return;
        }

        // Redirect to schema app about page
        wp_safe_redirect( add_query_arg( array( 'page' => 'schema-app-setting', 'tab' => 'schema-app-welcome' ), admin_url( 'options-general.php' ) ) );        

    }
    /**
     * 
     */
    public function welcome_screen_activate() {
        set_transient( '_welcome_screen_activation_redirect', true, 30 );
    }


    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        
        // This page will be under "Settings"
        add_options_page(
            'Schema App Settings', 
            'Schema App', 
            'manage_options', 
            'schema-app-setting', 
            array( $this, 'create_admin_page' )
        );
        
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        if ( isset( $_GET['NoticeDismiss'] ) && $_GET['NoticeDismiss'] == 'WooCommerceAddon' )
        {
            $this->Settings['NoticeDismissWooCommerceAddon'] = 1;

			update_option( 'schema_option_name', $this->Settings );
        }

		if ( empty( $this->Settings['NoticeDismissWooCommerceAddon'] ) && class_exists( 'WooCommerce' ) && ! function_exists( 'hunch_schema_wc_add' ) && ! class_exists( 'SchemaAppAdvanced' ) )
		{
			printf( '<div class="notice notice-success"> <p>Schema App WooCommerce is not installed but recommended for your WooCommerce products - <a target="_blank" href="https://www.schemaapp.com/product/schema-woocommerce-plugin/">See more</a>. &nbsp; <a href="%s">Dismiss</a></p> </div>', add_query_arg( 'NoticeDismiss', 'WooCommerceAddon' ) );
		}

        ?>
        <div class="wrap">
            <h2>Schema App Settings</h2>
            <div></div>

			<h3 class="nav-tab-wrapper">
				<a class="nav-tab" href="<?php echo admin_url() ?>options-general.php?page=schema-app-welcome">Quick Guide</a>
				<a class="nav-tab nav-tab-active" href="<?php echo admin_url() ?>options-general.php?page=schema-app-setting">Settings</a>
				<a class="nav-tab" href="<?php echo admin_url() ?>options-general.php?page=schema-app-licenses">Licenses</a>
				<?php if ( function_exists( 'genesis' ) ) : ?>
					<a class="nav-tab" href="<?php echo admin_url() ?>options-general.php?page=schema-app-setting-genesis">Genesis</a>
				<?php endif; ?>
				<?php do_action( 'hunch_schema_settings_nav_tab' ); ?>
			</h3>

            <section id="schema-app-welcome">
				<h3>Instructions</h3>
				<ol>
					<li>Enter your company/publisher settings in Wordpress Admin > Settings > Schema App. This creates default schema markup for pages, posts, search and categories.</li>
					<li>For further organic search optimization, <a href="https://www.schemaapp.com/product-pricing/">sign up for Schema App</a>. Use Schema App to optimize your homepage (organization), Contact Page, Services, Products, Reviews, etc. Schema App includes support for <a href="http://schema.org/">schema.org</a> markup questions and Schema App tool help.  Once you've signed up:</li>
					<ol>
						<li>Find your <a href="https://app.schemaapp.com/integration/wordpress">Schema App Account ID</a> and add it to the Schema App Wordpress settings page to <a href="https://youtu.be/0WH9s26WSg4">automate schema markup deployment</a>.</li>
						<li>Follow the <a href="https://www.schemaapp.com/tutorial/guide-optimizing-website-schema-org/">Getting Started Guide</a> to optimize your website content.</li>
					</ol>
				</ol>
				<p><em>Note: Schema App registration and Account ID is not required to make the plugin create default <a href="http://schema.org/">schema.org</a> markup for pages and posts.</em></p>

				<h3>Support & Service</h3>
				<p><a href="https://www.schemaapp.com/wordpress-plugin/faq/">Schema App Wordpress plugin Frequently Asked Questions (FAQ)</a></p>
				<p>Send support questions to <a href="mailto:support@hunchmanifest.com">support@hunchmanifest.com</a></p>

				<h3>Schema Markup Resources</h3>
				<ul>
					<li><a href="https://www.youtube.com/channel/UCqVBXnwZ3YNf2BVP1jXcp6Q">Schema App Youtube Video Tutorials</a></li>
					<li><a href="https://www.schemaapp.com/getting-started/">Getting Started Guide</a></li>
					<li><a href="https://www.schemaapp.com/tutorial/how-to-do-schema-markup-for-local-business/">Ultimate Guide to Local Business Schema Markup</a></li>
					<li><a href="https://search.google.com/structured-data/testing-tool/u/0/">Google Structured Data Testing Tool</a></li>
				</ul>
            </section>
            <section id="schema-app-settings">
                <form method="post" action="options.php">
                <?php
                    // This prints out all hidden setting fields
                    settings_fields( 'schema_option_group' );   
                    do_settings_sections( 'schema-app-setting' ); 
                    submit_button(); 
                ?>
                </form>
            </section>
            <!--
            <section id="schema-app-report"/>
            -->
            <section id="schema-app-license">   
                <form method="post" action="options.php">

                    <?php 
                    settings_fields( 'schema_option_group_license' );   
                    do_settings_sections( 'schema-app-license' ); 
                    ?>
                    <?php submit_button(); ?>
                </form>
            </section>

			<?php if ( function_exists( 'genesis' ) ) : ?>
				<section id="schema-app-settings-genesis">
					<form method="post" action="options.php">
						<?php
							settings_fields( 'schema_option_group_genesis' );
							do_settings_sections( 'schema-app-genesis' );
							submit_button(); 
						?>
					</form>
				</section>
			<?php endif; ?>

			<?php do_action( 'hunch_schema_settings_nav_tab_content' ); ?>

        </div>
        <?php
    }   

    /**
     * Register javascript for media upload (Publisher Logo)
     */
    public function admin_assets($hook) {

        if ( 'settings_page_schema-app-setting' == $hook )
        {
			// Javascript
			wp_enqueue_media(); 
			wp_enqueue_script('schema-admin-funcs', $this->PluginURL.'js/schemaAdmin.js', array('jquery','media-editor'), '20160928');
			$tab = isset($_GET['tab']) ? $_GET['tab'] : 'schema-app-settings';
			wp_localize_script( 'schema-admin-funcs', 'schemaData', array(
				'tab' => $tab,
			));
			// CSS Styles
			wp_enqueue_style( 'schema-admin-style', $this->PluginURL.'css/schemaStyle.css' );
        }
    }
    
    /**
     * Register and add settings
     */
    public function page_init() {      

        ////
        // Schema App Settings Page
        register_setting(
            'schema_option_group', // Option group
            'schema_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        
        add_settings_section(
            'plugin_settings', // ID
            'Plugin Setup', // Title
            array( $this, 'print_section_plugin' ), // Callback
            'schema-app-setting' // Page
        );  
        add_settings_section(
            'publisher_settings', // ID
            'Publisher Settings', // Title
            array( $this, 'print_section_publisher' ), // Callback
            'schema-app-setting' // Page
        );  

        // Plugin Graph ID (account name)
        add_settings_field(
            'graph_uri', // ID
            'Account ID', // Title 
            array( $this, 'graph_uri_callback' ), // Callback
            'schema-app-setting', // Page
            'plugin_settings' // Section           
        );     

		// Arguments: Settings Name, Settings Page, Settings Section
		do_action( 'hunch_schema_settings_section', 'schema_option_name', 'schema-app-setting', 'plugin_settings' );

        // Publisher Settings        
        add_settings_field(
            'publisher_type', // ID
            'Publisher Type', // Title 
            array( $this, 'publisher_type_callback' ), // Callback
            'schema-app-setting', // Page
            'publisher_settings' // Section           
        );      
        add_settings_field(
            'publisher_name', // ID
            'Publisher Name', // Title 
            array( $this, 'publisher_name_callback' ), // Callback
            'schema-app-setting', // Page
            'publisher_settings' // Section           
        );      
        add_settings_field(
            'publisher_image', // ID
            'Publisher Logo', // Title 
            array( $this, 'publisher_image_callback' ), // Callback
            'schema-app-setting', // Page
            'publisher_settings' // Section           
        );      

		// Arguments: Settings Name, Settings Page, Settings Section
		do_action( 'hunch_schema_settings_section', 'schema_option_name', 'schema-app-setting', 'publisher_settings' );


		add_settings_section( 'schema-default', 'Schema Default Settings', null, 'schema-app-setting' );  
		add_settings_field( 'SchemaDefaultLocation', 'Location where to put the schema markup', array( $this, 'SettingsFieldSchemaDefaultLocation' ), 'schema-app-setting', 'schema-default' );
		add_settings_field( 'SchemaDefaultTypePost', 'Post Default Schema Type', array( $this, 'SettingsFieldSchemaDefaultTypePost' ), 'schema-app-setting', 'schema-default' );
		add_settings_field( 'SchemaDefaultTypePage', 'Page Default Schema Type', array( $this, 'SettingsFieldSchemaDefaultTypePage' ), 'schema-app-setting', 'schema-default' );
		add_settings_field( 'SchemaDefaultImage', 'Default Image', array( $this, 'SettingsFieldSchemaDefaultImage' ), 'schema-app-setting', 'schema-default' );

		// Arguments: Settings Name, Settings Page, Settings Section
		do_action( 'hunch_schema_settings_section', 'schema_option_name', 'schema-app-setting', 'schema-default' );


		add_settings_section( 'schema', 'Other Schema Options', null, 'schema-app-setting' );  
		add_settings_field( 'ToolbarShowTestSchema', 'Show Test Schema', array( $this, 'SettingsFieldSchemaShowTestSchema' ), 'schema-app-setting', 'schema' );      
		add_settings_field( 'SchemaBreadcrumb', 'Show Breadcrumb', array( $this, 'SettingsFieldSchemaBreadcrumb' ), 'schema-app-setting', 'schema' );      
		add_settings_field( 'SchemaWebSite', 'Show WebSite', array( $this, 'SettingsFieldSchemaWebSite' ), 'schema-app-setting', 'schema' );      
		add_settings_field( 'SchemaLinkedOpenData', 'Linked Open Data', array( $this, 'SettingsFieldSchemaLinkedOpenData' ), 'schema-app-setting', 'schema' );      
		add_settings_field( 'SchemaRemoveMicrodata', 'Remove Microdata', array( $this, 'SettingsFieldSchemaRemoveMicrodata' ), 'schema-app-setting', 'schema' );      
		add_settings_field( 'SchemaRemoveWPSEOMarkup', 'Remove WPSEO Markup', array( $this, 'SettingsFieldSchemaRemoveWPSEOMarkup' ), 'schema-app-setting', 'schema' );      

		// Arguments: Settings Name, Settings Page, Settings Section
		do_action( 'hunch_schema_settings_section', 'schema_option_name', 'schema-app-setting', 'schema' );


        //// Schema App License Page
        // License Information
        register_setting(
            'schema_option_group_license', // Option group
            'schema_option_name_license', // Option name
            array( $this, 'sanitize_license' ) // Sanitize
        );
        add_settings_section(
            'license_settings', // ID
            'License Settings', // Title
            array( $this, 'print_section_license' ), // Callback
            'schema-app-license' // Page
        );
        add_settings_field(
            'schema_license_wc',                    // ID
            'Schema App WooCommerce License',                   // Title 
            array( $this, 'schema_license_wc_callback' ),    // Callback
            'schema-app-license',                   // Page or Tab
            'license_settings'                      // Section           
        );     
 
        add_settings_field(
            'schema_license_wc_status',                    // ID
            'Schema App WooCommerce Status',                   // Title 
            array( $this, 'schema_license_wc_status_callback' ),    // Callback
            'schema-app-license',                   // Page or Tab
            'license_settings'                      // Section           
        );      

		// Arguments: Settings Name, Settings Page, Settings Section
		do_action( 'hunch_schema_settings_section', 'schema_option_name', 'schema-app-license', 'license_settings' );

		// Genesis
        register_setting(
            'schema_option_group_genesis',      // Option group
            'schema_option_name_genesis',     // Option name
            array( $this, 'sanitize_genesis' )  // Sanitize
        );

        add_settings_section(
            'plugin_settings_genesis', // ID
            'Genesis Settings', // Title
            array( $this, 'print_section_genesis' ), // Callback
            'schema-app-genesis' // Page
        );  
        
//      genesis_attr_search-form
        add_settings_field(
            'search-form', // ID
            'http://schema.org/SearchAction', // Title 
            array( $this, 'search_form_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );      
                
//      genesis_attr_breadcrumb
        add_settings_field(
            'breadcrumb', // ID
            'http://schema.org/BreadcrumbList', // Title 
            array( $this, 'breadcrumb_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );      
        
//      genesis_attr_head
        add_settings_field(
            'head', // ID
            'http://schema.org/WebSite', // Title 
//            'http://schema.org/WebSite <br/>Head', // Title 
            array( $this, 'head_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );      
        
//      genesis_attr_body
        add_settings_field(
            'body', // ID
            'http://schema.org/WebPage', // Title 
//            'http://schema.org/WebPage <br/>Body', // Title 
            array( $this, 'body_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );      

//        genesis_attr_site-header
        add_settings_field(
            'site-header', // ID
            'http://schema.org/WPHeader', // Title 
//            'http://schema.org/WPHeader <br/>Site header', // Title 
            array( $this, 'site_header_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );

//        genesis_attr_nav-primary
        add_settings_field(
            'nav-primary', // ID
            'http://schema.org/SiteNavigationElement', // Title 
//            'http://schema.org/SiteNavigationElement <br/>Primary navigation', // Title 
            array( $this, 'nav_primary_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );
                
//        genesis_attr_entry
        add_settings_field(
            'entry', // ID
            'http://schema.org/CreativeWork', // Title 
//            'http://schema.org/CreativeWork <br/>Entry', // Title 
            array( $this, 'entry_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );
        
        // genesis_attr_sidebar-primary
         add_settings_field(
            'sidebar-primary', // ID
            'http://schema.org/WPSideBar', // Title 
//            'http://schema.org/WPSideBar <br/>Primary sidebar', // Title 
            array( $this, 'sidebar_primary_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );

//        genesis_attr_site-footer
         add_settings_field(
            'site-footer', // ID
            'http://schema.org/WPFooter', // Title 
//            'http://schema.org/WPFooter <br/>Site footer', // Title 
            array( $this, 'site_footer_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );
         
//      genesis_attr_comment         
        add_settings_field(
            'comment', // ID
//            'http://schema.org/Comment <br/>Comments', // Title 
            'http://schema.org/Comment', // Title 
            array( $this, 'comment_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );
       
//      genesis_attr_comment-author
        add_settings_field(
            'comment-author', // ID
            'http://schema.org/Person', // Title 
//            'http://schema.org/Person <br/>Comment author', // Title 
            array( $this, 'comment_author_callback_genesis' ), // Callback
            'schema-app-genesis', // Page
            'plugin_settings_genesis' // Section           
        );
  
  
  		if ( empty( $this->Settings['Version'] ) || version_compare( $this->Settings['Version'], $this->PluginVersion, '<' ) )
		{
			$this->PluginActivate();
		}

    }
    
    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ) {
        $new_input = array();
        
        if ( isset( $input['graph_uri'] ) )
        {
            $new_input['graph_uri'] = sanitize_text_field( $input['graph_uri'] );

			if ( $this->Settings['graph_uri'] != $new_input['graph_uri'] )
			{
				$APISubDomain = ( substr( $_SERVER['SERVER_NAME'], 0, 3 ) === 'dev' ) ? 'dev' : '';

				wp_remote_get( sprintf( 'https://api%s.hunchmanifest.com/utility/template?template=http://hunchmanifest.com/ontology/schemarules#AddSiteAccount&accountId=%s&siteUrl=%s&software=Wordpress', $APISubDomain, $new_input['graph_uri'], site_url() ), array( 'timeout' => 15, 'sslverify' => false ) );
			}

			// Arguments: Settings Field, Old Value, New Value
			do_action( 'hunch_schema_settings_sanitize', 'graph_uri', ( isset( $this->Settings['graph_uri'] ) ? $this->Settings['graph_uri'] : '' ), $new_input['graph_uri'] );
		}


		foreach ( array( 'publisher_type', 'publisher_name', 'publisher_image', 'SchemaDefaultLocation', 'SchemaDefaultTypePost', 'SchemaDefaultTypePage', 'SchemaDefaultImage', 'ToolbarShowTestSchema', 'SchemaBreadcrumb', 'SchemaWebSite', 'SchemaLinkedOpenData', 'SchemaRemoveMicrodata', 'SchemaRemoveWPSEOMarkup', 'Version', 'NoticeDismissWooCommerceAddon' ) as $FieldName )
		{
			if ( isset( $input[$FieldName] ) && $input[$FieldName] != '' )
			{
				$new_input[$FieldName] = sanitize_text_field( $input[$FieldName] );

				// Arguments: Settings Field, Old Value, New Value
				do_action( 'hunch_schema_settings_sanitize', $FieldName, ( isset( $this->Settings[$FieldName] ) ? $this->Settings[$FieldName] : '' ), $new_input[$FieldName] );
			}
		}


        return $new_input;
    }
    
    /**
     * sanitize_license
     * @param type $input
     * @return type
     */
    public function sanitize_license( $input ) {
        $new_input = array();

        if ( ! empty( $input['schema_license_wc'] ) )
        {
            $new_input['schema_license_wc'] = sanitize_text_field( $input['schema_license_wc'] );
		}

		if ( ! empty( $input['schema_license_wc_status'] ) )
		{
			$new_input['schema_license_wc_status'] = sanitize_text_field( $input['schema_license_wc_status'] );
		}

        if ( ! empty( $new_input['schema_license_wc'] ) )
		{
			$SchemaServer = new SchemaServer();

			$Response = $SchemaServer->activateLicense( array( 'license' => $new_input['schema_license_wc'], 'item_name' => urlencode( SchemaSettings::SCHEMA_ITEM_NAME ), 'url' => home_url() ) );

			if ( $Response[0] == true )
			{
				$new_input['schema_license_wc_status'] = 'Active';

				add_settings_error( 'schema_wc_activation_err', esc_attr( 'settings_updated' ), $Response[1], 'updated' );
			}
			else
			{
				$new_input['schema_license_wc_status'] = 'Inactive';

				add_settings_error( 'schema_wc_activation_err', esc_attr( 'settings_updated' ), $Response[1] . ". Visit <a target='_blank' href='http://app.schemaapp.com/licenses'>Schema App Licenses</a> for more information", 'error' );
			}
		}

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_plugin() {
        print "<p>By default the Schema App Tools creates <a target='_blank' href='https://www.schemaapp.com/wordpress-plugin/'>basic structured data</a> for all pages and posts. ";
        print "For greater organic search results, add additional structured data to your content with <a target='_blank' href='https://www.schemaapp.com/schema-org-json-ld-markup-editor/'>Schema App</a>. Schema App generates and automatically deploys schema.org markup from your inputs. <a href='https://www.schemaapp.com/product-pricing/'> Register with Schema App</a>. ";
        print "Once registered, add your Account ID to connect Schema App to wordpress for automated code deployment.</p>";
    }
    
    /** 
     * Print the Section text
     */
    public function print_section_publisher() {
        print '<p>Publisher information is required for AMP Articles and used in Page and Post structured data.</p>';       
    }
    
    /** 
     * Print the Section text
     */
    public function print_section_license() {
        print '<p>License Information required for WooCommerce schema.org structured data.</p>';       
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function graph_uri_callback() {
        printf(
            '<input type="text" id="graph_uri" name="schema_option_name[graph_uri]" value="%s" class="regular-text" />',
            isset( $this->Settings['graph_uri'] ) ? esc_attr( $this->Settings['graph_uri']) : ''
        );
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function publisher_type_callback() {
        $pubTypeSelect = 
            '<select type="text" id="publisher_type" name="schema_option_name[publisher_type]" class="regular-text" />' . 
            '<option value="">Please choose whether you are a company or person</option>';

        if ( isset( $this->Settings['publisher_type'] ) ) {
            if ( $this->Settings['publisher_type'] == "Organization" ) {
                $pubTypeSelect .= 
                    '<option value="Organization" selected="selected">Organization</option>' .
                    '<option value="Person">Person</option>';
            } else {
                $pubTypeSelect .= 
                    '<option value="Organization">Organization</option>' . 
                    '<option value="Person" selected="selected">Person</option>';
            }
        } else { 
            $pubTypeSelect .=
                '<option value="Organization">Organization</option>' .
                '<option value="Person">Person</option>';            
        }
        $pubTypeSelect .= '</select>';
        echo $pubTypeSelect;
        
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function publisher_name_callback() {
        printf(
            '<input type="text" id="publisher_name" name="schema_option_name[publisher_name]" value="%s" class="regular-text" />',
            isset( $this->Settings['publisher_name'] ) ? esc_attr( $this->Settings['publisher_name']) : ''
        );
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function publisher_image_callback() {
        $imageHtml = '<div class="uploader">';
        $imageVal = "";
        if ( isset( $this->Settings['publisher_image'] ) ) {
            $imageVal = esc_attr( $this->Settings['publisher_image']);
        }
        $imageHtml .= '<input id="publisher_image" class="regular-text" name="schema_option_name[publisher_image]" value="'. $imageVal . '" title="'. $imageVal . '" type="text" />';        
        $imageHtml .= '<button id="publisher_image_button" class="button">Select</button>';
        $imageHtml .= '<ul style="list-style: inherit; padding-left: 25px;"><li>Logos should have a wide aspect ratio, not a square icon.</li>';
        $imageHtml .= '<li>Logos should be no wider than 600px, and no taller than 60px.</li>';
        $imageHtml .= '<li>Always retain the original aspect ratio of the logo when resizing. Ideally, logos are exactly 60px tall with width <= 600px. If maintaining a height of 60px would cause the width to exceed 600px, downscale the logo to exactly 600px wide and reduce the height accordingly below 60px to maintain the original aspect ratio.</li>';
        $imageHtml .= '</ul></div>';
        
        echo $imageHtml;

    }


	public function SettingsFieldSchemaDefaultLocation( $Options )
	{
		$Value = ! empty ( $this->Settings['SchemaDefaultLocation'] ) ? esc_attr( $this->Settings['SchemaDefaultLocation'] ) : 'Header';

		?>

			<select name="schema_option_name[SchemaDefaultLocation]">
				<option value="Header" <?php selected( $Value, 'Header' ); ?>>Header</option>
				<option value="Footer" <?php selected( $Value, 'Footer' ); ?>>Footer</option>
			</select>

		<?php
	}


	public function SettingsFieldSchemaDefaultTypePost( $Options )
	{
		$Value = ! empty ( $this->Settings['SchemaDefaultTypePost'] ) ? esc_attr( $this->Settings['SchemaDefaultTypePost'] ) : '';

		?>

			<select name="schema_option_name[SchemaDefaultTypePost]">
				<option value="">Blog Posting</option>
				<option value="Article" <?php selected( $Value, 'Article' ); ?>>Article</option>
				<option value="LiveBlogPosting" <?php selected( $Value, 'LiveBlogPosting' ); ?>>&nbsp; Live Blog Posting</option>
				<option value="NewsArticle" <?php selected( $Value, 'NewsArticle' ); ?>>News Article</option>
				<option value="Report" <?php selected( $Value, 'Report' ); ?>>Report</option>
				<option value="ScholarlyArticle" <?php selected( $Value, 'ScholarlyArticle' ); ?>>Scholarly Article</option>
				<option value="MedicalScholarlyArticle" <?php selected( $Value, 'MedicalScholarlyArticle' ); ?>>&nbsp; Medical Scholarly Article</option>
				<option value="SocialMediaPosting" <?php selected( $Value, 'SocialMediaPosting' ); ?>>Social Media Posting</option>
				<option value="DiscussionForumPosting" <?php selected( $Value, 'DiscussionForumPosting' ); ?>>&nbsp; Discussion Forum Posting</option>
				<option value="TechArticle" <?php selected( $Value, 'TechArticle' ); ?>>Tech Article</option>
				<option value="APIReference" <?php selected( $Value, 'APIReference' ); ?>>&nbsp; API Reference</option>
			</select>

		<?php
	}


	public function SettingsFieldSchemaDefaultTypePage( $Options )
	{
		$Value = ! empty ( $this->Settings['SchemaDefaultTypePage'] ) ? esc_attr( $this->Settings['SchemaDefaultTypePage'] ) : '';

		?>

			<select name="schema_option_name[SchemaDefaultTypePage]">
				<option value="">Article</option>
				<option value="BlogPosting" <?php selected( $Value, 'BlogPosting' ); ?>>Blog Posting</option>
				<option value="LiveBlogPosting" <?php selected( $Value, 'LiveBlogPosting' ); ?>>&nbsp; Live Blog Posting</option>
				<option value="NewsArticle" <?php selected( $Value, 'NewsArticle' ); ?>>News Article</option>
				<option value="Report" <?php selected( $Value, 'Report' ); ?>>Report</option>
				<option value="ScholarlyArticle" <?php selected( $Value, 'ScholarlyArticle' ); ?>>Scholarly Article</option>
				<option value="MedicalScholarlyArticle" <?php selected( $Value, 'MedicalScholarlyArticle' ); ?>>&nbsp; Medical Scholarly Article</option>
				<option value="SocialMediaPosting" <?php selected( $Value, 'SocialMediaPosting' ); ?>>Social Media Posting</option>
				<option value="DiscussionForumPosting" <?php selected( $Value, 'DiscussionForumPosting' ); ?>>&nbsp; Discussion Forum Posting</option>
				<option value="TechArticle" <?php selected( $Value, 'TechArticle' ); ?>>Tech Article</option>
				<option value="APIReference" <?php selected( $Value, 'APIReference' ); ?>>&nbsp; API Reference</option>
			</select>

		<?php
	}


	public function SettingsFieldSchemaDefaultImage( $Options )
	{
		$Value = empty ( $this->Settings['SchemaDefaultImage'] ) ? "" : esc_attr( $this->Settings['SchemaDefaultImage'] );
		print '<input id="SchemaDefaultImage" class="regular-text" type="text" name="schema_option_name[SchemaDefaultImage]" value="' . $Value . '" title="' . $Value . '"> <button id="SchemaDefaultImageSelect" class="button">Select</button>';
		print '<p>Default image for BlogPosting (Posts) or Article (Pages) when none is available.</p>';
	}


	public function SettingsFieldSchemaShowTestSchema( $Options )
	{
		$Value = empty( $this->Settings['ToolbarShowTestSchema'] ) ? 0 : $this->Settings['ToolbarShowTestSchema'];

		print '<input type="checkbox" name="schema_option_name[ToolbarShowTestSchema]" value="1" ' . checked( 1, $Value, false ) . '>';
		print '<p>Add a "Test Schema" button to the top of your Wordpress pages when in edit mode to test schema markup in <a href="https://search.google.com/structured-data/testing-tool" target="_blank">Structured Data Testing Tool</a></p>';
	}
    

	public function SettingsFieldSchemaBreadcrumb( $Options )
	{
		$Value = empty( $this->Settings['SchemaBreadcrumb'] ) ? 0 : $this->Settings['SchemaBreadcrumb'];

		print '<input type="checkbox" name="schema_option_name[SchemaBreadcrumb]" value="1" ' . checked( 1, $Value, false ) . '>';
		print '<p>Add Schema.org <a href="https://developers.google.com/search/docs/data-types/breadcrumbs" target="_blank">Breadcrumb</a> Markup to your pages.</p>';
	}
    

	public function SettingsFieldSchemaWebSite( $Options )
	{
		$Value = empty( $this->Settings['SchemaWebSite'] ) ? 0 : $this->Settings['SchemaWebSite'];

		print '<input type="checkbox" name="schema_option_name[SchemaWebSite]" value="1" ' . checked( 1, $Value, false ) . '>';
		print '<p>Add <a href="https://schema.org/WebSite" target="_blank">WebSite</a> Markup to your homepage to enable <a href="https://developers.google.com/search/docs/data-types/sitelinks-searchbox" target="_blank">Site Search</a> and <a href="https://developers.google.com/search/docs/data-types/sitename" target="_blank">Site Name</a> features.</p>';
	}
    

	public function SettingsFieldSchemaLinkedOpenData( $Options )
	{
		$Value = empty( $this->Settings['SchemaLinkedOpenData'] ) ? 0 : $this->Settings['SchemaLinkedOpenData'];

		print '<input type="checkbox" name="schema_option_name[SchemaLinkedOpenData]" value="1" ' . checked( 1, $Value, false ) . '>';
		print '<p>Publish website schema.org data items as Linked Open Data</p>';
	}


	public function SettingsFieldSchemaRemoveMicrodata( $Options )
	{
		$Value = empty( $this->Settings['SchemaRemoveMicrodata'] ) ? 0 : $this->Settings['SchemaRemoveMicrodata'];

		print '<input type="checkbox" name="schema_option_name[SchemaRemoveMicrodata]" value="1" ' . checked( 1, $Value, false ) . '>';
		print '<p>Remove Microdata from header and content.</p>';
	}


	public function SettingsFieldSchemaRemoveWPSEOMarkup( $Options )
	{
		// Default enabled
		$Value = ( isset( $this->Settings['SchemaRemoveWPSEOMarkup'] ) && $this->Settings['SchemaRemoveWPSEOMarkup'] == 0 ) ? 0 : 1;

		?>

			<select name="schema_option_name[SchemaRemoveWPSEOMarkup]">
				<option value="1" <?php selected( $Value, 1 ); ?>>Enabled</option>
				<option value="0" <?php selected( $Value, 0 ); ?>>Disabled</option>
			</select>
			<p>Remove Website and Person/Company JSON/LD markup.</p>

		<?php

	}


    /** 
     * Get the settings option array and print one of its values
     */
    public function schema_license_wc_callback() {
        printf(
            '<input type="text" id="schema_license_wc" name="schema_option_name_license[schema_license_wc]" value="%s" class="regular-text" />',
            isset( $this->license['schema_license_wc'] ) ? esc_attr( $this->license['schema_license_wc']) : ''
        );
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function schema_license_wc_status_callback() {
        printf(
            '<input type="text" id="schema_license_wc_status" disabled="on" name="schema_option_name_license[schema_license_wc_status]" value="%s" class="regular-text" />',
            isset( $this->license['schema_license_wc_status'] ) ? esc_attr( $this->license['schema_license_wc_status'] ) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback() {
        printf(
            '<input type="text" id="title" name="schema_option_name[title]" value="%s" />',
            isset( $this->Settings['title'] ) ? esc_attr( $this->Settings['title']) : ''
        );
    }


    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_genesis( $input )
    {
        $new_input = array();
        
        if( isset( $input['search-form'] ) )
            $new_input['search-form'] = absint( $input['search-form'] );
        
        if( isset( $input['breadcrumb'] ) ) {
            $new_input['breadcrumb'] = absint( $input['breadcrumb'] );
            $new_input['breadcrumb-link-wrap'] = absint( $input['breadcrumb'] );            
        }
        
        if( isset( $input['head'] ) )
            $new_input['head'] = absint( $input['head'] );
        
        if( isset( $input['body'] ) )
            $new_input['body'] = absint( $input['body'] );
        
        if( isset( $input['site-header'] ) )
            $new_input['site-header'] = absint( $input['site-header'] );
        
        if( isset( $input['nav-primary'] ) ) {
            $new_input['nav-primary'] = absint( $input['nav-primary'] );
            $new_input['nav-secondary'] = absint( $input['nav-primary'] );
            $new_input['nav-header'] = absint( $input['nav-primary'] );            
        }
        
        if( isset( $input['content'] ) )
            $new_input['content'] = absint( $input['content'] );
        
        if( isset( $input['entry'] ) )
            $new_input['entry'] = absint( $input['entry'] );
        
        if( isset( $input['sidebar-primary'] ) )
            $new_input['sidebar-primary'] = absint( $input['sidebar-primary'] );
        
        if( isset( $input['site-footer'] ) )
            $new_input['site-footer'] = absint( $input['site-footer'] );
        
        if( isset( $input['comment'] ) )
            $new_input['comment'] = absint( $input['comment'] );
        
        if( isset( $input['comment-author'] ) )
            $new_input['comment-author'] = sanitize_text_field( $input['comment-author'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_genesis()
    {
        print 'Choose which schema.org markup to remove from Genesis Themes:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function body_callback_genesis() {
        $value = empty( $this->SettingsGenesis['body'] ) ? 0 : $this->SettingsGenesis['body'];
        print '<input type="checkbox" name="schema_option_name_genesis[body]" value="1" ' . checked( 1, $value, false ) . '>';         
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function breadcrumb_callback_genesis() {
        $value = empty( $this->SettingsGenesis['breadcrumb'] ) ? 0 : $this->SettingsGenesis['breadcrumb'];
        print '<input type="checkbox" name="schema_option_name_genesis[breadcrumb]" value="1" ' . checked( 1, $value, false ) . '>';      
        print '<input type="checkbox" style="display:none;" name="schema_option_name_genesis[breadcrumb-link-wrap]" value="1" ' . checked( 1, $value, false ) . '>';         
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function search_form_callback_genesis() {
        $value = empty( $this->SettingsGenesis['search-form'] ) ? 0 : $this->SettingsGenesis['search-form'];
        print '<input type="checkbox" name="schema_option_name_genesis[search-form]" value="1" ' . checked( 1, $value, false ) . '>';         
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function head_callback_genesis() {
        $value = empty( $this->SettingsGenesis['head'] ) ? 0 : $this->SettingsGenesis['head'];
        print '<input type="checkbox" name="schema_option_name_genesis[head]" value="1" ' . checked( 1, $value, false ) . '>';         
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function site_header_callback_genesis()
    {
        $value = empty( $this->SettingsGenesis['site-header'] ) ? 0 : $this->SettingsGenesis['site-header'];
        print '<input type="checkbox" name="schema_option_name_genesis[site-header]" value="1" ' . checked( 1, $value, false ) . '>';         
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function nav_primary_callback_genesis()
    {
        $value = empty( $this->SettingsGenesis['nav-primary'] ) ? 0 : $this->SettingsGenesis['nav-primary'];
        print '<input type="checkbox" name="schema_option_name_genesis[nav-primary]" value="1" ' . checked( 1, $value, false ) . '>';         
        // Also control navigation elements in secondary or footer menus
        print '<input type="checkbox" style="display:none;" name="schema_option_name_genesis[nav-secondary]" value="1" ' . checked( 1, $value, false ) . '>';         
        print '<input type="checkbox" style="display:none;" name="schema_option_name_genesis[nav-header]" value="1" ' . checked( 1, $value, false ) . '>';         

    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function entry_callback_genesis()
    {
        $value = empty( $this->SettingsGenesis['entry'] ) ? 0 : $this->SettingsGenesis['entry'];
        print '<input type="checkbox" name="schema_option_name_genesis[entry]" value="1" ' . checked( 1, $value, false ) . '>';         
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function sidebar_primary_callback_genesis()
    {
        $value = empty( $this->SettingsGenesis['sidebar-primary'] ) ? 0 : $this->SettingsGenesis['sidebar-primary'];
        print '<input type="checkbox" name="schema_option_name_genesis[sidebar-primary]" value="1" ' . checked( 1, $value, false ) . '>';         
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function site_footer_callback_genesis()
    {
        $value = empty( $this->SettingsGenesis['site-footer'] ) ? 0 : $this->SettingsGenesis['site-footer'];
        print '<input type="checkbox" name="schema_option_name_genesis[site-footer]" value="1" ' . checked( 1, $value, false ) . '>';         
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        $value = empty( $this->SettingsGenesis['id_number'] ) ? 0 : $this->SettingsGenesis['id_number'];
        print '<input type="checkbox" name="schema_option_name_genesis[id_number]" value="1" ' . checked( 1, $value, false ) . '>';         
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function comment_callback_genesis()
    {
        $value = empty( $this->SettingsGenesis['comment'] ) ? 0 : $this->SettingsGenesis['comment'];
        print '<input type="checkbox" name="schema_option_name_genesis[comment]" value="1" ' . checked( 1, $value, false ) . '>';         
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function comment_author_callback_genesis()
    {
        $value = empty( $this->SettingsGenesis['comment-author'] ) ? 0 : $this->SettingsGenesis['comment-author'];
        print '<input type="checkbox" name="schema_option_name_genesis[comment-author]" value="1" ' . checked( 1, $value, false ) . '>';         
    }


    // meta box on post/page
    public function meta_box($data) {
        $value = $this->load_post_meta($data->ID);
        ?>
        <table id="dt-page-definition" width="100%" cellspacing="5px">
            <tr valign="top">
                <td style="width:20%;"><label for="dt-heading"><?php _e( 'Subtitle:', FB_DT_TEXTDOMAIN ); ?></label></td>
                <td><input type="text" id="dt-heading" name="dt-heading" class="heading form-input-tip" size="16" autocomplete="off" value="<?php echo $value['heading']; ?>" tabindex="6" style="width:99.5%"/></td>
            </tr>
            <tr valign="top">
                <td><label for="dt-additional-info"><?php _e( 'Additional information:', FB_DT_TEXTDOMAIN ); ?></label></td>
                <td><textarea cols="16" rows="5" id="dt-additional-info" name="dt-additional-info" class="additional-info form-input-tip code" size="20" autocomplete="off" tabindex="6" style="width:90%"/><?php echo wpautop( $value['additional-info'] ); ?></textarea>
                    <table id="post-status-info" cellspacing="0" style="line-height: 24px;">
                        <tbody>
                            <tr>
                                <td> </td>
                                <td> </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr valign="top">
                <td><label for="dt-listdata"><?php _e( 'Listdata:', FB_DT_TEXTDOMAIN ); ?></label></td>
                <td><textarea cols="16" rows="10" id="dt-listdata" name="dt-listdata" class="listdata form-input-tip" size="20" autocomplete="off" tabindex="6" style="width:99.5%"/><?php echo $value['listdata']; ?></textarea><br /><small><?php _e( 'One list per line', FB_DT_TEXTDOMAIN ) ?></small></td>
            </tr>
        </table>
        <?php
    }

    /**
     * Admin nags for Graph and Publisher Setting Setup
     */
    public function admin_nag_set() {
        if ( current_user_can( 'manage_options' ) ) {
            $graphNotice = isset( $this->Settings['schema_ignore_notice_graph'] ) ? esc_attr( $this->Settings['schema_ignore_notice_graph']) : '';
            $pubNotice = isset( $this->Settings['schema_ignore_notice_publisher'] ) ? esc_attr( $this->Settings['schema_ignore_notice_publisher']) : '';
            if (empty($this->Settings['graph_uri']) && $graphNotice !== '1') {            
                $hide_url = add_query_arg( 'schema_ignore_notice_graph', '0' );
                $message = "Setup Schema App Structured Data with <a href='" . admin_url( 'options-general.php?page=schema-app-setting' ) . "'>Settings &#8594; Schema App</a> | <a id='hunch-schema-notice-dismiss' href='$hide_url'>Dismiss</a>";
                echo"<div class=\"update-nag hunch-schema-notice-dis\">$message</div>"; 
            } elseif (empty($this->Settings['publisher_type']) && $pubNotice !== '1') {
                $hide_url = add_query_arg( 'schema_ignore_notice_pub', '0' );
                $message = "Set Schema App Structured Data Publisher <a href='" . admin_url( 'options-general.php?page=schema-app-setting' ) . "'>Settings &#8594; Schema App</a> | <a id='hunch-schema-notice-dismiss' href='$hide_url'>Dismiss</a>";
                echo"<div class=\"update-nag hunch-schema-notice-dis\">$message</div>"; 
            }
        }
    }
 
    /**
     * 
     */
    public function admin_nag_handle() {
        
        if ( isset($_GET['schema_ignore_notice_graph']) && '0' == $_GET['schema_ignore_notice_graph'] ) {
            $this->Settings['schema_ignore_notice_graph'] = '1';
            update_option('schema_option_name', $this->Settings);
        }
        
        if ( isset($_GET['schema_ignore_notice_pub']) && '0' == $_GET['schema_ignore_notice_pub'] ) {
            $this->Settings['schema_ignore_notice_publisher'] = '1';
            update_option('schema_option_name', $this->Settings);
        }

    }

}