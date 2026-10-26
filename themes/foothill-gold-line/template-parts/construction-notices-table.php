<?php
/** Shared construction notices table. */
$homepage_table = ! empty( $args['homepage'] );
$notice_limit = isset( $args['limit'] ) ? (int) $args['limit'] : 9999;
?>
<table id="past-construction-table" data-homepage="<?php echo $homepage_table ? 'true' : 'false'; ?>">
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
								$pastNotices = isset( $args['notices'] ) ? $args['notices'] : get_posts( array(
                                    'post_type' => 'construction_notice',
                                    'posts_per_page' => $notice_limit,
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                ) );

                                if($pastNotices) {
									foreach ($pastNotices as $post) {
										// Loop start
										setup_postdata($post);
										// Get the Cities taxonomy terms
										$term_obj_list = get_the_terms( $post->ID, 'city' );
										$terms_string = $term_obj_list && ! is_wp_error( $term_obj_list ) ? join(', ', wp_list_pluck($term_obj_list, 'name')) : '';
                                        $pdf = get_field( 'construction_upload_pdf', $post->ID );
                                        if ( is_array( $pdf ) ) {
                                            $pdf = $pdf['url'] ?? ( $pdf['ID'] ?? 0 );
                                        }
                                        if ( is_numeric( $pdf ) ) {
                                            $pdf = wp_get_attachment_url( (int) $pdf );
                                        }
                                        $pdf_url = is_string( $pdf ) ? esc_url( $pdf, array( 'https', 'http' ) ) : '';
										
							?>
								<tr>
									<td class="construction-city-cell"><?php the_time('n/j/Y'); ?></td>
									<td class="construction-notice-cell"><?php echo $homepage_table ? '<h3>' : '<h2>'; ?><a<?php if ( $pdf_url ) : ?> href="<?php echo $pdf_url; ?>" target="_blank" rel="noopener noreferrer" title="Download PDF of Notice"<?php endif; ?>><?php the_title(); ?></a><?php echo $homepage_table ? '</h3>' : '</h2>'; ?><p><?php echo esc_html( $terms_string ); ?></p></td>
									<td class="construction-download-cell"><?php if ( $pdf_url ) : ?><a href="<?php echo $pdf_url; ?>" target="_blank" rel="noopener noreferrer" title="Download PDF of Notice"><span class="cm-download-button"><span class="fa fa-download"></span></span><span class="cm-download-text"><span class="fa fa-file-pdf-o"></span> PDF</span></a><?php else : ?><span aria-label="No PDF available">—</span><?php endif; ?></td>
								</tr>
							<?php } wp_reset_postdata(); } ?>
						</tbody>
					</table>
