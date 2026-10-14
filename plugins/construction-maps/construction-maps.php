<?php
/*
Plugin Name: Construction Maps
Plugin URI: https://foothillgoldline.com
Description: Construction Map Notices for Foothill Gold Line
Version: 1.0
Author: Mackey
Author URI: https://mackeycreativelab.com
*/
	// IMPORTANT: Make sure to add Custom Fields via ACF for plugin to work correctly

	/*Include custom post type and taxonomies*/
	include( plugin_dir_path( __FILE__ ) . 'cm-post-tax.php');
	include( plugin_dir_path( __FILE__ ) . 'cm-acf-options.php');
	
	// Enqueue Scripts and Styles
	function construction_maps_enqueue_script() {   
		wp_enqueue_script( 'cm-datatables', 'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'cm-js', plugin_dir_url( __FILE__ ) . 'js/construction_maps.js', array('jquery'), '1.0', true );
	}
	add_action('wp_enqueue_scripts', 'construction_maps_enqueue_script');
	
	function construction_maps_equeue_styles() {
		wp_enqueue_style('cm_font','https://use.typekit.net/goi8bom.css');
		wp_enqueue_style('cm_datatables','https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css');
		wp_enqueue_style( 'cm-css', plugins_url( '/css/construction_maps.css', __FILE__ ) );
	}
	add_action( 'wp_enqueue_scripts', 'construction_maps_equeue_styles' );
	
	// Add Google Maps API Key
	function my_acf_google_map_api( $api ){
	    $api['key'] = 'AIzaSyBPnA68Dhw8VMqZgqdcJpCQaofUICAGQgE';
	    return $api;
	}
	add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
	
?>