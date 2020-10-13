<?php
/**
 * @package Schema Premium - Class Schema RealEstateAgent
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_RealEstateAgent') ) :
	/**
	 * Schema RealEstateAgent
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_RealEstateAgent extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'RealEstateAgent';
		
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
			
			return __('Real Estate Agent', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A real-estate agent.', 'schema-premium');
		}
	}
	
	//new Schema_WP_RealEstateAgent();
	
endif;
