<?php
/** Plugin-wide construction widget settings. */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function cnw_add_settings_page() {
    add_submenu_page(
        'edit.php?post_type=construction_widget',
        __( 'Construction Notice Widget Settings', 'construction-notice-widgets' ),
        __( 'Settings', 'construction-notice-widgets' ),
        'manage_options',
        'cnw-settings',
        'cnw_render_settings_page'
    );
}
add_action( 'admin_menu', 'cnw_add_settings_page' );

/** Accept an absolute HTTP(S) URL, or an empty value to restore the default. */
function cnw_sanitize_view_all_url( $value ) {
    if ( is_string( $value ) && '' === trim( $value ) ) {
        return '';
    }

    $value = is_string( $value ) ? trim( $value ) : '';
    $parts = wp_parse_url( $value );
    $url = esc_url_raw( $value, array( 'http', 'https' ) );
    if ( $url && is_array( $parts ) && ! empty( $parts['host'] )
        && isset( $parts['scheme'] ) && in_array( strtolower( $parts['scheme'] ), array( 'http', 'https' ), true ) ) {
        return $url;
    }

    add_settings_error(
        'cnw_view_all_url',
        'cnw_invalid_url',
        __( 'Enter a complete http:// or https:// URL, or leave the field blank to use the site homepage.', 'construction-notice-widgets' )
    );
    return get_option( 'cnw_view_all_url', '' );
}

function cnw_register_settings() {
    register_setting( 'cnw_settings', 'cnw_view_all_url', array(
        'type'              => 'string',
        'sanitize_callback' => 'cnw_sanitize_view_all_url',
        'default'           => '',
    ) );
    add_settings_section( 'cnw_links', __( 'Widget Links', 'construction-notice-widgets' ), '__return_false', 'cnw-settings' );
    add_settings_field(
        'cnw_view_all_url',
        __( 'View All Construction Updates URL', 'construction-notice-widgets' ),
        'cnw_render_view_all_url_field',
        'cnw-settings',
        'cnw_links',
        array( 'label_for' => 'cnw_view_all_url' )
    );
}
add_action( 'admin_init', 'cnw_register_settings' );

function cnw_get_view_all_url() {
    $url = get_option( 'cnw_view_all_url', '' );
    return is_string( $url ) && '' !== $url ? $url : home_url( '/' );
}

function cnw_render_view_all_url_field() {
    ?>
    <input type="url" class="regular-text" id="cnw_view_all_url" name="cnw_view_all_url"
        value="<?php echo esc_attr( get_option( 'cnw_view_all_url', '' ) ); ?>"
        placeholder="<?php echo esc_attr( home_url( '/' ) ); ?>" aria-describedby="cnw-view-all-description">
    <p class="description" id="cnw-view-all-description">
        <?php esc_html_e( 'Applies to all construction notice widgets. Leave blank to use the site homepage. Link text is still set on each widget.', 'construction-notice-widgets' ); ?>
    </p>
    <?php
}

function cnw_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Construction Notice Widget Settings', 'construction-notice-widgets' ); ?></h1>
        <?php settings_errors(); ?>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'cnw_settings' );
            do_settings_sections( 'cnw-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
