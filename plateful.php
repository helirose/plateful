<?php
/**
 * Plugin Name:       Plateful - Food Menu Blocks
 * Description:       A plugin for easily adding restaurant menus to wordpress
 * Version:           1.0.0
 * Author:            Charlotte Rees
 * Text Domain:       plateful
 */

defined('ABSPATH') || exit;

// Load Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

use Plateful\Plugin;

if (!defined('PLATEFUL_PLUGIN_URL')) {
    define('PLATEFUL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if (!defined('PLATEFUL_PLUGIN_DIR')) {
    define('PLATEFUL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if (!defined( 'PLATEFUL_VERSION')) {
	$plugin_data = get_file_data( __FILE__, [ 'Version' => 'Version' ] );
	define( 'PLATEFUL_VERSION', $plugin_data['Version'] );
}

// Initialize the Plugin class
Plugin::get_instance();
