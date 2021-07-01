<!DOCTYPE html>
<html lang="en-us">
    
    <head>
        <meta charset="utf-8">
        <title>Dana Syariah Indonesia</title>
        <meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipiscing elit.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Madeon08">

        <!-- ================= Favicon ================== -->
        <!-- Standard -->
        <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" >
        <!-- Retina iPad Touch Icon-->
        <link rel="apple-touch-icon" sizes="144x144" href="/assets/img/favicon.ico">
        <!-- Retina iPhone Touch Icon-->
        <link rel="apple-touch-icon" sizes="114x114" href="/assets/img/favicon.ico">
        <!-- Standard iPad Touch Icon--> 
        <link rel="apple-touch-icon" sizes="72x72" href="/assets/img/favicon.ico">
        <!-- Standard iPhone Touch Icon--> 
        <link rel="apple-touch-icon" sizes="57x57" href="/assets/img/favicon.ico">
        
        <!-- =============== Google fonts =============== -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Maven+Pro:400,700' rel='stylesheet' type='text/css'>
        
        <!-- ============ Bootstrap core CSS ============ -->
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

        <!-- =============== Font Awesome =============== -->
        <link href="/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        
        <!-- ============ Add custom CSS here =========== -->
        <link href="/assets/css/animate.css" rel="stylesheet" type="text/css">
        <link href="/assets/css/magnific-popup.css" rel="stylesheet" type="text/css">
        <link href="/assets/css/style.css" rel="stylesheet" type="text/css">
    </head>
   
    <body>

        <!-- Loading -->
        <div class="globload">
            <div id="logo-loading" class="animated-middle spinner opacity-0">

                <!-- Logo / Uncomment the following line if you want to display your logo during the loading -->
                <!-- <img src="http://placehold.it/300x300/F1E7C0/333333&amp;text=logo" alt="" width="150" /> -->

                <div class="loading">

                     <p>please wait</p>
                     <span></span>
                     <span></span>
                     <span></span>
                     <span></span>
                     <span></span>
                     <span></span>
                     <span></span>

                </div>

            </div>
        </div>
        <!-- /. Loading -->
        
        <!-- Youtube background -->
        <!-- Write the small part just after the ?v= to change the video  -->
        <a id="bgndVideo" class="player" data-property="{videoURL:'http://www.youtube.com/watch?v=McWmHFkVOpM',containment:'#coming-soon',autoPlay:true, mute:false, startAt:0, opacity:1}"></a>
        
        <a class="controls-youtube-button opacity-0 animated-middle" onclick="$('#bgndVideo').playYTP()" data-toggle="tooltip" data-placement="bottom" data-title="Play" data-trigger="hover">
            <i class="fa fa-play"></i>
        </a>
        
        <a class="controls-youtube-button pause-button opacity-0 animated-middle" onclick="$('#bgndVideo').pauseYTP()" data-toggle="tooltip" data-placement="bottom" data-title="Pause" data-trigger="hover">
            <i class="fa fa-pause"></i>
        </a>
        <!-- /. Youtube background -->

        <!-- Background Picture on mobile -->
        <div id="back-stretch"></div>

        <!-- Global Wrapper -->
        <div class="wrapper">

            <!-- Main -->
            <div class="main">
               
                <!-- Welcome section -->
                <section class="welcome-section" id="coming-soon">

                    <!-- Grid pattern -->
                    <div id="pattern-video"></div>

                    <!-- Block logo & text -->
                    <div id="welcome" class="welcomeblock">

                        <div class="container">
                            
                            <div class="col-sm-12">

                                <!-- Logo -->
                                <img src="/img/danasyariahlogo.png" id="brand-logo" class="animated opacity-0" alt="" width="250" />

                               
                                <!-- Main text -->
                                <h1 class="animated opacity-0" style="padding-top: 20px" id="text-maintenance"><i class="fa fa-power-off"></i>UNDER MAINTENANCE</h1>

                                <!-- Text / Info  -->
                                <div class="col-md-6 col-md-offset-3 col-xs-12 col-xs-offset-0 animated opacity-0" id="text-construction">
                                    
                                    <h2>WE'LL BE RIGHT BACK AT 23.00 WIB.
                                        <br>More informations below.
                                    </h2>
                                    
                                    <!-- Button for informations -->
                                    <a data-scroll href="#anchor">
                                        <i class="fa fa-chevron-down" data-toggle="tooltip" data-placement="bottom" data-title="Informations" data-trigger="hover"></i>
                                    </a>

                                </div>
                        
                            </div>

                        </div>

                    </div>
                    <!-- /. Block logo & text -->

        
                </section>
                <!-- /. Welcome section -->

                <!-- Countdown section -->
               <!-- Countdown section -->
               <section class="countdown-section" id="anchor">

                <div class="container"> 
                    <div class="row">

                        <!-- Title above the countdown -->
                        <div class="col-md-12" data-scroll-reveal="enter after 0.3s">
                            <h3 class="title"><i class="fa fa-clock-o"></i><br>We are coming soon...</h3>
                        </div>

                        <div class="col-lg-12 col-md-12 col-xs-12">

                            <!-- Countdown -->
                            <div id="countdown_dashboard">
                                
                                <!-- Days -->
                                <div class="col-md-3 col-sm-3 col-xs-6 dash-glob" data-scroll-reveal="enter bottom move 25px, after 0.3s">
                                    <div class="dash days_dash">
                                        <div class="digit">0</div>
                                        <div class="digit">0</div>
                                        <div class="digit">0</div>
                                        <span class="dash_title">Days</span>
                                    </div>
                                </div>
                                
                                <!-- Hours -->
                                <div class="col-md-3 col-sm-3 col-xs-6 dash-glob" data-scroll-reveal="enter bottom move 25px, after 0.3s">
                                    <div class="dash hours_dash">
                                        <div class="digit">0</div>
                                        <div class="digit">0</div>
                                        <span class="dash_title">Hours</span>
                                    </div>
                                </div>
                                
                                <!-- Minutes -->
                                <div class="col-md-3 col-sm-3 col-xs-6 dash-glob" data-scroll-reveal="enter bottom move 25px, after 0.3s">
                                    <div class="dash minutes_dash">
                                        <div class="digit">0</div>
                                        <div class="digit">0</div>
                                        <span class="dash_title">Minutes</span>
                                    </div>
                                </div>
                                
                                <!-- Seconds -->
                                <div class="col-md-3 col-sm-3 col-xs-6 dash-glob" data-scroll-reveal="enter bottom move 25px, after 0.3s">
                                    <div class="dash seconds_dash">
                                        <div class="digit">0</div>
                                        <div class="digit">0</div>
                                        <span class="dash_title">Seconds</span>
                                    </div>
                                </div>
    
                            </div>
                            <!-- /. Countdown -->

                        </div>
                        
                    </div>
                </div>
            
            </section>
            <!-- /. Countdown section -->
                <!-- /. Countdown section -->
         
            </div>
            <!-- /. Main -->

        </div>
        <!-- /. Global Wrapper -->
        
        <!-- ////////////////\\\\\\\\\\\\\\\\ -->
        <!-- ********** Javascript ********** -->
        <!-- \\\\\\\\\\\\\\\\//////////////// -->

        <!-- *** *** Libraries jQuery and Bootstrap - Be careful to not remove them *** *** -->
        <script type="text/javascript" src="/assets/js/jquery.js"></script>
        <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>

        <!-- *** Countdown *** -->
        <script type="text/javascript" src="/assets/js/jquery.lwtCountdown-1.0.js"></script>

        <!-- *** JavaScript library that detects HTML5 and CSS3 features in the user’s browser *** -->
        <script type="text/javascript" src="/assets/js/modernizr.custom.js"></script>

        <!-- *** A lightweight script to animate scrolling to anchor links *** -->
        <script type="text/javascript" src="/assets/js/smooth-scroll.js"></script>

        <!-- *** Dynamically-resized, display your video from YouTube *** -->
        <script type="text/javascript" src="/assets/js/jquery.mb.YTPlayer.js"></script>

        <!-- *** Dynamically-resized, slideshow-capable background image to any page or element *** -->
        <script type="text/javascript" src="/assets/js/jquery.backstretch.js"></script>

        <!-- *** Create and maintain how elements fade in, triggered when they enter the viewport *** -->
        <script type="text/javascript" src="/assets/js/scrollReveal.js"></script>

        <!-- *** Google Maps API *** -->
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

        <!-- *** Popup with the contact form *** -->
        <script type="text/javascript" src="/assets/js/jquery.magnific-popup.min.js"></script>

        <!-- *** Plugins of contact and newsletter *** -->
        <script type="text/javascript" src="/assets/js/contact-me.js"></script>
        <script type="text/javascript" src="/assets/js/notifyMe.js"></script>

        <!-- *** A jQuery plugin that enables HTML5 placeholder behavior for browsers that aren’t trying hard enough yet (IE9) *** -->
        <script type="text/javascript" src="/assets/js/jquery.placeholder.js"></script>
        
        <!-- *** File used to start the plugins *** -->
        <script type="text/javascript" src="/assets/js/raw.js"></script>

        <!-- ////////////////\\\\\\\\\\\\\\\\ -->
        <!-- ********* /. Javascript ******** -->
        <!-- \\\\\\\\\\\\\\\\//////////////// -->

        <!-- YouTube background only on computer / on mobile, a picture is displayed by the backstrecth below -->
        <script>
            $(function(){
                if (!jQuery.browser.mobile)
                $(".player").mb_YTPlayer();
            });
        </script>

        <!-- Background applied only on mobile on the div called "back-stretch" -->
        <script>
            $(function(){
                if (jQuery.browser.mobile)
                $("#back-stretch").backstretch("https://images.unsplash.com/photo-1471880634588-3a1c2298e481?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80");
            });
        </script>

        <!-- Script for the popup contact form -->
        <script>
            $('.open-popup-link').magnificPopup({
                type:'inline',
                closeBtnInside: false,
                closeOnBgClick: false,
                mainClass: 'mfp-fade',
                removalDelay: 100,
                midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
            });
        </script>

        <!-- Keep the placeholder in old browsers -->
        <script>
            //Used for the placeholder on IE9
            $('input, textarea').placeholder();
        </script>

    </body>

</html>