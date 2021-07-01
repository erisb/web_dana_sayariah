$(function() {
    $('#login-form-link').click(function(e) {
        
        $("#login-form").delay(100).fadeIn(100);
        $('#loginModalAs').modal('toggle');
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

});

$(function() {
    $('#login-form-link2').click(function(e) {
        $("#login-form2").delay(100).fadeIn(100);
        $("#register-form2").fadeOut(100);
        $('#register-form-link2').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    $('#register-form-link2').click(function(e) {
        $("#register-form2").delay(100).fadeIn(100);
        $("#login-form2").fadeOut(100);
        $('#login-form-link2').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

});
$(function() {

    $('#close-btn').click(function(e) {
        $("#linfo-user").delay(100).fadeIn(100);
        $("#info-user").fadeOut(100);
        $('#info-user').css({ display: "none" });
        $(this).css({ display: "none" });
        e.preventDefault();
    });
    $('#close-btn1').click(function(e) {
        $("#linfo-user1").delay(100).fadeIn(100);
        $("#info-user1").fadeOut(100);
        $('#info-user1').css({ display: "none" });
        $(this).css({ display: "none" });
        e.preventDefault();
    });

});
$(function () {

    "use strict";

    // On window's load
    $(window).on('load', function () {
        setTimeout(function () {
            $(".page_loader").fadeOut("fast");
            $('link[id="style_sheet"]').attr('href', '/css/skins/default.css');
            $('document').ready(function(){
                $(window.location.hash).modal('show');
                }
            );

            // $('html, body').animate({
            //   scrollTop: 0
            // }, "fast");

        }, 1000);

        if ($('body.filter-portfolio').length > 0) {
            $(function () {
                $('.filter-portfolio').filterizr(
                    {
                        delay: 0
                    }
                );
            });
            $('.filteriz-navigation li').on('click', function () {
                $('.filteriz-navigation .filtr').removeClass('active');
                $(this).addClass('active');
            });
        }

    });

    // jQuery(document).on('ready', function() {
    //     (function($) {
    //         thmVideoPopup();
    //     })(jQuery);
    // });
    // Testimonial Slider
    jQuery(document).ready(function($) {

        // videopopup
        $('.video-popup').magnificPopup({
            type: 'iframe',
            disableOn: 700,
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: true,

            fixedContentPos: false
            
            });
        // endvideo

        var feedbackSlider = jQuery('.feedback-slider');
        feedbackSlider.owlCarousel({
            items: 2,
            nav: false,
            dots: true,
            autoplay: true,
            loop: true,
            mouseDrag: true,
            touchDrag: true,
            navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true,
                    autoplay: true,
                    loop: true,
                },
                600:{
                    items:1,
                    nav:false,
                    autoplay: true,
                    loop: true,
                },
                767:{
                    items:2,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    loop: true,
                },
                1000:{
                    items:3,
                    nav:false,
                    dots: true,
                    loop:false,
                    autoplay: true,
                    loop: true,
                }
            }
        });
    
        feedbackSlider.on("translate.owl.carousel", function(){
            $(".feedback-slider-item h3").removeClass("animated fadeIn").css("opacity", "0");
            $(".feedback-slider-item img, .feedback-slider-thumb img, .customer-rating").removeClass("animated zoomIn").css("opacity", "0");
        });
    
        feedbackSlider.on("translated.owl.carousel", function(){
            $(".feedback-slider-item h3").addClass("animated fadeIn").css("opacity", "1");
            $(".feedback-slider-item img, .feedback-slider-thumb img, .customer-rating").addClass("animated zoomIn").css("opacity", "1");
        });
        feedbackSlider.on('changed.owl.carousel', function(property) {
            var current = property.item.index;
            var prevThumb = $(property.target).find(".owl-item").eq(current).prev().find("img").attr('src');
            var nextThumb = $(property.target).find(".owl-item").eq(current).next().find("img").attr('src');
            var prevRating = $(property.target).find(".owl-item").eq(current).prev().find('span').attr('data-rating');
            var nextRating = $(property.target).find(".owl-item").eq(current).next().find('span').attr('data-rating');
            $('.thumb-prev').find('img').attr('src', prevThumb);
            $('.thumb-next').find('img').attr('src', nextThumb);
            $('.thumb-prev').find('span').next().html(prevRating + '<i class="fa fa-star"></i>');
            $('.thumb-next').find('span').next().html(nextRating + '<i class="fa fa-star"></i>');
        });
        $('.thumb-next').on('click', function() {
            feedbackSlider.trigger('next.owl.carousel', [300]);
            return false;
        });
        $('.thumb-prev').on('click', function() {
            feedbackSlider.trigger('prev.owl.carousel', [300]);
            return false;
        });
        
    }); //end ready
    //remove paralax on mobile
    jQuery(document).ready(function($) {
        var alterClass = function() {
          var ww = document.body.clientWidth;
          if (ww < 400) {
            $('#parallax-container').removeClass('parallax');
          } else if (ww >= 401) {
            $('#parallax-container').addClass('parallax');
          };
        };
        $(window).resize(function(){
          alterClass();
        });
        //Fire it when the page first loads:
        alterClass();
      });
    // Slick Sliders
    $('.slick-normal').each(function () {
        var slider = $(this);
        $(this).slick({
            autoplay:true,
            autoplaySpeed:7500,
            infinite: true,
            dots: false,
            arrows: true,
            centerPadding: '0%',
            slidesToShow: 3, 
            slidesToScroll: 1,
            cssEase: 'linear',
            accessibility: true,
            adaptiveHeight: true,
            centerMode: true,
            slidesPerRow: 2,
            speed: 300,
            prevArrow:'<button type="button" class="slick-prev"></button>',
            nextArrow:'<button type="button" class="slick-next"></button>',
            responsive: [
                {
                    breakpoint: 1920,
                    settings:{
                        centerPadding: '20%', 
                        slideToShow: 3,
                    }
                },
                {
                    breakpoint: 1441,
                    settings: {centerPadding: '14%', slidesToShow: 3}
                },
                {
                    breakpoint: 1024,
                    settings: {
                        centerPadding: '20%', slidesToShow: 3,
                    }
                },                
                {
                    breakpoint: 767,
                    settings: {centerPadding: '12%', slidesToShow: 1, arrows: true, dot: false, centerMode: true,}
                },
                {
                    breakpoint: 640,
                    settings: "unslick"
                },
                {
                    breakpoint: 970,
                    settings: {centerPadding: '0%', slidesToShow: 3,}
                },
                {
                    breakpoint: 1000,
                    settings: {centerPadding: '0%', slidesToShow: 3,}
                },
                {
                    breakpoint: 1366,
                    settings: {centerPadding: '0%', slidesToShow: 3, }
                }
            ]      
        });
        $(window).on('resize', function() {
            $('.carousel').slick('resize');
        });
        $(this).closest('.slick-slider-area').find('.slick-prev').on("click", function () {
            slider.slick('slickPrev');
        });
        $(this).closest('.slick-slider-area').find('.slick-next').on("click", function () {
            slider.slick('slickNext');
        });
    });

    $('.slick-fullwidth').slick({
        centerMode: true,
        centerPadding: '10%',
        slidesToShow: 3,
        dots: true,
        arrows: true,
        responsive: [
            {
                breakpoint: 1441,
                settings: {centerPadding: '15%', slidesToShow: 3}
            },
            {
                breakpoint: 1025,
                settings: {
                    centerPadding: '10px', slidesToShow: 2,
                }
            },
            {
                breakpoint: 767,
                settings: {centerPadding: '10px', slidesToShow: 1}
            }
        ]
    });

    // Header shrink while page scroll
    adjustHeader();
    doSticky();
    doStickySukuk();
    $(window).on('scroll', function () {
        adjustHeader();
        doSticky();
        doStickySukuk();
    });

    function adjustHeader()
    {
        var windowWidth = $(window).width();
        if(windowWidth > 992) {
            if ($(document).scrollTop() >= 100) {
                if($('.header-shrink').length < 1) {
                    $('.sticky-header').addClass('header-shrink');
                }
                if($('.do-sticky').length < 1) {
                    $('.logo img').attr('src', '/img/logo.png');
                }
            }
            else {
                $('.sticky-header').removeClass('header-shrink');
                if($('.do-sticky').length < 1) {
                    $('.logo img').attr('src', '/img/logo.png');
                }
            }
        } else {
            $('.logo img').attr('src', '/img/logo.png');
        }
    }

    function doSticky()
    {
        if ($(document).scrollTop() > 40) {
            $('.do-sticky').addClass('sticky-header');
        }
        else {
            $('.do-sticky').removeClass('sticky-header');
        }
    }

    function doStickySukuk()
    {
        if ($(document).scrollTop() > 350) {
            $('#sukuk').addClass('fixed-bottom');
        }
        else {
            $('#sukuk').removeClass('fixed-bottom');
        }
    }



    // WOW animation library initialization
    var wow = new WOW(
        {
            animateClass: 'animated',
            offset: 100,
            mobile: false
        }
    );
    wow.init();

    $(".open-offcanvas, .close-offcanvas").on("click", function () {
        return $("body").toggleClass("off-canvas-sidebar-open"), !1
    });

    $(document).on("click", function (t) {
        var a = $(".off-canvas-sidebar");
        a.is(t.target) || 0 !== a.has(t.target).length || $("body").removeClass("off-canvas-sidebar-open")
    });

    // Banner slider
    //Function to animate slider captions
    function doAnimations(elems) {
        //Cache the animationend event in a variable
        var animEndEv = 'webkitAnimationEnd animationend';
        elems.each(function () {
            var $this = $(this),
                $animationType = $this.data('animation');
            $this.addClass($animationType).one(animEndEv, function () {
                $this.removeClass($animationType);
            });
        });
    }

    //Variables on page load
    var $myCarousel = $('#carouselExampleIndicators');
    var $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
    //Initialize carousel
    $myCarousel.carousel();

    //Animate captions in first slide on page load
    doAnimations($firstAnimatingElems);
    //Pause carousel
    $myCarousel.carousel('pause');
    //Other slides to be animated on carousel slide event
    $myCarousel.on('slide.bs.carousel', function (e) {
        var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
        doAnimations($animatingElems);
    });
    $('#carouselExampleIndicators').carousel({
        interval: 3000,
        pause: "false"
    });

    // Megamenu activation
    $(".megamenu").on("click", function (e) {
        e.stopPropagation();
    });

    // DROPDOWN ON HOVER

    $(".dropdown").on('hover', function () {
            $('.dropdown-menu', this).stop().fadeIn("fast");
        },
        function () {
            $('.dropdown-menu', this).stop().fadeOut("fast");
        });


    // Counter Activation
    function isCounterElementVisible($elementToBeChecked)
    {
        var TopView = $(window).scrollTop();
        var BotView = TopView + $(window).height();
        var TopElement = $elementToBeChecked.offset().top;
        var BotElement = TopElement + $elementToBeChecked.height();
        return ((BotElement <= BotView) && (TopElement >= TopView));
    }
    $(window).on('scroll', function () {
        $( ".counter" ).each(function() {
            var isOnView = isCounterElementVisible($(this));
            if(isOnView && !$(this).hasClass('Starting')){
                $(this).addClass('Starting');
                $(this).prop('Counter',0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 3000,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            }
        });
    });

    // Dropzone initialization
    Dropzone.autoDiscover = false;
    $(function () {
        $("div#myDropZone").dropzone({
            url: "/file-upload"
        });
    });

    // Full  Page Search Activation
    $(function () {
        $('a[href="#full-page-search"]').on('click', function(event) {
            event.preventDefault();
            $('#full-page-search').addClass('open');
            $('#full-page-search > form > input[type="search"]').focus();
        });

        $('#full-page-search, #full-page-search button.close').on('click keyup', function(event) {
            if (event.target === this || event.target.className === 'close' || event.keyCode === 27) {
                $(this).removeClass('open');
            }
        });

        // $('form').submit(function(event) {
        //     event.preventDefault();
        //     return false;
        // })
    });




    // Page scroller initialization.
    $.scrollUp({
        scrollName: 'page_scroller',
        scrollDistance: 300,
        scrollFrom: 'top',
        scrollSpeed: 500,
        easingType: 'linear',
        animation: 'fade',
        animationSpeed: 200,
        scrollTrigger: false,
        scrollTarget: false,
        scrollText: '<i class="fa fa-chevron-up"></i>',
        scrollTitle: false,
        scrollImg: false,
        activeOverlay: false,
        zIndex: 2147483647
    });

    $.scrollUp({
        scrollName: 'proyek_btn',
        scrollDistance: 300,
        scrollFrom: 'top',
        scrollSpeed: 500,
        easingType: 'linear',
        animation: 'fade',
        animationSpeed: 200,
        scrollTrigger: false,
        scrollTarget: false,
        scrollTitle: false,
        scrollImg: false,
        scrollText: '<i class="fa fa-chevron-up"></i>',
        activeOverlay: false,
        zIndex: 2147483647
    });

    $.scrollUp({
        scrollName: 'keunggulan_btn',
        scrollDistance: 300,
        scrollFrom: 'top',
        scrollSpeed: 500,
        easingType: 'linear',
        animation: 'fade',
        animationSpeed: 200,
        scrollTrigger: false,
        scrollTarget: false,
        scrollTitle: false,
        scrollImg: false,
        scrollText: '<i class="fa fa-chevron-up"></i>',
        activeOverlay: false,
        zIndex: 2147483647
    });


    // Magnify activation
    $('.property-magnify-gallery').each(function() {
        $(this).magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery:{enabled:true}
        });
    });

    // Range sliders activation
    $(".range-slider-ui").each(function () {
        var minRangeValue = $(this).attr('data-min');
        var maxRangeValue = $(this).attr('data-max');
        var minName = $(this).attr('data-min-name');
        var maxName = $(this).attr('data-max-name');
        var unit = $(this).attr('data-unit');

        $(this).append("" +
            "<span class='min-value'></span> " +
            "<span class='max-value'></span>" +
            "<input class='current-min' type='hidden' name='"+minName+"'>" +
            "<input class='current-max' type='hidden' name='"+maxName+"'>"
        );
        $(this).slider({
            range: true,
            min: minRangeValue,
            max: maxRangeValue,
            values: [minRangeValue, maxRangeValue],
            slide: function (event, ui) {
                event = event;
                var currentMin = parseInt(ui.values[0], 10);
                var currentMax = parseInt(ui.values[1], 10);
                $(this).children(".min-value").text( currentMin + " " + unit);
                $(this).children(".max-value").text(currentMax + " " + unit);
                $(this).children(".current-min").val(currentMin);
                $(this).children(".current-max").val(currentMax);
            }
        });

        var currentMin = parseInt($(this).slider("values", 0), 10);
        var currentMax = parseInt($(this).slider("values", 1), 10);
        $(this).children(".min-value").text( currentMin + " " + unit);
        $(this).children(".max-value").text(currentMax + " " + unit);
        $(this).children(".current-min").val(currentMin);
        $(this).children(".current-max").val(currentMax);
    });

    // Select picket activation
    $('select').selectBox(
        {
            mobile: true,
        }
    );


    // Dropdown activation
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');


        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass("show");
        });

        return false;
    });


    // Modal activation
    $('.property-video').on('click', function () {
        $('#propertyModal').modal('show');
    });

    $('.modal.fade').on('hidden.bs.modal', function(e) {
        $('.video-to-stop', this).each(function() {
          this.contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
        });
      });

    // Google map activation
    function LoadMap(propertes) {
        var defaultLat = 40.7110411;
        var defaultLng = -74.0110326;
        var mapOptions = {
            center: new google.maps.LatLng(defaultLat, defaultLng),
            zoom: 15,
            scrollwheel: false,
            styles: [
                {
                    featureType: "administrative",
                    elementType: "labels",
                    stylers: [
                        {visibility: "off"}
                    ]
                },
                {
                    featureType: "water",
                    elementType: "labels",
                    stylers: [
                        {visibility: "off"}
                    ]
                },
                {
                    featureType: 'poi.business',
                    stylers: [{visibility: 'off'}]
                },
                {
                    featureType: 'transit',
                    elementType: 'labels.icon',
                    stylers: [{visibility: 'off'}]
                },
            ]
        };
        var map = new google.maps.Map(document.getElementById("contactMap"), mapOptions);
        var infoWindow = new google.maps.InfoWindow();
        var myLatlng = new google.maps.LatLng(40.7110411, -74.0110326);

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map
        });
        (function (marker) {
            google.maps.event.addListener(marker, "click", function (e) {
                infoWindow.setContent("" +
                    "<div class='map-properties contact-map-content'>" +
                    "<div class='map-content'>" +
                    "<p class='address'>123 Kathal St. Tampa City </p>" +
                    "<ul class='map-properties-list'> " +
                    "<li><i class='fa fa-phone'></i>  +XXXX XXXX XXX</li> " +
                    "<li><i class='fa fa-envelope'></i>  info@themevessel.com</li> " +
                    "<li><a href='index.html'><i class='fa fa-globe'></i>  http://http://themevessel.com</li></a> " +
                    "</ul>" +
                    "</div>" +
                    "</div>");
                infoWindow.open(map, marker);
            });
        })(marker);
    }

    if($('#contactMap').length){
        LoadMap();
    }


    // Countdown activation
    $( function() {
        // Add background image
        //$.backstretch('../img/nature.jpg');
        var endDate = "December  27, 2019 15:03:25";
        $('.countdown.simple').countdown({ date: endDate });
        $('.countdown.styled').countdown({
            date: endDate,
            render: function(data) {
                $(this.el).html("<div>" + this.leadingZeros(data.days, 3) + " <span>Days</span></div><div>" + this.leadingZeros(data.hours, 2) + " <span>Hours</span></div><div>" + this.leadingZeros(data.min, 2) + " <span>Minutes</span></div><div>" + this.leadingZeros(data.sec, 2) + " <span>Seconds</span></div>");
            }
        });
        $('.countdown.callback').countdown({
            date: +(new Date) + 10000,
            render: function(data) {
                $(this.el).text(this.leadingZeros(data.sec, 2) + " sec");
            },
            onEnd: function() {
                $(this.el).addClass('ended');
            }
        }).on("click", function() {
            $(this).removeClass('ended').data('countdown').update(+(new Date) + 10000).start();
        });

    });


    // Multi-item carousel activation
    var itemsMainDiv = ('.multi-carousel');
    var itemsDiv = ('.multi-carousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').on('click', function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });
    ResCarouselSize();

    $(window).on('resize', function () {
        ResCarouselSize();
        resizeModalsContent();
        adjustHeader()
    });
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "multiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }

    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e === 0) {
            translateXval = parseInt(xds, 10) - parseInt(itemWidth * s, 10);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e === 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds, 10) + parseInt(itemWidth * s, 10);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }


    resizeModalsContent();
    function resizeModalsContent() {
        var winWidth = $(window).width();
        var videoWidth = 400;
        if(winWidth < 992) {
            videoWidth = 500;
        }
        var ratio = .6665;
        var videoHeight = videoWidth * ratio;
        $('.modalIframe').css('height', videoHeight);
    }


    // Typed string activation
    if($('#typed-strings').length > 0){
        var typed = new Typed('#typed', {
            stringsElement: '#typed-strings',
            typeSpeed: 100,
            backSpeed: 0,
            backDelay: 1000,
            startDelay: 1000,
            loop: true
        });
    }

    if($('#typed-strings2').length > 0){
        var typed = new Typed('#typed2', {
            stringsElement: '#typed-strings2',
            typeSpeed: 100,
            backSpeed: 0,
            backDelay: 1000,
            startDelay: 1000,
            loop: true
        });
    }

    if($('#typed-strings3').length > 0){
        var typed = new Typed('#typed3', {
            stringsElement: '#typed-strings3',
            typeSpeed: 100,
            backSpeed: 0,
            backDelay: 1000,
            startDelay: 1000,
            loop: true
        });
    }


    //Youtube carousel activation
    if($('.player').length > 0){
        $(document).on('ready', function () {
            $(".player").mb_YTPlayer();
        });
    }


    /* ---- particles.js config ---- */
    if($('#particles-banner').length > 0){
        loadParticlesBackground();
    }

    function loadParticlesBackground() {
        particlesJS("particles-banner", {
            "particles": {
                "number": {
                    "value": 100,
                    "density": {
                        "enable": true,
                        "value_area":1000
                    }
                },
                "color": {
                    "value": ["#aa73ff", "#f8c210", "#83d238", "#33b1f8"]
                },

                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#fff"
                    },
                    "polygon": {
                        "nb_sides": 2
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.6,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 2,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 120,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": false
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
    }


    // Switching Color schema
    function populateColorPlates() {
        var plateStings = '<div class="option-panel option-panel-collased">\n' +
            '    <h2>Change Color</h2>\n' +
            '    <div class="color-plate default-plate" data-color="default"></div>\n' +
            '    <div class="color-plate blue-plate" data-color="blue"></div>\n' +
            '    <div class="color-plate yellow-plate" data-color="yellow"></div>\n' +
            '    <div class="color-plate red-plate" data-color="red"></div>\n' +
            '    <div class="color-plate green-light-plate" data-color="green-light"></div>\n' +
            '    <div class="color-plate orange-plate" data-color="orange"></div>\n' +
            '    <div class="color-plate yellow-light-plate" data-color="yellow-light"></div>\n' +
            '    <div class="color-plate green-light-2-plate" data-color="green-light-2"></div>\n' +
            '    <div class="color-plate olive-plate" data-color="olive"></div>\n' +
            '    <div class="color-plate purple-plate" data-color="purple"></div>\n' +
            '    <div class="color-plate blue-light-plate" data-color="blue-light"></div>\n' +
            '    <div class="color-plate brown-plate" data-color="brown"></div>\n' +
            '    <div class="setting-button">\n' +
            '        <i class="fa fa-gear"></i>\n' +
            '    </div>\n' +
            '</div>';
        $('body').append(plateStings);
    }
    $(document).on('click', '.color-plate', function () {
        var name = $(this).attr('data-color');
        $('link[id="style_sheet"]').attr('href', '/css/skins/' + name + '.css');
    });

    $(document).on('click', '.setting-button', function () {
        $('.option-panel').toggleClass('option-panel-collased');
    });
});






// mCustomScrollbar initialization
(function ($) {
    $(window).on('resize', function () {
        $('#map').css('height', $(this).height() - 110);
        if ($(this).width() > 768) {
            $(".map-content-sidebar").mCustomScrollbar(
                {theme: "minimal-dark"}
            );
            $('.map-content-sidebar').css('height', $(this).height() - 110);
        } else {
            $('.map-content-sidebar').mCustomScrollbar("destroy"); //destroy scrollbar
            $('.map-content-sidebar').css('height', '100%');
        }
    }).trigger("resize");
})(jQuery);

// hero slider
$('.hero-slide').slick({
    autoplay:true,
    autoplaySpeed:5500,
    infinite: true,
    arrows: true,
    centerMode: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 220,
    centerPadding: '0px',
    cssEase: 'linear',
    touchThreshold: 100,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: true,
          centerMode: true,
          centerPadding: '0px',
          slidesToShow: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: true,
          centerMode: true,
          centerPadding: '0px',
          slidesToShow: 1
        }
      }
    ]
  });

  $('.delapan-keunggulan').slick({
    infinite: true,
    autoplay:true,
    slidesToShow: 3,
    slidesToScroll: 3,
    centerMode: true,
    arrows: true,
    responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '0px',
            slidesToShow: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '0px',
            slidesToShow: 1
          }
        }
      ]
  });
      
