<?php
/**
 * Moller functions and definitions
 */
/**
* Require files
*/
	//Init the Redux Framework
if ( class_exists( 'ReduxFramework' ) && !isset( $redux_demo ) && file_exists( get_template_directory().'/theme-config.php' ) ) {
	require_once( get_template_directory().'/theme-config.php' );
}
	// Theme files
if ( file_exists( get_template_directory().'/include/wooajax.php' ) ) {
	require_once( get_template_directory().'/include/wooajax.php' );
}
if ( file_exists( get_template_directory().'/include/map_shortcodes.php' ) ) {
	require_once( get_template_directory().'/include/map_shortcodes.php' );
}
if ( file_exists( get_template_directory().'/include/shortcodes.php' ) ) {
	require_once( get_template_directory().'/include/shortcodes.php' );
}
define('PLUGIN_REQUIRED_PATH','http://roadthemes.com/plugins');
Class Moller_Features {
	/**
	* Global values
	*/
	static function moller_post_odd_event(){
		global $wp_session;
		if(!isset($wp_session["moller_postcount"])){
			$wp_session["moller_postcount"] = 0;
		}
		$wp_session["moller_postcount"] = 1 - $wp_session["moller_postcount"];
		return $wp_session["moller_postcount"];
	}
	static function moller_post_thumbnail_size($size){
		global $wp_session;
		if(!empty($size)){
			$wp_session["moller_postthumb"] = $size;
			return $wp_session["moller_postthumb"];
		} 
	}
	static function moller_shop_class($class){
		global $wp_session;
		if($class!=''){
			$wp_session["moller_shopclass"] = $class;
		}
		return $wp_session["moller_shopclass"];
	}
	static function moller_show_view_mode(){
		$moller_opt = get_option( 'moller_opt' );
		$moller_viewmode = 'grid-view'; //default value
		if(isset($moller_opt['default_view'])) {
			$moller_viewmode = $moller_opt['default_view'];
		}
		if(isset($_GET['view']) && $_GET['view']!=''){
			$moller_viewmode = $_GET['view'];
		}
		return $moller_viewmode;
	}
	static function moller_shortcode_products_count(){
		global $wp_session;
		$moller_productsfound = 0;
		if(isset($wp_session["moller_productsfound"])){
			$moller_productsfound = $wp_session["moller_productsfound"];
		}
		return $moller_productsfound;
	}
	/**
	* Constructor
	*/
	function __construct() {
		// Register action/filter callbacks
		//WooCommerce - action/filter
		add_theme_support( 'woocommerce' );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
		add_filter( 'get_product_search_form', array($this, 'moller_woo_search_form'));
		add_filter( 'woocommerce_shortcode_products_query', array($this, 'moller_woocommerce_shortcode_count'));
		add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
		    return array(
		        'width'  => 150,
		        'height' => 150,
		        'crop'   => 1,
		    );
		} );
		//move message to top
		remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
		add_action( 'woocommerce_show_message', 'wc_print_notices', 10 );
		//remove add to cart button after item
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
		add_action( 'moller_cart_totals', 'woocommerce_cart_totals', 5 );
		//Theme actions
		add_action( 'after_setup_theme', array($this, 'moller_setup'));
		add_action( 'wp_enqueue_scripts', array($this, 'moller_scripts_styles') );
		add_action( 'wp_head', array($this, 'moller_custom_code_header'));
		add_action( 'widgets_init', array($this, 'moller_widgets_init'));
		add_action( 'save_post', array($this, 'moller_save_meta_box_data'));
		add_action('comment_form_before_fields', array($this, 'moller_before_comment_fields'));
		add_action('comment_form_after_fields', array($this, 'moller_after_comment_fields'));
		add_action( 'customize_register', array($this, 'moller_customize_register'));
		add_action( 'customize_preview_init', array($this, 'moller_customize_preview_js'));
		add_action('admin_enqueue_scripts', array($this, 'moller_admin_style'));
		//Theme filters
		add_filter( 'loop_shop_per_page', array($this, 'moller_woo_change_per_page'), 20 );
		add_filter( 'woocommerce_output_related_products_args', array($this, 'moller_woo_related_products_limit'));
		add_filter( 'get_search_form', array($this, 'moller_search_form'));
		add_filter('excerpt_more', array($this, 'moller_new_excerpt_more'));
		add_filter( 'excerpt_length', array($this, 'moller_change_excerpt_length'), 999 );
		add_filter('wp_nav_menu_objects', array($this, 'moller_first_and_last_menu_class'));
		add_filter( 'wp_page_menu_args', array($this, 'moller_page_menu_args'));
		add_filter('dynamic_sidebar_params', array($this, 'moller_widget_first_last_class'));
		add_filter('dynamic_sidebar_params', array($this, 'moller_mega_menu_widget_change'));
		add_filter( 'dynamic_sidebar_params', array($this, 'moller_put_widget_content'));
		add_filter( 'the_content_more_link', array($this, 'moller_modify_read_more_link'));
		//Adding theme support
		if ( ! isset( $content_width ) ) {
			$content_width = 625;
		}
	}
	/**
	* Filter callbacks
	* ----------------
	*/
	// read more link 
	function moller_modify_read_more_link() {
		$moller_opt = get_option( 'moller_opt' );
		if(isset($moller_opt['readmore_text']) && $moller_opt['readmore_text'] != ''){
			$readmore_text = esc_html($moller_opt['readmore_text']);
		} else { 
			$readmore_text = esc_html__('Read more','moller');
		};
	    return '<div><a class="readmore" href="'. get_permalink().' ">'.$readmore_text.'</a></div>';
	}
	// Change products per page
	function moller_woo_change_per_page() {
		$moller_opt = get_option( 'moller_opt' );
		return $moller_opt['product_per_page'];
	}
	//Change number of related products on product page. Set your own value for 'posts_per_page'
	function moller_woo_related_products_limit( $args ) {
		global $product;
		$moller_opt = get_option( 'moller_opt' );
		$args['posts_per_page'] = $moller_opt['related_amount'];
		return $args;
	}
	// Count number of products from shortcode
	function moller_woocommerce_shortcode_count( $args ) {
		$moller_productsfound = new WP_Query($args);
		$moller_productsfound = $moller_productsfound->post_count;
		global $wp_session;
		$wp_session["moller_productsfound"] = $moller_productsfound;
		return $args;
	}
	//Change search form
	function moller_search_form( $form ) {
		if(get_search_query()!=''){
			$search_str = get_search_query();
		} else {
			$search_str = esc_html__( 'Search... ', 'moller' );
		}
		$form = '<form role="search" method="get" class="searchform blogsearchform" action="' . esc_url(home_url( '/' ) ). '" >
		<div class="form-input">
			<input type="text" placeholder="'.esc_attr($search_str).'" name="s" class="input_text ws">
			<button class="button-search searchsubmit blogsearchsubmit" type="submit">' . esc_html__('Search', 'moller') . '</button>
			<input type="hidden" name="post_type" value="post" />
			</div>
		</form>';
		return $form;
	}
	//Change woocommerce search form
	function moller_woo_search_form( $form ) {
		global $wpdb;
		if(get_search_query()!=''){
			$search_str = get_search_query();
		} else {
			$search_str = esc_html__( 'Search product...', 'moller' );
		}
		$form = '<form role="search" method="get" class="searchform productsearchform" action="'.esc_url( home_url( '/'  ) ).'">';
			$form .= '<div class="form-input">';
				$form .= '<input type="text" placeholder="'.esc_attr($search_str).'" name="s" class="ws"/>';
				$form .= '<button class="button-search searchsubmit productsearchsubmit" type="submit">' . esc_html__('Search', 'moller') . '</button>';
				$form .= '<input type="hidden" name="post_type" value="product" />';
			$form .= '</div>';
		$form .= '</form>';
		return $form;
	}
	// Replaces the excerpt "more" text by a link
	function moller_new_excerpt_more($more) {
		return '';
	}
	//Change excerpt length
	function moller_change_excerpt_length( $length ) {
		$moller_opt = get_option( 'moller_opt' );
		if(isset($moller_opt['excerpt_length'])){
			return $moller_opt['excerpt_length'];
		}
		return 50;
	}
	//Add 'first, last' class to menu
	function moller_first_and_last_menu_class($items) {
		$items[1]->classes[] = 'first';
		$items[count($items)]->classes[] = 'last';
		return $items;
	}
	/**
	 * Filter the page menu arguments.
	 *
	 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
	 *
	 * @since Moller 1.0
	 */
	function moller_page_menu_args( $args ) {
		if ( ! isset( $args['show_home'] ) )
			$args['show_home'] = true;
		return $args;
	}
	//Add first, last class to widgets
	function moller_widget_first_last_class($params) {
		global $my_widget_num;
		$class = '';
		$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
		$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	
		if(!$my_widget_num) {// If the counter array doesn't exist, create it
			$my_widget_num = array();
		}
		if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
			return $params; // No widgets in this sidebar... bail early.
		}
		if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
			$my_widget_num[$this_id] ++;
		} else { // If not, create it starting with 1
			$my_widget_num[$this_id] = 1;
		}
		if($my_widget_num[$this_id] == 1) { // If this is the first widget
			$class .= ' widget-first ';
		} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
			$class .= ' widget-last ';
		}
		$params[0]['before_widget'] = str_replace('first_last', ' '.$class.' ', $params[0]['before_widget']);
		return $params;
	}
	//Change mega menu widget from div to li tag
	function moller_mega_menu_widget_change($params) {
		$sidebar_id = $params[0]['id'];
		$pos = strpos($sidebar_id, '_menu_widgets_area_');
		if ( !$pos == false ) {
			$params[0]['before_widget'] = '<li class="widget_mega_menu">'.$params[0]['before_widget'];
			$params[0]['after_widget'] = $params[0]['after_widget'].'</li>';
		}
		return $params;
	}
	// Push sidebar widget content into a div
	function moller_put_widget_content( $params ) {
		global $wp_registered_widgets;
		if( $params[0]['id']=='sidebar-category' ){
			$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
			$settings = $settings_getter->get_settings();
			$settings = $settings[ $params[1]['number'] ];
			if($params[0]['widget_name']=="Text" && isset($settings['title']) && $settings['text']=="") { // if text widget and no content => don't push content
				return $params;
			}
			if( isset($settings['title']) && $settings['title']!='' ){
				$params[0][ 'after_title' ] .= '<div class="widget_content">';
				$params[0][ 'after_widget' ] = '</div>'.$params[0][ 'after_widget' ];
			} else {
				$params[0][ 'before_widget' ] .= '<div class="widget_content">';
				$params[0][ 'after_widget' ] = '</div>'.$params[0][ 'after_widget' ];
			}
		}
		return $params;
	}
	/**
	* Action hooks
	* ----------------
	*/
	/**
	 * Moller setup.
	 *
	 * Sets up theme defaults and registers the various WordPress features that
	 * Moller supports.
	 *
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_editor_style() To add a Visual Editor stylesheet.
	 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
	 * 	custom background, and post formats.
	 * @uses register_nav_menu() To add support for navigation menus.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 *
	 * @since Moller 1.0
	 */
	function moller_setup() {
		/*
		 * Makes Moller available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Moller, use a find and replace
		 * to change 'moller' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'moller', get_template_directory() . '/languages' );
		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();
		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );
		// This theme supports a variety of post formats.
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );
		// Register menus
		register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'moller' ) );
		register_nav_menu( 'stickymenu', esc_html__( 'Sticky Menu', 'moller' ) );
		register_nav_menu( 'mobilemenu', esc_html__( 'Mobile Menu', 'moller' ) );
		register_nav_menu( 'categories', esc_html__( 'Categories Menu', 'moller' ) );
		/*
		 * This theme supports custom background color and image,
		 * and here we also set up the default background color.
		 */
		add_theme_support( 'custom-background', array(
			'default-color' => 'e6e6e6',
		) );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		// This theme uses a custom image size for featured images, displayed on "standard" posts.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1170, 9999 ); // Unlimited height, soft crop
		add_image_size( 'moller-category-thumb', 1170, 743, true ); // (cropped) (post carousel)
		add_image_size( 'moller-post-thumb', 700, 445, true ); // (cropped) (blog sidebar)
		add_image_size( 'moller-post-thumbwide', 1170, 743, true ); // (cropped) (blog large img)
		add_image_size( 'moller-post-thumb-related-post', 450, 215 ); // (cropped) (blog large img)
	}
	/**
	 * Enqueue scripts and styles for front-end.
	 *
	 * @since Moller 1.0
	 */
	function moller_scripts_styles() {
		global $wp_styles, $wp_scripts;
		$moller_opt = get_option( 'moller_opt' );
		if(function_exists("vc_asset_url")){
			wp_enqueue_script( 'wpb_composer_front_js', vc_asset_url( 'js/dist/js_composer_front.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true );
		}
		/*
		 * Adds JavaScript to pages with the comment form to support
		 * sites with threaded comments (when in use).
		*/
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		// Add Bootstrap JavaScript
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.1.1', true );
		// Add Owl files
		wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '2.3.4', true );
		wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '2.3.4' );
		// Add Chosen js files
		wp_enqueue_script( 'jquery-chosen', get_template_directory_uri() . '/js/chosen/chosen.jquery.min.js', array('jquery'), '1.3.0', true );
		wp_enqueue_script( 'jquery-chosen-proto', get_template_directory_uri() . '/js/chosen/chosen.proto.min.js', array('jquery'), '1.3.0', true );
		wp_enqueue_style( 'chosen', get_template_directory_uri() . '/js/chosen/chosen.min.css', array(), '1.3.0' );
		// Add parallax script files
		// Add Fancybox
		wp_enqueue_script( 'jquery-fancybox-pack', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.pack.js', array('jquery'), '2.1.5', true );
		wp_enqueue_script( 'jquery-fancybox-buttons', get_template_directory_uri().'/js/fancybox/helpers/jquery.fancybox-buttons.js', array('jquery'), '1.0.5', true );
		wp_enqueue_script( 'jquery-fancybox-media', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-media.js', array('jquery'), '1.0.6', true );
		wp_enqueue_script( 'jquery-fancybox-thumbs', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-thumbs.js', array('jquery'), '1.0.7', true );
		wp_enqueue_style( 'jquery-fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css', array(), '2.1.5' );
		wp_enqueue_style( 'jquery-fancybox-buttons', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-buttons.css', array(), '1.0.5' );
		wp_enqueue_style( 'jquery-fancybox-thumbs', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-thumbs.css', array(), '1.0.7' );
		//Superfish
		wp_enqueue_script( 'jquery-superfish', get_template_directory_uri() . '/js/superfish/superfish.min.js', array('jquery'), '1.3.15', true );
		//Add Shuffle js
		wp_enqueue_script( 'jquery-modernizr-custom', get_template_directory_uri() . '/js/modernizr.custom.min.js', array('jquery'), '2.6.2', true );
		wp_enqueue_script( 'jquery-shuffle', get_template_directory_uri() . '/js/jquery.shuffle.min.js', array('jquery'), '3.0.0', true );
		//Add mousewheel
		wp_enqueue_script( 'jquery-mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', array('jquery'), '3.1.12', true );
		// Add jQuery countdown file
		wp_enqueue_script( 'jquery-countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), '2.0.4', true );
		// Add jQuery counter files
		wp_enqueue_script( 'jquery-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'jquery-counterup', get_template_directory_uri() . '/js/jquery.counterup.min.js', array('jquery'), '1.0', true );
		// Add variables.js file
		wp_enqueue_script( 'moller-variables', get_template_directory_uri() . '/js/variables.js', array('jquery'), time(), true );
		wp_enqueue_script( 'moller-theme', get_template_directory_uri() . '/js/theme.js', array('jquery'), time(), true );
		$font_url = $this->moller_get_font_url();
		if ( ! empty( $font_url ))
			wp_enqueue_style( 'moller-fonts', esc_url_raw( $font_url ), array(), null );
		// Loads our main stylesheet.
		wp_enqueue_style( 'moller-style', get_stylesheet_uri() );
		// Mega Main Menu
		wp_enqueue_style( 'megamenu-style', get_template_directory_uri() . '/css/megamenu_style.css', array(), '2.0.4');
		// Load ionicons css
		wp_enqueue_style( 'ionicons', get_template_directory_uri() . '/css/ionicons.min.css', array(), '2.0.0');
		// Load fontawesome css
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0');
		// Load bootstrap css
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.1.1');
		// Compile Less to CSS
		$previewpreset = (isset($_REQUEST['preset']) ? $_REQUEST['preset'] : null);
		// get preset from url (only for demo/preview)
		if($previewpreset){
			$_SESSION["preset"] = $previewpreset;
		}
		$presetopt = 1; /* change default preset 1 and 209 */
		if(!isset($_SESSION["preset"])){
			$_SESSION["preset"] = 1;
		}
		if($_SESSION["preset"] != 1) {
			$presetopt = $_SESSION["preset"];
		} else { /* if no preset varialbe found in url, use from theme options */
			if(isset($moller_opt['preset_option'])){
				$presetopt = $moller_opt['preset_option'];
			}
		}
		if(!isset($presetopt)) $presetopt = 1; /* in case first time install theme, no options found */
		if(isset($moller_opt['enable_less'])){
			if($moller_opt['enable_less']){
				$themevariables = array(
					'body_font'=> $moller_opt['bodyfont']['font-family'],
					'body_font_backup'=> $moller_opt['bodyfont']['font-backup'],
					'text_color'=> $moller_opt['bodyfont']['color'],
					'text_selected_bg' => $moller_opt['text_selected_bg'],
					'text_selected_color' => $moller_opt['text_selected_color'],
					'text_size'=> $moller_opt['bodyfont']['font-size'],
					'border_color'=> $moller_opt['border_color']['border-color'],
					'page_content_background' => $moller_opt['page_content_background']['background-color'],
					'row_space' => $moller_opt['row_space'],
					'row_container' => $moller_opt['row_container'],
					'heading_font'=> $moller_opt['headingfont']['font-family'],
					'heading_color'=> $moller_opt['headingfont']['color'],
					'heading_font_weight'=> $moller_opt['headingfont']['font-weight'],
					'dropdown_font'=> $moller_opt['dropdownfont']['font-family'],
					'dropdown_color'=> $moller_opt['dropdownfont']['color'],
					'dropdown_font_size'=> $moller_opt['dropdownfont']['font-size'],
					'dropdown_font_weight'=> $moller_opt['dropdownfont']['font-weight'],
					'dropdown_bg' => $moller_opt['dropdown_bg'],
					'menu_font'=> $moller_opt['menufont']['font-family'],
					'menu_color'=> $moller_opt['menufont']['color'],
					'menu_font_size'=> $moller_opt['menufont']['font-size'],
					'menu_font_weight'=> $moller_opt['menufont']['font-weight'],
					'sub_menu_font'=> $moller_opt['submenufont']['font-family'],
					'sub_menu_color'=> $moller_opt['submenufont']['color'],
					'sub_menu_font_size'=> $moller_opt['submenufont']['font-size'],
					'sub_menu_font_weight'=> $moller_opt['submenufont']['font-weight'],
					'sub_menu_bg' => $moller_opt['sub_menu_bg'],
					'categories_font'=> $moller_opt['categoriesfont']['font-family'],
					'categories_font_size'=> $moller_opt['categoriesfont']['font-size'],
					'categories_font_weight'=> $moller_opt['categoriesfont']['font-weight'],
					'categories_color'=> $moller_opt['categoriesfont']['color'],
					'categories_menu_bg' => $moller_opt['categories_menu_bg'],
					'categories_sub_menu_font'=> $moller_opt['categoriessubmenufont']['font-family'],
					'categories_sub_menu_font_size'=> $moller_opt['categoriessubmenufont']['font-size'],
					'categories_sub_menu_font_weight'=> $moller_opt['categoriessubmenufont']['font-weight'],
					'categories_sub_menu_color'=> $moller_opt['categoriessubmenufont']['color'],
					'categories_sub_menu_bg' => $moller_opt['categories_sub_menu_bg'],
					'link_color' => $moller_opt['link_color']['regular'],
					'link_hover_color' => $moller_opt['link_color']['hover'],
					'link_active_color' => $moller_opt['link_color']['active'],
					'primary_color' => $moller_opt['primary_color'],
					'menu_hover_itemlevel1_color' => $moller_opt['menu_hover_itemlevel1_color'],
					'sale_color' => $moller_opt['sale_color'],
					'saletext_color' => $moller_opt['saletext_color'],
					'rate_color' => $moller_opt['rate_color'],
					'price_font'=> $moller_opt['pricefont']['font-family'],
					'price_color'=> $moller_opt['pricefont']['color'],
					'price_font_size'=> $moller_opt['pricefont']['font-size'],
					'price_font_weight'=> $moller_opt['pricefont']['font-weight'],
					'header_color' => $moller_opt['header_color'],
					'header_link_color' => $moller_opt['header_link_color']['regular'],
					'header_link_hover_color' => $moller_opt['header_link_color']['hover'],
					'header_link_active_color' => $moller_opt['header_link_color']['active'],
					'topbar_color' => $moller_opt['topbar_color'],
					'topbar_link_color' => $moller_opt['topbar_link_color']['regular'],
					'topbar_link_hover_color' => $moller_opt['topbar_link_color']['hover'],
					'topbar_link_active_color' => $moller_opt['topbar_link_color']['active'],
					'footer_color' => $moller_opt['footer_color'],
					'footer_title_color' => $moller_opt['footer_title_color'],
					'footer_link_color' => $moller_opt['footer_link_color'],
				);
				if(isset($moller_opt['breadcrumb_bg']['background-color']) && $moller_opt['breadcrumb_bg']['background-color'] !="") {
					$themevariables['breadcrumb_bg'] = $moller_opt['breadcrumb_bg']['background-color'];
				} else {
					$themevariables['breadcrumb_bg'] = '#f6f6f6';
				}
				if(isset($moller_opt['header_sticky_bg']['rgba']) && $moller_opt['header_sticky_bg']['rgba']!="") {
					$themevariables['header_sticky_bg'] = $moller_opt['header_sticky_bg']['rgba'];
				} else {
					$themevariables['header_sticky_bg'] = 'rgba(255, 255, 255, 0.8)';
				}
				if(isset($moller_opt['header_bg']['background-color']) && $moller_opt['header_bg']['background-color']!="") {
					$themevariables['header_bg'] = $moller_opt['header_bg']['background-color'];
				} else {
					$themevariables['header_bg'] = '#fff';
				}
				if(isset($moller_opt['footer_bg']['background-color']) && $moller_opt['footer_bg']['background-color']!="") {
					$themevariables['footer_bg'] = $moller_opt['footer_bg']['background-color'];
				} else {
					$themevariables['footer_bg'] = '#222222';
				}
				switch ($presetopt) {
					case 2:
						break;
					case 3:
						$themevariables['topbar_color'] = '#ffffff';
						break;
					case 4:
						$themevariables['menu_color'] = '#ffffff';
						$themevariables['header_sticky_bg'] = 'rgba(0, 0, 0, 0.8)';
						break;
				}
				if(function_exists('compileLessFile')){
					compileLessFile('theme.less', 'theme'.$presetopt.'.css', $themevariables);
				}
			}
		}
		// Load main theme css style files
		wp_enqueue_style( 'moller-theme', get_template_directory_uri() . '/css/theme'.$presetopt.'.css', array('bootstrap'), time(), 'all');
		wp_enqueue_style( 'moller-opt-css', get_template_directory_uri() . '/css/opt_css.css', array('moller-theme'), '1.0.0');
		if(function_exists('WP_Filesystem')){
			if ( ! WP_Filesystem() ) {
				$url = wp_nonce_url();
				request_filesystem_credentials($url, '', true, false, null);
			}
			global $wp_filesystem;
			//add custom css, sharing code to header
			if($wp_filesystem->exists(get_template_directory(). '/css/opt_css.css')){
				$customcss = $wp_filesystem->get_contents(get_template_directory(). '/css/opt_css.css');
				if(isset($moller_opt['custom_css']) && $customcss!=$moller_opt['custom_css']){ //if new update, write file content
					$wp_filesystem->put_contents(
						get_template_directory(). '/css/opt_css.css',
						$moller_opt['custom_css'],
						FS_CHMOD_FILE // predefined mode settings for WP files
					);
				}
			} else {
				$wp_filesystem->put_contents(
					get_template_directory(). '/css/opt_css.css',
					$moller_opt['custom_css'],
					FS_CHMOD_FILE // predefined mode settings for WP files
				);
			}
		}
		//add javascript variables
		ob_start(); ?>
		"use strict";
		var moller_brandnumber = <?php if(isset($moller_opt['brandnumber'])) { echo esc_js($moller_opt['brandnumber']); } else { echo '6'; } ?>,
			moller_brandscrollnumber = <?php if(isset($moller_opt['brandscrollnumber'])) { echo esc_js($moller_opt['brandscrollnumber']); } else { echo '2';} ?>,
			moller_brandpause = <?php if(isset($moller_opt['brandpause'])) { echo esc_js($moller_opt['brandpause']); } else { echo '3000'; } ?>,
			moller_brandanimate = <?php if(isset($moller_opt['brandanimate'])) { echo esc_js($moller_opt['brandanimate']); } else { echo '700';} ?>;
		var moller_brandscroll = false;
			<?php if(isset($moller_opt['brandscroll'])){ ?>
				moller_brandscroll = <?php echo esc_js($moller_opt['brandscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var moller_categoriesnumber = <?php if(isset($moller_opt['categoriesnumber'])) { echo esc_js($moller_opt['categoriesnumber']); } else { echo '6'; } ?>,
			moller_categoriesscrollnumber = <?php if(isset($moller_opt['categoriesscrollnumber'])) { echo esc_js($moller_opt['categoriesscrollnumber']); } else { echo '2';} ?>,
			moller_categoriespause = <?php if(isset($moller_opt['categoriespause'])) { echo esc_js($moller_opt['categoriespause']); } else { echo '3000'; } ?>,
			moller_categoriesanimate = <?php if(isset($moller_opt['categoriesanimate'])) { echo esc_js($moller_opt['categoriesanimate']); } else { echo '700';} ?>;
		var moller_categoriesscroll = 'false';
			<?php if(isset($moller_opt['categoriesscroll'])){ ?>
				moller_categoriesscroll = <?php echo esc_js($moller_opt['categoriesscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var moller_blogpause = <?php if(isset($moller_opt['blogpause'])) { echo esc_js($moller_opt['blogpause']); } else { echo '3000'; } ?>,
			moller_bloganimate = <?php if(isset($moller_opt['bloganimate'])) { echo esc_js($moller_opt['bloganimate']); } else { echo '700'; } ?>;
		var moller_blogscroll = false;
			<?php if(isset($moller_opt['blogscroll'])){ ?>
				moller_blogscroll = <?php echo esc_js($moller_opt['blogscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var moller_testipause = <?php if(isset($moller_opt['testipause'])) { echo esc_js($moller_opt['testipause']); } else { echo '3000'; } ?>,
			moller_testianimate = <?php if(isset($moller_opt['testianimate'])) { echo esc_js($moller_opt['testianimate']); } else { echo '700'; } ?>;
		var moller_testiscroll = false;
			<?php if(isset($moller_opt['testiscroll'])){ ?>
				moller_testiscroll = <?php echo esc_js($moller_opt['testiscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var moller_catenumber = <?php if(isset($moller_opt['catenumber'])) { echo esc_js($moller_opt['catenumber']); } else { echo '6'; } ?>,
			moller_catescrollnumber = <?php if(isset($moller_opt['catescrollnumber'])) { echo esc_js($moller_opt['catescrollnumber']); } else { echo '2';} ?>,
			moller_catepause = <?php if(isset($moller_opt['catepause'])) { echo esc_js($moller_opt['catepause']); } else { echo '3000'; } ?>,
			moller_cateanimate = <?php if(isset($moller_opt['cateanimate'])) { echo esc_js($moller_opt['cateanimate']); } else { echo '700';} ?>;
		var moller_catescroll = false;
			<?php if(isset($moller_opt['catescroll'])){ ?>
				moller_catescroll = <?php echo esc_js($moller_opt['catescroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var moller_menu_number = <?php if(isset($moller_opt['categories_menu_items'])) { echo esc_js((int)$moller_opt['categories_menu_items']); } else { echo '10';} ?>;
		var moller_sticky_header = false;
			<?php if(isset($moller_opt['sticky_header'])){ ?>
				moller_sticky_header = <?php echo esc_js($moller_opt['sticky_header'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		jQuery(document).ready(function(){
			jQuery(".ws").on('focus', function(){
				if(jQuery(this).val()=="<?php esc_html__( 'Search product...', 'moller');?>"){
					jQuery(this).val("");
				}
			});
			jQuery(".ws").on('focusout', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("<?php esc_html__( 'Search product...', 'moller');?>");
				}
			});
			jQuery(".wsearchsubmit").on('click', function(){
				if(jQuery("#ws").val()=="<?php esc_html__( 'Search product...', 'moller');?>" || jQuery("#ws").val()==""){
					jQuery("#ws").focus();
					return false;
				}
			});
			jQuery(".search_input").on('focus', function(){
				if(jQuery(this).val()=="<?php esc_html__( 'Search...', 'moller');?>"){
					jQuery(this).val("");
				}
			});
			jQuery(".search_input").on('focusout', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("<?php esc_html__( 'Search...', 'moller');?>");
				}
			});
			jQuery(".blogsearchsubmit").on('click', function(){
				if(jQuery("#search_input").val()=="<?php esc_html__( 'Search...', 'moller');?>" || jQuery("#search_input").val()==""){
					jQuery("#search_input").focus();
					return false;
				}
			});
		});
		<?php
		$jsvars = ob_get_contents();
		ob_end_clean();
		if(function_exists('WP_Filesystem')){
			if($wp_filesystem->exists(get_template_directory(). '/js/variables.js')){
				$jsvariables = $wp_filesystem->get_contents(get_template_directory(). '/js/variables.js');
				if($jsvars!=$jsvariables){ //if new update, write file content
					$wp_filesystem->put_contents(
						get_template_directory(). '/js/variables.js',
						$jsvars,
						FS_CHMOD_FILE // predefined mode settings for WP files
					);
				}
			} else {
				$wp_filesystem->put_contents(
					get_template_directory(). '/js/variables.js',
					$jsvars,
					FS_CHMOD_FILE // predefined mode settings for WP files
				);
			}
		}
		//add css for footer, header templates
		$jscomposer_templates_args = array(
			'orderby'          => 'title',
			'order'            => 'ASC',
			'post_type'        => 'templatera',
			'post_status'      => 'publish',
			'posts_per_page'   => 30,
		);
		$jscomposer_templates = get_posts( $jscomposer_templates_args);
		if(count($jscomposer_templates) > 0) {
			foreach($jscomposer_templates as $jscomposer_template){
				if($jscomposer_template->post_title == $moller_opt['header_layout'] || $jscomposer_template->post_title == $moller_opt['footer_layout'] || $jscomposer_template->post_title == $moller_opt['header_mobile_layout'] || $jscomposer_template->post_title == $moller_opt['header_sticky_layout']){
					$jscomposer_template_css = get_post_meta ( $jscomposer_template->ID, '_wpb_shortcodes_custom_css', false);
					if(isset($jscomposer_template_css[0]))
					wp_add_inline_style( 'moller-opt-css', $jscomposer_template_css[0]);
				}
			}
		}
		//page width
		$moller_opt = get_option( 'moller_opt');
		if(isset($moller_opt['box_layout_width'])){
			wp_add_inline_style( 'moller-opt-css', '.wrapper.box-layout {max-width: '.$moller_opt['box_layout_width'].'px;}');
		}
	}
	//add sharing code to header
	function moller_custom_code_header() {
		global $moller_opt;
		if ( isset($moller_opt['share_head_code']) && $moller_opt['share_head_code']!='') {
			echo wp_kses($moller_opt['share_head_code'], array(
				'script' => array(
					'type' => array(),
					'src' => array(),
					'async' => array()
				),
			));
		}
	}
	/**
	 * Register sidebars.
	 *
	 * Registers our main widget area and the front page widget areas.
	 *
	 * @since Moller 1.0
	 */
	function moller_widgets_init() {
		$moller_opt = get_option( 'moller_opt');
		register_sidebar( array(
			'name' => esc_html__( 'Blog Sidebar', 'moller' ),
			'id' => 'sidebar-1',
			'description' => esc_html__( 'Sidebar on blog page', 'moller' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		));
		register_sidebar( array(
			'name' => esc_html__( 'Shop Sidebar', 'moller' ),
			'id' => 'sidebar-shop',
			'description' => esc_html__( 'Sidebar on shop page (only sidebar shop layout)', 'moller' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		));
		register_sidebar( array(
			'name' => esc_html__( 'Single product Sidebar', 'moller' ),
			'id' => 'sidebar-single_product',
			'description' => esc_html__( 'Sidebar on product details page', 'moller' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		));
		register_sidebar( array(
			'name' => esc_html__( 'Pages Sidebar', 'moller' ),
			'id' => 'sidebar-page',
			'description' => esc_html__( 'Sidebar on content pages', 'moller' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		));
		if(isset($moller_opt['custom-sidebars']) && $moller_opt['custom-sidebars']!=""){
			foreach($moller_opt['custom-sidebars'] as $sidebar){
				$sidebar_id = str_replace(' ', '-', strtolower($sidebar));
				if($sidebar_id!='') {
					register_sidebar( array(
						'name' => $sidebar,
						'id' => $sidebar_id,
						'description' => $sidebar,
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget' => '</aside>',
						'before_title' => '<h3 class="widget-title"><span>',
						'after_title' => '</span></h3>',
					));
				}
			}
		}
	}
	static function moller_meta_box_callback( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'moller_meta_box', 'moller_meta_box_nonce');
		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$value = get_post_meta( $post->ID, '_moller_post_intro', true);
		echo '<label for="moller_post_intro">';
		esc_html_e( 'This content will be used to replace the featured image, use shortcode here', 'moller');
		echo '</label><br />';
		wp_editor( $value, 'moller_post_intro', $settings = array());
	}
	static function moller_custom_sidebar_callback( $post ) {
		global $wp_registered_sidebars;
		$moller_opt = get_option( 'moller_opt');
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'moller_meta_box', 'moller_meta_box_nonce');
		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		//show sidebar dropdown select
		$csidebar = get_post_meta( $post->ID, '_moller_custom_sidebar', true);
		echo '<label for="moller_custom_sidebar">';
		esc_html_e( 'Select a custom sidebar for this post/page', 'moller');
		echo '</label><br />';
		echo '<select id="moller_custom_sidebar" name="moller_custom_sidebar">';
			echo '<option value="">'.esc_html__('- None -', 'moller').'</option>';
			foreach($wp_registered_sidebars as $sidebar){
				$sidebar_id = $sidebar['id'];
				if($csidebar == $sidebar_id){
					echo '<option value="'.$sidebar_id.'" selected="selected">'.$sidebar['name'].'</option>';
				} else {
					echo '<option value="'.$sidebar_id.'">'.$sidebar['name'].'</option>';
				}
			}
		echo '</select><br />';
		//show custom sidebar position
		$csidebarpos = get_post_meta( $post->ID, '_moller_custom_sidebar_pos', true);
		echo '<label for="moller_custom_sidebar_pos">';
		esc_html_e( 'Sidebar position', 'moller');
		echo '</label><br />';
		echo '<select id="moller_custom_sidebar_pos" name="moller_custom_sidebar_pos">'; ?>
			<option value="left" <?php if($csidebarpos == 'left') {echo 'selected="selected"';}?>><?php echo esc_html__('Left', 'moller'); ?></option>
			<option value="right" <?php if($csidebarpos == 'right') {echo 'selected="selected"';}?>><?php echo esc_html__('Right', 'moller'); ?></option>
		<?php echo '</select>';
	}
	function moller_save_meta_box_data( $post_id ) {
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */
		// Check if our nonce is set.
		if ( ! isset( $_POST['moller_meta_box_nonce'] ) ) {
			return;
		}
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['moller_meta_box_nonce'], 'moller_meta_box' ) ) {
			return;
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		/* OK, it's safe for us to save the data now. */
		// Make sure that it is set.
		if ( ! ( isset( $_POST['moller_post_intro'] ) || isset( $_POST['moller_custom_sidebar'] ) ) )  {
			return;
		}
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['moller_post_intro']);
		// Update the meta field in the database.
		update_post_meta( $post_id, '_moller_post_intro', $my_data);
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['moller_custom_sidebar']);
		// Update the meta field in the database.
		update_post_meta( $post_id, '_moller_custom_sidebar', $my_data);
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['moller_custom_sidebar_pos']);
		// Update the meta field in the database.
		update_post_meta( $post_id, '_moller_custom_sidebar_pos', $my_data);
	}
	//Change comment form
	function moller_before_comment_fields() {
		echo '<div class="comment-input">';
	}
	function moller_after_comment_fields() {
		echo '</div>';
	}
	/**
	 * Register postMessage support.
	 *
	 * Add postMessage support for site title and description for the Customizer.
	 *
	 * @since Moller 1.0
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	function moller_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
	/**
	 * Enqueue Javascript postMessage handlers for the Customizer.
	 *
	 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
	 *
	 * @since Moller 1.0
	 */
	function moller_customize_preview_js() {
		wp_enqueue_script( 'moller-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true);
	}
	function moller_admin_style() {
	  wp_enqueue_style('moller-admin-styles', get_template_directory_uri().'/css/admin.css');
	}
	/**
	* Utility methods
	* ---------------
	*/
	//Add breadcrumbs
	static function moller_breadcrumb() {
		global $post;
		$moller_opt = get_option( 'moller_opt');
		$brseparator = '<span class="separator">></span>';
		if (!is_home()) {
			echo '<div class="breadcrumbs">';
			echo '<a href="';
			echo esc_url( home_url( '/' ));
			echo '">';
			echo esc_html__('Home', 'moller');
			echo '</a>'.$brseparator;
			if (is_category() || is_single()) {
				$categories = get_the_category();
				if ( count( $categories ) > 0 ) {
					echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
				}
				if (is_single()) {
					if ( count( $categories ) > 0 ) { echo ''.$brseparator; }
					the_title();
				}
			} elseif (is_page()) {
				if($post->post_parent){
					$anc = get_post_ancestors( $post->ID);
					$title = get_the_title();
					foreach ( $anc as $ancestor ) {
						$output = '<a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a>'.$brseparator;
					}
					echo wp_kses($output, array(
							'a'=>array(
								'href' => array(),
								'title' => array()
							),
							'span'=>array(
								'class'=>array()
							)
						)
					);
					echo '<span title="'.esc_attr($title).'"> '.esc_html($title).'</span>';
				} else {
					echo '<span> '.get_the_title().'</span>';
				}
			}
			elseif (is_tag()) {single_tag_title();}
			elseif (is_day()) {printf( esc_html__( 'Archive for: %s', 'moller' ), '<span>' . get_the_date() . '</span>');}
			elseif (is_month()) {printf( esc_html__( 'Archive for: %s', 'moller' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'moller' ) ) . '</span>');}
			elseif (is_year()) {printf( esc_html__( 'Archive for: %s', 'moller' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'moller' ) ) . '</span>');}
			elseif (is_author()) {echo "<span>".esc_html__('Archive for','moller'); echo'</span>';}
			elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>".esc_html__('Blog Archives','moller'); echo'</span>';}
			elseif (is_search()) {echo "<span>".esc_html__('Search Results','moller'); echo'</span>';}
			echo '</div>';
		} else {
			echo '<div class="breadcrumbs">';
			echo '<a href="';
			echo esc_url( home_url( '/' ));
			echo '">';
			echo esc_html__('Home', 'moller');
			echo '</a>'.$brseparator;
			if(isset($moller_opt['blog_header_text']) && $moller_opt['blog_header_text']!=""){
				echo esc_html($moller_opt['blog_header_text']);
			} else {
				echo esc_html__('Blog', 'moller');
			}
			echo '</div>';
		}
	}
	static function moller_limit_string_by_word ($string, $maxlength, $suffix = '') {
		if(function_exists( 'mb_strlen' )) {
			// use multibyte functions by Iysov
			if(mb_strlen( $string )<=$maxlength) return $string;
			$string = mb_substr( $string, 0, $maxlength);
			$index = mb_strrpos( $string, ' ');
			if($index === FALSE) {
				return $string;
			} else {
				return mb_substr( $string, 0, $index ).$suffix;
			}
		} else { // original code here
			if(strlen( $string )<=$maxlength) return $string;
			$string = substr( $string, 0, $maxlength);
			$index = strrpos( $string, ' ');
			if($index === FALSE) {
				return $string;
			} else {
				return substr( $string, 0, $index ).$suffix;
			}
		}
	}
	static function moller_excerpt_by_id($post, $length = 25, $tags = '<a><span><em><strong>') {
		if ( is_numeric( $post ) ) {
			$post = get_post( $post);
		} elseif( ! is_object( $post ) ) {
			return false;
		}
		if ( has_excerpt( $post->ID ) ) {
			$the_excerpt = $post->post_excerpt;
			return apply_filters( 'the_content', $the_excerpt);
		} else {
			$the_excerpt = $post->post_content;
		}
		$the_excerpt = strip_shortcodes( strip_tags( $the_excerpt, $tags ));
		$the_excerpt = preg_split( '/\b/', $the_excerpt, $length * 2 + 1);
		$excerpt_waste = array_pop( $the_excerpt);
		$the_excerpt = implode( $the_excerpt);
		return apply_filters( 'the_content', $the_excerpt);
	}
	/**
	 * Return the Google font stylesheet URL if available.
	 *
	 * The use of Poppins by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * @since Moller 1.0
	 *
	 * @return string Font stylesheet or empty string if disabled.
	 */
	function moller_get_font_url() {
		$fonts_url = '';
		/* Translators: If there are characters in your language that are not
		* supported by Poppins translate this to 'off'. Do not translate
		* into your own language.
		*/
		$poppins = _x( 'on', ' Poppins: on or off', 'moller');
		if ( 'off' !== $poppins ) {
			$font_families[] = 'Poppins:300,400,500,600,700';
		}
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css'); // old https
		return esc_url_raw( $fonts_url);
	}
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Moller 1.0
	 */
	static function moller_content_nav( $html_id ) {
		global $wp_query;
		$html_id = esc_attr( $html_id);
		if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="<?php echo esc_attr($html_id); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'moller'); ?></h3>
				<div class="nav-previous"><?php next_posts_link( wp_kses(__( '<span class="meta-nav">&larr;</span> Older posts', 'moller' ),array('span'=>array('class'=>array())) )); ?></div>
				<div class="nav-next"><?php previous_posts_link( wp_kses(__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'moller' ), array('span'=>array('class'=>array())) )); ?></div>
			</nav>
		<?php endif;
	}
	/* Pagination */
	static function moller_pagination() {
		global $wp_query, $paged;
		if(empty($paged)) $paged = 1;
		$pages = $wp_query->max_num_pages;
			if(!$pages || $pages == '') {
			   	$pages = 1;
			}
		if(1 != $pages) {
			echo '<div class="pagination-container"><div class="pagination">';
			$big = 999999999; // need an unlikely integer
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'prev_text'    => esc_html__('Previous', 'moller'),
				'next_text'    =>esc_html__('Next', 'moller')
			));
			echo '</div></div>';
		}
	}
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own moller_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Moller 1.0
	 */
	static function moller_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>
		<li <?php if ( get_comments( [ 'parent' => get_comment_ID(), 'count' => true ] ) > 0 ) { comment_class('parent'); } else { comment_class(); } ?> id="comment-<?php comment_ID(); ?>">
			<p><?php esc_html_e( 'Pingback:', 'moller'); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'moller' ), '<span class="edit-link">', '</span>'); ?></p>
		<?php
				break;
			default :
			// Proceed with normal comments.
			global $post;
		?>
		<li <?php if ( get_comments( [ 'parent' => get_comment_ID(), 'count' => true ] ) > 0 ) { comment_class('parent'); } else { comment_class(); } ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 50); ?>
					<header class="comment-meta comment-author vcard">
						<?php
							printf( '<time datetime="%1$s">%2$s</time>',
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( esc_html__( '%1$s at %2$s', 'moller' ), get_comment_date('M d.Y'), get_comment_time() )
							);
							printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
								get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
								( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author', 'moller' ) . '</span>' : ''
							);
						?>
					</header><!-- .comment-meta -->
					<?php edit_comment_link( esc_html__( 'Edit', 'moller' ), '<p class="edit-link">', '</p>'); ?>
				</div>
				<div class="comment-info">
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'moller'); ?></p>
					<?php endif; ?>
					<section class="comment-content comment">
						<?php comment_text(); ?>
					</section><!-- .comment-content -->
				</div>
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'moller' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) )); ?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->
		<?php
			break;
		endswitch; // end comment_type check
	}
	/**
	 * Set up post entry meta.
	 *
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own moller_entry_meta() to override in a child theme.
	 *
	 * @since Moller 1.0
	 */
	static function moller_entry_meta() {
		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', '');
		$num_comments = (int)get_comments_number();
		$write_comments = '';
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = esc_html__('0 comments', 'moller');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . esc_html__(' comments', 'moller');
			} else {
				$comments = esc_html__('1 comment', 'moller');
			}
			$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		}
		$utility_text = null;
		if ( ( post_password_required() || !comments_open() ) && ($tag_list != false && isset($tag_list) ) ) {
			$utility_text = '<span>'. esc_html__( 'Tags: ', 'moller') .'</span>'. esc_html__( '%2$s', 'moller');
		} elseif ( $tag_list != false && isset($tag_list) && $num_comments != 0 ) {
			$utility_text = esc_html__( '%1$s', 'moller') .'<span>'. esc_html__( 'Tags: ', 'moller') .'</span>' . esc_html__( '%2$s', 'moller');
		} elseif ( ($num_comments == 0 || !isset($num_comments) ) && $tag_list==true ) {
			$utility_text = '<span>'. esc_html__( 'Tags: ', 'moller') .'</span>'. esc_html__( '%2$s', 'moller');
		} else {
			$utility_text = esc_html__( '%1$s', 'moller');
		}
		if ( ($tag_list != false && isset($tag_list)) || $num_comments != 0 ) { ?>
			<div class="entry-meta">
				<?php printf( $utility_text, null, $tag_list); ?>
			</div>
		<?php }
	}
	static function moller_entry_meta_small() {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list(', ');
		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( wp_kses(__( 'View all posts by %s', 'moller' ), array('a'=>array())), get_the_author() ) ),
			get_the_author()
		);
		$utility_text = esc_html__( 'Posted by %1$s / %2$s', 'moller');
		printf( $utility_text, $author, $categories_list);
	}
	static function moller_entry_comments() {
		$date = sprintf( '<time class="entry-date" datetime="%3$s">%4$s</time>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
		$num_comments = (int)get_comments_number();
		$write_comments = '';
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = wp_kses(__('<span>0</span> comments', 'moller'), array('span'=>array()));
			} elseif ( $num_comments > 1 ) {
				$comments = '<span>'.$num_comments .'</span>'. esc_html__(' comments', 'moller');
			} else {
				$comments = wp_kses(__('<span>1</span> comment', 'moller'), array('span'=>array()));
			}
			$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		}
		$utility_text = esc_html__( '%1$s', 'moller');
		printf( $utility_text, $write_comments);
	}
}
// Instantiate theme
$Moller_Features = new Moller_Features();
//Fix duplicate id of mega menu
function moller_mega_menu_id_change($params) {
	ob_start('moller_mega_menu_id_change_call_back');
}
function moller_mega_menu_id_change_call_back($html){
	$html = preg_replace('/id="mega_main_menu"/', 'id="mega_main_menu_first"', $html, 1);
	$html = preg_replace('/id="mega_main_menu_ul"/', 'id="mega_main_menu_ul_first"', $html, 1);
	return $html;
}
add_action('wp_loaded', 'moller_mega_menu_id_change');
function moller_enqueue_script() {
	wp_add_inline_script( 'moller-theme', 'var ajaxurl = "'.admin_url('admin-ajax.php').'";','before');
}
add_action( 'wp_enqueue_scripts', 'moller_enqueue_script');
// Wishlist count
if( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_ajax_update_count' ) ){
	function yith_wcwl_ajax_update_count(){
		wp_send_json( array(
			'count' => yith_wcwl_count_all_products()
		));
	}
	add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
	add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
}
function moller_set_backgimg_header(){ 
	global $moller_opt;
	if ( isset($moller_opt['breadcrumb_bg']['background-image']) && $moller_opt['breadcrumb_bg']['background-image']!='') {
		$breadcrumb_bg_image = "url(" . $moller_opt['breadcrumb_bg']['background-image'] . ")";
	} else {
		$breadcrumb_bg_image = 'none';
	}
	echo "<style>";
	echo ".title-breadcumbs{ background-image:" . $breadcrumb_bg_image . "}";
	echo "</style>";
}
add_action('wp_head','moller_set_backgimg_header');
function moller_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'moller_pingback_header' );
function moller_excerpt($limit) {
	global $moller_opt;
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt) >= $limit) {
	  array_pop($excerpt);
	  $excerpt = implode(" ", $excerpt) . '...';
	} else {
	  $excerpt = implode(" ", $excerpt);
	}
	$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
	$excerpt = '<p>' . $excerpt . '</p>';
	
	return $excerpt;
}
function moller_road_setup(){ 
    // Load admin resources.
    if (is_admin()) { 
        require  get_template_directory().'/road_importdata/class-tgm-plugin-activation.php';
        require  get_template_directory().'/road_importdata/roadtheme-setup.php';
	}

}
add_action('after_setup_theme', 'moller_road_setup', 9, 0);
add_theme_support( 'wc-product-gallery-slider' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );