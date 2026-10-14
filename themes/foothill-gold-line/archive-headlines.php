<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Foothill_Gold_Line
 */
get_header();
?>

<div id="content" class="headlinesPage">
    <h3><?php esc_html_e( 'The following is a selection of news and editorial pieces that chronicle both project milestones and regional developments that impact our progress.', 'foothill-gold-line' ); ?></h3>
    <h3><?php echo date('Y'); ?></h3>
    <?php
        $current_years_posts = get_posts(array(
            'numberposts' => -1,
            'post_type' => $post_type,
            'date_query' => array(
                'column' => 'post_date',
                array(
                    'after' => date("Y"),
                    'inclusive' => true
                )
            )
        ));
        foreach($current_years_posts as $post){ 
            $link = get_the_permalink($post->ID);
            if(get_field("file_link")){
                $attached_file = get_field("file_link");
                $link = $attached_file["url"];
            }
            if(get_field("article_external_link")){
                $thelink = get_field("article_external_link");
                if(strpos($thelink, "http") !== false) {
                    $link = $thelink;
                } else {
                    
                    $link = 'http://' . $thelink;
                }
            }
            ?>
            <p>
                <a href="<?php echo $link; ?>" title="<?php echo get_the_title($post->ID); ?>"><strong><?php if(get_field("toggle_date", $post->ID) === "show"){ echo get_the_date('', $post->ID) . " - "; } ?></strong><?php echo get_the_title($post->ID); ?></a> <?php if(get_field("article_teaser", $post->ID)){ echo " - "; echo strip_tags(get_field("article_teaser", $post->ID)); }?>
            </p>
    <?php         
        }
    ?>
    <br> <br>
    <h3><?php esc_html_e( 'ARCHIVE', 'foothill-gold-line' ); ?></h3>
    <?php
        $post_type = get_post_type();
        get_archive_by_date_hierachy($post_type);
    ?>


</div>

<?php

get_footer();
