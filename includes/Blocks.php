<?php

namespace Plateful;

use Plateful\Plugin;

class Blocks {

    /**
	 * Register hooks.
	 */
	public function register(): void {
		add_action( 'init', [ $this, 'register_blocks' ] );
	}

	public function register_blocks() {
		$blocks_dir = plugin_dir_path(__FILE__) . '../build/';
	
		// Loop through all folders in /blocks/
		foreach (glob($blocks_dir . '*-block', GLOB_ONLYDIR) as $block_folder) {
			$block_json = $block_folder . '/block.json';

			// Dynamically get render callback name for current block
			$parts = explode('/', $block_folder);
			$base = end($parts);
			$block_name = str_replace('-', '_', preg_replace('/-block$/', '', $base));
			$callback_method = 'render_' . $block_name;
	
			// Register block
			if (file_exists($block_json)) {

				if(method_exists($this, $callback_method)) {
					register_block_type($block_folder, [
						'render_callback' => [$this, $callback_method],
					]);
				} else {
					register_block_type($block_folder);
				}
			}
		}
	}
	
	public function render_plateful_menu($attributes, $content) {

		return Plugin::get_instance()->render_twig('menu.twig', [
			'content' => do_blocks($content),
			'section_names' => $this->find_section_names($content)
		]);
	}

	public function render_plateful_menu_section($attributes, $content) {

		return Plugin::get_instance()->render_twig('menu-section.twig', [
			'section_name' => $attributes['section_name'],
			'content' => do_blocks($content)
		]);
	}

	public function render_plateful_menu_item($attributes) {
		$post_id = $attributes['selectedPost'];

		if (empty($post_id)) {
			return '<p>No menu item selected.</p>';
		}

		$thumbnail = get_the_post_thumbnail($post_id, 'thumbnail', array('class' => 'plateful-thumbnail'));
		$post_img = $thumbnail ? $thumbnail : '<img src="' . PLATEFUL_PLUGIN_URL . '/build/images/placeholder.svg" class="plateful-thumbnail" alt="No photo provided for this menu item" />';

		$values = [
			'title'       => get_the_title($post_id),
			'description' => get_post_meta($post_id, '_description', true),
			'price'       => get_post_meta($post_id, '_price', true),
			'outOfStock'  => get_post_meta($post_id, '_outOfStock', true),
			'allergens'   => get_post_meta($post_id, '_allergens', true),
			'dietary'      => get_post_meta($post_id, '_dietary', true),
			'heatLevel'   => (int) get_post_meta($post_id, '_heat_level', true),
			'image'       => $post_img,
		];
		
		return Plugin::get_instance()->render_twig('menu-item.twig', $values);
	}

	private function find_section_names($content) {
		$section_names = [];
		$dom = new \DOMDocument();
		$dom->loadHTML($content);
		$details = $dom->getElementsByTagName('details');
		foreach ($details as $detail) {
			if ($detail->hasAttribute('class') && str_contains($detail->getAttribute('class'), 'plateful-menu-section')) {
				$name = $detail->getAttribute('name');
				if ($name) {
					$section_names[] = $name;
				}
			}
		}
		return $section_names;
	}
}