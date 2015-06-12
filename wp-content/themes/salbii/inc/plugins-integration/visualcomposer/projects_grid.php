<?php

class WPBakeryShortCode_VC_Projects_Grid extends WPBakeryShortCode
{
	public function __construct($settings) {
		parent::__construct($settings);
	}

	public function contentAdmin($atts, $content) {
		$element = $this->shortcode;
		$output = $custom_markup = $width  = '';

		if ( $content != NULL ) { $content = wpautop(stripslashes($content)); }

		$shortcode_attributes = array('width' => '1/1');

		foreach ( $this->settings['params'] as $param ) {
			if ( $param['param_name'] != 'content' ) {
				if ( isset($param['value']) ) {
					$shortcode_attributes[$param['param_name']] = is_string($param['value']) ? __($param['value'], "js_composer") : $param['value'];
				} else {
					$shortcode_attributes[$param['param_name']] = '';
				}
			} else if ( $param['param_name'] == 'content' && $content == NULL ) {
				$content = __($param['value'], "js_composer");
			}
		}

		extract(shortcode_atts(
			$shortcode_attributes
			, (array)$atts));

		$elem = $this->getElementHolder($width);

		$iner = $this->outputTitle($this->settings['name']);

		foreach($shortcode_attributes as $name => $value){

			if ( is_array($value)) {
				$value = join("; ", $value);
			}

			if(isset($this->settings['params'][$name])){
				$iner .= $this->singleParamHtmlHolder($this->settings['params'][$name], $value);
			}
		}

		$elem = str_ireplace('%wpb_element_content%', $iner, $elem);

		$output .= $elem;

		return $output;
	}
}

?>