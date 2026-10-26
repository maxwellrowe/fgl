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
					<?php get_template_part( 'template-parts/construction-notices-table' ); ?>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->
	
<?php get_footer(); ?>