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
    <table border="0" cellspacing="0" cellpadding="0" class="proposalTable">
        <tbody>
            <tr>
                <td class="rfpFirstColumn"><a href="#" class="proposalArrowLink"><img src="<?php echo get_stylesheet_directory_uri() . "/theme-files/arrow-yellow-off.gif"; ?>" width="8" height="19" alt="Yellow Arrow Right"></a> <strong><?php echo get_field("Id"); ?> - </strong></td>
                <td><strong><?php the_title(); ?></strong></td>
            </tr>

            <?php
            $attached_files = get_field("rfp_attached_files");
            if (is_array($attached_files)) {
                foreach ($attached_files as $attached_file) {
                    ?>
                    <tr>
                        <td></td>
                        <td>
                            <p><a href="<?php echo $attached_file['url']; ?>" title="<?php echo $attached_file['title']; ?>" ><?php echo get_field("Id") . ' - ' . $attached_file['description']; ?></a></p>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    <?php echo get_field("proposal_info"); ?>
</div>
<?php
get_footer();
