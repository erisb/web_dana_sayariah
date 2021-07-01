/* =*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*

	#RAW // Pure Coming Soon Template
	@Author		   Madeon08
	@Type          Javascript
	@Version       1.1
	@Last Update   12:55 PM Monday, February 15th, 2015

	TABLE OF CONTENTS
	---------------------------
	 1. Loading
	 2. Scroll Reveal
	 3. Countdown
	 4. Center welcome
	 5. Map
	 6. Nav between info & newsletter
	 7. Tooltip
	 8. Smooth scroll
	 9. Newsletter

=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=* */

 /* ================================= */
/* :::::::::: 1. Loading ::::::::::: */
/* ================================= */

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
	
	// Fade in for the logo and the countdown after 3,0s
	setTimeout(function() {
		$("#brand-logo").addClass("fadeIn").removeClass("opacity-0");
		$("#countdown-group").addClass("fadeIn").removeClass("opacity-0");
	}, 3000);
	
	// Fade in for the contact button after 3,0s
	setTimeout(function() {
		$("#contact-form").addClass("fadeInDown").removeClass("opacity-0");
	}, 3000);
	
	// Fade in for the title under the logo after 3,5s
	setTimeout(function() {
		$("#text-maintenance").addClass("fadeIn").removeClass("opacity-0");
	}, 3500);
	
	// Fade in for the text under the title after 4,0s
	setTimeout(function() {
		$("#text-construction").addClass("fadeIn").removeClass("opacity-0");
	}, 4000);
		
});

/* ================================= */
/* ::::::: 2. Scroll Reveal :::::::: */
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
		
	if (jQuery(this).scrollTop() < 100) {
		$('#second-block').removeClass("").addClass('fadeOut display-none');
		$('#first-block').removeClass("display-none fadeOut").addClass('fadeIn');
		$('#info-block-button').addClass('active');
		$('#news-block-button').removeClass('active');
	} 

});

/* ================================= */
/* ::::::::: 3. Countdown :::::::::: */
/* ================================= */

// Set you end date just below
$('#countdown_dashboard').countDown({
	targetDate: {
		'day': 		02,
		'month': 	06,
		'year': 	2019,
		'hour': 	05,
		'min': 		0,
		'sec': 		0
	},
	omitWeeks: true
});

/* ================================= */
/* ::::::: 4. Center welcome ::::::: */
/* ================================= */

// Used to center the logo and the text in the home
$(window).load(function(){
	
	$(function(){
		
		$.fn.center = function () {
			this.css("position","fixed");
			this.css("top", ( $(window).height() - this.height() ) / 2  + "px");
			return this;
		}
	
		$(".welcomeblock").center();      // on page load div will be centered   
		$("#countdown-group").center();   // on page load div will be centered

		$(window).resize(function(){     // whatever the screen size this
		   $(".welcomeblock").center();     // this will make it center when window resize happens 
		   $("#countdown-group").center();  // this will make it center when window resize happens 
		});
		
	});

});
	
/* ================================= */
/* :::::::::::: 5. Map ::::::::::::: */
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
/* ::::::: 6. Nav between info & newsletter :::::: */
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
/* :::::::::: 7. Tooltip ::::::::::: */
/* ================================= */

// Tooltip is used to display a little bubble above your links (used in the footer mainly); Disable on the screens with a resolution under 1025px, for a question of ergonomy :-)
if (window.matchMedia("(min-width: 1025px)").matches) {	
			
	$(function () { $("[data-toggle='tooltip']").tooltip(); });

}

/* ================================= */
/* ::::::: 8. Smooth scroll :::::::: */
/* ================================= */

// Used to have a smooth scroll when the user is clicking on a link with a anchor
smoothScroll.init({
	speed: 800, // Integer. How fast to complete the scroll in milliseconds
    easing: 'easeInOutCubic', // Easing pattern to use
    updateURL: false, // Boolean. Whether or not to update the URL with the anchor hash on scroll
});

/* ================================= */
/* ::::::::: 9. Newsletter ::::::::: */
/* ================================= */

// Plugin for the newsletter
$(document).ready(function() {
	$("#notifyMe").notifyMe();
});