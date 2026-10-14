<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Foothill_Gold_Line
 */
?>
<li class="item">
    <a href="<?php echo get_field("media_url"); ?>" class="playVideo" target="_blank">
        <?php
            $media_thumb = get_field("media_thumb");
            $video_thumb = has_post_thumbnail(get_the_ID()) ? get_the_post_thumbnail(get_the_ID()) : wp_get_attachment_image($media_thumb["ID"]);
            echo $video_thumb;
        ?>
    </a>
    <p>
        <a href="<?php echo get_field("media_url"); ?>" target="_blank">
            <?php the_date(); ?> &nbsp;&nbsp; | &nbsp;&nbsp;
            <span class="bold"><?php the_title(); ?></span><br>

        </a>
    </p>
    <div class="media_embed" style="display:none;">
        <?php echo get_field("media_embed"); ?>
    </div>
</li>


