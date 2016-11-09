<?php
// Trust Radius Reviews

?>
<section class="layer--trustradius-reviews">
  <div class="row">
    <!-- Begin Widget HTML -->
    <div class="tr-widget-container">
      <div class="tr-header">Reviews of Birst on &nbsp; <img style="height: 16px;" src="//trustradius-static.s3.amazonaws.com/1.0.0/images/trustradius_logo_tm_240.png" alt="Software Reviews on TrustRadius">
      </div>
      <!-- Configuration parameters go inside the "trustradius-widget" class below -->
      <div class="trustradius-widget" style="width: 100%; height: 220px; float: left; margin: 10px;" data-show-job-description="false" data-products="birst" data-show-footer="false" data-show-header="false" data-max-reviews="12" data-min-rating="9" data-sort="-date" data-max-teaser-length="235" data-navigation-mode="slide">
        <!-- Add JavaScript so that the widget loads asynchronously, without affecting the loading of the rest of the page. -->
        <script>
          // <![CDATA[
          (function() {
            function async_load() {
              var s = document.createElement('SCRIPT');
              s.src = '//d30ia583fbtg8i.cloudfront.net/reviews_list/v2/reviews_list.js';
              s.async = true;
              var x = document.getElementsByTagName('script')[0];
              x.parentNode.insertBefore(s, x);
            }
            window.attachEvent ? window.attachEvent('onload', async_load) : window.addEventListener('load', async_load, false);
          })();
          // ]]>
        </script>
      </div>
    </div>
    <!-- End Widget HTML -->
  </div>
</section>
