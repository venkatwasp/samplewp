<?php
$output = $el_class = $width =
$column_bg_color = $bg_opacity =
$rounded_corners = $css_style = '';

$styles = $css_class_helper = array();

extract(shortcode_atts(array(
		'column_bg_color' => '',
		'bg_opacity' => '',
    'el_class' => '',
    'el_styling' => '',
    'rounded_corners' => '',
    'width' => '1/1'
), $atts));

$el_class = $this->getExtraClass($el_class);
$width = wpb_translateColumnWidthToSpan($width);

//Take custom css and trim the attribute name
$extra_class = (isset($atts["css"]) && $atts["css"] != "") ? str_replace(".", "", strstr($atts["css"], '{', true)) : "";
$el_class .= ' wpb_column column_container columns ' . $extra_class;

// Compose custom css style attribute
if ( $column_bg_color != '' ){
	// Background color
	$column_bg_color = "background-color:" . $column_bg_color;
	array_push($styles , $column_bg_color);

	// Background image opacity
	if( ( $bg_opacity != '' ) && ( $bg_opacity != '1' ) ){
		$bg_opacity = "opacity:" . $bg_opacity;
		array_push($styles , $bg_opacity);
	}
}

// Column styling
if(trim($el_styling) != ''){
	array_push($css_class_helper, $el_styling);
}

// Column rounded corners
if( $rounded_corners ){
	array_push($css_class_helper, 'radius');
}

// Compose style attribute
if(count($styles) > 0){
	$css_style = implode("; ", $styles);
	$css_style = ' style="' . esc_attr($css_style) . '" ';
}

array_push($css_class_helper,'column-design-helper');
$css_class_helper = implode(" ", $css_class_helper);

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width.$el_class, $this->settings['base']);
$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t".sprintf('<div class="%s"%s></div>', $css_class_helper, $css_style); // column design helper
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo $output;