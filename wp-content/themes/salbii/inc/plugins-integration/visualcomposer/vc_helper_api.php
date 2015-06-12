<?php
/**
 * Created by JetBrains PhpStorm.
 * User: OV
 * Date: 8/19/13
 * Time: 8:46 PM
 * To change this template use File | Settings | File Templates.
 */

class VCElementMargins
{
	private static $content_elements = array(
		"vc_row",
		"vc_row_inner",
		"vc_column",
		"vc_column_inner",
		"vc_column_text",
		"vc_text_separator",
		"vc_message",
		"vc_facebook",
		"vc_tweetmeme",
		"vc_googleplus",
		"vc_pinterest",
		"vc_toggle",
		"vc_single_image",
		"vc_gallery",
		"vc_tabs",
		"vc_tour",
		"vc_tab",
		"vc_accordion",
		"vc_accordion_tab",
		"vc_teaser_grid",
		"vc_posts_slider",
		"vc_widget_sidebar",
		"vc_button",
		"vc_cta_button",
		"vc_video",
		"vc_gmaps",
		"vc_raw_html",
		"vc_raw_js",
		"vc_flickr",
		"vc_progress_bar",
		"vc_pie",
		"vc_separator",
		//"layerslider_vc",
		//"rev_slider_vc",
		//"gravityform",
		"vc_wp_search",
		"vc_wp_meta",
		"vc_wp_recentcomments",
		"vc_wp_calendar",
		"vc_wp_pages",
		"vc_wp_tagcloud",
		"vc_wp_custommenu",
		"vc_wp_text",
		"vc_wp_posts",
		"vc_wp_links",
		"vc_wp_categories",
		"vc_wp_archives",
		"vc_wp_rss",
		//"vc_items",
		//"vc_item",
		//"vc_posts_grid",
		"vc_iconbox",
		// "lbmn_slider",
	);

	/*
	 * Add 4 margin dropdowns (top, right, bottom, left) to every VC element's settings form.
	 * Values are processed by javascript in admin.js, not in VC templates.
	 */
	public static function addMarginsToVcElements(){

		$top_margins = array('Default'=>'');
		$right_margins = array('Default'=>'');
		$bottom_margins = array('Default'=>'');
		$left_margins = array('Default'=>'');

		for($margin = 250; $margin >= -250; $margin -= 5){
			if(abs($margin) < 100 || $margin % 50 ==0){
				$top_margins[$margin.'px'] = "margin-top_$margin"."px";
				$right_margins[$margin.'px'] = "margin-right_$margin"."px";
				$bottom_margins[$margin.'px'] = "margin-bottom_$margin"."px";
				$left_margins[$margin.'px'] = "margin-left_$margin"."px";
			}
		}

		foreach(VCElementMargins::$content_elements as $tag){
			/*
			vc_add_param($tag, array(
				"type" => "dropdown",
				"heading" => __("Element top margin", "js_composer"),
				"param_name" => "el_top_margin",
				"value" => $top_margins
			));
			vc_add_param($tag, array(
				"type" => "dropdown",
				"heading" => __("Element right margin", "js_composer"),
				"param_name" => "el_right_margin",
				"value" => $right_margins
			));
			vc_add_param($tag, array(
				"type" => "dropdown",
				"heading" => __("Element bottom margin", "js_composer"),
				"param_name" => "el_bottom_margin",
				"value" => $bottom_margins
			));
			vc_add_param($tag, array(
				"type" => "dropdown",
				"heading" => __("Element left margin", "js_composer"),
				"param_name" => "el_left_margin",
				"value" => $left_margins
			));
			*/
		}
	}
}

class VCPredefinedTemplates
{
	/*
 * $templates - array template_name => template_file_path
 */
	public static function setupPredefinedTemplates($templates_paths) {
		$templates = array();
		foreach($templates_paths as $template_name => $template_file_path){
			if (is_file($template_file_path)){
				$templates[$template_name] = file_get_contents($template_file_path);
			}
		}

		return VCPredefinedTemplates::addPredefinedTemplates($templates);
	}

	/*
	 * $templates - array template_name => template_text
	 */
	private static function addPredefinedTemplates($templates) {
		$output = '';

		$option_name = 'wpb_js_templates';
		$saved_templates = get_option($option_name);

		$predefined_templates = ( $saved_templates == false ) ? array() : $saved_templates;
		foreach($templates as $template_name => $template){
			$template_id = 'lbmn_' . sanitize_title($template_name);
			$template_arr = array( "name" => stripslashes($template_name), "template" => stripslashes($template) );
			if (!in_array($template_id, $predefined_templates)){
				$predefined_templates[$template_id] = $template_arr;
			}
		}

		if ( $saved_templates == false ) {
			add_option( $option_name, $predefined_templates, $deprecated = '', $autoload = 'no' );
		} else {
			update_option($option_name, $predefined_templates);
		}

		return $predefined_templates;
	}
}

class VCSettings
{

	protected static $vc_defaults = array(
		'wpb_js_vc_color' => '#f7f7f7',
		'wpb_js_vc_color_hover' => '#F0F0F0',
		'wpb_js_margin' => '35px',
		'wpb_js_gutter' => '2.5',
		'wpb_js_responsive_max' => '480',
		'wpb_js_vc_color_call_to_action_bg' => '',
		'wpb_js_vc_color_google_maps_bg' => '',
		'wpb_js_vc_color_post_slider_caption_bg' => '',
		'wpb_js_vc_color_progress_bar_bg' => '',
		'wpb_js_vc_color_separator_border' => '',
		'wpb_js_vc_color_tab_bg' => '',
		'wpb_js_vc_color_tab_bg_active' => '',
		'wpb_js_use_custom' => '',
	);

	protected static $settings_names = array(
		'wpb_js_vc_color',
		'wpb_js_vc_color_hover',
		'wpb_js_margin',
		'wpb_js_gutter',
		'wpb_js_responsive_max',
		'wpb_js_vc_color_call_to_action_bg',
		'wpb_js_vc_color_google_maps_bg',
		'wpb_js_vc_color_post_slider_caption_bg',
		'wpb_js_vc_color_progress_bar_bg',
		'wpb_js_vc_color_separator_border',
		'wpb_js_vc_color_tab_bg',
		'wpb_js_vc_color_tab_bg_active',
		'wpb_js_use_custom',
		'wpb_js_content_types',
	);

	public static function override_default_settings($settings)
	{
		foreach($settings as $setting_name => $setting_value){
			if (in_array($setting_name, VCSettings::$settings_names)) {
				$value_from_db = get_option($setting_name);

				if(!is_array($value_from_db)) {
					if($value_from_db === false || $value_from_db == VCSettings::$vc_defaults[$setting_name]){
						update_option($setting_name, $setting_value);
					}
				}
				else {
					$new_value = $value_from_db;

					foreach($setting_value as $post_type) {
						if(!in_array($post_type, $new_value)) {
							$new_value[] = $post_type;
						}
					}

					update_option($setting_name, $new_value);
				}
			}
		}
	}
}

class WPCommonHelper {
	static public function getAllPostsByType (/* string */ $type) {
		$posts = array();

		$args=array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'caller_get_posts'=> 1
		);

		$my_query = $post_id = null;
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
			while ($my_query->have_posts()) {
				$my_query->the_post();
				$post_id = get_the_ID();
				$posts[] = array(
					"id" => $post_id,
					"title" => get_the_title($post_id)
				);
			}
		}
		wp_reset_query();  // Restore global post data stomped by the_post().

		return $posts;
	}
}