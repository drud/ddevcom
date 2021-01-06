<?php
/**
 * @package Schema Premium - Class Schema Q&A Page
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_QAPage') ) :
	/**
	 * Schema QAPage
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_QAPage extends Schema_WP_WebPage {
		
		/** @var string Currenct Type */
    	protected $type = 'QAPage';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'WebPage';

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
			
			return 'QAPage';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Q&A Page', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A QAPage is a WebPage focussed on a specific Question and its Answer(s), e.g. in a question answering site or documenting Frequently Asked Questions (FAQs).', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array(
				
				'Question_name' => array(
					'label' 		=> __('Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'post_title',
					'instructions' 	=> __('The full text of the short form of the question.', 'schema-premium'),
					'required' 		=> true
				),
				'Question_answerCount' => array(
					'label' 		=> __('Answer Count', 'schema-premium'),
					'rangeIncludes' => array('Integer'),
					'field_type' 	=> 'number',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The number of answers this question has received. This may also be 0 for questions with no answers.', 'schema-premium'),
					'required' 		=> true
				),
				'Question_author' => array(
					'label' 		=> __('Author Name', 'schema-premium'),
					'rangeIncludes' => array('Person', 'Organization'),
					'field_type' 	=> 'text',
					'markup_value' => 'author_name',
					'instructions' 	=> __('The author of the question.', 'schema-premium'),
				),
				'Question_dateCreated' => array(
					'label'			=> __('Date Created', 'schema-premium'),
					'rangeIncludes' => array('Date', 'DateTime'),
					'field_type' 	=> 'date_time_picker',
					'markup_value' => 'post_date',
					'instructions' 	=> __('Date of first publication of the web page.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format' => 'Y-m-d'
				),
				'Question_text' => array(
					'label' 		=> __('Text', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value' => 'post_excerpt',
					'instructions' 	=> __('A description of the web page.', 'schema-premium'),
				)
			);

			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_QAPage', $properties );	
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
			
			// Get WebPage markup
			//
			$WebPage = new Schema_WP_WebPage();
			$schema  = $WebPage->schema_output();

			// Putting all together
			//
			$schema['@context'] =  'https://schema.org';
			$schema['@type'] 	=  $this->type;

			// Get properties
			$properties = schema_wp_get_properties_markup_output( $post_id, $this->properties(), $this->type );

			$name 			= isset($properties['Question_name'] ) ? $properties['Question_name'] : '';
			$answerCount 	= isset($properties['Question_answerCount'] ) ? $properties['Question_answerCount'] : 0;  // default to 0
			$dateCreated 	= isset($properties['Question_dateCreated'] ) ? $properties['Question_dateCreated'] : get_the_date( 'c', $post_id );
			$text 			= isset($properties['Question_text'] ) ? $properties['Question_text'] : schema_wp_get_description( $post_id );

			$schema['mainEntity'] = array
			(
				'@type' 		=> 'Question',
				'@id' 			=> get_permalink( $post_id ),
				'name'			=> $name,
				'answerCount' 	=> $answerCount,
				'dateCreated'	=> $dateCreated,
				'text'			=> $text,
			);

			if( isset($properties['Question_author'] ) ) { 
				$schema['mainEntity']['author'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['Question_author']
				);
			} else {
				$schema['mainEntity']['author'] = schema_wp_get_author_array( $post_id );
			}

			// Unset auto generated properties
			unset($schema['Question_name']);
			unset($schema['Question_answerCount']);
			unset($schema['Question_author']);
			unset($schema['Question_dateCreated']);
			unset($schema['Question_text']);	

			// debug
			//echo'<pre>';print_r($schema);echo'</pre>';
			
			return $this->schema_output_filter($schema);
		}

		/**
		* Apply filters to markup output
		*
		* @since 1.1.2.8
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_QAPage', $schema );
		}
	}
	
	//new Schema_WP_QAPage();
	
endif;
