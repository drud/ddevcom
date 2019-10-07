/**
* This file is a dummy file that doesn't do anything except
* does a fake registration of every Stackable block so that
* the WordPress plugin directory detects them and lists them
* in the Stackable plugin page.
*
* This file is auto-generated from the build process.
*/

registerBlockType( 'ugb/accordion', {
	title: __( 'Accordion' ),
	description: __( 'A title that your visitors can toggle to view more text. Use as FAQs or multiple ones for an Accordion.' ),
	icon: AccordionIcon,
	category: 'stackable',
	keywords: [
		__( 'Accordion' ),
		__( 'Toggle' ),
		__( 'Stackable' ),
	],
	attributes: schema,

	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/accordion-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/blockquote', {
	title: __( 'Blockquote' ),
	description: __( 'Display a quote in style.' ),
	icon: BlockquoteIcon,
	category: 'stackable',
	keywords: [
		__( 'Blockquote' ),
		__( 'Stackable' ),
	],
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
	attributes: schema,

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/blockquote-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/blog-posts', {
	title: __( 'Posts' ),
	description: __( 'Your latest blog posts. Use this to showcase a few of your posts in your landing pages.' ),
	icon: BlogPostsIcon,
	category: 'stackable',
	keywords: [
		__( 'Blog Posts' ),
		__( 'Stackable' ),
	],

	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	save,
	edit,

	// Stackable specific settings.
	sAdminTitle: __( 'Blog Posts' ),
	sDemoURL: 'https://wpstackable.com/blog-posts-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/button', {
	title: __( 'Button' ),
	icon: ButtonIcon,
	description: __( 'Add a customizable button.' ),
	category: 'stackable',
	keywords: [
		__( 'Button' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/button-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/cta', {
	title: __( 'Call to Action' ),
	description: __( 'A small section you can use to call the attention of your visitors. Great for calling attention to your products or deals.' ),
	icon: CTAIcon,
	category: 'stackable',
	keywords: [
		__( 'Call to Action' ),
		__( 'Stackable' ),
		__( 'CTA' ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/call-to-action-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/card', {
	title: __( 'Card' ),
	description: __( 'Describe a single subject in a small card. You can use this to describe your product, service or a person.' ),
	icon: CardIcon,
	category: 'stackable',
	keywords: [
		__( 'Card' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/card-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/container', {
	title: __( 'Container' ),
	description: __( 'A styled container that you can add other blocks inside. Use this to create unique layouts.' ),
	icon: ContainerIcon,
	category: 'stackable',
	keywords: [
		__( 'Container Layout' ),
		__( 'Row' ),
		__( 'Stackable' ),
	],
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
	deprecated,
	edit,
	save,
	attributes: schema,

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/container-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/count-up', {
	title: __( 'Count Up' ),
	description: __( 'Showcase your stats. Display how many customers you have or the number of downloads of your app.' ),
	icon: CountUpIcon,
	category: 'stackable',
	keywords: [
		__( 'Statistics' ),
		__( 'Count Up' ),
		__( 'Stackable' ),
	],
	attributes: schema,

	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/count-up-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/divider', {
	title: __( 'Divider' ),
	description: __( 'Add a pause between your content.' ),
	icon: DividerIcon,
	category: 'stackable',
	keywords: [
		__( 'Divider' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
} )
registerBlockType( 'ugb/expand', {
	title: __( 'Expand / Show More' ),
	description: __( 'Display a small snippet of text. Your readers can toggle it to show more information.' ),
	icon: ExpandIcon,
	category: 'stackable',
	keywords: [
		__( 'Expand' ),
		__( 'Show more/less' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/expand-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/feature-grid', {
	title: __( 'Feature Grid' ),
	description: __( 'Display multiple product features or services. You can use Feature Grids one after another.' ),
	icon: FeatureGridIcon,
	category: 'stackable',
	keywords: [
		__( 'Feature Grid' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		align: [ 'wide' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/feature-grid-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/feature', {
	title: __( 'Feature' ),
	description: __( 'Display a product feature or a service in a large area.' ),
	icon: FeatureIcon,
	category: 'stackable',
	keywords: [
		__( 'Feature' ),
		__( 'Stackable' ),
	],
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
	deprecated,
	edit,
	save,

	attributes: schema,

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/feature-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/header', {
	title: __( 'Header' ),
	description: __( 'A large header title area. Typically used at the very top of a page.' ),
	icon: HeaderIcon,
	category: 'stackable',
	keywords: [
		__( 'Header' ),
		__( 'Stackable' ),
	],
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
	attributes: schema,

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/header-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/icon-list', {
	title: __( 'Icon List' ),
	description: __( 'An unordered list with icons. You can use this as a list of features or benefits.' ),
	icon: IconListIcon,
	category: 'stackable',
	keywords: [
		__( 'Icon List' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/icon-list-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/image-box', {
	title: __( 'Image Box' ),
	description: __( 'Display an image that shows more information when hovered on. Can be used as a fancy link to other pages.' ),
	icon: ImageBoxIcon,
	category: 'stackable',
	keywords: [
		__( 'Image Box' ),
		__( 'Stackable' ),
	],
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
	attributes: schema,

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/image-box-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/notification', {
	title: __( 'Notification' ),
	description: __( 'Show a notice to your readers. People can dismiss the notice to permanently hide it.' ),
	icon: NotificationIcon,
	category: 'stackable',
	keywords: [
		__( 'Notification' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/notification-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/number-box', {
	title: __( 'Number Box' ),
	description: __( 'Display steps or methods that your users will do in your service. For example, "Get started in just 3 easy steps: 1, 2 and 3!"' ),
	icon: NumberBoxIcon,
	category: 'stackable',
	keywords: [
		__( 'Number Box' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
	deprecated,
	save,
	edit,

	// Stackable modules.
	modules: {
		'advanced-block-spacing': true,
		'advanced-column-spacing': true,
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'custom-css': {
			default: applyFilters( 'stackable.number-box.custom-css.default', '' ),
		},
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/number-box-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/pricing-box', {
	title: __( 'Pricing Box' ),
	description: __( 'Display the different pricing tiers of your business.' ),
	icon: PricingBoxIcon,
	category: 'stackable',
	keywords: [
		__( 'Pricing Box' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		align: [ 'wide' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/pricing-table-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/separator', {
	title: __( 'Separator' ),
	description: __( 'A fancy separator to be placed between containers and content.' ),
	icon: SeparatorIcon,
	category: 'stackable',
	keywords: [
		__( 'Separator' ),
		__( 'SVG Divider' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		align: [ 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
	deprecated,
	save,
	edit,

	// Stackable modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			enableMarginRight: false,
			enableMarginLeft: false,
			enablePaddingRight: false,
			enablePaddingLeft: false,
			height: false,
			width: false,
			horizontalAlign: false,
			verticalAlign: false,
			modifyStyles: false,
		},
		'custom-css': {
			default: applyFilters( 'stackable.separator.custom-css.default', '' ),
		},
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/separator-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/spacer', {
	title: __( 'Spacer' ),
	description: __( 'Sometimes you just need some space.' ),
	icon: SpacerIcon,
	category: 'stackable',
	keywords: [
		__( 'Spacer' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
} )
registerBlockType( 'ugb/team-member', {
	title: __( 'Team Member' ),
	description: __( 'Display members of your team or your office. Use multiple Team Member blocks if you have a large team.' ),
	icon: TeamMemberIcon,
	category: 'stackable',
	keywords: [
		__( 'Team Member' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		align: [ 'wide' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/team-member-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/testimonial', {
	title: __( 'Testimonial' ),
	description: __( 'Showcase what your users say about your product or service.' ),
	icon: TestimonialIcon,
	category: 'stackable',
	keywords: [
		__( 'Testimonial' ),
		__( 'Stackable' ),
	],
	attributes: schema,
	supports: {
		align: [ 'wide' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},
	deprecated,
	edit,
	save,

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/testimonial-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )
registerBlockType( 'ugb/video-popup', {
	title: __( 'Video Popup' ),
	description: __( 'Display a large thumbnail that your users can click to play a video full-screen. Great for introductory or tutorial videos.' ),
	icon: VideoPopupIcon,
	category: 'stackable',
	keywords: [
		__( 'Video Popup' ),
		__( 'Stackable' ),
		__( 'YouTube Vimeo mp4' ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/video-popup-block/?utm_source=welcome&utm_medium=settings&utm_campaign=view_demo&utm_content=demolink',
} )