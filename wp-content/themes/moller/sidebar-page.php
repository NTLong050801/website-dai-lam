<?php
/**
 * The sidebar for content page
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Moller_Theme
 * @since Moller 1.0
 */
$moller_opt = get_option( 'moller_opt' );
$moller_page_sidebar_extra_class = NULl;
if(!empty($moller_opt['sidebarse_pos'])) {
	if( $moller_opt['sidebarse_pos']=='left' ) {
		$moller_page_sidebar_extra_class = 'order-lg-first';
	}
}
?>
<?php if ( is_active_sidebar( 'sidebar-page' ) ) : ?>
<div id="secondary" class="col-12 col-lg-3 <?php echo esc_attr($moller_page_sidebar_extra_class);?>">
	<?php dynamic_sidebar( 'sidebar-page' ); ?>
</div>
<?php endif; ?>