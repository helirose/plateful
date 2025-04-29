<?php
/**
 * Plugin Name:       Plateful - Food Menu Blocks
 * Description:       A plugin for easily adding restaurant menus to wordpress
 * Version:           1.0.0
 * Author:            Charlotte Rees
 * Text Domain:       plateful
 */

// Load Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

use Plateful\Plugin;

defined('ABSPATH') || exit;

define( 'PLATEFUL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Initialize the Plugin class
Plugin::get_instance();

// Bootstrap the plugin
// add_action( 'plugins_loaded', function () {
//     $plugin = new \Plateful\Includes\Plugin();
//     $plugin->run();
// });
