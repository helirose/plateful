<?php

namespace Plateful;

use Plateful\Plugin;

class Options {

    /**
	 * Register hooks.
	 */
	public function register(): void {
		add_action( 'admin_menu', [ $this, 'register_options' ] );
	}

	public function register_options() {
        add_options_page(
            __( 'Plateful Settings', 'plateful' ),
            __( 'Plateful', 'plateful' ),
            'manage_options',
            'plateful-options',
            [ $this, 'plateful_options_page' ]);
    }

    public function plateful_options_page() {
        echo Plugin::get_instance()->render_twig('admin/options.twig', [
            'title' => __( 'Plateful Settings', 'plateful')
        ]);
    }
}