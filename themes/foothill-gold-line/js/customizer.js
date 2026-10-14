/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

jQuery(function ($) {
//    if ($(window).width() > 900) {
        $("#subNav ul > li").each(function (i) {
            $(this).attr("data-index", i);
        });

        $("#subNav.subNavDesktop ul > li").first().addClass("active");
        $("#subNav ul > li.active").each(function () {
            var activeEelement = $(this);
            var activeLink = $(this).children("a").attr("href");
            $("#phaseMap > a[href=" + activeLink + "]").css("opacity", 1);
            $("#subNav ul > li").hover(function () {
                var hoveredLink = $(this).children("a").attr("href");
                $("#phaseMap > a").css("opacity", 0);
                $("#phaseMap > a[href=" + hoveredLink + "]").css("opacity", 1);
            }, function () {
                $("#phaseMap > a").css("opacity", 0);
                $("#phaseMap > a[href=" + activeLink + "]").css("opacity", 1);
            });

            $("#phaseMap > a").hover(function () {
                var ahoveredLink = $(this).attr("href");
                $("a[href=" + ahoveredLink + "]").css("opacity", 1);
                $("#subNav ul > li > a[href=" + ahoveredLink + "]").parent("li").addClass("active");
            }, function () {
                $("#phaseMap > a").css("opacity", 0);
                $("#phaseMap > a[href=" + activeLink + "]").css("opacity", 1);
                $("#subNav ul > li").removeClass("active");
                activeEelement.addClass("active");
            });
        });

        $("#renderingNewLink.renderings").click(function (e) {
            e.preventDefault();
            var thisHref = $(this).attr("href"),
                rendHtml = $(thisHref).children("#leftCornerBox").html();
                console.log(rendHtml);
            $("#leftCornerBox .mediaBox").html(rendHtml);
            Metro.photoGallery($("#leftCornerBox .mediaBox"));
        });

//    }

});

/* Convert Email Addresses into MailTo Links */

jQuery(".filter-email-box div").filter(function ($) {
    var html = $(this).html();
    var emailPattern = /[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/g;

    var matched_str = $(this).html().match(emailPattern);
    if ( matched_str ) {
      var text = $(this).html();
      $.each(matched_str, function (index, value) {
          text = text.replace(value,"<a href='mailto:"+value+"'>"+value+"</a>");
      });
      $(this).html(text);
      return $(this)
    }
});

/* Smooth Scroll to Top */
jQuery(function ($) {
    $("a[href='#header']").click(function() {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      return false;
    });
});

/* Detect if page not in menu and default to Glendora */

jQuery(function ($) {
    if(!$("#nav li").hasClass("current-menu-item")) {
        $("#nav li.primary-item").addClass("current-menu-item");
    }
});

/* Homepage Move Slideshow for Mobile */
jQuery(function ($) {
    if ($(window).width() < 900) {
       $('#homeRightContent').insertBefore('#homeTabs');
    }
});

/* Construction Authority Gallery Above Content */
jQuery(function ($) {
    if ($(window).width() < 900) {
       $('.mobile-gallery').insertBefore('#contentLeft');
    }
});

/* Move the Arrow Up on Mobile outside of Scotch Panels */
jQuery(window).load(function() {
    if (jQuery(window).width() < 900) {
       jQuery('.mobile-arrow-up').insertBefore('.scotch-panel-wrapper');

       $(window).scroll(function() {
            if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
                $('.mobile-arrow-up').fadeIn(200);    // Fade in the arrow
            } else {
                $('.mobile-arrow-up').fadeOut(200);   // Else fade out the arrow
            }
        });
    }
});

jQuery(window).load(function() {
    if (jQuery(window).width() > 900) {
        jQuery('#wpadminbar').insertBefore('.scotch-panel-wrapper');
    }
});

/* Mobile on click of video, show the video div */
jQuery(function ($) {
    $("#videosListing a").click(function() {
        $("#videoBox").show();
    });
});

// Language Selector
jQuery(document).ready(function(){
    jQuery('#fgl-language-selector .fgl-translate-button a[href="#"]').click(function(event) {
        event.preventDefault();
        jQuery('#fgl-language-selector .sub-menu').slideToggle('fast');
    });
    jQuery('li.mobile-menu-translate a').click(function(event) {
        event.preventDefault();
        $(this).parent('li').find('ul.sub-menu').slideToggle();
    });
});


// Toggler
jQuery(document).ready(function(){
    jQuery('.toggle-header').on('click', function() {
        console.log('clicked');
        jQuery(this).next('.toggle-content').toggleClass('toggle-open'),
        jQuery(this).toggleClass('toggle-open');
    });
});