<?php

namespace Plateful;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Plugin {
/**
	 * Instance of this class.
	 *
	 * @var Plugin
	 */
	private static $instance;
	protected $twig;

	/**
	 * Construct.
	 */
	private function __construct() {
		// Initialize everything here.
		$this->init_hooks();
		$this->init_twig();
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

	private function init_twig() {
		$loader = new FilesystemLoader(__DIR__ . '/../templates');
		$this->twig = new Environment($loader, [
			'cache' => false,
		]);
		$this->twig->addGlobal('plateful_plugin_url', PLATEFUL_PLUGIN_URL);
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

	public function render_twig(string $template, array $context = []): string {
		return $this->twig->render($template, $context);
	}

}

