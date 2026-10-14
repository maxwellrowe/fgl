<?php
/**
 * Template Name: Dual Content presentations
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Foothill_Gold_Line
 */
get_header();
?>

<div id="contentLeft">
    <?php
    while (have_posts()) :
        the_post();

        the_content(sprintf(
                        wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers */
                                __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'foothill-gold-line'), array(
            'span' => array(
                'class' => array(),
            ),
                                )
                        ), get_the_title()
        ));

    endwhile; // End of the loop.
    ?>
    <?php echo get_field("main_body"); ?>
</div>
<div id="contentRight">
    <?php
    echo get_field("sub_body");
    $post_type_object = get_post_type_object("speaker_presentation");
    ?>
    <p>
        <?php
        if (get_field("display_archive") === "Yes") {
            if ($posts = get_posts(array(
                'numberposts' => 25,
                'post_type' => 'speaker_presentation'
                    ))) {
                foreach ($posts as $post) {
                    if ($attach_id = get_field("File")) {
                        $url = wp_get_attachment_url($attach_id);
                    } else {
                        $url = get_the_permalink($post->ID);
                    }
                    ?>
                <p><a href="<?php echo $url; ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
            <?php
            }
        }
    }
    ?>
</p>
</div>
<?php
get_footer();
