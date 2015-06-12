<?php
/**
 * Visual Composer plugin configuration
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */

/**
* ----------------------------------------------------------------------
* Set VC settings
*/

if (class_exists('VCSettings')) {
	VCSettings::override_default_settings(
		array(
			'wpb_js_use_custom' => true,
			'wpb_js_vc_color' => '#FFE4C4',
			'wpb_js_vc_color_hover' => '#FFEBCD',
			'wpb_js_margin' => '50px',
			'wpb_js_gutter' => '4.50',
			'wpb_js_responsive_max' => '940',
			'wpb_js_vc_color_call_to_action_bg' => '#8A2BE2',
			'wpb_js_vc_color_google_maps_bg' => '#DEB887',
			'wpb_js_vc_color_post_slider_caption_bg' => '#5F9EA0',
			'wpb_js_vc_color_progress_bar_bg' => '#CCCCCC',
			'wpb_js_vc_color_separator_border' => '#E4E4E4',
			'wpb_js_vc_color_tab_bg' => '#FF7F50',
			'wpb_js_vc_color_tab_bg_active' => '#6495ED',
			'wpb_js_content_types' => Array('page', 'lbmn_slider', 'lbmn_project'),
		)
	);
}