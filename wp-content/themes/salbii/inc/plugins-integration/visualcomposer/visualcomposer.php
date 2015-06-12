<?php
/**
 * Visual Composer plugin integration
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * Visual Composer integration by Olga Voloshin (kniganapolke@gmail.com)
 *
 * Code based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Some code is based on open-source tools or open-published code snippets
 *
 * Distributed via ThemeForest under GPLv2 (or later)
 */

require( get_template_directory() . '/inc/plugins-integration/visualcomposer/iconbox.php' );
require( get_template_directory() . '/inc/plugins-integration/visualcomposer/pricing_table.php' );
require( get_template_directory() . '/inc/plugins-integration/visualcomposer/projects_grid.php' );
require( get_template_directory() . '/inc/plugins-integration/visualcomposer/elements_carousel.php' );
require( get_template_directory() . '/inc/plugins-integration/visualcomposer/vc_helper_api.php' );

vc_set_template_dir( get_template_directory() . '/inc/plugins-integration/visualcomposer/vc_templates/' );

/**
* ----------------------------------------------------------------------
* Set VC settings
*/

if(!isset($size_arr)){
	$size_arr = array();
}

if(!isset($target_arr)){
	$target_arr = array();
}

// if (!class_exists('WPBakeryVisualComposerAbstract')) {
// 	$dir = get_template_directory() . '/wpbakery/';

// 	global $composer_settings;
// 	$composer_settings = Array(
// 		'APP_ROOT'      => $dir . '/js_composer',
// 		'WP_ROOT'       => dirname( dirname( dirname( dirname($dir ) ) ) ). '/',
// 		'APP_DIR'       => basename( $dir ) . '/js_composer/',
// 		'CONFIG'        => $dir . '/js_composer/config/',
// 		'ASSETS_DIR'    => 'assets/',
// 		'COMPOSER'      => $dir . '/js_composer/composer/',
// 		'COMPOSER_LIB'  => $dir . '/js_composer/composer/lib/',
// 		'SHORTCODES_LIB'  => $dir . '/js_composer/composer/lib/shortcodes/',
// 		'USER_DIR_NAME'  => 'inc/plugins-integration/visualcomposer/vc_templates', /* Path relative to your current theme, where VC should look for new shortcode templates */

// 		//for which content types Visual Composer should be enabled by default
// 		'default_post_types' => Array('page', 'post', 'lbmn_slider')
// 	);

// 	require_once locate_template('/wpbakery/js_composer/js_composer.php');
// 	$wpVC_setup->init($composer_settings);
// }

/**
* ----------------------------------------------------------------------
* Set custom layout grid classes
*/

function luberman_custom_rowcolumn_css_classes($class_string, $tag) {
		if($tag=='vc_row' || $tag=='vc_row_inner') {
				$class_string = str_replace('vc_row-fluid', 'row', $class_string); 	// define ZURB class for row
				// $class_string = str_replace('wpb_row', '', $class_string); 					// Remove VC class .wpb_row
		}
		if($tag=='vc_column' || $tag=='vc_column_inner') {
				$class_string = preg_replace('/vc_span(\d{1,2})/', 'large-$1 columns', $class_string); 	// define ZURB class for columns
				$class_string = preg_replace('/vc_(\d{1,2})\/12/', 'large-$1 columns', $class_string);  // custom layout classes like 1/12
				
				// $class_string = str_replace('wpb_column', '', $class_string); 													// Remove VC class .wpb_column
				// $class_string = str_replace('column_container', '', $class_string); 										//  Remove VC class /column_container
		}
		return $class_string;
}
// Filter to Replace default css class for vc_row shortcode and vc_column
add_filter('vc_shortcodes_css_class', 'luberman_custom_rowcolumn_css_classes', 10, 2);


/**
* ----------------------------------------------------------------------
* Hide some tabs from Visual Composer settings
*/

function lbmn_hide_gridclassestab ($tabs) {
	unset($tabs ["element_css"]);
	unset($tabs ["updater"]);
	unset($tabs ["color"]);
	return $tabs;
}

add_filter('vc_settings_tabs', 'lbmn_hide_gridclassestab', 10, 1);
// apply_filters('vc_settings_tabs', $this->tabs);


/**
* ----------------------------------------------------------------------
* Override Standard VC Button Backend VC Form
* original code @ config/map.php
*/

$icons_list_page = get_template_directory_uri() . "/iconfont/index.html";
// Used in "Button" and "Call to Action" blocks
$size_arr = array(__("Regular", "js_composer") => "", __("Mini", "js_composer") => "btn-mini", __("Large", "js_composer") => "btn-large" ); // DO NOT DELETE I NEED IT
$colors_arr = array(__("Brand Color", "js_composer") => "primary", __("Grey", "js_composer") => "wpb_button", __("Blue", "js_composer") => "btn-primary", __("Turquoise", "js_composer") => "btn-info", __("Green", "js_composer") => "btn-success", __("Orange", "js_composer") => "btn-warning", __("Red", "js_composer") => "btn-danger", __("Black", "js_composer") => "btn-inverse", __("White", "js_composer") => "btn-white");
$radius_arr = array(__("Square Button", "js_composer") => "square", __("Radius Button", "js_composer") => "radius", __("Round Button", "js_composer") => "round" );
$style_arr = array(
	// __("3D Styled", "js_composer") => "solid",
	__("Theme default", "js_composer") => "default",
	" " => "divider-0",
		__("Hard Shadow: Square", "js_composer") => "hardshadow square",
		__("Hard Shadow: Radius", "js_composer") => "hardshadow radius",
		__("Hard Shadow: Round", "js_composer") => "hardshadow round",
	"  " => "divider-1",
	// __("Plain", "js_composer") => "plain",
		__("Plain: Square", "js_composer") => "plain square",
		__("Plain: Radius", "js_composer") => "plain radius",
		__("Plain: Round", "js_composer") => "plain round",
	// __("Border Only", "js_composer") => "border",
	"   " => "divider-2",
		__("Border Only: Square", "js_composer") => "border square",
		__("Border Only: Radius", "js_composer") => "border radius",
		__("Border Only: Round", "js_composer") => "border round",
);

