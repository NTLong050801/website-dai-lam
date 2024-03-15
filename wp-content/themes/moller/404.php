<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Moller_Theme
 * @since Moller 1.0
 */
$moller_opt = get_option( 'moller_opt' );
get_header();
?>
<div class="main-container error404">
	<div class="container">
		<div class="search-form-wrapper">
			<h2><?php esc_html_e( "OOPS! PAGE NOT BE FOUND", 'moller' ); ?></h2>
			<p class="home-link"><?php esc_html_e( "Sorry but the page you are looking for does not exist, has been removed, changed or is temporarity unavailable.", 'moller' ); ?></p>
			<?php get_search_form(); ?>
			<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr__( 'Back to home', 'moller' ); ?>"><?php esc_html_e( 'Back to home page', 'moller' ); ?></a>
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