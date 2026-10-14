<?php
get_header();
?>
<div id="leftCornerBox" style="overflow: hidden;">
	<span id="prevBtn" style="display: block;"><a href="#prev"></a></span>
	<span id="nextBtn" style="display: block;"><a href="#next"></a></span>
	<div class="mediaBox">
	    <?php
	    if ($gallery_imgs = get_field("photo_gallery")) {
	        foreach ($gallery_imgs as $gallery_img) {
	            echo wp_get_attachment_image($gallery_img['ID'], "large");
	        }
	    }
	    ?>
	<!--/media-box--></div>
</div>

<?php if(get_field('phase_tab1_title')) { ?>

	<div id="phaseTabs" class="tabs ui-tabs ui-widget ui-widget-content ui-corner-all phaseTabsDualContent">
        <ul class="tabLabels ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
            <?php if (get_field("phase_tab1_title")) { ?><li class="tabLabel1 ui-state-default ui-corner-top"><a href="#tabs-1"><?php echo get_field("phase_tab1_title"); ?></a></li><?php } ?>
            <?php if (get_field("phase_tab2_title")) { ?><li class="tabLabel2 ui-state-default ui-corner-top"><a href="#tabs-2"><?php echo get_field("phase_tab2_title"); ?></a></li><?php } ?>
            <?php if (get_field("phase_tab3_title")) { ?><li class="tabLabel3 ui-state-default ui-corner-top"><a href="#tabs-3"><?php echo get_field("phase_tab3_title"); ?></a></li><?php } ?>
        </ul>
        <?php if (get_field("overview")) { ?><div class="phaseTabsPanel ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-1"><?php echo get_field("overview"); ?></div><?php } ?>
        <?php if (get_field("construction_or_planning_studies")) { ?><div class="phaseTabsPanel ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="tabs-2"><?php echo get_field("construction_or_planning_studies"); ?></div><?php } ?>
        <?php if (get_field("phase_events")) { ?><div class="phaseTabsPanel ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="tabs-3"><?php echo get_field("phase_events"); ?></div><?php } ?>
    </div>

<?php } else { ?>

	<div id="contentRight">
	    <?php echo get_field("main_body"); ?>
	</div>

<?php } ?>

<div class="halfBtmContent">
    <?php echo get_field("sub_body"); ?>
</div>
<?php

get_footer();
