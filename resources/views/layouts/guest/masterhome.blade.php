<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dana Syariah</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="google-signin-client_id" content="437102301747-mc6atn6ljrtv6fanh7st1dcqmlp8gcc9.apps.googleusercontent.com">
    {{-- <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" > --}}
    <link rel="shortcut icon" href="https://drive.google.com/uc?export=view&id=1WsRZFkSk-7_8yhHZ445aKCPjjJwl_6wp" type="image/x-icon" >
    <!-- chromeOpera -->
    <meta name="theme-color" content="#0F7851">
    <!-- Windows Phone browser -->
    <meta name="msapplication-navbutton-color" content="#0F7851">
    <!-- safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#0F7851">
    <!-- External CSS libraries -->
    <!-- chace control -->
    <!-- <meta http-equiv="Cache-control" content="public"> -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <link rel="stylesheet" href="/css/all.css">   
    @yield('style')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-142214442-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-142214442-1');
    </script>

    <!-- end of global site tag -->

    <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '444018075722130');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=444018075722130&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->

        <!-- chat intercome -->
        <script>
        window.intercomSettings = {
            app_id: "j44onp4i"
        };
    </script>
    <script>(function()
        {var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/j44onp4i';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
    </script>
    <!-- end of chat intercome -->
</head>
<body>
        <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N6RKMM6"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<div ></div>
@yield('navbar')

    @yield('body')
    <div class="modal fade" id="modalMd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="modalMdTitle"></h4>
                  </div>
                  <div class="modal-body">
                      <div class="modalError"></div>
                      <div id="modalMdContent"></div>
                  </div>
              </div>
          </div>
        </div>
    @include('includes.footerhome')
    
    <script src="/js/allNew.js"></script>
    <script defer src="/js/jquery.mCustomScrollbar.concat.min.js"></script> 
    <!-- canvas three js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
    <!-- Custom JS Script -->    
    <script defer src="/js/app.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <script>
        // lazy load
        const observer = lozad(); // lazy loads elements with default selector as '.lozad'
        observer.observe();
        // lazy load end
    </script>
    @if ($errors->get('username') || $errors->get('email') || $errors->get('password') )
    <script defer>        
        $(function() {
            $('#registerModal').modal('show')
        });
    </script>
    @endif

    {{-- <script defer>
        $(document).ready(function() {
            $('#newversionModal').modal('show')
        });
    </script> --}}
    @yield('script')
    
    <script type="text/javascript">
        $(document).ready(function () {
            //   slider v2
            var swiper = new Swiper('.blog-slider', {
                spaceBetween: 30,
                effect: 'fade',
                loop: true,
                mousewheel: {
                invert: false,
                },
        
                // autoHeight: true,
                pagination: {
                el: '.blog-slider__pagination',
                clickable: true,
                }
            });
        });
        // SLideHome
        $next = 1;          // fixed, please do not modfy;
        $current = 0;       // fixed, please do not modfy;
        $interval = 4000;   // You can set single picture show time;
        $fadeTime = 800;    // You can set fadeing-transition time;
        $imgNum = 3;        // How many pictures do you have
    
        $(document).ready(function(){
            //NOTE : Div Wrapper should with css: relative;
            //NOTE : img should with css: absolute;
            //NOTE : img Width & Height can change by you;
            $('.fadeImg').css('position','relative');
            $('.fadeImg img').css({'position':'absolute'});
    
            nextFadeIn();
        });
        $('#overlay').modal('show');

        setTimeout(function() {
            $('#overlay').modal('hide');
        }, 10000);
    
        function nextFadeIn(){
            //make image fade in and fade out at one time, without splash vsual;
            $('.fadeImg img').eq($current).delay($interval).fadeOut($fadeTime)
            .end().eq($next).delay($interval).hide().fadeIn($fadeTime, nextFadeIn);
                
            // if You have 5 images, then (eq) range is 0~4 
            // so we should reset to 0 when value > 4; 
            if($next < $imgNum-1){ $next++; } else { $next = 0;}
            if($current < $imgNum-1){ $current++; } else { $current =0; }
        };
        // End SLide Home
        // Video Popup
        $(document).ready(function() {

            // Gets the video src from the data-src on each button

            var $videoSrc;  
            $('.video-btn').click(function() {
                $videoSrc = $(this).data( "src" );
            });
            // console.log($videoSrc);

            
            
            // when the modal is opened autoplay it  
            $('#myModal').on('shown.bs.modal', function (e) {
                
            // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
            $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
            })
            


            // stop playing the youtube video when I close the modal
            $('#myModal').on('hide.bs.modal', function (e) {
                // a poor man's stop video
                $("#video").attr('src',$videoSrc); 
            }) 
            
        // document ready  
        });
        // end video popup
        // $('#newversionModal').delay(10000).hide();
        // setTimeout(function() {
        //   $('#newversionModal').hide();
        // }, 5000);
    </script>
</body>
</html>