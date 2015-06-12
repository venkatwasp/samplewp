<?php
/**
 * The Template for displaying top header area across website.
 * Used with get_template_part()
 *
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */



if ( ! function_exists( 'lbmn_output_seach_block' ) ) :
function lbmn_output_seach_block() {
	$output = '';

	$output = "<form action='" . home_url( '/' ) . "' method='get'>";
	$output .= "<input type='text' name='s' class='search-field' value='" . the_search_query() . "' />";
	$output .= "<button type='submit' class='search-button postfix button' aria-hidden='true' data-icon='&#xe054;'></button>";
	$output .= "</form>";

	echo $output;
}
endif; // lbmn_output_seach_block