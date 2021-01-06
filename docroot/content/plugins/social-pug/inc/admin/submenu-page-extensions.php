<?php

/**
 * Function that creates the sub-menu item and page for the extra tools page.
 */
function dpsp_register_extensions_subpage() {
	add_submenu_page( 'dpsp-social-pug', __('Extensions', 'social-pug'), '<span style="color: orange;">' . __('Extensions', 'social-pug') . '</span>', 'manage_options', 'dpsp-extensions', 'dpsp_extensions_subpage' );
}

/**
 * Function that adds content to the extensions subpage.
 *
 * @return string
 */
function dpsp_extensions_subpage() {
	if( ! empty( $_GET['sub-page'] ) && $_GET['sub-page'] == 'opt-in-hound' ) {
		include_once 'views/view-submenu-page-extensions-sub-page-opt-in-hound.php';
	} else {
		include_once 'views/view-submenu-page-extensions.php';
	}
}
