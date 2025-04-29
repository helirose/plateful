<?php

namespace Plateful;

class Menu {
	/**
	 * Register hooks.
	 */
	public function register(): void {
		add_action( 'init', [ $this, 'register_post_type' ] );
	}

	/**
	 * Register the 'menu_item' custom post type.
	 */
	public function register_post_type(): void {
		$labels = [
			'name'               => __( 'Menu', 'plateful' ),
			'singular_name'      => __( 'Menu', 'plateful' ),
			'add_new'            => __( 'Add New', 'plateful' ),
			'add_new_item'       => __( 'Add New Menu', 'plateful' ),
			'edit_item'          => __( 'Edit Menu', 'plateful' ),
			'new_item'           => __( 'New Menu', 'plateful' ),
			'all_items'          => __( 'All Menu', 'plateful' ),
			'view_item'          => __( 'View Menu', 'plateful' ),
			'search_items'       => __( 'Search Menu', 'plateful' ),
			'not_found'          => __( 'No menu found', 'plateful' ),
			'not_found_in_trash' => __( 'No menu found in Trash', 'plateful' ),
			'menu_name'          => __( 'Menu', 'plateful' ),
		];

		$args = [
			'labels'             => $labels,
			'public'             => true,
			'has_archive'        => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-carrot', // Because carrot.
			'supports'           => [ 'title', 'editor', 'thumbnail' ],
			'rewrite'            => [ 'slug' => 'menu' ],
		];

		register_post_type( 'menu', $args );
	}
}