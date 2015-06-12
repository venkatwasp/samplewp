<?php
$output = $style = $el_class = '';

extract(shortcode_atts(array(
	'style' => '',
	'el_class' => '',
), $atts));

// Separator Style

switch ($style) {
	case 'medium':
		$style = ' medium';
		break;
	case 'thick':
		$style = ' thick';
		break;
	case 'dotted':
		$style = ' dotted';
		break;
	case 'dashed':
		$style = ' dashed';
		break;
	case 'double':
		$style = ' double';
		break;
	default:
		$style = '';
		break;
}

$el_class = $this->getExtraClass($el_class);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_separator wpb_content_element'.$style.$el_class, $this->settings['base']);
$output .= '<div class="'.$css_class.'"></div>'.$this->endBlockComment('separator')."\n";

echo $output;