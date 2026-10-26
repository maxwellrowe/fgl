<?php
/**
 * Template name: Construction Notices
 */
 // Use in conjunction with Construction Maps plugin
get_header();
?>

<div id="content" class="content-area">
		<main id="main" class="site-main">

			<div id="past-construction-notices-wrapper">
				<div class="construction-notices-inner">
					<h1>Construction Updates</h1>
					<table id="past-construction-table">
						<thead>
							<tr>
								<th>Date</th>
								<th>Notice</th>
								<th><span class="cm-download-short">PDF</span><span class="cm-download-long">Download</span></th>
							</tr>
						</thead>
						<tbody>
							<?php
								// Get the notices
								$pastNotices = get_posts(array(
									'post_type' => 'construction_notice',
									'posts_per_page' => 9999,
									'orderby' => 'date',
									'order' => 'DESC'
								));
								
								if($pastNotices) {
									foreach ($pastNotices as $post) {
										// Loop start
										setup_postdata($post);
										// Get the Cities taxonomy terms
										$term_obj_list = get_the_terms( $post->ID, 'city' );
										$terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
										
							?>
								<tr>
									<td class="construction-city-cell"><?php the_time('n/j/Y'); ?></td>
									<td class="construction-notice-cell"><h2><a href="<?php the_field('construction_upload_pdf'); ?>" target="_blank" title="Download PDF of Notice"><?php the_title(); ?></a></h2><p><?php echo $terms_string; ?></p></td>
									<td class="construction-download-cell"><a href="<?php the_field('construction_upload_pdf'); ?>" target="_blank" title="Download PDF of Notice"><span class="cm-download-button"><span class="fa fa-download"></span></span><span class="cm-download-text"><span class="fa fa-file-pdf-o"></span> PDF</span></a></td>
								</tr>
							<?php } wp_reset_postdata(); } ?>
						</tbody>
					</table>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->
	
<?php get_footer(); ?>