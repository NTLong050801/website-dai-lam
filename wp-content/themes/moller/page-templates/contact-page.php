<?php
/**
 * Template Name: Contact Template
 *
 * Description: Contact page Template
 *
 * @package WordPress
 * @subpackage Moller_Theme
 * @since Moller 1.0
 */
$moller_opt = get_option( 'moller_opt' );
get_header();
?>
<div class="main-container contact-page">
	<div class="title-breadcumbs">
		<div class="container">
			<header class="entry-header">
				<h2 class="entry-title"><?php the_title(); ?></h2>
			</header>
			<div class="breadcrumb-container">
				<?php Moller_Features::moller_breadcrumb(); ?> 
			</div>
		</div>
	</div>
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="entry-content">
			<div class="container">
				<?php the_content(); ?>
			</div>
		</div><!-- .entry-content -->
	<?php endwhile; // end of the loop. ?>
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
<?php get_footer('contact'); ?>