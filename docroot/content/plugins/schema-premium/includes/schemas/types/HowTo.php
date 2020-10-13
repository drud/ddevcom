<?php
/**
 * @package Schema Premium - Class Schema HowTo
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_HowTo') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_HowTo {
		
		/** @var string Current Type */
    	protected $type = 'HowTo';
		
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
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('How To', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Instructions that explain how to achieve a result by performing a sequence of steps.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_HowTo', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
		
			$subtypes = array();
				
			return apply_filters( 'schema_wp_subtypes_HowTo', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
					'url' => array(
						'label' 		=> __('URL', 'schema-premium'),
						'rangeIncludes' => array('URL'),
						'field_type' 	=> 'url',
						'markup_value' => 'post_permalink',
						'instructions' 	=> __('URL of the article.', 'schema-premium'),
						'placeholder' 	=> 'https://'
					),
					'name' => array(
						'label' 		=> __('Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('Name of the article', 'schema-premium'),
						'required' 		=> true
					),
					'headline' => array(
						'label' 		=> __('Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'disabled',
						'instructions' 	=> __('Headline of the article', 'schema-premium'),
						'required' 		=> true
					),
					'alternativeHeadline' => array(
						'label' 		=> __('Alternative Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'disabled',
						'instructions' 	=> __('Secondary title for this article.', 'schema-premium')
					),
					'image' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('An image of the article.', 'schema-premium'),
						'required' 		=> true
					),
					'datePublished' => array(
						'label'			=> __('Published Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_date',
						'instructions' 	=> __('Date of first publication of the article.', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
						'required' 		=> true
					),
					'dateModified' => array(
						'label' 		=> __('Modified Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_modified',
						'instructions' 	=> __('The date on which the article was most recently modified', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
					),
					'author' => array(
						'label' 		=> __('Author Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('The author name of this article.', 'schema-premium'),
						'required' 		=> true
					),
					'description' => array(
						'label' 		=> __('Description', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_excerpt',
						'instructions' 	=> __('A description of the article.', 'schema-premium'),
					),
					'totalTime' => array(
						'label' 		=> __('Total Time', 'schema-premium'),
						'rangeIncludes' => array('Duration'),
						'field_type' 	=> 'time_picker',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The total time required to perform instructions or a direction.', 'schema-premium'),
						'display_format' => 'H:i:s',
						'return_format' => 'H:i:s',
					),
					'howto_tools' => array(
						'label' 		=> __('Tools', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'repeater',
						'layout'		=> 'block',
						'markup_value' => 'new_custom_field',
						'required' 		=> true,
						'button_label' 	=> __('Add Tool', 'schema-premium'),
						'instructions' 	=> __('Add tools that has been used.', 'schema-premium'),
						'sub_fields' 	=>  array(
							'tool_name' => array(
								'label' 		=> __('Name', 'schema-premium'),
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'text',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
								'placeholder' => __('Tool name', 'schema-premium'),
							),
						), // end sub fields
					),
					'howto_supplies' => array(
						'label' 		=> __('Supplies', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'repeater',
						'layout'		=> 'block',
						'markup_value' => 'new_custom_field',
						'required' 		=> true,
						'button_label' 	=> __('Add Supply', 'schema-premium'),
						'instructions' 	=> __('Add supplies that has been used.', 'schema-premium'),
						'sub_fields' 	=>  array(
							'supply_name' => array(
								'label' 		=> __('Name', 'schema-premium'),
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'text',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
								'placeholder' => __('Supply name', 'schema-premium'),
							),
						), // end sub fields
					),
					'howto_steps' => array(
						'label' 		=> __('Steps', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'repeater',
						'layout'		=> 'block',
						'markup_value' => 'new_custom_field',
						'required' 		=> true,
						'button_label' 	=> __('Add Step', 'schema-premium'),
						'instructions' 	=> __('Add step title, text, and upload an image.', 'schema-premium'),
						'sub_fields' 	=>  array(
							'name_item' => array(
								'label' 		=> __('Title', 'schema-premium'),
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'text',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
								'placeholder' => __('Title', 'schema-premium'),
							),
							'text_item' => array(
								'label' 		=> __('Text', 'schema-premium'),
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'textarea',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
								'placeholder' => __('Text of this step', 'schema-premium'),
								'rows' => 2
							),
							'image_item' => array(
								'label' 		=> __('Image', 'schema-premium'),
								'rangeIncludes' => array('ImageObject', 'URL'),
								'field_type' 	=> 'image',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
							),
						), // end sub fields
					),
				);
				
			return apply_filters( 'schema_properties_HowTo', $properties );	
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
			$schema['@context'] 		=  'http://schema.org';
			$schema['@type'] 			=  $this->type;
		
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			
			// Get Tools
			$schema['tool'] = $this->get_tools();
			
			// Get Supplies
			$schema['supply'] = $this->get_supplies();
			
			// Get Steps
			$schema['step'] = $this->get_steps();
						
			// Get properties
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			$schema['url'] 				= isset($properties['url'] ) ? $properties['url'] : get_permalink( $post->ID );
			$schema['name'] 			= isset($properties['name'] ) ? $properties['name'] : '';
			$schema['headline'] 		= isset($properties['headline'] ) ? $properties['headline'] : '';
			$schema['description'] 		= isset($properties['description'] ) ? $properties['description'] : schema_wp_get_description( $post->ID );
			$schema['image'] 			= isset($properties['image']) ? $properties['image'] : schema_wp_get_media( $post->ID );
			
			$schema['datePublished']	= isset($properties['datePublished'] ) ? $properties['datePublished'] : get_the_date( 'c', $post->ID );
			$schema['dateModified']		= isset($properties['dateModified'] ) ? $properties['dateModified'] : get_post_modified_time( 'c', false, $post->ID, false );
			
			if( isset($properties['author'] ) ) { 
				$schema['author'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['author']
				);
			} else {
				$schema['author'] = schema_wp_get_author_array( $post->ID );
			}
			
			$schema['publisher']		= schema_wp_get_publisher_array();
			
			$schema['keywords']			= schema_wp_get_post_tags( $post->ID );
			
			// Override properties
			$properties['totalTime']	= isset($properties['totalTime'] ) ? schema_premium_format_time_to_PT($properties['totalTime']) : '';
			
			// Unset auto generated properties
			unset($properties['author']);
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				$schema = array_merge($schema, $properties);
			}
			
			return $this->schema_output_filter($schema);
		}

		/**
		* Apply filters to markup output
		*
		* @since 1.1.2.8
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_HowTo', $schema );
		}

		/**
		* Get Tools
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_tools() {
			
			global $post;
			
			$output = array();
	
			$count = get_post_meta( get_the_ID(), 'schema_properties_HowTo_howto_tools', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					
					$step_no = $i + 1;
					
					$name 		= get_post_meta( get_the_ID(), 'schema_properties_HowTo_howto_tools_' . $i . '_tool_name', true );
					
					$output[] = array
					(
						'@type'	=> 'HowToTool',
						'name'	=> strip_tags($name),
					);
				}
		
			}
	
			return $output;
		}
		
		/**
		* Get Supplies
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_supplies() {
			
			global $post;
			
			$output = array();
	
			$count = get_post_meta( get_the_ID(), 'schema_properties_HowTo_howto_supplies', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					
					$step_no = $i + 1;
					
					$name 		= get_post_meta( get_the_ID(), 'schema_properties_HowTo_howto_supplies_' . $i . '_supply_name', true );
					
					$output[] 	= array
					(
						'@type'				=> 'HowToSupply',
						'name'				=> strip_tags($name),
					);
				}
		
			}
	
			return $output;
		}
		
		/**
		* Get Steps
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_steps() {
			
			global $post;
			
			$output = array();
	
			$count = get_post_meta( get_the_ID(), 'schema_properties_HowTo_howto_steps', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					
					$step_no = $i + 1;
					
					$name 		= get_post_meta( get_the_ID(), 'schema_properties_HowTo_howto_steps_' . $i . '_name_item', true );
					$text 		= get_post_meta( get_the_ID(), 'schema_properties_HowTo_howto_steps_' . $i . '_text_item', true );
					$image_id 	= get_post_meta( get_the_ID(), 'schema_properties_HowTo_howto_steps_' . $i . '_image_item', true );
					$image_url 	= ($image_id) ? wp_get_attachment_url( $image_id ) : '';
					
					$output[] = array
					(
						'@type'				=> 'HowToStep',
						'name'				=> strip_tags($name),
						'text'				=> strip_tags($text),
						'image'				=> $image_url,
						'url'				=> get_permalink( $post->ID ) . '#step' . $step_no,
					);
				}
		
			}
	
			return $output;
		}
		
	}
	
	new Schema_WP_HowTo();
	
endif;
