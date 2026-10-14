<?php

/*

Plugin Name: Event Feeder
Plugin URI: https://foothillgoldline.com
Description: JSON for Events
Version: 1.0
Author: Mackey
Author URI: https://mackeycreativelab.com
*/

	/*Include custom post type and taxonomies*/
	//include( plugin_dir_path( __FILE__ ) . 'events-register-post-type.php');
	//include( plugin_dir_path( __FILE__ ) . 'events-register-taxonomies.php');
	include( plugin_dir_path( __FILE__ ) . 'events-custom-feed.php');
	include( plugin_dir_path( __FILE__ ) . 'events-board-feed.php');
	include( plugin_dir_path( __FILE__ ) . 'events-community-feed.php');
	include( plugin_dir_path( __FILE__ ) . 'events-jpl-feed.php');
	
?>