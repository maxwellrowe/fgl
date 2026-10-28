<?php
/** Rebuild feeds only for event changes, after all saved fields are available. */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function fgl_events_queue_feed_rebuild( $post_id ) {
    if ( ! is_numeric( $post_id ) || 'fglevent' !== get_post_type( (int) $post_id ) ) {
        return;
    }

    $post_id = (int) $post_id;
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) || 'auto-draft' === get_post_status( $post_id ) ) {
        return;
    }

    fgl_events_schedule_feed_rebuild();
}

function fgl_events_schedule_feed_rebuild() {
    static $queued = false;
    if ( $queued ) {
        return;
    }
    $queued = true;
    add_action( 'shutdown', 'fgl_events_rebuild_feeds', 20 );
}

function fgl_events_rebuild_feeds() {
    the_feed();
    the_feed_board();
    the_feed_community();
    the_feed_jpa();
    wp_reset_postdata();
}

function fgl_events_deleted_post( $post_id, $post ) {
    // The post no longer exists in the database at this point.
    if ( $post instanceof WP_Post && 'fglevent' === $post->post_type ) {
        fgl_events_schedule_feed_rebuild();
    }
}

add_action( 'save_post_fglevent', 'fgl_events_queue_feed_rebuild', 20 );
add_action( 'acf/save_post', 'fgl_events_queue_feed_rebuild', 20 );
add_action( 'trashed_post', 'fgl_events_queue_feed_rebuild', 20 );
add_action( 'untrashed_post', 'fgl_events_queue_feed_rebuild', 20 );
add_action( 'deleted_post', 'fgl_events_deleted_post', 20, 2 );
