<?php

if ( ! class_exists( 'WP_Widget' ) ) {
	return;
}

/**
 * Class DPSP_Top_Shared_Posts
 */
class DPSP_Top_Shared_Posts extends WP_Widget {

	/**
	 * DPSP_Top_Shared_Posts constructor.
	 */
	public function __construct() {
		parent::__construct(
			'dpsp_top_shared_posts',
			__( 'Grow Social by Mediavine: Top Shared Posts', 'social-pug' ),
			[ 'description' => __( 'Display the most shared posts from any custom post type.', 'social-pug' ) ]
		);
	}

	/**
	 * Outputs the content of the widget in the front-end.
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		add_filter( 'mv_grow_scripts_should_enqueue', '__return_true' );

		// Set instance variables
		$posts_count         = ( isset( $instance['posts_count'] ) && ! empty( $instance['posts_count'] ) ? $instance['posts_count'] : 5 );
		$post_types          = ( isset( $instance['post_types'] ) && ! empty( $instance['post_types'] ) ? $instance['post_types'] : [] );
		$display_thumbnail   = ( isset( $instance['display_thumbnail'] ) && ! empty( $instance['display_thumbnail'] ) ? $instance['display_thumbnail'] : '' );
		$thumbnail_size      = ( isset( $instance['thumbnail_size'] ) && ! empty( $instance['thumbnail_size'] ) ? $instance['thumbnail_size'] : 'medium' );
		$display_excerpt     = ( isset( $instance['display_excerpt'] ) && ! empty( $instance['display_excerpt'] ) ? $instance['display_excerpt'] : '' );
		$display_share_count = ( isset( $instance['display_share_count'] ) && ! empty( $instance['display_share_count'] ) ? $instance['display_share_count'] : '' );

		// Get top shared posts
		$top_shared_posts = Mediavine\Grow\Settings::get_setting( 'dpsp_top_shared_posts', [] );

		if ( ! empty( $top_shared_posts ) ) {
			$top_shared_posts = json_decode( $top_shared_posts, ARRAY_A );
		}

		// Display the posts
		if ( ! empty( $top_shared_posts ) && ! empty( $post_types ) ) {

			// Filter posts
			$top_posts_ids = [];

			foreach ( $instance['post_types'] as $post_type ) {
				if ( ! empty( $top_shared_posts[ $post_type ] ) ) {
					$top_posts_ids = array_merge( $top_posts_ids, array_keys( $top_shared_posts[ $post_type ] ) );
				}
			}

			$top_posts_ids = array_slice( $top_posts_ids, 0, $posts_count );

			// Get top posts objects
			$top_shared_posts = get_posts(
				[
					'post_type' => $post_types,
					'include'   => $top_posts_ids,
				]
			);

			echo ( isset( $args['before_widget'] ) ? $args['before_widget'] : '' );

			echo ( isset( $args['before_title'] ) ? $args['before_title'] : '' );
				echo ( isset( $instance['title'] ) ? $instance['title'] : '' );
			echo ( isset( $args['after_title'] ) ? $args['after_title'] : '' );

			// If there are posts loop through them and display them
			if ( ! empty( $top_shared_posts ) ) {
				foreach ( $top_shared_posts as $top_post ) {

					$permalink = get_permalink( $top_post->ID );
					$title     = $top_post->post_title;

					if ( ! empty( $display_share_count ) ) {
						$total_share_count = dpsp_get_post_total_share_count( $top_post->ID );
					}

					// Open top post wrapper
					echo '<div class="dpsp-top-shared-post">';

						do_action( 'dpsp_top_shared_post_before', $top_post );

						// Display post thumbnail
					if ( $display_thumbnail == 'yes' ) {
						echo '<a class="dpsp-top-shared-post-thumbnail" href="' . $permalink . '" title="' . $title . '">';
							echo get_the_post_thumbnail( $top_post->ID, $thumbnail_size );
						echo '</a>';
					}

						// Display post title
						echo '<a class="dpsp-top-shared-post-title" href="' . $permalink . '" title="' . $title . '">';
							echo '<h3>';
								echo $title;
							echo '</h3>';
						echo '</a>';

						// Display post excerpt
					if ( $display_excerpt == 'yes' ) {

						echo '<p class="dpsp-top-shared-post-excerpt">';

							$more_string = apply_filters( 'dpsp_top_shared_posts_excerpt_more', '' );

							// If post excerpt is set display it
						if ( ! empty( $top_post->post_excerpt ) ) {

							echo $top_post->post_excerpt . $more_string;
						}

							// If post excerpt is not set generate it from the post content
						else {

							echo wp_trim_words( $top_post->post_content, apply_filters( 'dpsp_top_shared_posts_excerpt_length', 30 ), $more_string );

						}

							echo '</p>';

					}

						// Display total shares
					if ( $display_share_count && $total_share_count != 0 ) {
						echo '<p class="dpsp-top-shared-post-total-share-count">';
							echo '<span>' . __( 'Shares: ', 'social-pug' ) . '</span>';
							echo '<span>' . $total_share_count . '</span>';
						echo '</p>';
					}

						do_action( 'dpsp_top_shared_post_after', $top_post );

					// Close top post wrapper
					echo '</div>';
				}
			}

			echo ( isset( $args['after_widget'] ) ? $args['after_widget'] : '' );

		}

	}


	/**
	 * Outputs the options form in the back-end
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// Set saved values
		$title               = ( ! empty( $instance['title'] ) ? $instance['title'] : '' );
		$post_types          = ( ! empty( $instance['post_types'] ) ? $instance['post_types'] : [] );
		$display_thumbnail   = ( ! empty( $instance['display_thumbnail'] ) ? $instance['display_thumbnail'] : '' );
		$thumbnail_size      = ( ! empty( $instance['thumbnail_size'] ) ? $instance['thumbnail_size'] : 'medium' );
		$posts_count         = ( ! empty( $instance['posts_count'] ) ? $instance['posts_count'] : '5' );
		$display_excerpt     = ( ! empty( $instance['display_excerpt'] ) ? $instance['display_excerpt'] : '' );
		$display_share_count = ( ! empty( $instance['display_share_count'] ) ? $instance['display_share_count'] : '' );

		// Widget title
		echo '<p>';
			echo '<label class="dpsp-widget-section-title" for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', 'social-pug' ) . '</label>';
			echo '<input type="text" class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . $title . '" />';
		echo '</p>';

		// Post types to display
		echo '<p>';
			echo '<label class="dpsp-widget-section-title">' . __( 'Post types:', 'social-pug' ) . '</label>';

		foreach ( dpsp_get_post_types() as $post_type_slug => $post_type_name ) {
			echo '<label class="dpsp-settings-field-checkbox"><input type="checkbox" value="' . $post_type_slug . '" name="' . $this->get_field_name( 'post_types' ) . '[]" ' . ( in_array( $post_type_slug, $post_types ) ? 'checked="checked"' : '' ) . ' />' . $post_type_name . '</label>';
		}
		echo '</p>';

		// Posts options
		// Number of posts to show
		echo '<p>';
			echo '<label class="dpsp-widget-section-title">' . __( 'Post Options:', 'social-pug' ) . '</label>';

			echo '<label class="dpsp-widget-label" for="' . $this->get_field_id( 'posts_count' ) . '">' . __( 'Number of posts to show: ', 'social-pug' ) . '</label>';
			echo '<input type="text" name="' . $this->get_field_name( 'posts_count' ) . '" id="' . $this->get_field_id( 'posts_count' ) . '" size="3" value="' . $posts_count . '" /><br />';
		echo '</p>';

		// Display thumbnail
		echo '<p>';
			echo '<label class="dpsp-widget-label" for="' . $this->get_field_id( 'display_thumbnail' ) . '">' . __( 'Display featured image:', 'social-pug' ) . '</label>';
			echo '<input type="checkbox" id="' . $this->get_field_id( 'display_thumbnail' ) . '" name="' . $this->get_field_name( 'display_thumbnail' ) . '" value="yes" ' . checked( $display_thumbnail, 'yes', false ) . ' />';
		echo '</p>';

		// Thumbnail size
		echo '<p>';
			echo '<label class="dpsp-widget-label" for="' . $this->get_field_id( 'thumbnail_size' ) . '">' . __( 'Featured image size: ', 'social-pug' ) . '</label>';

			echo '<select id="' . $this->get_field_id( 'thumbnail_size' ) . '" name="' . $this->get_field_name( 'thumbnail_size' ) . '">';

		foreach ( get_intermediate_image_sizes() as $image_size ) {
			echo '<option value="' . $image_size . '" ' . selected( $thumbnail_size, $image_size, false ) . '>' . $image_size . '</option>';
		}

			echo '</select>';
		echo '</p>';

		// Display excerpt
		echo '<p>';
			echo '<label class="dpsp-widget-label" for="' . $this->get_field_id( 'display_excerpt' ) . '">' . __( 'Display post excerpt:', 'social-pug' ) . '</label>';
			echo '<input type="checkbox" id="' . $this->get_field_id( 'display_excerpt' ) . '" name="' . $this->get_field_name( 'display_excerpt' ) . '" value="yes" ' . checked( $display_excerpt, 'yes', false ) . ' />';
		echo '</p>';

		// Display share count
		echo '<p>';
			echo '<label class="dpsp-widget-label" for="' . $this->get_field_id( 'display_share_count' ) . '">' . __( 'Display post total share count:', 'social-pug' ) . '</label>';
			echo '<input type="checkbox" id="' . $this->get_field_id( 'display_share_count' ) . '" name="' . $this->get_field_name( 'display_share_count' ) . '" value="yes" ' . checked( $display_share_count, 'yes', false ) . ' />';
		echo '</p>';

	}


	/**
	 * Processing widget options on save.
	 *
	 * @param array $new_instance - The new options
	 * @param array $old_instance - The previous options
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance                        = [];
		$instance['title']               = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_types']          = ( ! empty( $new_instance['post_types'] ) ) ? $new_instance['post_types'] : '';
		$instance['posts_count']         = ( ! empty( $new_instance['posts_count'] ) ) ? $new_instance['posts_count'] : 5;
		$instance['display_thumbnail']   = ( ! empty( $new_instance['display_thumbnail'] ) ) ? $new_instance['display_thumbnail'] : '';
		$instance['thumbnail_size']      = ( ! empty( $new_instance['thumbnail_size'] ) ) ? $new_instance['thumbnail_size'] : 'medium';
		$instance['display_excerpt']     = ( ! empty( $new_instance['display_excerpt'] ) ) ? $new_instance['display_excerpt'] : '';
		$instance['display_share_count'] = ( ! empty( $new_instance['display_share_count'] ) ) ? $new_instance['display_share_count'] : '';

		return $instance;
	}
}
