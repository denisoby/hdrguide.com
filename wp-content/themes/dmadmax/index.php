<?php
/**
 *
 * Description: Default Index template to display loop of blog posts
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header();
if (have_posts() ) ;?>
<div class="row">
	<div class="container">
		<?php if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
	</div><!--/.container -->
</div><!--/.row -->
<div class="container">
	<header class="jumbotron subhead" id="overview">
		<?php
		if ( is_day() ) {
			printf( __( '<h1>%s', 'bootstrapwp' ), '<span>' . get_the_date() . '</span></h1><hr>' );
		} elseif ( is_month() ) {
			printf( __( '<h1>%s', 'bootstrapwp' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'bootstrapwp' ) ) . '</span></h1><hr>' );
		} elseif ( is_year() ) {
			printf( __( '<h1>%s', 'bootstrapwp' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'bootstrapwp' ) ) . '</span></h1><hr>' );
		} elseif ( is_tag() ) {
			printf( __( '<h1>Tagged: %s', 'bootstrapwp' ), '<span>' . single_tag_title( '', false ) . '</span></h1><hr>' );
					// Show an optional tag description
			$tag_description = tag_description();
			if ( $tag_description )
				echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
		} elseif ( is_category() ) {
			printf( __( '<h1>%s', 'bootstrapwp' ), '<span>' . single_cat_title( '', false ) . '</span></h1><hr>' );
					// Show an optional category description
			$category_description = category_description();
			if ( $category_description )
				echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
		} else {
			_e( '<div class="row forty"></div>', 'bootstrapwp' );
		}
		?>
</header>

<div class="row content">
	<div class="span8">
		<?php while ( have_posts() ) : the_post(); ?>
		<div <?php post_class(); ?>>
						
			<div class="row">
				        <div class="span3">
                            <div class="pop">
                            
          <?php // output rating
		if (get_field("rating") && in_category('reviews')) {
		 $origrating = get_field("rating");
		 ?>
         <div class="drated">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
          					<?php the_post_thumbnail('medium'); // array('class' => 'pop') ?></a>
                <div class="rating-chart">
                    <div class="percentage-dark" data-percent="<?php echo $origrating*10; ?>"><?php echo number_format($origrating,1); ?></div>
                </div>
          </div>
         <?php } else { ?>  
         					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
          					<?php the_post_thumbnail('medium'); // array('class' => 'pop') ?></a>
         <?php } ?>                  
                        	</div>                     
				        </div><!-- /.span2 -->
				        <div class="span5">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h3><?php the_title();?></h3></a>
						<p class="meta"><?php echo bootstrapwp_posted_on();?> in <?php
$categories = get_the_category();
$seperator = ' ';
$output = '';
if($categories){
	foreach($categories as $category) {
		$output .= '<a href="'.get_category_link($category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$seperator;
	}
echo trim($output, $seperator);
}
?></p>
				        	<?php the_excerpt();?>
				        </div><!-- /.span6 -->
				    </div><!-- /.row -->
				    <hr />
				</div><!-- /.post_class -->
			<?php endwhile; ?>
			<?php bootstrapwp_content_nav('nav-below');?>

		</div><!-- /.span8 -->
		<?php get_sidebar('blog'); ?>

		<?php get_footer(); ?>