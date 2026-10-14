<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Foothill_Gold_Line
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo("charset"); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <title><?php if (is_home() || is_front_page()) {
          bloginfo("/");
        } else {
          wp_title();
        } ?></title>
        <meta name="keywords" content="los angeles metro, metro gold line, foothill extension">
        <meta name="description" content="The Foothill Extension will continue the Metro Gold Line light-rail line from East Pasadena to Montclair.">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/saved_resource.css">

        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/saved_resource(1).css?v=1.2">
        <link rel="shortcut icon" href="">

        <link rel="stylesheet" type="text/css" media="print" href="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/saved_resource(2).css">

        <!--Full Calendar -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/fullcalendar/fullcalendar.min.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/fullcalendar/fccustom.css?v=1.3">

        <style type="text/css">

            /*body {background: url('https://foothillgoldline.org/images/uploads/files/skins-oranges-bg-new.jpg') center top #ffffff no-repeat; }*/

        </style>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-RFZBLY18NG"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-RFZBLY18NG');
        </script>

		<!-- Font Awesome -->
		<script src="https://use.fontawesome.com/824dc1fb78.js"></script>

        <script type="text/javascript" async="" src="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/ga.js"></script>
        <script type="text/javascript" charset="utf-8">
            //<![CDATA[
            var Client = {
                nav: 'chr',
                v: 65.0,
                os: 'win'
            };
            //]]>
        </script>

        <?php if (is_singular("construction_phases")) { ?>
        	<!--Load older version of jQuery, maps etc depend on it-->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
        <?php } else { ?>
        	<script src="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/jquery.min.js" type="text/javascript"></script>
			<!--included because some plugins depend on older version of jquery 1.4.4-->
			<script src="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/jquery-migrate-1.4.1.min.js" type="text/javascript"></script>
        <?php } ?>

        <!-- conflicts with Full Calendar-->
        <?php if (!is_page_template("page-events-test.php")) { ?>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/jquery-ui.min.js" type="text/javascript"></script>
        <?php } ?>


        <?php if (!is_singular("construction_phases")) { ?>
        	<script src="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/jquery.cycle.all.min.js" type="text/javascript"></script>
        <?php } ?>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/metro.js" type="text/javascript"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/theme-files/fgl_files/modernizr.js" type="text/javascript"></script>
        <!--load scotch panels for mobile menu -->
		<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/scotchPanels.min.js" type="text/javascript"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/customizer.js?v=1.2" type="text/javascript"></script>

        <?php if (is_page()) { ?>
        <!--Full Calendar -->
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/fullcalendar/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/fullcalendar/fccustom.js?v=1.3" type="text/javascript"></script>
        <?php } ?>

        <script>
	    	/* Mobile Menu */

			jQuery(document).ready(function() {
				jQuery("#mobile-nav").show();
			});

			jQuery( document ).ready(function($) {
				var scotchPanel = $('#scotch-panel').scotchPanel({
					//useCSS: false,
	                containerSelector: 'body',
	                direction: 'right',
	                duration: 50,
	                transition: 'ease',
	                clickSelector: '.mobile-toggler',
	                distanceX: '75%',
	                enableEscapeKey: true
	            });
	            $("li.menu-item-has-children").append('<span class="mobile-menu-toggle"></span>');
				//now toggle that menu
				$("li.menu-item-has-children span.mobile-menu-toggle").click(function() {
					$(this).parent('li').find('ul.sub-menu').slideToggle();
					$(this).parent('li').toggleClass('current-menu-parent');
					console.log('Clicked Menu');
				});
	        });

			/* Menu stuff */



	    </script>

            <?php
            $body_bg = [];
            switch (get_post_type()) {
              case "construction_phases":
                $body_bg = get_field("construction_phases_skin_bg", "option");
                break;
              case "dual_content_with_ph":
                $body_bg = get_field("citiesstations_skin_bg", "option");
                break;
              case "cities_stations":
                $body_bg = get_field("citiesstations_skin_bg", "option");
                break;
              case "mec-events":
                $body_bg = get_field("meetingsevents_skin_bg", "option");
                break;
              case "headlines":
                $body_bg = get_field("news_skin_bg", "option");
                break;
              case "videos":
                $body_bg = get_field("news_skin_bg", "option");
                break;
              case "construction_authori":
                $body_bg = get_field("about_us_skin_bg", "option");
                break;
              case "default":
                $body_bg = get_field("about_us_skin_bg", "option");
                break;
              default:
                $body_bg = get_field("default_skin_bg", "option");
            }

            /* First check if skin is selected other than none */
            if (get_field("choose_a_skin") == "default") {
              $body_bg = $body_bg = get_field("default_skin_bg", "option");
            } elseif (get_field("choose_a_skin") == "about") {
              $body_bg = $body_bg = get_field("about_us_skin_bg", "option");
            } elseif (get_field("choose_a_skin") == "news") {
              $body_bg = $body_bg = get_field("news_skin_bg", "option");
            } elseif (get_field("choose_a_skin") == "events") {
              $body_bg = $body_bg = get_field(
                "meetingsevents_skin_bg",
                "option"
              );
            } elseif (get_field("choose_a_skin") == "cities") {
              $body_bg = $body_bg = get_field(
                "citiesstations_skin_bg",
                "option"
              );
            } elseif (get_field("choose_a_skin") == "construction") {
              $body_bg = $body_bg = get_field(
                "construction_phases_skin_bg",
                "option"
              );
            } else {
              if (
                get_page_template_slug() &&
                get_page_template_slug() === "page-press-rel.php"
              ) {
                $body_bg = $body_bg = get_field("news_skin_bg", "option");
              } elseif (
                get_page_template_slug() &&
                get_page_template_slug() === "page-boards-list.php"
              ) {
                $body_bg = $body_bg = get_field("about_us_skin_bg", "option");
              } elseif (
                get_page_template_slug() &&
                get_page_template_slug() === "page-events-page.php"
              ) {
                $body_bg = $body_bg = get_field(
                  "meetingsevents_skin_bg",
                  "option"
                );
              } elseif (
                get_page_template_slug() &&
                get_page_template_slug() === "page-board-archives.php"
              ) {
                $body_bg = $body_bg = get_field(
                  "meetingsevents_skin_bg",
                  "option"
                );
              } elseif (
                get_page_template_slug() &&
                get_page_template_slug() === "page-events-test.php"
              ) {
                $body_bg = $body_bg = get_field(
                  "meetingsevents_skin_bg",
                  "option"
                );
              }
            }
            ?>
        <?php wp_head(); ?>

        <!--Tracking Code -->
        <?php echo get_field("tracking_code", "option"); ?>
    </head>

    <body <?php body_class("clearfix"); ?> <?php if (
   $body_bg
 ) { ?>style="background-image: url(<?php echo $body_bg["url"]; ?>)" <?php } ?>>

	    <!-- Off canvas menu for mobile -->
	    <div id="scotch-panel">

		    <!--Mobile Nav -->
		    <?php wp_nav_menu([
        "theme_location" => "menu-1",
        "container_class" => "custom-menu-class",
        "container" => "ul",
        "menu_id" => "mobile-nav",
        "menu_class" => "clearfix menu",
      ]); ?>

		<!--/scotch-panel--></div>

        <div id="container" class="">

            <div id="header">
                <div class="header-logo">
                    <?php the_custom_logo(); ?>
                    <div id="LogoText">
                       	<img src="<?php bloginfo(
                          "template_directory"
                        ); ?>/images/FGL.jpg" />
                    </div>

                    <div class="header-signup"><a href="<?php bloginfo(
                      "url"
                    ); ?>/dual_content/sign-up-for-e-news/" class="header-signup-button">Sign Up for Project Updates</a></div>
                    <!-- Language Switcher  via WP Menu -->
                    <?php wp_nav_menu([
                      "theme_location" => "language-selector",
                      "container_class" => "fgl-language",
                      "container" => "ul",
                      "menu_id" => "fgl-language-selector",
                      "menu_class" => "clearfix menu",
                    ]); ?>

                </div>

                	<!-- MOBILE-->
                <div class="mobile-header">

	                <a href="<?php bloginfo(
                   "url"
                 ); ?>" class="mobile-logo"><img src="<?php bloginfo(
  "template_directory"
); ?>/images/fg-mobile-logo@2x.png" /></a>

	                <a href="#" class="mobile-toggler"><img src="<?php bloginfo(
                   "template_directory"
                 ); ?>/images/menu-icon@2x.png" class="mobile-toggler-closed" /><img src="<?php bloginfo(
  "template_directory"
); ?>/images/menu-close-icon@2x.png" class="mobile-toggler-open" /></a>

	            <!--/mobile-header--></div>

                <div id="mobile-header-utilities">

	                <div style="width: 100%;">
		                <div style="width: 70%; float: left;">
			                <a href="<?php bloginfo(
                     "url"
                   ); ?>/dual_content/sign-up-for-e-news/" class="header-signup-button">Sign Up for Project Updates</a>
		                </div>
		                <div style="width: 30%; float: right; position: relative;">
			            	  <!-- Language Switcher  via WP Menu -->
		                    <?php wp_nav_menu([
                        "theme_location" => "language-selector",
                        "container_class" => "fgl-language",
                        "container" => "ul",
                        "menu_id" => "fgl-language-selector",
                        "menu_class" => "clearfix menu",
                      ]); ?>
		                </div>
	                </div>


	                <!-- Breadcrumbs-->
	                <div class="breadcrumbs" style="clear: both;">
		                <ul>
		                <?php my_breadcrumb("sitemap"); ?>
		                </ul>
					<!--/breadcrumbs--></div>

	            <!--/mobile-header-utilities--></div>

                <div id="search">
                <?php get_search_form(); ?>

                </div>

                <!-- Desktop Menu-->
                    <?php wp_nav_menu([
                      "theme_location" => "menu-1",
                      "container_class" => "custom-menu-class",
                      "container" => "ul",
                      "menu_id" => "nav",
                      "menu_class" => "clearfix menu",
                    ]); ?>
            </div>

        <div id="contentArea">
