<?php
/**
 * @package Schema Premium - Class Schema FAQPage
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_FAQPage') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_FAQPage extends Schema_WP_CreativeWork {
		
		/** @var string Current Type */
		protected $type = 'FAQPage';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'CreativeWork';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
			
			$this->init();
		}
	
		/**
		* Init
		*
		* @since 1.0.0
	 	*/
		public function init() {
		
			add_filter( 'schema_wp_get_default_schemas', array( $this, 'schema_type' ) );
			add_filter( 'schema_wp_types', array( $this, 'schema_type_extend' ) );
		}
		
		/**
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'FAQPage';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('FAQ Page', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A FAQPage is a WebPage presenting one or more "Frequently asked questions".', 'schema-premium');
		}
		
		/**
		* Extend schema types
		*
		* @since 1.0.0
		* @return array
		*/
		public function schema_type_extend( $schema_types ) {
			
			$schema_types[$this->type] = array 
				(
					'label' => $this->label(),
					'value'	=> $this->type
				);
			
			return $schema_types;
		}
		
		/**
		* Get schema type
		*
		* @since 1.0.0
		* @return array
		*/
		public function schema_type( $schema ) {
			
			$schema[$this->type] = array (
    			'id' 			=> $this->type,
    			'lable' 		=> $this->label(),
				'comment' 		=> $this->comment(),
    			'properties'	=> $this->properties(),
    			'subtypes' 		=> $this->subtypes(),
			);
			
			return apply_filters( 'schema_wp_FAQPage', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
				
			return apply_filters( 'schema_wp_subtypes_FAQPage', array() );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
				'question_answer' => array(
					'label' 		=> __('Question & Answer', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'repeater',
					'layout'		=> 'block',
					'markup_value' => 'new_custom_field',
					//'required' 		=> true,
					'button_label' 	=> __('Add FAQ', 'schema-premium'),
					'instructions' 	=> __('FAQ (Frequently asked questions), and answers.', 'schema-premium'),
					'sub_fields' 	=>  array(
						'question_item' => array(
							'label' 		=> __('Question', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'placeholder' => __('Question', 'schema-premium'),
						),
						'answer_item' => array(
							'label' 		=> __('Answer', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'textarea',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'placeholder' => __('Answer', 'schema-premium'),
							'rows' => 2
						),
					), // end sub fields
				),
			);

			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );
				
			return apply_filters( 'schema_properties_FAQPage', $properties );	
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
			
			// Get mainEntity
			//
			$schema['mainEntity'] = $this->get_question_answer();
						
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );
			
			return $this->schema_output_filter($schema);
		}

		/**
		* Apply filters to markup output
		*
		* @since 1.1.2.8
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_FAQPage', $schema );
		}
		
		/**
		* Get mainEntity Questions and Answers
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_question_answer() {
			
			$post_id = schema_premium_get_post_ID();

			$output = array();
	
			$count = get_post_meta( $post_id, 'schema_properties_FAQPage_question_answer', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					$question 	= get_post_meta( $post_id, 'schema_properties_FAQPage_question_answer_' . $i . '_question_item', true );
					$answer 	= get_post_meta( $post_id, 'schema_properties_FAQPage_question_answer_' . $i . '_answer_item', true );
					
					$output[] = array
					(
						'@type'				=> 'Question',
						'name'				=> strip_tags($question),
						'acceptedAnswer' 	=> array
						(
							'@type' => 'Answer',
							'text'	=> strip_tags($answer)
						)
					);
				}
		
			}
	
			return $output;
		}
		
	}
	
	new Schema_WP_FAQPage();
	
endif;
