<?php

namespace Mediavine\Grow;

if ( class_exists( 'Social_Pug' ) ) {
	class Share_Counts extends \Social_Pug {

		/**
		 * WordPress post meta key for the last updated timestamp
		 * @var string $last_updated_key
		 */
		public static $last_updated_key = 'dpsp_networks_shares_last_updated';

		private static $instance = null;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->init();
			}

			return self::$instance;
		}

		public function init() {
		}

		/**
		 * Set the last updated timestamp to a value very far in the past so that the value will be updated when it is next checked
		 */
		public static function invalidate_all() {
			$posts = self::get_all_posts_with_counts();
			foreach ( $posts as $post ) {
				\update_post_meta( $post->ID, self::$last_updated_key, 1 );
			}
		}

		/**
		 * Return an array with all posts that have share counts
		 * @return \WP_Post[]
		 */
		public static function get_all_posts_with_counts() {
			$args = [
				'meta_query' => [
					[
						'key'     => self::$last_updated_key,
						'compare' => 'EXISTS',
					],
				],
				'nopaging'   => true,
			];

			return \get_posts( $args );
		}
	}
}
