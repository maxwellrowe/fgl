<?php
/** Shared mobile title for pages and individual posts of every post type. */
if ( ! is_singular() || is_front_page() || is_page_template( 'page-home.php' ) ) {
    return;
}

$mobile_title = get_the_title( get_queried_object_id() );
if ( '' === trim( $mobile_title ) ) {
    return;
}
?>
<h1 class="fgl-mobile-content-title"><?php echo esc_html( $mobile_title ); ?></h1>
