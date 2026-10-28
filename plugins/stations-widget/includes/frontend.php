<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Read route data in geographic order; unassigned phases do not change position. */
function fglsw_route_data() {
    $posts = get_posts( array(
        'post_type' => 'station_widget', 'post_status' => 'publish',
        'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC', 'ID' => 'ASC' ),
    ) );
    $route = array();
    foreach ( $posts as $station ) {
        $phases = wp_get_post_terms( $station->ID, 'station_phase' );
        $statuses = wp_get_post_terms( $station->ID, 'station_status' );
        $phase = ! is_wp_error( $phases ) && $phases ? $phases[0] : null;
        $status = ! is_wp_error( $statuses ) && $statuses ? $statuses[0] : null;
        $route[] = array(
            'id' => $station->ID,
            'name' => get_the_title( $station ),
            'phase' => $phase,
            'status' => $status,
            'info' => function_exists( 'get_field' ) ? get_field( 'fglsw_info', $station->ID ) : '',
            'link' => function_exists( 'get_field' ) ? get_field( 'fglsw_link', $station->ID ) : '',
        );
    }
    return $route;
}

/** Resolve ACF Image formats without assuming a particular return setting. */
function fglsw_status_icon_url( $term_id ) {
    if ( ! function_exists( 'get_field' ) ) { return ''; }
    $image = get_field( 'fglsw_icon', 'station_status_' . absint( $term_id ) );
    if ( is_array( $image ) ) { $image = $image['url'] ?? ( $image['ID'] ?? 0 ); }
    if ( is_numeric( $image ) ) { $image = wp_get_attachment_image_url( (int) $image, 'thumbnail' ); }
    return is_string( $image ) ? esc_url( $image, array( 'https', 'http' ) ) : '';
}

function fglsw_icon_markup( $status ) {
    if ( ! $status ) { return '<span class="fglsw-icon-fallback" aria-hidden="true">●</span>'; }
    $url = fglsw_status_icon_url( $status->term_id );
    if ( ! $url && in_array( $status->slug, array( 'complete', 'station-construction', 'future-station' ), true ) ) {
        $url = plugins_url( 'assets/img/' . $status->slug . '.png', dirname( __DIR__ ) . '/stations-widget.php' );
    }
    return $url ? '<img class="fglsw-icon" src="' . esc_url( $url ) . '" alt="" width="30" height="30">' : '<span class="fglsw-icon-fallback" aria-hidden="true">●</span>';
}

function fglsw_register_assets() {
    $base = dirname( __DIR__ ) . '/stations-widget.php';
    wp_register_style( 'fglsw-swiper', plugins_url( 'assets/vendor/swiper/swiper-bundle.min.css', $base ), array(), '12.0.3' );
    wp_register_style( 'fglsw-widget', plugins_url( 'assets/css/stations-widget.css', $base ), array( 'fglsw-swiper' ), (string) filemtime( dirname( __DIR__ ) . '/assets/css/stations-widget.css' ) );
    wp_register_script( 'fglsw-swiper', plugins_url( 'assets/vendor/swiper/swiper-bundle.min.js', $base ), array(), '12.0.3', true );
    wp_register_script( 'fglsw-widget', plugins_url( 'assets/js/stations-widget.js', $base ), array( 'fglsw-swiper' ), (string) filemtime( dirname( __DIR__ ) . '/assets/js/stations-widget.js' ), true );
    // Styles must reach wp_head even when a shortcode is rendered by a template later.
    if ( is_singular() ) { wp_enqueue_style( 'fglsw-widget' ); }
}
add_action( 'wp_enqueue_scripts', 'fglsw_register_assets' );

