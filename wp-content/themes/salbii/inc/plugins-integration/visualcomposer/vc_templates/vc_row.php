<?php
$output =
$el_class =
$section_expand =
$content_within_grid =
$bg_color =
$image =
$bg_position_x =
$bg_position_y =
$bg_repeat =
$bg_size =
$bg_effect =
$bg_opacity =
$image_src =
$image_srcbg =
$background =
$style =
$css_class =
$parallax_speed =
$bg_image =
$devices_visibility = 
$css =
$el_styling = '';
$font_color = '';

$styles = $styles_helper = $css_class_helper = array();

extract(shortcode_atts(array(
	'el_class' => '',
	'expand' => '',
	'devices_visibility' => '',
	'content_within_grid' => '',
	'bg_color' => '',
	'image' => '',
	'bg_opacity' => '',
	'bg_position_x' => '',
	'bg_position_y' => '',
	'bg_repeat' => '',
	'bg_size' => '',
	'el_styling' => '',
	// 'bg_zoom' => '',
	'bg_effect' => '',
	'parallax_speed' => '',
        'bg_type' => '',
        'bg_override' => '',
        'bg_image' => '',
        'css' => '',
        'font_color' => ''
), $atts));


wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass($el_class);

if($bg_type == 'no_bg' && !empty($bg_image)){        
    $image = $bg_image;
}



if (!empty($expand) && (empty($bg_type) || $bg_type == 'no_bg')){ //without parallax
    $expand = 'expand';
}elseif(!empty($expand)){ //extra expand with parallax
    $expand = 'expand';
    foreach(array('content_within_grid',        
        'image',
        'bg_opacity',
        'bg_position_x',
        'bg_position_y',
        'bg_repeat',
        'bg_size',
        'bg_effect',
        'parallax_speed',
        'el_styling') as $k=>$v){
        unset($$v);
    }
}else { //normal parallax   
    foreach(array('content_within_grid',        
        'image',
        'bg_opacity',
        'bg_position_x',
        'bg_position_y',
        'bg_repeat',
        'bg_size',
        'bg_effect',
        'parallax_speed',
        'el_styling',
        'expand') as $k=>$v){
        unset($$v);
    }
} 
$expand_new = false;

// There is a small difference in css classes if 'out of the box' activated
if ( isset($expand) &&  $expand == 'expand' ) {
	$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
}elseif($bg_override == 'full' || $bg_override == 'ex-full' || $bg_override == 'browser_size'){
    $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'design-section wpb_row '.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);    
    $expand_new = true;
} else {
	$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.get_row_css_class().$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
}

// check class names for row-extended and set modifier
if ( stristr($css_class, 'extended-row') ) {
	$content_within_grid = false;
} else {
	$content_within_grid = true;
}

// Get background image src
if(!isset($image)) $image = '';
if(!isset($bg_position)) $bg_position = '';
if(!isset($bg_position_x)) $bg_position_x = '';
if(!isset($bg_position_y)) $bg_position_y = '';
if(!isset($bg_repeat)) $bg_repeat = '';
if(!isset($el_styling)) $el_styling = '';
if(!isset($expand)) $expand = '';



if ($image != ''){
	$image_info = wp_get_attachment_image_src($image, 'design-section');
	if(is_array($image_info) && array_key_exists(0, $image_info)){
		$image_srcbg = 'url(' . $image_info[0] . ')';
		$image_src = $image_info[0];
	}
}

if ($image == ''){ // do not output image-related properties if only bg color was set
	$bg_position = '';
	$bg_repeat = '';
}


if ($bg_color != ''){
	// Background color
	$bg_color = "background-color:" . $bg_color;
	array_push($styles, $bg_color);
}

if ($font_color != ''){
    // Font color
    $fc = 'color: '.$font_color;
    array_push($styles, $fc);
}

// background: [background-attachment || background-color || background-image || background-position || background-repeat] | inherit
$background = trim(implode(" ", array($image_srcbg, $bg_position_x, $bg_position_y, $bg_repeat)));
if($background != ''){
	$background = "background:" . $background;
	array_push($styles_helper, $background);
}


