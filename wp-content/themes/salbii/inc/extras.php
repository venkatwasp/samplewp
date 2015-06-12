<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function lbmn_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'lbmn_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function lbmn_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_page() ) { // need this condition to not have error message on search results page

		if ( function_exists('rwmb_meta') ) {
			// Add special class based on 'Remove top/bottom spacing' metabox value
			$page_spacing_settings = rwmb_meta( 'lbmn_page_design_settings', 'type=checkbox_list' );
		}

		if ( !empty($page_spacing_settings) ) {
			if ( in_array('no_top_padding', $page_spacing_settings) ) {
				$classes[] = 'content__no-top-padding';
			}
			if ( in_array('no_bottom_padding', $page_spacing_settings) ) {
				$classes[] = 'content__no-bottom-padding';
			}
		}
	}

	if ( is_home() || is_archive() || is_search() ) {
		// Add special class for blog section based on blog layout selected
		GLOBAL $theme_settings; // get theme options

		// Get selected [Blog Design] option from Theme Options panel
		if ( isset($theme_settings['lbmn_blog_design']) ) {
			$selected_blog_teaser_design = $theme_settings['lbmn_blog_design'];
		} else {
			$selected_blog_teaser_design = 'standard';
		}

		// [Blog Design] setting can be overrided by custom fields (used for theme demo mainly)
		switch ( get_post_meta( get_option( 'page_for_posts' ), 'blog_design', true ) ) {
			case 'standard':
					$selected_blog_teaser_design = 'standard';
				break;
			case 'masonry':
					$selected_blog_teaser_design = 'masonry';
				break;
		}

		if ( $selected_blog_teaser_design == 'masonry' ) {
			$classes[] = 'blog-style-masonry';
		} else {
			$classes[] = 'blog-style-standard';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'lbmn_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function lbmn_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'lbmn_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function lbmn_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'lbmn' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'lbmn_wp_title', 10, 2 );


/**
* ----------------------------------------------------------------------
* Get image/attachment ID by URL
* @link http://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
*/

function lbmn_get_attachment_id_from_url( $attachment_url = '' ) {

	global $wpdb;
	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url )
		return;

	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}

	return $attachment_id;
}

/**
* ----------------------------------------------------------------------
* Wrap non-Visual Composer content in grid classes
*/

add_filter( 'the_content', 'lbmn_wrap_non_vc_content', 7, 1 );

if ( ! function_exists( 'lbmn_wrap_non_vc_content' ) ):
function lbmn_wrap_non_vc_content($content) {
	// get first 20 characters of the page content
	$content_start = substr($content, 0, 20);
	// check if page isn't Visual Composer output.
	if ( !stristr($content_start, 'vc_row') ) {
		// wrap content with 12 columns grid
		$content = '<div class="row"><div class="large-12 columns entry-content__output non-vc-entry">' . $content.'</div></div>';
	} else {
		$content =  $content . '<div class="row"><div class="large-12 columns after-content-output">';
	}
	// lbmn_debug($content);
	return $content;
}
endif; //function_exists

/**
* ----------------------------------------------------------------------
* Post categories snippet
* Used in /template-parts/teaser-******.php
*/

if ( ! function_exists( 'lbmn_postcategories' ) ):
function lbmn_postcategories() {
	// Post categories
	if ( 'post' == get_post_type() ) { // Hide category and tag text for pages on Search
			$output = '';
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'lbmn' ) );
			if ( $categories_list && lbmn_categorized_blog() && !stristr($categories_list, 'Uncategorized') ) {
				$output .= ' <span class="post-categories">';
				$output .= $categories_list;
				$output .= '</span>';
			}
			return $output;
	}
}
endif; //function_exists



/**
* ----------------------------------------------------------------------
* Get the first link in posts
* http://www.wprecipes.com/wordpress-tip-how-to-get-the-first-link-in-posts
*
* used in teaser for post format link
*/

if ( ! function_exists( 'lbmn_get_content_link' ) ):
function lbmn_get_content_link( $content = false, $echo = false ){
    if ( $content === false )
        $content = get_the_content();

    // $content = preg_match_all( '/hrefs*=s*["']([^"']+)/', $content, $links );
    $pattern ='(?xi)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?]))';
    $content = preg_match_all( "#$pattern#i", $content, $links );
    $content = $links[1][0];

    if ( empty($content) ) {
    	$content = false;
    }

    return $content;
}
endif; //function_exists



/**
* ----------------------------------------------------------------------
* Return menu id from menu name
*/

if ( ! function_exists( 'lbmn_get_menuid_by_menuname' ) ):
function lbmn_get_menuid_by_menuname($menu_name) {
	$menus   = wp_get_nav_menus();
	$menu_id = 0;
	foreach ( $menus as $menu ) {
		$loop_menu_name = wp_html_excerpt( $menu->name, 40, '&hellip;' );
		$menuchoices[ $menu->term_id ] = $loop_menu_name;

		if ( $menu_name == $loop_menu_name ) { // get menu id for default icons menu
			$menu_id = $menu->term_id;
		}
	}

	return $menu_id;
}
endif; //function_exists


/**
 * ----------------------------------------------------------------------
 * Wrap oEmbed code with <div class="flex-video">
 * http://wordpress.org/support/topic/adding-a-wrapping-div-to-video-embeds
 */

add_filter('embed_oembed_html', 'lbmn_embed_oembed_html', 99, 4);
function lbmn_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="flex-video">' . $html . '</div>';
}
