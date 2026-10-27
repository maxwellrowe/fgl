<?php
/**
 * Plugin Name: Stations Widget
 * Description: An editable, ordered station route with phase navigation and status information. Use [stations_widget].
 * Version: 1.0.0
 * Text Domain: stations-widget
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

require_once __DIR__ . '/includes/admin.php';
require_once __DIR__ . '/includes/frontend.php';

function fglsw_register_content() {
    register_post_type( 'station_widget', array(
        'labels' => array( 'name' => 'Stations', 'singular_name' => 'Station', 'add_new_item' => 'Add Station', 'edit_item' => 'Edit Station' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-location-alt',
        'supports' => array( 'title', 'revisions' ),
    ) );
    foreach ( array( 'station_phase' => array( 'Phases', 'Phase' ), 'station_status' => array( 'Statuses', 'Status' ) ) as $taxonomy => $labels ) {
        register_taxonomy( $taxonomy, 'station_widget', array(
            'labels' => array( 'name' => $labels[0], 'singular_name' => $labels[1] ),
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'meta_box_cb' => false,
            'show_in_quick_edit' => false,
            'rewrite' => false,
        ) );
    }
}
add_action( 'init', 'fglsw_register_content' );

function fglsw_activate() {
    fglsw_register_content();
    $legend = array();
    foreach ( array( 'complete' => 'Complete', 'station-construction' => 'Station Construction', 'future-station' => 'Future Station' ) as $slug => $name ) {
        $term = term_exists( $slug, 'station_status' );
        if ( ! $term ) { $term = wp_insert_term( $name, 'station_status', array( 'slug' => $slug ) ); }
        if ( ! is_wp_error( $term ) && 'complete' !== $slug ) { $legend[] = (int) $term['term_id']; }
    }
    add_option( 'fglsw_settings', array( 'heading' => '23 Stations Completed On Time, On Budget', 'legend' => $legend ) );
}
register_activation_hook( __FILE__, 'fglsw_activate' );

function fglsw_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) { return; }
    acf_add_local_field_group( array(
        'key' => 'group_fglsw_station', 'title' => 'Station Details',
        'fields' => array(
            array( 'key' => 'field_fglsw_info', 'label' => 'Info', 'name' => 'fglsw_info', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Completion date or other station information.' ),
            array( 'key' => 'field_fglsw_link', 'label' => 'Learn More Link', 'name' => 'fglsw_link', 'type' => 'link', 'return_format' => 'array' ),
            array( 'key' => 'field_fglsw_phase', 'label' => 'Phase', 'name' => 'fglsw_phase', 'type' => 'taxonomy', 'taxonomy' => 'station_phase', 'field_type' => 'select', 'allow_null' => 1, 'multiple' => 0, 'save_terms' => 1, 'load_terms' => 1, 'return_format' => 'id', 'instructions' => 'Leave blank for a station outside a named phase. Only assigned phases get jump buttons.' ),
            array( 'key' => 'field_fglsw_status', 'label' => 'Status', 'name' => 'fglsw_status', 'type' => 'taxonomy', 'taxonomy' => 'station_status', 'field_type' => 'select', 'allow_null' => 0, 'multiple' => 0, 'required' => 1, 'save_terms' => 1, 'load_terms' => 1, 'return_format' => 'id' ),
        ),
        'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'station_widget' ) ) ),
    ) );
    acf_add_local_field_group( array(
        'key' => 'group_fglsw_status', 'title' => 'Status Icon',
        'fields' => array( array( 'key' => 'field_fglsw_icon', 'label' => 'Icon', 'name' => 'fglsw_icon', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'instructions' => 'Upload the icon used for this status on the route and in the legend. A transparent PNG is recommended.' ) ),
        'location' => array( array( array( 'param' => 'taxonomy', 'operator' => '==', 'value' => 'station_status' ) ) ),
    ) );
}
add_action( 'acf/init', 'fglsw_acf_fields' );

function fglsw_dependency_notice() {
    if ( current_user_can( 'manage_options' ) && ! function_exists( 'get_field' ) ) {
        echo '<div class="notice notice-warning"><p>Stations Widget requires Advanced Custom Fields to edit station details and status icons.</p></div>';
    }
}
add_action( 'admin_notices', 'fglsw_dependency_notice' );
