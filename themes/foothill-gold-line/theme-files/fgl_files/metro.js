/**
 * Main script for Metro GoldLine.
 * www.metrogoldline.org
 * Copyright © 2011 Metro GoldLine. All rights reserved.
 */
$('#click').click(function()
{   
    $("#panel").toggle();     
});

$('#newsletterSignupBox').click(function() {
    $('.closeEnewsBtn').dialog('open');

});

var Metro = (function($, undefined) {
  return {
    fire: function() {
      // this just calls every method in Metro.init
      for (var i in Metro.init) {
        Metro.init[i]();
      }
    },
    init: {
		// Initiate Tabs
		initTabs: function() {
			// HOME
			var $homeTabs = $('#homeTabs');
			if ($homeTabs.length) Metro.tabs( $homeTabs );

			// CITY
			var $i210 = $('#nav-cities-stations-gold-line-bridge.here');

			var $cityTabs = $('#cityTabs');

			// If on the i-210 Page
			if($i210.length)
			{
				// Default select 2nd tab
				if ($cityTabs.length) $cityTabs.tabs( { selected: 0 } );
			}
			else
			{
				// Default select 1st tab
				if ($cityTabs.length) Metro.tabs( $cityTabs );
			}

			// PHASES

			var $phase2A = $('#nav-construction-phases-pasadena-to-azusa.here');
			var $phase2B = $('#nav-construction-phases-azusa-to-montclair.here');

			var $phaseTabs = $('#phaseTabs');

			// If on the Construction Phase 2A
			if($phase2A.length)
			{
				// Default select 2nd tab
				if ($phaseTabs.length) $phaseTabs.tabs( { selected: 0 } );
			}
			else if($phase2B.length) {
				// Default select 1st tab
				if ($phaseTabs.length) $phaseTabs.tabs( { selected: 0 } );
			}
			else
			{
				// Default select 1st tab
				if ($phaseTabs.length) Metro.tabs( $phaseTabs );
			}
		},
		// Initiate Nav
		initNav: function() {

			var $nav = $('#nav .here, #nav .parent-here, .homePage');
			if (! $nav.length) Metro.nav();
		},
		// Initiate Home Page Phase Map
		//initHomePhaseMap: function() {

			//var $homePhaseMap = $('#homePhaseMap');
			//if ($homePhaseMap.length) Metro.homePhaseMap( $homePhaseMap );
		//},
		// Initiate Phase 1 Map
		initPhase1Map: function() {

			var $phase1Map = $('#phase1Map');
			if ($phase1Map.length) Metro.phase1Map( $phase1Map );
		},
		// Initiate Phase 2 Map
		initPhase2Map: function() {

			var $phase2Map = $('#phase2Map');
			if ($phase2Map.length) Metro.phase2Map( $phase2Map );
		},
		// Initiate Phase 3 Map
		initPhase3Map: function() {

			var $phase3Map = $('#phase3Map');
			if ($phase3Map.length) Metro.phase3Map( $phase3Map );
		},
		// Initiate Phase 4 Map
		initPhase4Map: function() {

			var $phase4Map = $('#phase4Map');
			if ($phase4Map.length) Metro.phase4Map( $phase4Map );
		},
		// Initiate Phase Maps
		initPhaseMaps: function() {

			var $phaseMap = $('#phasePageMap');
			if ($phaseMap.length) Metro.phaseMaps( $phaseMap );
		},
		// Initiate Photo Gallery
		initPhotoGallery: function() {

			var $photoGallery = $('.mediaBox');
			if($photoGallery.length) Metro.photoGallery( $photoGallery );
		},
		// For news/videos page
		initVideos: function() {
			var $video = $('#videoArchive');
			if ( $video.length ) Metro.videos.init( $video );
		},
		// Initiate Home Page Popup
		initPopup: function() {

			var $homePopup = $('#homePopup');
			if($homePopup.length) Metro.homePopup( $homePopup );
		},
		// For home videos
		homeVideos: function() {
			var $video = $('#videosListing');
			if ( $video.length ) Metro.videos.homeVideos( $video );
		},
		// city/stations page events
		cityStations: function() {
			var $cityTabs = $('#cityTabs');
			if ( $cityTabs.length ) Metro.cityStations( $cityTabs ); // this should later implement gallerySwitch
		},
		// gallery switch universal
		gallerySwitch: function() {
			var $gallery = $('.galleryswitch');
			if ( $gallery.length ) Metro.gallerySwitch( $gallery );
		},
		// calendar actions
		calendar: function() {
			var $cal = $('#calendarTable');
			if ( $cal.length ) Metro.cal.init( $cal );
		},
		// accordions
		accordion: function() {
			var $acc = $('.accordion');
			if ( $acc.length ) Metro.accordion( $acc );
		},
		// make shift table accordion
		taccordion: function() {
			var $tacc = $('.proposalTable');
			if ( $tacc.length ) Metro.taccordion( $tacc );
		},
		// make shift table accordion
		taccordion2: function() {
			var $tacc2 = $('.proposalTable2');
			if ( $tacc2.length ) Metro.taccordion2( $tacc2 );
		},
		iefixes: function() {
			if (Client.nav == 'ie' && Client.v <= 7 && $('.homePage').length == 0) Metro.fixIE();
		},
		initNewsletterSignup: function(){


			var $newsSignup = $('#newsletterSignupBox');

			if ($newsSignup.length) {

				if ( Modernizr.localstorage )  {
					//console.log("localStorage.newsletterSignup: " + localStorage.newsletterSignup);
						if(localStorage.newsletterSignup === null || localStorage.newsletterSignup !== "no")
						{
							//console.log("initNewsletterSignup1");
							$newsSignup.show();
							Metro.homeNewsletterSignupBox( $newsSignup );
						}
						else
						{
							//console.log("initNewsletterSignup2");
							$newsSignup.hide();
						}
				}
				else
				{
					$newsSignup.show();
					Metro.homeNewsletterSignupBox( $newsSignup );
				}
			}
		}
    },
   homeNewsletterSignupBox: function( $box ) {
    var $closeBtn = $box.find('.closeEnewsBtn'),
    		bounceEffect,
    		refreshIntervalId;

    	bounceEffect = function() {

			$box.effect("shake");

		};

		refreshIntervalId = setInterval(bounceEffect, 9000);

		$box.on('click', '.closeEnewsBtn', function (e) {
$newsSignup.hide();
    	  		$overlay.hide();
    	  		$overlay2.hide();
			$popupWindow.hide();
    	$box.hide();
			$newsSignup();

    	});
   },
	
    tabs: function($tabs) {

      $tabs.tabs({ selected: 0 });
    },
	nav: function() {
		$('#nav-construction-phases').addClass('parent-here');
    },
	accordion: function($acc) {
		if ( $acc.find('.iaccordion').length ) Metro.accordion( $acc.find('.iaccordion') );

		$acc.accordion({
			collapsible: true,
			autoHeight: false,
			active: false
		});
	},
	taccordion: function($tacc) {
		var $link = $tacc.find('.proposalArrowLink');

		$link.click(function(e) {
			var $this = $(this),
				$table = $this.parents('table'),
				$contents = $table.find('.proposalFilesArea'),
				$icon = $this.children('img'),
				iconsrc = $icon.attr('src');

			e.preventDefault();
			if ($contents.is(':hidden')) {
				$contents.show();
				$icon.attr('src', iconsrc.replace('off.gif', 'on.gif'));
			} else {
				$contents.hide();
				$icon.attr('src', iconsrc.replace('on.gif', 'off.gif'));
			}
		});
	},
	taccordion2: function($tacc2) {
		var $link2 = $tacc2.find('.proposalCatLink');

		$link2.click(function(e) {
			var $this = $(this),
				$table = $this.parents('table'),
				$contents = $table.find('.proposalCatArea'),
				$icon = $this.children('img'),
				iconsrc = $icon.attr('src');

			e.preventDefault();
			if ($contents.is(':visible')) {
				$contents.hide();
				$icon.attr('src', iconsrc.replace('on.gif', 'off.gif'));
			} else {
				$contents.show();
				$icon.attr('src', iconsrc.replace('off.gif', 'on.gif'));
			}
		});
	},
	photoGallery: function($photoGallery) {
		// hide nav by default
		$('#prevBtn, #nextBtn').hide();

		// make sure there's something to show
		if ( $photoGallery.children().length <= 1) return;

		// make sure the nav is shown
		$('#prevBtn, #nextBtn').show();

		$photoGallery
			.cycle({
				fx: 'scrollHorz',
				easing: 'easeOutExpo',
				timeout: 4000,
				next: '#nextBtn',
				prev: '#prevBtn'
			})
			.cycle('pause');
	},
	homePopup: function($popupWindow) {

    	var $closePopup = $('#closePopup')
    	  , $enterWebsiteBtn = $('#popupEnterWebsite')
    	  , $overlay = $('#overlay')

    	  , $overlay2 = $('#overlay2')
    	  , $signupUpdatesBtn = $('#signupUpdatesBtn')
    	  , closePopup = function () {
    	  		$overlay.hide()

    	  		$overlay2.hide()
				$popupWindow.hide()

				if(typeof(Storage) !== "undefined") {
					localStorage.setCacheItem('showPop', 'false', { days: 1 })
				}
    	  	}

		if(typeof(Storage) !== "undefined")
		{
			// remove old variable
			localStorage.removeItem('show')

			if(localStorage.getItem('showPop') === null) {
				localStorage.setItem('showPop', 'true')
			}

			if (localStorage.getItem('showPop') === 'true')
			{
				$overlay.css('display', 'block')
				$overlay2.css('display', 'block')
				$popupWindow.css('display', 'block')
				$overlay.show()
				$overlay2.show()
				$popupWindow.show()
			}
		}

    	$closePopup.click(function(e) {
			closePopup()
		})

		$enterWebsiteBtn.click(function(e) {
			closePopup()
		})

		$overlay.click(function(e) {
			closePopup()
		})
		
			$overlay2.click(function(e) {
			closePopup()
		})

		$signupUpdatesBtn.click(function(e) {
			e.stopPropagation()
			closePopup()
			window.location.href = "https://foothillgoldline.org/contact_us/sign-up-for-e-news/"
		})

		$popupWindow.click(function(e) {
			e.stopPropagation()
		})
    },
	gallerySwitch: function($gallery) {
		var $links = $gallery.find('a.gallery');

		if (! $links.length) return;

		$links.click(function(e) {
			var $this = $(this),
				node = $this.attr('href'),
				$gallerySet = $(node),
				$media = $('.mediaBox');

			e.preventDefault();

			$media
				.cycle('destroy')
				.html( $gallerySet.html() );

			// hide nav by default
			$('#prevBtn, #nextBtn').hide();

			// only for galleries
			if ($this.is('.gallery')) Metro.photoGallery( $media );
		});
	},
	cityStations: function($cityTabs) {
		// take care of gallery and video links
		$('#galleryLinks a.gallery, #galleryLinks a.video').click(function(e) {
			var $this = $(this);
				node = $this.attr('href'),
				$gallerySet = $(node),
				$media = $('#leftCornerBox .mediaBox');

			e.preventDefault();

			$media
				.cycle('destroy')
				.html( $gallerySet.html() );

			// hide nav by default
			$('#prevBtn, #nextBtn').hide();

			// only for galleries
			if ($this.is('.gallery')) Metro.photoGallery( $media );
		});


		if(window.location.toString().indexOf("#map") > -1)
		{
			$('#interactiveMap').css('display', 'block');
		}

    if(window.location.toString().indexOf("#rendering") > -1)
    {
      $('#rendering-container').css('display', 'block');
    }

		if(window.location.toString().indexOf("#plan") > -1)
		{
			$('#siteplan-container').css('display', 'block');
		}

		$('a.map ').click(function(e) {
			$('#interactiveMap').css('display', 'block');

			e.preventDefault();

		});

		$('a.plan ').click(function(e) {
			$('#siteplan-container').css('display', 'block');

			e.preventDefault();

		});

    $('a.rendering').click(function(e) {
      $('#rendering-container').css('display', 'block');

      e.preventDefault();

    });

		$('a.closeMap ').click(function(e) {
				$('#interactiveMap').css('display', 'none');

			e.preventDefault();

			$media
				.cycle('destroy')
				.html( $gallerySet.html() );

		});

		$('a.closePlan ').click(function(e) {
				$('#siteplan-container').css('display', 'none');

			e.preventDefault();

		});

    $('a.closeRendering ').click(function(e) {
        $('#rendering-container').css('display', 'none');

      e.preventDefault();

    });

		$cityTabs.find('.tabLabels a').click(function() {
			var $this = $(this),
				$tabLi = $this.parent(),
				$gallery,
				$media = $('#leftCornerBox .mediaBox');

			// don't do anything if the tab is already selected
			if ( ! $tabLi.is('.ui-state-focus') ) return;

			// begin tab-2 with stationart; begin tab-1 with photos
			if ( $tabLi.is('.tabLabel2') ) {
				$gallery = $('#stationart');
			} else if ( $tabLi.is('.tabLabel1') ) {
				$gallery = $('#photos');
			}

			// catch: if there isn't a gallery then die
			if ( $gallery.length < 1) return;

			$media
				.cycle('destroy')
				.html( $gallery.html() );

			Metro.photoGallery( $media );
		});
	},
	phaseMaps: function($phaseMap) {

		var $subNavButtons = $(".subNavButtons");
		var $activeBtn = $('#subNav .active');
		var $activeStations = $('.phaseMapArea .activeMapItem');

		// Highlight stations on hover except when station is already active
		$('.phasesMapRollover').each(function() {
			var $this = $(this);

			if (! $this.is('.activeMapItem')) {
				$this.hover(function() {
					$this.toggleClass('activeMapItem');
				});
			}
		});

		// De-Highlight other city nav buttons and stations when hovering over this nav button
		$subNavButtons.hover(
		 	function () {
					// Ignore if already active
					if(!$(this).is(".active"))
					{
						$activeBtn.addClass('non-active'); $activeBtn.removeClass('active');
						$activeStations.addClass('nonactiveMapItem'); $activeStations.removeClass('activeMapItem');
					}
		 	},
			function () {
					// Ignore if already active
					if(!$(this).is(".active"))
					{
						$activeBtn.addClass('active'); $activeBtn.removeClass('non-active');
						$activeStations.addClass('activeMapItem'); $activeStations.removeClass('nonactiveMapItem');
					}
			}
		);
    },
	phase1Map: function($phase1Map) {

		/* Phases Sub Navigation Button Variables */
		var $subNavBtnLosAngeles = $("#subNavBtnLosAngeles");
		var $subNavBtnPasadena = $("#subNavBtnPasadena");
		var $subNavBtnSouthPasadena = $("#subNavBtnSouthPasadena");

		/* Phases Station Variables */
		var $losAngelesStation = $(".losAngelesStation");
		var $pasadenaStation = $(".pasadenaStation");
		var $southPasadenaStation = $(".southPasadenaStation");

		// If Los Angeles Area is not already active
		if(!$subNavBtnLosAngeles.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$losAngelesStation.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnLosAngeles.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtnLosAngeles.hover(
			 	function () { $losAngelesStation.toggleClass('activeMapItem') }
			);
		}
		// If Pasadena Area is not already active
		if(!$subNavBtnPasadena.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$pasadenaStation.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnPasadena.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtnPasadena.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$pasadenaStation.toggleClass('activeMapItem');
				}
			);

		}
		// If South Pasadena Area is not already active
		if(!$subNavBtnSouthPasadena.is(".active"))
		{
			$southPasadenaStation.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnSouthPasadena.toggleClass('active');
				}
			);

			$subNavBtnSouthPasadena.hover(
			    function () { $southPasadenaStation.toggleClass('activeMapItem') }
			);
		}

		// Highlight all stations in city area when city is active
		if($subNavBtnLosAngeles.is(".active"))
		{
			$losAngelesStation.addClass('activeMapItem');
		}
		if($subNavBtnPasadena.is(".active"))
		{
			$pasadenaStation.addClass('activeMapItem');
		}
		if($subNavBtnSouthPasadena.is("active"))
		{
			$southPasadenaStation.addClass('.activeMapItem');
		}

		// default activeMapItem
		var $activeDefaults = $('.activeMapItem');
    },
	phase2Map: function($phase2Map) {

		/* Phases Sub Navigation Button Variables */
		/*var $subNavBtnArray = new Array($("#subNavBtn1"),$("#subNavBtn2"),$("#subNavBtn3"),$("#subNavBtn4"),$("#subNavBtn5"),$("#subNavBtn6"),$("#subNavBtn7"))*/

		/* Phases Sub Navigation Button Variables */
		var $subNavBtnI210Bridge = $("#subNavBtn1");
		var $subNavBtnArcadia = $("#subNavBtn2");
		var $subNavBtnMonrovia = $("#subNavBtn3");
				var $subNavBtnCampus = $("#subNavBtn3b");

		var $subNavBtnDuarte = $("#subNavBtn4");
		var $subNavBtnIrwindale = $("#subNavBtn5");
		var $subNavBtnAlameda = $("#subNavBtn6");
		var $subNavBtnCitrus = $("#subNavBtn7");

		/* Phases Station Variables */
		var $station1 = $(".station1");
		var $station2 = $(".station2");
		var $station3 = $(".station3");
				var $station3b = $(".station3b");

		var $station4 = $(".station4");
		var $station5 = $(".station5");
		var $station6 = $(".station6");
		var $station7 = $(".station7");

		// CITRUS
		if(!$subNavBtnCitrus.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station7.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnCitrus.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtnCitrus.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station7.toggleClass('activeMapItem');
				}
			);
		}
		// ALAMEDA
		if(!$subNavBtnAlameda.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station6.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnAlameda.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtnAlameda.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station6.toggleClass('activeMapItem');
				}
			);
		}
		// IRWINDALE
		if(!$subNavBtnIrwindale.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station5.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnIrwindale.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtnIrwindale.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station5.toggleClass('activeMapItem');
				}
			);
		}
		// DUARTE
		if(!$subNavBtnDuarte.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station4.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnDuarte.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtnDuarte.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station4.toggleClass('activeMapItem');
				}
			);
		}
		// MONROVIA
		if(!$subNavBtnMonrovia.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station3.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnMonrovia.toggleClass('active');
				}
			);

			// Highlight city nav button when hovering over stations
			$subNavBtnMonrovia.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station3.toggleClass('activeMapItem');
				}
			);
		}

			// CAMPUS
		if(!$subNavBtnCampus.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station3b.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnCampus.toggleClass('active');
				}
			);

			// Highlight city nav button when hovering over stations
			$subNavBtnCampus.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station3b.toggleClass('activeMapItem');
				}
			);
		}
		// If I-210 Bridge Area is not already active
		if(!$subNavBtnI210Bridge.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station1.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnI210Bridge.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtnI210Bridge.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station1.toggleClass('activeMapItem');
				}
			);
		}
		// ARCADIA
		if(!$subNavBtnArcadia.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station2.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtnArcadia.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtnArcadia.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station2.toggleClass('activeMapItem');
				}
			);
		}


		// Highlight all stations in city area when city is active
		if($subNavBtnI210Bridge.is(".active"))
		{
			$station1.addClass('activeMapItem');
		}
		if($subNavBtnArcadia.is(".active"))
		{
			$station2.addClass('activeMapItem');
		}
		if($subNavBtnMonrovia.is(".active"))
		{
			$station3.addClass('.activeMapItem');
		}
		if($subNavBtnDuarte.is(".active"))
		{
			$station4.addClass('.activeMapItem');
		}
		if($subNavBtnIrwindale.is(".active"))
		{
			$station5.addClass('.activeMapItem');
		}
		if($subNavBtnAlameda.is(".active"))
		{
			$station6.addClass('.activeMapItem');
		}
		if($subNavBtnCitrus.is(".active"))
		{
			$station7.addClass('.activeMapItem');
		}

		// default activeMapItem
		var $activeDefaults = $('.activeMapItem');
    },
	phase3Map: function($phase3Map) {

		/* Phases Sub Navigation Button Variables */
		var $subNavBtn1 = $("#subNavBtnGlendora");
		var $subNavBtn2 = $("#subNavBtnSanDimas");
		var $subNavBtn3 = $("#subNavBtnLaVerne");
		var $subNavBtn4 = $("#subNavBtnPomona");
		var $subNavBtn5 = $("#subNavBtnClaremont");
		var $subNavBtn6 = $("#subNavBtnMontclair");

		/* Phases Station Variables */
		var $station1 = $(".glendoraStation");
		var $station2 = $(".sanDimasStation");
		var $station3 = $(".laVerneStation");
		var $station4 = $(".pomonaStation");
		var $station5 = $(".claremontStation");
		var $station6 = $(".montclairStation");

		// GLENDORA
		if(!$subNavBtn1.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station1.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtn1.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtn1.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station1.toggleClass('activeMapItem');
				}
			);
		}
		// SAN DIMAS
		if(!$subNavBtn2.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station2.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtn2.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtn2.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station2.toggleClass('activeMapItem');
				}
			);
		}
		// LA VERNE
		if(!$subNavBtn3.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station3.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtn3.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtn3.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station3.toggleClass('activeMapItem');
				}
			);
		}
		// POMONA
		if(!$subNavBtn4.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station4.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtn4.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtn4.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station4.toggleClass('activeMapItem');
				}
			);
		}
		// CLAREMONT
		if(!$subNavBtn5.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station5.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtn5.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtn5.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station5.toggleClass('activeMapItem');
				}
			);
		}
		// MONTCLAIR
		if(!$subNavBtn6.is(".active"))
		{
			// Highlight stations when hovering over city nav button
			$station6.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$subNavBtn6.toggleClass('active');
				}
			);
			// Highlight city nav button when hovering over stations
			$subNavBtn6.hover(
			 	function () {
					$activeDefaults.toggleClass('activeMapItem');
					$station6.toggleClass('activeMapItem');
				}
			);
		}


		// Highlight all stations in city area when city is active
		if($subNavBtn1.is(".active"))
		{
			$station1.addClass('activeMapItem');
		}
		if($subNavBtn2.is(".active"))
		{
			$station2.addClass('activeMapItem');
		}
		if($subNavBtn3.is(".active"))
		{
			$station3.addClass('.activeMapItem');
		}
		if($subNavBtn4.is(".active"))
		{
			$station4.addClass('.activeMapItem');
		}
		if($subNavBtn5.is(".active"))
		{
			$station5.addClass('.activeMapItem');
		}
		if($subNavBtn6.is(".active"))
		{
			$station6.addClass('.activeMapItem');
		}

		// default activeMapItem
		var $activeDefaults = $('.activeMapItem');
    },
	videos: {
		init: function($video) {
			// paginate videos
			this.paginate( $video );

			// set capture the featured videos
			$('#videosListing a').click(function(e) {
				e.preventDefault();
				Metro.videos.setVideo( $(this) );
			});

			// get archived videos
			$video.click(function(e) {
				// bubble up the event
				var $target = $(e.target);

				if ($target.is('a.playVideo')) {
					e.preventDefault();
					Metro.videos.setVideo( $target );
				} else if ($target.is('img.playVideo')) {
					e.preventDefault();
					Metro.videos.setVideo( $target.parent() );
				}
			});
		},
		homeVideos: function($video) {
			$video.find('a').not('.regularLink').click(function(e) {
				e.preventDefault();

				// hide the slide gallery
				$('.mediaBox').hide();
				
				Metro.videos.setVideo( $(this) );
			});
		},
		setVideo: function($item) {
			var $parent = $item.parents('.item'),
				$embed = $parent.find('.media_embed'),
				$vidPlayer = $('#videoBox');

			if ($embed.length) {
				// there is embed html so let's use that!
				$vidPlayer.html( $embed.html() );
			} else {
				// there is no embed html so let's create it and inject it!
				$vidPlayer.html( this.createEmbed( $item ) );
			}
		},
		createEmbed: function($item) {
			var mediaUrl = $item.attr('href'),
				match = mediaUrl.match(/youtube|vimeo/gi)[0],
				parts,
				embedCode = '';

			switch (match) {
				case 'youtube':
					parts = mediaUrl.match(/v\=[0-9A-Za-z\-_]+/gi)[0].substr(2);
					embedCode = '<object width="468" height="282"><param name="movie" value="https://www.youtube.com/v/'+parts+'?fs=1&amp;hl=en_US&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="https://www.youtube.com/v/'+parts+'?fs=1&amp;hl=en_US&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="468" height="282"></embed></object>';
					break;
				case 'vimeo':
					parts = mediaUrl.match(/[0-9]+/gi)[0];
					embedCode = '<iframe src="https://player.vimeo.com/video/'+parts+'?title=0&amp;byline=0&amp;portrait=0" width="468" height="282" frameborder="0"></iframe>';
					break;
			}

			return embedCode;
		},
		paginate: function($video) {
			var $videos = $video.find('.videos'),
				$pages = $videos.find('div.page'),
				$pag = $video.find('.paginator');

			// hide all pages past first
			$pages.filter(':gt(0)').hide();

			// do paginator nav
			$pag.find('a').click(function(e) {
				e.preventDefault();

				Metro.videos.switchPage( this, $pag, $pages );
			});
		},
		switchPage: function(el, $pag, $pages) {
			var $this = $(el),
				cindex = $pages.index( $('div.page:visible') ),
				$cpage = $pag.find('.page'),
				cpaget = parseFloat($cpage.text());

			if ($this.is('.next')) {
				// go next
				if (cindex + 1 < $pages.length) {
					// go up 1
					$cpage.text( cpaget + 1 );
					$pages.hide();
					$pages.eq(cindex + 1).show();
				} else {
					// go back to first
					$cpage.text(1);
					$pages.hide();
					$pages.first().show();
				}
			} else {
				// go prev
				if (cindex + 1 > 1) {
					// go back one
					$cpage.text( cpaget - 1 );
					$pages.hide();
					$pages.eq( cindex - 1 ).show();
				} else {
					// go up to the last page
					$cpage.text( $pages.length );
					$pages.hide();
					$pages.last().show();
				}
			}
		}
	},
	cal: {
		init: function($cal) {
			// handle calendar view buttons (next, prev)
			this.handleViews( $cal );

			// event links don't actually go anywhere for now
			this.handleEvents( $cal );

			// handle more event links
			this.moreinfo();
		},
		handleViews: function($cal) {
			var cal = this,
				$links = $cal.find('.calendarMonthLinks');

			$links.click(function(e) {
				var $this = $(this),
					url = $this.attr('href'),
					details = url.replace('cal', 'details'),
					setc = $('#calendarMeetingTable').attr('class'),
					set = (setc) ? setc.substr(4) : false;
					$shield = $('<div class="shield"><div class="ajax"></div></div>');

				e.preventDefault();

				// Get the calendar (left)
				$.ajax({
					url: url,
					beforeSend: function() {
						$shield
							.width( $cal.width() )
							.height( $cal.height() )
							.hide()
							.insertBefore( $cal )
							.fadeIn(150);
					},
					success: function(data) {
						var $data = $(data);

						$cal.replaceWith( $data );
						$shield.fadeOut(100, function() {
							$shield.remove();
						});

						cal.handleViews( $data );
						cal.handleEvents( $data );
					}
				});

				// Get the details (right)
				details += (set) ? '/'+set+'/' : '';

				$.ajax({
					url: details,
					success: function(data) {
						var $data = $(data);

						$('#calendarMeetingTable').find('tr:gt(0)').replaceWith( $data );
						cal.moreinfo();
					}
				});
			});
		},
		handleEvents: function($cal) {
			var $events = $cal.find('.eventLink');

			$events.click(function(e) {
				var $t = $(this),
					id = this.getAttribute('id'),
					highlight = id.substr(2),
					detail = '#d_'+highlight,
					moredetails = '#mi_'+highlight,
					$moredetails_exists = $(moredetails),
					$scroll = $('#contentRight');

				e.preventDefault();
				$('.highlight td').css( 'border-bottom', 'none');
				$('.highlight').removeClass('highlight');
				$( detail ).addClass('highlight');

				if ( $moredetails_exists.length )
				{
					$( moredetails ).addClass('highlight');
				}
				else
				{
					$('.highlight td').css( 'border-bottom', '1px solid #c2c2c2');
				}

				// scroll element into view
				if (Client.nav == 'ie' && Client.v <= 7) $scroll = $scroll.children();

				$scroll.scrollTo( detail, 450, {easing: 'easeInOutExpo', offset: -20} );
			});
		},
		moreinfo: function() {
			var $mi = $('#calendarMeetingTable').find('.mi');

			$mi.click(function() {
				var $t = $(this),
					id = $t.attr('href');

				if (Client.nav == 'ie' && Client.v <= 7) {
					id = '#' + id.replace(/.*\#/, '');
				}

				$t.toggleClass('on');
				$(id).slideToggle(250, 'easeInOutExpo');

				return false;
			});
		}
	},
	fixIE: function() {
		var $areas = $('div:css(overflow,auto)');

		$areas.each(function() {
			var $t = $(this),
				h = $t.height(),
				w = $t.width();

			$t.wrapInner('<div style="overflow:auto;position:relative;"></div>')
				.children().height(h).width(w);
		});
	},
    utilities: {
      // you can package code together with related methods like so
      // this would be Metro.utilities.trim(str)
      trim: function(str) {
        return $.trim(str);
      },
      makeUpper: function(str) {
        return str.toUpperCase();
      },
      isZipValid: function() {

      	var $zip = $('#zip_code'),
      		zipCodeVal = $zip.val(),
      		test = zipCodeVal.match(/^\d{5}(-\d{4})?(?!-)$/);

      	if(!test)
      	{
      		$zip.focus();
      		alert("Please enter a valid Zip Code");
      		return false;
      	}

      	return true;

      },
      isFormValid: function () {

      	var $zip = $('#zip_code'),
      		zipCodeVal = $zip.val(),
      		ziptest = zipCodeVal.match(/^\d{5}(-\d{4})?(?!-)$/),
      		$email1 = $('#formEmail'),
      		$email1Val = $.trim($email1.val()),
      		$email2 = $('#email2'),
      		$email2Val = $.trim($email2.val()),
      		$emailtest = ($email1Val != null) && ($email2Val != null) && ($email1Val === $email2Val);

      	if(!ziptest)
      	{
      		$zip.focus();
      		alert("Please enter a valid Zip Code");
      		return false;
      	}
      	else if (!$emailtest)
      	{
      		$email1.focus();
      		alert("Your email addresses do not match");
      		return false;
      	}

      	return true;
      },
      doEmailsMatch: function () {

      	var $email1 = $('#formEmail'),
      		$email1Val = $.trim($email1.val()),
      		$email2 = $('#email2'),
      		$email2Val = $.trim($email2.val()),
      		$emailtest = ($email1Val != null) && ($email2Val != null) && ($email1Val === $email2Val);

      	if (!$emailtest)
      	{
      		$email1.focus();
      		alert("Your email addresses do not match");
      		return false;
      	}

      	return true;
      }

    }
  };
})(jQuery);

// Global events
jQuery(function() {
  Metro.fire();
});

// A space for custom things
(function($,undefined) {
	$.expr[':'].css = function(obj, index, meta, stack) {
		var params = meta[3].split(',');
		return ($(obj).css(params[0]) == params[1]);
	};
})(jQuery);
