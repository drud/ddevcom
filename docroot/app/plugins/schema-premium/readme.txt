=== Schema Premium ===
Contributors: hishaman, schemapress
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NGVUBT2QXN7YL
Tags: schema, schema.org, json, json-ld, google, seo, structured data, markup, search engine, search, rich snippets, breadcrumbs, social, post, page, plugin, wordpress, content, article, news, search results, site name, knowledge graph, social, social profiles, keywords, meta-tags, metadata, tags, categories, optimize, ranking, search engine optimization, search engines, serp, sitelinks, google sitelinks, sitelinks search box, google sitelinks search box, semantic, structured, canonical, custom post types, post type, title, terms, media, images, thumb, featured, url, video, video markup, video object, VideoObject, video schema, audio object, AudioObject, audio schema, audio, sameAs, about, contact, amp, mobile, taxonomy
Requires At Least: 4.0
Tested Up To: 5.6
Requires PHP: 5.6.20
Stable Tag: 1.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Get the next generation of Schema Structured Data to enhance your WordPress site presentation in Google search results.

== Description ==

Super fast, light-weight plugin for adding schema.org structured data markup in recommended JSON-LD format automatically to WordPress sites.

Enhanced Presentation in Search Results By including structured data appropriate to your content, your site can enhance its search results and presentation.

