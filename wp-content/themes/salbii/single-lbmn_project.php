<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */

global $post;

?>

<?php
	/**
	 * This template point visitors to the right page template (full-width, sidebar-left, sidebar-right)
	 * based on theme's option panel settings
	 *
	 * If user change Template option in the page editor,
	 * than theme option "Layout" will be ignored
	 */

	$page_sidebar_position = rwmb_meta( 'lbmn_project_page_template');
	switch ( $page_sidebar_position ) {
		case 'none':
			get_template_part( 'page', 'full-width' );
			break;

		case 'right':
			get_template_part( 'page', 'sidebar-right' );
			break;

		case 'left':
			get_template_part( 'page', 'sidebar-left' );
			break;

		default:
			get_template_part( 'page', 'full-width' );
			break;
	}

?>