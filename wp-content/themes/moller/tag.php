<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
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
<div class="main-container page-wrapper">
	<div class="title-breadcumbs">
		<div class="container">
			<header class="entry-header">
				<h2 class="entry-title"><?php the_archive_title(); ?></h2>
			</header>
			<div class="breadcrumb-container">
				<?php Moller_Features::moller_breadcrumb(); ?> 
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 <?php echo 'col-lg-'.$moller_blogcolclass; ?> <?php echo ''.$main_column_class; ?> <?php echo esc_attr($moller_blog_main_extra_class);?>">
				<div class="page-content blogs blog-page <?php echo esc_attr($moller_blogclass); if($moller_blogsidebar=='left') {echo ' left-sidebar'; } if($moller_blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php if ( have_posts() ) : ?>
						<?php if ( tag_description() ) : // Show an optional tag description ?>
							<div class="archive-header">
								<h2 class="archive-title"><?php printf( wp_kses(__( 'Tag Archives: %s', 'moller' ), array('span'=>array())), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h2>
								<div class="archive-meta"><?php echo tag_description(); ?></div>
							</div><!-- .archive-header -->
						<?php endif; ?>
						<div class="post-container">
							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();
								/*
								 * Include the post format-specific template for the content. If you want to
								 * this in a child theme then include a file called called content-___.php
								 * (where ___ is the post format) and that will be used instead.
								 */
								get_template_part( 'content', get_post_format() );
							endwhile;
							?>
						</div>
						<?php Moller_Features::moller_pagination(); ?>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
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