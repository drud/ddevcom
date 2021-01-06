# Imagify Partner for WordPress

This php class allows WordPress plugin developers to promote Imagify through their own plugin.

## What it does

It allows to create a link that will install and activate the Imagify plugin for WordPress: all is done with one click.
Then a partner ID is sent to our server when the user creates an Imagify account within the Imagify plugin.
In case the user creates the account outside the plugin, the partner ID is sent when the API key is filled and saved in the plugin settings.  
The link should be displayed only if an Imagify API key is not already stored in the database, and Imagify not already activated (tests are provided).  
See the example below for more details.

If you want to be part of this affiliation program, please drop us a line at contact@imagify.io.

## Bugs

If you find an issue in the php class, please let us know [here](https://github.com/wp-media/wp-imagify-partner/issues).
Be advised, this point of contact is to be used to report bugs and not to receive support.

To disclose a security issue to our team, please reach out to contact@imagify.io.

## Want to know more about our WordPress plugins? 

Visit [wp-media.me](https://wp-media.me/?utm_source=github&utm_medium=wp-imagify-partner_profile).

We also make other plugins that help speed up WordPress websites:

* [Imagify](https://imagify.io): it's a great WordPress plugin to optimize your images and speed up your website (but since you're here, you probably already know that).
* [WP Rocket](https://wp-rocket.me/): a user friendly WordPress plugin for page caching, cache preloading, static files compression, lazy loading, and more.

## Example

```php
define( 'EXAMPLE_IMAGIFY_PARTNER_ID' , 'test' );

add_action( 'plugins_loaded', 'example_plugin_init' );
/**
 * Init.
 */
function example_plugin_init() {
	if ( ! is_admin() ) {
		return;
	}

	require_once dirname( __FILE__ ) . '/vendor/class-imagify-partner.php';

	if ( Imagify_Partner::has_imagify_api_key() ) {
		return;
	}

	// The class needs to be initiated to launch hooks.
	$imagify = new Imagify_Partner( EXAMPLE_IMAGIFY_PARTNER_ID );
	$imagify->init();

	add_action( 'admin_menu', 'example_plugin_menu' );
}

/**
 * Add a submenu.
 */
function example_plugin_menu() {
	add_submenu_page( 'options-general.php', 'Example Plugin', 'Example Plugin', 'install_plugins', 'example-plugin', 'example_plugin_page' );
}

/**
 * The plugin page displaying a link to install Imagify plugin.
 */
function example_plugin_page() {
	echo '<div class="wrap">';
	echo '<h1>Example Plugin</h1>';
	echo '<div class="card"><p>';

	if ( Imagify_Partner::is_imagify_activated() ) {
		// Imagify is activated, the user only needs to set the API key (the 3 steps banner should be displaying).
		if ( Imagify_Partner::is_success() ) {
			_e( 'Imagify has been successfully activated.', 'example-plugin' );
		} else {
			_e( 'Imagify is already activated.', 'example-plugin' );
		}
	} else {
		$imagify = new Imagify_Partner( EXAMPLE_IMAGIFY_PARTNER_ID );

		if ( Imagify_Partner::is_imagify_installed() ) {
			$button_text = __( 'Activate Imagify', 'example-plugin' );
		} else {
			$button_text = __( 'Install and activate Imagify', 'example-plugin' );
		}

		echo '<a class="button-primary" href="' . esc_url( $imagify->get_post_install_url() ) . '">' . $button_text . '</a>';
	}

	echo '</p></div>';
	echo '</div>';
}
```
