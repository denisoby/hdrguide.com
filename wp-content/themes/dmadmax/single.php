<?php
/**
 * The template for displaying all posts.
 *
 * Default Post Template
 *
 * Page template with a fixed 940px container and right sidebar layout
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">
  <div class="container">
   <?php if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
   </div><!--/.container -->
   </div><!--/.row -->
   <div class="container">
        <div class="row content">
<div class="span8">
	<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

 <div class="row">
        <div class="span8">
        		<div class="row">
                	<div class="navbar subnav breadcrumb socialbar">
                    <ul>
                        <li><a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-url="<?php the_permalink(); ?>" data-via="hdrguide" data-related="hdrguide">Tweet</a></li>
                    
                        <li><div class="g-plusone" data-size="medium" data-count="true"></div></li>
                    
                        <li><div id="fb-root"></div>
                    <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="1" data-show-faces="false" data-action="like"></div></li>
                    </ul>
                    </div>
                </div>
        </div>
    </div>

      <header class="post-title">
        <h1 <?php hreview_echo(' class="item fn entry-title"'); ?>><?php the_title();?></h1>
      </header>
    
   
            
    	<div class="drated">
		<?php
				$fim = get_field("hide_featured_image");
		if ( has_post_thumbnail() && $fim != 1){
			if (is_single('hdr-efex-pro-review')) {
			?><a href="http://hdrguide.com/go/nik-collection" target="_blank"><?php the_post_thumbnail( 'featured-image', array( 'class' => 'featured-image' ) ); ?></a><?php
			} elseif (is_single('nik-collection-coupon-code')) {
			?><a href="http://hdrguide.com/go/nik-collection" target="_blank"><?php the_post_thumbnail( 'featured-image', array( 'class' => 'featured-image' ) ); ?></a><?php
			}	else {
			the_post_thumbnail( 'featured-image', array( 'class' => 'featured-image' ) );
			};
		};
		?>
		<?php // output rating
		if (get_field("rating")):
		 $origrating = get_field("rating");
		 ?>
                <div class="rating-chart">
                    		<div class="percentage-dark" data-percent="<?php echo $origrating*10; ?>">
                              <span class="rating">
                                <span class="value" itemprop="rating" title="rating"><?php echo number_format($origrating,1); ?></span>
                                <span class="best">
                                <span class="value-title" title="10"/> 
                                </span>
                              </span>
                    </div>
                </div>
         <?php endif; ?>
       </div>
            <div class="entry<?php hreview_echo(' description'); ?>">

            <?php /*
            <div style="float: left; padding: 15px;>

            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- hdrguide 1 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:336px;height:280px"
                 data-ad-client="ca-pub-0017098879698018"
                 data-ad-slot="9471214558"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            </div>
            */ ?>
       <?php
if (in_category('reviews')):
	if (get_field("pros") && get_field("cons") && get_field("conclusion")): ?>
        <div class="span3 pull-right offsetratings">
        
        <?php
if (in_category('reviews')):
	if (get_field("rating1") && get_field("rating2") && get_field("rating3") && get_field("label1") && get_field("label2") && get_field("label3")): ?>
        <div class="row extraratings">
        	<div class="light-chart">
                <div class="percentage centered" data-percent="<?php echo 10*get_field("rating1"); ?>"><span><?php echo get_field("rating1"); ?></span></div>
                <div class="label"><?php echo get_field("label1"); ?> </div>
            </div>
        	<div class="light-chart">
                <div class="percentage centered" data-percent="<?php echo 10*get_field("rating2"); ?>"><span><?php echo get_field("rating2"); ?></span></div>
                <div class="label"><?php echo get_field("label2"); ?> </div>
            </div>
        	<div class="light-chart">
                <div class="percentage centered" data-percent="<?php echo 10*get_field("rating3"); ?>"><span><?php echo get_field("rating3"); ?></span></div>
                <div class="label"><?php echo get_field("label3"); ?> </div>
            </div>
         </div>
    <?php endif;
endif; ?> 
        
        	<div class="row review3">
            	<h4 class="text-success"><i class="icon-plus"></i> Pros</h4>
				<?php echo get_field("pros"); ?> 
            </div>
            <div class="row review3">
            	<h4 class="text-error"><i class="icon-minus"></i> Cons</h4>
                <?php echo get_field("cons"); ?>
            </div>
            <div class="row review3">
            	<h4 class="text-info"><i class="icon-arrow-right-2"></i> Overall</h4>
                <?php echo get_field("conclusion"); ?>
            </div>             
        </div>
    <?php endif;
endif; ?>    

            <?php the_content();?>
            <?php /*
            <div style="text-align: center; padding: 10px">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- hdrguide2 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:580px;height:400px"
                 data-ad-client="ca-pub-0017098879698018"
                 data-ad-slot="4901414153"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            </div>
            */ ?>

            </div>
            <?php the_tags( '<ul class="tags"><li>', '</li><li>', '</li></ul>'); ?>

<?php if (is_single('photomatix-coupon-code')) { ?>
<br />
<p class="meta"><i class="icon-time icon-large"></i> Posted / last updated on 
<span class="date updated dtreviewed"><span class="value-title" title="2011-06-24">12 April 2014</span></span>
</p>
<?php 
} 
else 
{
?>
<p class="meta"><i class="icon-time icon-large"></i> Posted <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?> on <span class="date<?php hreview_echo(' updated dtreviewed') ?>"><?php
      hreview_echo('<span class="value-title" title="'.
        get_the_time('Y-m-d').'"/>');
      the_time('d F Y');
  ?>
</span></p>
<?php }
?>
            <hr>
            <div class="row">
              <div class="span1"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_email(), '100' ); }?></a></div>
              <div class="span7 vcard">
				<h3>About <span class="author<?php hreview_echo(' fn reviewer'); ?>"><?php the_author(); ?></span></h3>
				<p><?php the_author_description(); ?></p>
                
              </div>
            </div>
        
<?php endwhile; // end of the loop. ?>
</div> <!-- post class and id -->
<hr />
 <?php comments_template(); ?>

 <?php bootstrapwp_content_nav('nav-below');?>

          </div><!-- /.span8 -->
          <?php get_sidebar(); ?>


<?php get_footer(); ?>