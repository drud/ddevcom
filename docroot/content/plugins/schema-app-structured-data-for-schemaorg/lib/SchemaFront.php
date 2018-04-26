<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );
/**
 * Description of schema-editor
 *
 * @author Mark van Berkel
 */
class SchemaFront
{
    public $Settings;

    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct()
    {
		$this->Settings = get_option( 'schema_option_name' );

		add_action( 'init', array( $this, 'HandleCache' ) );
		add_action( 'wp', array( $this, 'LinkedOpenData' ), 10, 1 );

		// Do not change priority of following hooks as it breaks hook chaining and functions like wp_localize_script
		if ( ! empty( $this->Settings['SchemaDefaultLocation'] ) && $this->Settings['SchemaDefaultLocation'] == 'Footer' )
		{
			add_action( 'wp_footer', array( $this, 'hunch_schema_add' ) );
		}
		else
		{
			add_action( 'wp_head', array( $this, 'hunch_schema_add' ) );
		}

		if ( ! empty( $this->Settings['SchemaRemoveMicrodata'] ) )
		{
			add_action( 'template_redirect', array( $this, 'TemplateRedirect' ), 0 );
		}

		if ( ! empty( $this->Settings['ToolbarShowTestSchema'] ) )
		{
			add_action( 'admin_bar_menu', array( $this, 'AdminBarMenu' ), 999 );
		}

		// Default enabled
		if ( ! isset( $this->Settings['SchemaRemoveWPSEOMarkup'] ) || $this->Settings['SchemaRemoveWPSEOMarkup'] == 1 )
		{
			add_filter( 'wpseo_json_ld_output', array( $this, 'RemoveWPSEOJsonLD' ), 10, 2 );
		}

		// Priority 15 ensures it runs after Genesis itself has setup.
		add_action( 'genesis_setup', array( $this, 'GenesisSetup' ), 15 );

		add_action( 'amp_post_template_head', array( $this, 'AMPPostTemplateHead' ) );
		add_filter( 'amp_post_template_metadata', '__return_false' );
    }


	public function HandleCache()
	{
		if ( isset( $_GET['Action'], $_GET['URL'] ) && $_GET['Action'] == 'HSDeleteMarkupCache' )
		{
			delete_transient( 'HunchSchema-Markup-' . md5( $_GET['URL'] ) );

			header( 'HTTP/1.0 202 Accepted', true, 202 );

			exit;
		}
	}


    /**
     * hunch_schema_add is called to lookup schema.org or add default markup 
     */
    public function hunch_schema_add( $JSON = false )
    {
		global $post;

		if ( empty( $post ) )
		{
			return;
		}

		$DisableMarkup = is_singular() ? get_post_meta( $post->ID, '_HunchSchemaDisableMarkup', true ) : false;

		if ( ! $DisableMarkup )
		{
			$PostType = get_post_type();
			$SchemaThing = HunchSchema_Thing::factory( $PostType );

			$SchemaServer = new SchemaServer();
			$SchemaMarkup = $SchemaServer->getResource();

			$JSONSchemaMarkup = array();
			$SchemaMarkupType = '';

                        // If Custom schema markup is empty or not found
			if ( $SchemaMarkup === "" || $SchemaMarkup === false ) {

				$SchemaMarkupCustom = get_post_meta( $post->ID, '_HunchSchemaMarkup', true );

				if ( $SchemaMarkupCustom )
				{
					$SchemaMarkupType = 'Custom';
					$SchemaMarkup = $SchemaMarkupCustom;
				}
				else if ( isset( $SchemaThing ) )
				{
					$SchemaMarkupType = 'Default';
					$SchemaMarkup = $SchemaThing->getResource();
				}
			}
			else
			{
				$SchemaMarkupType = 'App';
			}

			do_action( 'hunch_schema_markup_render', $SchemaMarkup, $SchemaMarkupType, $post, $PostType, $JSON );

			$SchemaMarkup = apply_filters( 'hunch_schema_markup', $SchemaMarkup, $SchemaMarkupType, $post, $PostType );

			if ( $SchemaMarkup !== "" && ! is_null( $SchemaMarkup ) )
			{
				if ( $JSON )
				{
					$JSONSchemaMarkup[] = json_decode( $SchemaMarkup );
				}
				else
				{
					printf( '<!-- Schema App --><script type="application/ld+json">%s</script><!-- Schema App -->' . "\n", $SchemaMarkup );
				}
			}

			if ( ! empty( $this->Settings['SchemaWebSite'] ) && is_front_page() )
			{
				$SchemaMarkupWebSite = apply_filters( 'hunch_schema_markup_website', $SchemaThing->getWebSite(), $PostType );

				if ( ! empty( $SchemaMarkupWebSite ) )
				{
					if ( $JSON )
					{
						$JSONSchemaMarkup[] = json_decode( $SchemaMarkupWebSite );
					}
					else
					{
						printf( '<!-- Schema App Website --><script type="application/ld+json">%s</script><!-- Schema App Website -->' . "\n", $SchemaMarkupWebSite );
					}
				}
			}

			if ( ! empty( $this->Settings['SchemaBreadcrumb'] ) && method_exists( $SchemaThing, 'getBreadcrumb' ) )
			{
				$SchemaMarkupBreadcrumb = apply_filters( 'hunch_schema_markup_breadcrumb', $SchemaThing->getBreadcrumb(), $PostType );

				if ( ! empty( $SchemaMarkupBreadcrumb ) )
				{
					if ( $JSON )
					{
						$JSONSchemaMarkup[] = json_decode( $SchemaMarkupBreadcrumb );
					}
					else
					{
						printf( '<!-- Schema App Breadcrumb --><script type="application/ld+json">%s</script><!-- Schema App Breadcrumb -->' . "\n", $SchemaMarkupBreadcrumb );
					}
				}
			}

			if ( $JSON && ! empty( $JSONSchemaMarkup ) )
			{
				if ( count( $JSONSchemaMarkup ) == 1 )
				{
					$JSONSchemaMarkup = reset( $JSONSchemaMarkup );

					print json_encode( $JSONSchemaMarkup );
				}
				else
				{
					print json_encode( $JSONSchemaMarkup );
				}
			}
		}     
    }


