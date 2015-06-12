<?php
echo lbmn_icon($atts, $content);

add_shortcode( 'vc_iconbox', 'lbmn_icon' );

function lbmn_icon( $atts, $content = null ) {
$output = $color = $badge_color = $size = $icon = $href = $el_class = $style = $title = $tab_id = $icon_position = $hover_effect = '';
extract(shortcode_atts(array(
	'color' => '',
	'badge_color' => '',
	'style' => '',
	'hover_effect' => '',
	'size' => '',
	'icon' => '&#xe000;',
	'icon_position' => 'top-center',
	'href' => '',
	'el_class' => '',
	'title' => '',
	'tab_id' => ''
), $atts));

$el_css = $a_class = '';

if ( $el_class != '' ) {
	$tmp_class = explode(" ", strtolower($el_class));
	$tmp_class = str_replace(".", "", $tmp_class);
	if ( in_array("prettyphoto", $tmp_class) ) {
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );
		$a_class .= ' prettyphoto';
		$el_class = str_ireplace("prettyphoto", "", $el_class);
	}
	if ( in_array("pull-right", $tmp_class) && $href != '' ) { $a_class .= ' pull-right'; $el_class = str_ireplace("pull-right", "", $el_class); }
	if ( in_array("pull-left", $tmp_class) && $href != '' ) { $a_class .= ' pull-left'; $el_class = str_ireplace("pull-left", "", $el_class); }
}

if ( $size != '' && $size != 'wpb_regularsize' ) {
	switch ($size) {
		case 'btn-mini':
			$size = 'small';
			break;
		case 'btn-large':
			$size = 'large';
			break;
	}
	$size = ' '.$size;
} else {
	$size = '';
}


$effect_css = '';
if ( $hover_effect == 'vc-icon-effect-1a' ) {
	$el_class .= ' '.$hover_effect;
	if ($badge_color!='') {
		$effect_css .= " style='box-shadow:0 0 0 2px {$badge_color};'";
	} elseif ($color!='') {
		$effect_css .= " style='box-shadow:0 0 0 2px {$color};'";
	}
}

if ($color!='') { $color = 'color: '.$color.';';}

if ( !stristr($style, 'border') && $badge_color!='' ) { // not a border style > set background
	$badge_color = 'background-color: '.$badge_color.';';
} else { // border style > set border-color
	$badge_color = 'border-color: '.$badge_color.';';
}

if ($color!='' || $badge_color!='') { $el_css = " style='{$color}{$badge_color}'"; }

$default_button_style = ' plain round';

if ($style != '') {
	if ($style == 'default' || stristr($style, 'divider')) {
		$style = $default_button_style;
	} else {
		$style = ' '.$style;
	}
}

// Icon position – prepare css class
$icon_position = ' '.$icon_position;

$i_icon = ( $icon != '' ) ? '<b class="icon" '.$el_css.'><b class="icon-glyph" aria-hidden="true" data-icon="'.$icon.'"></b><i class="icon effect-helper"'.$effect_css.'></i></b>' : '';


$el_class .= $size . $style . $icon_position; // $this->getExtraClass($el_class);
// $a_class .= 'button'.$color.$size.$el_class.$position.$radius.$style.$icon_parent_class;
// $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $a_class, $this->settings['base']);

if ( $icon != '' ) {
	if ( $href != '' ) {
		// $output .= '<span class="'.$css_class.'">'.$i_icon.$title.'</span>';
		$output = '<div class="iconbox__icon"><a class="'.$a_class.'" title="'.$title.'" href="'.$href.'">' .$i_icon.$title. '</a></div>';
	} else {
		// $output = $i_icon;
		$output = '<div class="iconbox__icon">'.$i_icon.'</div>'; //vc-icon-effect-1 vc-icon-effect-1a
	}
}
	$content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
	$output = "<div class='vc_iconbox wpb_content_element{$el_class}'>{$output}<div class='iconbox__content'>{$content}</div></div>";

return $output;
}//fucntion