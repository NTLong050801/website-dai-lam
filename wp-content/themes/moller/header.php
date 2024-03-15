<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Moller_Theme
 * @since Moller1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php $moller_opt = get_option( 'moller_opt' ); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<div class="wrapper">
	<div class="page-wrapper">
		<?php 
			if(isset($moller_opt['header_layout']) && $moller_opt['header_layout']!=''){
				$header_class = str_replace(' ', '-', strtolower($moller_opt['header_layout']));
			} else {
				$header_class = '';
			} 
			if( (class_exists('RevSliderFront')) && (is_front_page() && has_shortcode( $post->post_content, 'rev_slider_vc')) ) {
				$hasSlider_class = 'rs-active';
			} else {
				$hasSlider_class = '';
			}
			if( isset($moller_opt['header_mobile_layout']) && $moller_opt['header_mobile_layout'] != "") {
				$hasMobileLayout_class = 'has-mobile-layout';
			} else {
				$hasMobileLayout_class = '';
			}
		?>
		<div class="header-container <?php echo esc_attr($header_class)." ".esc_attr($hasSlider_class) ." ".esc_attr($hasMobileLayout_class) ?>">
			<div class="header">
				<div class="header-content">
					<?php
					if ( isset($moller_opt['header_layout']) && $moller_opt['header_layout'] != "") { 
						$jscomposer_templates_args = array(
							'orderby'          => 'title',
							'order'            => 'ASC',
							'post_type'        => 'templatera',
							'post_status'      => 'publish',
							'posts_per_page'   => 30,
						);
						$jscomposer_templates = get_posts( $jscomposer_templates_args );
						if(count($jscomposer_templates) > 0) {
							foreach($jscomposer_templates as $jscomposer_template){
								if($jscomposer_template->post_title == $moller_opt['header_layout']){ ?>
									<div class="header-composer">
										<div class="container">
											<?php 
												echo do_shortcode(apply_filters( 'the_content', $jscomposer_template->post_content ));
											?>
										</div>
									</div>
								<?php }
							}
						}
						// header sticky
						if ( isset($moller_opt['sticky_header']) && $moller_opt['sticky_header']) {
							if(count($jscomposer_templates) > 0) {
								foreach($jscomposer_templates as $jscomposer_template){
									if($jscomposer_template->post_title == $moller_opt['header_sticky_layout']){ ?>
										<div class="header-sticky <?php if ( is_admin_bar_showing() ) {echo 'with-admin-bar';} ?>">
											<div class="container">
												<?php 
													echo do_shortcode(apply_filters( 'the_content', $jscomposer_template->post_content ));
												?>
											</div>
										</div>
									<?php }
								}
							}
						}
						// header mobile
						if ( isset($moller_opt['header_mobile_layout']) && $moller_opt['header_mobile_layout'] != "") {
							if(count($jscomposer_templates) > 0) {
								foreach($jscomposer_templates as $jscomposer_template){
									if($jscomposer_template->post_title == $moller_opt['header_mobile_layout']){ ?>
										<div class="header-mobile">
											<div class="container">
												<?php 
													echo do_shortcode(apply_filters( 'the_content', $jscomposer_template->post_content ));
												?>
											</div>
										</div>
									<?php }
								}
							}
						}
					} else { ?>
						<div class="header-default">
							<div class="container">
								<div class="row">
									<div class="header-menu-logo sidebar-container col-9 col-lg-3 col-xl-3">
										<?php if ( has_nav_menu( 'mobilemenu' ) ) : ?>
											<div class="visible-small mobile-menu">
												<div class="mbmenu-toggler open-sidebar"><?php if ( isset($moller_opt['mobile_menu_label']) ) { echo esc_html($moller_opt['mobile_menu_label']); } else { esc_html_e('Menu', 'moller'); } ?><span class="mbmenu-icon"><i class="ion-navicon-round"></i></span></div>
												<div class="sidebar-mobile"> 
													<div class="close-sidebar"><?php esc_html_e('Close', 'moller'); ?></div>
													<div class="mobile-menu-content">
														<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
										<?php endif; ?>
										<?php if( isset($moller_opt['logo_main']['url']) && $moller_opt['logo_main']['url']!=''){ ?>
											<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($moller_opt['logo_main']['url']); ?>" alt=" <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ) ?> " /></a></div>
										<?php } else { ?>
											<h1 class="logo site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
										<?php } ?>
									</div>
									<div class="col-3 col-lg-9 col-xl-9">
										<div class="header-menu-icon">
											<div class="main-menu-wrapper">
												<?php if ( has_nav_menu( 'primary' ) ) : ?>
													<div class="horizontal-menu visible-large">
														<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
													</div>
												<?php endif; ?>
											</div>
											<div class="header-search">
												<div class="search-dropdown">
													<div class="search-click"></div>
													<?php get_search_form(); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>