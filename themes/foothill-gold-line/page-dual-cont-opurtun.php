<?php
/**
 * Template Name: Dual Content oportunity archive
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

<div id="contentLeft" class="content_type_archive">
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
    echo get_field("main_body");
    if (get_field("display_archive") === "Yes") {
        $sql = "SELECT pm.`meta_value` AS id_val, GROUP_CONCAT(pm.`post_id` ORDER BY p.`post_date` DESC) AS post_ids
                    FROM `" . $wpdb->prefix . "postmeta` pm
                    INNER JOIN `" . $wpdb->prefix . "posts` p ON p.`ID` = pm.`post_id` AND p.post_type = 'contracting_opportun'
                    WHERE pm.`meta_key` = 'Id'
                    GROUP BY pm.`meta_value`
                    ORDER BY  p.`post_date` DESC";
        if ($p_ids_datas = $wpdb->get_results($sql, ARRAY_A)) {
            ?>
            <div class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons" role="tablist">
                <?php
                foreach ($p_ids_datas as $p_ids_data) {
                    $post_ids = explode(",", $p_ids_data['post_ids']);
                    if (count($post_ids) > 1) {
                        ?>
                        <h3 class="toggle-header ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" role="tab" aria-expanded="true" tabindex="0">
                            <span class="ui-icon ui-icon-triangle-1-e"></span> <?php echo $p_ids_data["id_val"] . " - " . esc_html__(" (click here to see more)", 'foothill-gold-line'); ?>
                        </h3>
                        <ul class="toggle-item ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" role="tabpanel" style="">
                            <div class="accordion ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion ui-widget ui-accordion-icons ui-accordion-content-active" role="tablist" style="">
                                <?php
                                foreach ($post_ids as $post_id) {
                                    ?>
                                    <p class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <strong><?php echo get_the_title($post_id); ?></strong>
                                    </p>
                                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" role="tabpanel">
                                        <ul>
                                            <?php
                                            if ($attached_files = get_field("rfp_attached_files", $post_id)) {
                                                foreach ($attached_files as $attach_file) {
                                                    ?>
                                                    <li class="files"><a href="<?php echo $attach_file['url']; ?>"><?php echo $attach_file['description']; ?></a></li>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <li class="files"><a href=""><?php echo $p_ids_data["id_val"] . " " . get_the_title($post_id); ?></a></li>
                                            <?php }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </ul>
                        <?php
                    } else {
                        ?>
                        <?php if(get_field('open_toggle_by_default', $post_ids[0])) {
                            $toggle_open = 'toggle-open';
                        } else {
                            $toggle_open = '';
                        } ?>
                        <h3 class="toggle-header ui-accordion-header ui-helper-reset ui-state-default ui-corner-all <?php echo $toggle_open; ?>" role="tab" aria-expanded="true" tabindex="0">
                            <span class="ui-icon ui-icon-triangle-1-e"></span> <?php echo $p_ids_data["id_val"] . " - " . get_the_title($post_ids[0]); ?>
                        </h3>
                        <ul class="toggle-content ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom <?php echo $toggle_open; ?>" role="tabpanel" style="">
                            <?php
                            if ($attached_files = get_field("rfp_attached_files", $post_ids[0])) {
                                foreach ($attached_files as $attach_file) {
                                    ?>
                                    <li class="files"><a href="<?php echo $attach_file['url']; ?>"><?php echo $attach_file['description']; ?></a></li>
                                    <?php
                                }
                            }
                            ?>
                            <?php if(get_field('proposal_info',$post_ids[0])) { ?>
                                <li class="files"><?php echo get_field('proposal_info',$post_ids[0]); ?></li>
                            <?php } ?>
                        </ul>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
        }
    }
    ?>
</div>
<div id="contentRight" class="oportunity-right">
    <?php echo get_field("sub_body"); ?>
</div>
<?php
get_footer();
