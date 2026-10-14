<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Search Template
 *
 * @link           http://codex.wordpress.org/Theme_Development#Search_Results_.28search.php.29
 */
?>
<?php get_header(); ?>

<div id="content">

    <?php if (have_posts()) : ?>
        <h4><?php printf(__('Search Results for: %s', 'foothill-gold-line'), '<span>' . get_search_query() . '</span>'); ?></h4>
		<ol>
        <?php while (have_posts()) : the_post(); ?>
            <li><h2 class="post-title" style="display: inline;"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'foothill-gold-line'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
	            <?php if(has_excerpt()) { ?><div style="margin-left: 20px;"><?php the_excerpt(); ?></div><?php } ?>
            </li>
        <?php endwhile; ?> 
        
		</ol>

        <?php if ($wp_query->max_num_pages > 1) : ?>
            <!--<div class="navigation">
                <div class="previous"><?php next_posts_link(__('&#8249; Older posts', 'foothill-gold-line')); ?></div>
                <div class="next"><?php previous_posts_link(__('Newer posts &#8250;', 'foothill-gold-line')); ?></div>
            </div>-->
        <?php endif; ?>

    <?php else : ?>
        <h1><?php _e("No Search Results Found", 'foothill-gold-line'); ?></h1>
        <p><?php _e('Sorry, there no results were found for <strong>"', 'foothill-gold-line'); ?> <?php the_search_query(); ?> "</strong> .</p> <hr><br>
        <?php // get_search_form(); ?>

    <?php endif; ?>  

</div><!-- #content -->

<?php get_footer(); ?>