<?php
namespace Mediavine\Grow\Tools;

class Sticky_Bar extends Tool {
	use Renderable;

	/**
	 * Sticky_Bar constructor. Set metadata and slug
	 */
	public function init() {
		$this->load_properties([
			'slug' => 'sticky_bar',
			'name'               => __( 'Sticky Bar', 'social-pug' ),
			'type'               => 'share_tool',
			'activation_setting' => 'dpsp_location_sticky_bar[active]',
			'img'                => 'assets/dist/tool-mobile.' . DPSP_VERSION . '.png',
			'admin_page'         => 'admin.php?page=dpsp-sticky-bar',
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
