<?php

namespace Plateful;

class Plugin {
/**
	 * Instance of this class.
	 *
	 * @var Plugin
	 */
	private static $instance;

	/**
	 * Construct.
	 */
	private function __construct() {
		// Initialize everything here.
		$this->init_hooks();
	}

	/**
	 * Initialization hooks.
	 */
	private function init_hooks(): void {
		// Register custom post types (menu).
		$menu = new Menu();
		$menu->register();

		// Register custom post types (menu).
		$menuItems = new MenuItems();
		$menuItems->register();

		// Load blocks.
		$blocks = new Blocks();
		$blocks->register();

		add_action( 'wp_enqueue_scripts', [$this, 'plateful_enqueue_styles']);
		add_action( 'wp_enqueue_scripts', [$this, 'plateful_enqueue_scripts']);
	}

	/**
	 * Get the singleton instance.
	 *
	 * @return Plugin
	 */
	public static function get_instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function plateful_enqueue_styles() {
		wp_enqueue_style('plateful-menu', plugins_url( 'plateful/build/frontend/plateful-menu.css', dirname( __DIR__ )), [], PLATEFUL_VERSION);
	}

	public function plateful_enqueue_scripts() {
		wp_enqueue_script('plateful-menu', plugins_url( 'plateful/build/frontend/plateful-menu.js', dirname( __DIR__ )), [], PLATEFUL_VERSION);
	}

}

