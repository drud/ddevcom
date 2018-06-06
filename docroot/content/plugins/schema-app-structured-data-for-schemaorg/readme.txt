=== Schema App Structured Data ===
Contributors: vberkel
Plugin Name: Schema App Structured Data
Tags: schema, structured data, schema.org, rich snippets, json-ld
Author URI: https://www.hunchmanifest.com
Author: Mark van Berkel (vberkel)
Requires at least: 3.5
Tested up to: 4.8
Stable tag: 1.9.10
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Get Schema.org structured data for all pages, posts, categories and profile pages on activation. Use Schema App to customize any Schema markup. 

== Description ==

**"There are several dedicated plugins that you can use. In my opinion, the best is Schema App Structured Data."**
[Neil Patel's Blog on Structured Data](http://neilpatel.com/blog/structured-data/)

**What Markup does Schema App Wordpress Plugin Create?**

By activating the plugin Schema App Wordpress plugin automatically creates [schema.org](http://schema.org/) markup for the all your pages, posts, author and category content leveraging information that already exists in your Wordpress website. Just activate the plugin, adding your logo and name of your business, BAM, your content is optimized to be fully understood by search engines resulting in higher traffic, higher click through rates and more.  The plugin also provides all three Google Site Structure features including Breadcrumbs, Sitelinks Searchbox and Your Site Name in Results.  Schema App Wordpress plugin also integrates with [Schema App Tools](https://www.schemaapp.com) to automatically deploy custom content (see below). 

**Video Feature in version 1.9** 

[Google's Powerful Video Features](https://developers.google.com/search/docs/data-types/videos) are now added automatically for all YouTube videos. 

**What type of markup is automatically created with this plugin?**

* Page : http://schema.org/Article
* Post : http://schema.org/BlogPosting
* Search : http://search.org/SearchResultsPage
* Author : http://schema.org/ProfilePage
* Category : http://schema.org/CollectionPage
* Tag : http://schema.org/CollectionPage
* Blog : http://schema.org/Blog
* BreadcrumbList : http://schema.org/BreadcrumbList
* WebSite : http://schema.org/WebSite

All of these pages get extremely detailed schema.org data based on what's possibly mapped from the database. Customization of Page and Post schema markup can be done through default settings (e.g. posts can default to NewsArticle) as well as by directly editing the generated JSON-LD for each page. 

**[Schema App Wordpress Plugin FAQ](https://www.schemaapp.com/wordpress-plugin/faq/)**

**Extended Optimization with Schema App Tools**

There is a lot of benefit of adding schema markup to fully describe your business including increased organic traffic, higher search rank and rich results. To achieve this you need to optimize your whole website with schema markup. 

[Schema App Tools](https://www.schemaapp.com/) enable marketers to create custom [schema.org](http://schema.org/) markup for a website's Local Business,  Organization, Services, Reviews, Contact Page and more. Schema App Tools have the complete [schema.org](http://schema.org/) vocabulary, requires no JSON-LD coding, and help you do ongoing schema markup maintenance when Google changes their recommendations. [Learn more about the Schema App Tools](https://www.schemaapp.com/schema-org-json-ld-markup-editor/). 

Schema App Tools subscriptions include support from our experts in schema markup and access to the Schema App [Advanced Wordpress Plugin](https://www.schemaapp.com/schema-app-advanced-wordpress-plugin/). The Advanced Plugin compliments this base Schema Plugin by adding capabilities including:

* WooCommerce Products
* Link Category & Tag Definitions to Wikipedia, Wikidata
* Page & Post Review Widget 
* Custom Post & Field Mapping

**Manage multiple sites?**

Schema App Tools allow you to easily manage schema markup across multiple domains and provides scalable solutions for sites with large amounts of data. If you want to add schema markup to your WordPress website in the most productive and smart way, it's Schema App. 

**Using WooCommerce?**

Schema App also offers a WooCommerce plugin to optimize your products and get product rich snippets. Learn more here. https://www.schemaapp.com/product/schema-woocommerce-plugin/

== Installation ==

Installation is straightforward

1. Upload hunch-schema to the /wp-content/plugins/ directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Configure AMP publisher settings for Plugin in Wordpress under Settings>Schema App
1. For greater organic search results [register with Schema App](https://hunchmanifest.leadpages.co/leadbox/143ff4a73f72a2%3A1601ca700346dc/5764878782431232/) to extend your content structured data. 
1. Add the Account ID to WP Admin > Settings > Schema App from the registration email and found at http://app.schemaapp.com/wordpress

== Frequently Asked Questions ==
You\'ll find the [FAQ on SchemaApp.com] (http://www.schemaapp.com/wordpress/faq/).

== Screenshots ==
1. Schema App Tools Admin
2. Settings Menu Navigation
3. Schema.org Page Meta Box
4. Schema.org Editor UI
5. Link to Validation

== Changelog ==
= 1.9.10 = 
- Fix, loading double encoded Cyrillic characters in URL lookup

= 1.9.9 =
- Feature, add setting for schema in header or footer
- Fix, Advanced Plugin Rating Widget Javascript enqueue priority

= 1.9.8 =
- Fix, Ignore cached null returned

= 1.9.7 = 
- Fix, Improve cached data checking 

= 1.9.6 = 
- Fix, WooCommerce Activation error
- Fix, Breadcrumb List Item, unique @id
- Fix, CollectionPage items check for and use configured default
- Improve, add low priority to hunch_schema_add function, behind other JS

= 1.9.5 = 
- Fix, API error in PHP versions < 5.4

= 1.9.4 = 
- Fix, caching when no Schema App data found

= 1.9.3 = 
- Improve, switch remote schema lookup to faster Schema Delivery Network (CDN)
- Improve, move JSON-LD output to wp_footer for faster loading pages
- Feature, add filter for Wordpress SEO to remove WebSite, Company and Person data items

= 1.9.2 = 
- Fix, YouTube Video warning

= 1.9.1 =
- Fix, Warning for pages without post data
- Fix, JSON-LD Editor ignores input with script element
- Fix, Settings set as Default BlogPosting

= 1.9.0 =
- Feature, VideoObject markup for YouTube videos in Pages and Posts
- Feature, Page and Posts Default schema class options
- Improve, Settings Page
- Fix, datePublished change to improve localization

= 1.8.1 =
- Fix, Genesis deactivation settings
- Fix, Article Image Missing for Blog Page

= 1.8.0 =
- Feature, AMP structured data support to improve on the WP /amp/ page’s structured data

= 1.7.7 = 
- Fix, improve compatibility with Advanced
- Info, tested on WP 4.8

= 1.7.6 = 
- Fix, activation improvements, new hooks

= 1.7.5 = 
- Fix, adjust filter 'hunch_schema_markup', action 'hunch_schema_markup_render'

= 1.7.4 = 
- Fix, WooCommerce activation

= 1.7.3 = 
- Feature, integration point for Schema App Advanced
- Fix, cannot access property PHP notice

= 1.7.2 =
- Feature, For Page markup add name, url, comment, commentCount
- Fix, Improve Linked Data output

= 1.7.1 =
- Fix, Server configuration
- Fix, Missing description, use own method

= 1.7.0 = 
- Feature, Microdata filter option
- Fix, communication with custom Schema App markup. Try Curl first otherwise use file_get_contents
- Fix, Simplify Activation Sequence
- Documentation, improve marketing copy, instructions

= 1.6.1 =
- Fix, Server Errors on some web server

= 1.6.0 = 
- Feature, Add Linked Data Support
- Feature, Tag Pages, add CollectionPage schema markup
- Fix, Errors with Javascript URL, PHP Notices
- Fix, Publisher details missing from list
- Fix, Admin notice links

= 1.5.1 =
- Fix, activation sequence

= 1.5.0 =
- Feature, Improve Schema App speed by storing custom data in WP as transient data
- Feature, Genesis Framework Filtering options 
- Fix, Show Page & Post Description default in admin
- Fix, Setting page notice for default image

= 1.4.2 =
- Feature, Default Article Image Object option
- Fix, Improve custom markup form feedback

= 1.4.1 =
- Fix, Publisher details for Article, BlogPosting

= 1.4.0 = 
- Feature, provide in post editing for custom schema markup

= 1.3.4 = 
- Fix, error with custom post types for WebSite markup

= 1.3.3 = 
- Feature, add wordCount, split keyword many properties

= 1.3.2 =
- Fix, Add to BlogPosting default needed switch to HTTPS

= 1.3.1 = 
- Fix, BreadcrumbList @id conflicts

= 1.3.0 = 
- Feature, Website for Google Site Search Box
- Feature, Website for Google Site Name
- Feature, Filter to disable markup from PHP usable in Themes, Templates
- Fix, BreadcrumbList error on other post types

= 1.2.1 = 
- Fix, error with access settings

= 1.2.0 =
- Feature, BreadcrumbList for Page & Posts
- Feature, Meta Box Layout Improvement
- Fix, Javascript conflict for admin sections elements

= 1.1.4 = 
- Fix, Show Custom Markup for Latest Blog Homepages

= 1.1.3 = 
- Fix, Author details on Post edit screen
- Fix, Loading of assets on plugin settings page for SSL site
- Fix, jQuery conflict on Post edit screen
- Feature, Added link in Toolbar to test markup

= 1.1.2 = 
- Fix, Javascript version to force reload

= 1.1.1 = 
- Fix, Add to Default Markup button

= 1.1.0 = 
- Feature, extend posts and page markup
- Documentation, improve setup page instructions and descriptions

= 1.0.0 = 
- Feature, Pages option for more specific types
- Feature, Disable markup option
- Feature, Author's ProfilePage improvement
- Feature, Add 10 comments, total commentCount to blogPosting, Blog and Category pages
- Feature, BlogPosting add keywords using tags
- Feature, Add the Blog page as type schema.org/Blog

= 0.5.9 = 
- Feature, Default markup if no featured image set add first image in content
- Fix, Publisher logo fallback markup
- Fix, Canonical URL check with get_permalink

= 0.5.8 = 
- Fix, Improve Category (CollectionPage) data
- Documentation, Improve Quick Guide and Settings instructions

= 0.5.7 = 
- Fix, Publisher image dimensions
- Fix, Author name for Pages
- Fix, API results filter null

= 0.5.6 = 
- Feature, Rename menu item 'Schema Settings' as 'Schema App'
- Feature, Admin Settings redesign as tabs
- Feature, Tab for Quick Guide
- Feature, License Tab for enabling WooCommerce plugin extension

= 0.5.5 = 
- Fix, Setting Publisher Image Upload
- Feature, Add Admin Notices
- Security, Prevent scripts being accessed directly

= 0.5.4 = 
- Fix for Publisher Logo Upload

= 0.5.3 = 
- Fix Editor JSON-LD Preview

= 0.5.2 = 
- Timeout after 5 seconds
- Tested up to WP 4.4.1

= 0.5.1 = 
- Suppress Warning when no content found

= 0.5.0 = 
- Extend Page and Post Markup for Accelerated Mobile Pages

= 0.4.4 = 
- Plugin Description Update
- Fix Meta Box Update (Create) Link

= 0.4.3 = 
- Fix Meta Box Update Link

= 0.4.2 = 
- Fix Category page error

= 0.4.1 = 
- Fix PHP Warning from empty Graph ID

= 0.4.0 = 
- Add Author, Category and Search page types
- Show formatted and default markup in Meta Box
- Change date formats to ISO8601
- Code refactoring
- Add Banner and Icon

= 0.3.3 = 
- Fixes to getResource routine

= 0.3.2 = 
- Fix PHP warning

= 0.3.1 = 
- Fix server file_get_contents warning

= 0.3.0 =
- When no data found in Schema App, add some default page and post structured data

= 0.2.0 =
- Add Post and Page Edit meta box
- Server does caching, switch from Javascript to PHP API to retrieve data for header

= 0.1.0 =
- First version 