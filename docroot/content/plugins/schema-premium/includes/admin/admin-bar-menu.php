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
	if (is_admin()) return $admin_bar;
	
	$schema_test_link = schema_wp_get_option( 'schema_test_link' );
	
	if ( $schema_test_link != 'yes' ) return $admin_bar;
		
	// Get current page url
	$url =  'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	
	// If user can't publish posts, then get out
	if ( ! current_user_can( 'publish_posts' ) ) return $admin_bar;
	
	// Structured Data Testing Tool
	$admin_bar->add_menu( array(
		'id'	=> 'schema-test-item',
		'title'	=> __('', 'schema-premium'),
		'href'	=> 'https://developers.google.com/structured-data/testing-tool/?url='.$url,
		'meta'	=> array(
			'title'		=> __('Structured Data Testing Tool', 'schema-premium'),
			'class'		=> 'schema_google_developers',
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
	
	// Rich Results Test
	$admin_bar->add_menu( array(
		'id'	=> 'schema-test-rich-item',
		'title'	=> __('', 'schema-premium'),
		'href'	=> 'https://search.google.com/test/rich-results?view=search-preview&url='.$url,
		'meta'	=> array(
			'title'		=> __('Rich Results Test', 'schema-premium'),
			'class'		=> 'schema_google_developers_rich',
			'target'	=> __('_blank')
		),			
	) );
	
	$admin_bar->add_menu(array(
		'parent' => 'schema-test-rich-item', 
		'title' => __('Rich Results Test', 'schema-premium'), 
		'id' => 'schema-test-rich-item-link', 
		'href' => 'https://search.google.com/test/rich-results?view=search-preview&url='.$url,
		'meta'	=> array(
			'title'		=> __('Rich Results Test', 'schema-premium'),
			'class'		=> 'schema_google_developers_rich_link',
			'target'	=> __('_blank')
		),	
	) );
}


// on backend area
//add_action( 'admin_head', 'schema_wp_admin_bar_styles' );
// on frontend area
add_action( 'wp_head', 'schema_wp_admin_bar_styles' );
/*
* Add styles to admin bar
*
* @since 1.0.0
*/
function schema_wp_admin_bar_styles() {
	
	// If it's admin page, then get out!
	if (is_admin()) return;
	
	if ( ! is_admin_bar_showing() ) return;
	
	$schema_test_link = schema_wp_get_option( 'schema_test_link' );
	
	if ( $schema_test_link != 'yes' ) return;
	
	?>
	<style type="text/css">
		/* admin bar */
		.schema_google_developers a {
			padding-left:20px !important;
			background:	transparent url('<?php echo SCHEMAPREMIUM_PLUGIN_URL; ?>assets/images/admin-bar/google-developers.png') 8px 50% no-repeat !important;
		}
		.schema_google_developers a:hover {
			background:	transparent url('<?php echo SCHEMAPREMIUM_PLUGIN_URL; ?>assets/images/admin-bar/google-developers-hover.png') 8px 50% no-repeat !important;
		}
		.schema_google_developers_link a,
		.schema_google_developers_link a:hover {
			background:	none !important;
		}
		.schema_google_developers_rich a {
			padding-left:20px !important;
			background:	transparent url('<?php echo SCHEMAPREMIUM_PLUGIN_URL; ?>assets/images/admin-bar/icons8-developer-mode-16.png') 8px 50% no-repeat !important;
		}
		.schema_google_developers_rich a:hover {
			background:	transparent url('<?php echo SCHEMAPREMIUM_PLUGIN_URL; ?>assets/images/admin-bar/icons8-developer-mode-16-hover.png') 8px 50% no-repeat !important;
		}
		.schema_google_developers_rich_link a,
		.schema_google_developers_rich_link a:hover {
			background:	none !important;
		}s
	</style>
<?php
}
