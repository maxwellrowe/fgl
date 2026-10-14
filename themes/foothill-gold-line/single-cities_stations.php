<?php
/**
 * The template for displaying single skins
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Foothill_Gold_Line
 */
get_header();
?>

<style>
    #station_art_gallery img {
        width: 100%;
        height: auto;
        max-width: 100%;
    }
</style>
<div class="relative-block">
	<div id="leftCornerBox" style="overflow: hidden;">
		<span id="prevBtn" style="display: block;"><a href="#prev"></a></span>
		<span id="nextBtn" style="display: block;"><a href="#next"></a></span>
		<div class="mediaBox">
		    <?php
		    if ($gallery_imgs = get_field("station_photo_gallery")) {
		        foreach ($gallery_imgs as $gallery_img) {
		            echo wp_get_attachment_image($gallery_img['ID'], "slider_image");
		        }
		    }
		    ?>
		</div>
	</div>
</div>
<div id="interactiveMap">
    <a href="#closeMap" class="closeMap" title="Close Map"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/converted-images/btn-map-close.png" width="29" height="23" alt="Close Interactive Map"><div class="close-map-text">Click to Close Map</div></a>
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="945" height="540" id="flashMap" align="middle">
        <param name="allowScriptAccess" value="always">
        <param name="allowFullScreen" value="false">
        <param name="wmode" value="opaque">
        <param name="movie" value="<?php echo get_field("interactive_map"); ?>"><param name="quality" value="high"><param name="bgcolor" value="#ffffff">
        <embed src="<?php echo get_field("interactive_map"); ?>" quality="high" bgcolor="#ffffff" width="945" height="540" name="v025" wmode="opaque" align="middle" allowscriptaccess="always" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="https://www.adobe.com/go/getflashplayer">
    </object>
</div>
<div id="siteplan-container">
    <a href="#closePlan" class="closePlan" title="Close Plan"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/converted-images/btn-map-close.png" width="29" height="23" alt="Close Site Plan"><div class="close-map-text">Click to Close Site Plan</div></a>
    <?php
    $image = get_field("site_plan_min");
    echo wp_get_attachment_image($image['ID'], 'large');
    ?>

    <p class="centered site-plan-dl">
        <?php if ($attach_file = get_field("site_plan_full_size")) { ?>
            <a download="" href="<?php echo wp_get_attachment_url($attach_file['ID']) ?>"><strong>Full-Size Site Plan</strong></a>
        <?php } ?>
        <span style="color: #ccc; font-size: 12px;">(click to download as PDF)</span>
    </p>
</div>
<?php if (get_field("rendering_full_size") && get_field("rendering_min")) { ?>
    <div id="rendering-container">
        <a href="#closeRendering" class="closeRendering" title="Close Rendering"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/converted-images/btn-map-close.png" width="29" height="23" alt="Close Site Rendering">
            <div class="close-map-text">Click to Close Site Rendering</div></a>
        <?php
        $image = get_field("rendering_min");
        echo wp_get_attachment_image($image['ID'], 'large');
        ?>
        <p class="centered rendering-dl">
            <?php if ($attach_file = get_field("rendering_full_size")) { ?>
                <a download="" href="<?php echo wp_get_attachment_url($attach_file['ID']) ?>"><strong>Full-Size Rendering</strong></a>
            <?php } ?>
            <span style="color: #ccc; font-size: 12px;">(click to download as PDF)</span>
        </p>
    </div>
<?php } ?>
<div id="galleryStash" class="hide">
    <?php if ($gallery_imgs = get_field("station_photo_gallery")) { ?>
        <div id="photos">
            <?php
            foreach ($gallery_imgs as $gallery_img) {
                echo wp_get_attachment_image($gallery_img['ID'], 'slider_image');
            }
            ?>

        </div>
    <?php } ?>
    <?php if ($rend_gallery_imgs = get_field("renderings_photo_gallery")) { ?>
        <div id="renderings">
            <div id="leftCornerBox" style="overflow: hidden;">

	                <?php
	                foreach ($rend_gallery_imgs as $rend_gallery_img) {
	                    echo wp_get_attachment_image($rend_gallery_img['ID'], 'slider_image');
	                }
	                ?>

            </div>
        </div>
    <?php } ?>
