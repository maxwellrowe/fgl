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

<div id="contentLeft">
    <?php echo get_field("authority_main_body"); ?>
</div>
<div class="container full-width-mobile mobile-gallery" style="position: relative; width: 467px; height: 348px; float: right;">
    <span id="prevBtn" style="display: none;"><a href="#prev" aria-label="Previous slide"></a></span>
    <span id="nextBtn" style="display: none;"><a href="#next" aria-label="Next slide"></a></span>
    <div class="mediaBox right">
        <?php
        if ($gallery_imgs = get_field("authority_beforeafter_gallery")) {
            foreach ($gallery_imgs as $gallery_img) {
                echo wp_get_attachment_image($gallery_img['ID'], "slider_image");
            }
        }
        ?>
    </div>
    <div id="galleryCache" class="hide">
        <div id="beforeAfter">
            <?php
            if ($gallery_imgs = get_field("authority_beforeafter_gallery")) {
                foreach ($gallery_imgs as $gallery_img) {
                    echo wp_get_attachment_image($gallery_img['ID'], "large");
                }
            }
            ?>
        </div>
        <div id="construction">
            <?php
            if ($gallery_imgs = get_field("aurthority_constructionimage_gal")) {
                foreach ($gallery_imgs as $gallery_img) {
                    echo wp_get_attachment_image($gallery_img['ID'], "large");
                }
            }
            ?>
        </div>
        <div id="meetings">
            <?php
            if ($gallery_imgs = get_field("authority_meeting_gallery")) {
                foreach ($gallery_imgs as $gallery_img) {
                    echo wp_get_attachment_image($gallery_img['ID'], "large");
                }
            }
            ?>
        </div>
    </div>
</div>
<div class="halfBtmContentAuthority right galleryswitch">
    <p>
        <?php if (get_field("aurthority_constructionimage_gal")) { ?>
            <a href="#construction" class="gallery" title=""><?php esc_html_e('construction images', 'foothill-gold-line'); ?></a>&nbsp;&nbsp;&nbsp;
            <?php
        }
        if (get_field("authority_meeting_gallery")) {
            ?>
            <a href="#meetings" class="gallery" title=""><?php esc_html_e('public meetings', 'foothill-gold-line'); ?></a>&nbsp;&nbsp;&nbsp;
            <?php }
        ?>
    </p>
    <?php
    echo get_field("authority_sub_body");
    ?>
</div>
<?php
get_footer();
