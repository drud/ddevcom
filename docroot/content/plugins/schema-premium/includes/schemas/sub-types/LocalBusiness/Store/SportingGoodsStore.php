<?php
/**
 * @package Schema Premium - Class Schema SportingGoodsStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_SportingGoodsStore') ) :
	/**
	 * Schema SportingGoodsStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_SportingGoodsStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'SportingGoodsStore';
			
		/** @var string Current Parent Type */
		protected $parent_type = 'Store';

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
			
			return 'SportingGoodsStore';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('SportingGoods Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A sporting goods store.', 'schema-premium');
		}
	}
	
endif;
