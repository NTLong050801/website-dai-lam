<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Moller_Theme
 * @since Moller 1.0
 */
$moller_opt = get_option( 'moller_opt' );
$moller_blogsidebar = 'right';
if(isset($moller_opt['sidebarblog_pos']) && $moller_opt['sidebarblog_pos']!=''){
	$moller_blogsidebar = $moller_opt['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$moller_blogsidebar = $_GET['sidebar'];
}
$moller_blog_sidebar_extra_class = NULl;
if($moller_blogsidebar=='left') {
	$moller_blog_sidebar_extra_class = 'order-lg-first';
}
?>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="secondary" class="col-12 col-lg-3 <?php echo esc_attr($moller_blog_sidebar_extra_class);?>">
		<div class="secondary-inner">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	</div><!-- #secondary -->
<?php endif; ?>