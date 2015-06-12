<?php
/*
 *
 * Set the text domain for the theme or plugin.
 *
 */
define('Redux_TEXT_DOMAIN', 'lbmn');

/*
 *
 * Require the framework class before doing anything else, so we can use the defined URLs and directories.
 * If you are running on Windows you may have URL problems which can be fixed by defining the framework url first.
 *
 */
//define('Redux_OPTIONS_URL', site_url('path the options folder'));
if(!class_exists('Redux_Options')) {
	require_once(dirname(__FILE__) . '/options/defaults.php');
}

/*
 *
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections) {
	//$sections = array();
	$sections[] = array(
		'title' => __('A Section added by hook', 'lbmn'),
		'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'lbmn'),
		'icon' => 'paper-clip',
		'icon_class' => 'icon-large',
		// Leave this as a blank section, no options just some intro text set above.
		'fields' => array()
	);

	return $sections;
}
//add_filter('redux-opts-sections-twenty_eleven', 'add_another_section');


/*
 *
 * Custom function for filtering the args array given by a theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args) {
	//$args['dev_mode'] = false;

	return $args;
}
//add_filter('redux-opts-args-twenty_eleven', 'change_framework_args');


/*
 *
 * Most of your editing will be done in this section.
 *
 * Here you can override default values, uncomment args and change their values.
 * No $args are required, but they can be over ridden if needed.
 *
 */
