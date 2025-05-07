<?php

namespace Plateful;

class MenuItems {

    public array $known_allergens = [
        'Gluten',
        'Nuts',
        'Dairy',
        'Eggs',
        'Soy',
        'Shellfish',
        'Fish',
        'Celery',
        'Mustard',
        'Sesame',
        'Sulphites',
        'Lupin',
        'Molluscs',
    ];

    public function register(): void {
        add_action( 'init', [ $this, 'register_items' ] );
        add_action('add_meta_boxes', [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post_plateful-menu-items', [ $this, 'save_fields' ] );
    }


    public function register_items(): void {
        $labels = [
            'name'               => __( 'Plateful menu item', 'plateful' ),
            'singular_name'      => __( 'Plateful menu item', 'plateful' ),
            'add_new'            => __( 'Add New', 'plateful' ),
            'add_new_item'       => __( 'Add New Plateful menu item', 'plateful' ),
            'edit_item'          => __( 'Edit Plateful menu item', 'plateful' ),
            'new_item'           => __( 'New Plateful menu item', 'plateful' ),
            'all_items'          => __( 'All Plateful menu items', 'plateful' ),
            'view_item'          => __( 'View Plateful menu item', 'plateful' ),
            'search_items'       => __( 'Search Plateful menu items', 'plateful' ),
            'not_found'          => __( 'No Plateful menu items found', 'plateful' ),
            'not_found_in_trash' => __( 'No Plateful menu items found in Trash', 'plateful' ),
            'menu_name'          => __( 'Plateful menu items', 'plateful' ),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'has_archive'        => false,
            'show_in_rest'       => true,
            'menu_icon'          => 'dashicons-carrot', // Because carrot.
            'supports'           => [ 'title', 'thumbnail'],
            'rewrite'            => [ 'slug' => 'plateful-menu-items' ],
            'rest_base'         => 'plateful-menu-items',
            'capability_type'   => 'post',
            'capabilities'       => [ 'post' ],
            'map_meta_cap'       => true
        ];

        register_post_type( 'plateful-menu-items', $args );
    }

   public function add_meta_boxes() {
        add_meta_box( 
            'plateful-menu-item',
            'Plateful Menu Item',
            [ $this, 'render_fields' ],
            'plateful-menu-items',
            'normal',
            'high'
        );
    }

    public function render_fields($post) {
        $values = [
            'description'=> get_post_meta( $post->ID, '_description', true ),
            'price'      => get_post_meta( $post->ID, '_price', true ),
            'outOfStock'  => get_post_meta( $post->ID, '_outOfStock', true ),
            'allergens'  => get_post_meta( $post->ID, '_allergens', true ),
            'heatLevel'  => get_post_meta( $post->ID, '_heat_level', true ),
            'dietary' => get_post_meta( $post->ID, '_dietary', true )
        ];

        $heat = $values['heatLevel'] !== '' ? $values['heatLevel'] : 0;
    
        wp_nonce_field( 'plateful_meta_box', 'plateful_meta_box_nonce');
    
        echo '<p><label>Description:<br><textarea name="description" style="width:100%">' . esc_textarea( $values['description'] ) . '</textarea></label></p>';
        echo '<p><label>Price:<br><input type="number" name="price" step="0.01" value="' . esc_attr( $values['price'] ) . '" required></label></p>';
        echo '<p><label><input type="checkbox" name="outOfStock" value="1"' . checked( $values['outOfStock'], 1, false ) . '> Out of stock</label></p>';
        echo '<fieldset style="margin-bottom: 1em;">';
        echo '<legend><strong>Dietary Labels:</strong></legend>';
        echo '<label style="display:block;">';
        echo '<input type="radio" name="dietary_main" value="vegetarian"'  . checked($values['dietary']['main'], 'vegetarian', false) . '>';
        echo 'Vegetarian';
        echo '</label>';
        echo '<label style="display:block;">';
        echo '<input type="radio" name="dietary_main" value="vegan"' . checked($values['dietary']['main'], 'vegan', false) . '>';
        echo 'Vegan';
        echo '</label>';
        echo '<label style="display:block;">';
        echo '<input type="checkbox" name="dietary_gluten_free" value="1"' . checked($values['dietary']['gluten_free'], 1, false) . '>';
        echo 'Gluten Free';
        echo '</label>';
        echo '</fieldset>';
        echo '<fieldset style="margin-bottom: 1em;">';
        echo '<legend><strong>Allergens present in this dish:</strong></legend>';
        foreach ( $this->known_allergens as $allergen ) {
            $checked = is_array($values['allergens']) && in_array( $allergen, $values['allergens'] ) ? 'checked' : '';
            printf(
                '<label style="display:block;"><input type="checkbox" name="allergens[]" value="%s" %s> %s</label>',
                esc_attr( $allergen ),
                $checked,
                esc_html( $allergen )
            );
        }
        echo '</fieldset>';
        echo '<p><label>Heat Level (0–5):<br><input type="number" name="heatLevel" min="0" max="5" value="' . esc_attr($heat) . '" required></label></p>';
    }

    public function save_fields( $post_id ) {
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    
        if ( ! isset($_POST['plateful_meta_box_nonce']) || ! wp_verify_nonce( $_POST['plateful_meta_box_nonce'], 'plateful_meta_box' ) ) return;
    
        $fields = ['description', 'price', 'allergens', 'heatLevel'];
    
        $out_of_stock = isset($_POST['outOfStock']) ? 1 : 0;
        update_post_meta( $post_id, '_outOfStock', $out_of_stock );

        $dietary = [
            'main' => in_array($_POST['dietary_main'] ?? '', ['vegetarian', 'vegan']) ? $_POST['dietary_main'] : '',
            'gluten_free' => isset($_POST['dietary_gluten_free']) ? 1 : 0,
        ];

        error_log(print_r($dietary, true));
        update_post_meta( $post_id, '_dietary', $dietary );

        foreach ( $fields as $field ) {
            if ( isset($_POST[$field]) ) {
                if ( is_array( $_POST[$field] ) ) {
                    $value = array_filter( array_map( 'sanitize_text_field', $_POST[$field] ), fn( $item ) => in_array( $item, $this->known_allergens ) );
                } else {
                    $value = sanitize_text_field( $_POST[$field] );
                }
                update_post_meta( $post_id, "_$field", $value );
            }
        }
    }
}