//   delapan keunggulan slide
// hero slider
$('.delapan-slide').slick({
    autoplay:true,
    autoplaySpeed:5500,
    infinite: true,
    arrows: false,
    centerMode: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 220,
    centerPadding: '0px',
    cssEase: 'linear',
    touchThreshold: 100,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '0px',
          slidesToShow: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '0px',
          slidesToShow: 1
        }
      }
    ]
  });

// canvas particle
// paralax gsap
$(function(){               
                

            var $parallaxContainer    = $("#parallax-container"); //our container
            var $parallaxItems          = $parallaxContainer.find(".parallax");  //elements
            var fixer                         = 0.0008;     //experiment with the value
            
            $(document).on("mousemove", function(event){                    
                        
                var pageX =  event.pageX - ($parallaxContainer.width() * 0.5);  //get the mouseX - negative on left, positive on right
                var pageY =  event.pageY - ($parallaxContainer.height() * 0.5); //same here, get the y. use console.log(pageY) to see the values
                
      //here we move each item
                $parallaxItems.each(function(){
                    
                    var item    = $(this);
                    var speedX  = item.data("speed-x");                 
                    var speedY  = item.data("speed-y");
                    
        /*TweenLite.to(item, 0.5, {
                        x: (item.position().left + pageX * speedX )*fixer,    //calculate the new X based on mouse position * speed 
                        y: (item.position().top + pageY * speedY)*fixer
                    });*/
        
        //or use set - not so smooth, but better performance
        if(window.innerWidth >= 640){
        TweenLite.set(item, {
                        x: (item.position().left + pageX * speedX )*fixer,
                        y: (item.position().top + pageY * speedY)*fixer
                    });
        } else {
            TweenLite.set(item, {
                x: 0,
                y: 0
            });
        }
                    
                });
            });             
        });

      
// greenshock
// video
$(document).ready(function(){
    //google login
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        console.log('Name: ' + profile.getName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        alert("I am an alert box!"+profile.getId());
      }
      function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
          console.log('User signed out.');
        });
      }
    //   end google login
    // tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })

    $("#myModal2").on("hidden.bs.modal",function(){
      $("#iframeYoutube").attr("src","#");
    })
  })
  
  function changeVideo(vId){
    var iframe=document.getElementById("iframeYoutube");
    iframe.src="https://www.youtube.com/embed/"+vId;
  
    $("#myModal2").modal("show");
  }


// $('select').selectBox(
//     {
//         mobile: true,
//     }
// );

// // Dropdown activation
// $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
//     if (!$(this).next().hasClass('show')) {
//         $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
//     }
//     var $subMenu = $(this).next(".dropdown-menu");
//     $subMenu.toggleClass('show');


//     $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
//         $('.dropdown-submenu .show').removeClass("show");
//     });

//     return false;
// });
