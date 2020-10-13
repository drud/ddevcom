<?php
/**
 * @package Schema Premium - Class Schema AutomotiveBusiness
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AutomotiveBusiness') ) :
	/**
	 * Schema AutomotiveBusiness
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AutomotiveBusiness extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'AutomotiveBusiness';
		
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
			
			return __('Automotive Business', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Car repair, sales, or parts.', 'schema-premium');
		}
	}
	
	//new Schema_WP_AutomotiveBusiness();
	
endif;
