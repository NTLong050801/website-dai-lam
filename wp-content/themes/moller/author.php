<?php
/**
 * The template for displaying Author Archive pages
 *
 * Used to display archive-type pages for posts by an author.
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
				<header class="entry-header">
					<h2 class="entry-title"><?php the_archive_title(); ?></h2>
				</header>
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
						<?php
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							 *
							 * We reset this later so we can run the loop
							 * properly with a call to rewind_posts().
							 */
							the_post();
						?>
						<?php
						// If a user has filled out their description, show a bio on their entries.
						if ( get_the_author_meta( 'description' ) ) : ?>
							<div class="archive-header">
								<h3 class="archive-title"><?php printf( esc_html__( 'Author Archives: %s', 'moller' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '">' . get_the_author() . '</a></span>' ); ?></h3>
								<div class="author-info archives">
									<div class="author-avatar">
										<?php
										/**
										 * Filter the author bio avatar size.
										 *
										 * @since Moller 1.0
										 *
										 * @param int $size The height and width of the avatar in pixels.
										 */
										$author_bio_avatar_size = apply_filters( 'moller_author_bio_avatar_size', 68 );
										echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
										?>
									</div><!-- .author-avatar -->
									<div class="author-description">
										<h2><?php printf( esc_html__( 'About %s', 'moller' ), get_the_author() ); ?></h2>
										<p><?php the_author_meta( 'description' ); ?></p>
									</div><!-- .author-description	-->
								</div><!-- .author-info -->
							</div><!-- .archive-header -->
						<?php endif; ?>
						<?php
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();
						?>
						<div class="post-container">
							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', get_post_format() ); ?>
							<?php endwhile; ?>
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