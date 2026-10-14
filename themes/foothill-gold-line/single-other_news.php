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
    <?php
        $post_type_object = get_post_type_object(get_post_type());
    ?>
    <h2 style="text-transform: capitalize"><?php echo $post_type_object->label; ?></h2>
    <?php echo get_the_date(); ?>
    <h3><?php the_title(); ?></h3>
    <?php echo echo get_field("article_main_body"); ?>
    <p><?php echo echo get_field("article_teaser"); ?></p>
</div>
<?php

get_footer();