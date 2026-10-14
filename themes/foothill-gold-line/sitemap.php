<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Sitemap Template
 *
   Template Name: Sitemap
 *
 * @file           sitemap.php
 * @package        gConverter 
 * @filesource     wp-content/themes/gconverter/sitemap.php
 */
?>
<?php get_header(); ?>

<div id="content">
    <?php the_title("<h1>", "</h1>"); ?>
    <ul>
    <?php
        wp_list_categories(array(
            "exclude" => "1"
        ));
        
    ?>
    </ul>
</div><!-- end of #content-sitemap -->

<?php get_footer(); ?>