<?php
/**
 * Template name: Sitemap Menu
 */
get_header();
?>

	<div id="content" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		
		<table cellspacing="3" cellpadding="0" border="0" id="siteMapTable">
			<tbody>
				<tr>
					<td class="siteMapCell">
						
						<?php
						    wp_nav_menu( array(
						        'menu' => 'sitemap',
						        'menu_class'     => 'sitemap',
						         ) );
						?>
						
					</td>
					<td >
						
						<form role="search" id="searchform" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label>
        <span class="screen-reader-text"><strong><?php echo _x( 'Search for Keyword:', 'label' ) ?></strong></span>
        <br>
        <input type="text" class="search-field halfWidth"
            placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
    </label>
    <input type="submit" class="search-submit"
        value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
</form>
						
					</td>
				</tr>
			</tbody>
		</table>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
