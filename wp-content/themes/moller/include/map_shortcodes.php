<?php
//Shortcodes for Visual Composer
add_action( 'vc_before_init', 'moller_vc_shortcodes' );
function moller_vc_shortcodes() { 
	//Site logo
	vc_map( array(
		'name' => esc_html__( 'Logo', 'moller'),
		'description' => esc_html__( 'Insert logo image', 'moller' ),
		'base' => 'roadlogo',
		'class' => '',
		'category' => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params' => array(
			array(
				'type'       => 'attach_image',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Upload logo image', 'moller' ),
				'description'=> esc_html__( 'Note: For retina screen, logo image size is at least twice as width and height (width is set below) to display clearly', 'moller' ),
				'param_name' => 'logo_image',
				'value'      => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Insert logo link or not', 'moller' ),
				'param_name' => 'logo_link',
				'value' => array(
					esc_html__( 'Yes', 'moller' )	=> 1,
					esc_html__( 'No', 'moller' )	=> 0,
				),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Logo width (unit: px)', 'moller' ),
				'description'=> esc_html__( 'Insert number. Leave blank if you want to use original image size', 'moller' ),
				'param_name' => 'logo_width',
				'value'      => esc_html__( '150', 'moller' ),
			),
		)
	) );
	//Main Menu
	vc_map( array(
		'name'        => esc_html__( 'Main Menu', 'moller'),
		'description' => esc_html__( 'Set Primary Menu in Apperance - Menus - Manage Locations', 'moller' ),
		'base'        => 'roadmainmenu',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => '',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Set Primary Menu in Apperance - Menus - Manage Locations', 'moller' ),
				'param_name' => 'no_settings',
			),
		),
	) );
	//Sticky Menu
	vc_map( array(
		'name'        => esc_html__( 'Sticky Menu', 'moller'),
		'description' => esc_html__( 'Set Sticky Menu in Apperance - Menus - Manage Locations', 'moller' ),
		'base'        => 'roadstickymenu',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => '',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Set Sticky Menu in Apperance - Menus - Manage Locations', 'moller' ),
				'param_name' => 'no_settings',
			),
		),
	) );
	//Mobile Menu
	vc_map( array(
		'name'        => esc_html__( 'Mobile Menu', 'moller'),
		'description' => esc_html__( 'Set Mobile Menu in Apperance - Menus - Manage Locations', 'moller' ),
		'base'        => 'roadmobilemenu',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => '',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Set Mobile Menu in Apperance - Menus - Manage Locations', 'moller' ),
				'param_name' => 'no_settings',
			),
		),
	) );
	//Wishlist
	vc_map( array(
		'name'        => esc_html__( 'Wishlist', 'moller'),
		'description' => esc_html__( 'Wishlist', 'moller' ),
		'base'        => 'roadwishlist',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => '',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'This widget does not have settings', 'moller' ),
				'param_name' => 'no_settings',
			),
		),
	) );
	//Categories Menu
	vc_map( array(
		'name'        => esc_html__( 'Categories Menu', 'moller'),
		'description' => esc_html__( 'Set Categories Menu in Apperance - Menus - Manage Locations', 'moller' ),
		'base'        => 'roadcategoriesmenu',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => '',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Set Categories Menu in Apperance - Menus - Manage Locations', 'moller' ),
				'param_name' => 'no_settings',
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => esc_html__( 'Inner Category Menu', 'moller' ),
				'description' => esc_html__( 'Always show category menu on inner pages', 'moller' ),
				'param_name' => 'categories_menu_sub',
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => esc_html__( 'Home Category Menu', 'moller' ),
				'description' => esc_html__( 'Always show category menu on home page', 'moller' ),
				'param_name' => 'categories_menu_home',
			),
		),
	) );
	//Social Icons
	vc_map( array(
		'name'        => esc_html__( 'Social Icons', 'moller'),
		'description' => esc_html__( 'Configure icons and links in Theme Options', 'moller' ),
		'base'        => 'roadsocialicons',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => '',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'This widget does not have settings', 'moller' ),
				'param_name' => 'no_settings',
			),
		),
	) );
	//Mini Cart
	vc_map( array(
		'name'        => esc_html__( 'Mini Cart', 'moller'),
		'description' => esc_html__( 'Mini Cart', 'moller' ),
		'base'        => 'roadminicart',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => '',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'This widget does not have settings', 'moller' ),
				'param_name' => 'no_settings',
			),
		),
	) );
	//Products Search without dropdown
	vc_map( array(
		'name'        => esc_html__( 'Product Search (No dropdown)', 'moller'),
		'description' => esc_html__( 'Product Search (No dropdown)', 'moller' ),
		'base'        => 'roadproductssearch',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => '',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'This widget does not have settings', 'moller' ),
				'param_name' => 'no_settings',
			),
		),
	) );
	//Products Search with dropdown
	vc_map( array(
		'name'        => esc_html__( 'Product Search (Dropdown)', 'moller'),
		'description' => esc_html__( 'Product Search (Dropdown)', 'moller' ),
		'base'        => 'roadproductssearchdropdown',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => '',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'This widget does not have settings', 'moller' ),
				'param_name' => 'no_settings',
			),
		),
	) );
	//Image slider
	vc_map( array(
		'name'        => esc_html__( 'Image slider', 'moller' ),
		'description' => esc_html__( 'Upload images and links in Theme Options', 'moller' ),
		'base'        => 'image_slider',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of rows', 'moller' ),
				'param_name' => 'rows',
				'value'      => array(
					esc_html__( '1', 'moller' )	=> '1',
					esc_html__( '2', 'moller' )	=> '2',
					esc_html__( '3', 'moller' )	=> '3',
					esc_html__( '4', 'moller' )	=> '4',
				),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: over 1201px)', 'moller' ),
				'param_name' => 'items_1200up',
				'value'      => esc_html__( '4', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 992px - 1199px)', 'moller' ),
				'param_name' => 'items_992_1199',
				'value'      => esc_html__( '4', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 768px - 991px)', 'moller' ),
				'param_name' => 'items_768_991',
				'value'      => esc_html__( '3', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 640px - 767px)', 'moller' ),
				'param_name' => 'items_640_767',
				'value'      => esc_html__( '2', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 480px - 639px)', 'moller' ),
				'param_name' => 'items_480_639',
				'value'      => esc_html__( '2', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: under 479px)', 'moller' ),
				'param_name' => 'items_0_479',
				'value'      => esc_html__( '1', 'moller' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Navigation', 'moller' ),
				'param_name' => 'navigation',
				'value'      => array(
					esc_html__( 'Yes', 'moller' ) => true,
					esc_html__( 'No', 'moller' )  => false,
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Pagination', 'moller' ),
				'param_name' => 'pagination',
				'value'      => array(
					esc_html__( 'No', 'moller' )  => false,
					esc_html__( 'Yes', 'moller' ) => true,
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Item Margin (unit: pixel)', 'moller' ),
				'param_name' => 'item_margin',
				'value'      => esc_html__( '30', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Slider speed number (unit: second)', 'moller' ),
				'param_name' => 'speed',
				'value'      => esc_html__( '500', 'moller' ),
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => esc_html__( 'Slider loop', 'moller' ),
				'param_name' => 'loop',
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => esc_html__( 'Slider Auto', 'moller' ),
				'param_name' => 'auto',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'moller' ),
				'param_name' => 'style',
				'value'      => array(
					esc_html__( 'Style 1', 'moller' )  => 'style1',
				),
			)
		),
	) );
	//Brand logos
	vc_map( array(
		'name'        => esc_html__( 'Brand Logos', 'moller' ),
		'description' => esc_html__( 'Upload images and links in Theme Options', 'moller' ),
		'base'        => 'ourbrands',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of rows', 'moller' ),
				'param_name' => 'rows',
				'value'      => array(
					esc_html__( '1', 'moller' )	=> '1',
					esc_html__( '2', 'moller' )	=> '2',
					esc_html__( '3', 'moller' )	=> '3',
					esc_html__( '4', 'moller' )	=> '4',
				),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: over 1201px)', 'moller' ),
				'param_name' => 'items_1201up',
				'value'      => esc_html__( '7', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 992px - 1199px)', 'moller' ),
				'param_name' => 'items_992_1199',
				'value'      => esc_html__( '7', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 768px - 991px)', 'moller' ),
				'param_name' => 'items_768_991',
				'value'      => esc_html__( '6', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 640px - 767px)', 'moller' ),
				'param_name' => 'items_640_767',
				'value'      => esc_html__( '4', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 480px - 639px)', 'moller' ),
				'param_name' => 'items_480_639',
				'value'      => esc_html__( '4', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: under 479px)', 'moller' ),
				'param_name' => 'items_0_479',
				'value'      => esc_html__( '3', 'moller' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Navigation', 'moller' ),
				'param_name' => 'navigation',
				'value'      => array(
					esc_html__( 'Yes', 'moller' ) => true,
					esc_html__( 'No', 'moller' )  => false,
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Pagination', 'moller' ),
				'param_name' => 'pagination',
				'value'      => array(
					esc_html__( 'No', 'moller' )  => false,
					esc_html__( 'Yes', 'moller' ) => true,
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Item Margin (unit: pixel)', 'moller' ),
				'param_name' => 'item_margin',
				'value'      => esc_html__( '0', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    =>  esc_html__( 'Slider speed number (unit: second)', 'moller' ),
				'param_name' => 'speed',
				'value'      => esc_html__( '500', 'moller' ),
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => esc_html__( 'Slider loop', 'moller' ),
				'param_name' => 'loop',
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => esc_html__( 'Slider Auto', 'moller' ),
				'param_name' => 'auto',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'moller' ),
				'param_name' => 'style',
				'value'      => array(
					esc_html__( 'Style 1', 'moller' )       => 'style1',
				),
			)
		),
	) );
	//Latest posts
	vc_map( array(
		'name'        => esc_html__( 'Latest posts', 'moller' ),
		'description' => esc_html__( 'List posts', 'moller' ),
		'base'        => 'latestposts',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of posts', 'moller' ),
				'param_name' => 'posts_per_page',
				'value'      => esc_html__( '10', 'moller' ),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Category', 'moller' ),
				'param_name'  => 'category',
				'value'       => esc_html__( '0', 'moller' ),
				'description' => esc_html__( 'Slug of the category (example: slug-1, slug-2). Default is 0 : show all posts', 'moller' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Image scale', 'moller' ),
				'param_name' => 'image',
				'value'      => array(
					esc_html__( 'Wide', 'moller' )	=> 'wide',
					esc_html__( 'Square', 'moller' ) => 'square',
				),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Excerpt length', 'moller' ),
				'param_name' => 'length',
				'value'      => esc_html__( '20', 'moller' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns', 'moller' ),
				'param_name' => 'colsnumber',
				'value'      => array(
					esc_html__( '1', 'moller' )	=> '1',
					esc_html__( '2', 'moller' )	=> '2',
					esc_html__( '3', 'moller' )	=> '3',
					esc_html__( '4', 'moller' )	=> '4',
				),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Enable slider', 'moller' ),
				'param_name'  => 'enable_slider',
				'value'       => true,
				'save_always' => true, 
				'group'       => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of rows', 'moller' ),
				'param_name' => 'rowsnumber',
				'group'      => esc_html__( 'Slider Options', 'moller' ),
				'value'      => array(
						esc_html__( '1', 'moller' )	=> '1',
						esc_html__( '2', 'moller' )	=> '2',
						esc_html__( '3', 'moller' )	=> '3',
						esc_html__( '4', 'moller' )	=> '4',
						esc_html__( '5', 'moller' )	=> '5',
					),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 992px - 1199px)', 'moller' ),
				'param_name' => 'items_992_1199',
				'value'      => esc_html__( '3', 'moller' ),
				'group'      => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 768px - 991px)', 'moller' ),
				'param_name' => 'items_768_991',
				'value'      => esc_html__( '3', 'moller' ),
				'group'      => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 640px - 767px)', 'moller' ),
				'param_name' => 'items_640_767',
				'value'      => esc_html__( '2', 'moller' ),
				'group'      => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: 480px - 639px)', 'moller' ),
				'param_name' => 'items_480_639',
				'value'      => esc_html__( '2', 'moller' ),
				'group'      => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns (screen: under 479px)', 'moller' ),
				'param_name' => 'items_0_479',
				'value'      => esc_html__( '1', 'moller' ),
				'group'      => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Navigation', 'moller' ),
				'param_name'  => 'navigation',
				'save_always' => true,
				'group'       => esc_html__( 'Slider Options', 'moller' ),
				'value'       => array(
					esc_html__( 'Yes', 'moller' ) => true,
					esc_html__( 'No', 'moller' )  => false,
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Pagination', 'moller' ),
				'param_name'  => 'pagination',
				'save_always' => true,
				'group'       => esc_html__( 'Slider Options', 'moller' ),
				'value'       => array(
					esc_html__( 'No', 'moller' )  => false,
					esc_html__( 'Yes', 'moller' ) => true,
				),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Item Margin (unit: pixel)', 'moller' ),
				'param_name'  => 'item_margin',
				'value'       => esc_html__( '30', 'moller' ),
				'save_always' => true,
				'group'       => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Slider speed number (unit: second)', 'moller' ),
				'param_name'  => 'speed',
				'value'       => esc_html__( '500', 'moller' ),
				'save_always' => true,
				'group'       => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Slider loop', 'moller' ),
				'param_name'  => 'loop',
				'value'       => true,
				'group'       => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Slider Auto', 'moller' ),
				'param_name'  => 'auto',
				'value'       => true,
				'group'       => esc_html__( 'Slider Options', 'moller' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Navigation Style', 'moller' ),
				'param_name'  => 'navigation_style',
				'value'       => array(
					__( 'Style 1', 'moller' ) => 'nav-style',
				),
				'group'       => __( 'Slider Options', 'moller' ),
			),
		),
	) );
	//Testimonials
	vc_map( array(
		'name'        => esc_html__( 'Testimonials', 'moller' ),
		'description' => esc_html__( 'Testimonial slider', 'moller' ),
		'base'        => 'testimonials',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'moller'),
		"icon"     	  => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of testimonial', 'moller' ),
				'param_name' => 'limit',
				'value'      => esc_html__( '10', 'moller' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Display Author', 'moller' ),
				'param_name' => 'display_author',
				'value'      => array(
					esc_html__( 'Yes', 'moller' )	=> '1',
					esc_html__( 'No', 'moller' )	=> '0',
				),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Display Avatar', 'moller' ),
				'param_name' => 'display_avatar',
				'value'      => array(
					esc_html__( 'Yes', 'moller' )=> '1',
					esc_html__( 'No', 'moller' ) => '0',
				),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Avatar image size', 'moller' ),
				'param_name'  => 'size',
				'value'       => esc_html__( '150', 'moller' ),
				'description' => esc_html__( 'Avatar image size in pixels. Default is 150', 'moller' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Display URL', 'moller' ),
				'param_name' => 'display_url',
				'value'      => array(
					esc_html__( 'Yes', 'moller' )	=> '1',
					esc_html__( 'No', 'moller' )	=> '0',
				),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Category', 'moller' ),
				'param_name'  => 'category',
				'value'       => esc_html__( '0', 'moller' ),
				'description' => esc_html__( 'Slug of the category (only one category). Default is 0 : show all testimonials', 'moller' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Navigation', 'moller' ),
				'param_name' => 'navigation',
				'value'      => array(
					esc_html__( 'Yes', 'moller' ) => true,
					esc_html__( 'No', 'moller' )  => false,
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Pagination', 'moller' ),
				'param_name' => 'pagination',
				'value'      => array(
					esc_html__( 'Yes', 'moller' ) => true,
					esc_html__( 'No', 'moller' )  => false,
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    =>  esc_html__( 'Slider speed number (unit: second)', 'moller' ),
				'param_name' => 'speed',
				'value'      => esc_html__( '500', 'moller' ),
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => esc_html__( 'Slider loop', 'moller' ),
				'param_name' => 'loop',
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => esc_html__( 'Slider Auto', 'moller' ),
				'param_name' => 'auto',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'moller' ),
				'param_name'  => 'style',
				'value'       => array(
					esc_html__( 'Style 1', 'moller' )                => 'style1',
					esc_html__( 'Style 2 (about page)', 'moller' )   => 'style-about-page',
				),
			)
		),
	) );
	//Counter
	vc_map( array(
		'name'     => esc_html__( 'Counter', 'moller' ),
		'description' => esc_html__( 'Counter', 'moller' ),
		'base'     => 'moller_counter',
		'class'    => '',
		'category' => esc_html__( 'Theme', 'moller'),
		"icon"     => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'   => array(
			array(
				'type'        => 'attach_image',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Image icon', 'moller' ),
				'param_name'  => 'image',
				'value'       => '',
				'description' => esc_html__( 'Upload icon image', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number', 'moller' ),
				'param_name' => 'number',
				'value'      => '',
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Text', 'moller' ),
				'param_name' => 'text',
				'value'      => '',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'moller' ),
				'param_name'  => 'style',
				'value'       => array(
					esc_html__( 'Style 1', 'moller' )   => 'style1',
				),
			),
		),
	) );
	//Heading title
	vc_map( array(
		'name'     => esc_html__( 'Heading Title', 'moller' ),
		'description' => esc_html__( 'Heading Title', 'moller' ),
		'base'     => 'roadthemes_title',
		'class'    => '',
		'category' => esc_html__( 'Theme', 'moller'),
		"icon"     => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'   => array(
			array(
				'type'       => 'textarea',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Heading title element', 'moller' ),
				'param_name' => 'heading_title',
				'value'      => esc_html__( 'Title', 'moller' ),
			),
			array(
				'type'       => 'textarea',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Heading sub-title element', 'moller' ),
				'param_name' => 'sub_heading_title',
				'value'      => '',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'moller' ),
				'param_name'  => 'style',
				'value'       => array(
					esc_html__( 'Style 1 (Default)', 'moller' )    => 'style1',
					esc_html__( 'Style 2', 'moller' )              => 'style2',
					esc_html__( 'Style 3 (Footer title)', 'moller' )     => 'style3',
					esc_html__( 'Style 4 (Footer title 2)', 'moller' )     => 'style4',
				),
			),
		),
	) );
	//Countdown
	vc_map( array(
		'name'     => esc_html__( 'Countdown', 'moller' ),
		'description' => esc_html__( 'Countdown', 'moller' ),
		'base'     => 'roadthemes_countdown',
		'class'    => '',
		'category' => esc_html__( 'Theme', 'moller'),
		"icon"     => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'   => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'End date (day)', 'moller' ),
				'param_name' => 'countdown_day',
				'value'      => esc_html__( '1', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'End date (month)', 'moller' ),
				'param_name' => 'countdown_month',
				'value'      => esc_html__( '1', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'End date (year)', 'moller' ),
				'param_name' => 'countdown_year',
				'value'      => esc_html__( '2020', 'moller' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'moller' ),
				'param_name'  => 'style',
				'value'       => array(
					esc_html__( 'Style 1', 'moller' )      => 'style1',
				),
			),
		),
	) );
	//Login logout
	vc_map( array(
		'name'     => esc_html__( 'Login/logout links', 'moller' ),
		'description' => esc_html__( 'Login/logout links', 'moller' ),
		'base'     => 'road_login_logout',
		'class'    => '',
		'category' => esc_html__( 'Theme', 'moller'),
		"icon"     => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'   => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Text Wellcome', 'moller' ),
				'param_name' => 'txt_wellcome',
				'value'      => esc_html__( 'Hello', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Text Login', 'moller' ),
				'param_name' => 'txt_login',
				'value'      => esc_html__( 'Login', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Text Logout', 'moller' ),
				'param_name' => 'txt_logout',
				'value'      => esc_html__( 'Logout', 'moller' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Text Signup', 'moller' ),
				'param_name' => 'txt_signup',
				'value'      => esc_html__( 'Signup', 'moller' ),
			),
		),
	) );
}
?>