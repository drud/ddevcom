<?php
/**
 * @package Schema Premium - Class Schema TechArticle
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_TechArticle') ) :
	/**
	 * Schema Article
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_TechArticle extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'TechArticle';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'Article';

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
			
			return 'TechArticle';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Tech Article', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A technical article - Example: How-to (task) topics, step-by-step, procedural troubleshooting, specifications, etc.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {

			$properties = array(
				
				'dependencies' => array(
					'label' 		=> __('Dependencies', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'disabled',
					'instructions' 	=> __('Prerequisites needed to fulfill steps in article.', 'schema-premium'),
				),
				'proficiencyLevel' => array(
					'label' 		=> __('Proficiency Level', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'disabled',
					'instructions' 	=> __('Proficiency needed for this content; expected values: (Beginner, Expert)', 'schema-premium'),
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( array(), self::type(), self::label(), self::comment(), 40 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_TechArticle', $properties );	
		}
	}
	
endif;
