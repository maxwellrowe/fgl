<?php
/**
 * The template for displaying single skins
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Foothill_Gold_Line
 */

get_header();
?>
<div id="content">
    <?php the_title( '<h3>', '</h3>' ); ?>
    <div class=""><?php echo get_post_meta(get_the_ID(), 'Skin phases') ?></div>
    <div class=""><?php echo get_post_meta(get_the_ID(), 'Skin cities') ?></div>
    <div class=""><?php echo get_post_meta(get_the_ID(), 'Skin default') ?></div>
    <div class=""><?php echo get_post_meta(get_the_ID(), 'Skin events') ?></div>
    <div class=""><?php echo get_post_meta(get_the_ID(), 'Skin news') ?></div>
    <div class=""><?php echo get_post_meta(get_the_ID(), 'Skin aboutus'); ?></div>
    
    
    
    <?php 
    foreach (get_post_meta(get_the_ID(), 'Skin phases') as $phase){ ?>
        <div class=""><?php echo $phase; ?></div>
    <?php }
    ?>
</div>
<?php

get_footer();