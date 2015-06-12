<?php
$output = $color = $size = $icon = $target = $href = $el_class = $title = $position = $style = '';
extract(shortcode_atts(array(
	'color' => 'wpb_button',
	'style' => '',
	'size' => '',
	'icon' => 'none',
	'target' => '_self',
	'href' => '',
	'el_class' => '',
	'title' => __('Text on the button', "js_composer"),
	'position' => ''
), $atts));
$a_class = '';

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

if ( $target == 'same' || $target == '_self' ) { $target = ''; }
$target = ( $target != '' ) ? ' target="'.$target.'"' : '';

// $color = ( $color != '' ) ? ' wpb_'.$color : '';
if ( $color != '' &&  $color != 'primary') {
	$color = ' wpb_'.$color;
} else {
	$color = '';
}

// $size = ( $size != '' && $size != 'wpb_regularsize' ) ? ' '.$size : ' '.$size;
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

$default_button_style = ' radius';

if ($style != '') {
	if ($style == 'default' || stristr($style, 'divider')) {
		$style = $default_button_style;
	} else {
		$style = ' '.$style;
	}
}

/* check here for standard VC icon names
and map them to the icons from my list */
// TODO: we repeat this block twice in vc_button.php and vc_cta_button.php - maybe it's better to make a fucntion of it?
if ( $icon != '' && $icon != 'none' ) {

	// remap standard icons to the ones we use
	// originals icons array defined in config/map.php
	switch ($icon) {
		case 'wpb_address_book':		$icon = '&#xe067;'; break;
		case 'wpb_alarm_clock':			$icon = '&#xe057;'; break;
		case 'wpb_anchor':					$icon = '&#xf13d;'; break;
		case 'wpb_application_image':	$icon = '&#xe0cc;'; break;
		case 'wpb_arrow':					$icon = '&#xe100;'; break;
		case 'wpb_asterisk':			$icon = '&#xf069;'; break;
		case 'wpb_hammer':				$icon = '&#xf0e3;'; break;
		case 'wpb_balloon':				$icon = '&#xe050;'; break;
		case 'wpb_balloon_buzz':			$icon = '&#xe12a;'; break;
		case 'wpb_balloon_facebook':	$icon = '&#xe127;'; break;
		case 'wpb_balloon_twitter':		$icon = '&#xe125;'; break;
		case 'wpb_battery':						$icon = '&#xe07b;'; break;
		case 'wpb_binocular':					$icon = '&#xe054;'; break;
		case 'wpb_document_excel':		$icon = '&#xe09e;'; break;
		case 'wpb_document_image':		$icon = '&#xf03e;'; break;
		case 'wpb_document_music':		$icon = '&#xe064;'; break;
		case 'wpb_document_office':		$icon = '&#xe068;'; break;
		case 'wpb_document_pdf':			$icon = '&#xe0da;'; break;
		case 'wpb_document_powerpoint':	$icon = '&#xe0ca;'; break;
		case 'wpb_document_word':	$icon = '&#xe0da;'; break;
		case 'wpb_bookmark':			$icon = '&#xe0d8;'; break;
		case 'wpb_camcorder':			$icon = '&#xf03d;'; break;
		case 'wpb_camera':				$icon = '&#xe05e;'; break;
		case 'wpb_chart':    			$icon = '&#xe0a2;'; break;
		case 'wpb_chart_pie':    	$icon = '&#xe0a0;'; break;
		case 'wpb_clock':    			$icon = '&#xe06d;'; break;
		case 'wpb_fire':    			$icon = '&#xe070;'; break;
		case 'wpb_heart':    			$icon = '&#xe049;'; break;
		case 'wpb_mail':    			$icon = '&#xe034;'; break;
		case 'wpb_play':    			$icon = '&#xe0db;'; break;
		case 'wpb_shield':    		$icon = '&#xf132;'; break;
		case 'wpb_video':    			$icon = '&#xf16a;'; break;
	}
} else {
	$icon = '';
}

$i_icon = ( $icon != '' ) ? '<i class="icon" aria-hidden="true" data-icon="'.$icon.'"> </i> ' : '';
$icon_parent_class = '';
if ( $icon != '' ) {
	$icon_parent_class = ' has-icon';
}
$position = ( $position != '' ) ? ' '.$position.'-button-position' : '';
$el_class = $this->getExtraClass($el_class);
$a_class .= 'button'.$color.$size.$el_class.$position.$style.$icon_parent_class;

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $a_class, $this->settings['base']);

if ( $href != '' ) {
	// $output .= '<span class="'.$css_class.'">'.$i_icon.$title.'</span>';
	$output = '<a class="'.$css_class.'" title="'.$title.'" href="'.$href.'"'.$target.'>' .$i_icon.$title. '</a>';
} else {
	$output .= '<button class="'.$css_class.'">'.$i_icon.$title.'</button>';

}

echo $output . $this->endBlockComment('button') . "\n";