vc_map( array(
	"name" => __("Button", "js_composer"),
	"base" => "vc_button",
	"icon" => "icon-wpb-ui-button",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Text on the button", "js_composer"),
			"holder" => "button",
			"class" => "wpb_button",
			"param_name" => "title",
			"value" => __("Text on the button", "js_composer"),
			"description" => __("Text on the button.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("URL (Link)", "js_composer"),
			"param_name" => "href",
			"description" => __("Button link.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Size", "js_composer"),
			"param_name" => "size",
			"value" => $size_arr,
			"description" => __("Button size.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Color", "js_composer"),
			"param_name" => "color",
			"value" => $colors_arr,
			"description" => __("Button color.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Style", "js_composer"),
			"param_name" => "style",
			"value" => $style_arr,
			"description" => __("Button visual style.", "js_composer")
		),
		array(
			"type" => "checkbox",
			"heading" => __("Link target", "js_composer"),
			"param_name" => "target",
			"value" => array(__("Open link in a new tab", "js_composer") => "_blank")
		),

		/* Replaced standard icons dropdown with text-fied. In the future need to create a custom icon seleciton UI. */

		array(
			"type" => "textfield",
			"heading" => __("Icon", "js_composer"),
			"param_name" => "icon",
			"description" => __("Paste here <a href='$icons_list_page' target='_blank' >the icon code</a> (ex.: &amp;#xe000;)", "js_composer") //TODO: format it right
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a css class name.", "js_composer")
		)
	),
	"js_view" => 'VcButtonView'
) );



/**
* ----------------------------------------------------------------------
* Row (Section)
*/

vc_add_param('vc_row', array(
    "heading" => "Expand",
    "type" => "dropdown",
    "param_name" => "expand",
    "value" => array(
        "No, don't expand section width" => "",
        "Yes, expand section width" => "expand",
    ),
    "description" => __("Make \"out of the box\" section that expanded to the widow edges", "js_composer"),
));


vc_add_param('vc_row', array(
    "heading" => "Visibility on devices",
    "type" => "dropdown",
    "param_name" => "devices_visibility",
    "value" => array(
        "Visible on all devices" => "",
        "Hidden on Phones (<768px)" => "hidden-xs",
        "Hidden on Tablets (≥768px and < 992px)" => "hidden-sm",
        "Hidden on Desktops (≥992px)" => "hidden-md hidden-lg",        
        "Visible only on Phones (<768px)" => "visible-xs",
        "Visible only on Tablets (≥768px and <992px)" => "visible-sm",
        "Visible only on Desktops (≥992px)" => "visible-md visible-lg",        
    ),
    "description" => __("Visibility on various devices", "js_composer"),
));