Check out the [Plugin Homepage](https://schema.press/) for more info and [documentation](https://schema.press/docs-premium/).


### What is Schema markup?

Schema markup is code (semantic vocabulary) that you put on your website to help the search engines return more informative results for users. So, Schema is not just for SEO reasons, it’s also for the benefit of the searcher. 

### Schema Key Features

* Easy to use, set it and forget it, with minimal settings.
* Support for different schema.org types
* Enable Schema types at once per post type or post category.
* Enable Schema types anywhere you want on your site content.
* Integration: Customize source data of schema.org properties.
* Valid markup, test it in Google Structured Data Testing Tool.
* Output JSON-LD format, the most recommended by Google.
* Reuse data saved in post meta, which is created by other plugins.
* Extensible, means you can extend its functionality via other plugins, extensions or within your Theme’s functions.php file.

== Installation ==

1. Upload the entire `schema-premium` folder to the `/wp-content/plugins/` directory
2. DO NOT change the name of the `schema-premium` folder
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Navigate to the `Schema > Settings` menu to configure the plugin
5. If you cache your site, make sure to clear cache after configuring the plugin settings.

== Frequently Asked Questions ==

= The plugin isn't working or have a bug? =

Send us detailed information about the issue by opening a [support ticket](https://schema.press/submit-ticket/) and we will get back to you.

= Is there any Documentation for this plugin? =

Indeed, detailed information about the plugin can be found on the [documentation section](https://schema.press/docs-premium/) on our website.

= Are you going to add support for new schema.org types in the future? =

Yes!

== Changelog ==

= 1.2.2 =

* Fix: Product:review was not set correctly in markup output.
* Fix: CreativeWork and Product by adding missing bestRating and worstRating properties.
* Fix: Corrected update notices CSS classes to notice instead of update-nag.
* Fix: Function that loads plugin first was missing 2 parameters.
* Update: Pumped tested WordPress version to 5.6 release.

= 1.2.1 =
* Fix: Review markup by adding aggregateRating and review to itemReviewed.
* Fix: JobPosting description property markup to have full content with HTML.
* Fix: VideoObject extension, use WP_oEmbed get_provider instead of discover function.
* Fix: PHP error when calling properties function while $itemReviewed is not an object.
* Fix: PHP warning when trying to get media object.
* Fix: PHP warning when viewing post type archive page.
* Fix: PHP warning when multiple parameter is not set in ACF country select field.
* Fix: PHP warning when trying to get properties of itemReviewed.
* Fix: hiringOrganization logo property field values select.
* Fix: ItemList in Post type archive markup. 
* Fix: Modified time output in Blog posts structured data.
* Fix: Missing function was required for WPHeader and WPFooter.
* Enhancement: Added new filter schema_knowledge_graph_output.
* Enhancement: Added url and description properties to publisher array.
* Enhancement: Added embedUrl to VideoObject markup.
* Enhancement: Added @id property.
* Enhancement: Added $parent_group variable to auto field creation loop.
* Enhancement: Added full_content type to property fields.
* Enhancement: Added department property to local server test.
* Enhancement: Removed Yes/No text on the Opening Hours Close field.
* Enhancement: Use Website URL from plugin settings in publisher property. 
* Enhancement: Use site_url and deprecate schema_wp_get_home_url.
* Modification: Disabled ACF Address field extension since it is not complete.
* Update: Updated EDD license update class to version 1.8.0 release.
* Update: Updated ACF Pro to version 5.9.3 release.
* Update: Pumped tested WordPress version to 5.5.3 release.

= 1.2 =
* Fix: Markup warning for sameAs property.
* Fix: PHP notice in author extension and setup wizard.
* Fix: PHP notice when calling comments markup function.
* Fix: PHP notice when post id is not set on some edit screens.
* Fix: Exclusion rules for post ID, and post categories.
* Fix: General tab key and id was misspelled.
* Fix: Error due to conflict function name, changed to sp_is_edit_page.
* Fix: Warnings in VideoObject extension, added contentUrl and embedUrl properties.
* Fix: Duplicate markup when checking post categories.
* Enhancement: Added support for schema.org Thing.
* Enhancement: Added support for schema.org CreativeWork.
* Enhancement: Added support for schema.org Organization.
* Enhancement: Added support for schema.org Book, and its subtype Audiobook.
* Enhancement: Added support for SocialMediaPosting subtypes.
* Enhancement: Added new options page for creating schema types.
* Enhancement: Added new integration for WP Job Manager plugin.
* Enhancement: Added new function to return supported schema.org types.
* Enhancement: Added new function to return an array of available countries.
* Enhancement: Added new function to retrieve attachment url from id.
* Enhancement: Added new function to get address markup.
* Enhancement: Added new function to subtract words by a number of characters.
* Enhancement: Added new function to force remove shortcodes from description.
* Enhancement: Added new feature to fix local server urls when testing.
* Enhancement: Added new filter schema_location_rules.
* Enhancement: Added new filter schema_add_to_properties.
* Enhancement: Added new filter schema_post_type_archive_enable.
* Enhancement: Added link to Schema post type in edit screen.
* Enhancement: Added dashicon and conditional_logic parameters to property tabs.
* Enhancement: Added discussionUrl property.
* Enhancement: Added missing translations and instructions for VideoObject extension.
* Enhancement: Added links for specific posts and pages in schema columns page.
* Enhancement: Do not store schema type comment in post meta.
* Enhancement: Allow disabling Price Range property field.
* Enhancement: Moved BlogPosting file under SocialMediaPosting sub folder.
* Enhancement: Switched all @context urls to https.
* Enhancement: Switched gravatar urls to https.
* Enhancement: Schema types properties has its own function for ACF fields.
* Enhancement: Make sure Thing and CreativeWork classes loads earlier.
* Enhancement: Allow priceRange example $10-20 in fixed values and post meta.
* Enhancement: Speed up queries in back-end when getting all post meta keys.
* Enhancement: Re-order settings admin menu item.
* Enhancement: Reduced code base by making use of reusable functions.
* Enhancement: Modified some wording in back-end to make it more informational.
* Update: Updated ACF Pro to version 5.9.1 release.
* Update: Pumped tested WordPress version to 5.5.1 release.

= 1.1.4.4 =
* Fix: Plugin upgrade.

= 1.1.4.3 =
* Fix: Paywalled Content properties were not pulled properly.
* Enhancement: Changed default schema type from Article to WebPage.
* Enhancement: Modified filter name for truncating title.
* Update: Pumped tested WordPress version to 5.4.2 release.

= 1.1.4.2 = 
* Fix: Recipe image markup output.
* Fix: Properties post meta fields for images.

= 1.1.4.1 = 
* Fix: The check location target match function retuns invalid data.
* Enhancement: Corrected typo in Recipe post meta fields.

= 1.1.4 = 
* Enhancement: Added new parameters to ACF star rating field.
* Enhancement: Added new global variable $schema_markup_singular.
* Enhancement: Added isolated Bootstrap 4.1.0 CSS resource. 
* Enhancement: Added new function schema_premium_is_match;
* Enhancement: Set street address 2 and 3 fields value to disabled.
* Update: Updated ACF Pro to version 5.8.11 release.

= 1.1.3.1 = 
* Fix: Loading ACF PRO properly.
* Fix: totalTime property for schema.org Recipe type.
* Enhancement: Added repeated field for images in schema.org Recipe type.
* Enhancement: Added new features to ACF custom rating stars field. 
* Enhancement: Added new data types to Columns class for use by extensions.
* Update: Pumped tested WordPress version to 5.4.1 release.

= 1.1.3 =
* Fix: PHP error when calling get_current_screen to load ACF styles. 

= 1.1.2.9 =
* Fix: PHP error due to calling get_field function in custom location rules.
* Enhancement: Added support for SpecialAnnouncement schema.

= 1.1.2.8 =
* Fix: Enable Blog markup on plugin activation, update default settings.
* Fix: Properties of sub-types were not pulled correctly.
* Fix: PHP error when calling wp_parse_url function.
* Fix: PHP notices across the plugin code.
* Enhancement: Added support for WebPage: QAPage for Questions and Answers.
* Enhancement: Added support for most LocalBusiness schema sub-types.
* Enhancement: Added automatic integration for DW Question Answer plugin.
* Enhancement: Added automatic integration for Co-Authors Plus plugin.
* Enhancement: Added automatic integration for bbPress replies in markup. 
* Enhancement: Added author url or website check in markup output.
* Enhancement: Added new parameter $author_id to author array function.
* Enhancement: Added new functions to parse WP shortcodes from content.
* Enhancement: Added new feature to allow adding custom markup.
* Enhancement: Added new feature for tabbed Properties in Schema Types edit page.
* Enhancement: Added new settings tab for integrations.
* Enhancement: Added new setting for enable/disable markup on specific entry.
* Enhancement: Added new setting for enable/disable loading ACF PRO plugin.
* Enhancement: Added Arabic and English .po and .mo translation files.
* Enhancement: Added link to edit schema Properties post meta.
* Enhancement: Better functions to filter markup output in main types classes.
* Enhancement: Better check for plugin loading order, load Schema after ACF.
* Enhancement: Better placement for sameAs post meta, moved to tab in main group.
* Enhancement: Better placement for Video Object Details post meta, in main group.
* Enhancement: Admin notices functions and wording.
* Enhancement: Check if ACF PRO functions exists before calling them.
* Enhancement: Remove Post Formats if not supported by active Theme.
* Tweak: Removed Article:General type from subtypes select list.
* Tweak: Added class schema-premium to script output.
* Update: Updated ACF Pro to version 5.8.9 release.
* Update: Pumped tested WordPress version to 5.4 release.

= 1.1.2.7 =
* Fix: Event properties fields were not getting the correct values.
* Fix: Added missing jQuery ui icons for date picker field.
* Enhancement: Added support for new settings field type datepicker.
* Enhancement: Added support for lowPrice property in Product schema.

= 1.1.2.6 =
* Fix: Fatal error when calling get_current_screen function.
* Fix: Fatal error when calling the Configuration Wizard classes.
* Enhancement: Added support Live Badge, publication property to VideoObject details.
* Enhancement: Added transcript property to VideoObject details.
* Enhancement: Reduce codebase by adding new function to get properties meta fields.
* Enhancement: Added more instructions to Article schema type edit screen.
* Enhancement: Added review and rating properties to LocalBusiness schema type.
* Enhancement: Added support for HomeAndConstructionBusiness as a sub of LocalBusiness.

= 1.1.2.5 =
* Fix: Property fixed text value was not pulled correctly.
* Fix: Remove cssSelector property post meta field if disabled.
* Fix: Yoast SEO plugin integration, show SiteLinks and Search Box markup back.

= 1.1.2.4 =
* Fix: Added missing description property for schema.org Event type.
* Fix: Use correct time format from WordPress general settings in properties fields.
* Fix: PHP fatal error when enabling audio within plugin settings.
* Fix: Default image error, check if it is an external url before retrieving image sizes.
* Fix: Opening Hours array was not reflecting correct values.
* Fix: Property Fixed Text overrides values of other target locations.
* Enhancement: Put Schema Properties output functions in a separate file.
* Enhancement: Allow adding multiple post IDs in Location Rules.

= 1.1.2.3 =
* Fix: error caused on heavy sites when retrieve terms.
* Fix: AMP pages markup, re-coded functions to work properly.
* Fix: PHP notices by checking if variables includes an array across plugin files.
* Enhancement: Replaced meta-tax class with ACF fields on taxonomy term pages.
* Enhancement: Make sameAs on term pages repeated field to allow adding several urls.
* Update: Pumped required PHP version to 5.6.20 release.
* Update: updated readme.txt file.

= 1.1.2.2 =
* Fix: Error in Google Structured Data testing tool, remove keywords from Product.
* Fix: Notice when merging $schema and $properties arrays in schema.org types.
* Fix: Include plugin.php file when checking for active plugin on front-end.
* Fix: Screenshot property field sources and values corrected for images.
* Fix: Properties for schema.org specific subtypes was not added when a subtype is used.
* Fix: Minor style issue for ACF PRO fields.
* Fix: Remove Yoast SEO plugin schema markup for versions 11.0 and up.
* Fix: User roles on a network install was incorrect. 
* Enhancement: Added support for schema.org Place.
* Enhancement: Added support for schema.org Accommodation and sub types.
* Enhancement: Added support for schema.org MobileApplication.
* Enhancement: Added support for schema, org WebApplication.
* Enhancement: Added simple integration and new settings for Rank Math plugin.
* Enhancement: Automatically configure schema for Pages and Posts on plugin activation.
* Tweak: Updated the Service:serviceType property description.
* Tweak: Make street address 2 and 3 disabled by default.
* Tweak: Modified user role label to Schema Manager.
* Update: Pumped tested WordPress version to 5.3.2 release.
* Update: corrected license.txt file. 

= 1.1.2.1 =
* Fix: schema.org Store type, it was calling incorrect name.

= 1.1.2 =
* Fix: Added missing lastReviewed and reviewedBy properties to WebPage.
* Fix: Special Page for AboutPage markup output, was not working properly.
* Fix: Post meta keys array was missing hidden meta keys.
* Fix: Properties set to existing post meta gets override by other enabled types.
* Enhancement: Performance speed check properties fetching.
* Enhancement: Added support for schema.org type Movie.
* Enhancement: Added schema.org CheckoutPage to Special Pages as a new feature.
* Enhancement: Added schema.org FurnitureStore type as a sub type of LocalBusiness.
* Enhancement: Added schema.org Attorney type as a sub type of LocalBusiness.
* Enhancement: Added schema.org Notary type as a sub type of LocalBusiness.
* Enhancement: Added schema.org DiscussionForumPosting under Article.
* Enhancement: Added new integration for bbPress plugin.
* Enhancement: Added new function to allow adding filters in Article subtypes.
* Enhancement: Added new function to check location target match for a specific property.
* Enhancement: Added new properties isAccessibleForFree and cssSelector.
* Enhancement: Added integration with Schema Reviews extension to accept_user_reviews.
* Enhancement: Added protected $parent_type to Article, BlogPosting, and Event classes.
* Tweak: Set Breadcrumbs Show Homepage setting to be true on plugin activation.
* Tweak: Modify the types drop list for Article to allow presenting sub-types.

= 1.1.1 = 
* Fix: Service schema.org markup errors, removed author and review properties.
* Fix: Memory size error on heavy EDD site by removing extra post types.
* Fix: Bug in multi-check callback in plugin settings.
* Fix: Search function in Block Helper class to look inside internal blocks.
* Fix: Memory limit error when editing Schema > Type, saved meta keys in WP transient.
* Enhancement: Added new feature and settings for releasing Beta versions.
* Enhancement: Added new function to allow search recursive arrays in depth.
* Enhancement: Added new filter to override admin post types array.
* Enhancement: Added new filter to override post type archive markup array.
* Enhancement: Added new function to filters.php file to exclude post types meta keys.
* Enhancement: Added Default Image to post types archive single ItemList.
* Enhancement: Re-coded the updater function code and changed its name in main class.
* Tweak: Set higher priority 2 for markup output in head.
* Update: Updated ACF Pro to version 5.8.7 release.
* Update: Pumped tested WordPress version to 5.3 release.

= 1.1.0 = 
* Fix: Bug in plugin license settings when entering bundle license key.
* Enhancement: Added support for schema.org WebPage type.
* Enhancement: Added support for schema.org AboutPage subtype of WebPage.
* Enhancement: Added support for schema.org CheckoutPage subtype of WebPage.
* Enhancement: Added support for schema.org MedicalWebPage subtype of WebPage.
* Enhancement: Added support for schema.org ProfilePage subtype of WebPage.

= 1.0.9 = 
* Fix: Added @id property to logos array in publisher to stop repeated inclusion.
* Fix: Generate image object instead of image url in Organization logo markup.
* Fix: VideoObject return empty array when embedding non-supported video types.
* Fix: Added @type WebPage and @id to the BreadcrumbList.
* Fix: Typo in MedicalBusiness class name was causing an error.
* Enhancement: Added property image and @id for Organization type.
* Enhancement: Added function to retrieve image id by url.
* Enhancement: Added new function in breadcrumbs class to return JSON-LD array.
* Enhancement: Added property image to publisher.
* Enhancement: Added new extension for inserting VideoObject details in post meta.
* Enhancement: Added class helper for ACF blocks, and changed file structure.
* Update: ACF PRO to the latest 5.8.6 version.
* Update: Pumped tested WordPress version to 5.2.4 release.

= 1.0.8 = 
* Fix: A typo in plugin settings.
* Fix: CSS for admin bar menu item padding.
* Fix: Duplicate function name in Rating extension. 
* Enhancement: Add support for HowTo schema.org type.
* Enhancement: Added Review:itemReviewed schema types supported by Google.
* Enhancement: Display ACF PRO version in advanced settings.
* Enhancement: Added new admin bar menu item for Rich Results Test.

= 1.0.7 =
* Fix: Notices in Recipe class.
* Fix: Post meta notifications display even though properties are set.
* Enhancement: Load plugin first, this allow extensions to load after.
* Enhancement: Add support for FAQPage schema.org type.
* Enhancement: Add Schema in block categories, to be used by plugin extensions.
* Enhancement: Add parameter rows to text-area input fields.
* Update: ACF PRO to the latest 5.8.4 version.
* Update: EDD updater class to the latest 1.6.19 version.
* Update: Pumped tested WordPress version to 5.2.3 release.

= 1.0.6 =
* Fix: Make sure we are not calling functions statically in main class.
* Fix: Remove opening hours meta post from post type schema.
* Fix: Possible bug in schema properties fields.
* Fix: Error on AMP markup output for special pages (contact and about pages).
* Fix: Not able to override author name by mapping property field value.
* Fix: PHP warning in post type list class in locations target column.
* Enhancement: Added check and display notice if ACF or ACF PRO is active.
* Enhancement: Added gtin8, gtin12, gtin13, gtin14, and mpn properties to Product markup.
* Enhancement: Added new features and settings for breadcrumbs markup.
* Enhancement: Added new function schema_premium_rating_star to be used by extensions.
* Enhancement: Display message on new post creation, when post id is not available yet.
* Enhancement: Display message when property fields are not set to new custom field.
* Enhancement: Added new function is_edit_page to check if it is an edit page.
* Enhancement: Load properties fields in wp instead of acf/init on non admin pages.
* Update: Drop support for Google+ since Google is dropping it.
* Update: Pumped tested WordPress version to 5.1.1 release.
* Tweak: Set alternativeHeadline property field to disabled.
* Tweak: Added more description for Default Image setting.
* Tweak: Changed order of Schemas sub setting, put author before breadcrumbs.

= 1.0.5 =
* Fix: Review markup and properties mapping, also added missing description property.
* Fix: Article markup and properties mapping.
* Enhancement: Avoid errors by adding a check for Schema free before activating.
* Enhancement: Remove Ratings column by Post Rating plugin from Schema post type.
* Tweak: Corrected typo in Schema > Settings > Schemas > Breadcrumbs setting item.
* Tweak: Added new type for post id and rating stars to columns class.
* Update: ACF PRO to the latest 5.7.13 version. 

= 1.0.4 =
* Fix: PHP notice in JobPosting additionalProperty, and LocalBusiness.
* Fix: Service markup.
* Enhancement: Added a couple of checks to avoid errors in VideoObject > YouTube.
* Enhancement: Added support for schema.org Person markup.
* Enhancement: Added markup by specific post id in location target post meta.
* Enhancement: Added review and aggregateRating to schema Service.
* Enhancement: Added support for category, keywords, and yield to Recipe markup.
* Enhancement: Added support for review and aggregateRating to Recipe markup.
* Enhancement: Added new settings tab for breadcrumbs.
* Tweak: Wording of custom meta key field in Schema > Type> properties options.

= 1.0.3 =
* Fix: Remove mainEntityOfPage from Product markup.
* Fix: Match @id and url properties in post type archives and terms.
* Fix: Links in license activation settings was pointing to wrong site.
* Fix: JobPosting markup was showing errors in Google testing tool.
* Enhancement: Added AggregateOffer support for schema.org Product.
* Enhancement: Added new fields to Product for highPrice and offerCount properties.
* Enhancement: Added new filters.php file for adding misc filters.
* Enhancement: append #product to permalink on post type product if found.
* Enhancement: Added markup by category in location target post meta.
* Enhancement: Allow disabling properties post meta field.
* Enhancement: Added missing description field for Local Business type.
* Tweak: Removed property url from Product schema markup.
* Tweak: Wording and descriptions in a few files.
* Tweak: Renamed few plugin functions prefix.
* Update: Pumped tested WordPress version to 5.1 release.
* Update: updated readme.txt file.

= 1.0.2 =
* Fix: Review markup output even if no rating value provided or equal zero.
* Fix: Bug when truncating titles.
* Fix: Bug in Event Offer Valid From date field causing it not to save dates.
* Fix: LocalBusiness and Service (address, geo, provider) fields when set fixed value.
* Enhancement: Added support for schema.org SoftwareApplication markup.
* Enhancement: Added support for 20 schema.org Event sub-types markup.
* Enhancement: Added fixed price range select field.
* Enhancement: Added fixed price range select field.
* Enhancement: Added prefix for plugin constants.
* Enhancement: Added new filters to custom fields to allow accept user rating.
* Update: Updated ACF Pro to version 5.7.12 release.
* Update: Updated plugin updater class to version 1.6.18 release.


= 1.0.1 =
* Fix: ACF date picker field was missing the date format.
* Fix: PHP Fatal error when truncating long headlines.
* Fix: Opening specification hours for LocalBusiness night shift was missing.
* Fix: Image custom field return attachment ID, now return Image Object.
* Fix: PHP Fatal error on LocalBusiness class, in opening hours.
* Enhancement: Added support for schema.org Review markup.
* Enhancement: Added support for schema.org Recipe markup.
* Enhancement: Added support for schema.org Course markup.
* Enhancement: Added support for schema.org Product markup.
* Enhancement: Added support for schema.org Service markup.
* Enhancement: Integration of WooCommerce.
* Enhancement: Added new function to return array of types that supports author markup.
* Enhancement: Added new function to code duration time like PT1H45M30S.
* Enhancement: Removed the Official Free extension tab from extensions settings page.
* Modified: modified some file names.
* Update: updated readme.txt file.

= 1.0.0 =
* Initial Release
