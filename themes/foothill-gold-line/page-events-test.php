<?php
/**
 * Template name: Test Events page
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

get_header(); ?>

	<div id="primary" class="content-area calendarPage">
		<main id="main" class="site-main">

		<div id="calendarArea">

			<div id="calbuttons">

				<button id="calendarprev"></button>
				<button id="calendarnext"></button>

			<!--/calbuttons--></div>

			<div id='calendarfc'></div>

		<!--calendarArea--></div>

		<div class="halfBtmContent halfBtmContentCalMobile">
			<table border="0" cellspacing="0" cellpadding="0" id="calendarTodayTable">
				<tbody><tr>
					<td>
						<img src="https://foothillgoldline.org/images/circle-yellow.gif" width="13" height="13" alt="">
					</td>
					<td class="calTodayTypeCol">
						<strong>Board Meeting</strong>
					</td>

					<?php
     $today = date("Y-m-d");
     // args
     $args = [
       "numberposts" => -1,
       "posts_per_page" => 1,
       "post_type" => "fglevent",
       "meta_key" => "start_date_and_time",
       "orderby" => "meta_value",
       "order" => "ASC",
       "tax_query" => [
         [
           "taxonomy" => "eventcat",
           "field" => "slug",
           "terms" => "board-meeting",
         ],
       ],
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

						<?php while ($the_query->have_posts()):
        $the_query->the_post(); ?>

							<?php $thedate = get_field("start_date_and_time", false, false); ?>
							<?php $thedate = new DateTime($thedate); ?>

							<?php
       $todaysdate = date("Y-m-d");
       $postsdate = $thedate->format("Y-m-d");

       if ($todaysdate === $postsdate) { ?>

									<td style="white-space: nowrap;"><?php echo $thedate->format(
           "M j"
         ); ?> <?php echo $thedate->format("H:i a"); ?></td>
									<td><em><?php if (
           get_field("cancelled")
         ) { ?><strike><?php the_title(); ?></strike><?php } else {the_title();} ?></em></td>

								<?php } else { ?>

									<td><em>no events today</em></td>
									<td>&nbsp;</td>

								<?php }
       ?>

						<?php
      endwhile; ?>

						<?php else: ?>

							<td><em>no events today</em></td>
							<td>&nbsp;</td>

						<?php endif; ?>

						<?php wp_reset_query();
// Restore global post data stomped by the_post().
?>

				</tr>
					<tr>
						<td>
							<img src="https://foothillgoldline.org/images/circle-blue.gif" width="13" height="13" alt="">
						</td>
						<td class="calTodayTypeCol">
							<strong>JPA &amp; TAC</strong>
						</td>

						<?php
      $today = date("Y-m-d");
      // args
      $args = [
        "numberposts" => -1,
        "posts_per_page" => 1,
        "post_type" => "fglevent",
        "meta_key" => "start_date_and_time",
        "orderby" => "meta_value",
        "order" => "ASC",
        "tax_query" => [
          [
            "taxonomy" => "eventcat",
            "field" => "slug",
            "terms" => "jpa-and-tac-meeting",
          ],
        ],
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

						<?php while ($the_query->have_posts()):
        $the_query->the_post(); ?>

							<?php $thedate = get_field("start_date_and_time", false, false); ?>
							<?php $thedate = new DateTime($thedate); ?>

							<?php
       $todaysdate = date("Y-m-d");
       $postsdate = $thedate->format("Y-m-d");

       if ($todaysdate === $postsdate) { ?>

									<td style="white-space: nowrap;"><?php echo $thedate->format(
           "M j"
         ); ?> <?php echo $thedate->format("H:i a"); ?></td>
									<td><em><?php if (
           get_field("cancelled")
         ) { ?><strike><?php the_title(); ?></strike><?php } else {the_title();} ?></em></td>

								<?php } else { ?>

									<td><em>no events today</em></td>
									<td>&nbsp;</td>

								<?php }
       ?>

						<?php
      endwhile; ?>

						<?php else: ?>

							<td><em>no events today</em></td>
							<td>&nbsp;</td>

						<?php endif; ?>

						<?php wp_reset_query();
// Restore global post data stomped by the_post().
?>

					</tr>
					<tr>
						<td>
							<img src="https://foothillgoldline.org/images/circle-gray.gif" width="13" height="13" alt="">
						</td>
						<td class="calTodayTypeCol">
							<strong>Community</strong>
						</td>

						<?php
      $today = date("Y-m-d");
      // args
      $args = [
        "numberposts" => -1,
        "posts_per_page" => 1,
        "post_type" => "fglevent",
        "meta_key" => "start_date_and_time",
        "orderby" => "meta_value",
        "order" => "ASC",
        "tax_query" => [
          [
            "taxonomy" => "eventcat",
            "field" => "slug",
            "terms" => "community-meeting",
          ],
        ],
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

						<?php while ($the_query->have_posts()):
        $the_query->the_post(); ?>

							<?php $thedate = get_field("start_date_and_time", false, false); ?>
							<?php $thedate = new DateTime($thedate); ?>

							<?php
       $todaysdate = date("Y-m-d");
       $postsdate = $thedate->format("Y-m-d");

       if ($todaysdate === $postsdate) { ?>

									<td style="white-space: nowrap;"><?php echo $thedate->format(
           "M j"
         ); ?> <?php echo $thedate->format("H:i a"); ?></td>
									<td><em><?php if (
           get_field("cancelled")
         ) { ?><strike><?php the_title(); ?></strike><?php } else {the_title();} ?></em></td>

								<?php } else { ?>

									<td><em>no events today</em></td>
									<td>&nbsp;</td>

								<?php }
       ?>

						<?php
      endwhile; ?>

						<?php else: ?>

							<td><em>no events today</em></td>
							<td>&nbsp;</td>

						<?php endif; ?>

						<?php wp_reset_query();
// Restore global post data stomped by the_post().
?>

					</tr>
			</tbody></table>
		</div>

		<div id="contentRight">

			<div id="contentRightEventsContent">

				<?php while (have_posts()):
      the_post(); ?>

					<?php if (!is_page("calendar")) { ?>
						<h3><?php the_title(); ?></h3>
					<?php } ?>

					<?php the_content();
    endwhile;
// End of the loop.
?>

				<!--The Events Listing -->
				<?php if (is_page("calendar")) { ?>

					<?php
     $pages = get_field("calendar_pages_order");

     if (!empty($pages)) {
       foreach ($pages as $page) {
         $post_id = $page["calendar_page"]; ?>
							<h3><?php echo get_the_title($post_id); ?></h3>
							<?php if (get_post($post_id)) {
         $post = get_post($post_id);
         $content = apply_filters("the_content", $post->post_content);
         echo $content;
       } ?>

							<?php if ($post_id == "2147") { ?>
								<div id="boardCalList"></div>
							<?php } ?>
							<?php if ($post_id == "2151") { ?>
								<div id="jpaCalList"></div>
							<?php } ?>
							<?php if ($post_id == "2144") { ?>
								<div id="communityCalList"></div>
							<?php } ?>
							<div style="border-bottom: 1px solid #10155e; height: 20px;"></div>
						<?php
       } ?>
						<div style="height: 20px;"></div>
						<?php
     } else {
        ?>

						<h3><?php echo get_the_title("2147"); ?></h3>
						<?php if (get_post("2147")) {
        $id = "2147";
        $post = get_post($id);
        $content = apply_filters("the_content", $post->post_content);
        echo $content;
      } ?>
						<div id="boardCalList"></div>

						<hr />
						<h3><?php echo get_the_title("2151"); ?></h3>
						<?php if (get_post("2151")) {
        $id = "2151";
        $post = get_post($id);
        $content = apply_filters("the_content", $post->post_content);
        echo $content;
      } ?>
						<div id="jpaCalList"></div>

						<hr />
						<h3><?php echo get_the_title("2144"); ?></h3>
						<?php if (get_post("2144")) {
        $id = "2144";
        $post = get_post($id);
        $content = apply_filters("the_content", $post->post_content);
        echo $content;
      } ?>
						<div id="communityCalList"></div>
						<div style="height: 20px;"></div>

					<?php
     }
     ?>

				<?php } elseif (is_page("board-meetings-agendas")) { ?>

					<div id="boardCalList"></div>

				<?php } elseif (is_page("jpa-tac-meetings-agendas")) { ?>

					<div id="jpaCalList"></div>

				<?php } elseif (is_page("community-meetings-events")) { ?>
					<div id="communityCalList"></div>

				<?php } ?>

			<!--/contentRightEventsContent--></div>

		<!--contentRight--></div>

		<div class="halfBtmContent">
			<table border="0" cellspacing="0" cellpadding="0" id="calendarTodayTable">
				<tbody><tr>
					<td>
						<img src="https://foothillgoldline.org/images/circle-yellow.gif" width="13" height="13" alt="">
					</td>
					<td class="calTodayTypeCol">
						<strong>Board Meeting</strong>
					</td>

					<?php
     $today = date("Y-m-d");
     // args
     $args = [
       "numberposts" => -1,
       "posts_per_page" => 1,
       "post_type" => "fglevent",
       "meta_key" => "start_date_and_time",
       "orderby" => "meta_value",
       "order" => "ASC",
       "tax_query" => [
         [
           "taxonomy" => "eventcat",
           "field" => "slug",
           "terms" => "board-meeting",
         ],
       ],
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

						<?php while ($the_query->have_posts()):
        $the_query->the_post(); ?>

							<?php $thedate = get_field("start_date_and_time", false, false); ?>
							<?php $thedate = new DateTime($thedate); ?>

							<?php
       $todaysdate = date("Y-m-d");
       $postsdate = $thedate->format("Y-m-d");

       if ($todaysdate === $postsdate) { ?>

									<td style="white-space: nowrap;"><?php echo $thedate->format(
           "M j"
         ); ?> <?php echo $thedate->format("H:i a"); ?></td>
									<td><em><?php if (
           get_field("cancelled")
         ) { ?><strike><?php the_title(); ?></strike><?php } else {the_title();} ?></em></td>

								<?php } else { ?>

									<td><em>no events today</em></td>
									<td>&nbsp;</td>

								<?php }
       ?>

						<?php
      endwhile; ?>

						<?php else: ?>

							<td><em>no events today</em></td>
							<td>&nbsp;</td>

						<?php endif; ?>

						<?php wp_reset_query();
// Restore global post data stomped by the_post().
?>

				</tr>
					<tr>
						<td>
							<img src="https://foothillgoldline.org/images/circle-blue.gif" width="13" height="13" alt="">
						</td>
						<td class="calTodayTypeCol">
							<strong>JPA &amp; TAC</strong>
						</td>

						<?php
      $today = date("Y-m-d");
      // args
      $args = [
        "numberposts" => -1,
        "posts_per_page" => 1,
        "post_type" => "fglevent",
        "meta_key" => "start_date_and_time",
        "orderby" => "meta_value",
        "order" => "ASC",
        "tax_query" => [
          [
            "taxonomy" => "eventcat",
            "field" => "slug",
            "terms" => "jpa-and-tac-meeting",
          ],
        ],
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

						<?php while ($the_query->have_posts()):
        $the_query->the_post(); ?>

							<?php $thedate = get_field("start_date_and_time", false, false); ?>
							<?php $thedate = new DateTime($thedate); ?>

							<?php
       $todaysdate = date("Y-m-d");
       $postsdate = $thedate->format("Y-m-d");

       if ($todaysdate === $postsdate) { ?>

									<td style="white-space: nowrap;"><?php echo $thedate->format(
           "M j"
         ); ?> <?php echo $thedate->format("H:i a"); ?></td>
									<td><em><?php if (
           get_field("cancelled")
         ) { ?><strike><?php the_title(); ?></strike><?php } else {the_title();} ?></em></td>

								<?php } else { ?>

									<td><em>no events today</em></td>
									<td>&nbsp;</td>

								<?php }
       ?>

						<?php
      endwhile; ?>

						<?php else: ?>

							<td><em>no events today</em></td>
							<td>&nbsp;</td>

						<?php endif; ?>

						<?php wp_reset_query();
// Restore global post data stomped by the_post().
?>

					</tr>
					<tr>
						<td>
							<img src="https://foothillgoldline.org/images/circle-gray.gif" width="13" height="13" alt="">
						</td>
						<td class="calTodayTypeCol">
							<strong>Community</strong>
						</td>

						<?php
      $today = date("Y-m-d");
      // args
      $args = [
        "numberposts" => -1,
        "posts_per_page" => 1,
        "post_type" => "fglevent",
        "meta_key" => "start_date_and_time",
        "orderby" => "meta_value",
        "order" => "ASC",
        "tax_query" => [
          [
            "taxonomy" => "eventcat",
            "field" => "slug",
            "terms" => "community-meeting",
          ],
        ],
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

						<?php while ($the_query->have_posts()):
        $the_query->the_post(); ?>

							<?php $thedate = get_field("start_date_and_time", false, false); ?>
							<?php $thedate = new DateTime($thedate); ?>

							<?php
       $todaysdate = date("Y-m-d");
       $postsdate = $thedate->format("Y-m-d");

       if ($todaysdate === $postsdate) { ?>

									<td style="white-space: nowrap;"><?php echo $thedate->format(
           "M j"
         ); ?> <?php echo $thedate->format("H:i a"); ?></td>
									<td><em><?php if (
           get_field("cancelled")
         ) { ?><strike><?php the_title(); ?></strike><?php } else {the_title();} ?></em></td>

								<?php } else { ?>

									<td><em>no events today</em></td>
									<td>&nbsp;</td>

								<?php }
       ?>

						<?php
      endwhile; ?>

						<?php else: ?>

							<td><em>no events today</em></td>
							<td>&nbsp;</td>

						<?php endif; ?>

						<?php wp_reset_query();
// Restore global post data stomped by the_post().
?>

					</tr>
			</tbody></table>
		</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
