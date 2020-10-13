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
				'TechArticle_properties_tab' => array(
					'label' 		=> '<span style="color:#c90000;">' . $this->type . '</span>',
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'tab',
					'menu_order' 	=> 30,
					'markup_value' 	=> 'none'
				),
				'TechArticle_properties_info' => array(
					'label' => $this->type,
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'message',
					'markup_value' => 'none',
					'instructions' 	=> __('Properties of' , 'schema-premium') . ' ' . $this->type,
					'message'		=> $this->comment(),
				),
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
				),
				'TechArticle_properties_tab_endpoint' => array(
					'label' 		=> '', // empty label
					'field_type' 	=> 'tab',
					'markup_value' 	=> 'none'
				),
			);
			
			// Get parent properties 
			//
			$Article_properties = parent::properties();
			// 
			// Fix tabs
			//
			$Article_properties['Article_properties_tab']['label'] 			= '<span style="color:#c90000;">' . $this->parent_type . '</span>';
			$Article_properties['Article_properties_info']['label'] 		= $this->parent_type;
			$Article_properties['Article_properties_info']['instructions'] 	= __('Properties of' , 'schema-premium') . ' ' . $this->parent_type;
			$Article_properties['Article_properties_info']['message']  		= parent::comment();
			
			$properties = array_merge( $Article_properties, $properties );

			return apply_filters( 'schema_properties_TechArticle', $properties );	
		}
	}
	
endif;
