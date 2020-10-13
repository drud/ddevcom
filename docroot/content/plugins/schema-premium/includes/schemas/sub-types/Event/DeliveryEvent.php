<?php
/**
 * @package Schema Premium - Class Schema DeliveryEvent
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_DeliveryEvent') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_DeliveryEvent extends Schema_WP_Event {
		
		/** @var string Currenct Type */
    	protected $type = 'DeliveryEvent';
		
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
			
			return __('Delivery Event', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Delivery event.', 'schema-premium');
		}
	}
	
	//new Schema_WP_DeliveryEvent();
	
endif;
