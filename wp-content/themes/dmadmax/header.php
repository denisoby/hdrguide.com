<?php
/**
 *
 * Default Page Header
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.1
 *
 * Last Revised: August 15, 2012
 */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
   <title><?php wp_title( '|', true, 'right' ); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

  <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/favicon.ico">

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/i-m-still-a-hillbill-ie.css" />
<![endif]-->

<?php wp_head(); ?>

<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter38005015 = new Ya.Metrika({ id:38005015, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/38005015" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

  </head>
  <body <?php body_class('noise'); ?>  data-spy="scroll" data-target=".bs-docs-sidebar" data-offset="10" onload="initPieChart();">
    <div class="navbar navbar-inverse navbar-relative-top">
           <div class="navbar-inner">
             <div class="container">
           <div style="float:left;">
            <div style="float: left; padding: 10px 0; width: 250px">
                <a href="https://store.stuckincustoms.com/complete-hdr-tutorial?acc=cfee398643cbc3dc5eefc89334cacdc1" target="_blank"><img src="http://hdrguide.com/wp-content/uploads/2013/04/hdr-video-tutorial.jpg" width="300" height="250"/></a>
            </div>
            <div style="float: left; padding: 10px 50px; width: 250px">
                <a href="https://store.stuckincustoms.com/art-of-photography?acc=cfee398643cbc3dc5eefc89334cacdc1" target="_blank"><img src="https://store.stuckincustoms.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/s/t/store_ad_-_beginning_photography_tutorial.jpg"/></a>
            </div>
           </div>
           <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div style="float: right">
          <?php
           /** Loading WordPress Custom Menu  **/
           wp_nav_menu( array(
              'menu'            => 'main-menu',
              'container_class' => 'nav-collapse',
              'menu_class'      => 'nav',
              'fallback_cb'     => '',
              'menu_id' => 'main-menu',
              'walker' => new Bootstrapwp_Walker_Nav_Menu()
          ) ); ?>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row masthead">
    <div class="container">
      <a class="brand" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
    </div><!--/.container -->
  </div><!--/.row -->
  
    <!-- End Header -->
              <!-- Begin Template Content -->