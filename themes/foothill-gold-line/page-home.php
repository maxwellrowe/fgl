<?php
/**
 * Template name: Home page
 */
get_header(); ?>

<?php while (have_posts()):
  the_post();

  the_content(
    sprintf(
      wp_kses(
        /* translators: %s: Name of current post. Only visible to screen readers */
        __(
          'Continue reading<span class="screen-reader-text"> "%s"</span>',
          "foothill-gold-line"
        ),
        [
          "span" => [
            "class" => [],
          ],
        ]
      ),
      get_the_title()
    )
  );
endwhile;
// End of the loop.
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        // Check if the Cycle plugin is loaded and the element exists
        if (jQuery.isFunction(jQuery.fn.cycle) && jQuery('.homeMediaBox').length) {
            jQuery('.homeMediaBox').cycle({
                fx: 'scrollHorz',
                easing: 'easeOutExpo',
                timeout: 4000,
                next: '.nextBtn',
                prev: '.prevBtn'
            });
        } else {
            console.warn("Either .homeMediaBox does not exist or the Cycle plugin is not loaded.");
        }
    });
</script>


<div id="homeTabs" class="tabs ui-tabs ui-widget ui-widget-content ui-corner-all">
    <ul class="tabLabels ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
        <li class="tabLabel1 ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#tabs-1"><?php esc_html_e(
          "What's New?",
          "foothill-gold-line"
        ); ?></a></li>
        <li class="tabLabel2 ui-state-default ui-corner-top"><a href="#tabs-2"><?php esc_html_e(
          "Meetings/Events",
          "foothill-gold-line"
        ); ?></a></li>
        <li class="tabLabel3 ui-state-default ui-corner-top"><a href="#tabs-3"><?php esc_html_e(
          "Video",
          "foothill-gold-line"
        ); ?></a></li>
    </ul>
    <div class="tabsPanel newsPanel ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-1">

        <?php
        wp_reset_query();
        query_posts([
          "post_type" => [
            "headlines",
            //"videos",
            "press_release",
          ],
          "meta_query" => [
            "relation" => "OR",
            "sticky" => [
              "key" => "make_this_post_sticky",
              "value" => "1",
              "compare" => "==",
            ],
            "not_sticky" => [
              "key" => "make_this_post_sticky",
              "value" => "0",
              "compare" => "==",
            ],
          ],
          "posts_per_page" => "10",
          "orderby" => [
            "sticky" => "DESC",
            "date" => "DESC",
          ],
          "post_status" => "publish",
        ]);
        if (have_posts()): ?>
            <ul>
                <?php while (have_posts()): ?>
                    <li>
                        <?php
                        the_post();
                        $post_type_object = get_post_type_object(
                          get_post_type()
                        );
                        $headlines_post_type = "Headlines";

                        $post_date =
                          get_field("toggle_date") === "show"
                            ? "<strong>" . get_the_date() . "</strong> - "
                            : "";

                        if (get_field("article_external_link")) {
                          $thelink = get_field("article_external_link");
                          if (strpos($thelink, "http") !== false) {
                            $link = $thelink;
                          } else {
                            $link = "http://" . $thelink;
                          }
                        }
                        if (get_field("file_link", $post->ID)) {
                          $attach = get_field("file_link");
                          $link = wp_get_attachment_url($attach["ID"]);
                        }
                        ?>

                        <?php if (
                          $post_type_object->label == $headlines_post_type
                        ) { ?>

                             <a href="<?php echo $link; ?>" title="<?php echo get_the_title(); ?>"> <?php echo $post_date; ?>
                            <?php echo get_the_title(); ?></a>

                        <?php } else { ?>

                             <a href="<?php echo $link; ?>" title="<?php echo get_the_title(); ?>"> <?php echo $post_date .
  " <strong>" .
  $post_type_object->label .
  ": </strong>"; ?>
                            <?php echo get_the_title(); ?></a>

                        <?php } ?>

                    </li>
                <?php endwhile; ?>
            </ul>
            <?php endif;
        wp_reset_query();
        ?>

    </div>
    <div class="tabsPanel eventsPanel ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="tabs-2">
        <!--EVENTS GO HERE -->

    <?php
    $today = date("Y-m-d H:i:s");
    // args
    $args = [
      "numberposts" => -1,
      "posts_per_page" => 9999,
      "post_type" => "fglevent",
      "meta_key" => "start_date_and_time",
      "orderby" => "meta_value",
      "order" => "ASC",
      "meta_query" => [
        [
          "key" => "start_date_and_time",
          "compare" => ">=",
          "value" => $today,
        ],
      ],
    ];
    // query
    $the_query = new WP_Query($args);
    ?>

        <?php if ($the_query->have_posts()): ?>

            <ul>

                <?php while ($the_query->have_posts()):
                  $the_query->the_post(); ?>

                    <li>
                        <?php $term_obj_list_category_slug = get_the_terms(
                          $post->ID,
                          "eventcat"
                        ); ?>
                        <?php $eventCatSlug = join(
                          ", ",
                          wp_list_pluck($term_obj_list_category_slug, "slug")
                        ); ?>
                        <?php $boardevent = "board-meeting"; ?>
                        <?php $communityevent = "community-meeting"; ?>
                        <?php $jpaevent = "jpa-and-tac-meeting"; ?>
                        <?php // get the date formatted for query param
                          if(get_field("start_date_and_time")) {
                            $start = get_field("start_date_and_time");
                            $months = [
                                "enero" => "January",
                                "febrero" => "February",
                                "marzo" => "March",
                                "abril" => "April",
                                "mayo" => "May",
                                "junio" => "June",
                                "julio" => "July",
                                "agosto" => "August",
                                "septiembre" => "September",
                                "octubre" => "October",
                                "noviembre" => "November",
                                "diciembre" => "December"
                            ];
                            // Convert Spanish month names to English
                            $start_fixed = str_replace(array_keys($months), array_values($months), strtolower($start));
                            $start_date = new DateTime($start_fixed);
                            $date = $start_date->format("Y-n-j");
                          }
                        ?>

                        <a href="<?php bloginfo(
                          "url"
                        ); ?>/calendar?eventid=<?php echo get_the_ID(); ?>&date=<?php echo $date; ?>">

                            <span class="bold">
                                <?php
                                if(get_field("start_date_and_time")) {
                                  $homedate = $start_date->format("M d, Y");
                                  echo $homedate;
                                }
                                ?>
                            </span>
                            - <?php the_title(); ?>
                        </a>

                    </li>

                <?php
                endwhile; ?>

            </ul>

        <?php endif; ?>

        <?php wp_reset_query();
