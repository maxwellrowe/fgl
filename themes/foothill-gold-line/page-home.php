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


<div class="home-feature-panels">
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

</div><!-- .home-feature-panels -->

<div class="home-updates">
  <?php
  $alerts_page_id = get_queried_object_id();
  $alerts_hidden = get_field( 'homepage_construction_alerts_hide', $alerts_page_id );
  $alerts_title = get_field( 'homepage_construction_alerts_title', $alerts_page_id ) ?: 'Construction Updates';
  $alerts_button = get_field( 'homepage_construction_alerts_button_text', $alerts_page_id ) ?: 'View All Construction Updates';
  $alerts_url = get_field( 'homepage_construction_alerts_button_link', $alerts_page_id );
  $alerts_url = is_string( $alerts_url ) ? esc_url( $alerts_url ) : '';
  $alerts_notices = $alerts_hidden ? array() : get_posts( array(
      'post_type' => 'construction_notice',
      'posts_per_page' => -1,
      'orderby' => 'date',
      'order' => 'DESC',
      'tax_query' => array(
          array(
              'taxonomy' => 'status',
              'field' => 'slug',
              'terms' => 'active',
              'include_children' => false,
          ),
      ),
      'meta_query' => array(
          array(
              'key' => 'make_this_notice_sticky',
              'value' => '1',
              'compare' => '=',
          ),
      ),
  ) );
  ?>
  <?php if ( ! $alerts_hidden && $alerts_notices ) : ?>
  <div class="home-updates__construction-updates">
    <div id="past-construction-notices-wrapper">
      <div class="construction-notices-inner">
        <div class="home-construction-heading">
          <h2><i class="fa-solid fa-helmet-safety" aria-hidden="true"></i><span><?php echo esc_html( $alerts_title ); ?></span></h2>
          <?php if ( $alerts_url ) : ?>
            <a class="fgl-button fgl-button--tan" href="<?php echo $alerts_url; ?>"><?php echo esc_html( $alerts_button ); ?></a>
          <?php endif; ?>
        </div>
        <?php get_template_part( 'template-parts/construction-notices-table', null, array( 'homepage' => true, 'notices' => $alerts_notices ) ); ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <div class="home-updates__enews">
    <?php
    $signup_page_id = get_queried_object_id();
    $signup_defaults = array(
        'title' => 'Sign Up for E-News',
        'link' => 'https://public.govdelivery.com/accounts/CAFGL/subscribers/qualify',
        'form_label' => 'Email Address',
        'form_placeholder' => 'Enter your email address',
        'button_text' => 'Submit',
    );
    $signup = array();
    foreach ( $signup_defaults as $key => $default ) {
        $value = get_field( 'homepage_sign_up_' . $key, $signup_page_id );
        $signup[$key] = is_string( $value ) && '' !== trim( $value ) ? $value : $default;
    }
    $signup_action = esc_url( $signup['link'], array( 'https', 'http' ) );
    if ( ! $signup_action ) {
        $signup_action = esc_url( $signup_defaults['link'] );
    }
    ?>
    <div class="section-heading">
      <h2 id="home-enews-title"><span class="fa-regular fa-envelope" aria-hidden="true"></span> <?php echo esc_html( $signup['title'] ); ?></h2>
      <a href="<?php echo esc_url( $signup['link'] ); ?>" class="fgl-button fgl-button--tan">Latest News</a>
    </div>
    <form id="GD-snippet-form" aria-labelledby="home-enews-title" accept-charset="UTF-8" action="<?php echo $signup_action; ?>" method="post">
      <input name="utf8" type="hidden" value="✓">
      <input name="authenticity_token" type="hidden" value="Pm6QGyCs4cutPrVvzS5oPCEyGMTI38rMd9/WXRd/a+Y=">
      <fieldset>
        <label for="home-enews-email"><?php echo esc_html( $signup['form_label'] ); ?> <span class="home-enews-required">(required)</span></label>
        <div class="home-enews-field">
          <input id="home-enews-email" name="email" type="email" autocomplete="email" required
            placeholder="<?php echo esc_attr( $signup['form_placeholder'] ); ?>">
        </div>
        <div class="button_panel">
          <input class="fgl-button fgl-button--primary" name="commit" type="submit" value="<?php echo esc_attr( $signup['button_text'] ); ?>">
        </div>
      </fieldset>
    </form>
  </div>
</div>

<div class="home-stations">
  <?php if ( shortcode_exists( 'stations_widget' ) ) : ?>
    <?php echo do_shortcode( '[stations_widget]' ); ?>
  <?php endif; ?>
</div>

<?php
get_footer();

