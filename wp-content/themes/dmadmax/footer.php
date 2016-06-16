<?php
/**
 * Default Footer
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.1
 *
 * Last Revised: July 16, 2012
 */
?>
    <!-- End Template Content -->
    </div> <!-- /container -->
      <footer>
<div class="container">
      <div class="row">
      	<div class="span4">
          <?php if ( function_exists('dynamic_sidebar')) dynamic_sidebar("footer-left"); ?>
         </div>
         <div class="span4">
          <?php if ( function_exists('dynamic_sidebar')) dynamic_sidebar("footer-middle"); ?>
          </div>
          <div class="span4">          
          <?php if ( function_exists('dynamic_sidebar')) dynamic_sidebar("footer-right"); ?>
          </div>
	</div> <!--  row -->
	<p class="pull-left">&copy; <?php bloginfo('name'); ?> <?php the_time('Y') ?>. <a href="http://hdrguide.com/privacy-policy">Privacy Policy</a>. This site is monetized by affiliate links.</p>
          <p class="pull-right btt"><a href="#"><i class="icon-arrow-right-2"></i> Back to top</a></p>
		<!-- /container used to be here -->
       </footer>
<?php wp_footer(); ?>

  </body>
</html>