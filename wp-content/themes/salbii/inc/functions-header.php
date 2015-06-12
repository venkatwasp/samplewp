<?php
/**
 * Fuctions and variables used by next files:
 * Top Panel, Header Top, Header Bottom
 * Used with get_template_part()
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 *
 * Code based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Some code is based on open-source tools or open-published code snippets
 */

GLOBAL $theme_settings;

if ( ! function_exists( 'lbmn_get_topbar_settings' ) ) :
function lbmn_get_topbar_settings ($panel_name) {
	$topbar_themesettings = array();
	GLOBAL $theme_settings;
	// $theme_settings = get_option('lbmn_theme_settings');
	// if (get_theme_mods() ) {
		// Get data from theme customizer if theme_mods has been saved atleast once by user

		if ( isset( $theme_settings[ 'lbmn_'.$panel_name.'_switch'] ) ) {
			$topbar_themesettings['switch']	= $theme_settings[ 'lbmn_'.$panel_name.'_switch'];
		}

		if ( isset( $theme_settings[ 'lbmn_'.$panel_name.'_sectiontype_left'] ) ) {
			$topbar_themesettings['sectiontype_left']	= $theme_settings[ 'lbmn_'.$panel_name.'_sectiontype_left'];
		}

		if ( isset( $theme_settings[ 'lbmn_'.$panel_name.'_sectiontype_right'] ) ) {
			$topbar_themesettings['sectiontype_right']	= $theme_settings[ 'lbmn_'.$panel_name.'_sectiontype_right'];
		}


		$topbar_themesettings['text_left']	= "<ul class='left'><li class='$panel_name-text-left top-bar__text-line'>" . $theme_settings['lbmn_'.$panel_name.'_text_left'] . "</li></ul>";
		$topbar_themesettings['text_right'] = "<ul class='right'><li class='$panel_name-text-right top-bar__text-line'>" . $theme_settings['lbmn_'.$panel_name.'_text_right'] . "</li></ul>";


		if ( isset( $theme_settings[ 'lbmn_'.$panel_name.'_menu_left'] ) ) {
			$topbar_themesettings['menu_left']	= $theme_settings[ 'lbmn_'.$panel_name.'_menu_left'];
		}

		if ( isset( $theme_settings[ 'lbmn_'.$panel_name.'_menu_right'] ) ) {
			$topbar_themesettings['menu_right']	= $theme_settings[ 'lbmn_'.$panel_name.'_menu_right'];
		}

		if ( isset( $theme_settings[ 'lbmn_'.$panel_name.'_icons_left'] ) ) {
			$topbar_themesettings['icons_left']	= $theme_settings[ 'lbmn_'.$panel_name.'_icons_left'];
		}

		if ( isset( $theme_settings[ 'lbmn_'.$panel_name.'_icons_right'] ) ) {
			$topbar_themesettings['icons_right']	= $theme_settings[ 'lbmn_'.$panel_name.'_icons_right'];
		}

		if ( isset( $theme_settings[ 'lbmn_'.$panel_name.'_height' ] ) ) {
			$topbar_themesettings['height'] = ' '.$theme_settings[ 'lbmn_'.$panel_name.'_height' ];
		}

		return $topbar_themesettings;
	// } else {
		// return false;
	// }
}
endif; // lbmn_get_topbar_settings


if ( ! function_exists( 'lbmn_get_logo_settings' ) ) :
function lbmn_get_logo_settings () {
	GLOBAL $theme_settings;
	$logo_themesettings = array();
	
	// if WPML installed -> get the URL for the current language
	if(function_exists("icl_get_home_url")) $logo_link = icl_get_home_url();
	else $logo_link = get_home_url();

	if (get_theme_mods() ) {
		// Get data from theme customizer if theme_mods has been saved atleast once by user
		//$logo_themesettings['logo_placement']	= 'headertop-left'; //$theme_settings[ 'lbmn_logo_placement' ];
		$logo_themesettings['logo_url']	= $logo_link;
		$logo_themesettings['logo_text']	= $theme_settings['lbmn_logo_text'];
		$logo_themesettings['logo_image_retina']	= $theme_settings['lbmn_logo_retina'];
		$logo_themesettings['logo_image']	= $theme_settings['lbmn_logo_image'];

		return $logo_themesettings;
	} else {
		return false;
	}
}
endif; // lbmn_get_logo_settings


