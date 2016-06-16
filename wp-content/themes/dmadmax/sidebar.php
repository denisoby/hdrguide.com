<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */
?>
<div class="span4">
	<div class="well sidebar-nav noise">    

<h3 class="widget-title">Love HDR? Follow HDR Guide</h3>

<div class="social-networks">
<a href="https://www.facebook.com/hdrguide" target="_blank"><i class="icon-facebook-2 icon-large"></i></a>
<a href="http://twitter.com/hdrguide" target="_blank"><i class="icon-twitter icon-large"></i></a>
<a href="https://plus.google.com/u/0/b/101791693434807353979/101791693434807353979"><i class="icon-gplus-2 icon-large"></i></a>
<a href="http://hdrguide.com/feed"><i class="icon-rss icon-large"></i></a>

</div>

<?php 
if (!is_single() && !in_category('reviews')) { ?>    
<h3 class="widget-title">Featured Reviews</h3>
<?php // fetch latest reviews
$my_query = new WP_Query('tag=featured&showposts=2&orderby=date&order=DESC'); ?>
<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>

    <h4><a href="<?php the_permalink() ?>" title="Permanent Link to: 
    <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
	
    <div class="drated">
    <?php
if ( has_post_thumbnail()): ?>
	<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'medium', array( 'class' => 'review' ) ); ?></a>
	<?php endif;
?>
<?php // output rating
		if (get_field("rating")):
		 $origrating = get_field("rating");
		 ?>

                <div class="rating-chart">
                    <div class="percentage-dark" data-percent="<?php echo $origrating*10; ?>"><?php echo number_format($origrating,1); ?></div>
                </div>

         <?php endif; ?>
    <hr>
	</div>
<?php endwhile; ?>
<?php } ?>
<?php 
if (1) { ?>    
<h3 class="widget-title">Recent Posts</h3>

<?php // fetch 5 latest posts
$my_query = new WP_Query('showposts=5'); ?>
<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
<div class="row-fluid recent">
<div class="span4">
		<?php if ( has_post_thumbnail()): ?>
        	<a href="<?php the_permalink() ?>"><?php  the_post_thumbnail( 'thumbnail'); ?></a>
        <?php endif; ?>
</div>
<div class="span8">
	 <h4><a href="<?php the_permalink() ?>" title="Permanent Link to: 
    <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
    <p><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></p>
</div>
</div>
<?php endwhile; ?>
<br />
<?php } ?>  
            <?php
    if ( function_exists('dynamic_sidebar')) dynamic_sidebar("sidebar-posts");
?>
	</div><!--/.well .sidebar-nav -->
          </div><!-- /.span4 -->
          </div><!-- /.row .content -->

