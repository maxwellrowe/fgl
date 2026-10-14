<?php
/**
 * Google Maps configuration for Construction Maps.
 */

defined( 'ABSPATH' ) || exit;

function construction_maps_register_settings() {
    register_setting(
        'construction_maps_settings',
        'construction_maps_api_key',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'construction_maps_sanitize_api_key',
            'default'           => '',
            'show_in_rest'      => false,
        )
    );

    add_settings_section( 'construction_maps_api', 'Google Maps', '__return_false', 'construction-maps-settings' );
    add_settings_field(
        'construction_maps_api_key',
        'API key',
        'construction_maps_api_key_field',
        'construction-maps-settings',
        'construction_maps_api',
        array( 'label_for' => 'construction_maps_api_key' )
    );
}
add_action( 'admin_init', 'construction_maps_register_settings' );

function construction_maps_sanitize_api_key( $value ) {
    if ( ! is_string( $value ) ) {
        add_settings_error( 'construction_maps_api_key', 'invalid_api_key', 'Please enter a valid API key.' );
        return get_option( 'construction_maps_api_key', '' );
    }

    return sanitize_text_field( trim( $value ) );
}

function construction_maps_add_settings_page() {
    add_options_page(
        'Construction Maps Settings',
        'Construction Maps',
        'manage_options',
        'construction-maps-settings',
        'construction_maps_settings_page'
    );
}
add_action( 'admin_menu', 'construction_maps_add_settings_page' );

function construction_maps_api_key_field() {
    $key = get_option( 'construction_maps_api_key', '' );
    ?>
    <input type="password" id="construction_maps_api_key" name="construction_maps_api_key"
        value="<?php echo esc_attr( $key ); ?>" class="regular-text" autocomplete="off"
        spellcheck="false" aria-describedby="construction_maps_api_key_description" />
    <p class="description" id="construction_maps_api_key_description">
        Used by the ACF Google Map field. Enter your Google Maps API key and save changes.
        Clear this field and save to remove the saved key.
    </p>
    <?php
}

function construction_maps_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'construction_maps_settings' );
            do_settings_sections( 'construction-maps-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