//vc_map(
//	array(
//	"name" => __("Row", "js_composer"),
//	"base" => "vc_row",
//	"is_container" => true,
//	"icon" => "icon-wpb-row",
//	// "weight" => 1000,
//	"show_settings_on_create" => false,
//	"category" => __('Content', 'js_composer'),
//	"params" => array(
//		array(
//			/*"type" => "checkbox",
//			"heading" => "",
//			"param_name" => "expand",
//			"value" => array(__("Expand section width", "js_composer") => "expand",),
//			"description" => __("Make \"out of the box\" section that expanded to the widow edges", "js_composer"),*/
//                        "heading" => "",
//                        "type" => "dropdown",                        
//                        "param_name" => "expand",
//                        "value" => array(
//                                "No, don't expand section width" => "",
//                                "Yes, expand section width" => "expand",                                
//                        ),                        
//                        "description" => __("Make \"out of the box\" section that expanded to the widow edges", "js_composer"),
//		),
//			 /*array(
//			 	"type" => "checkbox",
//			 	"heading" => "",
//			 	"param_name" => "content_within_grid",
//			 	"value" => array(__("Keep inner content within the grid", "js_composer") => "keep",),
//			 	"description" => __("Window-wide or grid-wide inner content)", "js_composer"),
//			 	"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			 ),*/
//			/*array(
//				"type" => "colorpicker",
//				"heading" => __("Background color", "js_composer"),
//				"param_name" => "bg_color",
//				"description" => __("Out of the box section background color.", "js_composer"),
//				"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			),
//			array(
//				"type" => "attach_image",
//				"heading" => __("Image", "js_composer"),
//				"param_name" => "image",
//				"value" => "",
//				"description" => __("Select image from media library.", "js_composer"),
//				"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => __("Background image opacity", "js_composer"),
//				"param_name" => "bg_opacity",
//				"value" => array(
//					"100%" => "",
//					"90%" => ".9",
//					"80%" => ".8",
//					"70%" => ".7",
//					"60%" => ".6",
//					"50%" => ".5",
//					"40%" => ".4",
//					"30%" => ".3",
//					"20%" => ".2",
//					"10%" => ".1",
//				),
//				"description" => __("Use it to create colored sem-transparent effects.", "js_composer"),
//				"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			),
//			array(
//				"type" => "textfield",
//				"heading" => __("Horizontal background position X ", "js_composer"),
//				"param_name" => "bg_position_x",
//				"value" => "center",
//				"description" => __("Background image horizontal position. Can take one of the next values: left, center, right, 0% .. 100%, 0px .. 2000px ..", "js_composer"),
//				"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			),
//			array(
//				"type" => "textfield",
//				"heading" => __("Vertical background position Y", "js_composer"),
//				"param_name" => "bg_position_y",
//				"value" => "top",
//				"description" => __("Background image vertical position. Can take one of the next values: top, center, bottom, 0% .. 100%, 0px .. 2000px ..", "js_composer"),
//				"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => __("Background repeat", "js_composer"),
//				"param_name" => "bg_repeat",
//				"value" => array(
//					 "Auto" => '',
//					"Do not repeat" => "no-repeat",
//					"Repeat horizontally and vertically" => "repeat",
//					"Repeat horizontally" => "repeat-x",
//					"Repeat vertically" => "repeat-y" ),
//				"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			),
//			array(
//				"type" => "textfield",
//				"heading" => __("Background size", "js_composer"),
//				"param_name" => "bg_size",
//				"value" => "cover",
//				"description" => __("Background image size. Can take one of the next values: cover, contain, 0% .. 100%, 0px .. 2000px ..", "js_composer"),
//				"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => __("Background effect", "js_composer"),
//				"param_name" => "bg_effect",
//				"value" => array(
//					"None" => "",
//					"Parallax" => "parallax",
//					"Fixed" => "fixed",
//				),
//				"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => __("Parallax speed", "js_composer"),
//				"param_name" => "parallax_speed",
//				"value" => array(
//					"Normal" => "normal",
//					"Very Slow" => "veryslow",
//					"Slow" => "slow",
//					 "Normal" => "normal",
//					"Fast" => "fast",
//					"Very Fast" => "veryfast",
//				),
//				"dependency" => array('element' => "bg_effect", 'value' => array('parallax')), // show only if "Expand section width" checked
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => __("Element styling", "js_composer"),
//				"param_name" => "el_styling",
//				"value" => array(
//					"None" => "",
//					"Hard inner shadow" => "hardshadow-inner",
//					"Soft inner shadow" => "softshadow-inner",
//				),
//				"dependency" => array('element' => "expand", 'not_empty' => true), // show only if "Expand section width" checked
//			),
//                        array(
//                                "type" => "textfield",
//                                "heading" => __("Extra class name", "js_composer"),
//                                "param_name" => "el_class",
//                                "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//                        ),*/
//		),
//		"js_view" => 'VcRowViewCustomized'
//		)
//);



/* Column
---------------------------------------------------------- */
$column_settings = array(
	array(
		"type" => "colorpicker",
		"heading" => __("Background color", "js_composer"),
		"param_name" => "column_bg_color",
		//"value" => ''
	),
	array(
		"type" => "dropdown",
		"heading" => __("Background opacity", "js_composer"),
		"param_name" => "bg_opacity",
		"value" => array(
			"100%" => "1",
			"95%" => ".95",
			"90%" => ".9",
			"85%" => ".85",
			"80%" => ".8",
			"75%" => ".75",
			"70%" => ".7",
			"65%" => ".65",
			"60%" => ".6",
			"55%" => ".55",
			"50%" => ".5",
			"45%" => ".45",
			"40%" => ".4",
			"35%" => ".35",
			"30%" => ".3",
			"25%" => ".25",
			"20%" => ".2",
			"15%" => ".15",
			"10%" => ".1",
			"5%" => ".05",
		),
		"description" => __("Applies only when background color set.", "js_composer"),
	),
	array(
		"type" => "dropdown",
		"heading" => __("Element styling", "js_composer"),
		"param_name" => "el_styling",
		"value" => array(
			"None" => "",
			"Hard inner shadow" => "hardshadow",
			"Soft inner shadow" => "softshadow",
		),
	),
	array(
		"type" => "checkbox",
		"param_name" => "rounded_corners",
		"value" => array(__("Rounded corners", "js_composer") => "true")
	),
);

foreach($column_settings as $param) {
	vc_add_param('vc_column', $param);
	vc_add_param('vc_column_inner', $param);
}

/**
 * --------------------------------------------------------------------
 * Tab
 */

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

vc_map( array(
	"name" => __("Tab", "js_composer"),
	"base" => "vc_tab",
	//"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Title", "js_composer"),
			"param_name" => "title",
			"description" => __("Tab title.", "js_composer")
		),
		array(
			"type" => "tab_id",
			"heading" => __("Tab ID", "js_composer"),
			"param_name" => "tab_id"
		)
	),
	'js_view' => ($vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35')
) );

/**
* ----------------------------------------------------------------------
* Icon box
*/

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

$icon_style_arr = array(
	// __("3D Styled", "js_composer") => "solid",
	__("Theme default", "js_composer") => "default",
	" " => "divider-0",
		__("Icon only", "js_composer") => "icon-only",
	"  " => "divider-1",
		__("Border Only: Round", "js_composer") => "border round",
		__("Border Only: Square", "js_composer") => "border square",
		__("Border Only: Radius", "js_composer") => "border radius",
	"   " => "divider-2",
		__("Plain: Round", "js_composer") => "plain round",
		__("Plain: Square", "js_composer") => "plain square",
		__("Plain: Radius", "js_composer") => "plain radius",

);

