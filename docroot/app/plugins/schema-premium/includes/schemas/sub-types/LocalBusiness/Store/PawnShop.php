<?php
/**
 * @package Schema Premium - Class Schema PawnShop
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_PawnShop') ) :
	/**
	 * Schema PawnShop
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_PawnShop extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'PawnShop';
			
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
			
			return 'PawnShop';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Pawn Shop', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A shop that will buy, or lend money against the security of, personal possessions.', 'schema-premium');
		}
	}
	
endif;
