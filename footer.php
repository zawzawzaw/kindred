  </div> <!-- #PageContainer -->


  <footer id="desktop-footer">
    <div class="container-fluid has-breakpoint">
      <div class="row">
        <div class="col-md-3">
          <div id="desktop-footer-logo-container">
            <a href="" id="desktop-footer-logo"></a>
          </div>
        </div>
        <div class="col-md-5">
          <div id="desktop-footer-menu">
            <nav>
              <ul>
                <li><a href="javascript:void(0);">About</a></li>
                <li><a href="javascript:void(0);">News</a></li>
                <li><a href="javascript:void(0);">My Account</a></li>
                <li><a href="javascript:void(0);">Our Teas</a></li>
                <li><a href="javascript:void(0);">FAQS</a></li>
                <li><a href="javascript:void(0);">Contact Us</a></li>
                <li><a href="javascript:void(0);">Tea Store</a></li>
                <li><a href="javascript:void(0);">Locate</a></li>
                <li><a href="javascript:void(0);">Terms & Privacy</a></li>
              </ul>
            </nav>
          </div>
        </div>
        <div class="col-md-1">
          <div id="desktop-footer-seperator">
          </div>
        </div>
        <div class="col-md-3">

          <div id="desktop-footer-right-container">

            <form id="desktop-footer-newsletter-form">
              <input type="text" placeholder="Join our mailing list">
              <button type="submit"></button>
            </form> <!-- desktop-footer-newsletter-form -->

            <div id="desktop-footer-social-container">
              <h4>Follow us</h4>
              <ul>
                <li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
                <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                <li><a href="javascript:void(0);" class="fa fa-pinterest"></a></li>
              </ul>
            </div> <!-- desktop-footer-social-container -->

          </div> <!-- desktop-footer-right-container -->


        </div>

      </div>
    </div>
  </footer>






  <!-- 
  <script type="text/javascript" src="source/libs/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="source/libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
  <script type="text/javascript" src="source/libs/jquery-disablescroll/jquery.disablescroll.min.js"></script>

  <script type="text/javascript" src="source/libs/misc-js/manic-custom-polyfill.js"></script>
  <script type="text/javascript" src="source/libs/misc-js/mobile-detect.js"></script>
  <script type="text/javascript" src="source/libs/misc-js/preloadjs-0.4.0.min.js"></script>

  <script type="text/javascript" src="source/libs/gsap/src/minified/TimelineMax.min.js"></script>
  <script type="text/javascript" src="source/libs/gsap/src/minified/TweenMax.min.js"></script>
  <script type="text/javascript" src="source/libs/gsap/src/minified/jquery.gsap.min.js"></script>
  <script type="text/javascript" src="source/libs/gsap/src/minified/plugins/ScrollToPlugin.min.js"></script>

  <script type="text/javascript" src="source/libs/scrollmagic/scrollmagic/minified/ScrollMagic.min.js"></script>
  <script type="text/javascript" src="source/libs/scrollmagic/scrollmagic/minified/plugins/animation.gsap.min.js"></script>
  <script type="text/javascript" src="source/libs/scrollmagic/scrollmagic/minified/plugins/debug.addIndicators.min.js"></script>

  <script type="text/javascript" src="source/libs/slick-carousel/slick/slick.min.js"></script>
  <script type="text/javascript" src="source/libs/imagesloaded/imagesloaded.pkgd.min.js"></script>

  <script type="text/javascript" src="source/libs/hammer/hammer.min.js"></script>
    
  <link rel="stylesheet" type="text/css" href="source/libs/intltelinput/css/intlTelInput.css">
  <script type="text/javascript" src="source/libs/intltelinput/js/utils.js"></script>
  <script type="text/javascript" src="source/libs/intltelinput/js/intlTelInput.js"></script>

  <script src="source/libs/video.js/dist/ie8/videojs-ie8.min.js"></script>
  <script src="source/libs/video.js/dist/video.min.js"></script>
  <script>
    videojs.options.flash.swf = 'source/libs/video.js/dist/video-js.swf';
  </script>


  
  <script src="source/libs/google-closure/closure-library/closure/goog/base.js"></script>
  <script src="source/js/google-closure-dependency-list.js"></script>
  <script type="text/javascript">
    goog.require('kindred.page.Default');
  </script>
  <script type="text/javascript">
    page = new kindred.page.Default({});
  </script>
  -->
  <script type="text/javascript" src="assets/head.load.min.js"></script>

  <script type="text/javascript">
    var PAGE_LIBRARY        = "assets/page-libraries.min.js";
    var PAGE_JS             = "assets/page-default.min.js";
    // prevent variable override
    window.custom_head = head;

    window.custom_head.load(PAGE_LIBRARY, function() {
      window.custom_head.load(PAGE_JS, function() {
        window.page = new kindred.page.Default({});
      });
    });
  </script>


</body>
</html>