/**
 * Function return a css class based on setting to display icon menu with/without icons
 *
 * @param  string $topbar_area - defines particular area we are working with (toppanel/headertop/headerbottom)
 * @param  string $topbar_section - defines right or left section of the area
 * @return string - prints html class: empty string if to show labels / ' no-label' if to hide labels
 */
if ( ! function_exists( 'lbmn_get_iconmenu_label_setting' ) ) :
function lbmn_get_iconmenu_label_setting ( $topbar_area, $topbar_section ) {
	GLOBAL $theme_settings;
	$output ='';
	$theme_mod_to_query = 'lbmn_' . $topbar_area . '_icons_' . $topbar_section . '_nolabel';
	// ex: 'lbmn_toppanel_icons_left_nolabel'

	if ( $theme_settings[$theme_mod_to_query] ) {
		$output = ' no-label';
	}

	return $output;
}
endif; // lbmn_get_iconmenu_label_setting


/**
 * Top-bar menu render function, used to generate dropdown menu in the right/left section
 *
 * @param  integer $menu_to_output - Menu id to output
 * @param  string  $menu_align - Menu places on the right or left section for the top-bar
 * @param  string  $custom_menu_classes – Add custom css classes to <ul class=''>
 */
if ( ! function_exists( 'lbmn_menu_output' ) ) :
function lbmn_menu_output ( $menu_to_output = 0, $menu_align = 'left', $custom_menu_classes = '' ) {
	/* By default wp_nav_menu displays the first non-empty menu
	 	 if can't find by 'menu' argument, so we check if it was definitely
	 	 set in Theme Customizer */

	if ( 0 != $menu_to_output ) {
		return wp_nav_menu( array(
			'menu'				=> $menu_to_output,
			'container'		=> false,
			'items_wrap'	=> '<ul id="%1$s" class="menu ' . $menu_align . ' menuid-' . $menu_to_output . $custom_menu_classes . '">%3$s</ul>',
			'fallback_cb' => false,
			'echo'        => false,
			'walker'			=> new lbmn_walker( array(
				'item_type'	=> 'li'
			) ),
		) );
	}
}
endif; // umberman_menu_output


/**
 * Output logo at the position selected in theme customizer
 * @param  string $header_area_name – name of the header area where we output the logo
 * @param  string $logo_img_url – path to default image logo
 * @param  string $logo_url – linked destination
 * @param  string $logo_text – text logo label / img alt text
 * @param  string $logo_imgx2_url – retina logo version
 */
if ( ! function_exists( 'render_logo_output' ) ) :
function render_logo_output($header_area_name ='', $logo_img_url ='', $logo_url ='/', $logo_text = '', $logo_imgx2_url ='') {
	$output = '';
	// prepare retina logo output
	$retina_logo_html = "";
	$retina_class_switch = "";
	$logo_alt = esc_attr($logo_text); // sanitize alt attr

	if ($logo_imgx2_url) {
		
		/* $retina_logo_size = getimagesize($logo_imgx2_url);
		$retina_logo_size_attr = '';

		if ( isset($retina_logo_size) & $retina_logo_size[0] != 0 & $retina_logo_size[1] != 0  ) {
			$retina_logo_size_attr = 'height = "' . $retina_logo_size[0]  .'" width = "' . $retina_logo_size[1] .'"';
		}

		$retina_logo_html = "<img src='$logo_imgx2_url' class='header-logo__retina show-for-retina' alt='$logo_alt' $retina_logo_size_attr />";
		*/
		$retina_logo_html = "<img src='$logo_imgx2_url' class='header-logo__retina show-for-retina' alt='$logo_alt' />";
		$retina_class_switch = " hide-for-retina";
	}
	// logo output
	if ($logo_img_url) {
		$output = "\n<div class='header-logo " . $header_area_name . "__logo'>\n<a href='$logo_url'><img src='$logo_img_url' class='header-logo__normal$retina_class_switch' alt='$logo_alt' />$retina_logo_html</a>\n</div>\n";
	} else {
		$output = "\n<div class='header-logo header-logo__text " . $header_area_name . "__logo'>\n<a href='$logo_url'>". $logo_text ."</a>\n</div>\n";
	}

	return $output;
}
endif; // render_logo_output


