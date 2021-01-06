<?php
namespace Mediavine\Grow\Tools;

class Inline_Content extends Tool {
	use Renderable;

	/**
	 * Inline_Content constructor. Set metadata and slug
	 */
	public function init() {
		$this->load_properties([
			'slug' => 'inline_content',
			'name'               => __( 'Inline Content', 'social-pug' ),
			'type'               => 'share_tool',
			'activation_setting' => 'dpsp_location_content[active]',
			'img'                => 'assets/dist/tool-content.' . DPSP_VERSION . '.png',
			'admin_page'         => 'admin.php?page=dpsp-content',
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