// Restore global post data stomped by the_post().
?>

    </div>
    <div class="tabsPanel videoPanel ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="tabs-3">
        <div id="videosListing">
            <ul>
                <?php
                $videos = get_posts([
                  "numberposts" => 3,
                  "post_type" => "videos",
                ]);
                foreach ($videos as $video) {

                  $video_url = get_field("media_url", $video->ID);
                  $media_embed = get_field("media_embed", $video->ID);
                  $video_date = get_the_date("", $video->ID);
                  $video_title = get_the_title($video->ID);
                  ?>

                    <li class="item">
                        <a href="<?php echo $video_url; ?>" class="playVideo" target="_blank">
                            <?php
                            $media_thumb = get_field("media_thumb", $video->ID);
                            $video_thumb = has_post_thumbnail($video->ID)
                              ? get_the_post_thumbnail($video->ID)
                              : wp_get_attachment_image($media_thumb["ID"]);
                            echo $video_thumb;
                            ?>
                        </a>
                        <p>
                            <a href="<?php echo $video_url; ?>" target="_blank">
                                <?php echo $video_date; ?> &nbsp;&nbsp; | &nbsp;&nbsp;
                                <span class="bold"><?php echo $video_title; ?></span><br>

                            </a>
                        </p>
                        <div class="media_embed" style="display:none;">
                            <?php echo $media_embed; ?>
                        </div>
                    </li>
                <?php
                }
                ?>

            </ul>
        </div>
    </div>
</div>
<div id="homeRightContent">

    <span id="prevBtn" style="display: block;"><a href="#prev" aria-label="Previous slide"></a></span>
    <span id="nextBtn" style="display: block;"><a href="#next" aria-label="Next slide"></a></span>
    <div class="mediaBox" style="width: 466px; height: 278px; overflow: hidden;">
        <?php if (get_field("home_image_gallery")) {
          $home_gallery = get_field("home_image_gallery");
          shuffle($home_gallery);
          foreach ($home_gallery as $image) { ?>
                <img src="<?php echo $image["sizes"][
                  "home_slider"
                ]; ?>" style="width: 466px; height: 278px; overflow: hidden;">
                <?php }
        } ?>

    </div>
    <div id="videoBox">

    </div>

</div>

<?php
get_sidebar("index-2");
get_footer();

