<?php

namespace Plateful;

class Blocks {

    /**
	 * Register hooks.
	 */
	public function register(): void {
		add_action( 'init', [ $this, 'register_blocks' ] );
	}

	function register_blocks() {
		$blocks_dir = plugin_dir_path(__FILE__) . '../build/';

		error_log($blocks_dir);
	
		// Loop through all folders in /blocks/
		foreach (glob($blocks_dir . '*', GLOB_ONLYDIR) as $block_folder) {
			$block_json = $block_folder . '/block.json';
	
			if (file_exists($block_json)) {
				register_block_type($block_folder);
			}
		}
	}
}
