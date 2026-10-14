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

<div id="content" class="content-area">
    <?php
    $post_type_object = get_post_type_object(get_post_type());
    ?>
    <h2 style="text-transform: capitalize"><?php echo $post_type_object->label; ?></h2>

    <?php if (get_field("article_external_link")) {
        if (!strstr(get_field("article_external_link"), "https://")) {
            $ext_url = "https://" . get_field("article_external_link");
        } else {
            $ext_url = get_field("article_external_link");
        }

        ?>
        <p>
            <a href="<?php echo $ext_url; ?>" title="<?php the_title(); ?>" target="_blank"><?php if(get_field("toggle_date") === "show"){ echo "<strong>" . get_the_date() . "</strong> - "; } ?><?php the_title(); ?></a>
            <?php if(get_field("article_teaser")){ echo " - "; echo strip_tags(get_field("article_teaser")); }?>
        </p>
    <?php }else{
        if($file = get_field("file_link")){
        ?>
        <p>
            <a href="<?php echo wp_get_attachment_url($file['ID']); ?>" title="<?php the_title(); ?>" target="_blank"><?php if(get_field("toggle_date") === "show"){ echo "<strong>" . get_the_date() . "</strong> - "; } ?><?php the_title(); ?></a>
            <?php if(get_field("article_teaser")){ echo " - "; echo strip_tags(get_field("article_teaser")); }?>
        </p>
    <?php }else{
        echo get_the_date();
        the_title("<h3>", "</h3>");
        echo get_field("article_main_body");
        ?>

    <?php
        }
    }
    ?>

</div>

<?php
get_footer();
