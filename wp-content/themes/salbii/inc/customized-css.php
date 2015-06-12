<?php
/**
 * Customized css.
 * This file decribes the functions responsible for <style> injection
 * with custom colors/fonts setings in the header
 *
 * To optimize WP speed we use Transients API caching provided by WP.
 * Idea and basic implementation by @link https://github.com/aristath
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 *
 * Code based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Some code is based on open-source tools or open-published code snippets
 */

/**
 * ----------------------------------------------------------------------
 * Generate cutomized CSS output
 */

function lbmn_customized_css() {
    
	GLOBAL $theme_settings;
	include( get_template_directory() . '/inc/color.class.php');

	/**
	* ----------------------------------------------------------------------
	* Get setting from theme customizer
	*/

	/** content layout settings 
	*/
	
        $boxed_layout = empty($theme_settings['lbmn_layoutoption_boxed_layout']) ? 0 : $theme_settings['lbmn_layoutoption_boxed_layout'];        
	$boxed_outer_bg_color=!empty($theme_settings['lbmn_content_boxed_outer_bg_color'])?$theme_settings['lbmn_content_boxed_outer_bg_color']:lbmn_LAYOUTOPTION_BOXED_OUTER_BG_COLOR;
   
        $boxed_outer_bg_pattern=!empty($theme_settings['lbmn_content_boxed_outer_bg_pattern'])?$theme_settings['lbmn_content_boxed_outer_bg_pattern']:'';
   	$boxed_outer_bg_pattern_upload=!empty($theme_settings['lbmn_content_boxed_outer_bg_pattern_upload'])?$theme_settings['lbmn_content_boxed_outer_bg_pattern_upload']:'';
   	
   	if(!empty($boxed_outer_bg_pattern_upload) && preg_match("|custom|", $boxed_outer_bg_pattern)) {
   		$boxed_outer_bg_pattern = $boxed_outer_bg_pattern_upload;
   	} else {
   		$boxed_outer_bg_pattern = $boxed_outer_bg_pattern;
   	}

        $page_bg_color=!empty($theme_settings['lbmn_page_bg_color'])?$theme_settings['lbmn_page_bg_color']:lbmn_PAGE_BG_COLOR;
        
        $header_layout = $theme_settings['lbmn_header_layout'];        
        
        $boxed_outer_bg_img_repeat = (empty($theme_settings['lbmn_content_boxed_outer_bg_image_style']) || $theme_settings['lbmn_content_boxed_outer_bg_image_style'] == 'cover') ? 'no-repeat' : $theme_settings['lbmn_content_boxed_outer_bg_image_style'];
        
        $boxed_outer_bg_img_upload = (!empty($theme_settings['lbmn_content_boxed_outer_bg_image_upload'])) ? $theme_settings['lbmn_content_boxed_outer_bg_image_upload'] : '';
        $boxed_outer_type = empty($theme_settings['lbmn_content_boxed_outer_type']) ? 'none':$theme_settings['lbmn_content_boxed_outer_type'];


	/* 
	**/

	$brand_color = $theme_settings['lbmn_brand_color']; $brand_color_obj = new phpColors_Color($brand_color);
	$brand_color_contrast = $theme_settings['lbmn_brand_color_contrast'];

	// $body_bg = ''; //$theme_settings['lbmn_bodybg_color']; // '#' . get_theme_mod( 'background_color' );
	$text_color = $theme_settings['lbmn_text_color'];
	$headings_color = $theme_settings['lbmn_headings_color'];
        
	// Top panel colors        
        $toppanel_bgcolor=!empty($theme_settings['lbmn_toppanel_backgroundcolor'])?$theme_settings['lbmn_toppanel_backgroundcolor']:lbmn_TOPPANEL_BACKGROUNDCOLOR_DEFAULT;
        $toppanel_bgcolor_obj = new phpColors_Color($toppanel_bgcolor);
        
        $toppanel_linkcolor=!empty($theme_settings['lbmn_toppanel_linkcolor'])?$theme_settings['lbmn_toppanel_linkcolor']:lbmn_TOPPANEL_LINKCOLOR_DEFAULT;
        $toppanel_linkcolor_obj = new phpColors_Color($toppanel_linkcolor);
        
        $toppanel_linkcolor_hover=!empty($theme_settings['lbmn_toppanel_linkhovercolor'])?$theme_settings['lbmn_toppanel_linkhovercolor']:lbmn_TOPPANEL_LINKHOVERCOLOR_DEFAULT;
        $toppanel_linkcolor_hover_obj = new phpColors_Color($toppanel_linkcolor_hover);
        
        $toppanel_textcolor=!empty($theme_settings['lbmn_toppanel_textcolor'])?$theme_settings['lbmn_toppanel_textcolor']:lbmn_TOPPANEL_TEXTCOLOR_DEFAULT;
        $toppanel_textcolor_obj = new phpColors_Color($toppanel_textcolor);        
                
	$toppanel_fontstyling_left = get_theme_mod( 'lbmn_toppanel_fontstyling_left', 'medium' );
	$toppanel_fontstyling_right = get_theme_mod( 'lbmn_toppanel_fontstyling_right', 'medium' );
	$toppanel_height = get_theme_mod( 'lbmn_toppanel_height', 'medium' );
        
        
	// Header top colors
	$headertop_bgcolor = $theme_settings['lbmn_header_bgcolor'];
	$headertop_linkcolor = $theme_settings['lbmn_header_linkcolor']; $headertop_linkcolor_obj = new phpColors_Color($headertop_linkcolor);
	$headertop_linkcolor_hover = $theme_settings['lbmn_header_linkhovercolor'];  $headertop_linkcolor_hover_obj = new phpColors_Color( $headertop_linkcolor_hover);
	$headertop_textcolor = $theme_settings['lbmn_header_textcolor']; $headertop_textcolor_obj = new phpColors_Color($headertop_textcolor);
	$headertop_fontstyling_left = $theme_settings['lbmn_header_menustyling'];
	$headertop_fontstyling_right = $theme_settings['lbmn_header_menustyling'];
	$header_menu_bgcolor = $theme_settings['lbmn_menu_bgcolor'];
	$header_menu_bordercolor = $theme_settings['lbmn_menu_bordercolor'];
	$header_logo = $theme_settings['lbmn_logo_image'];        
        
        $header_opacity = empty($theme_settings['lbmn_header_opacity'])? 1 : $theme_settings['lbmn_header_opacity'] / 100;        
        $headertop_bgcolor_string = 'rgba(' . lmmn_hex2rgb($headertop_bgcolor) . ','.$header_opacity.')';
        $header_menu_bgcolor_string = 'rgba(' . lmmn_hex2rgb($header_menu_bgcolor) . ','.$header_opacity.')';
        
        // Footer 
        $footer_bgcolor=!empty($theme_settings['lbmn_footer_backgroundcolor'])?$theme_settings['lbmn_footer_backgroundcolor']:lbmn_FOOTER_BACKGROUNDCOLOR_DEFAULT;
        $footer_bgcolor_obj = new phpColors_Color($footer_bgcolor);
        
        $footer_linkcolor=!empty($theme_settings['lbmn_footer_linkcolor'])?$theme_settings['lbmn_footer_linkcolor']:lbmn_FOOTER_LINKCOLOR_DEFAULT;
        $footer_linkcolor_obj = new phpColors_Color($footer_linkcolor);
        
        $footer_linkcolor_hover=!empty($theme_settings['lbmn_footer_linkhovercolor'])?$theme_settings['lbmn_footer_linkhovercolor']:lbmn_FOOTER_LINKHOVERCOLOR_DEFAULT;
        $footer_linkcolor_hover_obj = new phpColors_Color($footer_linkcolor_hover);
        
        $footer_textcolor=!empty($theme_settings['lbmn_footer_textcolor'])?$theme_settings['lbmn_footer_textcolor']:lbmn_FOOTER_TEXTCOLOR_DEFAULT;
        $footer_textcolor_obj = new phpColors_Color($footer_textcolor);  
        
        // Footer menu
        $footer_menu_linkcolor=!empty($theme_settings['lbmn_footer_menu_linkcolor'])?$theme_settings['lbmn_footer_menu_linkcolor']:lbmn_FOOTER_MENU_LINKCOLOR_DEFAULT;
        $footer_menu_linkcolor_obj = new phpColors_Color($footer_menu_linkcolor);
        
        $footer_menu_linkcolor_hover=!empty($theme_settings['lbmn_footer_menu_linkhovercolor'])?$theme_settings['lbmn_footer_menu_linkhovercolor']:lbmn_FOOTER_MENU_LINKHOVERCOLOR_DEFAULT;
        $footer_menu_linkcolor_hover_obj = new phpColors_Color($footer_menu_linkcolor_hover);

	// $styles = "<style type='text/css' id ='" . lbmn_THEME_NAME . "_customized_css'>\n";
	$styles ='';
	/**
	* ----------------------------------------------------------------------
	* Text and content
	*/
	$styles .= "body {";
	// $styles .= "background-color:$body_bg;";
	$styles .= "color:$text_color;";
	$styles .= "}";


	/* layout options 
	*/
        $styles .= "body.boxed-layout .global-wrapper { width:100%; margin:auto; max-width:1100px; }";
        $styles .= "body.boxed-layout .global-wrapper { background-color: $page_bg_color }";
        $styles .= "body.boxed-layout .main-section { background-color: $boxed_outer_bg_color; }";
        
        if($boxed_layout == '1'){            
            
            if($boxed_outer_type == 'pattern'){
                $styles .= "body .main-section { background-image: url('$boxed_outer_bg_pattern'); }";

            }elseif($boxed_outer_type == 'image'){
                $styles .= "body .main-section {  background-image: url('$boxed_outer_bg_img_upload'); }";
            }                                   
        }
        
        $styles .= "body.boxed-layout .site-header.animated { left: auto !important; right: auto !important; }";
        
        
        
        


        //header opacity
//        $styles .= 'header.site-header {opacity: '.$header_opacity.'}';


	// ohter cases were we use background color
	$styles .= ".comment-content:before,";
	// vc composer
	$styles .= "body .wpb_content_element .wpb_tabs_nav li.ui-tabs-active, body .wpb_content_element.wpb_tabs .wpb_tour_tabs_wrapper .wpb_tab, .vc_text_separator div";
	// $styles .= "{ background-color:$body_bg; }";


	// other cases when we use body text color for elements
	$styles .= "h1, h2, h3, h4, h5, h6, .wpb_heading ";
	$styles .= "{ color:$headings_color; }";

	// other cases when we use body text color for elements
	$styles .= ".widget-title, label, ";
	$styles .= ".comment-author a, .comment-meta a, ";
	$styles .= ".isotope-item .post-categories a, .isotope-item .entry-meta a,";
	// vc elements
	$styles .= "body .wpb_tour .wpb_tour_tabs_wrapper .wpb_tabs_nav a,";
	// form elements
	$styles .= 'input[type="text"], input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], textarea ';
	$styles .= "{ color:$text_color; }";

	$styles .= "a, .site-footer a:hover, .site-footer .side-nav li a:hover, body .brand-color, label .required, .side-nav li a { color: $brand_color; }";
	$styles .= "a:hover, a:focus { color:#" . $brand_color_obj->darken(15) ."; }\n";
	$styles .= "body .button.border {background-color: transparent; border-color: $brand_color; color: $brand_color; }";
	$styles .= "body .brand-bgcolor, body .brand_bgcolor, .widget-title:after, body .wpb_heading:after,";
	$styles .= "body .button, .button:focus, button:focus { background-color: $brand_color; }";
	$styles .= "body .button, .button:hover, .button:focus, body .brand-color-contrast { color: $brand_color_contrast; }";
	$styles .= "body .brand-color-contrast-children * { color: $brand_color_contrast; }";
	$styles .= "body .brand-color-contrast-children-important * { color: $brand_color_contrast!important; }";

	$styles .= "body .button:hover { background-color: #" . $brand_color_obj->darken(7) ."; }";
	$styles .= "body .button.border:hover { background-color: $brand_color; color: $brand_color_contrast; }";

	$styles .= "body .brand_bordercolor, body .wpb_call_to_action.border.brand_bordercolor { border-color: $brand_color; }";
	$styles .= "body .brand-contrast_bordercolor { border-color: $brand_color_contrast; }";

	$styles .= "body .button.brand-contrast_bordercolor { border-color: $brand_color_contrast; color: $brand_color_contrast; }";
	$styles .= "body .button.brand-contrast_bordercolor:hover { background-color: $brand_color_contrast; color: $brand_color; }";

	$styles .= ".wpb_separator.brand-color { border-bottom-color: $brand_color; }"; // colored content separator
	$styles .= ".wpb_single_image a:before { background-color: $brand_color; }"; // image hover color overlay

	$styles .= "body .wpb_call_to_action.hardshadow.brand_bgcolor { background-color: $brand_color;}";
	$styles .= "body .wpb_call_to_action.brand_bgcolor * { color: $brand_color_contrast;}";
	$styles .= "body .wpb_call_to_action.brand_bgcolor .button,";
	$styles .= "body .wpb_call_to_action.brand_bgcolor .button .icon ";
	$styles .= "{background-color: $brand_color_contrast; color: $brand_color!important; }\n";
	$styles .= "body .wpb_call_to_action.brand_bgcolor .button.border {background-color:  transparent!important; border-color: $brand_color_contrast!important;  color: $brand_color_contrast!important;}\n";


	/* Brand the selection */
	$styles .= "::-moz-selection { color: $brand_color_contrast;  background: $brand_color; }";
	$styles .= "::selection      { color: $brand_color_contrast;  background: $brand_color; }";

	// Text in Zurb Navigation
	$top_panel_height='40px';
	$styles .= ".top-bar__text-line { line-height: $top_panel_height; }";

	/**
	* ----------------------------------------------------------------------
	* Top bar common styles
	*/

	$styles .= ".top-bar .menu > li > .dropdown:after { border-bottom: 4px solid $brand_color; }";
	$styles .= ".top-bar .menu > li > .dropdown:before { color: $brand_color; }";

	function font_styling_customize( $area_html_address, $area_section, $font_style ) {
		$output_styles = '';
		$font_size_small = "0.75em";//12px
		$font_size_large = "1em";//16px

		switch ( $font_style ) {
			case 'small':
				$output_styles	.= "\n$area_html_address .menu.$area_section > li > a, $area_html_address-text-$area_section { font-size: $font_size_small;}";
				break;
			case 'large':
				$output_styles	.= "$area_html_address .menu.$area_section > li > a, $area_html_address-text-$area_section { font-size: $font_size_large;}";
				break;
			case 'caps-small':
				$output_styles	.= "$area_html_address .menu.$area_section > li > a, $area_html_address-text-$area_section { font-size: $font_size_small; text-transform: uppercase; letter-spacing: 0px;}";
				break;
			case 'caps-medium':
				$output_styles	.= "$area_html_address .menu.$area_section > li > a, $area_html_address-text-$area_section { text-transform: uppercase; letter-spacing: 1px;}";
				break;
			case 'caps-large':
				$output_styles	.= "$area_html_address .menu.$area_section > li > a, $area_html_address-text-$area_section { font-size: $font_size_large; text-transform: uppercase; letter-spacing: 1px;}";
				break;
			default:
				# leave as it is in scss
				break;
		}
		return $output_styles;
	}


	/**
	* ----------------------------------------------------------------------
	* Top panel
	*/

	$styles .= ".toppanel { background-color: $toppanel_bgcolor; color: $toppanel_linkcolor; }";
	$styles .= ".toppanel .top-bar__text-line {color: $toppanel_textcolor!important; }";
	$styles .= ".toppanel .has-dropdown > a:after { border-color: " . $toppanel_linkcolor_obj->getCssRgba(0.2) . " transparent transparent transparent; }";
	$styles	.= ".toppanel a, .toppanel .search-button { color: $toppanel_linkcolor!important; }";
	$styles	.= ".toppanel a:hover, .toppanel .search-button:hover, .toppanel .menu-item:hover > a { color: $toppanel_linkcolor_hover!important; }";

	$styles .= ".toppanel .search-block .search-field, .toppanel .search-block .search-field:focus { background-color: #3C3C3C; color: $toppanel_textcolor; }";

	// Top panel: Left Icons without labels
	if ( get_theme_mod( 'lbmn_toppanel_icons_left_nolabel' ) ) {
		$icon_menu_id = get_theme_mod( 'lbmn_toppanel_icons_left');

		$styles	.= ".top-bar-section .menuid-$icon_menu_id .menu-item-with-icon { letter-spacing: -4px; }"; // compensate &nbsp; width
		$styles	.= ".top-bar-section .menuid-$icon_menu_id .menu-item__icon-label { display:none; }";
	}

	// Top panel: Right Icons without labels
	if ( get_theme_mod( 'lbmn_toppanel_icons_right_nolabel' ) ) {
		$icon_menu_id = get_theme_mod( 'lbmn_toppanel_icons_right');

		$styles	.= ".top-bar-section .menuid-$icon_menu_id .menu-item-with-icon { letter-spacing: -4px; }"; // compensate &nbsp; width
		$styles	.= ".top-bar-section .menuid-$icon_menu_id .menu-item__icon-label { display:none; }";
	}

	// Font styling
	$styles	.= font_styling_customize( '.toppanel', 'left', $toppanel_fontstyling_left );
	$styles	.= font_styling_customize( '.toppanel', 'right', $toppanel_fontstyling_right );

	/**
	* ----------------------------------------------------------------------
	* Header top area
	*/      
        
	$styles .= ".headertop { background-color: $headertop_bgcolor_string; color: $headertop_linkcolor; }";
	$styles .= ".headertop .top-bar__text-line {color: $headertop_textcolor!important; }";
	$styles .= ".headertop .additional-header-text {color: $headertop_textcolor!important; }";
	
	$styles .= ".headertop .has-dropdown > a:after { border-color: " . $headertop_linkcolor_obj->getCssRgba(0.2) . " transparent transparent transparent; }";
	$styles	.= ".headertop a, .headertop .search-button { color: $headertop_linkcolor!important; }";
	$styles	.= ".headertop a:hover, .headertop .search-button:hover, .headertop .menu-item:hover > a { color: $headertop_linkcolor_hover!important; }";

	// active menu item decoration
	$styles .= ".headertop .top-bar-section ul.menu > li.active > a { color: $headertop_linkcolor_hover!important; }";
	$styles .= ".headertop .top-bar-section ul.menu > li.active > a:before, .top-bar-section ul.menu > li:hover > a:before { background-color: $brand_color; }";


	// mobile menu toggle
	$styles	.= ".top-bar .toggle-topbar.menu-icon a span, .top-bar.expanded .toggle-topbar a span { ";
	$styles	.= "box-shadow: 0 10px 0 1px $headertop_linkcolor, 0 16px 0 1px $headertop_linkcolor, 0 22px 0 1px $headertop_linkcolor;";
	$styles	.= "}";

	$styles	.= "body .top-bar .toggle-topbar.menu-icon a:hover span, body .top-bar.expanded .toggle-topbar a:hover span { ";
	$styles	.= "box-shadow: 0 10px 0 1px $headertop_linkcolor_hover, 0 16px 0 1px $headertop_linkcolor_hover, 0 22px 0 1px $headertop_linkcolor_hover;";
	$styles	.= "}";

	// call to action button in the header
	$styles .= ".headertop .additional-header-text a.button ";
	$styles .= "{color: $brand_color_contrast!important; }";

	// header menu background and dividers colors
	$styles .= ".header-layout-2 .top-bar-section:before, .header-layout-3 .top-bar-section:before { background-color: $header_menu_bgcolor_string; border-top-color: $header_menu_bordercolor; width: 100%; }";

	// Header top: Left Icons without labels
	if ( get_theme_mod( 'lbmn_headertop_icons_left_nolabel' ) ) {
		$icon_menu_id = get_theme_mod( 'lbmn_headertop_icons_left');

		$styles	.= ".top-bar-section .menuid-$icon_menu_id .menu-item-with-icon { letter-spacing: -4px; }"; // compensate &nbsp; width
		$styles	.= ".top-bar-section .menuid-$icon_menu_id .menu-item__icon-label { display:none; }";
	}

	// Header top: Right Icons without labels
	if ( get_theme_mod( 'lbmn_headertop_icons_right_nolabel' ) ) {
		$icon_menu_id = get_theme_mod( 'lbmn_headertop_icons_right');

		$styles	.= ".top-bar-section .menuid-$icon_menu_id .menu-item-with-icon { letter-spacing: -4px; }"; // compensate &nbsp; width
		$styles	.= ".top-bar-section .menuid-$icon_menu_id .menu-item__icon-label { display:none; }";
	}

	// Font styling
	$styles	.= font_styling_customize( '.headertop', 'left', $headertop_fontstyling_left );
	$styles	.= font_styling_customize( '.headertop', 'right', $headertop_fontstyling_right );


	/**
	* ----------------------------------------------------------------------
	* Header logo
	*/
        /* V1.0 START

	// get logo dimensions
	$logo_attachment_id = lbmn_get_attachment_id_from_url($header_logo);
	$logo_image_meta = wp_get_attachment_image_src( $logo_attachment_id, 'full');
	$logo_image_width = $logo_image_meta[1];
	$logo_image_height = $logo_image_meta[2];
	$custom_logo_image_width = $custom_logo_image_height = 0;

	// check if custom logo width is set
	if ( isset( $theme_settings['lbmn_logo_width'] )) {
		$custom_logo_image_width = floatval( $theme_settings['lbmn_logo_width'] );
		if ( $custom_logo_image_width != 0 ) {
			$logo_image_height = $custom_logo_image_width / ( $logo_image_width / $logo_image_height );
			$logo_image_width = $custom_logo_image_width;
		}
	}

	// if image logo uploaded
	if($logo_attachment_id) {
		$styles	.= ".top-bar-with-logo .header-logo img {width:{$logo_image_width}px;}";

		$custom_logo_margin_top = 0;
		// if custom logo margin-top is set
		if ( isset( $theme_settings['lbmn_logo_margin_top'] )) {
			$custom_logo_margin_top = floatval( $theme_settings['lbmn_logo_margin_top'] );
			if ( $custom_logo_margin_top != 0 ) {
				$styles	.= ".top-bar-with-logo .header-logo img {margin-top:{$custom_logo_margin_top}px;}";
			}
		}


		// verticaly balance image logos
		if ( $top_panel_height < $logo_image_height ) {
			// creating pseudo element with height needed to balance too hight logos
			$styles .= ".top-bar-with-logo:before {content: '';position: relative;width: 100%;height: ".( ($logo_image_height - $top_panel_height) /2 )."px;display: block;}";
			// verticaly balance logos by adding negative margin top
			$styles	.= ".top-bar-with-logo .header-logo {margin-top:-".( ($logo_image_height - $top_panel_height) /2)."px;}";
		} else {
			$logo_margin_top = ($top_panel_height - $logo_image_height) / 2;
			$styles	.= ".top-bar-with-logo .header-logo {margin-top:".$logo_margin_top."px;}";
		}

	} //else { // if text logo used

	// add normal logo width/height to retina logo
	$styles	.= "img.header-logo__retina {width:".$logo_image_width."px; height:".$logo_image_height."px;}";

V1.0 END */

	/* SINCE V1.1 */
	if($header_logo && $logo_image_meta = @getimagesize($header_logo)) {
	
		$logo_image_width = $logo_image_meta[0];
		$logo_image_height = $logo_image_meta[1];
	
		$custom_logo_image_width = $custom_logo_image_height = 0;
	
		// check if custom logo width is set
		if ( isset( $theme_settings['lbmn_logo_width'] )) {
			$custom_logo_image_width = floatval( $theme_settings['lbmn_logo_width'] );
			if ( $custom_logo_image_width != 0 && $logo_image_height != 0 && ( $logo_image_width / $logo_image_height ) ) {
				$logo_image_height = $custom_logo_image_width / ( $logo_image_width / $logo_image_height );
				$logo_image_width = $custom_logo_image_width;
			}
		}
	
		// if image logo uploaded
		$styles	.= ".top-bar-with-logo .header-logo img {width:{$logo_image_width}px;}";
	
		$custom_logo_margin_top = 0;
		// if custom logo margin-top is set
		if ( isset( $theme_settings['lbmn_logo_margin_top'] )) {
			$custom_logo_margin_top = floatval( $theme_settings['lbmn_logo_margin_top'] );
			if ( $custom_logo_margin_top != 0 ) {
				$styles	.= ".top-bar-with-logo .header-logo img {margin-top:{$custom_logo_margin_top}px;}";
			}
		}
	
		// if custom logo margin-bottom is set
		if ( isset( $theme_settings['lbmn_logo_margin_bottom'] )) {
			$custom_logo_margin_bottom = floatval( $theme_settings['lbmn_logo_margin_bottom'] );
			if ( $custom_logo_margin_bottom != 0 ) {
				$styles	.= ".top-bar-with-logo .header-logo img {margin-bottom:{$custom_logo_margin_bottom}px;}";
			}
		}
	
		// verticaly balance image logos
		/* if ( $top_panel_height < $logo_image_height ) {
			// creating pseudo element with height needed to balance too hight logos
			// $styles .= ".top-bar-with-logo:before {content: '';position: relative;width: 100%;height: ".( ($logo_image_height - $top_panel_height) /2 )."px;display: block;}";
			// verticaly balance logos by adding negative margin top
			$styles	.= ".top-bar-with-logo .header-logo {";
			$styles	.= 	"margin-top:-".( ($logo_image_height - $top_panel_height) /2)."px;";
			$styles	.= 	"margin-bottom:-".( ($logo_image_height - $top_panel_height) /2)."px;";
			$styles	.= "}";
		} else {
			$logo_margin_top = ($top_panel_height - $logo_image_height) / 2;
			$styles	.= ".top-bar-with-logo .header-logo {margin-top:".$logo_margin_top."px;}";
		} */
	
		// add normal logo width/height to retina logo
		$styles	.= "img.header-logo__retina {width:".$logo_image_width."px}";
	
	}



	/**
	* ----------------------------------------------------------------------
	* Search field styling (header areas)
	*/

	$styles	.=  ".headertop .search-block .search-field, .search-block .search-field:focus { background-color: $headertop_bgcolor_string;}"; //$header_search_inputbgcolor
	// Search results page
	$styles	.=  ".searchpage-searchform input[type='search'] { background: $brand_color_contrast; border: none;}";

	/**
	* ----------------------------------------------------------------------
	* Mega menu styling
	*/

	$styles	.= "body .megamenu-parent:hover > .megamenu-sub-menu {";
	$styles	.= "border-top: solid 4px $brand_color;";
	$styles	.= "}";

	$styles	.= "body .megamenu-parent:hover:after {";
	$styles	.= "border-color: transparent transparent $brand_color;";
	$styles	.= "}";

	// form focus
	$styles  .= 'body .megamenu-parent:hover > .megamenu-sub-menu input[type="text"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="password"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="date"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="datetime"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="datetime-local"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="month"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="week"]:focus, input[type="email"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="number"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="search"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="tel"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="time"]:focus, body .megamenu-parent:hover > .megamenu-sub-menu input[type="url"]:focus, textarea:focus {';
	$styles  .= "	border-color: $brand_color;";
	$styles  .= "}";

	/**
	* ----------------------------------------------------------------------
	* Side navigation
	*/

	$styles  .= ".site-content .widget .side-nav > li:hover a:first-child,";
	$styles  .= ".site-content .widget .side-nav > li.active a:first-child { color: $brand_color; }";

	// Tag cloud
	$styles  .= ".tagcloud a:hover { background-color: $brand_color; color: $brand_color_contrast;  }";

	/**
	* ----------------------------------------------------------------------
	* Visual Composer Components
	*/

	$styles  .= ".wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header:hover a,";
	$styles  .= ".wpb_accordion .wpb_accordion_wrapper .ui-state-active.wpb_accordion_header a,";
	$styles  .= ".wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header:hover .ui-icon,";
	$styles  .= ".wpb_content_element .wpb_tabs_nav li.ui-tabs-active a,";
	$styles  .= ".wpb_content_element .wpb_tabs_nav li:hover a,";
	$styles  .= ".wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover";
	$styles  .= "{ color: $brand_color; }";

	// Accordion & FAQ
	$styles  .= ".wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-state-active,";
	$styles  .= ".wpb_toggle.wpb_toggle_title_active";
	// $styles  .= ".wpb_content_element .wpb_tabs_nav li.ui-tabs-active";
	$styles  .= "{ border-top: 3px solid $brand_color; }";

	$styles  .= ".wpb_content_element .wpb_tabs_nav li.ui-tabs-active > a:before";
	$styles  .= "{ background: $brand_color; }";

	// Icons
	$styles  .= ".vc_iconbox.plain .icon:first-child { background-color: $brand_color; color: $brand_color_contrast; }";
	$styles  .= ".vc_iconbox.border .icon:first-child { border-color: $brand_color; color: $brand_color; }";
	$styles  .= ".vc-icon-effect-1a .effect-helper { box-shadow: 0 0 0 2px $brand_color; }";

	// Masonry grid ( used for portfolio / blog index / post teasers )
	$styles  .= ".isotope-item .post-thumb,";
	$styles  .= ".wpb_teaser_grid_lbmn_project .post-title:before,";
	$styles  .= ".vc_carousel .post-title:before";
	$styles  .= "{ background-color: $brand_color; }";

	// Post format specific styles
	$styles  .= ".isotope-item .colored-card-part";
	$styles  .= "{ background-color: $brand_color; }";

	$styles  .= ".isotope-item .colored-card-part *";
	$styles  .= "{ color: $brand_color_contrast!important; }";


	// Call to action block
	// Inverse primary button on primary color block

	$styles  .= "body .wpb_call_to_action.brand-bgcolor .button, ";
	$styles  .= "body .wpb_call_to_action.brand-bgcolor .button *";
	$styles  .= "{ background-color: $brand_color_contrast; color: $brand_color; }";

	$styles  .= "body .wpb_call_to_action.brand-bgcolor .button.border, ";
	$styles  .= "body .wpb_call_to_action.brand-bgcolor .button.border *";
	$styles  .= "{ background-color: transparent; border-color: $brand_color_contrast; color: $brand_color_contrast; }";

	/**
	* ----------------------------------------------------------------------
	* Form Elements
	*/

	// form focus
	$styles  .= 'input[type="text"]:focus, input[type="password"]:focus, input[type="date"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="month"]:focus, input[type="week"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="time"]:focus, input[type="url"]:focus, textarea:focus {';
	$styles  .= "	border-color: $brand_color;";
	$styles  .= "}";

	/**
	* ----------------------------------------------------------------------
	* Blog post
	*/

	$styles  .= ".author-info { border-bottom-color: $brand_color; }";
	$styles  .= ".post-footer-meta a:hover { background: $brand_color; border-color: $brand_color; color: $brand_color_contrast; }";

	/**
	* ----------------------------------------------------------------------
	* Fonts definisions
	*/

	if ( ! function_exists( 'lbmn_get_fontfamily' ) ) :
	function lbmn_get_fontfamily($settingname__standard_font_name, $settingname__custom_font_name = '') {
		GLOBAL $theme_settings;

		// Get values set in theme settings panel
		$standard_font_name = $theme_settings[$settingname__standard_font_name];
		$custom_font_name = @$theme_settings[$settingname__custom_font_name];
		$custom_font_weight = '';
                $custom_font_italic = '';

		// Set alternative fonts for standard font-family
		/* http://kv5r.com/articles/dev/font-family.asp */
		switch ($standard_font_name) {
			case 'arial':
				$standard_font_name = "Arial,'DejaVu Sans','Liberation Sans',Freesans,sans-serif";
				break;
			case 'helvetica':
				$standard_font_name = "Helvetica,Arial,'DejaVu Sans','Liberation Sans',Freesans,sans-serif";
				break;
			case 'lucida-sans-unicode':
				$standard_font_name = "'Lucida Sans Unicode','Lucida Grande','Lucida Sans','DejaVu Sans Condensed',sans-serif";
				break;
			case 'century-gothic':
				$standard_font_name = "'Century Gothic',futura,'URW Gothic L',Verdana,sans-serif";
				break;
			case 'arial-narrow':
				$standard_font_name = "'Arial Narrow','Nimbus Sans L',sans-serif";
				break;
			case 'impact':
				$standard_font_name = "Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif";
				break;
			case 'arial-black':
				$standard_font_name = "'Arial Black',Gadget,sans-serif";
				break;
			case 'cambria':
				$standard_font_name = "Cambria,'Palatino Linotype','Book Antiqua','URW Palladio L',serif";
				break;
			case 'verdana':
				$standard_font_name = "Verdana,Geneva,'DejaVu Sans',sans-serif";
				break;
			case 'constantia':
				$standard_font_name = "Constantia,Georgia,'Nimbus Roman No9 L',serif";
				break;
			case 'bookman-old-style':
				$standard_font_name = "'Bookman Old Style',Bookman,'URW Bookman L','Palatino Linotype',serif";
				break;
			default:
				$standard_font_name = "'Helvetica Neue',Helvetica,Arial,'DejaVu Sans','Liberation Sans',Freesans,sans-serif";
				break;
		}

		if ( $custom_font_name ) {
                        
			$string_to_filter = $custom_font_name;
			$custom_font_name = preg_replace("/(.*)\:(\w*)/", "$1", $string_to_filter);
			$custom_font_name = "'" . str_replace("+", " ", $custom_font_name) . "', ";
			$custom_font_weight = preg_replace("/(.*)\:(\w*)/", "$2", $string_to_filter);
			if(strpos($string_to_filter, 'italic') !== false){
				$custom_font_italic = 'italic';
			}
			switch ( $custom_font_weight ) {
			 	case 'regular':
			 		$custom_font_weight = 400;
			 		break;
			 	case 'bold':
			 		$custom_font_weight = 600;
			 		break;

			 	default:
			 		$custom_font_weight = intval($custom_font_weight);
			 		break;
			}
		

                    $custom_font = $custom_font_name. $standard_font_name;

                    $output = array('font-family' => $custom_font, 'font-weight' => $custom_font_weight, 'font-style' => $custom_font_italic);
                }else{
                    $output = array('font-family' => $standard_font_name, 'font-weight' => 'normal', 'font-style' => 'normal');
                }
		return $output;
	}
	endif; // lbmn_add_websafe_fonts

	$typography_font_headings = '';
	$typography_font_body = '';


	// Header font
	// Set font-family value for website header text
	$header_fontsettings = '';

	switch ( $theme_settings['lbmn_header_font_type'] ) {
		case 'standard':
			$header_fontsettings = lbmn_get_fontfamily( 'lbmn_header_standardfont' );
			break;
		case 'another':
			$header_fontsettings = lbmn_get_fontfamily( 'lbmn_header_standardfont', 'lbmn_header_font_type_another' );
			break;
		default: // google
			$header_fontsettings = lbmn_get_fontfamily( 'lbmn_header_standardfont', 'lbmn_header_font_type_google');
			break;
	}
	$header_fontfamily = $header_fontsettings['font-family'];
	$header_fontweight = $header_fontsettings['font-weight'];
	$header_fontstyle = $header_fontsettings['font-style'];

	$styles .= ".headertop, .headertop .menu-item__icon-label, .headerbottom {";
	$styles .= "font-family: $header_fontfamily;";
		if ( $header_fontweight ) {
			$styles .= "font-weight: ".$header_fontweight."!important;";
		}
		if ( $header_fontstyle ) {
			$styles .= "font-weight: ".$header_fontstyle."!important;";
		}
	$styles .= "}";

	// Title font
	// Set font-family value for website titles
	$title_fontsettings = '';

	switch ( $theme_settings['lbmn_title_font_type'] ) {
		case 'standard':
			$title_fontsettings = lbmn_get_fontfamily( 'lbmn_title_standardfont' );
			break;
		case 'another':
			$title_fontsettings = lbmn_get_fontfamily( 'lbmn_title_standardfont', 'lbmn_title_font_type_another' );
			break;
		default: // google
			$title_fontsettings = lbmn_get_fontfamily( 'lbmn_title_standardfont', 'lbmn_title_font_type_google');
			break;
	}
	$title_fontfamily = $title_fontsettings['font-family'];
	$title_fontweight = $title_fontsettings['font-weight'];
	$title_fontstyle = $title_fontsettings['font-style'];
	$title_bgcolor = $theme_settings['lbmn_title_bgcolor'];
	$title_textcolor = $theme_settings['lbmn_title_textcolor'];

	$styles .= ".page-title {";
	$styles .= "background: $title_bgcolor;";
	$styles .= "}";
	$styles .= ".page-title *, .page-title *:before {";
	$styles .= "color: {$title_textcolor}!important;";
	$styles .= "}";

	$styles .= ".page-title, .page-title__primary-title {";
	$styles .= "font-family: $title_fontfamily;";
	if ( $title_fontweight ) {
		$styles .= "font-weight: $title_fontweight;";
	}
	if ( $title_fontstyle ) {
			$styles .= "font-style: $title_fontstyle;";
		}
	$styles .= "}";


	// Footer font
	// Set font-family value for website footer
	$footer_fontsettings = '';

	switch ( $theme_settings['lbmn_footer_font_type'] ) {
		case 'standard':
			$footer_fontsettings = lbmn_get_fontfamily( 'lbmn_footer_standardfont' );
			break;
		case 'another':
			$footer_fontsettings = lbmn_get_fontfamily( 'lbmn_footer_standardfont', 'lbmn_footer_font_type_another' );
			break;
		default: // google
			$footer_fontsettings = lbmn_get_fontfamily( 'lbmn_footer_standardfont', 'lbmn_footer_font_type_google');
			break;
	}
	$footer_fontfamily = $footer_fontsettings['font-family'];
	$footer_fontweight = $footer_fontsettings['font-weight'];
	$footer_fontstyle = $footer_fontsettings['font-style'];

	$styles .= ".site-footer {";
        $styles .="background-color: $footer_bgcolor;";
        $styles .="color: $footer_textcolor;";
        
        
	$styles .= "font-family: $footer_fontfamily;";
	if ( $footer_fontweight ) {
		$styles .= "font-weight: $footer_fontweight;";
	}
	if ( $footer_fontstyle ) {
		$styles .= "font-style: $footer_fontstyle;";
	}
	$styles .= "}";
        
        $styles .=".site-footer a, .site-footer .side-nav li a {";        
        $styles .="color: $footer_linkcolor;";        
        $styles .= "}";
        
        $styles .=".site-footer a:hover, .site-footer .side-nav li a:hover{";        
        $styles .="color: $footer_linkcolor_hover;";        
        $styles .= "}";
        
        //footer menu
        $styles .=".site-footer__menu .top-bar-section ul.menu li.active > a {";
        $styles .="color: $footer_menu_linkcolor_hover;";
        $styles .= "}";

        $styles .=".site-footer__menu .top-bar-section ul.menu li > a {";
        $styles .="color: $footer_menu_linkcolor;";
        $styles .= "}";
        
        $styles .=".site-footer__menu .top-bar-section ul.menu li > a:hover {";
        $styles .="color: $footer_menu_linkcolor_hover;";
        $styles .= "}";
        
        
	// Body font
	// Set font-family value for website body
	$body_fontsettings = '';

	switch ( $theme_settings['lbmn_body_font_type'] ) {
		case 'standard':
			$body_fontsettings = lbmn_get_fontfamily( 'lbmn_body_standardfont' );
			break;
		case 'another':
			$body_fontsettings = lbmn_get_fontfamily( 'lbmn_body_standardfont', 'lbmn_body_font_type_another' );
			break;
		default: // google
			$body_fontsettings = lbmn_get_fontfamily( 'lbmn_body_standardfont', 'lbmn_body_font_type_google');
			break;
	}
	$body_fontfamily = $body_fontsettings['font-family'];
	$body_fontweight = $body_fontsettings['font-weight'];
	$body_fontstyle = $body_fontsettings['font-style'];
	$styles .= "body {";
	$styles .= "font-family: $body_fontfamily;";
	if ( $body_fontweight ) {
		$styles .= "font-weight: $body_fontweight;";
	}
	if ( $body_fontstyle ) {
		$styles .= "font-style: $body_fontstyle;";
	}
	$styles .= "}";


	// Headings font
	// Set font-family value for website Headings
	$headings_fontsettings = '';

	switch ( $theme_settings['lbmn_headings_font_type'] ) {
		case 'standard':
			$headings_fontsettings = lbmn_get_fontfamily( 'lbmn_headings_standardfont' );
			break;
		case 'another':
			$headings_fontsettings = lbmn_get_fontfamily( 'lbmn_headings_standardfont', 'lbmn_headings_font_type_another' );
			break;
		default: // google
			$headings_fontsettings = lbmn_get_fontfamily( 'lbmn_headings_standardfont', 'lbmn_headings_font_type_google');
			break;
	}
	$headings_fontfamily = $headings_fontsettings['font-family'];
	$headings_fontweight = $headings_fontsettings['font-weight'];

	$styles .= "h1, h2, h3, h4, h5, h6 {";
	$styles .= "font-family: $headings_fontfamily;";
	if ( $headings_fontweight ) {
		$styles .= "font-weight: $headings_fontweight;";
	}
	$styles .= "}";



	// $styles .= "\n</style>";
	return $styles;
}