	public function LinkedOpenData( $WP )
	{
		if ( ! empty( $this->Settings['SchemaLinkedOpenData'] ) )
		{
			$RequestHeaders = array();

			if ( function_exists( 'apache_request_headers' ) )
			{
				$RequestHeaders = apache_request_headers();
			}

			// preg_match( '/\.jsonld$/i', $_SERVER['REQUEST_URI'] )
			if (  ( ! empty( $_GET['format'] ) && $_GET['format'] == 'jsonld' )  ||  ( ! empty( $RequestHeaders['Accept'] ) && $RequestHeaders['Accept'] == 'application/json' )  )
			{
				$this->hunch_schema_add( true );

				exit;
			}
		}
	}


	public function TemplateRedirect()
	{
		ob_start( array( $this, 'RemoveMicrodata' ) );
	}


	public function RemoveMicrodata( $Buffer )
	{
		$Buffer = preg_replace( '/[\s\n]*<(link|meta)(\s|[^>]+\s)itemprop=[\'"][^\'"]*[\'"][^>]*>[\s\n]*/imS', '', $Buffer );

		for ( $I = 1; $I <= 6; $I++ )
		{
			$Buffer = preg_replace( '/(<[^>]*)\sitem(scope|type|prop)(=[\'"][^\'"]*[\'"])?([^>]*>)/imS', '$1$4', $Buffer );
		}

		return $Buffer;
	}


	public function RemoveWPSEOJsonLD( $data, $context )
	{
		if ( in_array( $context, array( 'website', 'company', 'person' ) ) )
		{
			return array();
		}

		return $data;
	}


	public function AdminBarMenu( $WPAdminBar )
	{
		$Permalink = HunchSchema_Thing::getPermalink();

		if ( $Permalink )
		{
			$Node = array
			(
				'id'    => 'Hunch-Schema',
				'title' => 'Test Schema',
				'href'  => 'https://developers.google.com/structured-data/testing-tool?url=' . urlencode( $Permalink ),
				'meta'  => array
				(
					'class' => 'Hunch-Schema',
					'target' => '_blank',
				),
			);

			$WPAdminBar->add_node( $Node );
		}
	}


	public function GenesisSetup()
	{
		$Attributes = get_option( 'schema_option_name_genesis' );

		if ( $Attributes )
		{
			foreach ( $Attributes as $Key => $Value )
			{
				add_filter( 'genesis_attr_' . $Key, array( $this, 'GenesisAttribute' ), 20 );
			}
		}
	}


	public function GenesisAttribute( $Attribute )
	{
		$Attribute['itemtype'] = '';
		$Attribute['itemprop'] = '';
		$Attribute['itemscope'] = '';

		return $Attribute;
	}


	public function AMPPostTemplateHead( $Template )
	{
		$this->hunch_schema_add( false );
	}

}