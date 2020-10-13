<?php
/**
 * Setup Schema wizard class
 *
 * Walkthrough to the basic setup upon installation
 *
 * @since 1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'admin_url', 'schema_wp_add_new_post_url', 10, 3 );
/**
 * Override "New Post" URL so that we can fire the wizard
 *
 * @since 1.0.0
 */
function schema_wp_add_new_post_url( $url, $path, $blog_id ) {
	
	// Global object containing current admin page
    global $pagenow;
	
	if ( $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
		
    	if ( $path == "post-new.php?post_type=schema" ) {
    	    $url = "admin.php?page=schema-setup-type&step=schema_type";
    	}
	}
	return $url;
}


if ( ! class_exists( 'Schema_WP_Setup_Schema_Wizard' ) ) :
/**
 * The class
 */
class Schema_WP_Setup_Schema_Wizard {
    /** @var string Currenct Step */
    protected $step   = '';

    /** @var array Steps for the setup wizard */
    protected $steps  = array();

    /**
     * Hook in tabs.
     */
    public function __construct() {
        if ( current_user_can( 'manage_options' ) ) {
            add_action( 'admin_menu', array( $this, 'admin_menus' ) );
			add_action( 'admin_head', array( $this, 'hide_admin_menus' ) );
            add_action( 'admin_init', array( $this, 'setup_wizard' ), 99 );
		}
    }

    /**
     * Enqueue scripts & styles from woocommerce plugin.
     *
     * @return void
     */
    public function enqueue_scripts() {
        $suffix     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$suffix     = '';
		$url 		= SCHEMAPREMIUM_PLUGIN_URL . 'assets/vendors/woo-setup-wiz/';
		
        wp_register_script( 'jquery-blockui', $url . 'js/jquery-blockui/jquery.blockUI' . $suffix . '.js', array( 'jquery' ), '2.70', true );
        wp_register_script( 'selectWoo', $url . 'js/selectWoo/selectWoo.full' . $suffix . '.js', array( 'jquery' ), '1.0.1' );
        wp_register_script( 'wc-enhanced-select', $url . 'js/wc-enhanced-select' . $suffix . '.js', array( 'jquery', 'selectWoo' ), SCHEMAPREMIUM_VERSION );
        wp_localize_script( 'wc-enhanced-select', 'wc_enhanced_select_params', array(
            'i18n_matches_1'            => _x( 'One result is available, press enter to select it.', 'enhanced select', 'schema-premium' ),
            'i18n_matches_n'            => _x( '%qty% results are available, use up and down arrow keys to navigate.', 'enhanced select', 'schema-premium' ),
            'i18n_no_matches'           => _x( 'No matches found', 'enhanced select', 'schema-premium' ),
            'i18n_ajax_error'           => _x( 'Loading failed', 'enhanced select', 'schema-premium' ),
            'i18n_input_too_short_1'    => _x( 'Please enter 1 or more characters', 'enhanced select', 'schema-premium' ),
            'i18n_input_too_short_n'    => _x( 'Please enter %qty% or more characters', 'enhanced select', 'schema-premium' ),
            'i18n_input_too_long_1'     => _x( 'Please delete 1 character', 'enhanced select', 'schema-premium' ),
            'i18n_input_too_long_n'     => _x( 'Please delete %qty% characters', 'enhanced select', 'schema-premium' ),
            'i18n_selection_too_long_1' => _x( 'You can only select 1 item', 'enhanced select', 'schema-premium' ),
            'i18n_selection_too_long_n' => _x( 'You can only select %qty% items', 'enhanced select', 'schema-premium' ),
            'i18n_load_more'            => _x( 'Loading more results&hellip;', 'enhanced select', 'schema-premium' ),
            'i18n_searching'            => _x( 'Searching&hellip;', 'enhanced select', 'schema-premium' ),
            'ajax_url'                  => admin_url( 'admin-ajax.php' ),
        ) );
		
		//wp_enqueue_style( 'schema-wp-admin', SCHEMAPREMIUM_PLUGIN_URL . 'assets/css/admin' . $suffix . '.css', SCHEMAPREMIUM_VERSION );
        wp_enqueue_style( 'woocommerce_admin_styles', $url . 'css/admin.css', array(), SCHEMAPREMIUM_VERSION );
        wp_enqueue_style( 'wc-setup', $url . 'css/wc-setup.css', array( 'dashicons', 'install' ), SCHEMAPREMIUM_VERSION );
		
		wp_enqueue_style( 'schema-wp-setup', $url . 'css/schema-setup.css', SCHEMAPREMIUM_VERSION );

        wp_register_script( 'wc-setup', $url . 'js/wc-setup.js', array( 'jquery', 'wc-enhanced-select', 'jquery-blockui' ), SCHEMAPREMIUM_VERSION );
        wp_localize_script( 'wc-setup', 'wc_setup_params', array() );
		
		wp_register_script( 'schema-wp-setup', $url . 'js/schema-setup.js', array( 'jquery' ), SCHEMAPREMIUM_VERSION );
		wp_localize_script( 'schema-wp-setup', 'schema_wp_vars', array(
			//'post_id'                     => isset( $post->ID ) ? $post->ID : null,
			'post_id'                     => null,
			'schema_premium_version'           => SCHEMAPREMIUM_VERSION,
			'use_this_file'               => __( 'Use This File', 'schema-premium' ),
			'remove_text'                 => __( 'Remove', 'schema-premium' ),
			'new_media_ui'                => apply_filters( 'schema_wp_use_35_media_ui', 1 ),
			'unsupported_browser'         => __( 'We are sorry but your browser is not compatible with this kind of file upload. Please upgrade your browser.', 'schema-premium' ),
		));

   		 //wp_enqueue_style( 'load-fontawesome', SCHEMAPREMIUM_PLUGIN_URL . 'vendors/fontawesome/css/all.css', false ); 
    }
	
