<?php
/**
 * Created by JetBrains PhpStorm.
 * User: OV
 * Date: 8/26/13
 * Time: 12:21 PM
 * To change this template use File | Settings | File Templates.
 */

class WPBakeryShortCode_VC_Price_Block extends WPBakeryShortCode {
	public function __construct($settings) {
		parent::__construct($settings);
	}
}

class WPBakeryShortCode_VC_Pricing_Plan_Feature extends WPBakeryShortCode {
	public function __construct($settings) {
		parent::__construct($settings);
	}
}

class WPBakeryShortCode_VC_Pricing_Table extends WPBakeryShortCode_VC_Column
{
	public function __construct($settings) {
		parent::__construct($settings);
	}

	public function getColumnControls($controls, $extended_css = '') {
		return '';
	}
}

?>