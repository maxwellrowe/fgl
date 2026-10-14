<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Foothill_Gold_Line
 */
get_header();
?>


<?php do_action('mec_before_main_content'); ?>
<div id="primary">
<section id="<?php echo apply_filters('mec_single_page_html_id', 'main-content'); ?>" class="<?php echo apply_filters('mec_single_page_html_class', ''); ?>">
    <?php while (have_posts()): the_post(); ?>

<?php echo get_post_meta($post->ID, 'mec_start_date', true); ?>

<?php echo get_post_meta($post->ID, 'location', true); ?>

<?php $terms = get_terms("mec_category");
 $count = count($terms);
 if ( $count > 0 ){
     echo "<ul>";
     foreach ( $terms as $term ) {
       echo "<li>" . $term->name . "</li>";

     }
     echo "</ul>";
 } ?>
 
<?php $terms = get_the_terms($post->ID, 'mec_category');
$count = count($terms);
     if ( $count > 0 ){
          foreach ( $terms as $term ) {
               echo $term->name;
	}
} ?>

<?php $location = isset($post->ID->data->locations[$post->ID->data->meta['mec_location_id']]) ? $post->ID->data->locations[$post->ID->data->meta['mec_location_id']]['address'] : ''; ?>
<?php echo $location ?>

<?php $term_list = wp_get_post_terms($post->ID, 'mec_category', array("fields" => "names"));
print_r($term_list); ?>

        <?php $MEC = MEC::instance();
        echo $MEC->single(); ?>

    <?php endwhile; // end of the loop. ?>
    
</section>



<!--Attached Files-->
<?php
    if (have_rows('attached_files')):
    ?>
    <article class="">
        <div class="">
            <?php
            // loop through the rows of data
            while (have_rows('attached_files')) : the_row();
            $file = get_sub_field('event_file');
            ?>
            &nbsp; &nbsp; &nbsp; &nbsp;<a href="<?php echo $file["url"] ?>"><? echo $file['title']; ?></a><br><br>
            <?php
            endwhile;
            ?>
        </div>
        <hr>
    </article>
        <?php
    endif;
    ?>

<?php do_action('mec_after_main_content'); ?>
</div>
<?php
get_footer();
