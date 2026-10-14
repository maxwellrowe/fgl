<?php
/**
 * Template Name: Press rel
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

<div id="contentArea">
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
        <?php
        $current_id = get_the_ID();
        echo get_field("main_body", $current_id);
        ?>

        <?php
        $post_type = get_post_type();
        $posts = get_posts(array(
            'numberposts' => 10,
            'post_type' => 'press_release',
        ));
        foreach ($posts as $post) {
            $link = get_permalink($post->ID);
            $post_date = get_field("toggle_date") === "show" ? "<strong>" . get_the_date('', $post->ID) . "</strong> - " : "";
            if (get_field("file_link", $post->ID)) {
                $attach = get_field("file_link", $post->ID);
                $link = wp_get_attachment_url($attach['ID']);
            }
            if (get_field("article_external_link")) {
                if (!strstr(get_field("article_external_link"), "http://")) {
                    $link = "http://" . get_field("article_external_link");
                } else {
                    $link = get_field("article_external_link");
                }
            }
            ?>

                <a href="<?php echo $link; ?>" title="<?php echo get_the_title($post->ID); ?>"> <?php echo $post_date; ?>
                    <?php echo get_the_title($post->ID); ?>
                </a>
				<?php echo get_field("article_teaser"); ?>

            <?php
        }
        ?>
    </div>
    <div id="contentRight">
        <?php echo get_field("sub_body", $current_id); ?>
    </div>
</div>

<?php
get_footer();