vc_map( array(
	"name" => __("Icon box", "js_composer"),
	"base" => "vc_iconbox",
	"icon" => "icon-wpb-vc_extend",
	"category" => __('Content', "js_composer"),
	"is_container" => true,
	"content_element" => true,
	'admin_enqueue_css' => array(get_template_directory_uri().'/inc/plugins-integration/visualcomposer/vc_views.css'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Icon", "js_composer"),
			"param_name" => "icon",
			"description" => __("Paste here <a href='$icons_list_page' target='_blank' >the icon code</a> (ex.: &amp;#xe000;)", "js_composer") //TODO: format it right
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Icon Color", "js_composer"),
			"param_name" => "color",
			//"description" => __("", "js_composer")
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Badge Color", "js_composer"),
			"param_name" => "badge_color",
			//"description" => __("", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Icon position", "js_composer"),
			"param_name" => "icon_position",
			"value" => array(
				__("Top center", "js_composer") => "icon-position__top-center",
				__("Top left", "js_composer") => "icon-position__top-left",
				__("Left", "js_composer") => "icon-position__left",
			),
			"description" => __("How and where to display the icon.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Size", "js_composer"),
			"param_name" => "size",
			"value" => $size_arr,
			"description" => __("Icon size.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Style", "js_composer"),
			"param_name" => "style",
			"value" => $icon_style_arr,
			"description" => __("Icson visual style.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Hover effect", "js_composer"),
			"param_name" => "hover_effect",
			"value" => array(
				__("None", "js_composer") => "none",
				__("Effect 1", "js_composer") => "vc-icon-effect-1a",
			),
			"description" => __("How and where to display the icon.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("URL (Link)", "js_composer"),
			"param_name" => "href",
			"description" => __("Icon link.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		),
	),
	'js_view' => 'VcIconboxView'
) );


/**
 * ----------------------------------------------------------------------
 * Pricing table
 */

vc_map( array(
	"name" => __("Pricing Table", "js_composer"),
	"base" => "vc_pricing_table",
	"icon" => "icon-wpb-vc_extend",
	"category" => __('Content', "js_composer"),
	//"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => true,
	'admin_enqueue_css' => array(get_template_directory_uri().'/inc/plugins-integration/visualcomposer/vc_views.css?ver=1529'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Number of plans", "js_composer"),
			"param_name" => "plans_count",
			"value" => array(
				"" => 0,
				"1" => 1,
				"2" => 2,
				"3" => 3,
				"4" => 4,
				"5" => 5,
				"6" => 6,
			),
			"description" => __("How many pricing table columns to create?", "js_composer"),
		),
	),
	'js_view' => 'VcPricingTableView'
) );

vc_map( array(
	"name" => __("Price Block", "js_composer"),
	"base" => "vc_price_block",
	"class" => "pricingtable-priceblock",
	//"allowed_container_element" => 'vc_column',
	"is_container" => false,
	"content_element" => false,
	"show_settings_on_create" => false,
	'admin_enqueue_css' => array(get_template_directory_uri().'/inc/plugins-integration/visualcomposer/vc_views.css'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Plan Title", "js_composer"),
			"param_name" => "title",
			// "value" => "",
			"description" => __("Basic, Standard, Professional, Ultimate, etc.", "js_composer"),
		),
		array(
			"type" => "textfield",
			"heading" => __("Currency Symbol", "js_composer"),
			"param_name" => "currency",
			"value" => "$",
			"description" => __("$, &pound;, &euro;, &yen;, etc.", "js_composer"),
		),
		array(
			"type" => "textfield",
			"heading" => __("Price", "js_composer"),
			"param_name" => "price",
			"value" => "0",
		),
		array(
			"type" => "textfield",
			"heading" => __("Period", "js_composer"),
			"param_name" => "period",
			"value" => "/mo",
			"description" => __("'/mo', '/yr', '&lt;br /&gt;a month', '&lt;br /&gt;per year', etc.", "js_composer"),
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Price block background color", "js_composer"),
			"param_name" => "bg_color",
			"value" => ''
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Price block text color", "js_composer"),
			"param_name" => "text_color",
			"value" => ''
		),
		array(
			"type" => "checkbox",
			"param_name" => "custom_plantitle_color",
			"value" => array(__("Custom colors for plan title", "js_composer") => "true")
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Price title background color", "js_composer"),
			"param_name" => "title_bg_color",
			"value" => '',
			"dependency" => Array('element' => "custom_plantitle_color", 'not_empty' => true),
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Price title text color", "js_composer"),
			"param_name" => "title_text_color",
			"value" => '',
			"dependency" => Array('element' => "custom_plantitle_color", 'not_empty' => true),
		),

		array(
			"type" => "textarea",
			"heading" => __("Description", "js_composer"),
			"param_name" => "description",
			"value" => "sample description",
		),
		array(
			"type" => "checkbox",
			"param_name" => "make_featured",
			"value" => array(__("Make Featured", "js_composer") => "true")
		),
		array(
			"type" => "textfield",
			"heading" => __("Featured Badge Text", "js_composer"),
			"param_name" => "featured_badge_text",
			"dependency" => Array('element' => "make_featured", 'not_empty' => true),
			"value" => "Featured",
		),
	),
	'js_view' => 'VcPriceBlockView'
) );

