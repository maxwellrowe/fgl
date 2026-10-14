<?php
	
	/* Register Custom Taxonomies */
	function cptui_register_my_taxes() {

		/**
		 * Taxonomy: Categories.
		 */
	
		$labels = array(
			"name" => __( "Categories", "twentyseventeen" ),
			"singular_name" => __( "Category", "twentyseventeen" ),
		);
	
		$args = array(
			"label" => __( "Categories", "twentyseventeen" ),
			"labels" => $labels,
			"public" => true,
			"hierarchical" => true,
			"label" => "Categories",
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => array( 'slug' => 'categories', 'with_front' => true, ),
			"show_admin_column" => false,
			"show_in_rest" => false,
			"rest_base" => "",
			"show_in_quick_edit" => false,
		);
		register_taxonomy( "categories", array( "event" ), $args );
	
		/**
		 * Taxonomy: Organizations.
		 */
	
		$labels = array(
			"name" => __( "Organizations", "twentyseventeen" ),
			"singular_name" => __( "Organization", "twentyseventeen" ),
		);
	
		$args = array(
			"label" => __( "Organizations", "twentyseventeen" ),
			"labels" => $labels,
			"public" => true,
			"hierarchical" => true,
			"label" => "Organizations",
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => array( 'slug' => 'organization', 'with_front' => true, ),
			"show_admin_column" => false,
			"show_in_rest" => false,
			"rest_base" => "",
			"show_in_quick_edit" => false,
		);
		register_taxonomy( "organization", array( "event" ), $args );
	
		/**
		 * Taxonomy: Audiences.
		 */
	
		$labels = array(
			"name" => __( "Audiences", "twentyseventeen" ),
			"singular_name" => __( "Audience", "twentyseventeen" ),
		);
	
		$args = array(
			"label" => __( "Audiences", "twentyseventeen" ),
			"labels" => $labels,
			"public" => true,
			"hierarchical" => true,
			"label" => "Audiences",
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => array( 'slug' => 'audience', 'with_front' => true, ),
			"show_admin_column" => false,
			"show_in_rest" => false,
			"rest_base" => "",
			"show_in_quick_edit" => false,
		);
		register_taxonomy( "audience", array( "event" ), $args );
	
		/**
		 * Taxonomy: Displays.
		 */
	
		$labels = array(
			"name" => __( "Displays", "twentyseventeen" ),
			"singular_name" => __( "Display", "twentyseventeen" ),
		);
	
		$args = array(
			"label" => __( "Displays", "twentyseventeen" ),
			"labels" => $labels,
			"public" => true,
			"hierarchical" => true,
			"label" => "Displays",
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => array( 'slug' => 'display', 'with_front' => true, ),
			"show_admin_column" => false,
			"show_in_rest" => false,
			"rest_base" => "",
			"show_in_quick_edit" => false,
		);
		register_taxonomy( "display", array( "event" ), $args );
	
		/**
		 * Taxonomy: Campuses.
		 */
	
		$labels = array(
			"name" => __( "Campuses", "twentyseventeen" ),
			"singular_name" => __( "Campus", "twentyseventeen" ),
		);
	
		$args = array(
			"label" => __( "Campuses", "twentyseventeen" ),
			"labels" => $labels,
			"public" => true,
			"hierarchical" => true,
			"label" => "Campuses",
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => array( 'slug' => 'campus', 'with_front' => true, ),
			"show_admin_column" => false,
			"show_in_rest" => false,
			"rest_base" => "",
			"show_in_quick_edit" => false,
		);
		register_taxonomy( "campus", array( "event" ), $args );
	}
	
	add_action( 'init', 'cptui_register_my_taxes' );
	
?>