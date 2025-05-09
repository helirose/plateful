<?php

namespace Plateful;

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

	public function render_plateful_menu_item($attributes) {
		$post_id = $attributes['selectedPost'];

		if (empty($post_id)) {
			return '<p>No menu item selected.</p>';
		} else {
			$values = [
				'description'=> get_post_meta( $post_id, '_description', true ),
				'price'      => get_post_meta( $post_id, '_price', true ),
				'outOfStock'  => get_post_meta( $post_id, '_outOfStock', true ),
				'allergens'  => get_post_meta( $post_id, '_allergens', true ),
				'heatLevel'  => get_post_meta( $post_id, '_heat_level', true ),
			];
			$output = '<div>';
			if($values['outOfStock']) {
				$output .= '<p><strong>Out of stock</strong></p>';
			}
			$output .= '<strong>' . get_the_title($post_id) . '</strong><br>';
			$output .= '<p>' . $values['description'] . '</p>';
			$output .= '</div>';
			return $output;
		}
	}

	public function render_plateful_menu($attributes, $content) {

		return '<div>' . do_blocks($content) . '</div>';
		
	}

	public function render_plateful_menu_section($attributes, $content) {

		$output = '';
		$output .= '<div class="menu-section">' ;
		$output .= $attributes['title'];
		$output .= '<div class="menu-section-content">';
		$output .= do_blocks($content);
		$output .= '</div>';
		$output .= '</div>';

		return $output;
		
	}
}
