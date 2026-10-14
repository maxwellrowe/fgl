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
    <div class="flex-row">
        <div class="left">
            <?php
            if ($bios_picture = get_field("bios_picture")) {
                $picture = wp_get_attachment_image($bios_picture['ID'], "full");
            } else {
                $picture = wp_get_attachment_image($bios_picture['ID'], "full");
            }
            echo $picture;
            ?>
        </div>
        <div class="left left-space">
            <strong><?php the_title(); ?><br>
                <?php echo get_field("bios_name"); ?></strong><br>
            <?php echo get_field("appointee_of"); ?><br><br>
            <?php echo get_field("bios_description"); ?>
        </div>
    </div>
    <div class="clear"><br></div>
    <div class="">
        <a href="tel:<?php echo get_field("bios_phone"); ?>"><?php echo get_field("bios_phone"); ?></a><br>
        <a href="mailto:<?php echo get_field("bios_email"); ?>"><?php echo get_field("bios_email"); ?></a>
    </div>
</div>
<?php
get_footer();