function fglsw_shortcode() {
    $route = fglsw_route_data();
    if ( ! $route ) { return ''; }
    wp_enqueue_style( 'fglsw-widget' );
    wp_enqueue_script( 'fglsw-widget' );
    $settings = get_option( 'fglsw_settings', array() );
    $heading = $settings['heading'] ?? 'Stations';
    $id = wp_unique_id( 'fglsw-' );
    $phases = array();
    foreach ( $route as $index => $station ) {
        if ( $station['phase'] && ! isset( $phases[$station['phase']->term_id] ) ) {
            $phases[$station['phase']->term_id] = array( 'index' => $index, 'name' => $station['phase']->name );
        }
    }
    ob_start();
    ?>
    <section class="fglsw" aria-label="<?php echo esc_attr( $heading ?: 'Stations' ); ?>" id="<?php echo esc_attr( $id ); ?>">
        <?php if ( $heading ) : ?>
            <div class="section-heading fglsw-heading">
                <h2><?php echo esc_html( $heading ); ?></h2>
            </div>
        <?php endif; ?>
        <div class="fglsw-stage">
            <div class="swiper fglsw-route" aria-label="Station route">
                <div class="swiper-wrapper">
                <?php foreach ( $route as $index => $station ) :
                    $phase_id = $station['phase'] ? (int) $station['phase']->term_id : 0;
                    $previous_phase = $index > 0 && $route[$index - 1]['phase'] ? (int) $route[$index - 1]['phase']->term_id : 0;
                    $span = 1;
                    if ( $phase_id && $phase_id !== $previous_phase ) {
                        while ( isset( $route[$index + $span] ) && $route[$index + $span]['phase'] && (int) $route[$index + $span]['phase']->term_id === $phase_id ) { $span++; }
                    }
                    $popup_id = $id . '-station-' . $station['id'];
                    ?>
                    <div class="swiper-slide fglsw-station" data-phase="<?php echo esc_attr( $phase_id ); ?>">
                        <button class="fglsw-trigger" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr( $popup_id ); ?>" aria-label="<?php echo esc_attr( $station['name'] . ( $station['status'] ? ', ' . $station['status']->name : '' ) ); ?>">
                            <span class="fglsw-name"><?php echo esc_html( $station['name'] ); ?></span>
                            <?php echo fglsw_icon_markup( $station['status'] ); ?>
                        </button>
                        <?php if ( $phase_id && $phase_id !== $previous_phase ) : ?>
                            <div class="fglsw-phase-bracket" style="--phase-span: <?php echo (int) $span; ?>;"><span><?php echo esc_html( $station['phase']->name ); ?></span></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
            <button class="fglsw-arrow fglsw-prev" type="button" aria-label="Previous station"><span aria-hidden="true">‹</span></button>
            <button class="fglsw-arrow fglsw-next" type="button" aria-label="Next station"><span aria-hidden="true">›</span></button>
            <?php foreach ( $route as $station ) : $popup_id = $id . '-station-' . $station['id']; ?>
                <div class="fglsw-popover" id="<?php echo esc_attr( $popup_id ); ?>" role="dialog" aria-modal="false" aria-labelledby="<?php echo esc_attr( $popup_id . '-title' ); ?>" hidden>
                    <button class="fglsw-close" type="button" aria-label="Close station details">×</button>
                    <h3 id="<?php echo esc_attr( $popup_id . '-title' ); ?>"><?php echo esc_html( $station['name'] ); ?></h3>
                    <?php if ( is_string( $station['info'] ) && $station['info'] ) : ?><p><?php echo nl2br( esc_html( $station['info'] ) ); ?></p><?php endif; ?>
                    <?php $link = $station['link']; if ( is_array( $link ) && ! empty( $link['url'] ) ) : ?>
                        <a href="<?php echo esc_url( $link['url'] ); ?>" <?php if ( '_blank' === ( $link['target'] ?? '' ) ) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></a>
                    <?php endif; ?>
                    <img class="fglsw-popover-tail" src="<?php echo esc_url( plugins_url( 'assets/img/popover-tail.svg', dirname( __DIR__ ) . '/stations-widget.php' ) ); ?>" alt="">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-scrollbar fglsw-scrollbar"></div>
        <div class="fglsw-footer">
            <?php if ( $phases ) : ?><nav class="fglsw-jumps" aria-label="Jump to phase"><strong>Jump To:</strong>
                <?php foreach ( $phases as $phase_id => $phase ) : ?><button type="button" data-index="<?php echo esc_attr( $phase['index'] ); ?>" data-phase="<?php echo esc_attr( $phase_id ); ?>"><?php echo esc_html( $phase['name'] ); ?></button><?php endforeach; ?>
            </nav><?php endif; ?>
            <ul class="fglsw-legend" aria-label="Station status key">
                <?php foreach ( (array) ( $settings['legend'] ?? array() ) as $status_id ) : $status = get_term( (int) $status_id, 'station_status' ); if ( ! $status || is_wp_error( $status ) ) { continue; } ?>
                    <li><?php echo fglsw_icon_markup( $status ); ?><span><?php echo esc_html( $status->name ); ?></span></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode( 'stations_widget', 'fglsw_shortcode' );
