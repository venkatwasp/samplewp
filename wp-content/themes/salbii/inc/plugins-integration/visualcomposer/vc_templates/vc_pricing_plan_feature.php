<?php

$predefined_atts = array(
	'title' => '',
	'description' => '',
	'show_description_in_popup' => false,
	'icon' => '',
	// 'bg_color' => '',
	'text_color' => '',
	// 'border' => false,
	'el_class' => '',
);

$show_description_in_popup = false;
// $border = false;
$output = $title = $description = $icon = $text_color = $border = $bg_color = $text_color = $el_class = '';
$popup_description = $title_css_classes = $data_attr = '';
extract(shortcode_atts($predefined_atts, (array)$atts));

// Add colors to style attr
$style = '';

if($text_color != ''){
	$style = " style='color:$text_color;'";
}

$el_class = $this->getExtraClass($el_class);

if ( $show_description_in_popup ) {
	$popup_description =  " title='{$description}'";
	$title_css_classes = " has-tip tip-bottom";
	$data_attr = " data-tooltip";
}

$output .=	"<div class='pricingtable-feature $el_class' $style>";

if ( $show_description_in_popup && !$title  ) { // if only icon and tooltip description set - show icon in side feature title tag
	$output .=	"<p>";
	$output .=	"<span class='feature-title{$title_css_classes}'{$popup_description}{$style}{$data_attr}><b class='icon' aria-hidden='true' data-icon='{$icon}'></b> </span>";
} else {
	$output .= ($icon != '') ? "<div class='feature-icon'><b class='icon' aria-hidden='true' data-icon='{$icon}'></b></div>" : '';
	$output .=	"<p>";

	if ( $title != '' ) {
		$output .=	"<span class='feature-title{$title_css_classes}'{$popup_description}{$style}{$data_attr}>$title</span>";
	}
}

if ( !$show_description_in_popup && ( $description !== '' ) ) {
	if ( $title != '' ) {
		$output .=	"<br />";
	}

	$output .=	"<span class='feature-description' $style>$description</span>";
}
$output .=	"</p>";

$output .=	"</div>";

echo $output;

?>