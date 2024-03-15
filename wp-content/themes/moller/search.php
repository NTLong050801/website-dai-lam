<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Moller_Theme
 * @since Moller 1.0
 */
$moller_opt = get_option( 'moller_opt' );
get_header();
$moller_bloglayout = 'sidebar';
if(isset($moller_opt['blog_layout']) && $moller_opt['blog_layout']!=''){
	$moller_bloglayout = $moller_opt['blog_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$moller_bloglayout = $_GET['layout'];
}
$moller_blogsidebar = 'right';
if(isset($moller_opt['sidebarblog_pos']) && $moller_opt['sidebarblog_pos']!=''){
	$moller_blogsidebar = $moller_opt['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$moller_blogsidebar = $_GET['sidebar'];
}
if ( !is_active_sidebar( 'sidebar-1' ) )  {
	$moller_bloglayout = 'nosidebar';
}
$moller_blog_main_extra_class = NULl;
if($moller_blogsidebar=='left') {
	$moller_blog_main_extra_class = 'order-lg-last';
}
$main_column_class = NULL;
switch($moller_bloglayout) {
	case 'sidebar':
		$moller_blogclass = 'blog-sidebar';
		$moller_blogcolclass = 9;
		$main_column_class = 'main-column';
		Moller_Features::moller_post_thumbnail_size('moller-post-thumb');
		break;
	case 'largeimage':
		$moller_blogclass = 'blog-large';
		$moller_blogcolclass = 9;
		$main_column_class = 'main-column';
		Moller_Features::moller_post_thumbnail_size('moller-post-thumbwide');
		break;
	case 'grid':
		$moller_blogclass = 'grid';
		$moller_blogcolclass = 9;
		$main_column_class = 'main-column';
		Moller_Features::moller_post_thumbnail_size('moller-post-thumbwide');
		break;
	default:
		$moller_blogclass = 'blog-nosidebar';
		$moller_blogcolclass = 12;
		$moller_blogsidebar = 'none';
		Moller_Features::moller_post_thumbnail_size('moller-post-thumb');
}
?>
<div class="main-container">
	<div class="title-breadcumbs">
		<div class="container">
			<header class="entry-header">
				<h2 class="entry-title"><?php printf( wp_kses(__( 'Search Results for: %s', 'moller' ), array('span'=>array())), '<span>' . get_search_query() . '</span>' ); ?></h2>
			</header>
			<div class="breadcrumb-container">
				<?php Moller_Features::moller_breadcrumb(); ?> 
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 <?php echo 'col-lg-'.$moller_blogcolclass; ?> <?php echo ''.$main_column_class; ?> <?php echo esc_attr($moller_blog_main_extra_class);?>">
				<div class="page-content blog-page blogs <?php echo esc_attr($moller_blogclass); if($moller_blogsidebar=='left') {echo ' left-sidebar'; } if($moller_blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php if ( have_posts() ) : ?>
						<div class="post-container">
							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', 'search' ); ?>
							<?php endwhile; ?>
						</div>
						<?php Moller_Features::moller_pagination(); ?>
					<?php else : ?>
						<article id="post-0" class="post no-results not-found">
							<header class="entry-header">
								<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'moller' ); ?></h1>
							</header>
							<div class="entry-content">
								<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'moller' ); ?></p>
								<?php get_search_form(); ?>
							</div><!-- .entry-content -->
						</article><!-- #post-0 -->
					<?php endif; ?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<!-- brand logo -->
	<?php 
		if(isset($moller_opt['inner_brand']) && function_exists('moller_brands_shortcode') && shortcode_exists( 'ourbrands' ) ){
			if($moller_opt['inner_brand'] && isset($moller_opt['brand_logos'][0]) && $moller_opt['brand_logos'][0]['thumb']!=null) { ?>
				<div class="inner-brands">
					<div class="container">
						<?php echo do_shortcode('[ourbrands]'); ?>
					</div>
				</div>
			<?php }
		}
	?>
	<!-- end brand logo --> 
</div>
<?php get_footer(); ?>