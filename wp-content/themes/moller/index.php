<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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
				<h2 class="entry-title"><?php if(isset($moller_opt['blog_header_text']) && ($moller_opt['blog_header_text'] !='')) { echo esc_html($moller_opt['blog_header_text']); } else { esc_html_e('Blog', 'moller');}  ?></h2>
			</header>
			<div class="breadcrumb-container">
				<?php Moller_Features::moller_breadcrumb(); ?> 
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 <?php echo 'col-lg-'.$moller_blogcolclass; ?> <?php echo ''.$main_column_class; ?> <?php echo esc_attr($moller_blog_main_extra_class);?>">
				<div class="page-content blog-page blogs <?php echo esc_attr($moller_blogclass); ?>">
					<div class="blog-wrapper">
						<?php if ( have_posts() ) : ?>
							<div class="post-container">
								<?php /* Start the Loop */ ?>
								<?php while ( have_posts() ) : the_post(); ?>
									<?php get_template_part( 'content', get_post_format() ); ?>
								<?php endwhile; ?>
							</div>
							<?php Moller_Features::moller_pagination(); ?>
						<?php else : ?>
							<article id="post-0" class="post no-results not-found">
							<?php if ( current_user_can( 'edit_posts' ) ) :
								// Show a different message to a logged-in user who can add posts.
							?>
								<header class="entry-header">
									<h1 class="entry-title"><?php esc_html_e( 'No posts to display', 'moller' ); ?></h1>
								</header>
								<div class="entry-content">
									<p><?php printf( wp_kses(__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'moller' ), array('a'=>array('href'=>array()))), admin_url( 'post-new.php' ) ); ?></p>
								</div><!-- .entry-content -->
							<?php else :
								// Show the default message to everyone else.
							?>
								<header class="entry-header">
									<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'moller' ); ?></h1>
								</header>
								<div class="entry-content">
									<p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'moller' ); ?></p>
									<?php get_search_form(); ?>
								</div><!-- .entry-content -->
							<?php endif; ?>
							</article><!-- #post-0 -->
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php if($moller_bloglayout!='nosidebar' && is_active_sidebar('sidebar-1')): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
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