if ( ! function_exists( 'lbmn_output_seach_block' ) ) :
function lbmn_output_seach_block($custom_class = '') {
	$output = '';

	if ( $custom_class ) {
		$custom_class = ' ' . $custom_class;
	}

	$output = "\n<form action='" . home_url( '/' ) . "' method='get' class='search-block{$custom_class}'>";
	$output .= "<input type='text' name='s' class='search-field' value='" . get_search_query() . "' />";
	$output .= "<button type='submit' class='search-button' aria-hidden='true' data-icon='&#xe054;'></button>";
	$output .= "</form>\n";

	return $output;
}
endif; // lbmn_output_seach_block

// Webfonts
if ( ! function_exists( 'lbmn_webfonts_css' ) ) :
function lbmn_webfonts_css () {
	
	GLOBAL $theme_settings;
	$output ='';
	$webfonts_google = '';
	$webfonts_other = '';
	$webfont_settings = array();
	foreach ($theme_settings as $option_name=>$single_option){
		if($single_option == 'google' && $single_option !== 0){
			$webfont_settings[] = $option_name;
		}
	}
	$webfonts_torender = array(); // array of unique Google fonts used
	foreach ($webfont_settings as $webfont_setting_control) {
		// make sure not to request the same font from Google Twice
		if ( !in_array( $theme_settings[$webfont_setting_control . '_google'] , $webfonts_torender ) && !empty($theme_settings[$webfont_setting_control . '_google']) ) {
			$webfonts_torender[] = $theme_settings[$webfont_setting_control . '_google'] ;
			if ( 'google' == $theme_settings[$webfont_setting_control] ) {
				$webfonts_google .= $theme_settings[$webfont_setting_control . '_google'] .':100,300,400,400italic,700'. '|';
			}
		}
	}
	
	if ( $webfonts_google ) {
		$webfonts_google = rtrim($webfonts_google, "|");
		// see if the user has added any Google Fonts character sets
		if( !empty($theme_settings['lbmn_googlefonts_charset']) ) {
			foreach($theme_settings['lbmn_googlefonts_charset'] as $key => $val) {
				$all_charsets[] = $key;
			}
			$webfonts_google_charset = '&amp;subset=' . implode(",", $all_charsets);
		}
		?>
			<link href='//fonts.googleapis.com/css?family=<?php echo $webfonts_google . $webfonts_google_charset; ?>' rel='stylesheet' type='text/css'>
		<?php
	}
	return $output;
}
endif; // lbmn_webfonts_css
add_action('wp_head', 'lbmn_webfonts_css');

// Favicon
function lbmn_custom_favicon(){
	GLOBAL $theme_settings;
	if(empty($theme_settings['lbmn_favicon'])){
		$theme_settings['lbmn_favicon'] = get_template_directory_uri() . '/images/demo-theme/salbii-favicon.png';
	}
	?>
	<link rel="shortcut icon" href="<?php echo $theme_settings['lbmn_favicon']; ?>">
	<?php
}
add_action('wp_head', 'lbmn_custom_favicon');