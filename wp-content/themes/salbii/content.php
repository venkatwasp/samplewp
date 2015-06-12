<?php
/**
 * The default template for displaying content.
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */




GLOBAL $theme_settings;

if ( is_home() || is_archive() || is_search() ) {
	// When any type of Archive page is being displayed.
	// Category, Tag, Author and Date based pages are all types of Archives.

	// Get selected blog design otpion from Theme Options panel
	if ( isset($theme_settings['lbmn_blog_design']) ) {
		$selected_blog_teaser_desing = $theme_settings['lbmn_blog_design'];
	} else {
		$selected_blog_teaser_desing = 'standard';
	}

	// Blog design can be overrided by custom fields (used for theme demo mainly)
	switch ( get_post_meta( get_option( 'page_for_posts' ), 'blog_design', true ) ) {
		case 'standard':
				$selected_blog_teaser_desing = 'standard';
			break;
		case 'masonry':
				$selected_blog_teaser_desing = 'masonry';
			break;
	}


	// Get current post format
	// we use it to style teaser appropriately
	$post_format = get_post_format();
	if ( false === $post_format )
		$post_format = 'standard';

	// echo '<!-- DEBUG: is_archive() || is_search() -->';
	switch ( $selected_blog_teaser_desing ) {
		case 'masonry':
			get_template_part( 'template-parts/teaser-designmasonry', $post_format );
			break;
		default:
			/* Include the Post-Format-specific template for the content.
			 * If you want to overload this in a child theme then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/teaser-designstandard', $post_format );
			break;
	}

} else {
	// echo '<!-- DEBUG: not archive() || not search() -->';
	// if we are on single page or post
	get_template_part( 'template-parts/content', 'page' );
}