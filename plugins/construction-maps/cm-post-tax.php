<?php 
	// CPT for Construction Notices
	function cptui_register_my_cpts_construction_notice() {
		$labels = [
			"name" => __( "Construction Notices", "foothill-gold-line" ),
			"singular_name" => __( "Construction Notice", "foothill-gold-line" ),
		];
	
		$args = [
			"label" => __( "Construction Notices", "foothill-gold-line" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "construction_notice",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => [ "slug" => "construction_notice", "with_front" => true ],
			"query_var" => true,
			"menu_position" => 10,
			"menu_icon" => "dashicons-megaphone",
			"supports" => [ "title", "editor", "thumbnail", "revisions" ],
		];
	
		register_post_type( "construction_notice", $args );
	}
	
	add_action( 'init', 'cptui_register_my_cpts_construction_notice' );
	
	
	// Type of Construction Taxonomy
	function cptui_register_my_taxes_construction_type() {
		$labels = [
			"name" => __( "Types", "foothill-gold-line" ),
			"singular_name" => __( "Type", "foothill-gold-line" ),
			"add_new_item" => __("Add New Type", "foothill-gold-line" ),
		];
	
		$args = [
			"label" => __( "Types", "foothill-gold-line" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => true,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'construction_type', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"rest_base" => "construction_type",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			];
		register_taxonomy( "construction_type", [ "construction_notice" ], $args );
	}
	add_action( 'init', 'cptui_register_my_taxes_construction_type' );
	
	// City Taxonomy
	function cptui_register_my_taxes_city() {
		$labels = [
			"name" => __( "Cities", "foothill-gold-line" ),
			"singular_name" => __( "City", "foothill-gold-line" ),
			"add_new_item" => __("Add New City", "foothill-gold-line" ),
		];
	
		$args = [
			"label" => __( "Cities", "foothill-gold-line" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => true,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'city', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"rest_base" => "city",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			];
		register_taxonomy( "city", [ "construction_notice" ], $args );
	}
	add_action( 'init', 'cptui_register_my_taxes_city' );

	
?>