function setup_framework_options() {
	$args = array();

	// Setting dev mode to true allows you to view the class settings/info in the panel.
	// Default: true
	$args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['dev_mode_icon_class'] = 'icon-large';

	// If you want to use Google Fonts, you MUST define the api key.
	$args['google_api_key'] = 'AIzaSyDEz2KL4BWPAS4J14lTVu9cwC3mG1iTArI';

	// Define the starting tab for the option panel.
	// Default: '0';
	//$args['last_tab'] = '0';

	// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
	// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
	// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
	// Default: 'standard'
	//$args['admin_stylesheet'] = 'standard';

	// Add HTML before the form.
	//$args['intro_text'] = __('<p><a href="http://salbii.ticksy.com" target="_blank" title="Salbii Support">Salbii support</a> team is always here to give you a hand with your setup!</p>', 'lbmn');

	// Add content after the form.
	//$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'lbmn');

	// Set footer/credit line.
	$args['footer_credit'] = __('<span id="footer-thankyou"><a title="Salbii Support" target="_blank" href="http://salbii.ticksy.com">Salbii support</a> team is always here to give you a hand with your setup!</span>', 'lbmn');

	// Setup custom links in the footer for share icons
	// $args['share_icons']['twitter'] = array(
	// 	'link' => 'http://twitter.com/ghost1227',
	// 	'title' => __('Follow me on Twitter', 'lbmn'),
	// 	'img' => Redux_OPTIONS_URL . 'img/social/Twitter.png'
	// );
	// $args['share_icons']['linked_in'] = array(
	// 	'link' => 'http://www.linkedin.com/profile/view?id=52559281',
	// 	'title' => __('Find me on LinkedIn', 'lbmn'),
	// 	'img' => Redux_OPTIONS_URL . 'img/social/LinkedIn.png'
	// );

	// Enable the import/export feature.
	// Default: true
	//$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	$args['import_icon_type'] = 'image';
	$args['import_icon'] = get_template_directory_uri() . '/images/wp-admin/icon-topbar.png';
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// $args['import_icon_type'] = 'iconfont';
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = 'icon-large';

	// Set a custom option name. Don't forget to replace spaces with underscores!
	$args['opt_name'] = 'lbmn_theme_settings';

	// Set a custom menu icon.
	//$args['menu_icon'] = '';

	// Set a custom title for the options page.
	// Default: Options
	$args['menu_title'] = __('Theme Options', 'lbmn');

	// Set a custom page title for the options page.
	// Default: Options
	$args['page_title'] = __('Salbii Theme Options', 'lbmn');

	// Set a custom page slug for options page (wp-admin/themes.php?page=***).
	// Default: redux_options
	$args['page_slug'] = 'themeoptions';

	// Set a custom page capability.
	// Default: manage_options
	// $args['page_cap'] = 'manage_options';

	// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
	// Default: menu
	$args['page_type'] = 'submenu';

	// Set the parent menu.
	// Default: themes.php
	// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	// $args['page_parent'] = 'themes.php';

	// Set a custom page location. This allows you to place your menu where you want in the menu order.
	// Must be unique or it will override other items!
	// Default: null
	//$args['page_position'] = null;

	// Set a custom page icon class (used to override the page icon next to heading)
	//$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Font Awesome, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	// $args['icon_type'] = 'image';
	$args['dev_mode_icon_type'] = 'iconfont';
	//$args['import_icon_type'] == 'image';

	// Disable the panel sections showing as submenu items.
	// Default: true
	// $args['allow_sub_menu'] = false;

	// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
	// $args['help_tabs'][] = array(
	// 	'id' => 'redux-opts-1',
	// 	'title' => __('Theme Information 1', 'lbmn'),
	// 	'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'lbmn')
	// );
	// $args['help_tabs'][] = array(
	// 	'id' => 'redux-opts-2',
	// 	'title' => __('Theme Information 2', 'lbmn'),
	// 	'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'lbmn')
	// );

	// Set the help sidebar for the options page.
	// $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'lbmn');



$sections = array();



//  =================================================================================
//  = SECTION 1 - Global                                                            =
//  =================================================================================
	$sections[] = array(
		// 'icon' => 'upload',
		// 'icon_class' => 'icon-2x',
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/color-swatch.png',
		'title' => __('Global Settings', 'lbmn'),
		// 'desc' => __('<p class="description">Edit your global settings here.</p>', 'lbmn'),
		'fields' => array(
			// favicon
			array(
				'id' => 'lbmn_favicon',
				'type' => 'upload',
				'title' => __('Favicon', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				'desc' => __('Recommended file format *.ico or *.png (114px x 114px)', 'lbmn'),
				'std' => get_template_directory_uri() . '/images/demo-theme/salbii-favicon.png',
			),
			// colours
			array(
				'id' => 'basiccolors_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Colors</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_brand_color',
				'type' => 'color',
				'title' => __('Primary color', 'lbmn'),
				'desc' => __('This is your main brand color', 'lbmn'),
				'std' => '#5aa3bf'
			),
			array(
				'id' => 'lbmn_brand_color_contrast',
				'type' => 'color',
				'title' => __('Contrast color', 'lbmn'),
				'desc' => __('This is the color that contrasts with your primary color', 'lbmn'),
				'std' => '#ffffff'
			),
			array(
				'id' => 'lbmn_title_bgcolor',
				'type' => 'color',
				'title' => __('Title bar background color', 'lbmn'),
				'desc' => __('This is the background color of the page title bar', 'lbmn'),
				'std' => '#F5F6F7'
			),
			array(
				'id' => 'lbmn_title_textcolor',
				'type' => 'color',
				'title' => __('Page title font color', 'lbmn'),
				'desc' => __('This is the color of the page title', 'lbmn'),
				'std' => '#5C5C5C',
			),
			array(
				'id' => 'lbmn_headings_color',
				'type' => 'color',
				'title' => __('Headings font color', 'lbmn'),
				'desc' => __('This is the default color of your headings', 'lbmn'),
				'std' => '#393C3F'
			),
			/* array(
				'id' => 'lbmn_page_bg_color',
				'type' => 'color',
				'title' => __('Page Background color', 'lbmn'),
				'std' => '#FFFFFF'
			), */
			array(
				'id' => 'lbmn_text_color',
				'type' => 'color',
				'title' => __('Body Text color', 'lbmn'),
				'desc' => __('This is your main website text color', 'lbmn'),
				'std' => '#7F8488'
			),
			// layout options
			array(
				'id' => 'content_layoutoptions_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Website Layout</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_layoutoption_boxed_layout',
				'type' => 'checkbox',
				'title' => 'Boxed layout',
				'switch' => true,
				'std' => '0', // 1 = checked | 0 = unchecked
                'class' => 'conditionals-regulator checkbox'
			),
			array(
				'id' => 'lbmn_content_boxed_outer_bg_color',
				'type' => 'color',
				'title' => __('Background color', 'lbmn'),
				'std' => '#2e3036',
                'class' => 'conditional parent___lbmn_layoutoption_boxed_layout value___1 regular-text'
			),
            array(
                'id' => 'lbmn_content_boxed_outer_type',
                'type' => 'select',
                'title' => __('Background style', 'lbmn'),
                // 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
                // 'desc' => __('To change the pre-footer widgets, navigate to the', 'lbmn') . " <a href='" . site_url('/wp-admin/widgets.php') . "' target='_blank'>Widget Admin Section</a>",
                'options' => array(
                    'none' => __('None','lbmn'),
                    'image' => __('Image', 'lbmn'),
                    'pattern' => __('Pattern', 'lbmn')
                ),
                'class' => 'conditionals-regulator conditional parent___lbmn_layoutoption_boxed_layout value___1 regular-text'
			),
			array(
				'id' => 'lbmn_content_boxed_outer_bg_pattern',
				'type' => 'radio_img',
				'title' => __('Select pattern', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				// 'desc' => __('To change the pre-footer widgets, navigate to the', 'lbmn') . " <a href='" . site_url('/wp-admin/widgets.php') . "' target='_blank'>Widget Admin Section</a>",
				'options' => array(
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg1.png' => array('title' => 'Pattern 1', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg1-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg2.png' => array('title' => 'Pattern 2', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg2-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg3.png' => array('title' => 'Pattern 3', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg3-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg4.png' => array('title' => 'Pattern 4', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg4-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg5.png' => array('title' => 'Pattern 5', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg5-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg6.png' => array('title' => 'Pattern 6', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg6-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg7.png' => array('title' => 'Pattern 7', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg7-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg8.png' => array('title' => 'Pattern 8', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg8-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg9.png' => array('title' => 'Pattern 9', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg9-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg10.png' => array('title' => 'Pattern 10', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg10-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg11.png' => array('title' => 'Pattern 11', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg11-thumb.png'),
					get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg12.png' => array('title' => 'Pattern 12', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg12-thumb.png'),
	                'custom' => array('title' => 'Custom', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg-custom-thumb.png'),
				), // Must provide key => value(array:title|img) pairs for radio options
	            'class' => 'conditionals-regulator conditional parent___lbmn_content_boxed_outer_type value___pattern',
	            'std' => get_template_directory_uri() . '/images/wp-admin/layout-backgrounds/bg1.png'
			),
			array(
				'id' => 'lbmn_content_boxed_outer_bg_pattern_upload',
				'type' => 'upload',
				'title' => __('Custom pattern', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				// 'desc' => __('Upload the image of your background pattern  *.png format.', 'lbmn'),
				'class' => 'conditional parent___lbmn_content_boxed_outer_bg_pattern value___custom'
			),
            array(
                'id' => 'lbmn_content_boxed_outer_bg_image_style',
                'type' => 'select',
                'title' => __('Repeat pattern', 'lbmn'),
                'options' => array(
                'repeat' => __('Tiled', 'lbmn'),
                'repeat-y' => __('Tiled vertically', 'lbmn'),
                'repeat-x' => __('Tiled horizontally', 'lbmn'),
                ),
                'std' => 'repeat',
                'class' => 'conditionals-regulator conditional parent___lbmn_content_boxed_outer_type value___pattern'
            ),
			array(
				'id' => 'lbmn_content_boxed_outer_bg_image_upload',
				'type' => 'upload',
				'title' => __('Select image ', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				// 'desc' => __('Upload an image from your computer, or select from media library', 'lbmn'),
                'class' => 'conditional parent___lbmn_content_boxed_outer_type value___image'
			),
			// logo
			array(
				'id' => 'header_logo_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Website Logo</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_logo_image',
				'type' => 'upload',
				'title' => __('Standard logo', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				'desc' => __('Recommended file format: *.jpg, *.png or *.gif', 'lbmn'),
				'std' => get_template_directory_uri() . '/images/demo-theme/salbii-logo.png',
			),
			array(
				'id' => 'lbmn_logo_retina',
				'type' => 'upload',
				'title' => __('Retina logo', 'lbmn'),
				'sub_desc' => __('Optional but highly recommended!', 'lbmn'),
				'desc' => __('The retina logo should be <strong>exactly twice the size</strong> of your standard logo', 'lbmn'),
				'std' => get_template_directory_uri() . '/images/demo-theme/salbii-retina-logo.png',
			),
			array(
				'id' => 'lbmn_logo_text',
				'type' => 'text',
				'title' => __('Logo alternative text', 'lbmn'),
				'validate' => 'html',
				'std' => 'Salbii WordPress Theme',
				'desc' => __('This is only used for the <code>alt=""</code> tag and will not show on the site', 'lbmn')
			),
			array(
				'id' => 'lbmn_logo_margin_top',
				'type' => 'text',
				'title' => __('Logo top margin', 'lbmn'),
				'sub_desc' => __('Optional space above the logo', 'lbmn'),
				'desc' => __('Input numeric value of pixels - <em>but without px</em>', 'lbmn'),
				'validate' => 'numeric',
				'std' => '0',
				'class' => 'small-text'
			),
			array(
				'id' => 'lbmn_logo_margin_bottom',
				'type' => 'text',
				'title' => __('Logo bottom margin', 'lbmn'),
				'sub_desc' => __('Optional space below the logo', 'lbmn'),
				'desc' => __('Input numeric value of pixels - <em>but without px</em>', 'lbmn'),
				'validate' => 'numeric',
				'std' => '0',
				'class' => 'small-text'
			),
			array(
				'id' => 'lbmn_logo_width',
				'type' => 'text',
				'title' => __('Logo width', 'lbmn'),
				'sub_desc' => __('Only use this option to reduce the width of your logo', 'lbmn'),
				'desc' => __('Input numeric value of pixels - <em>but without px</em>', 'lbmn'),
				'validate' => 'numeric',
				'std' => '0',
				'class' => 'small-text'
			),

		)
	);



//  =================================================================================
//  = SECTION 2 - Site Header                                                       =
//  =================================================================================

	$sections[] = array(
		// 'icon' => 'upload',
		// 'icon_class' => 'icon-2x',
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/icon-header.png',
		'title' => __('Site Header', 'lbmn'),
		// 'desc' => __('<p class="description"> </p>', 'lbmn'),
		'fields' => array(
			array(
				'id' => 'lbmn_header_layout',
				'type' => 'radio_img',
				'title' => __('Header layout', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				// 'desc' => __('This uses some of the built in images, you can use them for layout options.', 'lbmn'),
				'options' => array(
					'header-layout-1' => array('title' => __('Minimal. Logo left aligned. Single row.','lbmn'), 'img' => get_template_directory_uri() . '/images/wp-admin/header-layout-1.png'),
					'header-layout-2' => array('title' => __('Logo centered above the navigation menu.','lbmn'), 'img' => get_template_directory_uri() . '/images/wp-admin/header-layout-2.png'),
					'header-layout-3' => array('title' => __('Advanced. Logo left aligned. Two rows with additional tag line.','lbmn'), 'img' => get_template_directory_uri() . '/images/wp-admin/header-layout-3.png'),
				), // Must provide key => value(array:title|img) pairs for radio options
				'std' => 'header-layout-1',
				'class' => 'conditionals-regulator',
			),
			array(
				'id' => 'lbmn_header_height',
				'type' => 'select',
				'title' => __('Header height', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				// 'desc' => __('This is the area that contains your logo', 'lbmn'),
				'options' => array(
					'small'=> __('Small','lbmn'),
					'medium'=> __('Medium','lbmn'),
					'large'=> __('Large','lbmn'),
				),
				'std' => 'large',
			),
			array(
				'id' => 'lbmn_header_bgcolor',
				'type' => 'color',
				'title' => __('Header background color', 'lbmn'),
				'sub_desc' => __('Default is white #FFFFFF', 'lbmn'),
				'std' => '#FFFFFF'
			),
			array(
				'id' => 'lbmn_header_textcolor',
				'type' => 'color',
				'title' => __('Header text color', 'lbmn'),
				'std' => lbmn_HEADERTOP_TEXTCOLOR_DEFAULT,
			),
            array(
				'id' => 'lbmn_header_option',
				'type' => 'select',
				'title' => __('Header style', 'lbmn'),
				'options' => array(
					'none'		=> __('None','lbmn'),
					'sticky'	=> __('Sticky','lbmn'),
					'floating'	=> __('Floating','lbmn')
				),
				'std' => 'sticky',
				'class' => 'conditionals-regulator',
			),
            array(
				'id' => 'lbmn_header_floating_mobile',
				'type' => 'checkbox',
				'title' => 'Disable floating on mobiles/tablets',
				'switch' => true,
				'std' => '0', // 1 = checked | 0 = unchecked
				'class' => 'conditional parent___lbmn_header_option value___floating',
			),
			array(
				'id' => 'lbmn_header_dropshadow',
				'type' => 'checkbox',
				'title' => __('Add drop shadow to the header', 'lbmn'),
				'switch' => true,
				'std' => '1' // 1 = checked | 0 = unchecked
			),
			array(
				'id' => 'lbmn_header_opacity',
				'type' => 'text',
				'title' => __('Header opacity', 'lbmn'),
				//'sub_desc' => __('100 = no transparency', 'lbmn'),
				'desc' => __('Insert a numeric value from 0 to 100', 'lbmn'),
				'validate' => 'numeric',
				'std' => '100',
				'class' => 'small-text'
			),
			array(
				'id' => 'lbmn_header_components_heading',
				'type' => 'info',
				'desc' => '<h4 class="section-divider">' . __('Additional Header Elements', 'lbmn') . '</h4>',
				'class' => 'conditional parent___lbmn_header_layout value___header-layout-3 value___header-layout-1',
			),
			array(
				'id' => 'lbmn_header_languageswitcher',
				'type' => 'checkbox',
				'title' => __('Display language selector', 'lbmn'),
				'desc' => __('This requires the <a title="The WordPress Multilingual Plugin" target="_blank" href="http://wpml.org/">WPML plugin</a> to be installed and activated.', 'lbmn'),
				'switch' => true,
				'class' => 'conditional parent___lbmn_header_layout value___header-layout-3 value___header-layout-1',
				'std' => '0' // 1 = checked | 0 = unchecked
			),
			array(
				'id' => 'lbmn_header_search',
				'type' => 'checkbox',
				'title' => __('Display search tool', 'lbmn'),
				'desc' => __('This displays a search tool with your navigation menu', 'lbmn'),
				'switch' => true,
				'class' => 'conditional parent___lbmn_header_layout value___header-layout-3 value___header-layout-1',
				'std' => '1' // 1 = checked | 0 = unchecked
			),
			array(
				'id' => 'lbmn_header_search_mobile_hide',
				'type' => 'checkbox',
				'title' => __('Hide search tool on mobile', 'lbmn'),
				'desc' => __('Switch on to hide the search tool on mobile devices', 'lbmn'),
				'switch' => true,
				'class' => 'conditional parent___lbmn_header_layout value___header-layout-3 value___header-layout-1',
				'std' => '1' // 1 = checked | 0 = unchecked
			),
			array(
				'id' => 'lbmn_header_additional_text',
				'type' => 'text',
				'title' => __('Tag line', 'lbmn'),
				'desc' => __('This displays to the right of the advanced header', 'lbmn'),
				'validate' => 'html',
				'std' => " <strong>LONDON &middot; PARIS &middot; NEW YORK</strong>",
				// 'desc' => __('We use this text for logo image alt too.', 'lbmn'),
				'class' => 'conditional parent___lbmn_header_layout value___header-layout-3 regular-text',
			),
			array(
				'id' => 'mainmenu_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Header Menu Styling</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_header_linkcolor',
				'type' => 'color',
				'title' => __('Link color', 'lbmn'),
				'desc' => __('', 'lbmn'),
				'std' => lbmn_HEADERTOP_LINKCOLOR_DEFAULT,
			),
			array(
				'id' => 'lbmn_header_linkhovercolor',
				'type' => 'color',
				'title' => __('Link hover color', 'lbmn'),
				'desc' => __('', 'lbmn'),
				'std' => lbmn_HEADERTOP_LINKHOVERCOLOR_DEFAULT,
			),
			array(
				'id' => 'lbmn_menu_bgcolor',
				'type' => 'color',
				'title' => __('Menu background color', 'lbmn'),
				'desc' => __('', 'lbmn'),
				'std' => lbmn_MENU_BACKGROUNDCOLOR_DEFAULT,
				'class' => 'conditional parent___lbmn_header_layout value___header-layout-2 value___header-layout-3',
			),
			array(
				'id' => 'lbmn_menu_bordercolor',
				'type' => 'color',
				'title' => __('Divider line color', 'lbmn'),
				'desc' => __('', 'lbmn'),
				'std' => lbmn_MENU_DIVIDERCOLOR_DEFAULT,
				'class' => 'conditional parent___lbmn_header_layout value___header-layout-2 value___header-layout-3',
			),
			array(
				'id' => 'lbmn_header_menustyling',
				'type' => 'select',
				'title' => __('Font style', 'lbmn'),
				'options' => array(
					'small'		=> __('Small','lbmn'),
					'medium'	=> __('Medium','lbmn'),
					'large'		=> __('Large','lbmn'),
					'divider-1'		=> '&nbsp;',
					'caps-small'	=> __('UPPERCASE: SMALL','lbmn'),
					'caps-medium'	=> __('UPPERCASE: MEDIUM','lbmn'),
					'caps-large'	=> __('UPPERCASE: LARGE','lbmn'),
				),
				'std' => 'medium',
			),
		)
	);



//  =================================================================================
//  = SECTION 3 - Typography                                                        =
//  =================================================================================

	$sections[] = array(
		// 'icon' => 'upload',
		// 'icon_class' => 'icon-2x',
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/icon-type.png',
		'title' => __('Typography', 'lbmn'),
		// 'desc' => __('<p class="description"></p>', 'lbmn'),
		'fields' => array(
			// GOOGLE FONTS CHARACTER SET
			array(
				'id' => 'lbmn_googlefonts_charset',
				'type' => 'multi_checkbox',
				'title' => __('Select Google Fonts Character Sets', 'lbmn'),
				'sub_desc' => __('Prevent slowness on your pages by using only the languages that you actually need!<br><br>Note: Not all character sets are available to use with all Google Fonts. <br>If in doubt, check <a href="http://www.google.com/fonts" target=\"_blank\">Google Fonts</a>', 'lbmn'),
				'options' => array(
					'latin' => 'Latin (latin)' ,
					'latin-ext' => 'Latin Extended (latin-ext)' ,
					'cyrillic' => 'Cyrillic (cyrillic)',
					'cyrillic-ext' => 'Cyrillic Extended (cyrillic-ext)' ,
					'greek' => 'Greek (greek)' ,
					'greek-ext' => 'Greek Extended (greek-ext)' ,
					'vietnamese' => 'Vietnamese (vietnamese)' ,
				),
				'default' => array(
					'latin' => '1'
				)
			),
			// HEADER
			array(
				'id' => 'header_font_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Header Font</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_header_font_type',
				'type' => 'select',
				'title' => __('Select the font source', 'lbmn'),
				'options' => array(
					'standard' => __('Standard fonts', 'lbmn'),
					'google' => __('Standard fonts + Google Fonts', 'lbmn'),
					'another' => __('Standard fonts + Typekit/FontDeck/Fonts.com', 'lbmn'),
				),
				'std' => 'google',
				'class' => 'conditionals-regulator',
			),
			array(
				'id' => 'lbmn_header_standardfont',
				'type' => 'select',
				'title' => __('Select standard font', 'lbmn'),
				'options' => array(
					'arial'					=> __('Sans-serif > Standard: Arial','lbmn'),
					'helvetica'			=> __('Sans-serif > Standard: Helvetica','lbmn'),
					'lucida-sans-unicode'	=> __('Sans-serif > Standard: Lucida Sans Unicode','lbmn'),
					'century-gothic'=> __('Sans-serif > Modern: Century Gothic','lbmn'),
					'divider-1'			=> '&nbsp;',
					'arial-narrow'	=> __('Sans-serif > Narrow: Arial Narrow','lbmn'),
					'impact'				=> __('Sans-serif > Narrow Heavy: Impact','lbmn'),
					'arial-black'		=> __('Sans-serif > Heavy: Arial Black','lbmn'),
					'divider-2'			=> '&nbsp;',
					'cambria'						=> __('Serif > Standard: Cambria','lbmn'),
					'verdana'						=> __('Serif > Standard: Verdana','lbmn'),
					'constantia'				=> __('Serif > Modern: Constantia','lbmn'),
					'bookman-old-style'	=> __('Serif > Old Style: Bookman Old Style','lbmn'),
				),
				'std' => 'helvetica',
			),
			array(
				'id' => 'lbmn_header_font_type_google',
				'type' => 'google_webfonts',
				'title' => __('Select Google Webfont', 'lbmn'),
				'class' => 'conditional parent___lbmn_header_font_type value___google', // Set custom classes for elements if you want to do something a little different
				'std' => 'Roboto',
			),
			array(
				'id' => 'lbmn_header_font_type_another',
				'type' => 'text',
				'title' => __('Custom web font: font-family', 'lbmn'),
				'sub_desc' => __('TypeKit > Using weights & styles in your CSS <br/>FontDeck > Step 2', 'lbmn'),
				'desc' => __('Insert the font-family name - <em>i.e.</em> <code>Custom Font Name</code>', 'lbmn'),
				'class' => 'conditional parent___lbmn_header_font_type value___another regular-text',
			),
			array(
				'id' => 'lbmn_header_font_type_another_js',
				'type' => 'info',
				'desc' => __("<h4>Remember to insert the related JavaScript</h4> <p class='description'>If you are using <strong>custom web fonts</strong> other than Google Fonts, please ensure you insert <br />the JavaScript code provided by the font service you are using. <br /><em>TypeKit (Embed Code section), FontDeck (Using the fonts on your website > Step 1)</em></p><p class='description'>You can insert custom JavaScript in <b>Theme Options > Advanced > Custom Scripts</b></p>", 'lbmn'),
				'class' => 'conditional parent___lbmn_header_font_type value___another',
			),
			// PAGE TITLE
			array(
				'id' => 'title_font_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Page Title Font</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_title_font_type',
				'type' => 'select',
				'title' => __('Select the font source', 'lbmn'),
				'options' => array(
					'standard' => __('Standard fonts', 'lbmn'),
					'google' => __('Standard fonts + Goole Webfonts', 'lbmn'),
					'another' => __('Standard fonts + Typekit/FontDeck/Fonts.com', 'lbmn'),
				),
				'std' => 'google',
				'class' => 'conditionals-regulator',
			),
			array(
				'id' => 'lbmn_title_standardfont',
				'type' => 'select',
				'title' => __('Select standard fonts', 'lbmn'),
				'options' => array(
					'arial'					=> __('Sans-serif > Standard: Arial','lbmn'),
					'helvetica'			=> __('Sans-serif >Standard: Helvetica','lbmn'),
					'lucida-sans-unicode'	=> __('Sans-serif > Standard: Lucida Sans Unicode','lbmn'),
					'century-gothic'=> __('Sans-serif > Modern: Century Gothic','lbmn'),
					'divider-1'			=> '&nbsp;',
					'arial-narrow'	=> __('Sans-serif > Narrow: Arial Narrow','lbmn'),
					'impact'				=> __('Sans-serif > Narrow Heavy: Impact','lbmn'),
					'arial-black'		=> __('Sans-serif > Heavy: Arial Black','lbmn'),
					'divider-2'			=> '&nbsp;',
					'cambria'						=> __('Serif > Standard: Cambria','lbmn'),
					'verdana'						=> __('Serif > Standard: Verdana','lbmn'),
					'constantia'				=> __('Serif > Modern: Constantia','lbmn'),
					'bookman-old-style'	=> __('Serif > Old Style: Bookman Old Style','lbmn'),
				),
				'std' => 'helvetica',
			),
			array(
				'id' => 'lbmn_title_font_type_google',
				'type' => 'google_webfonts',
				'title' => __('Select Google Fonts', 'lbmn'),
				'class' => 'conditional parent___lbmn_title_font_type value___google', // Set custom classes for elements if you want to do something a little different
				'std' => 'Roboto',
			),
			array(
				'id' => 'lbmn_title_font_type_another',
				'type' => 'text',
				'title' => __('Custom web font: font-family', 'lbmn'),
				'sub_desc' => __('TypeKit > Using weights & styles in your CSS <br/>FontDeck > Step 2', 'lbmn'),
				'desc' => __('Insert the font-family name - <em>i.e.</em> <code>Custom Font Name</code>', 'lbmn'),
				'class' => 'conditional parent___lbmn_title_font_type value___another regular-text',
			),
			array(
				'id' => 'lbmn_title_font_type_another_js',
				'type' => 'info',
				'desc' => __("<h4>Remember to insert the related JavaScript</h4> <p class='description'>If you are using <strong>custom web fonts</strong> other than Google Fonts, please ensure you insert <br />the JavaScript code provided by the font service you are using. <br /><em>TypeKit (Embed Code section), FontDeck (Using the fonts on your website > Step 1)</em></p><p class='description'>You can insert custom JavaScript in <b>Theme Options > Advanced > Custom Scripts</b></p>", 'lbmn'),
				'class' => 'conditional parent___lbmn_title_font_type value___another',
			),
			// CONTENT BODY
			array(
				'id' => 'body_font_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Content Body Font</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_body_font_type',
				'type' => 'select',
				'title' => __('Select the font source', 'lbmn'),
				'options' => array(
					'standard' => __('Standard fonts', 'lbmn'),
					'google' => __('Standard fonts + Google Fonts', 'lbmn'),
					'another' => __('Standard fonts + Typekit/FontDeck/Fonts.com', 'lbmn'),
				),
				'std' => 'google',
				'class' => 'conditionals-regulator',
			),
			array(
				'id' => 'lbmn_body_standardfont',
				'type' => 'select',
				'title' => __('Select standard fonts', 'lbmn'),
				'options' => array(
					'arial'					=> __('Sans-serif > Standard: Arial','lbmn'),
					'helvetica'			=> __('Sans-serif >Standard: Helvetica','lbmn'),
					'lucida-sans-unicode'	=> __('Sans-serif > Standard: Lucida Sans Unicode','lbmn'),
					'century-gothic'=> __('Sans-serif > Modern: Century Gothic','lbmn'),
					'divider-1'			=> '&nbsp;',
					'arial-narrow'	=> __('Sans-serif > Narrow: Arial Narrow','lbmn'),
					'impact'				=> __('Sans-serif > Narrow Heavy: Impact','lbmn'),
					'arial-black'		=> __('Sans-serif > Heavy: Arial Black','lbmn'),
					'divider-2'			=> '&nbsp;',
					'cambria'						=> __('Serif > Standard: Cambria','lbmn'),
					'verdana'						=> __('Serif > Standard: Verdana','lbmn'),
					'constantia'				=> __('Serif > Modern: Constantia','lbmn'),
					'bookman-old-style'	=> __('Serif > Old Style: Bookman Old Style','lbmn'),
				),
				'std' => 'helvetica',
			),
			array(
				'id' => 'lbmn_body_font_type_google',
				'type' => 'google_webfonts',
				'title' => __('Select Google Fonts', 'lbmn'),
				'class' => 'conditional parent___lbmn_body_font_type value___google', // Set custom classes for elements if you want to do something a little different
				'std' => 'Roboto',
			),
			array(
				'id' => 'lbmn_body_font_type_another',
				'type' => 'text',
				'title' => __('Custom web font: font-family', 'lbmn'),
				'sub_desc' => __('TypeKit > Using weights & styles in your CSS <br/>FontDeck > Step 2', 'lbmn'),
				'desc' => __('Insert the font-family name - <em>i.e.</em> <code>Custom Font Name</code>', 'lbmn'),
				'class' => 'conditional parent___lbmn_body_font_type value___another regular-text',
			),
			array(
				'id' => 'lbmn_body_font_type_another_js',
				'type' => 'info',
				'desc' => __("<h4>Remember to insert the related JavaScript</h4> <p class='description'>If you are using <strong>custom web fonts</strong> other than Google Fonts, please ensure you insert <br />the JavaScript code provided by the font service you are using. <br /><em>TypeKit (Embed Code section), FontDeck (Using the fonts on your website > Step 1)</em></p><p class='description'>You can insert custom JavaScript in <b>Theme Options > Advanced > Custom Scripts</b></p>", 'lbmn'),
				'class' => 'conditional parent___lbmn_body_font_type value___another',
			),
			// CONTENT HEADER
			array(
				'id' => 'headings_font_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Content Heading Font</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_headings_font_type',
				'type' => 'select',
				'title' => __('Select the font source', 'lbmn'),
				'options' => array(
					'standard' => __('Standard fonts', 'lbmn'),
					'google' => __('Standard fonts + Google Webfonts', 'lbmn'),
					'another' => __('Standard fonts + Typekit/FontDeck/Fonts.com', 'lbmn'),
				),
				'std' => 'google',
				'class' => 'conditionals-regulator',
			),
			array(
				'id' => 'lbmn_headings_standardfont',
				'type' => 'select',
				'title' => __('Select standard font', 'lbmn'),
				'options' => array(
					'arial'					=> __('Sans-serif > Standard: Arial','lbmn'),
					'helvetica'			=> __('Sans-serif >Standard: Helvetica','lbmn'),
					'lucida-sans-unicode'	=> __('Sans-serif > Standard: Lucida Sans Unicode','lbmn'),
					'century-gothic'=> __('Sans-serif > Modern: Century Gothic','lbmn'),
					'divider-1'			=> '&nbsp;',
					'arial-narrow'	=> __('Sans-serif > Narrow: Arial Narrow','lbmn'),
					'impact'				=> __('Sans-serif > Narrow Heavy: Impact','lbmn'),
					'arial-black'		=> __('Sans-serif > Heavy: Arial Black','lbmn'),
					'divider-2'			=> '&nbsp;',
					'cambria'						=> __('Serif > Standard: Cambria','lbmn'),
					'verdana'						=> __('Serif > Standard: Verdana','lbmn'),
					'constantia'				=> __('Serif > Modern: Constantia','lbmn'),
					'bookman-old-style'	=> __('Serif > Old Style: Bookman Old Style','lbmn'),
				),
				'std' => 'helvetica',
			),
			array(
				'id' => 'lbmn_headings_font_type_google',
				'type' => 'google_webfonts',
				'title' => __('Select Google Fonts', 'lbmn'),
				'class' => 'conditional parent___lbmn_headings_font_type value___google', // Set custom classes for elements if you want to do something a little different
				'std' => 'Roboto',
			),
			array(
				'id' => 'lbmn_headings_font_type_another',
				'type' => 'text',
				'title' => __('Custom web font: font-family', 'lbmn'),
				'sub_desc' => __('TypeKit > Using weights & styles in your CSS <br/>FontDeck > Step 2', 'lbmn'),
				'desc' => __('Insert the font-family name - <em>i.e.</em> <code>Custom Font Name</code>', 'lbmn'),
				'class' => 'conditional parent___lbmn_headings_font_type value___another regular-text',
			),
			array(
				'id' => 'lbmn_headings_font_type_another_js',
				'type' => 'info',
				'desc' => __("<h4>Remember to insert the related JavaScript</h4> <p class='description'>If you are using <strong>custom web fonts</strong> other than Google Fonts, please ensure you insert <br />the JavaScript code provided by the font service you are using. <br /><em>TypeKit (Embed Code section), FontDeck (Using the fonts on your website > Step 1)</em></p><p class='description'>You can insert custom JavaScript in <b>Theme Options > Advanced > Custom Scripts</b></p>", 'lbmn'),
				'class' => 'conditional parent___lbmn_headings_font_type value___another',
			),
			// FOOTER
			array(
				'id' => 'footer_font_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Footer Font</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_footer_font_type',
				'type' => 'select',
				'title' => __('Select the font source', 'lbmn'),
				'options' => array(
					'standard' => __('Standard fonts', 'lbmn'),
					'google' => __('Standard fonts + Google Fonts', 'lbmn'),
					'another' => __('Standard fonts + Typekit/FontDeck/Fonts.com', 'lbmn'),
				),
				'std' => 'google',
				'class' => 'conditionals-regulator',
			),
			array(
				'id' => 'lbmn_footer_standardfont',
				'type' => 'select',
				'title' => __('Select standard font', 'lbmn'),
				'options' => array(
					'arial'					=> __('Sans-serif > Standard: Arial','lbmn'),
					'helvetica'			=> __('Sans-serif >Standard: Helvetica','lbmn'),
					'lucida-sans-unicode'	=> __('Sans-serif > Standard: Lucida Sans Unicode','lbmn'),
					'century-gothic'=> __('Sans-serif > Modern: Century Gothic','lbmn'),
					'divider-1'			=> '&nbsp;',
					'arial-narrow'	=> __('Sans-serif > Narrow: Arial Narrow','lbmn'),
					'impact'				=> __('Sans-serif > Narrow Heavy: Impact','lbmn'),
					'arial-black'		=> __('Sans-serif > Heavy: Arial Black','lbmn'),
					'divider-2'			=> '&nbsp;',
					'cambria'						=> __('Serif > Standard: Cambria','lbmn'),
					'verdana'						=> __('Serif > Standard: Verdana','lbmn'),
					'constantia'				=> __('Serif > Modern: Constantia','lbmn'),
					'bookman-old-style'	=> __('Serif > Old Style: Bookman Old Style','lbmn'),
				),
				'std' => 'helvetica',
			),
			array(
				'id' => 'lbmn_footer_font_type_google',
				'type' => 'google_webfonts',
				'title' => __('Select Google Fonts', 'lbmn'),
				'class' => 'conditional parent___lbmn_footer_font_type value___google', // Set custom classes for elements if you want to do something a little different
				'std' => 'Roboto',
			),
			array(
				'id' => 'lbmn_footer_font_type_another',
				'type' => 'text',
				'title' => __('Custom web font: font-family', 'lbmn'),
				'sub_desc' => __('TypeKit > Using weights & styles in your CSS <br/>FontDeck > Step 2', 'lbmn'),
				'desc' => __('Insert the font-family name - <em>i.e.</em> <code>Custom Font Name</code>', 'lbmn'),
				'class' => 'conditional parent___lbmn_footer_font_type value___another regular-text',
			),
			array(
				'id' => 'lbmn_footer_font_type_another_js',
				'type' => 'info',
				'desc' => __("<h4>Remember to insert the related JavaScript</h4> <p class='description'>If you are using <strong>custom web fonts</strong> other than Google Fonts, please ensure you insert <br />the JavaScript code provided by the font service you are using. <br /><em>TypeKit (Embed Code section), FontDeck (Using the fonts on your website > Step 1)</em></p><p class='description'>You can insert custom JavaScript in <b>Theme Options > Advanced > Custom Scripts</b></p>", 'lbmn'),
				'class' => 'conditional parent___lbmn_footer_font_type value___another',
			),
		)
	);



//  =================================================================================
//  = SECTION 4 - Top bar                                                           =
//  =================================================================================

	$sections[] = array(
		// 'icon' => 'upload',
		// 'icon_class' => 'icon-2x',
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/icon-topbar.png',

		'title' => __('Top Bar', 'lbmn'),
		//'desc' => __('<p class="description">The top bar displays at the very top of your website, above the site header.</p>', 'lbmn'),
		'fields' => array(
			array(
				'id' => 'lbmn_toppanel_switch',
				'type' => 'checkbox',
				'title' => __('Display Top Bar', 'lbmn'),
				'desc' => 'This is the very top bar above the site header',
				'switch' => true,
				'std' => '1',
			),
			array(
				'id' => 'toppanel_leftsection_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Top Bar Left Section</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_toppanel_sectiontype_left',
				'type' => 'select',
				'title' => __('Type of content', 'lbmn'),
				'desc' => 'What type of content would you like to display?',
				'options' => array(
					'text' => __('Custom text line', 'lbmn'),
					'menu' => __('Custom menu', 'lbmn'),
					'icons' => __('Social icons','lbmn'),
				),
				'std' => 'text',
				'class' => 'conditionals-regulator',
			),
			array(
				'id' => 'lbmn_toppanel_text_left', // The item ID must be unique
				'type' => 'text',
				'title' => __('Text', 'lbmn'),
				'validate' => 'html',
				'std' => 'Salbii\'s available on ThemeForest &mdash; <a href="http://themeforest.net/user/Tfingi">BUY NOW</a>',
				'class' => 'conditional parent___lbmn_toppanel_sectiontype_left value___text ', // Set custom classes for elements if you want to do something a little different
			),
			array(
				'id' => 'lbmn_toppanel_menu_left',
				'type' => 'menu_select',
				'title' => __('Select your custom menu', 'lbmn'),
				'class' => 'conditional parent___lbmn_toppanel_sectiontype_left value___menu ',
			),
			array(
				'id' => 'lbmn_toppanel_icons_left',
				'type' => 'menu_select',
				'title' => __('Select your social icons', 'lbmn'),
				'std' => lbmn_get_menuid_by_menuname('Social Icons List'),
				'class' => 'conditional parent___lbmn_toppanel_sectiontype_left value___icons ',
			),
			array(
				'id' => 'lbmn_toppanel_icons_left_nolabel',
				'type' => 'checkbox',
				'desc' => __('Show icons only, without text label', 'lbmn'),
				'std' => '1',
				'class' => 'conditional parent___lbmn_toppanel_sectiontype_left value___icons ',
			),
			array(
				'id' => 'toppanel_rightsection_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Top Bar Right Section</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_toppanel_sectiontype_right',
				'type' => 'select',
				'title' => __('Type of content', 'lbmn'),
				'desc' => 'What type of content would you like to display?',
				'options' => array(
					'text' => __('Custom text line', 'lbmn'),
					'menu' => __('Custom menu', 'lbmn'),
					'icons' => __('Social icons','lbmn'),
				),
				'std' => 'icons',
				'class' => 'conditionals-regulator',
			),
			array(
				'id' => 'lbmn_toppanel_text_right', // The item ID must be unique
				'type' => 'text',
				'title' => __('Type your custom text line', 'lbmn'),
				'validate' => 'html',
				'std' => 'Salbii rocks!',
				'class' => 'conditional parent___lbmn_toppanel_sectiontype_right value___text ', // Set custom classes for elements if you want to do something a little different
			),
			array(
				'id' => 'lbmn_toppanel_menu_right',
				'type' => 'menu_select',
				'title' => __('Select your custom menu', 'lbmn'),
				'class' => 'conditional parent___lbmn_toppanel_sectiontype_right value___menu ',
			),
			array(
				'id' => 'lbmn_toppanel_icons_right',
				'type' => 'menu_select',
				'title' => __('Select your social icons', 'lbmn'),
				'std' => lbmn_get_menuid_by_menuname('Social Icons List'),
				'class' => 'conditional parent___lbmn_toppanel_sectiontype_right value___icons ',
			),
			array(
				'id' => 'lbmn_toppanel_icons_right_nolabel',
				'type' => 'checkbox',
				'desc' => __('Show icons only, without text label', 'lbmn'),
				'std' => '1',
				'class' => 'conditional parent___lbmn_toppanel_sectiontype_right value___icons ',
			),
			array(
				'id' => 'lbmn_toppanel_components_heading',
				'type' => 'info',
				'desc' => '<h4 class="section-divider">' . __('Additional Elements', 'lbmn') . '</h4>',
			),
			array(
				'id' => 'toppanel_languageswitcher',
				'type' => 'select',
				'title' => __('Language toggle position', 'lbmn'),
				'options' => array(
					'none' => __('Disabled', 'lbmn'),
					'toppanel-right' => __('Right', 'lbmn'),
					'toppanel-left' => __('Left','lbmn'),
				),
				'desc' => __('This requires the <a href="http://wpml.org/" target="_blank" title="The WordPress Multilingual Plugin">WPML plugin</a> to be installed and activated.', 'lbmn'),
				'std' => 'none',
			),
			array(
				'id' => 'lbmn_toppanel_header_search',
				'type' => 'checkbox',
				'title' => __('Display search tool', 'lbmn'),
				'switch' => true,
				'desc' => 'This displays a search tool in the top bar',
				'std' => '0' // 1 = checked | 0 = unchecked
			),
			array(
				'id' => 'lbmn_toppanel_heading',
				'type' => 'info',
				'desc' => '<h4 class="section-divider">' . __('Top Bar Colors', 'lbmn') . '</h4>',
			),
			array(
				'id' => 'lbmn_toppanel_backgroundcolor',
				'type' => 'color',
				'title' => __('Background color', 'lbmn'),
				//'desc' => 'The background colour of the top bar',
				'std' => lbmn_TOPPANEL_BACKGROUNDCOLOR_DEFAULT
			),
			array(
				'id' => 'lbmn_toppanel_textcolor',
				'type' => 'color',
				'title' => __('Text color', 'lbmn'),
				//'desc' => 'Colour of text in the top bar',
				'std' => lbmn_TOPPANEL_TEXTCOLOR_DEFAULT,
			),
			array(
				'id' => 'lbmn_toppanel_linkcolor',
				'type' => 'color',
				'title' => __('Link color', 'lbmn'),
				//'desc' => 'Colour of text links in the top bar',
				'std' => lbmn_TOPPANEL_LINKCOLOR_DEFAULT,
			),
			array(
				'id' => 'lbmn_toppanel_linkhovercolor',
				'type' => 'color',
				'title' => __('Link hover color', 'lbmn'),
				//'desc' => 'Hover colour of text links in the top bar',
				'std' => lbmn_TOPPANEL_LINKHOVERCOLOR_DEFAULT,
			),
		)
	);



//  =================================================================================
//  = SECTION 6 - Blog                                                              =
//  =================================================================================

	$sections[] = array(
		// 'icon' => 'upload',
		// 'icon_class' => 'icon-2x',
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/script-attribute-b.png',
		'title' => __('Blog Settings', 'lbmn'),
		//'desc' => __('<p class="description">Here you can edit blog settings.</p>', 'lbmn'),
		'fields' => array(
			array(
				'id' => 'lbmn_blog_design',
				'type' => 'radio_img',
				'title' => __('Blog design', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				// 'desc' => __('To change the footer widgets visits:', 'lbmn') . " <a href='" . site_url('/wp-admin/widgets.php') . "' target='_blank'>Widgets Admin Section</a>",
				'options' => array(
					'standard' => array('title' => 'Standard', 'img' => get_template_directory_uri() . '/images/wp-admin/blog-design-standard.png'),
					'masonry' => array('title' => 'Masonry', 'img' => get_template_directory_uri() . '/images/wp-admin/blog-design-masonry.png'),
					// 'left' => array('title' => 'Sidebar left', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-2-alt2.png'),
				), // Must provide key => value(array:title|img) pairs for radio options
				'std' => 'standard',
				'class' => 'conditionals-regulator',
			),
			array(
				'id' => 'lbmn_blog_columns',
				'type' => 'radio_img',
				'title' => __('Blog grid columns', 'lbmn'),
				//'sub_desc' => __('This only applies if you are using the <strong>Masonry design</strong> above.', 'lbmn'),
				// 'desc' => __('To change the footer widgets visits:', 'lbmn') . " <a href='" . site_url('/wp-admin/widgets.php') . "' target='_blank'>Widgets Admin Section</a>",
				'options' => array(
					'blog-columns-2' => array('title' => '2 Columns', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-2.png'),
					'blog-columns-3' => array('title' => '3 Columns', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-3.png'),
					'blog-columns-4' => array('title' => '4 Columns', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-4.png'),
				),
				'std' => 'blog-columns-3',
				'class' => 'conditional parent___lbmn_blog_design value___masonry',
			),
			array(
				'id' => 'lbmn_blog_index_layout',
				'type' => 'radio_img',
				'title' => __('Blog index layout', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				// 'desc' => __('To change the footer widgets visits:', 'lbmn') . " <a href='" . site_url('/wp-admin/widgets.php') . "' target='_blank'>Widgets Admin Section</a>",
				'options' => array(
					'full' => array('title' => 'Full width', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-full.png'),
					'right' => array('title' => 'Right sidebar', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-right.png'),
					'left' => array('title' => 'Left sidebar', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-left.png'),
				), // Must provide key => value(array:title|img) pairs for radio options
				'std' => 'full',
				'class' => 'conditional parent___lbmn_blog_design value___standard',
			),
			array(
				'id' => 'lbmn_blog_post_layout',
				'type' => 'radio_img',
				'title' => __('Single blog post layout', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				// 'desc' => __('To change the footer widgets visits:', 'lbmn') . " <a href='" . site_url('/wp-admin/widgets.php') . "' target='_blank'>Widgets Admin Section</a>",
				'options' => array(
					'full' => array('title' => 'Full width', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-full.png'),
					'right' => array('title' => 'Right sidebar', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-right.png'),
					'left' => array('title' => 'Left sidebar', 'img' => get_template_directory_uri() . '/images/wp-admin/layout-left.png'),
				), // Must provide key => value(array:title|img) pairs for radio options
				'std' => 'full',
			),
			array(
                'id' => 'lbmn_blog_disable_feature_image_on_blog_post_page',
                'type' => 'checkbox',
                'title' => __('Disable Featured image on blog posts', 'lbmn'),
				'desc' => __('This hides the Featured image on single blog post page', 'lbmn'),

                'switch' => true,
                'std' => '1',
			),
		)
	);



//  =================================================================================
//  = SECTION 7 - Widget Areas                                                      =
//  =================================================================================

	$sections[] = array(
		// 'icon' => 'upload',
		// 'icon_class' => 'icon-2x',
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/icon-slider.png',
		'title' => __('Widget Areas', 'lbmn'),
		'desc' => __('<p class="description">The theme has a <strong>pre-footer</strong> - <em>At the bottom of every page, just above the footer</em> - and a <strong>footer</strong> widget areas.<br><em>Remember, you can also have widgets in the blog sidebar.</em></p>', 'lbmn'),
		'fields' => array(
			// pre-footer area
			array(
				'id' => 'prefooter_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Pre-footer Widget Area</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_prefooter_main_switch',
				'type' => 'checkbox',
				'title' => __('Pre-footer widgets', 'lbmn'),
				'switch' => true,
				'std' => '0',
				'class' => 'conditionals-regulator checkbox'
			),
			array(
				'id' => 'lbmn_prefooter_layout',
				'type' => 'radio_img',
				'title' => __('Pre-footer widget area layout', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				'desc' => __('Configure your widgets in the ', 'lbmn') . " <a href='" . site_url('/wp-admin/widgets.php') . "' target='_blank'>Widget Admin Section</a>",
				'options' => array(
					'prefooter-columns-1' => array('title' => '1 Column', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-1.png'),
					'prefooter-columns-2' => array('title' => '50% | 50%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-2.png'),
					'prefooter-columns-2-alt1' => array('title' => '75% | 25%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-2-alt1.png'),
					'prefooter-columns-2-alt2' => array('title' => '25% | 75%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-2-alt2.png'),
					'prefooter-columns-3' => array('title' => '3 Columns', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-3.png'),
					'prefooter-columns-3-alt1' => array('title' => '25% | 25% | 50%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-3-alt1.png'),
					'prefooter-columns-3-alt2' => array('title' => '50% | 25% | 25%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-3-alt2.png'),
					'prefooter-columns-4' => array('title' => '4 Columns', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-4.png'),
				), // Must provide key => value(array:title|img) pairs for radio options
				'std' => 'footer-columns-4',
				'class' => 'conditional parent___lbmn_prefooter_main_switch value___1'
			),
			// footer
			array(
				'id' => 'footer_heading',
				'type' => 'info',
				'desc' => __('<h4 class="section-divider">Footer Widget Area</h4>', 'lbmn')
			),
			array(
				'id' => 'lbmn_footer_main_switch',
				'type' => 'checkbox',
				'title' => __('Footer widgets', 'lbmn'),
				'switch' => true,
				'std' => '1',
				'class' => 'conditionals-regulator checkbox'
			),
			array(
				'id' => 'lbmn_footer_layout',
				'type' => 'radio_img',
				'title' => __('Footer widget area layout', 'lbmn'),
				// 'sub_desc' => __('No validation can be done on this field type', 'lbmn'),
				'desc' => __('Configure your widgets in the ', 'lbmn') . " <a href='" . site_url('/wp-admin/widgets.php') . "' target='_blank'>Widget Admin Section</a>",
				'options' => array(
					'footer-columns-1' => array('title' => '1 Column', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-1.png'),
					'footer-columns-2' => array('title' => '50% | 50%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-2.png'),
					'footer-columns-2-alt1' => array('title' => '75% | 25%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-2-alt1.png'),
					'footer-columns-2-alt2' => array('title' => '25% | 75%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-2-alt2.png'),
					'footer-columns-3' => array('title' => '3 Columns', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-3.png'),
					'footer-columns-3-alt1' => array('title' => '25% | 25% | 50%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-3-alt1.png'),
					'footer-columns-3-alt2' => array('title' => '50% | 25% | 25%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-3-alt2.png'),
					'footer-columns-3-alt3' => array('title' => '25% | 50% | 25%', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-3-alt3.png'),
					'footer-columns-4' => array('title' => '4 Columns', 'img' => get_template_directory_uri() . '/images/wp-admin/footer-columns-4.png'),
				), // Must provide key => value(array:title|img) pairs for radio options
				'std' => 'footer-columns-3-alt2',
				'class' => 'conditional parent___lbmn_footer_main_switch value___1'
			),

		)
	);



//  =================================================================================
//  = SECTION 8 - Call to action section                                            =
//  =================================================================================

	$sections[] = array(
		// 'icon' => 'upload',
		// 'icon_class' => 'icon-2x',
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/icon-footer.png',
		'title' => __('Call to Action', 'lbmn'),
		'desc' => __('<p class="description">The <em>Call to Action</em> section appears just above the footer on every page of your website.</p>', 'lbmn'),
		'fields' => array(
			array(
				'id' => 'lbmn_calltoaction_switch',
				'type' => 'checkbox',
				'title' => __('Display \'Call to Action\'', 'lbmn'),
				'switch' => true,
				'std' => '0',
				'class' => 'conditionals-regulator checkbox'
			),
			array(
				'id' => 'lbmn_calltoaction_title',
				'type' => 'textarea',
				'title' => __('The call to action text', 'lbmn'),
				'std' => 'Salbii is a creative and flexible WordPress theme. <br /><small>Available today on ThemeForest.net</small>',
				'validate' => 'html',
				'class' => 'conditional parent___lbmn_calltoaction_switch value___1'
			),
			array(
				'id' => 'lbmn_calltoaction_button_text',
				'type' => 'text',
				'title' => __('Button text', 'lbmn'),
				'std' => "BUY NOW!",
				'class' => 'conditional parent___lbmn_calltoaction_switch value___1'
			),
			array(
				'id' => 'lbmn_calltoaction_button_url',
				'type' => 'text',
				'title' => __('Button link', 'lbmn'),
				'desc' => __('Please include <code>http://</code> at the start of your URL', 'lbmn'),
				'std' => "http://themeforest.net/user/Tfingi/portfolio/",
				'validate' => 'url',
				'class' => 'conditional parent___lbmn_calltoaction_switch value___1'
			),
		)
	);



//  =================================================================================
//  = SECTION 9 - Footer                                                              =
//  =================================================================================

	$sections[] = array(
		// 'icon' => 'upload',
		// 'icon_class' => 'icon-2x',
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/icon-footer.png',
		'title' => __('Footer', 'lbmn'),
		'desc' => __('<p class="description">If you wish to insert widgets in the footer, see <strong>Widget Areas</strong>.</p>', 'lbmn'),
		'fields' => array(
			// styling
            array(
                'id' => 'lbmn_footer_styling_heading',
                'type' => 'info',
                'desc' => '<h4 class="section-divider">' . __('Colors', 'lbmn') . '</h4>',
            ),
            array(
                'id' => 'lbmn_footer_backgroundcolor',
                'type' => 'color',
                'title' => __('Background color', 'lbmn'),
                'std' => lbmn_FOOTER_BACKGROUNDCOLOR_DEFAULT
            ),
            array(
                'id' => 'lbmn_footer_textcolor',
                'type' => 'color',
                'title' => __('Text color', 'lbmn'),
                'std' => lbmn_FOOTER_TEXTCOLOR_DEFAULT,
            ),
            array(
                'id' => 'lbmn_footer_linkcolor',
                'type' => 'color',
                'title' => __('Link color', 'lbmn'),
                'std' => lbmn_FOOTER_LINKCOLOR_DEFAULT,
            ),
            array(
                'id' => 'lbmn_footer_linkhovercolor',
                'type' => 'color',
                'title' => __('Link hover color', 'lbmn'),
                'std' => lbmn_FOOTER_LINKHOVERCOLOR_DEFAULT,
            ),
            // footer menu
            array(
                'id' => 'lbmn_footer_menu_heading',
                'type' => 'info',
                'desc' => '<h4 class="section-divider">' . __('Footer Menu', 'lbmn') . '</h4>',
            ),
            array(
            	'id' => 'lbmn_footer_menu_switch',
            	'type' => 'checkbox',
            	'title' => __('Display menu in footer', 'lbmn'),
            	'desc' => __('You need to assign a footer menu in', 'lbmn') . " <a href='" . site_url('/wp-admin/nav-menus.php?action=locations') . "' target='_blank'>" . __('Manage Menu Locations', 'lbmn') . "</a>",
            	'switch' => true,
            	'std' => '1',
            	'class' => 'conditionals-regulator checkbox'
            ),
            array(
                'id' => 'lbmn_footer_menu_linkcolor',
                'type' => 'color',
                'title' => __('Link color', 'lbmn'),
                'std' => lbmn_FOOTER_MENU_LINKCOLOR_DEFAULT,
                'class' => 'conditional parent___lbmn_footer_menu_switch value___1'
            ),
            array(
                'id' => 'lbmn_footer_menu_linkhovercolor',
                'type' => 'color',
                'title' => __('Link hover color', 'lbmn'),
                'std' => lbmn_FOOTER_MENU_LINKHOVERCOLOR_DEFAULT,
                'class' => 'conditional parent___lbmn_footer_menu_switch value___1'
            ),
            // Copyright and credits
            array(
                'id' => 'lbmn_footer_copycredits_heading',
                'type' => 'info',
                'desc' => '<h4 class="section-divider">' . __('Copyright &amp; Credits', 'lbmn') . '</h4>',
            ),
            array(
            	'id' => 'lbmn_footer_copyrights_switch',
            	'type' => 'checkbox',
            	'title' => __('Display copyright and credits', 'lbmn'),
            	'switch' => true,
            	'std' => '1',
            	'class' => 'conditionals-regulator checkbox',
            ),
            array(
            	'id' => 'lbmn_footer_copyrights_left',
            	'type' => 'text',
            	'title' => __('Copyright text', 'lbmn'),
            	'desc' => 'Bottom left of the footer',
            	'std' => '&copy; Salbii &middot; 2014 &middot; All rights reserved.',
            	'class' => 'conditional parent___lbmn_footer_copyrights_switch value___1',
            ),
            array(
            	'id' => 'lbmn_footer_copyrights_right',
            	'type' => 'text',
            	'title' => __('Credits text', 'lbmn'),
            	'desc' => 'Bottom right of the footer',
            	'std' => "Handcrafted by <a href='http://themeforest.net/user/Tfingi' target='_blank'>Tfingi</a>",
            	'class' => 'conditional parent___lbmn_footer_copyrights_switch value___1',
            ),

		)
	);



//  =================================================================================
//  = SECTION - Advanced 				                                                    =
//  =================================================================================

	$sections[] = array(
		// 'icon' => 'upload',
		// 'icon_class' => 'icon-2x',
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/switch.png',

		'title' => __('Advanced Settings', 'lbmn'),
		//'desc' => __('<p class="description">Here you can edit advanced options.</p>', 'lbmn'),
		'fields' => array(
			array(
				'id' => 'lbmn_css',
				'type' => 'textarea',
				'title' => __('Custom CSS', 'lbmn'),
				// 'sub_desc' => __('JS will be escaped', 'lbmn'),
				'desc' => __('This code will be included in the html <code>&lt;head&gt;</code> tag. <b>Do not include</b> &lt;style&gt; tags here.', 'lbmn'),
				'validate' => 'html',
				'std' => ''
			),
			array(
				'id' => 'lbmn_js',
				'type' => 'textarea',
				'title' => __('Custom script', 'lbmn'),
				'std' => '',
				'sub_desc' => __('e.g. Google Analytics, Adobe, Typekit, etc.', 'lbmn'),
				'desc' => __('This code will be included before closing <code>&lt;/body&gt;</code> tag. Please <b>include</b> &lt;script&gt; tags if needed.', 'lbmn'),
			),
		)
	);



	$tabs = array();

	if (function_exists('wp_get_theme')){
		$theme_data = wp_get_theme();
		$item_uri = $theme_data->get('ThemeURI');
		$description = $theme_data->get('Description');
		$author = $theme_data->get('Author');
		$author_uri = $theme_data->get('AuthorURI');
		$version = $theme_data->get('Version');
		$tags = $theme_data->get('Tags');
	} else {
		$theme_data = wp_get_theme(trailingslashit(get_stylesheet_directory()) . 'style.css');
		$item_uri = $theme_data['URI'];
		$description = $theme_data['Description'];
		$author = $theme_data['Author'];
		$author_uri = $theme_data['AuthorURI'];
		$version = $theme_data['Version'];
		$tags = $theme_data['Tags'];
	 }

	$item_info = '<div class="redux-opts-section-desc">';
	$item_info .= '<p class="redux-opts-item-data description item-uri">' . __('<strong>Theme URL:</strong> ', 'lbmn') . '<a href="' . $item_uri . '" target="_blank">' . $item_uri . '</a></p><br>';
	$item_info .= '<p class="redux-opts-item-data description item-author">' . __('<strong>Author:</strong> ', 'lbmn') . ($author_uri ? '<a href="' . $author_uri . '" target="_blank">' . $author . '</a>' : $author) . '</p><br>';
	$item_info .= '<p class="redux-opts-item-data description item-version">' . __('<strong>Version:</strong> ', 'lbmn') . $version . '</p><br>';
	$item_info .= '<p class="redux-opts-item-data description item-description">' . $description . '</p><br>';
	$item_info .= '<p class="redux-opts-item-data description item-tags">' . __('<strong>Tags:</strong> ', 'lbmn') . implode(', ', $tags) . '</p>';
	$item_info .= '</div>';

	$tabs['item_info'] = array(
		'icon_type' => 'image',
		'icon' => get_template_directory_uri() . '/images/wp-admin/information-white.png',
		'title' => __('Theme Information', 'lbmn'),
		'content' => $item_info
	);

	if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
		$tabs['docs'] = array(
			'icon' => 'book',
			'icon_class' => 'icon-large',
			'title' => __('Documentation', 'lbmn'),
			'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
		);
	}

	global $Redux_Options;
	$Redux_Options = new Redux_Options($sections, $args, $tabs);

}
add_action('init', 'setup_framework_options', 0);

/*
 *
 * Custom function for the callback referenced above
 *
 */
// function my_custom_field($field, $value) {
// 	print_r($field);
// 	print_r($value);
// }

/*
 *
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value) {
	$error = false;
	$value =  'just testing';
	/*
	do your validation

	if(something) {
		$value = $value;
	} elseif(somthing else) {
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
	}
	*/

	$return['value'] = $value;
	if($error == true) {
		$return['error'] = $field;
	}
	return $return;
}