/**
 * Set cache for 24 hours
 */
function lbmn_customized_css_cache() {
	$data = get_transient( 'lbmn_customized_css' );
	if ( $data === false ) {
		$data = lbmn_customized_css();
		set_transient( 'lbmn_customized_css', $data, 3600 * 24 );
	}
//	$custom_css = "\n<!-- Customized CSS: Start -->\n";
	$custom_css = $data;
//	$custom_css .= "\n<!-- Customized CSS: End -->\n";

	// Custom CSS
	GLOBAL $theme_settings;
	$user_css = htmlspecialchars_decode($theme_settings['lbmn_css']);
	//pa($user_css,1);
	if ( $user_css ) {

		$custom_css .= "\n<!-- User CSS: Start -->\n";
		$custom_css .= $user_css;
		$custom_css .= "\n<!-- User CSS: End -->\n";
	}
	
	wp_add_inline_style( 'lbmn-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'lbmn_customized_css_cache', 199);
// add_action( 'wp_head', 'lbmn_customized_css_cache', 199 );


function lbmn_custom_body_class($classes) {
    global $theme_settings;
    
    $boxed_layout = empty($theme_settings['lbmn_layoutoption_boxed_layout']) ? 0 : $theme_settings['lbmn_layoutoption_boxed_layout'];        
    if($boxed_layout == 1){
       $classes[] = 'boxed-layout'; 
    }
    
    $boxed_outer_type = empty($theme_settings['lbmn_content_boxed_outer_type']) ? 'none':$theme_settings['lbmn_content_boxed_outer_type'];
    if($boxed_outer_type == 'pattern'){
        $classes[] = 'patt';
    }
    
    if($boxed_outer_type == 'image'){
        $classes[] = 'img';
    }        
    
    if($theme_settings['lbmn_header_layout'] == 'header-layout-1'){
        $classes[] = 'header-1';
    }elseif($theme_settings['lbmn_header_layout'] == 'header-layout-2'){
        $classes[] = 'header-2';
    }elseif($theme_settings['lbmn_header_layout'] == 'header-layout-3'){
        $classes[] = 'header-3';
    }
    
    
    
    return $classes;
}
add_filter('body_class','lbmn_custom_body_class');

function lbmn_default_body_class($classes) {
    global $theme_settings;
    
    $theme_settings['default_body_class'] = implode(' ',$classes);
    
    return $classes;
}
add_filter('body_class','lbmn_default_body_class', 1000);

/**
 * Reset cache when in customizer
 */

function lbmn_customized_css_cache_reset() {
	delete_transient( 'lbmn_customized_css' );
	lbmn_customized_css_cache();
}

function lmmn_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}

add_action( 'customize_preview_init', 'lbmn_customized_css_cache_reset' );
