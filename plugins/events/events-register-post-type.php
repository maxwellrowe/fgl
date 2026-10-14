<?php
	
	/* Register Custom Post Type */
	
	function cptui_register_my_cpts_event() {

		/**
		 * Post Type: Events.
		 */
	
		$labels = array(
			"name" => __( "Events", "twentyseventeen" ),
			"singular_name" => __( "Event", "twentyseventeen" ),
		);
	
		$args = array(
			"label" => __( "Events", "twentyseventeen" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"has_archive" => false,
			"show_in_menu" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "event", "with_front" => true ),
			"query_var" => true,
			"supports" => array( "title", "editor", "thumbnail", "revisions" ),
		);
	
		register_post_type( "event", $args );
	}
	
	add_action( 'init', 'cptui_register_my_cpts_event' );

?>