<?php
/**
 * @package Schema Premium - Class Schema Audiobook
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Audiobook') ) :
	/**
	 * Class
	 *
	 * @since 1.2
	 */
	class Schema_WP_Audiobook extends Schema_WP_Book {
		
		/** @var string Currenct Type */
    	protected $type = 'Audiobook';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'Book';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
		
			// emty __construct
		}
		
		/**
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'Audiobook';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Audiobook', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An audiobook.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {

			$properties = array(

				'duration' => array(
					'label' 		 => __('Duration', 'schema-premium'),
					'rangeIncludes'  => array('Text'),
					'field_type' 	 => 'time_picker',
					'markup_value' 	 => 'disabled',
					'instructions' 	 => __('The duration of the audio recording.', 'schema-premium'),
					'display_format' => 'H:i:s',
					'return_format'  => 'H:i:s',
				),
				'readBy' => array(
					'label' 		=> __('Read By', 'schema-premium'),
					'rangeIncludes' => array('Person'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('A person who reads (performs) the audiobook.', 'schema-premium'),
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 40 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_Audiobook', $properties );	
		}

		/**
		* Schema output
		*
		* @since 1.0.0
		* @return array
		*/
		public function schema_output( $post_id = null ) {
			
			if ( isset($post_id) ) {
				$post = get_post( $post_id );
			} else {
				global $post;
			}
			
			$schema = array();
			
			// Putting all together
			//
			//$schema['@context'] =  'https://schema.org';
			//$schema['@type'] 	=  $this->type;
			/*
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			*/

			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Modify properties values
			//
			// $total_time = prepTime + cookTime
			//
			if ( isset($properties['duration']) && $properties['duration'] != '' ) { 
				$schema['duration'] = schema_premium_format_time_to_PT( $properties['duration'] );
			}

			// Get director
			//
			if( isset($properties['readBy'] ) ) { 
				$schema['readBy'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['readBy']
				);
			}

			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

			// Debug
			//echo '<pre>'; print_r($schema); echo '</pre>';
			
			return $this->schema_output_filter($schema);
		}
		
		/**
		* Apply filters to markup output
		*
		* @since 1.1.2
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_Audiobook', $schema );
		}
	}
	
	//new Schema_WP_Audiobook();
	
endif;