    /**
     * Add admin menus/screens.
     */
    public function admin_menus() {
        add_dashboard_page( __('Schema Type Setup', 'schema-premium'), __('Schema Type Wizard', 'schema-premium'), 'manage_options', 'schema-setup-type', '' );
    }
	
	/**
     * Hide admin menus/screens.
     */
    public function hide_admin_menus() {
        remove_submenu_page( 'index.php', 'schema-setup-type' );
    }
	
    /**
     * Show the setup wizard.
     */
    public function setup_wizard() {
        if ( empty( $_GET['page'] ) || 'schema-setup-type' !== $_GET['page'] ) {
            return;
        }
        $this->steps = array(
			'introduction' => array(
                'name'    =>  __( 'Introduction', 'schema-premium' ),
                'view'    => array( $this, 'schema_setup_introduction' ),
                'handler' => ''
            ),
			'schema_type' => array(
                'name'    =>  __( 'Schema', 'schema-premium' ),
                'view'    => array( $this, 'schema_setup_type' ),
                'handler' => array( $this, 'schema_setup_type_save' ),
            ),
            'next_steps' => array(
                'name'    =>  __( 'Complete Setup!', 'schema-premium' ),
                'view'    => array( $this, 'schema_setup_complete' ),
                'handler' => ''
            )
        );
        $this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

        $this->enqueue_scripts();

        if ( ! empty( $_POST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) { // WPCS: CSRF ok.
            call_user_func( $this->steps[ $this->step ]['handler'] );
		}
		
        ob_start();
        $this->setup_wizard_header();
        $this->setup_wizard_steps();
        $this->setup_wizard_content();
        $this->setup_wizard_footer();
        exit;
    }

    public function get_next_step_link() {
        $keys = array_keys( $this->steps );

        return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ] );
    }

    /**
     * Setup Wizard Header.
     */
    public function setup_wizard_header() {
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta name="viewport" content="width=device-width" />
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php _e( 'Schema &rsaquo; Setup Wizard', 'schema-premium' ); ?></title>
			<?php wp_print_scripts( 'wc-setup' ); ?>
            <?php wp_print_scripts( 'schema-wp-setup' ); ?>
            <?php do_action( 'admin_print_styles' ); ?>
            <?php do_action( 'admin_head' ); ?>
            <?php //do_action( 'dokan_setup_wizard_styles' ); ?>
			<style type="text/css">
                .wc-setup-steps {
                    justify-content: center;
                }
                .wc-setup-content a {
                    color: #3f51b5;
                }
                .wc-setup-steps li.active:before {
                    border-color: #3f51b5;
                }
                .wc-setup-steps li.active {
                    border-color: #3f51b5;
                    color: #3f51b5;
                }
                .wc-setup-steps li.done:before {
                    border-color: #3f51b5;
                }
                .wc-setup-steps li.done {
                    border-color: #3f51b5;
                    color: #3f51b5;
                }
                .wc-setup .wc-setup-actions .button-primary,
				.wc-setup .wc-setup-actions .button-primary,
				.wc-setup .wc-setup-actions .button-primary {
                    background: #3f51b5 !important;
                }
                .wc-setup .wc-setup-actions .button-primary:active,
				.wc-setup .wc-setup-actions .button-primary:focus,
				.wc-setup .wc-setup-actions .button-primary:hover {
                    background: #333 !important;
                    border-color: #333 !important;
                }
                .wc-setup-content .wc-setup-next-steps ul .setup-product a,
				.wc-setup-content .wc-setup-next-steps ul .setup-product a,
				.wc-setup-content .wc-setup-next-steps ul .setup-product a {
                    background: #3f51b5 !important;
                    box-shadow: inset 0 1px 0 rgba(255,255,255,.25),0 1px 0 #3f51b5;
                }
                .wc-setup-content .wc-setup-next-steps ul .setup-product a:active,
				.wc-setup-content .wc-setup-next-steps ul .setup-product a:focus,
				.wc-setup-content .wc-setup-next-steps ul .setup-product a:hover {
                    background: #333 !important;
                    border-color: #333 !important;
                    box-shadow: inset 0 1px 0 rgba(255,255,255,.25),0 1px 0 #333;
                }
                .wc-setup .wc-setup-actions .button-primary,
				.wc-setup-content .wc-setup-next-steps ul .setup-product a.button-primary  {
                    border-color: #3f51b5 !important;
					text-shadow: none !important;
                }
                .wc-setup-content .wc-setup-next-steps ul .setup-product a {
                    border-color: #3f51b5 !important;
                }
                ul.wc-wizard-payment-gateways li.wc-wizard-gateway
				.wc-wizard-gateway-enable input:checked+label:before {
                    background: #3f51b5 !important;
                    border-color: #3f51b5 !important;
                }
				.wc-wizard-service-item .wc-wizard-service-toggle,
				.wc-wizard-services-list-toggle .wc-wizard-service-toggle {
					border: 2px solid #3f51b5;
					background-color: #3f51b5;
				}
				.select2-container--default .select2-results__option--highlighted[aria-selected],
				.select2-container--default .select2-results__option--highlighted[data-selected] {
					background-color: #3f51b5;
				}
				.description {
					margin-top: 1.25em !important;
				}
				.wc-setup-next-steps-last li {
					padding: 0;
					line-height: 1.0;
				}
				.wc-setup-next-steps-last li span {
					float: left;
				}
	        </style>
        </head>
        <body class="wc-setup wp-core-ui">
            <?php
                $badge_url = SCHEMAPREMIUM_PLUGIN_URL . 'assets/images/schema-badge.png';
            ?>
            <h1 id="wc-logo"><a href="https://schema.press"><img src="<?php echo $badge_url; ?>" alt="<?php echo SCHEMAPREMIUM_PLUGINNAME; ?>" /></a></h1>
        <?php
    }

    /**
     * Setup Wizard Footer.
     */
    public function setup_wizard_footer() {
        ?>
            <?php if ( 'next_steps' === $this->step ) : ?>
                <a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url('edit.php?post_type=schema') ); ?>"><?php _e( 'Return to the WordPress Dashboard', 'schema-premium' ); ?></a>
            <?php endif; ?>
            </body>
        </html>
        <?php
    }

    /**
     * Output the steps.
     */
    public function setup_wizard_steps() {
        $ouput_steps = $this->steps;
        array_shift( $ouput_steps );
        ?>
        <ol class="wc-setup-steps">
            <?php foreach ( $ouput_steps as $step_key => $step ) : ?>
                <li class="<?php
                    if ( $step_key === $this->step ) {
                        echo 'active';
                    } elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
                        echo 'done';
                    }
                ?>"><?php echo esc_html( $step['name'] ); ?></li>
            <?php endforeach; ?>
        </ol>
        <?php
    }

    /**
     * Output the content for the current step.
     */
    public function setup_wizard_content() {
        echo '<div class="wc-setup-content schema-setup-content">';
        call_user_func( $this->steps[ $this->step ]['view'] );
        echo '</div>';
    }
	
    /**
     * Introduction step.
     */
    public function schema_setup_introduction() {
        ?>
        <h1><?php _e( 'Create New Schema Type', 'schema-premium' ); ?></h1>
        <p><?php _e( 'This step-by-step configuration wizard will take you though creating and enabling a new Schema type for your website content. <strong>It should take less than a minute!</strong>', 'schema-premium' ); ?></p>
        <p class="wc-setup-actions step">
            <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next"><?php _e( 'Let\'s Go!', 'schema-premium' ); ?></a>
            <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=schema' ) ); ?>" class="button button-large"><?php _e( 'Cancel', 'schema-premium' ); ?></a>
        </p>
        <?php
    }
	
	/**
     * Schema Type Select step.
     */
    public function schema_setup_type() {
        ?>
        <h1><?php _e( 'Select Schema Type', 'schema-premium' ); ?></h1>
        
        <p><?php //_e( 'Select Schema type that describes your content best.', 'schema-premium' ); ?></p>
        

        <form method="post">
            <table class="form-table">
                <tr>
                	<!-- <th scope="row"><label for="site_type"><?php //_e( 'Schema Type', 'schema-premium' ); ?></label></th>-->
                    <td><?php schema_wp_custom_meta_box_field( array(
						'label'	=> __('Schema Markup Type', 'schema-premium'), // <label>
						'desc'	=> __('Select Schema type which describes your content best', 'schema-premium'), // description
						'id'	=> 'type', // field id and name
						'class' => 'wc-enhanced-select',
						'type'	=> 'select', // type of field
						'options' => apply_filters( 'schema_wp_types', array ( /* Empty array of options */ ) ),
					)); ?></td>
                </tr>
            </table>
            <p class="wc-setup-actions step">
                <input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Continue', 'schema-premium' ); ?>" name="save_step" />
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=schema' ) ); ?>" class="button button-large button-next"><?php _e( 'Cancel', 'schema-premium' ); ?></a>
                <?php wp_nonce_field( 'schema-setup' ); ?>
            </p>
        </form>
        <?php
    }
	
	/**
     * Save store options.
     */
    public function schema_setup_type_save() {
        check_admin_referer( 'schema-setup' );

        $title        	= isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : 0;
		$schema_type	= isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : 0;
		
		// Get schema properties for this type
		$schema_default = schema_wp_get_default_schemas( $schema_type );
		
		// for debug
		//echo'<pre>';print_r( $schema_default);echo'</pre>';exit;
		
		$new_schema = array(
			'post_type'   => 'schema',
			'post_title'  => $title,
			'post_status' => 'publish',
			'meta_input'  => array(
				'_schema_type'			=> $schema_type,
				'_schema_comment'		=> $schema_default['comment'],
				'_schema_subtypes'		=> $schema_default['subtypes'],
				//'_schema_properties'	=> $schema_default['properties'],
			),
		);
		
		$post_id = wp_insert_post( $new_schema );
		
		$redirect_url = $this->get_next_step_link();
		
		if ( ! is_wp_error( $post_id ) ) {
			$redirect_url = add_query_arg( 'schema_id', $post_id, $redirect_url );
		}
		
		wp_redirect( esc_url_raw( $redirect_url ) );
        //wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }

    /**
     * Final step.
     */
    public function schema_setup_complete() {
		
		$post_id 		= isset( $_GET['schema_id'] ) ? sanitize_text_field( $_GET['schema_id'] ) : 0;
		$schema_type 	= get_post_meta( $post_id, '_schema_type', true );
		 
        ?>
        <h1><?php _e('Schema type','schema-premium'); echo ' <span style="color:#3f51b5">'.$schema_type . '</span> '; _e( 'has been created!', 'schema-premium' ); ?></h1>
		
        <p style="background:#f1f1f1;padding:20px;"><?php _e( 'To complete setup, set Location Rules and Properties for this Schema type to take effect and take care of all the needed technical optimization of your site content.', 'schema-premium' ); ?></b>
        
        <div class="wc-setup-next-steps">
            <div class="wc-setup-next-steps-first">
                <h2><?php _e( 'Next Steps', 'schema-premium' ); ?></h2>
                <ul>
                    <li class="setup-product"><a class="button button-primary button-large" href="<?php echo esc_url( admin_url( 'post.php?post='.$post_id.'&action=edit' ) ); ?>"><?php _e( 'Configure', 'schema-premium' ); echo ' '.$schema_type.' ';  _e( 'type!', 'schema-premium' )?></a></li>
                </ul>
            </div>
            
            <div class="wc-setup-next-steps-last">
                <h2><?php _e( 'Learn More', 'schema-premium' ); ?></h2>
                <ul>
                    <li><span class="dashicons dashicons-arrow-right"></span> <a href="https://schema.press/docs-premium/sub-type/" target="_blank"><?php _e( 'Configuring sub type', 'schema-premium' ); ?></a></li>
                    <li><span class="dashicons dashicons-arrow-right"></span> <a href="https://schema.press/docs-premium/target-location-rules/" target="_blank"><?php _e( 'Setup location rules', 'schema-premium' ); ?></a></li>
                    <li><span class="dashicons dashicons-arrow-right"></span> <a href="https://schema.press/docs-premium/properties/" target="_blank"><?php _e( 'Configuring properties', 'schema-premium' ); ?></a></li>
                    <li><span class="dashicons dashicons-arrow-right"></span> <a href="https://schema.press/docs-premium/" target="_blank"><?php _e( 'Plugin documentation', 'schema-premium' ); ?></a></li>  
                </ul>
            </div>
            
        </div>
        <?php
    }
}

endif;
