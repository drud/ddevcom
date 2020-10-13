<?php
/**
 * @package Schema Premium - Class Schema NewsArticle
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_NewsArticle') ) :
	/**
	 * Schema Article
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_NewsArticle extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'NewsArticle';
		
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
			
			return __('News Article', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A NewsArticle is an article whose content reports news, or provides background context and supporting materials for understanding the news.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {

			$properties = array(
				'NewsArticle_properties_tab' => array(
					'label' 		=> '<span style="color:#c90000;">' . $this->type . '</span>',
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'tab',
					'menu_order' 	=> 30,
					'markup_value' 	=> 'none'
				),
				'NewsArticle_properties_info' => array(
					'label' => $this->type,
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'message',
					'markup_value' => 'none',
					'instructions' 	=> __('Properties of' , 'schema-premium') . ' ' . $this->type,
					'message'		=> $this->comment(),
				),
				'printColumn' => array(
					'label' 		=> __('Print Column', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'disabled',
					'instructions' 	=> __('The number of the column in which the NewsArticle appears in the print edition.', 'schema-premium'),
				),
				'printEdition' => array(
					'label' 		=> __('Print Edition', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'disabled',
					'instructions' 	=> __('The edition of the print product in which the NewsArticle appears.', 'schema-premium'),
				),
				'printPage' => array(
					'label' 		=> __('Print page', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'disabled',
					'instructions' 	=> __('If this NewsArticle appears in print, this field indicates the name of the page on which the article is found. Please note that this field is intended for the exact page name (e.g. A5, B18).', 'schema-premium'),
				),
				'printSection' => array(
					'label' 		=> __('Print Edition', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'disabled',
					'instructions' 	=> __('If this NewsArticle appears in print, this field indicates the print section in which the article appeared.', 'schema-premium'),
				),
				'NewsArticle_properties_tab_endpoint' => array(
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

			return apply_filters( 'schema_properties_NewsArticle', $properties );	
		}
	}
	
endif;
