<?php
/**
 * Created by JetBrains PhpStorm.
 * User: OV
 * Date: 8/12/13
 * Time: 5:22 PM
 * To change this template use File | Settings | File Templates.
 */
if ( !defined('ICONBOX_TITLE') ) define('ICONBOX_TITLE', __("Iconbox", "js_composer"));
if (function_exists("vc_path_dir")) require_once vc_path_dir('SHORTCODES_DIR', 'vc-tab.php');
class WPBakeryShortCode_VC_Iconbox extends WPBakeryShortCode_VC_Tab {
	protected $predefined_atts = array(
		'tab_id' => ICONBOX_TITLE,
		'title' => ICONBOX_TITLE
	);

	/*
	 * Override to insert title
	 */
	public function contentAdmin($atts, $content = null) {
		$width = $el_class = '';
		extract(shortcode_atts($this->predefined_atts, $atts));
		$output = '';

		$column_controls = $this->getColumnControls($this->settings('controls'));
		$column_controls_bottom =  $this->getColumnControls('add', 'bottom-controls');

		if ( $width == 'column_14' || $width == '1/4' ) {
			$width = array('vc_span3');
		}
		else if ( $width == 'column_14-14-14-14' ) {
			$width = array('vc_span3', 'vc_span3', 'vc_span3', 'vc_span3');
		}

		else if ( $width == 'column_13' || $width == '1/3' ) {
			$width = array('vc_span4');
		}
		else if ( $width == 'column_13-23' ) {
			$width = array('vc_span4', 'vc_span8');
		}
		else if ( $width == 'column_13-13-13' ) {
			$width = array('vc_span4', 'vc_span4', 'vc_span4');
		}

		else if ( $width == 'column_12' || $width == '1/2' ) {
			$width = array('vc_span6');
		}
		else if ( $width == 'column_12-12' ) {
			$width = array('vc_span6', 'vc_span6');
		}

		else if ( $width == 'column_23' || $width == '2/3' ) {
			$width = array('vc_span8');
		}
		else if ( $width == 'column_34' || $width == '3/4' ) {
			$width = array('vc_span9');
		}
		else if ( $width == 'column_16' || $width == '1/6' ) {
			$width = array('vc_span2');
		} else if ( $width == 'column_56' || $width == '5/6' ) {
			$width = array('vc_span10');
		} else {
			$width = array('');
		}
		for ( $i=0; $i < count($width); $i++ ) {
			$output .= '<div '.$this->mainHtmlBlockParams($width, $i).'>';
			$output .= str_replace("%column_size%", wpb_translateColumnWidthToFractional($width[$i]), $column_controls);
			$output .= '<div class="wpb_element_wrapper">';
			$output .= $this->outputTitle($this->settings['name']);
			$output .= '<div '.$this->containerHtmlBlockParams($width, $i).'>';
			$output .= do_shortcode( shortcode_unautop($content) );
			$output .= '</div>';
			if ( isset($this->settings['params']) ) {
				$inner = '';
				foreach ($this->settings['params'] as $param) {
					$param_value = isset($$param['param_name']) ? $$param['param_name'] : '';
					if ( is_array($param_value)) {
						// Get first element from the array
						reset($param_value);
						$first_key = key($param_value);
						$param_value = $param_value[$first_key];
					}
					$inner .= $this->singleParamHtmlHolder($param, $param_value);
				}
				$output .= $inner;
			}
			$output .= '</div>';
			$output .= str_replace("%column_size%", wpb_translateColumnWidthToFractional($width[$i]), $column_controls_bottom);
			$output .= '</div>';
		}
		return $output;
	}
}