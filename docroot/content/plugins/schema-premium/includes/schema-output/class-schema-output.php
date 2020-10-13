<?php
/**
 * Schema Output
 *
 * @since 1.4
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Schema_WP_Output' ) ) :
/**
 * Schema Output Class
 *
 * @version 1.0.0
 * @since   1.0.0
 */
class Schema_WP_Output {
    
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct () {
		
		$this->init();
	}
	
	/**
	 * Init
	 *
	 * @since 1.0.0
	 */
	public function init() {

		$schema_output_location = schema_wp_get_option( 'schema_output_location' );
				
		if ( ! isset($schema_output_location) || $schema_output_location == '' ) {
			$schema_output_location = 'head'; // default
		}
				
		// Switch between schema markup output locations
		switch ( $schema_output_location ) {
			case 'head' :
				add_action('wp_head', array( $this, 'do_schema' ), 2 );
				break;
				
			case 'footer' :
				add_action('wp_footer', array( $this, 'do_schema' ) );
				break;
		}
	}
	
	/**
	 * Get Schema 
	 *
	 * @since 1.0.0
	 */
	public function get_schema( $post_id = null, $schema_type ) {
		
		// Do not run on 404 pages
		if ( is_404() ) return;
	
		if ( isset($post_id) ) {
			$post = get_post( $post_id );
		} else {
			global $post;
		}

		$schema = array();
		
		if ( ! isset( $schema_type) || $schema_type != '') {
			// Save class name in a variable
			$ClassName 		= 'Schema_WP_' . $schema_type;
			// Init
			if ( class_exists( $ClassName ) ) {
   				$Schema_Class 	= new $ClassName;
				$schema 		= $Schema_Class->schema_output( $post_id );
			}
		}
		
    	return apply_filters( 'schema_output', $schema );
	}
	
	/**
	 * JSON_LD final output
	 *
	 * @since 1.0.0
	 */
	public function do_schema() {
       
		$this->schema_before();
		
		do_action('schema_output_before_before');
		
		do_action('schema_output_before');
		
		do_action('schema_markup_output'); // main action
		
		do_action('schema_output_after');
		
		do_action('schema_output_after_after');
		
		$this->schema_after();

    }
	
	/**
	 * JSON_LD before output
	 *
	 * @since 1.0.0
	 */
	public function schema_before() {
		echo  PHP_EOL . '<!-- This site is optimized with the Schema Premium ver.' . SCHEMAPREMIUM_VERSION . ' - https://schema.press -->' . PHP_EOL;
	}
	
	/**
	 * JSON_LD after output
	 *
	 * @since 1.0.0
	 */
	public function schema_after() {
		echo PHP_EOL.'<!-- Schema Premium Plugin -->' . PHP_EOL .  PHP_EOL;
	}
	
	/**
	 * JSON_LD output
	 *
	 * @since 1.0.0
	 */
	public function json_output( $schema, $error = false ) {
      
		if ( $error ) {
			/** Error Display */
			if ( isset( $schema["@type"] ) ) {
				foreach ( $schema["message"] as $message ) {
					echo "<!-- Schema.org ", $schema["@type"], " : ", $message, " -->", PHP_EOL;
				}
			}
		} else {
			if ( is_array( $schema ) && ! empty($schema) ) {
				
				// Get setting for display instructions
				$json_ld_output_format = schema_wp_get_option( 'json_ld_output_format' );
	
				if ( $json_ld_output_format == 'pretty_print' ) {
					
					echo '<script type="application/ld+json" class="schema-premium">', PHP_EOL;
					echo json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ), PHP_EOL;
					echo '</script>', PHP_EOL;

				} else {
					
					// Minified
					echo '<script type="application/ld+json" class="schema-premium">';
					echo json_encode( $schema, JSON_UNESCAPED_UNICODE );
					echo '</script>';	
				}
			}
		}
    }
}

new Schema_WP_Output();

endif; // End if class_exists check
