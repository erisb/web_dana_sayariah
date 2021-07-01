/* =*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*

	#RAW // Pure Coming Soon Template
	@Author		   Madeon08
	@Type          Javascript
	@Version       1.1
	@Last Update   12:55 PM Monday, February 15th, 2015

	TABLE OF CONTENTS
	---------------------------
	 1. Loading
	 2. Full screen
	 3. Scroll Reveal
	 4. Countdown
	 5. Center welcome
	 6. Map
	 7. Nav between info & newsletter
	 8. Tooltip
	 9. Smooth scroll
	10. Newsletter
	11. Parallax

=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=* */

/* ================================= */
/* :::::::::: 1. Loading ::::::::::: */
/* ================================= */

$(document).ready(function() {

	$(function(){
		
		$.fn.center = function () {
			this.css("position","absolute");
			this.css("top", ( $(window).height() - this.height() ) / 2  + "px");
			this.css("left", ( $(window).width() - this.width() ) / 2 + "px");
			return this;
		}
	  
		$("#logo-loading").center();   // on page load div will be centered 

		$(window).resize(function(){ 	// whatever the screen size this
		   $("#logo-loading").center();   // this will make it center when window resize happens
		});
		
	});
    
    $("#logo-loading").addClass("fadeIn").removeClass("opacity-0");
});

// When all the files were been loaded
$(window).load(function() {

	// Fade Out for the loading after 2,4s
	setTimeout(function() {
		$(".globload").addClass("fadeOut animated-middle");
	}, 2400);

	// Display none for the loading after 3,5s
	setTimeout(function() {
		$(".globload").addClass("display-none");
	}, 3500);
	
	// Fade in for the logo after 3,0s
	setTimeout(function() {
		$("#brand-logo").addClass("fadeIn").removeClass("opacity-0");
	}, 3000);
	
	// Fade in for the contact button after 3,0s
	setTimeout(function() {
		$("#contact-form").addClass("fadeInDown").removeClass("opacity-0");
	}, 3000);

	// Fade in for the button play and pause (YouTube variant)
	setTimeout(function() {
		$(".controls-youtube-button").addClass("fadeIn").removeClass("opacity-0");
	}, 3000);
	
	// Fade in for the title under the logo after 3,5s
	setTimeout(function() {
		$("#text-maintenance").addClass("fadeIn").removeClass("opacity-0");
	}, 3500);
	
	// Fade in for the text under the title after 4,0s
	setTimeout(function() {
		$("#text-construction").addClass("fadeIn").removeClass("opacity-0");
	}, 4000);

	// Fade in up for the link at the bottom after 4,5s
	setTimeout(function() {
		$(".scrollbott").addClass("fadeInUp").removeClass("opacity-0");
	}, 4500);
		
});

/* ================================= */
/* :::::::: 2. Full screen ::::::::: */
/* ================================= */

// Home in full screen
$(document).ready(function() {
    fullScreenContainer();
});

function fullScreenContainer() {

    var screenWidth = $(window).width() + "px";
    var screenHeight = $(window).height() + "px";
    
    $("#coming-soon").css({
    width: screenWidth,
    height: screenHeight
    });
    
    $(window).resize( function () {
    
    var screenWidth = $(window).width() + "px";
    var screenHeight = $(window).height() + "px";
    
    $("#coming-soon").css({
    width: screenWidth,
    height: screenHeight
    }); 
    
    });
}

/* ================================= */
/* ::::::: 3. Scroll Reveal :::::::: */
/* ================================= */

// Use for the effect of appearing and disappearing the elements when the user is scrolling
(function($) {

    'use strict';

    // The starting defaults.
        var config = {
        after: '0.2s',
        over: '1.66s',
    };

    window.scrollReveal = new scrollReveal({ reset: true, move: '50px' });
    
})();

$(window).scroll(function () {
		
	if (jQuery(this).scrollTop() < 500) {
		$('#second-block').removeClass("").addClass('fadeOut display-none');
		$('#first-block').removeClass("display-none fadeOut").addClass('fadeIn');
		$('#info-block-button').addClass('active');
		$('#news-block-button').removeClass('active');
	} 

});

/* ================================= */
/* ::::::::: 4. Countdown :::::::::: */
/* ================================= */

// Set you end date just below
$('#countdown_dashboard').countDown({
	targetDate: {
		'day': 		02,
		'month': 	06,
		'year': 	2019,
		'hour': 	00,
		'min': 		0,
		'sec': 		0
	},
	omitWeeks: true
});

/* ================================= */
/* ::::::: 5. Center welcome ::::::: */
/* ================================= */

// Used to center the logo and the text in the home
$(window).load(function(){
	
	$(function(){
		
		$.fn.center = function () {
			this.css("position","absolute");
			this.css("top", ( $(window).height() - this.height() ) / 2  + "px");
			this.css("left", ( $(window).width() - this.width() ) / 2 + "px");
			return this;
		}
		
		$(".welcomeblock").center();   // on page load div will be centered 

		$(window).resize(function(){ 	// whatever the screen size this
		   $(".welcomeblock").center();   // this will make it center when window resize happens
		});
		
	});

});
	
/* ================================= */
/* :::::::::::: 6. Map ::::::::::::: */
/* ================================= */