</div>
<div id="cityTabs" class="tabs ui-tabs ui-widget ui-widget-content ui-corner-all phaseTabsDualContent citytabs">

    <ul class="tabLabels ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
        <?php if (get_field('tab1_title')) { ?><li class="tabLabel1 ui-state-default ui-corner-top"><a href="#tabs-1"><?php echo get_field('tab1_title'); ?></a></li> <?php } ?>
        <?php if (get_field('tab2_title')) { ?><li class="tabLabel2 ui-state-default ui-corner-top"><a href="#tabs-2"><?php echo get_field('tab2_title'); ?></a></li> <?php } ?>
        <?php if (get_field('tab3_title')) { ?><li class="tabLabel3 ui-state-default ui-corner-top"><a href="#tabs-3"><?php echo get_field('tab3_title'); ?></a></li> <?php } ?>
    </ul>
    <?php if (get_field('about_station')) { ?> <div class="cityTabsPanel aboutPanel ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="tabs-1">
            <p id="galleryLinks">
                <?php
                $link_button = "";
                if (get_field("renderings_photo_gallery")) {
                    $link_button = '<a href="#renderings" id="renderingNewLink" title="" class="renderings renderings">renderings</a>&nbsp;&nbsp;&nbsp;';
                }
                if (get_field("rendering_full_size") && get_field("rendering_min")) {
                    $link_button = '<a href="#rendering" id="renderingNewLink" title="" class="rendering">renderings</a>&nbsp;&nbsp;&nbsp; ';
                }
                echo $link_button;
                ?>
                <?php if (get_field("site_plan_full_size") && get_field("site_plan_min")) { ?><a href="#plan" id="sitePlanNewLink" title="" class="plan">site plan</a>&nbsp;&nbsp;&nbsp;<?php } ?>
                <?php if (get_field("station_photo_gallery")) { ?><a href="#photos" title="" id="photosLink" class="gallery">photos</a>&nbsp;&nbsp;&nbsp;<?php } ?>
                <?php if (get_field("interactive_map")) { ?><a href="#interactiveMap" id="interactiveMapLink" title="" class="map">interactive map</a>&nbsp;&nbsp;&nbsp;<?php } ?>
            </p>
            <?php echo get_field('about_station'); ?></div> <?php } ?>
    <?php if (get_field('station_art')) { ?>
        <div class="cityTabsPanel artPanel ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="tabs-2">
            <?php if (get_field('station_art_gallery')) { ?>
                <div id="station_art_gallery" style="overflow: hidden; margin-bottom: 12px; position:relative;">
                    <span id="prevBtn" style="display: block;"><a id="artStationPrev" href="#prev"></a></span>
                    <span id="nextBtn" style="display: block; left: auto; right: 10px;"><a id="artStationNext" href="#next"></a></span>
                    <div class="stationArtMediaBox cycle-slideshow" data-cycle-timeout="0" data-cycle-prev="#artStationPrev" data-cycle-next="#artStationNext" data-cycle-fx="scrollHorz">
                        <?php
                        if ($gallery_imgs = get_field("station_art_gallery")) {
                            foreach ($gallery_imgs as $gallery_img) {
                                echo wp_get_attachment_image($gallery_img['ID'], "full");
                            }
                        }
                        ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
            <?php } ?>
            <?php echo get_field('station_art'); ?>
        </div>
    <?php } ?>
    <?php if (get_field('future_plans')) { ?> <div class="cityTabsPanel artPanel ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="tabs-3"><?php echo get_field('future_plans'); ?></div> <?php } ?>
</div>
<div class="halfBtmContent citybottomhalf">
    <?php echo get_field('bottom_content'); ?>
</div>
<?php wp_reset_query(); ?>

    <div id="subNav">
        <ul id="nav-sub">

	        <?php if(in_category('14')) { ?>

	        	<li>
	        		<a href="<?php bloginfo ('url'); ?>/construction_phases/los_angeles_to_pasadena/">BACK TO: Los Angeles to Pasadena</a>
	        	</li>

	        <?php } elseif(in_category('15')) { ?>

	        	<li>
	        		<a href="<?php bloginfo ('url'); ?>/construction_phases/pasadena_to_azusa/">BACK TO: Pasadena to Azusa</a>
	        	</li>

	        <?php } elseif(in_category('16')) { ?>

	        	<?php
				$rel_articles = get_field('related_articles');
				if ($rel_articles):
				    ?>

		        	<?php $current_id = $post->ID; ?>
		            <?php foreach ($rel_articles as $post): // variable must be called $post (IMPORTANT) ?>
		                <?php setup_postdata($post); ?>
		                <?php $current_class = $post->ID ?>
		                <li <?php if($current_class == $current_id) { ?>class="active"<?php } ?>>
		                	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		                </li>
		            <?php endforeach; ?>

		        <?php wp_reset_postdata(); ?>
				<?php endif; ?>

	        <?php } ?>
        </ul>
        <table>
            <tbody><tr>
                    <td width="100%">

                    </td>
                </tr>
            </tbody></table>
    </div>

<?php
get_footer();
