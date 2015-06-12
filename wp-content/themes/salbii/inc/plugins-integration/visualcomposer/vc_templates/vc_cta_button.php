<?php
$output = $color = $icon = $size = $target = $href = $title = $call_text = $call_text_secondary = $position = $el_class = $btn_style = $el_style = '';
extract(shortcode_atts(array(
	'color' => 'wpb_button',
	'icon' => 'none',
	'size' => '',
	'btn_style' => '',
	'el_style' => '',
	'target' => '',
	'href' => '',
	'title' => __('Text on the button', "js_composer"),
	'call_text' => '',
	'call_text_secondary' => '',
	'position' => 'cta_align_right',
	'el_class' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);

if ( $target == 'same' || $target == '_self' ) { $target = ''; }
if ( $target != '' ) { $target = ' target="'.$target.'"'; }

// $icon = ( $icon != '' && $icon != 'none' ) ? ' '.$icon : '';
// TODO: we repeat this block twice in vc_button.php and vc_cta_button.php - maybe it's better to make a fucntion of it?
if ( $icon != '' && $icon != 'none' ) {

	// remap standard icons to the ones we use
	// originals icons array defined in config/map.php
	switch ($icon) {
		case 'wpb_address_book':        $icon = '&#xe067;'; break;
		case 'wpb_alarm_clock':         $icon = '&#xe057;'; break;
		case 'wpb_anchor':                  $icon = '&#xf13d;'; break;
		case 'wpb_application_image':   $icon = '&#xe0cc;'; break;
		case 'wpb_arrow':                   $icon = '&#xe100;'; break;
		case 'wpb_asterisk':            $icon = '&#xf069;'; break;
		case 'wpb_hammer':              $icon = '&#xf0e3;'; break;
		case 'wpb_balloon':             $icon = '&#xe050;'; break;
		case 'wpb_balloon_buzz':            $icon = '&#xe12a;'; break;
		case 'wpb_balloon_facebook':    $icon = '&#xe127;'; break;
		case 'wpb_balloon_twitter':     $icon = '&#xe125;'; break;
		case 'wpb_battery':                     $icon = '&#xe07b;'; break;
		case 'wpb_binocular':                   $icon = '&#xe054;'; break;
		case 'wpb_document_excel':      $icon = '&#xe09e;'; break;
		case 'wpb_document_image':      $icon = '&#xf03e;'; break;
		case 'wpb_document_music':      $icon = '&#xe064;'; break;
		case 'wpb_document_office':     $icon = '&#xe068;'; break;
		case 'wpb_document_pdf':            $icon = '&#xe0da;'; break;
		case 'wpb_document_powerpoint': $icon = '&#xe0ca;'; break;
		case 'wpb_document_word':   $icon = '&#xe0da;'; break;
		case 'wpb_bookmark':            $icon = '&#xe0d8;'; break;
		case 'wpb_camcorder':           $icon = '&#xf03d;'; break;
		case 'wpb_camera':              $icon = '&#xe05e;'; break;
		case 'wpb_chart':               $icon = '&#xe0a2;'; break;
		case 'wpb_chart_pie':       $icon = '&#xe0a0;'; break;
		case 'wpb_clock':               $icon = '&#xe06d;'; break;
		case 'wpb_fire':                $icon = '&#xe070;'; break;
		case 'wpb_heart':               $icon = '&#xe049;'; break;
		case 'wpb_mail':                $icon = '&#xe034;'; break;
		case 'wpb_play':                $icon = '&#xe0db;'; break;
		case 'wpb_shield':          $icon = '&#xf132;'; break;
		case 'wpb_video':               $icon = '&#xf16a;'; break;
	}
} else {
	$icon = '';
}

// $i_icon = ( $icon != '' ) ? ' <i class="icon"> </i>' : '';
$i_icon = ( $icon != '' ) ? '<i class="icon" aria-hidden="true" data-icon="'.$icon.'"> </i> ' : '';
$icon_parent_class = '';
if ( $icon != '' ) {
	$icon_parent_class = ' has-icon';
}

// $color = ( $color != '' ) ? ' wpb_'.$color : '';
if ( $color != '' &&  $color != 'primary') {
	$color = ' wpb_'.$color;
} else {
	$color = '';
}

// $size = ( $size != '' && $size != 'wpb_regularsize' ) ? ' wpb_'.$size : ' '.$size;
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

if ($btn_style != '') {
	if ($btn_style == 'default' || stristr($btn_style, 'divider')) {
		$btn_style = $default_button_style;
	} else {
		$btn_style = ' '.$btn_style;
	}
}

// make block corners rounded in button inside has rounded corders
if ( stristr($btn_style, 'radius') || stristr($btn_style, 'round') ) {
	$el_class .= ' radius';
}


$default_block_style = '';

if ($el_style != '') {
	if ($el_style == 'none' || stristr($btn_style, 'divider')) {
		$el_style = $default_block_style;
	} else {
		$el_style = ' '.$el_style;
	}
}



$a_class = '';
if ( $el_class != '' ) {
	$tmp_class = explode(" ", $el_class);
	if ( in_array("prettyphoto", $tmp_class) ) {
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );
		$a_class .= ' prettyphoto'; $el_class = str_ireplace("prettyphoto", "", $el_class);
	}
}

if ( $href != '' ) {
	$a_class .= 'button'.$color.$size.$btn_style.$icon_parent_class; // $radius.
	$button = '<a class="'.$a_class.'" title="'.$title.'" href="'.$href.'"'.$target.'>' .$i_icon.$title. '</a>';
	// $button = '<span class="button '.$color.$size.$icon.'">'.$title.$i_icon.'</span>';
	// $button = '<a class="button'.$a_class.'" href="'.$href.'"'.$target.'>' . $button . '</a>';
} else {
	//$button = '<button class="wpb_button '.$color.$size.$icon.'">'.$title.$i_icon.'</button>';
	$button = '';
	$el_class .= ' cta_no_button';
}
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_call_to_action wpb_content_element clearfix '.$position.$el_class.$el_style, $this->settings['base']);

$output .= '<div class="'.$css_class.'">';
// if ( $position != 'cta_align_bottom' ) $output .= $button;
$output .= apply_filters('wpb_cta_text', '<h3 class="wpb_call_text wpb_call_heading">'. $call_text . '</h3>', array('content'=>$call_text));
if ( $call_text_secondary != '' ) {
	$output .= apply_filters('wpb_cta_text_secondary', '<p class="wpb_call_text wpb_call_content">'.$call_text_secondary.'</p>',  array('content'=>$call_text_secondary));
}
//$output .= '<h2 class="wpb_call_text">'. $call_text . '</h2>';
// if ( $position == 'cta_align_bottom' ) $output .= $button;
$output .= $button;
$output .= '</div> ' . $this->endBlockComment('.wpb_call_to_action') . "\n";

echo $output;