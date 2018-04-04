<?php
if(!class_exists('Prism_WP_Scripts')):
    
    /**
    * Class for handling styles and scripts
    */
    class Prism_WP_Scripts {
        
        private $prism_wp_settings_data; // Holds settings array
        
        /**
         * Initialize
         */
        public function __construct( $prism_wp_settings_data ) {
            
            // Inject dependencies
            $this->prism_wp_settings_data = $prism_wp_settings_data;
            
            add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend_scripts' ), $this->prism_wp_settings_data['script_priority'] );
            
        } // end constructor
        
        /**
         * Scripts and styles for slider admin area
         */ 
        public function register_admin_scripts( $hook ) {

            if( 'options-general.php?page=prism-wp-settings' == $hook ){ // Limit loading to certain admin pages
                
            }
        }
        
        
        /**
         * Scripts and styles for slider to run. Must be hook to either admin_enqueue_scripts or wp_enqueue_scripts
         *
         * @param string $hook Hook name passed by WP
         * @return void
         */
        public function register_frontend_scripts( $hook ) {
            $in_footer = true;
            
            if($this->prism_wp_settings_data['load_scripts_in'] == 'header'){
                $in_footer = false;
            }
            
            // Themes
            if( 'default' == $this->prism_wp_settings_data['theme'] ){
                wp_enqueue_style( 'prism', PRISM_WP_URL.'libs/prism/themes/prism.css', array(), PRISM_WP_VERSION );
                
            } else if ( 'coy' == $this->prism_wp_settings_data['theme'] ){
                wp_enqueue_style( 'prism-coy', PRISM_WP_URL.'libs/prism/themes/prism-coy.css', array(), PRISM_WP_VERSION );
                
            } else if ( 'dark' == $this->prism_wp_settings_data['theme'] ){
                wp_enqueue_style( 'prism-dark', PRISM_WP_URL.'libs/prism/themes/prism-dark.css', array(), PRISM_WP_VERSION );
                
            } else if ( 'funky' == $this->prism_wp_settings_data['theme'] ){
                wp_enqueue_style( 'prism-funky', PRISM_WP_URL.'libs/prism/themes/prism-funky.css', array(), PRISM_WP_VERSION );
                
            } else if ( 'okaidia' == $this->prism_wp_settings_data['theme'] ){
                wp_enqueue_style( 'prism-okaidia', PRISM_WP_URL.'libs/prism/themes/prism-okaidia.css', array(), PRISM_WP_VERSION );
                
            } else if ( 'tomorrow' == $this->prism_wp_settings_data['theme'] ){
                wp_enqueue_style( 'prism-tomorrow', PRISM_WP_URL.'libs/prism/themes/prism-tomorrow.css', array(), PRISM_WP_VERSION );
                
            } else if ( 'twilight' == $this->prism_wp_settings_data['theme'] ){
                wp_enqueue_style( 'prism-twilight', PRISM_WP_URL.'libs/prism/themes/prism-twilight.css', array(), PRISM_WP_VERSION );
                
            }
            
            $register_scripts = array(
                // Core
                array(
                    'handle' => 'prism-core',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-core.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-core.min.js',
                    'deps' => array()
                ),
                
                // Languages
                array(
                    'handle' => 'prism-clike',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-clike.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-clike.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-bash',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-bash.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-bash.min.js',
                    'deps' => array('prism-core', 'prism-clike')
                ),
                array(
                    'handle' => 'prism-c',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-c.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-c.min.js',
                    'deps' => array('prism-core', 'prism-clike')
                ),
                array(
                    'handle' => 'prism-coffeescript',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-coffeescript.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-coffeescript.min.js',
                    'deps' => array('prism-core', 'prism-clike', 'prism-javascript')
                ),
                array(
                    'handle' => 'prism-cpp',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-cpp.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-cpp.min.js',
                    'deps' => array('prism-core', 'prism-clike', 'prism-c')
                ),
                array(
                    'handle' => 'prism-csharp',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-csharp.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-csharp.min.js',
                    'deps' => array('prism-core', 'prism-clike')
                ),
                array(
                    'handle' => 'prism-css',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-css.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-css.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-css-extras',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-css-extras.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-css-extras.min.js',
                    'deps' => array('prism-core', 'prism-css')
                ),
                array(
                    'handle' => 'prism-gherkin',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-gherkin.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-gherkin.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-groovy',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-groovy.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-groovy.min.js',
                    'deps' => array('prism-core', 'prism-clike')
                ),
                array(
                    'handle' => 'prism-http',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-http.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-http.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-java',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-java.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-java.min.js',
                    'deps' => array('prism-core', 'prism-clike')
                ),
                array(
                    'handle' => 'prism-javascript',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-javascript.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-javascript.min.js',
                    'deps' => array('prism-core', 'prism-clike')
                ),
                array(
                    'handle' => 'prism-markup',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-markup.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-markup.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-php',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-php.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-php.min.js',
                    'deps' => array('prism-core', 'prism-clike')
                ),
                array(
                    'handle' => 'prism-php-extras',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-php-extras.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-php-extras.min.js',
                    'deps' => array('prism-core', 'prism-clike', 'prism-php')
                ),
                array(
                    'handle' => 'prism-python',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-python.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-python.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-ruby',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-ruby.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-ruby.min.js',
                    'deps' => array('prism-core', 'prism-clike')
                ),
                array(
                    'handle' => 'prism-ruby',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-ruby.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-ruby.min.js',
                    'deps' => array('prism-core', 'prism-clike')
                ),
                array(
                    'handle' => 'prism-scss',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-scss.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-scss.min.js',
                    'deps' => array('prism-core', 'prism-css')
                ),
                array(
                    'handle' => 'prism-sql',
                    'src' => PRISM_WP_URL.'libs/prism/components/prism-sql.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/components/prism-sql.min.js',
                    'deps' => array('prism-core')
                ),
                
                // Plugins
                array(
                    'handle' => 'prism-line-highlight',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/line-highlight/prism-line-highlight.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/plugins/line-highlight/prism-line-highlight.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-line-numbers',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/line-numbers/prism-line-numbers.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/plugins/line-numbers/prism-line-numbers.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-show-invisibles',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/show-invisibles/prism-show-invisibles.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/plugins/show-invisibles/prism-show-invisibles.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-autolinker',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/autolinker/prism-autolinker.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/plugins/autolinker/prism-autolinker.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-wpd',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/wpd/prism-wpd.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/plugins/wpd/prism-wpd.min.js',
                    'deps' => array('prism-core')
                ),
                array(
                    'handle' => 'prism-file-highlight',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/file-highlight/prism-file-highlight.js',
                    'src_minified' => PRISM_WP_URL.'libs/prism/plugins/file-highlight/prism-file-highlight.min.js',
                    'deps' => array('prism-core')
                )
            );
            
            // Loop and register scripts
            foreach( $register_scripts as $script ){
                
                $src = $script['src_minified'];
                
                if(PRISM_WP_DEBUG){ // Use unminified version when debugging
                    $src = $script['src'];
                }
                
                wp_register_script(
                    $script['handle'],
                    $src,
                    $script['deps'],
                    PRISM_WP_VERSION,
                    $in_footer
                );
            }
            
            $register_styles = array(
                // Plugins
                array(
                    'handle' => 'prism-line-highlight',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/line-highlight/prism-line-highlight.css',
                    'deps' => array()
                ),
                array(
                    'handle' => 'prism-line-numbers',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/line-numbers/prism-line-numbers.css',
                    'deps' => array()
                ),
                array(
                    'handle' => 'prism-show-invisibles',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/show-invisibles/prism-show-invisibles.css',
                    'deps' => array()
                ),
                array(
                    'handle' => 'prism-autolinker',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/autolinker/prism-autolinker.css',
                    'deps' => array()
                ),
                array(
                    'handle' => 'prism-wpd',
                    'src' => PRISM_WP_URL.'libs/prism/plugins/wpd/prism-wpd.css',
                    'deps' => array()
                )
            );
            
            // Loop and register styles
            foreach( $register_styles as $style ){
                wp_register_style(
                    $style['handle'],
                    $style['src'],
                    $style['deps'],
                    PRISM_WP_VERSION
                );
            }
            
            // Enqueue needed languages
            if ( 1 == $this->prism_wp_settings_data['language_bash'] ){
                wp_enqueue_script( 'prism-bash' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_c'] ){
                wp_enqueue_script( 'prism-c' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_coffeescript'] ){
                wp_enqueue_script( 'prism-coffeescript' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_cpp'] ){
                wp_enqueue_script( 'prism-cpp' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_csharp'] ){
                wp_enqueue_script( 'prism-csharp' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_css'] ){
                wp_enqueue_script( 'prism-css' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_css_extras'] ){
                wp_enqueue_script( 'prism-css_extras' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_gherkin'] ){
                wp_enqueue_script( 'prism-gherkin' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_groovy'] ){
                wp_enqueue_script( 'prism-groovy' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_http'] ){
                wp_enqueue_script( 'prism-http' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_java'] ){
                wp_enqueue_script( 'prism-java' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_javascript'] ){
                wp_enqueue_script( 'prism-javascript' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_markup'] ){
                wp_enqueue_script( 'prism-markup' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_php'] ){
                wp_enqueue_script( 'prism-php' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_php_extras'] ){
                wp_enqueue_script( 'prism-php-extras' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_python'] ){
                wp_enqueue_script( 'prism-python' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_ruby'] ){
                wp_enqueue_script( 'prism-ruby' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_scss'] ){
                wp_enqueue_script( 'prism-scss' );
            }
            if ( 1 == $this->prism_wp_settings_data['language_sql'] ){
                wp_enqueue_script( 'prism-sql' );
            }
            
            
            // Enqueue needed plugins
            if ( 1 == $this->prism_wp_settings_data['line_highlight'] ){
                wp_enqueue_style( 'prism-line-highlight' );
                wp_enqueue_script( 'prism-line-highlight' );
            }
            
            if ( 1 == $this->prism_wp_settings_data['line_numbers'] ){
                wp_enqueue_style( 'prism-line-numbers' );
                wp_enqueue_script( 'prism-line-numbers' );
            }
            
            if ( 1 == $this->prism_wp_settings_data['show_invisibles'] ){
                wp_enqueue_style( 'prism-show-invisibles' );
                wp_enqueue_script( 'prism-show-invisibles' );
            }
            
            if ( 1 == $this->prism_wp_settings_data['autolinker'] ){
                wp_enqueue_style( 'prism-autolinker' );
                wp_enqueue_script( 'prism-autolinker' );
            }
            
            if ( 1 == $this->prism_wp_settings_data['wpd'] ){
                wp_enqueue_style( 'prism-wpd' );
                wp_enqueue_script( 'prism-wpd' );
            }
            
            if ( 1 == $this->prism_wp_settings_data['file_highlight'] ){ // Doesn't have style!
                wp_enqueue_script( 'prism-file-highlight' );
            }
        }
        
    }
    
endif;