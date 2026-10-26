<?php
/**
 * Plugin Name: Construction Notice Widgets
 * Description: Construction notice widgets with dedicated single, header, and footer templates.
 * Version: 1.0.0
 * Text Domain: construction-notice-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/includes/settings.php';

/** Register construction notice widgets. */
function cnw_register_post_type() {
    register_post_type( 'construction_widget', array(
        'labels' => array(
            'name'          => __( 'Construction Notice Widgets', 'construction-notice-widgets' ),
            'singular_name' => __( 'Construction Notice Widget', 'construction-notice-widgets' ),
            'add_new_item'  => __( 'Add New Construction Notice Widget', 'construction-notice-widgets' ),
            'edit_item'     => __( 'Edit Construction Notice Widget', 'construction-notice-widgets' ),
        ),
        'public'       => true,
        'show_in_rest' => true,
        'has_archive'  => false,
        'rewrite'      => array( 'slug' => 'construction-widget' ),
        'menu_icon'    => 'dashicons-hammer',
        'supports'     => array( 'title', 'editor', 'thumbnail' ),
    ) );
}
add_action( 'init', 'cnw_register_post_type' );

/** Use the plugin's dedicated template for individual widgets. */
function cnw_single_template( $template ) {
    if ( is_singular( 'construction_widget' ) ) {
        return plugin_dir_path( __FILE__ ) . 'templates/single-construction_widget.php';
    }

    return $template;
}
add_filter( 'template_include', 'cnw_single_template' );

/** Load widget styles after Bootstrap and the active theme's normal enqueues. */
function cnw_enqueue_widget_assets() {
    if ( is_singular( 'construction_widget' ) ) {
        wp_enqueue_style( 'cnw-bootstrap', plugins_url( 'assets/vendor/bootstrap/bootstrap.min.css', __FILE__ ), array(), '5.3.8' );
        wp_enqueue_style(
            'cnw-widget',
            plugins_url( 'assets/css/construction-notice-widgets.css', __FILE__ ),
            array( 'cnw-bootstrap' ),
            (string) filemtime( __DIR__ . '/assets/css/construction-notice-widgets.css' )
        );
        if ( function_exists( 'get_field' ) ) {
            $widget_id = get_queried_object_id();
            $dark = 'widget-dark' === get_field( 'overall_theme', $widget_id );
            $variables = array(
                '--cnw-background:' . ( $dark ? '#313984' : '#ffffff' ),
                '--cnw-heading-color:' . ( $dark ? '#ffffff' : '#10155e' ),
                '--cnw-text-color:' . ( $dark ? '#ffffff' : '#10155e' ),
            );
            foreach ( array(
                'widget_background_color' => '--cnw-background',
                'widget_border_color' => '--cnw-border-color',
                'heading_text_color' => '--cnw-heading-color',
                'body_text_color' => '--cnw-text-color',
            ) as $field => $property ) {
                $value = get_field( $field, $widget_id );
                $color = is_string( $value ) ? sanitize_hex_color( $value ) : null;
                if ( $color ) {
                    $variables[] = $property . ':' . $color;
                }
            }
            foreach ( array(
                'widget_border_width' => '--cnw-border-width',
                'heading_text_size' => '--cnw-heading-size',
                'body_text_size' => '--cnw-text-size',
            ) as $field => $property ) {
                $value = get_field( $field, $widget_id );
                if ( ! is_scalar( $value ) || '' === trim( (string) $value ) ) {
                    continue;
                }
                $value = trim( (string) $value );
                if ( is_numeric( $value ) ) {
                    $value .= 'px';
                }
                if ( preg_match( '/^\d*\.?\d+(px|rem|em|%)$/', $value ) ) {
                    $variables[] = $property . ':' . $value;
                }
            }
            wp_add_inline_style( 'cnw-widget', 'body.const-update-widget{' . implode( ';', $variables ) . ';}' );
        }
        wp_enqueue_script(
            'cnw-iframe-resizer-child',
            plugins_url( 'assets/js/iframeResizer.contentWindow.min.js', __FILE__ ),
            array(),
            '4.3.11',
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'cnw_enqueue_widget_assets', 100 );

/** Generate the embed code after ACF saves a construction widget. */
function cnw_update_widget_embed_code( $post_id ) {
    if ( ! is_numeric( $post_id ) || 'construction_widget' !== get_post_type( (int) $post_id ) ) {
        return;
    }

    $post_id = (int) $post_id;
    if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
        return;
    }

    $widget_url = get_permalink( $post_id );
    $resizer_url = plugins_url( 'assets/js/iframeResizer.min.js', __FILE__ );
    $embed_code = sprintf(
        '<!-- Foothill Gold Line Construction Activity Widget -->' . "\n" .
        '<iframe src="%s" class="fgl-cons-widget" title="Foothill Gold Line Construction Notices" width="350" height="400" style="width: 100%%; border: 0;"></iframe>' . "\n" .
        '<script src="%s"></script>' . "\n" .
        '<script>iFrameResize({ log: false }, "iframe.fgl-cons-widget");</script>',
        esc_url( $widget_url ),
        esc_url( $resizer_url )
    );

    update_field( 'field_5f37dd0a57f7d', $embed_code, $post_id );
}
add_action( 'acf/save_post', 'cnw_update_widget_embed_code', 20 );

/** Keep the generated embed code read-only in ACF. */
function cnw_widget_embed_code_readonly( $field ) {
    $field['readonly'] = true;
    return $field;
}
add_filter( 'acf/load_field/name=widget_embed_code', 'cnw_widget_embed_code_readonly' );

function cnw_activate() {
    cnw_register_post_type();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'cnw_activate' );

function cnw_deactivate() {
    unregister_post_type( 'construction_widget' );
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'cnw_deactivate' );
