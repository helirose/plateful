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
}

