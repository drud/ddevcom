/**
* This file is a dummy file that doesn't do anything except
* does a fake registration of every Stackable block so that
* the WordPress plugin directory detects them and lists them
* in the Stackable plugin page.
*
* This file is auto-generated from the build process.
*/

registerBlockType( 'ugb/accordion', {
	title: __( 'Accordion', i18n ),
	description: __( 'A title that your visitors can toggle to view more text. Use as FAQs or multiple ones for an Accordion.', i18n ),
	icon: AccordionIcon,
	category: 'common',
	keywords: [
		__( 'Accordion', i18n ),
		__( 'Toggle', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,

	deprecated,
	edit,
	save,

	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		// 'advanced-column-spacing': {
		// 	columnGap: false,
		// },
		'advanced-responsive': true,
		// 'block-background': true,
		// 'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.cta.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/blockquote', {
	title: __( 'Blockquote', i18n ),
	description: __( 'Display a quote in style.', i18n ),
	icon: BlockquoteIcon,
	category: 'common',
	keywords: [
		__( 'Blockquote', i18n ),
		__( 'Stackable', i18n ),
	],
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},
	attributes: schema,

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			columnGap: false,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.blockquote.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/blog-posts', {
	title: __( 'Posts', i18n ),
	description: __( 'Your latest blog posts. Use this to showcase a few of your posts in your landing pages.', i18n ),
	icon: BlogPostsIcon,
	category: 'layout',
	keywords: [
		__( 'Blog Posts', i18n ),
		__( 'Stackable', i18n ),
	],
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},
	attributes: schema,

	save,
	edit,
	deprecated,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			verticalColumnAlign: true,
			verticalContentAlign: false,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.blog-posts.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/button', {
	title: __( 'Button', i18n ),
	description: __( 'Add a customizable button.', i18n ),
	icon: ButtonIcon,
	category: 'layout',
	keywords: [
		__( 'Button', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.button.custom-css.default', '' ),
		},
	},
}

// Change the main class name since we're using `ugb-button` for the button element.
addFilter( 'stackable.button.mainClassName', 'stackable/button', () => {
	return 'ugb-button-wrapper'
} )

// If the alignment was changed, but the design doesn't support it, go back to the basic design to allow the alignment change.
addFilter( 'stackable.button.setAttributes', 'stackable/button/contentAlign', ( attributes, blockProps ) => {
	if ( typeof attributes.contentAlign === 'undefined' ) {
		return attributes
	}

	if ( ! [ '', 'basic' ].includes( blockProps.attributes.design ) ) {
		attributes.design = 'basic'
	}

	return attributes
} )

// If the design was changed, but the design doesn't support alignment, reset the alignment attribute.
addFilter( 'stackable.button.setAttributes', 'stackable/button/design', attributes => {
	if ( typeof attributes.design === 'undefined' ) {
		return attributes
	}

	if ( ! [ '', 'basic' ].includes( attributes.design ) ) {
		attributes.contentAlign = ''
	}

	return attributes
} ) )
registerBlockType( 'ugb/cta', {
	title: __( 'Call to Action', i18n ),
	description: __( 'A small section you can use to call the attention of your visitors. Great for calling attention to your products or deals.', i18n ),
	icon: CTAIcon,
	category: 'layout',
	keywords: [
		__( 'Call to Action', i18n ),
		__( 'Stackable', i18n ),
		__( 'CTA', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			columnGap: false,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.cta.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/card', {
	title: __( 'Card', i18n ),
	description: __( 'Describe a single subject in a small card. You can use this to describe your product, service or a person.', i18n ),
	icon: CardIcon,
	category: 'layout',
	keywords: [
		__( 'Card', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			paddings: false,
			verticalColumnAlign: true,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.card.custom-css.default', '' ),
		},
	},
}

// For column spacings, use advanced paddings & vertical align on the content area only.
addFilter( 'stackable.card.advanced-column-spacing.vertical-align.selector', 'stackable/card', () => '.ugb-card__content' ) )
registerBlockType( 'ugb/columns', {
	title: __( 'Advanced Columns & Grid', i18n ),
	description: __( 'Add a block that displays content in multiple columns. Get advanced options on how you want your columns to look.', i18n ),
	icon: ColumnsIcon,
	category: 'layout',
	keywords: [
		__( 'Advanced Columns', i18n ),
		__( 'section rows', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,

	supports: {
		html: false,
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	edit,
	save,

	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'custom-css': {
			default: applyFilters( 'stackable.columns.custom-css.default', '' ),
		},
	},
}

// If the design was changed, check if we surpass the max columns.
addFilter( 'stackable.columns.setAttributes', 'stackable/columns/design', ( attributes, blockProps ) => {
	if ( typeof attributes.design === 'undefined' ) {
		return attributes
	}

	const blockAttributes = blockProps.attributes

	if ( attributes.design !== 'grid' && blockAttributes.columns > 6 ) {
		attributes.columns = 6
	}

	return attributes
} )

// If the design was changed, change the number of columns to make the layout's
// effect more apparent.
addFilter( 'stackable.columns.setAttributes', 'stackable/columns/design', ( attributes, blockProps ) => {
	if ( typeof attributes.design === 'undefined' ) {
		return attributes
	}

	const blockAttributes = blockProps.attributes

	if ( attributes.design !== 'plain' && blockAttributes.columns < 4 ) {
		attributes.columns = 4
	}

	return attributes
} ) )
registerBlockType( 'ugb/container', {
	title: __( 'Container', i18n ),
	description: __( 'A styled container that you can add other blocks inside. Use this to create unique layouts.', i18n ),
	icon: ContainerIcon,
	category: 'layout',
	keywords: [
		__( 'Container Layout', i18n ),
		__( 'Row', i18n ),
		__( 'Stackable', i18n ),
	],
	supports: {
		anchor: true,
		align: [ 'center', 'wide', 'full' ],
		html: false,
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		// Add EditorsKit block navigator toolbar.
		editorsKitBlockNavigator: true,
	},
	deprecated,
	edit,
	save,
	attributes: schema,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			columnGap: false,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'custom-css': {
			default: applyFilters( 'stackable.container.custom-css.default', '' ),
		},
	},
}

// Remove the default way of how the column spacing -> vertical align works since we are using another method in `style.js`
addFilter( 'stackable.container.advanced-column-spacing.vertical-align', 'stackable/container', () => ( {} ) ) )
registerBlockType( 'ugb/count-up', {
	title: __( 'Count Up', i18n ),
	description: __( 'Showcase your stats. Display how many customers you have or the number of downloads of your app.', i18n ),
	icon: CountUpIcon,
	category: 'common',
	keywords: [
		__( 'Statistics', i18n ),
		__( 'Count Up', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,

	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			verticalColumnAlign: true,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.count-up.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/design-library', {
	title: __( 'Design Library', i18n ),
	description: __( 'Choose a layout or block from the Stackable Design Library.', i18n ),
	icon: StackableIcon,
	category: 'layout',
	keywords: [
		__( 'Design Library', i18n ),
		__( 'Element Layouts', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,

	supports: {
		customClassName: false,
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,
}

const mountDesignLibrary = () => {
	// Content only editing mode shouldn't have a button.
	if ( isContentOnlyMode ) {
		return
	}

	if ( disabledBlocks.includes( name ) ) {
		return
	}

	let timeout = null
	const unsubscribe = subscribe( () => {
		const toolbar = document.querySelector( '.edit-post-header-toolbar' )
		if ( ! toolbar ) {
			return
		}

		const buttonDiv = document.createElement( 'div' )
		buttonDiv.classList.add( 'ugb-insert-library-button__wrapper' )

		if ( ! toolbar.querySelector( '.ugb-insert-library-button__wrapper' ) ) {
			render( <InsertLibraryButton />, buttonDiv )
			toolbar.appendChild( buttonDiv )
		}

		if ( timeout ) {
			clearTimeout( timeout )
		}

		timeout = setTimeout( () => {
			if ( document.querySelector( '.ugb-insert-library-button__wrapper' ) ) {
				unsubscribe()
			}
		}, 0 )
	} )
}

domReady( mountDesignLibrary ) )
registerBlockType( 'ugb/divider', {
	title: __( 'Divider', i18n ),
	description: __( 'Add a pause between your content.', i18n ),
	icon: DividerIcon,
	category: 'layout',
	keywords: [
		__( 'Divider', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	edit,
	save,
	deprecated,

	// Stackable modules.
	modules: {
		'advanced-block-spacing': true,
		'advanced-responsive': true,
		'content-align': true,
		'custom-css': {
			default: applyFilters( 'stackable.divider.custom-css.default', '' ),
		},
	},
}

addFilter( 'stackable.divider.setAttributes', 'stackable/divider/defaults', ( attributes, blockProps ) => {
	const blockAttributes = blockProps.attributes

	if ( typeof attributes.design !== 'undefined' && attributes.design !== 'basic' ) {
		return {
			...attributes,
			height: attributes.design === 'asterisks' ? 14 : 7,
			width: attributes.design === 'dots' || attributes.design === 'asterisks' ? 10 : blockAttributes.width,
		}
	} else if ( attributes.design === 'basic' ) {
		return {
			...attributes,
			height: 1,
			width: 50,
		}
	}

	return attributes
} ) )
registerBlockType( 'ugb/expand', {
	title: __( 'Expand / Show More', i18n ),
	description: __( 'Display a small snippet of text. Your readers can toggle it to show more information.', i18n ),
	icon: ExpandIcon,
	category: 'layout',
	keywords: [
		__( 'Expand', i18n ),
		__( 'Show more/less', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		// 'advanced-column-spacing': {
		// 	columnGap: false,
		// 	height: false,
		// 	verticalContentAlign: false,
		// 	paddingSelector: '.ugb-block-content',
		// },
		'advanced-responsive': true,
		// 'block-background': true,
		// 'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'custom-css': {
			default: applyFilters( 'stackable.expand.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/feature-grid', {
	title: __( 'Feature Grid', i18n ),
	description: __( 'Display multiple product features or services. You can use Feature Grids one after another.', i18n ),
	icon: FeatureGridIcon,
	category: 'layout',
	keywords: [
		__( 'Feature Grid', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'wide' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			verticalColumnAlign: true,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.feature-grid.custom-css.default', '' ),
		},
	},
}

// If the alignment was changed, but the design doesn't support it, go back to the basic design to allow the alignment change.
addFilter( 'stackable.feature-grid.setAttributes', 'stackable/feature-grid/imageShape', attributes => {
	if ( typeof attributes.imageShape !== 'undefined' ) {
		return {
			...attributes,
			image1Shape: '',
			image2Shape: '',
			image3Shape: '',
			image4Shape: '',
			image1ShapeFlipX: '',
			image1ShapeFlipY: '',
			image1ShapeStretch: '',
			image2ShapeFlipX: '',
			image2ShapeFlipY: '',
			image2ShapeStretch: '',
			image3ShapeFlipX: '',
			image3ShapeFlipY: '',
			image3ShapeStretch: '',
			image4ShapeFlipX: '',
			image4ShapeFlipY: '',
			image4ShapeStretch: '',
		}
	}

	if ( typeof attributes.imageShapeFlipX !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeFlipX: '',
			image2ShapeFlipX: '',
			image3ShapeFlipX: '',
			image4ShapeFlipX: '',
		}
	}

	if ( typeof attributes.imageShapeFlipY !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeFlipY: '',
			image2ShapeFlipY: '',
			image3ShapeFlipY: '',
			image4ShapeFlipY: '',
		}
	}

	if ( typeof attributes.imageShapeStretch !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeStretch: '',
			image2ShapeStretch: '',
			image3ShapeStretch: '',
			image4ShapeStretch: '',
		}
	}

	if ( typeof attributes.columnBackgroundColor !== 'undefined' || typeof attributes.columnBackgroundColorType !== 'undefined' ) {
		return {
			...attributes,
			column1BackgroundColor: '',
			column2BackgroundColor: '',
			column3BackgroundColor: '',
			column4BackgroundColor: '',
		}
	}

	return attributes
} ) )
registerBlockType( 'ugb/feature', {
	title: __( 'Feature', i18n ),
	description: __( 'Display a product feature or a service in a large area.', i18n ),
	icon: FeatureIcon,
	category: 'layout',
	keywords: [
		__( 'Feature', i18n ),
		__( 'Stackable', i18n ),
	],
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	attributes: schema,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		// 'advanced-column-spacing': {
		// 	columnGap: false,
		// },
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.feature.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/header', {
	title: __( 'Header', i18n ),
	description: __( 'A large header title area. Typically used at the very top of a page.', i18n ),
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Header', i18n ),
		__( 'Stackable', i18n ),
	],
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},
	attributes: schema,

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			columnGap: false,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.header.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/heading', {
	title: __( 'Advanced Heading', i18n ),
	description: __( 'Introduce new sections of your content in style.', i18n ),
	icon: HeadingIcon,
	category: 'common',
	keywords: [
		__( 'Heading', i18n ),
		__( 'Title', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	edit,
	save,
	deprecated,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-responsive': true,
		'content-align': true,
		'custom-css': {
			default: applyFilters( 'stackable.heading.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/icon-list', {
	title: __( 'Icon List', i18n ),
	description: __( 'An unordered list with icons. You can use this as a list of features or benefits.', i18n ),
	icon: IconListIcon,
	category: 'common',
	keywords: [
		__( 'Icon List', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		// 'advanced-column-spacing': true,
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.icon-list.custom-css.default', '' ),
		},
	},
}

// If the user changes the icon in the inspector, change all icons
addFilter( 'stackable.icon-list.setAttributes', 'stackable/icon-list/icon', ( attributes, blockProps ) => {
	if ( typeof attributes.icon === 'undefined' ) {
		return attributes
	}

	range( 1, 21 ).forEach( index => {
		if ( blockProps.attributes[ `icon${ index }` ] ) {
			attributes[ `icon${ index }` ] = undefined
		}
	} )

	return attributes
} ) )
registerBlockType( 'ugb/icon', {
	title: __( 'Icon', i18n ),
	description: __( 'Pick an icon or upload your own SVG icon to decorate your content.', i18n ),
	icon: IconIcon,
	category: 'common',
	keywords: [
		__( 'Icon', i18n ),
		__( 'SVG', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	edit,
	save,
	deprecated,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.icon.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/image-box', {
	title: __( 'Image Box', i18n ),
	description: __( 'Display an image that shows more information when hovered on. Can be used as a fancy link to other pages.', i18n ),
	icon: ImageBoxIcon,
	category: 'layout',
	keywords: [
		__( 'Image Box', i18n ),
		__( 'Stackable', i18n ),
	],
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},
	attributes: schema,

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.image-box.custom-css.default', '' ),
		},
	},
}

// The "height" option is really the "columnHeight" option. @see edit.js
// Disable the default column height.
addFilter( 'stackable.image-box.advanced-column-spacing.styles', 'stackable/image-box/column-height', styles => {
	styles[ '> .ugb-inner-block > .ugb-block-content > *' ] = {
		minHeight: undefined,
	}
	styles.tablet[ '> .ugb-inner-block > .ugb-block-content > *' ] = {
		minHeight: undefined,
	}
	styles.mobile[ '> .ugb-inner-block > .ugb-block-content > *' ] = {
		minHeight: undefined,
	}

	return styles
} ) )
registerBlockType( 'ugb/notification', {
	title: __( 'Notification', i18n ),
	description: __( 'Show a notice to your readers. People can dismiss the notice to permanently hide it.', i18n ),
	icon: NotificationIcon,
	category: 'formatting',
	keywords: [
		__( 'Notification', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			columnGap: false,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		// 'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.notification.custom-css.default', '' ),
		},
	},
}

addFilter( 'stackable.notification.setAttributes', 'stackable/notification/notifType', attributes => {
	if ( typeof attributes.notifType === 'undefined' ) {
		return attributes
	}

	return {
		...attributes,
		columnBackgroundColor: '',
		columnBackgroundColorOpacity: '',
		iconColor: '',
		titleColor: '',
		descriptionColor: '',
		buttonBackgroundColor: '',
		columnBorderColor: '',
	}
} )

// When background opacity is set or when the background color is reset, revert background color to notification color.
addFilter( 'stackable.notification.setAttributes', 'stackable/notification/opacity', ( attributes, blockProps ) => {
	const setColumnBackgroundColor = attributes.hasOwnProperty( 'columnBackgroundColor' )
	if ( typeof attributes.columnBackgroundColorOpacity === 'undefined' && ! setColumnBackgroundColor ) {
		return attributes
	}

	// If a new background color is set, do not revert to notification color.
	if ( setColumnBackgroundColor && typeof attributes.columnBackgroundColor !== 'undefined' ) {
		return attributes
	}

	const {
		notifType = 'success',
		columnBackgroundColor = '',
	} = blockProps.attributes

	const NOTIFY_BACKGROUND_COLORS = {
		success: '#40ba7b',
		error: '#d9534f',
		info: '#2091e1',
		warning: '#ffdd57',
	}

	return {
		...attributes,
		columnBackgroundColor: columnBackgroundColor && ! setColumnBackgroundColor ? columnBackgroundColor : NOTIFY_BACKGROUND_COLORS[ notifType ],
	}
} ) )
registerBlockType( 'ugb/number-box', {
	title: __( 'Number Box', i18n ),
	description: __( 'Display steps or methods that your users will do in your service. For example, "Get started in just 3 easy steps: 1, 2 and 3!"', i18n ),
	icon: NumberBoxIcon,
	category: 'layout',
	keywords: [
		__( 'Number Box', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},
	deprecated,
	save,
	edit,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			verticalColumnAlign: true,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.number-box.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/pricing-box', {
	title: __( 'Pricing Box', i18n ),
	description: __( 'Display the different pricing tiers of your business.', i18n ),
	icon: PricingBoxIcon,
	category: 'layout',
	keywords: [
		__( 'Pricing Box', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'wide' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			verticalColumnAlign: true,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.pricing-box.custom-css.default', '' ),
		},
	},
}

// Reset some attributes if some global attributes are set.
addFilter( 'stackable.pricing-box.setAttributes', 'stackable/pricing-box/imageShape', attributes => {
	if ( typeof attributes.imageShape !== 'undefined' ) {
		return {
			...attributes,
			image1Shape: '',
			image2Shape: '',
			image3Shape: '',
			image1ShapeFlipX: '',
			image1ShapeFlipY: '',
			image1ShapeStretch: '',
			image2ShapeFlipX: '',
			image2ShapeFlipY: '',
			image2ShapeStretch: '',
			image3ShapeFlipX: '',
			image3ShapeFlipY: '',
			image3ShapeStretch: '',
		}
	}

	if ( typeof attributes.imageShapeFlipX !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeFlipX: '',
			image2ShapeFlipX: '',
			image3ShapeFlipX: '',
		}
	}

	if ( typeof attributes.imageShapeFlipY !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeFlipY: '',
			image2ShapeFlipY: '',
			image3ShapeFlipY: '',
		}
	}

	if ( typeof attributes.imageShapeStretch !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeStretch: '',
			image2ShapeStretch: '',
			image3ShapeStretch: '',
		}
	}

	if ( typeof attributes.columnBackgroundColor !== 'undefined' || typeof attributes.columnBackgroundColorType !== 'undefined' ) {
		return {
			...attributes,
			column1BackgroundColor: '',
			column2BackgroundColor: '',
			column3BackgroundColor: '',
		}
	}

	return attributes
} ) )
registerBlockType( 'ugb/separator', {
	title: __( 'Separator', i18n ),
	description: __( 'A fancy separator to be placed between containers and content.', i18n ),
	icon: SeparatorIcon,
	category: 'layout',
	keywords: [
		__( 'Separator', i18n ),
		__( 'SVG Divider', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},
	deprecated,
	save,
	edit,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-responsive': true,
		'advanced-block-spacing': {
			enableMarginRight: false,
			enableMarginLeft: false,
			enablePaddingRight: false,
			enablePaddingLeft: false,
			height: false,
			width: false,
			horizontalContentAlign: false,
			verticalContentAlign: false,
			modifyStyles: false,
		},
		'custom-css': {
			default: applyFilters( 'stackable.separator.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'ugb/spacer', {
	title: __( 'Spacer', i18n ),
	description: __( 'Sometimes you just need some space.', i18n ),
	icon: SpacerIcon,
	category: 'layout',
	keywords: [
		__( 'Spacer', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'block-separators': {
			enableBringToFront: false,
		},
		'advanced-responsive': true,
		'custom-css': {
			default: applyFilters( 'stackable.spacer.custom-css.default', '' ),
		},
	},
}

// Change the spacer height if a separator is turned on and the height is small.
addFilter( 'stackable.spacer.setAttributes', 'stackable/spacer/separator-padding', ( attributes, blockProps ) => {
	const {
		showTopSeparator = false,
		showBottomSeparator = false,
		height = '',
	} = blockProps.attributes
	const numSeparatorsBefore = ( showTopSeparator ? 1 : 0 ) + ( showBottomSeparator ? 1 : 0 )

	let turnedOnSeparator = false
	if ( typeof attributes.showTopSeparator !== 'undefined' ) {
		if ( attributes.showTopSeparator ) {
			turnedOnSeparator = true
		}
	}
	if ( typeof attributes.showBottomSeparator !== 'undefined' ) {
		if ( attributes.showBottomSeparator ) {
			turnedOnSeparator = true
		}
	}
	if ( turnedOnSeparator ) {
		const currentHeight = ! height ? 0 : height
		if ( numSeparatorsBefore === 0 && currentHeight < 200 ) {
			attributes.height = 200
			attributes.heightUnit = 'px'
		} else if ( numSeparatorsBefore === 1 && currentHeight < 400 ) {
			attributes.height = 400
			attributes.heightUnit = 'px'
		}
	}
	return attributes
} ) )
registerBlockType( 'ugb/team-member', {
	title: __( 'Team Member', i18n ),
	description: __( 'Display members of your team or your office. Use multiple Team Member blocks if you have a large team.', i18n ),
	icon: TeamMemberIcon,
	category: 'layout',
	keywords: [
		__( 'Team Member', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'wide' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.team-member.custom-css.default', '' ),
		},
	},
}

// Reset some attributes if some global attributes are set.
addFilter( 'stackable.team-member.setAttributes', 'stackable/team-member/imageShape', attributes => {
	if ( typeof attributes.imageShape !== 'undefined' ) {
		return {
			...attributes,
			image1Shape: '',
			image2Shape: '',
			image3Shape: '',
			image1ShapeFlipX: '',
			image1ShapeFlipY: '',
			image1ShapeStretch: '',
			image2ShapeFlipX: '',
			image2ShapeFlipY: '',
			image2ShapeStretch: '',
			image3ShapeFlipX: '',
			image3ShapeFlipY: '',
			image3ShapeStretch: '',
		}
	}

	if ( typeof attributes.imageShapeFlipX !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeFlipX: '',
			image2ShapeFlipX: '',
			image3ShapeFlipX: '',
		}
	}

	if ( typeof attributes.imageShapeFlipY !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeFlipY: '',
			image2ShapeFlipY: '',
			image3ShapeFlipY: '',
		}
	}

	if ( typeof attributes.imageShapeStretch !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeStretch: '',
			image2ShapeStretch: '',
			image3ShapeStretch: '',
		}
	}

	if ( typeof attributes.columnBackgroundColor !== 'undefined' || typeof attributes.columnBackgroundColorType !== 'undefined' ) {
		return {
			...attributes,
			column1BackgroundColor: '',
			column2BackgroundColor: '',
			column3BackgroundColor: '',
		}
	}

	return attributes
} ) )
registerBlockType( 'ugb/testimonial', {
	title: __( 'Testimonial', i18n ),
	description: __( 'Showcase what your users say about your product or service.', i18n ),
	icon: TestimonialIcon,
	category: 'layout',
	keywords: [
		__( 'Testimonial', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'wide' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			verticalColumnAlign: true,
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.testimonial.custom-css.default', '' ),
		},
	},
}

// Reset some attributes if some global attributes are set.
addFilter( 'stackable.testimonial.setAttributes', 'stackable/testimonial/imageShape', attributes => {
	if ( typeof attributes.imageShape !== 'undefined' ) {
		return {
			...attributes,
			image1Shape: '',
			image2Shape: '',
			image3Shape: '',
			image1ShapeFlipX: '',
			image1ShapeFlipY: '',
			image1ShapeStretch: '',
			image2ShapeFlipX: '',
			image2ShapeFlipY: '',
			image2ShapeStretch: '',
			image3ShapeFlipX: '',
			image3ShapeFlipY: '',
			image3ShapeStretch: '',
		}
	}

	if ( typeof attributes.imageShapeFlipX !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeFlipX: '',
			image2ShapeFlipX: '',
			image3ShapeFlipX: '',
		}
	}

	if ( typeof attributes.imageShapeFlipY !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeFlipY: '',
			image2ShapeFlipY: '',
			image3ShapeFlipY: '',
		}
	}

	if ( typeof attributes.imageShapeStretch !== 'undefined' ) {
		return {
			...attributes,
			image1ShapeStretch: '',
			image2ShapeStretch: '',
			image3ShapeStretch: '',
		}
	}

	if ( typeof attributes.columnBackgroundColor !== 'undefined' || typeof attributes.columnBackgroundColorType !== 'undefined' ) {
		return {
			...attributes,
			column1BackgroundColor: '',
			column2BackgroundColor: '',
			column3BackgroundColor: '',
		}
	}

	return attributes
} ) )
registerBlockType( 'ugb/text', {
	title: __( 'Advanced Text', i18n ),
	description: __( 'Start with the building block of all page layouts.', i18n ),
	icon: TextIcon,
	category: 'common',
	keywords: [
		__( 'Text', i18n ),
		__( 'Pargraph', i18n ),
		__( 'Stackable', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	edit,
	save,
	deprecated,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			paddings: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.text.custom-css.default', '' ),
		},
	},
}

// If the design was changed, force turn on the title.
addFilter( 'stackable.text.setAttributes', 'stackable/text/design', ( attributes, blockProps ) => {
	if ( typeof attributes.design === 'undefined' ) {
		return attributes
	}

	const blockAttributes = blockProps.attributes

	if ( attributes.design === 'side-title-1' || attributes.design === 'side-title-2' ) {
		if ( blockAttributes.design !== 'side-title-1' && blockAttributes.design !== 'side-title-2' ) {
			attributes.showTitle = true
		}
	}

	return attributes
} ) )
registerBlockType( 'ugb/video-popup', {
	title: __( 'Video Popup', i18n ),
	description: __( 'Display a large thumbnail that your users can click to play a video full-screen. Great for introductory or tutorial videos.', i18n ),
	icon: VideoPopupIcon,
	category: 'common',
	keywords: [
		__( 'Video Popup', i18n ),
		__( 'Stackable', i18n ),
		__( 'YouTube Vimeo mp4', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
		anchor: true,
	},

	deprecated,
	edit,
	save,

	// Stackable modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		// 'advanced-column-spacing': true,
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		'block-title': true,
		// 'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'stackable.video-popup.custom-css.default', '' ),
		},
	},
} )