vc_map( array(
	"name" => __("Pricing Plan Feature", "js_composer"),
	"base" => "vc_pricing_plan_feature",
	"class" => "pricingtable-feature",
	"is_container" => false,
	"content_element" => false,
	"show_settings_on_create" => false,
	'admin_enqueue_css' => array(get_template_directory_uri().'/inc/plugins-integration/visualcomposer/vc_views.css'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Feature Title", "js_composer"),
			"param_name" => "title",
			// "value" => "",
		),
		array(
			"type" => "textfield",
			"heading" => __("Description", "js_composer"),
			"param_name" => "description",
			// "value" => "sample description",
		),
		array(
			"type" => "checkbox",
			"param_name" => "show_description_in_popup",
			"value" => array(__("Show description in popup", "js_composer") => "true")
		),
		array(
			"type" => "textfield",
			"heading" => __("Icon", "js_composer"),
			"description" => __("Paste here <a href='$icons_list_page' target='_blank' >the icon code</a> (ex.: &amp;#xe000;)", "js_composer"),
			"param_name" => "icon",
		),
		// array(
		// 	"type" => "colorpicker",
		// 	"heading" => __("Background color", "js_composer"),
		// 	"param_name" => "bg_color",
		// 	"value" => ''
		// ),
		array(
			"type" => "colorpicker",
			"heading" => __("Text color", "js_composer"),
			"param_name" => "text_color",
			"value" => ''
		),
		// array(
		// 	"type" => "checkbox",
		// 	"param_name" => "border",
		// 	"value" => array(__("Border", "js_composer") => "true")
		// ),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		),
	),
	'js_view' => 'VcPricingPlanFeatureView'
) );

/* Elements Carousel
---------------------------------------------------------- */
$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);
vc_map( array(
	"name" => __("Elements Carousel", "js_composer"),
	"base" => "vc_elements_carousel",
	"show_settings_on_create" => false,
	"is_container" => true,
	"icon" => "icon-wpb-ui-tab-content-vertical",
	"category" => __('Content', 'js_composer'),
	"wrapper_class" => "clearfix",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Widget title", "js_composer"),
			"param_name" => "title",
			"description" => __("What text use as a widget title. Leave blank if no title is needed.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Auto rotate slides", "js_composer"),
			"param_name" => "interval",
			"value" => array(__("Disable", "js_composer") => 0, 3, 5, 10, 15),
			"description" => __("Auto rotate slides each X seconds.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		)
	),
	"custom_markup" => '
  <div class="wpb_tabs_holder wpb_holder clearfix vc_container_for_children">
  <ul class="tabs_controls">
  </ul>
  %content%
  </div>'
,
	'default_content' => '
  [vc_tab title="'.__('Slide 1','js_composer').'" tab_id="'.$tab_id_1.'"][/vc_tab]
  [vc_tab title="'.__('Slide 2','js_composer').'" tab_id="'.$tab_id_2.'"][/vc_tab]
  ',
	"js_view" => ($vc_is_wp_version_3_6_more ? 'VcElementsCarouselView' : 'VcElementsCarouselView35')
) );

/**
* ----------------------------------------------------------------------
* Call to action button
*/

$block_style_arr = array(
	__("No style", "js_composer") => "none",
	__("Plain: Grey", "js_composer") => "plain grey",
	__("Plain: Brand Color", "js_composer") => "plain brand_bgcolor",
	__("Border Only: Grey", "js_composer") => "border",
	__("Border Only: Brand Color", "js_composer") => "border brand_bordercolor",
	__("Hard shadow: Grey", "js_composer") => "hardshadow",
	__("Hard shadow: Brand Color", "js_composer") => "hardshadow brand_bgcolor",
);

