<?php
/**
 * The sidebar for shop page
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Moller_Theme
 * @since Moller 1.0
 */
$moller_opt = get_option( 'moller_opt' );
$shopsidebar = 'left';
if(isset($moller_opt['sidebarshop_pos']) && $moller_opt['sidebarshop_pos']!=''){
	$shopsidebar = $moller_opt['sidebarshop_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$shopsidebar = $_GET['sidebar'];
}
$moller_shop_sidebar_extra_class = NULl;
if($shopsidebar=='left') {
	$moller_shop_sidebar_extra_class = 'order-lg-first';
}
?>
<?php if ( is_active_sidebar( 'sidebar-shop' ) ) : ?>
	<div id="secondary" class="col-12 col-lg-3 sidebar-shop <?php echo esc_attr($moller_shop_sidebar_extra_class);?>">
		<div class="secondary-inner">
			<?php dynamic_sidebar( 'sidebar-shop' ); ?>
		</div>
	</div>
<?php endif; ?>