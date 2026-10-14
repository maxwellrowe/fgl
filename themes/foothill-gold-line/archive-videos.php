<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Foothill_Gold_Line
 */
get_header();
?>

<div class="">
    <div id="videoBox">
        <?php
        $resent_post = wp_get_recent_posts(array(
            'numberposts' => 1,
            'post_type' => 'videos',
        ));

        echo get_field("media_embed", $resent_post[0]["ID"]);
        ?>
    </div>
    <div id="videosListingArea">
        <h2><?php esc_html_e('Featured', 'foothill-gold-line'); ?></h2>

        <div id="videosListing">
            <ul>
                <?php
                $post_count = 1;
                while (have_posts() && $post_count <= 3) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part('template-parts/content', get_post_type());
                    $post_count++;
                endwhile;
                ?>
            </ul>
        </div>
    </div>
    <div id="videoArchive">
        <?php the_archive_title('<h2 class="page-title">', '</h2>'); ?>
        <div id="videoArchiveBox">
            <?php
            $videos_archive = get_posts(array(
                "numberposts" => -1,
                "post_type" => "videos"
            ));
            $videos_list_html = '<div class="videos">';
            $count = 0;
            for ($i = 0; $i < count($videos_archive) / 4; $i++) {
                $videos_list_html .= '<div class="page">';
                for ($j = 0; $j < 2; $j++) {
                    $videos_list_html .= '<div class="row">';
                    for ($item = 0; $item < 2; $item++) {
                        if ($count < count($videos_archive)) {
                            $videos_list_html .= '<div class="item">';
                            $video_id = $videos_archive[$count]->ID;
                            $media_thumb = get_field("media_thumb", $video_id);
                            $video_thumb = has_post_thumbnail($video_id) ? get_the_post_thumbnail($video_id) : wp_get_attachment_image($media_thumb["ID"]);
                            $media_url = get_field("media_url", $video_id);
                            $video_title = get_the_title($video_id);
                            $video_date = get_the_date('', $video_id);
                            $videos_list_html .= '<a href="' . $media_url . '" class="playVideo" target="_blank">';
                            $videos_list_html .= $video_thumb;
                            $videos_list_html .= '</a>';
                            $videos_list_html .= '<p>';
                            $videos_list_html .= '<a href="' . $media_url . '" target="_blank" class="playVideo">';
                            $videos_list_html .= '' . $video_date . '&nbsp;&nbsp; | &nbsp;&nbsp;';
                            $videos_list_html .= '<span class="bold">' . $video_title . '</span><br>';
                            $videos_list_html .= '</a>';
                            $videos_list_html .= '</p>';
//                            $videos_list_html .= '<div class="media_embed" style="display:none;">';
//                            $videos_list_html .= get_post_meta($video_id, 'Media embed', TRUE);
//                            $videos_list_html .= '</div>';
                            $videos_list_html .= '</div>';
                        }
                        $count++;
                    }
                    $videos_list_html .= '</div>';
                }
                $videos_list_html .= '</div>';
            }
            $videos_list_html .= '</div>';
            echo $videos_list_html;
            ?>

            <p class="paginator">
                <strong><a href="#prev" title="" class="prev">&lt;</a>
                    <span class="page">1</span> of <span class="pages"><?php echo ceil(count($videos_archive) / 4); ?></span>
                    <a href="#next" title="" class="next">&gt;</a></strong>
            </p>
        </div>
    </div>
</div>

<?php

get_footer();
