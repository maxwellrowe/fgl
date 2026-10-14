<?php

get_header();
?>
<?php if(is_single(49)) { ?>
    <div id="contentRight" class="oportunity-right">
        <?php echo get_field("sub_body") ?>
    </div>
    <div id="contentLeft">
        <?php echo get_field("main_body") ?>
    </div>

<?php } else { ?>
    <div id="contentLeft">
        <?php echo get_field("main_body") ?>
    </div>
    <div id="contentRight" class="oportunity-right">
        <?php echo get_field("sub_body") ?>
    </div>
<?php } ?>
<?php
get_footer();