if ($image != ''){
	// Background size
	if(trim($bg_size) != ''){
		$bg_size = "background-size:" . $bg_size;
		array_push($styles_helper, $bg_size);
	}

	// Background image opacity
	if(trim($bg_opacity) != ''){
		$bg_opacity = "opacity:" . $bg_opacity;
		array_push($styles_helper, $bg_opacity);
	}

	// Background image effect
	if(trim($bg_effect) != ''){
		switch ($bg_effect) {
			case 'fixed':
				array_push($styles_helper, 'background-attachment:fixed');
				break;
			case 'parallax':
				array_push($css_class_helper, 'parallax');

				if(trim($parallax_speed) != '' && $parallax_speed != 'normal'){
					switch ($parallax_speed) {
						case 'veryslow':
							array_push($css_class_helper, 'parallax-veryslow');
							break;

						case 'slow':
							array_push($css_class_helper, 'parallax-slow');
							break;

						case 'fast':
							array_push($css_class_helper, 'parallax-fast');
							break;

						case 'veryfast':
							array_push($css_class_helper, 'parallax-veryfast');
							break;
					}
				}

				break;
		}
	}
}

// Section styling
if(trim($el_styling) != ''){
	array_push($css_class_helper, $el_styling);
}
	

// Compose style attribute
if(count($styles) > 0){
	$style = implode("; ", $styles);
	$style = ' style="' . esc_attr($style) . '" ';
}

if(count($styles_helper) > 0){
	$style_helper = implode("; ", $styles_helper);
	$style_helper = ' style="' . esc_attr($style_helper) . '" ';
} else {
	$style_helper = '';
}

if(isset($devices_visibility) && $devices_visibility != '') $css_class .= " ".$devices_visibility;


if ( $expand == 'expand' ) { // out of the box design activated
	global $is_processing_sectionslider; // check if we are renderign section slider
	// if ( !$is_processing_sectionslider ) { // do not show extra html it it's section slider
	// 	$output .= '<!-- 8-) -->'; // unclosed <p> bug desactivation
	// 	$output .= '</div>'; // close previous .columns
	// 	$output .= '</div>'; // close previous .row
	// } else {
	// 	$output .= '<!-- 8-) -->'; // unclosed <p> bug desactivation
	// }

		$css_class = 'design-section ' . $css_class;
		$css_class = trim($css_class);
		$output .= sprintf('<div class="%s"%s>', $css_class, $style);

		array_push($css_class_helper,'design-section-hellper');
                $css_class_helper = implode(" ", $css_class_helper);
                if ($image != ''){
                        $output .= sprintf('<div class="%s"%s><img src="%s"/></div>', $css_class_helper, $style_helper, $image_src);
                } else {
                        $output .= sprintf('<div class="%s"%s></div>', $css_class_helper, $style_helper);
                }
                // $output .= sprintf('<div class="%s"></div>', $css_class_helper);

                        if ( $content_within_grid ) {
                                $output .= '<div class="row">';
                        } else {
                                $output .= '<div class="row-extended">';
                        }

                        $output .= wpb_js_remove_wpautop($content);

                $output .= '</div>';
		$output .= '</div>'; // close .design-section
		// $output .= '<!-- 8-) -->'; // unclosed <p> bug desactivation
	// if ( !$is_processing_sectionslider ) { // do not show extra html it it's section slider
	// 	$output .= '<div class="row">'; // open .row  again
	// 	$output .= '<div class="large-12 columns">'; // open .columns again
	// 	$output .= '<!-- 8-) -->'; // unclosed <p> bug desactivation
	// }
} else { // satndard VC row    
    $output .= sprintf('<div class="%s"%s>', $css_class, $style);
    
    if($expand_new){
        $output .= '<div class="row">';
    }    
    
    // $output .= '<!-- 8-) -->'; // unclosed <p> bug desactivation
    $output .= wpb_js_remove_wpautop($content);
    // $output .= '<!-- 8-) -->'; // unclosed <p> bug desactivation
    
    if($expand_new){
        $output .= '</div>';
    }
    
    $output .= '</div>'.$this->endBlockComment('row');  
    
}

echo $output;