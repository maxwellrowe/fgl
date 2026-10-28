<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function fglsw_admin_menu() {
    add_submenu_page( 'edit.php?post_type=station_widget', 'Stations Widget Settings', 'Settings', 'manage_options', 'fglsw-settings', 'fglsw_settings_page' );
    add_submenu_page( 'edit.php?post_type=station_widget', 'Route Order', 'Route Order', 'manage_options', 'fglsw-order', 'fglsw_order_page' );
}
add_action( 'admin_menu', 'fglsw_admin_menu' );

function fglsw_order_assets() {
    $screen = get_current_screen();
    if ( ! $screen || 'station_widget' !== $screen->post_type || 'fglsw-order' !== ( $_GET['page'] ?? '' ) ) { return; }
    $base = dirname( __DIR__ ) . '/stations-widget.php';
    wp_enqueue_script( 'fglsw-order', plugins_url( 'assets/js/admin-order.js', $base ), array( 'jquery-ui-sortable' ), (string) filemtime( dirname( __DIR__ ) . '/assets/js/admin-order.js' ), true );
    wp_enqueue_style( 'fglsw-order', plugins_url( 'assets/css/admin-order.css', $base ), array(), (string) filemtime( dirname( __DIR__ ) . '/assets/css/admin-order.css' ) );
}
add_action( 'admin_enqueue_scripts', 'fglsw_order_assets' );

function fglsw_sanitize_settings( $input ) {
    $input = is_array( $input ) ? $input : array();
    $legend = array();
    foreach ( (array) ( $input['legend'] ?? array() ) as $id ) {
        $id = absint( $id );
        if ( $id && term_exists( $id, 'station_status' ) ) { $legend[] = $id; }
    }
    return array( 'heading' => sanitize_text_field( $input['heading'] ?? '' ), 'legend' => array_values( array_unique( $legend ) ) );
}
function fglsw_register_settings() {
    register_setting( 'fglsw_settings', 'fglsw_settings', array( 'type' => 'array', 'sanitize_callback' => 'fglsw_sanitize_settings' ) );
}
add_action( 'admin_init', 'fglsw_register_settings' );

function fglsw_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) { return; }
    $settings = get_option( 'fglsw_settings', array() );
    $statuses = get_terms( array( 'taxonomy' => 'station_status', 'hide_empty' => false ) );
    ?>
    <div class="wrap"><h1>Stations Widget Settings</h1>
        <?php settings_errors(); ?>
        <p>Add <code>[stations_widget]</code> to any page. Edit icons under <a href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=station_status&post_type=station_widget' ) ); ?>">Stations → Statuses</a>.</p>
        <form action="options.php" method="post">
            <?php settings_fields( 'fglsw_settings' ); ?>
            <table class="form-table"><tr><th><label for="fglsw-heading">Heading</label></th><td><input id="fglsw-heading" class="large-text" name="fglsw_settings[heading]" value="<?php echo esc_attr( $settings['heading'] ?? '' ); ?>"></td></tr>
            <tr><th>Statuses shown in legend</th><td><fieldset><legend class="screen-reader-text">Statuses shown in legend</legend>
                <?php if ( ! is_wp_error( $statuses ) ) : foreach ( $statuses as $status ) : ?>
                    <label><input type="checkbox" name="fglsw_settings[legend][]" value="<?php echo esc_attr( $status->term_id ); ?>" <?php checked( in_array( (int) $status->term_id, array_map( 'intval', (array) ( $settings['legend'] ?? array() ) ), true ) ); ?>> <?php echo esc_html( $status->name ); ?></label><br>
                <?php endforeach; endif; ?>
                <p class="description">Only checked statuses appear in the bottom-right legend. This does not hide stations.</p>
            </fieldset></td></tr></table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function fglsw_order_page() {
    if ( ! current_user_can( 'manage_options' ) ) { return; }
    $stations = get_posts( array( 'post_type' => 'station_widget', 'post_status' => array( 'publish', 'draft', 'pending', 'private', 'future' ), 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC', 'ID' => 'ASC' ) ) );
    ?>
    <div class="wrap"><h1>Route Order</h1>
        <p>Drag stations into left-to-right route order, or use the Move up and Move down buttons, then click Save Route Order. You can also enter positions manually; smaller numbers come first. Keep stations in the same phase consecutive. Stations without a phase can appear anywhere.</p>
        <?php if ( isset( $_GET['saved'] ) ) : ?><div class="notice notice-success"><p>Route order saved.</p></div><?php endif; ?>
        <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
            <input type="hidden" name="action" value="fglsw_save_order">
            <?php wp_nonce_field( 'fglsw_save_order' ); ?>
            <p id="fglsw-order-message" role="status" aria-live="polite"></p>
            <table id="fglsw-order-table" class="widefat striped"><thead><tr><th>Order</th><th>Station</th><th>Phase</th><th>Publication status</th></tr></thead><tbody>
            <?php foreach ( $stations as $station ) : $phases = wp_get_post_terms( $station->ID, 'station_phase', array( 'fields' => 'names' ) ); ?>
                <tr data-station-name="<?php echo esc_attr( $station->post_title ); ?>"><td>
                    <span class="fglsw-order-controls" hidden>
                        <span class="fglsw-drag-handle dashicons dashicons-move" aria-hidden="true" title="Drag to reorder"></span>
                        <button type="button" class="button fglsw-move-up" aria-label="<?php echo esc_attr( 'Move ' . $station->post_title . ' up' ); ?>">↑</button>
                        <button type="button" class="button fglsw-move-down" aria-label="<?php echo esc_attr( 'Move ' . $station->post_title . ' down' ); ?>">↓</button>
                    </span>
                    <input type="number" min="0" step="1" name="order[<?php echo esc_attr( $station->ID ); ?>]" value="<?php echo esc_attr( $station->menu_order ); ?>" aria-label="<?php echo esc_attr( 'Route position for ' . $station->post_title ); ?>">
                </td><td><a href="<?php echo esc_url( get_edit_post_link( $station->ID ) ); ?>"><?php echo esc_html( $station->post_title ); ?></a></td><td><?php echo esc_html( ! is_wp_error( $phases ) && $phases ? implode( ', ', $phases ) : 'No phase' ); ?></td><td><?php echo esc_html( $station->post_status ); ?></td></tr>
            <?php endforeach; ?>
            </tbody></table>
            <?php submit_button( 'Save Route Order' ); ?>
        </form>
    </div>
    <?php
}
function fglsw_save_order() {
    if ( ! current_user_can( 'manage_options' ) ) { wp_die( 'Not authorized.', '', array( 'response' => 403 ) ); }
    check_admin_referer( 'fglsw_save_order' );
    $order = isset( $_POST['order'] ) && is_array( $_POST['order'] ) ? wp_unslash( $_POST['order'] ) : array();
    foreach ( $order as $id => $position ) {
        $id = absint( $id );
        if ( 'station_widget' === get_post_type( $id ) && current_user_can( 'edit_post', $id ) && is_scalar( $position ) ) {
            wp_update_post( array( 'ID' => $id, 'menu_order' => min( 2147483647, absint( $position ) ) ) );
        }
    }
    wp_safe_redirect( admin_url( 'edit.php?post_type=station_widget&page=fglsw-order&saved=1' ) );
    exit;
}
add_action( 'admin_post_fglsw_save_order', 'fglsw_save_order' );
