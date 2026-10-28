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
    <div id="phasePageMap">
        <?php the_title('<h2 class="fgl-template-content-title">', "</h2>"); ?>
        <div id="phaseMap" class="phaseMapArea" style="background-image: url('<?php if ($image = get_field('city_stations_image')) echo $image['url']; ?>')">
            <?php
            // check if the repeater field has rows of data
            if (have_rows('station_info')):

                // loop through the rows of data
                while (have_rows('station_info')) : the_row();
                    $img_src = get_sub_field('station_image');
                    ?>
                    <a href="<?php the_sub_field('station_link'); ?>" class="phasesMapRollover" style="line-height: 0px; height: auto; position: absolute; top: <?php the_sub_field('position_top'); ?>; left: <?php the_sub_field('position_left'); ?>;">
                        <?php echo wp_get_attachment_image($img_src['ID']); ?>
                    </a>
                    <?php
                endwhile;

            else :

            // no rows found

            endif;
            ?>
        </div>
        <div id="subNav" class="constphases-mobile-nav">
	        <?php
            // check if the repeater field has rows of data
            if (have_rows('subnav')):
                ?>
                <ul>
                    <?php
                    // loop through the rows of data
                    while (have_rows('subnav')) : the_row();
//                                $is_active = get_sub_field('is_active');
                        ?>
                    <li><a href="<?php the_sub_field('subnav_link'); ?>" title="<?php the_sub_field('subnav_title'); ?>"><?php the_sub_field('subnav_title'); ?></a></li>
                        <?php
                    endwhile;
                    ?>
                </ul>
                <?php
            else :

            // no rows found

            endif;
            ?>
	        <table>
	            <tbody><tr>
	                    <td style="width: 100%">


	                    </td>
	                </tr>
	            </tbody></table>
	    </div>
    </div>
    <?php if(get_field('phase_tab2_title')) { ?>
    	<div id="phaseTabs" class="tabs ui-tabs ui-widget ui-widget-content ui-corner-all">
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
    	<div id="contentRight" class="contentRightConstPhase">
	    	<?php echo get_field("overview"); ?>
		</div>
    <?php } ?>

    <div id="subNav" class="subNavDesktop">
        <?php
                        // check if the repeater field has rows of data
                        if (have_rows('subnav')):
                            ?>
                            <ul>
                                <?php
                                // loop through the rows of data
                                while (have_rows('subnav')) : the_row();
//                                $is_active = get_sub_field('is_active');
                                    ?>
                                <li><a href="<?php the_sub_field('subnav_link'); ?>" title="<?php the_sub_field('subnav_title'); ?>"><?php the_sub_field('subnav_title'); ?></a></li>
                                    <?php
                                endwhile;
                                ?>
                            </ul>
                            <?php
                        else :

                        // no rows found

                        endif;
                        ?>
        <table>
            <tbody><tr>
                    <td style="width: 100%">


                    </td>
                </tr>
            </tbody></table>
    </div>

<?php

get_footer();
