<?php
if (function_exists("vc_path_dir"))  require_once vc_path_dir('SHORTCODES_DIR', 'vc-tour.php');
class WPBakeryShortCode_VC_Elements_Carousel extends WPBakeryShortCode_VC_Tour {
	protected function getFileName() {
		return 'vc_elements_carousel';
	}
}
?>