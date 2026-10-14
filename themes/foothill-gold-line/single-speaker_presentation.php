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
    <p><strong><?php esc_html_e('Click on the link(s) to download the file(s)', 'foothill-gold-line'); ?></strong></p>

            <?php
            if($attach_id = get_field("File")){
                    $url = wp_get_attachment_url($attach_id);
                }else{
                    $url = get_the_permalink();
                }
            ?>
    <p><a href="<?php echo $url; ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
    <?php echo get_field("description"); ?>
</div>
<?php
get_footer();
