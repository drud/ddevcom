<?php
/*
*
*	Admin Bar Menu
*	
*	@since 1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


add_action( 'admin_bar_menu', 'schema_wp_admin_bar_menu_items', 99 );
/*
* Add Google Rich Snippet Test Tool link to admin bar menu
*	
* @since 1.0.0
*/
function schema_wp_admin_bar_menu_items( $admin_bar ) {
		
	/* This print_r will show you the current contents of the admin menu bar, use it if you want to examine the $admin_bar array
	* echo "<pre>";
	* print_r($admin_bar);
	* echo "</pre>";
	*/
		
	// If it's admin page, then get out!
	//
	if ( is_admin() ) 
		return $admin_bar;
	
	$schema_test_link = schema_wp_get_option( 'schema_test_link' );
	
	if ( $schema_test_link != 'yes' ) 
		return $admin_bar;
		
	// Get current page url
	//
	$url =  'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	
	// If user can't publish posts, then get out
	//
	if ( ! current_user_can( 'publish_posts' ) ) 
		return $admin_bar;
	
	// Structured Data Testing Tool
	$admin_bar->add_menu( array(
		'id'	=> 'schema-test-item',
		'title'	=> '<i></i>' . __('Schema', 'schema-premium'),
		'href'	=> get_admin_url() . 'edit.php?post_type=schema',
		'meta'	=> array(
			'title'		=> __('Structured Data Testing Tool', 'schema-premium'),
			'class'		=> 'schema_google_developers'
		),
	) );
	
	$admin_bar->add_menu(array(
		'parent' => 'schema-test-item', 
		'title' => __('Rich Results Test', 'schema-premium'), 
		'id' => 'schema-test-rich-item-link', 
		'href' => 'https://search.google.com/test/rich-results?view=search-preview&url='.$url,
		'meta'	=> array(
			'title'		=> __('Rich Results Test', 'schema-premium'),
			'class'		=> 'schema_google_developers_rich_link',
			'target'	=> __('_blank')
		),	
	) );

	$admin_bar->add_menu(array(
		'parent' => 'schema-test-item', 
		'title' => __('Structured Data Testing Tool', 'schema-premium'), 
		'id' => 'schema-test-item-link', 
		'href' => 'https://developers.google.com/structured-data/testing-tool/?url='.$url,
		'meta'	=> array(
			'title'		=> __('Rich Results Test', 'schema-premium'),
			'class'		=> 'schema_google_developers_link',
			'target'	=> __('_blank')
		),	
	) );
}
