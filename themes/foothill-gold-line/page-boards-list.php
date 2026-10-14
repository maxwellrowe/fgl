<?php
/**
 * Template Name: Boards list
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

<div id="content" class="boardpage">
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
    ?>
    <div class="clear">
    <?php echo get_field("main_body", $current_id); ?>
    </div>
        <?php
        $bios_ids = array();
        if ($posts = get_posts(array(
            "numberposts" => 30,
            "post_type" => "board_of_directors",
            'order' => 'ASC'
                ))) {
            foreach ($posts as $post) {
                $bios_ids[$post->ID] = intval(get_field("Order"));
            }
            asort($bios_ids);
            foreach ($bios_ids as $b_id => $v_order) {
                if ($bios_picture = get_field("bios_picture", $b_id)) {
                    $picture = wp_get_attachment_image($bios_picture['ID'], "full");
                } else {
                    $picture = "";
                }
                ?>
            <div class="left bios-item">
                <table border="0" cellspacing="0" cellpadding="0" class="biosTable boardTable">
                    <tbody>
                        <tr>
                            <td class="bioPictureCell">
							<?php echo $picture; ?>
                            </td>
                            <td class="bioInfoCell">
                                <strong><?php echo get_the_title($b_id); ?><br>
								<?php echo get_field("bios_name", $b_id); ?></strong><br>
								<?php echo get_field("appointee_of", $b_id); ?><br><br>
                                    <?php echo get_field("bios_description", $b_id); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php
    }
}
?>
    <div class="left">
    <?php echo get_field("sub_body", $current_id); ?>
    </div>
</div>

<?php
get_footer();
