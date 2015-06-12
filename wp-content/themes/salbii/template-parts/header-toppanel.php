<?php
/**
 * The Template used to display 'Top bar' panel across the website.
 * Used with get_template_part()
 *
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */



/**
* ----------------------------------------------------------------------
* Get theme options for 'Top panel' area
*/
GLOBAL $theme_settings;
$toppanel_settings = lbmn_get_topbar_settings('toppanel');
// this fucntion is defined in "fucntions-header.php"

// echo '$toppanel_settings: ' . var_dump($toppanel_settings);

if ( ! $toppanel_settings ) {
	// Set default values if user just installed theme and not yet saved theme customizer options
	$toppanel_settings['switch']	= 1;
	$toppanel_settings['sectiontype_left'] 	= 'text';
	$toppanel_settings['sectiontype_right'] = 'icons';
	$toppanel_settings['text_left'] 	= "<li class='toppanel-text-left top-bar__text-line'> Thank you for choosing  " . lbmn_THEME_NAME_DISPLAY . "! </li>";

	// Find icons menu id
	$default_menu_id;
	foreach ( wp_get_nav_menus() as $menu ) {
		$menu_name = wp_html_excerpt( $menu->name, 40, '&hellip;' );
		if ( 'Social Icons List' == $menu_name ) { // get menu id for default icons menu
			$default_menu_id = $menu->term_id;
		}
	}
	$toppanel_settings['icons_right'] = $default_menu_id;
}


// Template variables
$toppanel_template_open = "
<div class='contain-to-grid toppanel top-bar-wrapper" . (isset($toppanel_settings['height']) ? $toppanel_settings['height'] : '') . "'>
	<nav class='top-bar'>";

$toppanel_template_open .= "<ul class='title-area'><li class='name'><!-- no standard title --></li></ul>
		<section class='top-bar-section'>";

$toppanel_template_close = "
		</section>
	</nav>
</div>";


if ( $toppanel_settings['switch'] ) {
	echo $toppanel_template_open;

	if ( 'toppanel-left' == $theme_settings['toppanel_languageswitcher'] ) {
		echo lbmn_languages_selector('left');
	} elseif ( 'toppanel-right' == $theme_settings['toppanel_languageswitcher'] ) {
		echo lbmn_languages_selector('right');
	}

	// output search field if it's attached to this area
	if ( isset($theme_settings['lbmn_toppanel_header_search']) && $theme_settings['lbmn_toppanel_header_search'] ) {
		echo '<!-- test -->';echo lbmn_output_seach_block('right');echo '<!-- test2 -->';
	}

	switch ( $toppanel_settings['sectiontype_left'] ) {
		case 'text': 	echo $toppanel_settings['text_left']; break;
		case 'menu': 	echo lbmn_menu_output ($toppanel_settings['menu_left'], 'left'); break;
		case 'icons': echo lbmn_menu_output ($toppanel_settings['icons_left'], 'left', lbmn_get_iconmenu_label_setting ( 'toppanel', 'left' ) ); break;
	}

	switch ( $toppanel_settings['sectiontype_right'] ) {
		case 'text': 	echo $toppanel_settings['text_right']; break;
		case 'menu': 	echo lbmn_menu_output ($toppanel_settings['menu_right'], 'right'); break;
		case 'icons': echo lbmn_menu_output ($toppanel_settings['icons_right'], 'right', lbmn_get_iconmenu_label_setting ( 'toppanel', 'right' ) ); break;
	}

	echo $toppanel_template_close;
}