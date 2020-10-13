<?php
/**
 * @package Schema FAQ - Block Helper
 * @category Core
 * @author Hesham Zebida
 * @version 1.0 
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_Premium_ACF_BlockHelper') ) :
/**
 * Block Helper
 *
 * @since 1.0
 * return array	
 */
class Schema_Premium_ACF_BlockHelper
{
    /**
     * Gets ACF fields for a specific block on a given post
     * @author Jens Soegaard <jens@jenssogaard.com>
     */
	
	public function getBlockFromPage(string $block_name, int $post_id)
    {
        $post = get_post($post_id);

        if (!$post) return false;
        
		$blocks_data	= array();
		$blocks 		= parse_blocks($post->post_content);
		
		// Find all blocks that match our block
		//
		// @since 1.1.1
		//
		$schema_blocks	= schema_premium_recursive_array_search($blocks, 'blockName', $block_name);
		
		// Debug
		//echo'<pre>';print_r($schema_blocks);echo'</pre>';//exit;
        
		if ($schema_blocks) {
			return $schema_blocks;
        }

        return false;
		
		/*
		if ($blocks) {
            foreach ($blocks as $block) {
                if($block['blockName'] == $block_name) {
                   $blocks_data[] = $block['attrs']['data'];
                }
				
            }
			return $blocks_data;
        }

        return false;
		*/
    }
	
    /**
     * Return post id by checking for post instance, second POST param post_id (eg. if ACF ajax preview from Gutenberg), third GET page_id (WP preview)
     * @author Jens Soegaard <jens@jenssogaard.com>
     */
   /* public function getPostId()
    {
        if (get_the_ID()) return get_the_ID();
        if (isset($_POST['post_id'])) return $_POST['post_id'];
        if (isset($_GET['page_id'])) return $_GET['page_id'];

        return false;
    }*/
}

endif;
