<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Foothill_Gold_Line
 */
get_header();
?>

<div id="content" class="content-area" >
     <?php
        $post_type_object = get_post_type_object(get_post_type());
    ?>
    <h2 style="text-transform: capitalize"><?php echo $post_type_object->label; ?></h2>
    <h3 class="fgl-template-content-title"><?php the_title(); ?></h3>
    <p>
        <strong><?php echo get_the_date(); ?></strong>
        <?php echo get_field("media_desc"); ?>
    </p>
    <div class="media_embed"><?php echo get_field("media_embed"); ?> </div>
</div><!-- #primary -->

<?php
get_footer();
