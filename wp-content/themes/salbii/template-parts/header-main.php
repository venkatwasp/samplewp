<?php
/**
 * The Template for displaying top header area across website.
 * Used with get_template_part()
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */


GLOBAL $theme_settings;

$header_layout = array($theme_settings['lbmn_header_layout']);
if(defined('THEME_COLORS') && THEME_COLORS == true){
    $header_layout = array('header-layout-1', 'header-layout-2', 'header-layout-3');
}

foreach($header_layout as $hl){    
    $extra_class = "header-layout " . str_replace('-', '_', $hl);    
    
    $ts = $theme_settings;
    $ts['lbmn_header_layout'] = $hl;
    lbmn_generate_header($ts, $extra_class);        
}


function lbmn_generate_header($theme_settings, $extra_class) {

    // $headertop_settings = lbmn_get_topbar_settings('headertop');
    $logo_settings = lbmn_get_logo_settings();
    $sectiontype_left_output = $sectiontype_right_output = $header_styling_classes = $before_logo_output = $after_logo_output = '';

    if (isset($theme_settings['lbmn_header_dropshadow'])) {
            if ( $theme_settings['lbmn_header_dropshadow']) {
                    $header_styling_classes .= ' dropshadow';
            }
    }

    if ( ($theme_settings['lbmn_header_menustyling'] == 'small') || ($theme_settings['lbmn_header_menustyling'] == 'caps-small')  ) {
            $header_styling_classes .= ' menu-small';
    }


    // Prepare output based on selected header desgin
    if ( $theme_settings['lbmn_header_layout'] == 'header-layout-1' ) {


            // Set default values if user just installed theme and not yet saved theme customizer options
            // $headertop_settings['switch']	= 1;
            $headertop_settings['height'] = ' '.$theme_settings['lbmn_header_height'];
            $logo_settings['logo_placement']	= 'headertop-left';
            $menu_locations = get_nav_menu_locations();

            $sectiontype_right_output = '';

            // output search field if it's attached to this area
            if ( $theme_settings['lbmn_header_search'] ) {
                    // $sectiontype_right_output .= lbmn_output_seach_block('right');
                    $sectiontype_left_output = lbmn_output_seach_block('right') . $sectiontype_left_output;
                    if ( $theme_settings['lbmn_header_search_mobile_hide'] ) {
                    	$sectiontype_left_output = '<div class="hide-for-small">' . $sectiontype_left_output . '</div>';
                    }
            }

            // output language switch if selected in theme options
            if ( $theme_settings['lbmn_header_languageswitcher'] ) {
                    $sectiontype_right_output = lbmn_languages_selector('right');
            }

            if ( isset($menu_locations['primary-menu']) ) {
                    $sectiontype_right_output .= lbmn_menu_output ($menu_locations['primary-menu'], 'right');
            }

            $header_styling_classes .= ' header-layout-1'; // contain-to-grid';
    }

    if ( $theme_settings['lbmn_header_layout'] == 'header-layout-2' ) {

            // Set default values if user just installed theme and not yet saved theme customizer options
            // $headertop_settings['switch']	= 1;
            $headertop_settings['height'] = ' '.$theme_settings['lbmn_header_height'];
            $logo_settings['logo_placement']	= 'headertop-left';
            $menu_locations = get_nav_menu_locations();

            $sectiontype_right_output = '';
            $sectiontype_right_output .= lbmn_menu_output ($menu_locations['primary-menu'], 'right');
            $header_styling_classes .= ' header-layout-2';
    }

    if ( $theme_settings['lbmn_header_layout'] == 'header-layout-3' ) {
            $headertop_settings['height'] = ' '.$theme_settings['lbmn_header_height'];
            $logo_settings['logo_placement']	= 'headertop-left';
            $menu_locations = get_nav_menu_locations();

            // output additinal header text if set in theme options
            if ( isset($theme_settings['lbmn_header_additional_text']) && strlen($theme_settings['lbmn_header_additional_text']) > 1  ) {
                    $after_logo_output .= '<p class="additional-header-text">' . $theme_settings['lbmn_header_additional_text'] . '</p>';
            }

            $sectiontype_right_output = lbmn_menu_output ($menu_locations['primary-menu'], 'left');

            // output language switch if selected in theme options
            if ( $theme_settings['lbmn_header_languageswitcher'] ) {
                    $sectiontype_right_output .= lbmn_languages_selector('right');
            }

            // output search field if it's attached to this area
            if ( $theme_settings['lbmn_header_search'] ) {
                    // $sectiontype_right_output .= lbmn_output_seach_block('right');
                    $sectiontype_left_output = lbmn_output_seach_block('right') . $sectiontype_left_output;
                    if ( $theme_settings['lbmn_header_search_mobile_hide'] ) {
                    	$sectiontype_left_output = '<div class="hide-for-small">' . $sectiontype_left_output . '</div>';
                    }
            }

            $header_styling_classes .= ' header-layout-3';// contain-to-grid';
    }


    if ($before_logo_output) {
            $before_logo_output = '<div class="before-logo-section">'. $before_logo_output . '</div>';
    }

    if ($after_logo_output) {
            $after_logo_output = '<div class="after-logo-section">'. $after_logo_output . '</div>';
    }


    // Prepare Template Parts
    // if defined to show logo in headertop area
    if ( stristr( $logo_settings['logo_placement'], 'headertop')) {
            $headertop_logo_placement_class = " top-bar-with-logo logo-position__" . $logo_settings['logo_placement'];
            $headertop_logo_output = render_logo_output('headertop', $logo_settings['logo_image'], $logo_settings['logo_url'], $logo_settings['logo_text'], $logo_settings['logo_image_retina']);
    } else {
            $headertop_logo_placement_class = '';
            $headertop_logo_output = '';
    }

    // Output Header
    echo "
    <div class='top-bar-wrapper headertop" . (isset($headertop_settings['height']) ? $headertop_settings['height'] : '') . "$headertop_logo_placement_class $header_styling_classes $extra_class'>
            <nav class='top-bar'>";

            if($theme_settings['lbmn_header_layout'] == 'header-layout-1') //this is when logo is on the left ..
            {
                    echo "<div class='row' style='position: relative'>";
                            echo "<div class='large-2 columns'>";
                                    echo $before_logo_output;
                                    // if defined to show logo in headertop area
                                    echo  $headertop_logo_output;
                                    echo $after_logo_output;
                            echo "</div>";
                    echo "<div style='position:static;' class='large-10 columns'>";
                            echo  "<div class='top-bar-section' style='position: static;'>";
                                            echo  "<ul class='title-area show-for-small'><li class='name'><!-- no standard title --></li><li class='mobile-menu-toggle'><a href='#' class='right-off-canvas-toggle'><i aria-hidden='true' class='icon-list-2'></i> <span>Menu</span></a></li></ul>";
                                            echo $sectiontype_left_output;
                                            echo $sectiontype_right_output;
                                    echo "</div>";
                            echo "</div>";
                    echo "</div>";
            }
            else
            {
                    echo "<div class='row'>";
                            echo "<div class='large-12 columns'>";
                                    echo $before_logo_output;
                                    // if defined to show logo in headertop area
                                    echo $headertop_logo_output;
                                    echo $after_logo_output;
                            echo "</div>";
                    echo "</div>";

                    echo  "<section class='top-bar-section'>";
                    echo "<div class='row'>";
                            echo "<div class='large-12 columns'>";
                                    echo "<div style='position:static;' class='". ($theme_settings['lbmn_header_layout'] == 'header-layout-1' ? 'large-10' :'') ." columns'>";
                                                    echo  "<ul class='title-area show-for-small'><li class='name'><!-- no standard title --></li><li class='mobile-menu-toggle'><a href='#' class='right-off-canvas-toggle'><i aria-hidden='true' class='icon-list-2'></i> <span>Menu</span></a></li></ul>";
                                                    echo $sectiontype_left_output;
                                                    echo $sectiontype_right_output;
                                            echo "</div>";
                                    echo "</div>";
                            echo "</div>";
                    echo "</section>";
            }
            echo "
            </nav>
    </div>";
}