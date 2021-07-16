<?php
/**
 * @package Schema Premium - Class Schema VideoGame
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_VideoGame') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_VideoGame extends Schema_WP_SoftwareApplication {
		
		/** @var string Currenct Type */
    	protected $type = 'VideoGame';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'SoftwareApplication';

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
			
			return 'VideoGame';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Video Game', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A video game is an electronic game that involves human interaction with a user interface to generate visual feedback on a video device.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.2
		* @return array
		*/
		public function properties() {
			
			// Add specific properties 
			//
			$properties['gamePlatform'] =  array(
				'label' 		=> __('Game Platform', 'schema-premium'),
				'rangeIncludes' => array('Text', 'Thing', 'URL'),
				'field_type' 	=> 'text',
				'markup_value' => 'disabled',
				'instructions' 	=> __('The electronic systems used to play video games.', 'schema-premium'),
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 40 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_VideoGame', $properties );
		}
	}
	
endif;
