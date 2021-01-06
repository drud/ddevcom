<?php
/**
 * @package Schema Premium - Class Schema Book
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Book') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Book extends Schema_WP_CreativeWork {
		
		/** @var string Current Type */
    	protected $type = 'Book';
		
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
			
			return 'Book';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Book', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A book.', 'schema-premium');
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
				'subtypes' 		=> $this->subtypes()
			);
			
			return apply_filters( 'schema_wp_Book', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			$subtypes =  array
			(
           		'Audiobook' => __('Audiobook', 'schema-premium')
			);
				
			return apply_filters( 'schema_wp_subtypes_Book', $subtypes );
		}
		
		/**
		* Properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array(

				'abridged' => array(
					'label' 		=> __('Abridged', 'schema-premium'),
					'rangeIncludes' => array('Boolean'),
					'field_type' 	=> 'true_false',
					'default_value' => 0,
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('Indicates whether the book is an abridged edition.', 'schema-premium'),
					'ui' 			=> 1,
					'ui_on_text' 	=> __('Yes', 'schema-premium'),
					'ui_off_text' 	=> __('No', 'schema-premium'),
				),
				'bookEdition' => array(
					'label' 		=> __('Book Edition', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('The edition of the book.', 'schema-premium'),
				),
				'bookFormat' => array(
					'label' 		=> __('Book Format', 'schema-premium'),
					'rangeIncludes'	=> array('BookFormatType'),
					'field_type' 	=> 'select',
					'choices'		=> array(
												'AudiobookFormat' 	=> 'Audiobook Format',
												'EBook' 			=> 'E-Book',
												'GraphicNovel' 		=> 'Graphic Novel',
												'Hardcover' 		=> 'Hardcover',
												'Paperback' 		=> 'Paperback'
											),
					'multiple' 		=> true,
					'markup_value' 	=> 'new_custom_field',
					'instructions' 	=> __('The publication format of the book.', 'schema-premium'),
					'ui' 			=> true,
					//'ajax' 			=> true,
				),
				'isbn' => array(
					'label' 		=> __('ISBN', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' 	=> 'new_custom_field',
					'instructions' 	=> __('The ISBN of the book.', 'schema-premium'),
				),
				'numberOfPages' => array(
					'label' 		=> __('Number Of Pages', 'schema-premium'),
					'rangeIncludes' => array('Integer'),
					'field_type' 	=> 'number',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('The number of pages in the book.', 'schema-premium'),
				)
			);

			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			// 
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_Book', $properties );	
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
			
			// Putting all together
			//
			$schema['@context'] =  'https://schema.org';
			$schema['@type'] 	=  $this->type;
		
			// Get main entity of page
			//
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID ) . '#webpage'
			);
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// abridged
			//
			if ( isset($properties['abridged']) ) {
				
				if ( $properties['abridged'] == 1 ) {
					// True
					$schema['abridged'] = 'True';
						
				} elseif ( $properties['abridged'] == 0 ) {
					// False
					$schema['abridged'] = 'False';
				}

				// Unset auto generated properties
				//
				unset($properties['abridged']);
			}

			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

			// Debug
			//echo '<pre>'; print_r($schema); echo '</pre>';
			
			return $this->schema_output_filter($schema);
		}
		
		/**
		* Apply filters to markup output
		*
		* @since 1.1.2
		* @return array
		*/
		public function schema_output_filter( $schema ) {

			return apply_filters( 'schema_output_Book', $schema );
		}
	}
	
	new Schema_WP_Book();
	
endif;
