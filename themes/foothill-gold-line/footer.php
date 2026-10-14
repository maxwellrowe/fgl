<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Foothill_Gold_Line
 */
?>
    </div>
    <div id="footer">

	    <div class="footer-desktop">
		    <div class="footer-copyright">
			    <?php echo get_field('footer_middle','option'); ?>
			    <span class="footer-copyright-text">&copy;<?php echo date('Y'); ?> Metro Gold Line Foothill Extension Construction Authority | <a href="<?php bloginfo('url'); ?>/sitemap/">Sitemap</a></span>
		    </div>

		    <div class="footer-buttons">
			    <?php if( have_rows('footer_left','option') ): ?>

		        <ul id="footerLeftIconList">

			         <?php while ( have_rows('footer_left','option') ) : the_row();
                            $button_class = (string) get_sub_field('button_class');
                            $button_variant = in_array('footer-i-will-ride', preg_split('/\s+/', trim($button_class)), true) ? 'light' : 'primary';
                        ?>

                        <li><a href="<?php the_sub_field('link'); ?>" class="footer-button fgl-button fgl-button--<?php echo esc_attr($button_variant); ?> <?php echo esc_attr($button_class); ?>"><?php the_sub_field('button_text'); ?></a></li>

					 <?php endwhile; ?>

				</ul>

				<?php endif; ?>
		    </div>

		    <div class="footer-social">
			    <?php if( have_rows('footer_right','option') ): ?>

			        <ul id="footerRightIconList">

				         <?php while ( have_rows('footer_right','option') ) : the_row(); ?>

				         	<li><a href="<?php the_sub_field('link'); ?>" class="footer-button"><?php the_sub_field('button_text'); ?></a></li>

						 <?php endwhile; ?>

					</ul>

				<?php endif; ?>
		    </div>
	    </div>

	    <!-- Mobile Only Footer -->
	    <div class="footer-mobile">
		    <div class="footer-copyright">
			    <?php echo get_field('footer_middle','option'); ?>
			    <span class="footer-copyright-text">&copy;<?php echo date('Y'); ?> Metro Gold Line Foothill Extension Construction Authority | <a href="<?php bloginfo('url'); ?>/sitemap/">Sitemap</a></span>
		    </div>
	    </div>

		<?php /*<div id="translate-mobile-only">
			<!-- Language Switcher  via WP Menu -->
            <?php
	            wp_nav_menu( array(
	                'theme_location' => 'language-selector',
	                'container_class' => 'fgl-language-footer',
	                'container' => 'ul',
	                'menu_id' => 'fgl-language-selector-footer',
	                'menu_class' => 'clearfix menu'
	            ));
            ?>
		</div>*/ ?>

    </div>

</div><!-- #content -->

</div><!-- #content -->



<?php wp_footer(); ?>

<a class="mobile-arrow-up" href="#header"><img src="<?php bloginfo('template_directory'); ?>/images/arrow-up.png" /></a>

</body>
</html>
