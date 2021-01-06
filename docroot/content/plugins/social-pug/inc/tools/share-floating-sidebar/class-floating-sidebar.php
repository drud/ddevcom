<?php
namespace Mediavine\Grow\Tools;

class Floating_Sidebar extends Tool {
	use Renderable;

	/**
	 * Floating Sidebar constructor. Set metadata and slug
	 */
	public function init() {
		$this->load_properties([
			'slug' => 'floating_sidebar',
			'name'               => __( 'Floating Sidebar', 'social-pug' ),
			'type'               => 'share_tool',
			'activation_setting' => 'dpsp_location_sidebar[active]',
			'img'                => 'assets/dist/tool-sidebar.' . DPSP_VERSION . '.png',
			'admin_page'         => 'admin.php?page=dpsp-sidebar',
		]);
	}

	/**
	 * The rendering action of this tool
	 * @return string HTML output of tool
	 */
	public function render() {
		// @TODO Migrate functionality from global function to this class
		$this->has_rendered = true;
		return '';
	}

}