// When the window has finished loading create our google map below
google.maps.event.addDomListener(window, 'load', init);
google.maps.event.addDomListener(window, 'resize', init);
		
function init() {
	
	var myLatlng = new google.maps.LatLng(49.6122021,6.1324549,17);

		// Basic options for a simple Google Map
		// For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
		var mapOptions = {
		// How zoomed in you want the map to start at (always required)
		zoom: 9,
		scrollwheel: false,
		draggable: false,
		
		// The latitude and longitude to center the map (always required)
		center: myLatlng,
		
		// How you would like to style the map. 
		// This is where you would paste any style found on Snazzy Maps.
				
		styles: [	
				
		{
	        "featureType": "landscape",
	        "stylers": [
	            {
	                "saturation": -100
	            },
	            {
	                "lightness": 65
	            },
	            {
	                "visibility": "on"
	            }
	        ]
	    },

	    {
	        "featureType": "poi",
	        "stylers": [
	            {
	                "saturation": -100
	            },
	            {
	                "lightness": 51
	            },
	            {
	                "visibility": "simplified"
	            }
	        ]
	    },

	    {
	        "featureType": "road.highway",
	        "stylers": [
	            {
	                "saturation": -100
	            },
	            {
	                "visibility": "simplified"
	            }
	        ]
	    },

	    {
	        "featureType": "road.arterial",
	        "stylers": [
	            {
	                "saturation": -100
	            },
	            {
	                "lightness": 30
	            },
	            {
	                "visibility": "on"
	            }
	        ]
	    },

	    {
	        "featureType": "road.local",
	        "stylers": [
	            {
	                "saturation": -100
	            },
	            {
	                "lightness": 40
	            },
	            {
	                "visibility": "on"
	            }
	        ]
	    },

	    {
	        "featureType": "transit",
	        "stylers": [
	            {
	                "saturation": -100
	            },
	            {
	                "visibility": "simplified"
	            }
	        ]
	    },

	    {
	        "featureType": "administrative.province",
	        "stylers": [
	            {
	                "visibility": "off"
	            }
	        ]
	    },

	    {
	        "featureType": "water",
	        "elementType": "labels",
	        "stylers": [
	            {
	                "visibility": "on"
	            },
	            {
	                "lightness": -25
	            },
	            {
	                "saturation": -100
	            }
	        ]
	    },

	    {
	        "featureType": "water",
	        "elementType": "geometry",
	        "stylers": [
	            {
	                "hue": "#ffff00"
	            },
	            {
	                "lightness": -25
	            },
	            {
	                "saturation": -97
	            }
	        ]
	    },

	    ]

	};
	
	var map = new google.maps.Map(document.getElementById('map'), mapOptions);

	// Set the text contained in the bubble; Let this part well in one line, no newline.
	var contentString = '<div class="info-content"><h2>We are here <small>28, Rue du Nord @ Luxembourg</small></h2><p>Located in the center of the city, lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam fermentum euismod erat, nec porta turpis fringilla sed.</p></div>';

	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});
	
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: 'More informations'
	});
	
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});
	
}
		
/* =============================================== */
/* ::::::: 7. Nav between info & newsletter :::::: */
/* =============================================== */	

$(document).ready(function() {
	
	$('button#info-block-button').click(function(){
		$('#second-block').removeClass("").addClass('fadeOut display-none');
		$('#first-block').removeClass("display-none fadeOut").addClass('fadeIn');
		$('#info-block-button').addClass('active');
		$('#news-block-button').removeClass('active');
	});

	$('button#news-block-button').click(function(){
		$('#second-block').removeClass('fadeOut display-none').addClass('fadeIn');
		$('#first-block').addClass('fadeOut display-none');
		$('#info-block-button').removeClass('active');
		$('#news-block-button').addClass('active');
	});

});

/* ================================= */
/* :::::::::: 8. Tooltip ::::::::::: */
/* ================================= */

// Tooltip is used to display a little bubble above your links (used in the footer mainly); Disable on the screens with a resolution under 1025px, for a question of ergonomy :-)
if (window.matchMedia("(min-width: 1025px)").matches) {	
			
	$(function () { $("[data-toggle='tooltip']").tooltip(); });

}

/* ================================= */
/* :::::::: 9. Smooth scroll ::::::: */
/* ================================= */

// Used to have a smooth scroll when the user is clicking on a link with a anchor
smoothScroll.init({
	speed: 800, // Integer. How fast to complete the scroll in milliseconds
    easing: 'easeInOutCubic', // Easing pattern to use
    updateURL: false, // Boolean. Whether or not to update the URL with the anchor hash on scroll
});

/* ================================= */
/* :::::::: 10. Newsletter ::::::::: */
/* ================================= */

// Plugin for the newsletter
$(document).ready(function() {
	$("#notifyMe").notifyMe();
});

/* ================================= */
/* ::::::::: 11. Parallax :::::::::: */
/* ================================= */

// Effect when you are scrolling, the background of the main div is moving slowly to the top
$(document).ready(function(){

	if ( $(window).width() > 769) {
		
    $(window).scroll( function() {
		var scroll = $(window).scrollTop(), slowScroll = scroll/2;
		$('#wrap').css({ transform: "translateY(" + slowScroll + "px)" });
		$('#back-stretch').css({ transform: "translateY(" + slowScroll + "px)" });
	});

	}
});