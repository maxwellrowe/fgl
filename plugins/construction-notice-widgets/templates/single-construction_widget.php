<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'get_field' ) ) {
    wp_die( esc_html__( 'Construction Notice Widgets requires Advanced Custom Fields.', 'construction-notice-widgets' ) );
}

$widget_id = get_queried_object_id();
require __DIR__ . '/header-construction_widget.php'; ?>

	<div id="construction-updates" class="const-update-widget-wrapper d-lg-block">
					<div id="construction-updates-height-controller">
						
						<?php 
							$overallTheme = get_field('overall_theme');
							if($overallTheme == 'widget-dark') {
						?>
							<div class="const-update-widget-fgl mb-3">
								<a href="https://foothillgoldline.org" target="_PARENT">
									<img src="<?php echo esc_url( plugins_url( 'assets/img/FGL_linear_reverse.png', dirname( __DIR__ ) . '/construction-notice-widgets.php' ) ); ?>" alt="Foothill Gold Line" class="embed-widget-logo" />
								</a>
							</div>
						<?php } ?>
							
						<?php if($overallTheme == 'widget-light') { ?>
							<div class="const-update-widget-fgl mb-3">
								<a href="https://foothillgoldline.org" target="_PARENT">
									<img src="<?php echo esc_url( plugins_url( 'assets/img/FGL_linear.png', dirname( __DIR__ ) . '/construction-notice-widgets.php' ) ); ?>" alt="Foothill Gold Line" class="embed-widget-logo" />
								</a>
							</div>
						<?php } ?>
						
						<h2 class="mb-1"><?php the_field('widget_heading_copy'); ?></h2>
						<!-- If is "Active" (17) Construction Notice, Organize by City-->
						<?php // Output all Taxonomies names with their respective items
							$terms = get_field('widget_city', $widget_id);
                            if ($terms && !is_array($terms)) {
                                $terms = array($terms);
                            }
							if($terms) {
								foreach( $terms as $term ):
							?>  
							    <?php
                                    $term = get_term( $term );
                                    if ( ! $term || is_wp_error( $term ) ) {
                                        continue;
                                    }
                                    $termName = $term->name;
                                    $termLocationCity = '';
                                ?>
								<h3><?php echo esc_html($termName); // Print the term name ?></h3>                          
								<ul>
									<?php   
									// Get the Term's City Name to later match with the location
									$termLocation = get_field('widget_city', 'term_' . $term->term_id);
									if(is_array($termLocation) && !empty($termLocation['city'])) {
										$termLocationCity = $termLocation['city'];	
										$termLocationCity = preg_replace('/\s*/', '', $termLocationCity);
										$termLocationCity = strtolower($termLocationCity);
									}
									
									$theTaxonomy = get_term($term)->taxonomy;
									$theTermSlug = get_term($term)->slug;
									
									// Get the posts                      
									$posts = get_posts(array(
									'post_type' => 'construction_notice',
									'taxonomy' => $theTaxonomy,
									'term' => $theTermSlug,
									'meta_query' => array(
										'relation' => 'OR',
										'sticky' => array(
											'key' => 'make_this_notice_sticky',
											'value' => '1',
											'compare' => '='
										),
										'not_sticky' => array(
											'key' => 'make_this_notice_sticky',
											'value' => '0',
											'compare' => '='
										)
									),
									'orderby' => array(
										'sticky' => 'DESC',
										'date' => 'DESC',
									),                                  
									'nopaging' => true, // to show all posts in this taxonomy, could also use 'numberposts' => -1 instead
									));
									foreach($posts as $post): // begin cycle through posts of this taxonmy
									setup_postdata($post); //set up post data for use in the loop (enables the_title(), etc without specifying a post ID)
									?>
									
									
										
										<?php 
										if( has_term('active', 'status')) { // Check if Active Status
											$theTermIds = array();
                                            $constNoticeItemLocation = array('lat' => '', 'lng' => '');
											if( have_rows('location') ):
												while( have_rows('location') ) : the_row();
													$theTypeTerms = get_sub_field('construction_type');
													
													foreach( (array) $theTypeTerms as $theTypeTerm):
														// Push terms
														$type_id = $theTypeTerm instanceof WP_Term ? $theTypeTerm->term_id : absint($theTypeTerm);
                                                    if ($type_id) {
                                                        $theTermIds[] = $type_id;
                                                    }
													endforeach;
													
													// Match location and term location
													$indLocation = get_sub_field('address');
													$indLocationCity = is_array($indLocation) ? ($indLocation['city'] ?? '') : '';	
													$indLocationCity = preg_replace('/\s*/', '', $indLocationCity);
													$indLocationCity = strtolower($indLocationCity);
													
													if($termLocationCity !== '' && $indLocationCity == $termLocationCity) {
														$constNoticeItemLocation = get_sub_field('address');
													}
												endwhile;
											else :
											endif;
											$uniqueTerms = array_unique($theTermIds);
											
										?>      
											<li id="noticeId<?php the_ID(); ?>" class="noticeId<?php the_ID(); ?> <?php echo esc_attr($termLocationCity); ?>" data-lat="<?php echo esc_attr($constNoticeItemLocation['lat'] ?? ''); ?>" data-lng="<?php echo esc_attr($constNoticeItemLocation['lng'] ?? ''); ?>"><a href="https://construction.foothillgoldline.org?notice=<?php the_ID(); ?>" target="_PARENT" class="const-update-widget-link"><?php the_title(); ?><br /><span class="construction-notice-item-icon">
											
											<?php foreach( $uniqueTerms as $theTermId): ?>
												<img src="<?php the_field('construction_type_icon', 'term_' . $theTermId); ?>" alt="<?php the_title(); ?>" />
											<?php endforeach; ?>
											</span></a></li>   
										<?php } ?>
									<?php endforeach; ?>
								</ul>                                              
							<?php endforeach; ?>
						<?php } else { ?>
							<p>No cities selected.</p>
						<?php } ?>
					</div>
					<?php wp_reset_postdata(); ?>
					<a href="<?php echo esc_url( cnw_get_view_all_url() ); ?>" target="_parent" id="construction-updates-past-link" class="pb-3"><?php echo esc_html(get_field('widget_view_all_link_copy', $widget_id)); ?> <span class="fa fa-arrow-right"></span></a>
				</div>

<?php
require __DIR__ . '/footer-construction_widget.php';