vc_map( array(
	"name" => __("Call to Action Block", "js_composer"),
	"base" => "vc_cta_button",
	"icon" => "icon-wpb-call-to-action",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textarea",
			'admin_label' => true,
			"heading" => __("Heading", "js_composer"),
			"param_name" => "call_text",
			"value" => __("Click edit button to change this text.", "js_composer"),
			"description" => __("Enter heading for call to action block.", "js_composer")
		),
		array(
			"type" => "textarea",
			// 'admin_label' => true,
			"heading" => __("Text", "js_composer"),
			"param_name" => "call_text_secondary",
			"value" => __("Click edit button to change this text.", "js_composer"),
			"description" => __("Enter secondary text.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Text on the button", "js_composer"),
			"param_name" => "title",
			"value" => __("Text on the button", "js_composer"),
			"description" => __("Text on the button.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("URL (Link)", "js_composer"),
			"param_name" => "href",
			"description" => __("Button link.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button position", "js_composer"),
			"param_name" => "position",
			"value" => array(__("Align right", "js_composer") => "cta_align_right", __("Align left", "js_composer") => "cta_align_left", __("Align bottom", "js_composer") => "cta_align_bottom"),
			"description" => __("Select button alignment.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Target", "js_composer"),
			"param_name" => "target",
			"value" => (count($target_arr) == 0 ? array("Same tab" => "_self", "New tab" => "_blank") : $target_arr),
			"description" => __("Where to open the linked page.", "js_composer"),
			"dependency" => Array('element' => "href", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Color", "js_composer"),
			"param_name" => "color",
			"value" => $colors_arr,
			"description" => __("Button color.", "js_composer"),
			"dependency" => Array('element' => "href", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Size", "js_composer"),
			"param_name" => "size",
			"value" => $size_arr,
			"description" => __("Button size.", "js_composer"),
			"dependency" => Array('element' => "href", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Style", "js_composer"),
			"param_name" => "btn_style",
			"value" => $style_arr,
			"description" => __("Button visual style.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Block Style", "js_composer"),
			"param_name" => "el_style",
			"value" => $block_style_arr,
			"description" => __("Block visual style.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Button Icon", "js_composer"),
			"param_name" => "icon",
			"description" => __("Paste here <a href='$icons_list_page' target='_blank' >the icon code</a> (ex.: &amp;#xe000;)", "js_composer") //TODO: format it right
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		)
	),
	"js_view" => 'VcCallToActionView'
) );



/**
* ----------------------------------------------------------------------
* Separator (Divider)
*/

$divider_style_arr = array(
	__("Thin", "js_composer") => "thin",
	__("Medium", "js_composer") => "medium",
	__("Thick", "js_composer") => "thick",
	__("Double", "js_composer") => "double",
	__("Dotted", "js_composer") => "dotted",
	__("Dashed", "js_composer") => "dashed",
);

vc_map( array(
	"name"    => __("Separator", "js_composer"),
	"base"    => "vc_separator",
	'icon'    => 'icon-wpb-ui-separator',
	"show_settings_on_create" => false,
	"category"  => __('Content', 'js_composer'),
	// "controls"  => 'popup_delete'
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Style", "js_composer"),
			"param_name" => "style",
			"value" => $divider_style_arr,
			"description" => __("Select separator style.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		)
	),
) );



/* Flickr
---------------------------------------------------------- */
vc_map( array(
	"base" => "vc_flickr",
	"name" => __("Flickr Widget", "js_composer"),
	"icon" => "icon-wpb-flickr",
	"category" => __('Content', 'js_composer'),
	"params"	=> array(
		array(
			"type" => "textfield",
			"heading" => __("Widget title", "js_composer"),
			"param_name" => "title",
			"description" => __("What text use as a widget title. Leave blank if no title is needed.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Flickr ID", "js_composer"),
			"param_name" => "flickr_id",
			'admin_label' => true,
			"description" => sprintf(__('To find your flickID visit %s.', "js_composer"), '<a href="http%3A%2F%2Fidgettr.com%2F" target="_blank">idGettr</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Number of photos", "js_composer"),
			"param_name" => "count",
			"value" => array(9, 8, 7, 6, 5, 4, 3, 2, 1),
			"description" => __("Number of photos.", "js_composer")
		),

		array(
			"type" => "dropdown",
			"heading" => __("Size", "js_composer"),
			"param_name" => "size",
			"value" => array(__("Small", "js_composer") => "s", __("Thumbnail", "js_composer") => "t", __("Medium", "js_composer") => "m"),
			"description" => __("Size of photos.", "js_composer")
		),

		array(
			"type" => "dropdown",
			"heading" => __("Type", "js_composer"),
			"param_name" => "type",
			"value" => array(__("User", "js_composer") => "user", __("Group", "js_composer") => "group"),
			"description" => __("Photo stream type.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Display", "js_composer"),
			"param_name" => "display",
			"value" => array(__("Latest", "js_composer") => "latest", __("Random", "js_composer") => "random"),
			"description" => __("Photo order.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		)
	)
) );

/* Projects grid
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Projects Grid", "js_composer"),
	"base" => "vc_projects_grid",
	"icon" => "icon-wpb-application-icon-large",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Widget title", "js_composer"),
			"param_name" => "title",
			"description" => __("What text use as a widget title. Leave blank if no title is needed.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns count", "js_composer"),
			"param_name" => "grid_columns_count",
			"value" => array(4, 3, 2, 1),
			"admin_label" => true,
			"description" => __("Select columns count.", "js_composer")
		),
		array(
			"type" => "posttypes",
			"heading" => __("Post types", "js_composer"),
			"param_name" => "grid_posttypes",
			"description" => __("Select lbmn_project to display portfolio projects.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Teasers count", "js_composer"),
			"param_name" => "grid_teasers_count",
			"description" => __('How many teasers to show? Leave blank to show all.', "js_composer")
		),
		// array(
		// 	"type" => "dropdown",
		// 	"heading" => __("Content", "js_composer"),
		// 	"param_name" => "grid_content",
		// 	"value" => array(__("Teaser (Excerpt)", "js_composer") => "teaser", __("Full Content", "js_composer") => "content"),
		// 	"description" => __("Teaser layout template.", "js_composer")
		// ),
		array(
			"type" => "dropdown",
			"heading" => __("Layout", "js_composer"),
			"param_name" => "grid_layout",
			"value" => array(__("Title + Thumbnail + Text", "js_composer") => "title_thumbnail_text", __("Thumbnail + Title + Text", "js_composer") => "thumbnail_title_text", __("Thumbnail + Text", "js_composer") => "thumbnail_text", __("Thumbnail + Title", "js_composer") => "thumbnail_title", __("Thumbnail only", "js_composer") => "thumbnail", __("Title + Text", "js_composer") => "title_text"),
			"description" => __("Teaser layout.", "js_composer")
		),
		array(
			"type" => "checkbox",
			// "heading" => __("display project type / attributes", "js_composer"),
			"param_name" => "grid_project_taxonomy",
			"value" => array(__("Show project category", "js_composer") => "true")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Link", "js_composer"),
			"param_name" => "grid_link",
			"value" => array(__("Link to post", "js_composer") => "link_post", __("Link to bigger image", "js_composer") => "link_image", __("Thumbnail to bigger image, title to post", "js_composer") => "link_image_post", __("No link", "js_composer") => "link_no"),
			"description" => __("Link type.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Link target", "js_composer"),
			"param_name" => "grid_link_target",
			"value" => $target_arr,
			"dependency" => Array('element' => "grid_link", 'value' => array('link_post', 'link_image_post'))
		),
		array(
			"type" => "dropdown",
			"heading" => __("Teaser grid layout", "js_composer"),
			"param_name" => "grid_template",
			"value" => array(__("Grid", "js_composer") => "grid", __("Grid with filter", "js_composer") => "filtered_grid"),
			"description" => __("Teaser layout template.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Layout mode", "js_composer"),
			"param_name" => "grid_layout_mode",
			"value" => array(__("Fit rows", "js_composer") => "fitRows", __('Masonry', "js_composer") => 'masonry'),
			"dependency" => Array('element' => 'grid_template', 'value' => array('filtered_grid', 'grid')),
			"description" => __("Teaser layout template.", "js_composer")
		),
		array(
			"type" => "taxonomies",
			"heading" => __("Filter projects by:", "js_composer"),
			"param_name" => "grid_taxomonies",
			"dependency" => Array('element' => 'grid_template' /*, 'not_empty' => true*/, 'value' => array('filtered_grid'), 'callback' => 'wpb_grid_post_types_for_taxonomies_handler'),
			"description" => __("Filter projects by type or by attributes.", "js_composer") //TODO: Change description
		),
		// array(
		// 	"type" => "textfield",
		// 	"heading" => __("Thumbnail size", "js_composer"),
		// 	"param_name" => "grid_thumb_size",
		// 	"description" => __('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height).', "js_composer")
		// ),
		array(
			"type" => "textfield",
			"heading" => __("Post/Page IDs", "js_composer"),
			"param_name" => "posts_in",
			"description" => __('Fill this field with page/posts IDs separated by commas (,) to retrieve only them. Use this in conjunction with "Post types" field.', "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Exclude Post/Page IDs", "js_composer"),
			"param_name" => "posts_not_in",
			"description" => __('Fill this field with page/posts IDs separated by commas (,) to exclude them from query.', "js_composer")
		),
		array(
			"type" => "exploded_textarea",
			"heading" => __("Categories", "js_composer"),
			"param_name" => "grid_categories",
			"description" => __("If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter).", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", "js_composer"),
			"param_name" => "orderby",
			"value" => array( "", __("Date", "js_composer") => "date", __("ID", "js_composer") => "ID", __("Author", "js_composer") => "author", __("Title", "js_composer") => "title", __("Modified", "js_composer") => "modified", __("Random", "js_composer") => "rand", __("Comment count", "js_composer") => "comment_count", __("Menu order", "js_composer") => "menu_order" ),
			"description" => sprintf(__('Select how to sort retrieved posts. More at %s.', 'js_composer'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order way", "js_composer"),
			"param_name" => "order",
			"value" => array( __("Descending", "js_composer") => "DESC", __("Ascending", "js_composer") => "ASC" ),
			"description" => sprintf(__('Designates the ascending or descending order. More at %s.', 'js_composer'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		)
	)
) );

/* LBMN Slider
---------------------------------------------------------- */

if (is_plugin_active('lbmn-slider/lbmn-slider.php')) {

	$posts = WPCommonHelper::getAllPostsByType('section_slider');
	$dd_values = array();

	foreach($posts as $post){
		$dd_values[$post['title']] = $post['id'];
	}

	vc_map( array(
		"name" => __("LBMN Slider", "js_composer"),
		"base" => "lbmn_slider",
		"icon" => "icon-wpb-application-icon-large",
		"category" => __('Content', 'js_composer'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", "js_composer"),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
			),
			array(
				"type" => "dropdown",
				"heading" => __("Section Slider", "js_composer"),
				"param_name" => "id",
				"value" => $dd_values,
			),
		),
		'js_view' => 'VcLbmnSlider',
	));
}

/* Margins
 * Add margins settings to all VC elements
---------------------------------------------------------- */
VCElementMargins::addMarginsToVcElements();

/* Column
 * Setup predefined VC templates (template name => path to template file)
---------------------------------------------------------- */
$templates_dir = get_template_directory() . '/inc/plugins-integration/visualcomposer/vc_predefined_post_templates/';
VCPredefinedTemplates::setupPredefinedTemplates(array(
	'Page: Home with simple slider' => $templates_dir . 'home-simple-slider.html',
	'Page: Home with LayerSlider' => $templates_dir . 'home-layerslider.html',
	'Page: Home minimal' => $templates_dir . 'home-minimal.html',
	'Page: About us' => $templates_dir . 'page-about.html',
	'Page: FAQ' => $templates_dir . 'page-faq.html',
	'Page: Services' => $templates_dir . 'page-services.html',
	'Page: Contact us' => $templates_dir . 'page-contact.html',
	'Page: Features' => $templates_dir . 'page-features.html',
	'Page: Pricing' => $templates_dir . 'page-pricing.html',
	'Section: Simple slider' => $templates_dir . 'section-simpleslider.html',
	'Section: LayerSlider' => $templates_dir . 'section-layerslider.html',
	'Section: Icon blocks – 3 cols, large' => $templates_dir . 'section-features-3blocks.html',
	'Section: Icon blocks – 3 cols, med' => $templates_dir . 'section-features-3blocks-medium.html',
	'Section: Icon blocks – 4 cols, med' => $templates_dir . 'section-features-4blocks.html',
	'Section: Image with desc. – 3 cols' => $templates_dir . 'section-features-3blocks-images.html',
	'Section: Intro text block, centered' => $templates_dir . 'section-text-intro-centered.html',
	'Section: Intro text, image on right' => $templates_dir . 'section-text-intro-img-right.html',
	'Section: Text with sidenote' => $templates_dir . 'section-text-and-sidenote.html',
	'Section: Feature image +  text' => $templates_dir . 'section-text-and-image.html',
	'Section: Carousel – projects' => $templates_dir . 'section-freatured-projects.html',
	'Section: Testimonials with logos' => $templates_dir . 'section-testimonials-with-logos.html',
	'Section: Call to action, dark bg' => $templates_dir . 'section-calltoactionline-dark.html',
	'Section: Call to action, large btn' => $templates_dir . 'section-calltoactionline-hugebutton.html',
	'Section: Team member' => $templates_dir . 'section-team-member.html',
	'Section: Client logos ' => $templates_dir . 'section-client-logos.html',
	'Section: Stats / Facts/ Numbers' => $templates_dir . 'section-stats.html',
	'Section: FAQ' => $templates_dir . 'section-faq.html',
	'Section: FAQ - 3 cols' => $templates_dir . 'section-faq.html',
	'Section: Map full width ' => $templates_dir . 'section-gmap-full.html',
	'Section: Alt. page title – image bg ' => $templates_dir . 'section-title-imagebg.html',
));

function update_parallax_background() {

    if (isset($_POST['post_id']) && isset($_POST['shortcode'])) {

        $shortcode = $_POST['shortcode'];

        preg_match_all('/' . get_shortcode_regex() . '/s', $shortcode, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            if ($m[2] == 'vc_row') {
                $atts = shortcode_parse_atts(stripslashes($m[3]));

                if (!empty($atts) && !isset($atts['bg_type'])) {

                    if (!empty($atts['image'])) {
                        $param = WPBMap::getParam('vc_row', 'bg_type');
                        unset($param['value']['Image']);
                        $param['value'] = array('Image' => 'image') + $param['value'];
                        WPBMap::mutateParam('vc_row', $param);

                        $param = WPBMap::getParam('vc_row', 'parallax_style');
                        unset($param['value']['Vertical Parallax On Scroll']);
                        $param['value'] = array('Vertical Parallax On Scroll' => 'vcpb-vz-jquery') + $param['value'];
                        WPBMap::mutateParam('vc_row', $param);

                        $param = WPBMap::getParam('vc_row', 'bg_image_new');
                        $param['value'] = $atts['image'];
                        WPBMap::mutateParam('vc_row', $param);

                        $param = WPBMap::getParam('vc_row', 'bg_override');
                        unset($param['value']['Full Width']);
                        $param['value'] = array('Full Width ' => 'full') + $param['value'];
                        WPBMap::mutateParam('vc_row', $param);
                    }

                    if (!empty($atts['parallax_speed'])) {
                        $speeds = array(
                            'veryslow' => 20,
                            'slow' => 40,
                            'normal' => 60,
                            'fast' => 80,
                            'veryfast' => 100
                        );
                        $param = WPBMap::getParam('vc_row', 'parallax_sense');
                        $param['value'] = $speeds[$atts['parallax_speed']];

                        WPBMap::mutateParam('vc_row', $param);
                    }

                    if (!empty($atts['bg_effect'])) {
                        $effects = array(
                            'parallax' => 'Move with the content',
                            'fixed' => 'Fixed at its position'
                        );
                        $param = WPBMap::getParam('vc_row', 'bg_img_attach');
                        $selected = array($effects[$atts['bg_effect']] => $param['value'][$effects[$atts['bg_effect']]]);
                        unset($param['value'][$effects[$atts['bg_effect']]]);
                        $param['value'] = array_merge($selected, $param['value']);
                        WPBMap::mutateParam('vc_row', $param);
                    }

                    if (!empty($atts['bg_size'])) {
                        $atts['bg_size'] = ($atts['bg_size'] == 'cover' || $atts['bg_size'] == 'contain') ? $atts['bg_size'] : 'initial';
                        $sizes = array(
                            'cover' => 'Cover - Image to be as large as possible',
                            'contain' => 'Contain - Image will try to fit inside the container area',
                            'initial' => 'Initial'
                        );
                        $param = WPBMap::getParam('vc_row', 'bg_image_size');
                        $selected = array($sizes[$atts['bg_size']] => $param['value'][$sizes[$atts['bg_size']]]);
                        unset($param['value'][$sizes[$atts['bg_size']]]);
                        $param['value'] = array_merge($selected, $param['value']);
                        WPBMap::mutateParam('vc_row', $param);
                    }

                    if (!empty($atts['bg_repeat'])) {
                        $repeats = array(
                            'no-repeat' => 'No Repeat',
                            'repeat' => 'Repeat',
                            'repeat-x' => 'Repeat X',
                            'repeat-y' => 'Repeat Y'
                        );

                        $param = WPBMap::getParam('vc_row', 'bg_image_repeat');
                        $selected = array($repeats[$atts['bg_repeat']] => $param['value'][$repeats[$atts['bg_repeat']]]);
                        unset($param['value'][$repeats[$atts['bg_repeat']]]);
                        $param['value'] = array_merge($selected, $param['value']);
                        WPBMap::mutateParam('vc_row', $param);
                    }
                }
            }
        }
    }
}

add_action('admin_init', 'update_parallax_background', 20);