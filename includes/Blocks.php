<?php

namespace Plateful;

class Blocks {

    /**
	 * Register hooks.
	 */
	public function register(): void {
		add_action( 'init', [ $this, 'register_blocks' ] );
	}

	/**
	 * Registers block(s) from the build directory using metadata.
	 */
	public function register_blocks(): void {
		$block_dir = PLATEFUL_PLUGIN_DIR . 'build/';
		$manifest_file = $block_dir . 'blocks-manifest.php';

		if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) && file_exists( $manifest_file ) ) {
			wp_register_block_types_from_metadata_collection( $block_dir, $manifest_file );
			return;
		}

		if ( function_exists( 'wp_register_block_metadata_collection' ) && file_exists( $manifest_file ) ) {
			wp_register_block_metadata_collection( $block_dir, $manifest_file );
			return;
		}

		// Fallback loop for older WP versions.
		if ( file_exists( $manifest_file ) ) {
			$manifest_data = require $manifest_file;
			foreach ( array_keys( $manifest_data ) as $block_type ) {
				register_block_type( $block_dir . $block_type );
			}
		}
    }
}
