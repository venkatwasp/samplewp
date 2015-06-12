<?php
/**
 * The Template for displaying header+preheader for separate pages and single posts.
 * Used with get_template_part()
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 *
 * Code based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Some code is based on open-source tools or open-published code snippets
 */



GLOBAL $theme_settings;
$output_primarytitle = $output_secondarytitle = "";
$disable_title = false;

if ( !is_search() ) { // these values isn't available on search page

	if ( function_exists('rwmb_meta') ) {
	
		// Get 'Disable page title' metabox value
		if( is_home() ) {
			$post_id = get_option('page_for_posts');
			$title_settings = rwmb_meta( 'lbmn_page_title_settings', 'type=checkbox_list', $post_id );
		} else {
			$title_settings = rwmb_meta( 'lbmn_page_title_settings', 'type=checkbox_list' );
		}
				
	} else {
		$title_settings = '';
	}

	if ( isset($title_settings[0]) && $title_settings[0] == 'hidden') {
		$disable_title = true; // turn off page title
	}

	if ( function_exists('rwmb_meta') ) {
	
		// Get secondary title metabox value
		if( is_home() ) {
			$post_id = get_option('page_for_posts');
			$secondarytitle = rwmb_meta( 'lbmn_secondary_page_title', 'type=text', $post_id );
		} else {
			$secondarytitle = rwmb_meta( 'lbmn_secondary_page_title', 'type=text' );
		}
		
	} else {
		$secondarytitle = '';
	}
	$output_secondarytitle = $secondarytitle;

}

if ( is_search() ) { // special title for search result page

	// get number of posts found for search query
	$newSearch = new WP_Query("s=$s & showposts=-1");
	$search_results_count = $newSearch->post_count;

	$output_primarytitle = __( 'You are searching for: ', 'lbmn' ) . '<span>' . get_search_query() . '</span>';

	if ( 1 == $search_results_count ) {
		$output_secondarytitle = __( 'There is one post that match your criteria...', 'lbmn' );
	} elseif ( 1 < $search_results_count ) {
		$output_secondarytitle = sprintf( __( 'Here are %s posts that match your criteria...', 'lbmn' ), '<span>' . $search_results_count . '</span>' );
	} else {
		$output_secondarytitle = __( 'Looks like nothing was found. Sorry.', 'lbmn' );
	}
	
} elseif ( is_archive() ) {

	if ( is_category() ) :
		$output_primarytitle = sprintf( __( 'Category Archives: %s', 'lbmn' ), '<span>' . single_cat_title( '', false ) . '</span>' );

	elseif ( is_tag() ) :
		$output_primarytitle = sprintf( __( 'Tag Archives: %s', 'lbmn' ), '<span>' . single_tag_title( '', false ) . '</span>' );

	elseif ( is_author() ) :
		/* Queue the first post, that way we know
		 * what author we're dealing with (if that is the case).
		*/
		the_post();
		$output_primarytitle = sprintf( __( 'Author Archives: %s', 'lbmn' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
		/* Since we called the_post() above, we need to
		 * rewind the loop back to the beginning that way
		 * we can run the loop properly, in full.
		 */
		rewind_posts();

	elseif ( is_day() ) :
		$output_primarytitle = sprintf( __( 'Daily Archives: %s', 'lbmn' ), '<span>' . get_the_date() . '</span>' );

	elseif ( is_month() ) :
		$output_primarytitle = sprintf( __( 'Monthly Archives: %s', 'lbmn' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

	elseif ( is_year() ) :
		$output_primarytitle = sprintf( __( 'Yearly Archives: %s', 'lbmn' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

	elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
		_e( 'Asides', 'lbmn' );

	elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
		_e( 'Images', 'lbmn');

	elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
		_e( 'Videos', 'lbmn' );

	elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
		_e( 'Quotes', 'lbmn' );

	elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
		_e( 'Links', 'lbmn' );
		
	else : 
		//_e( 'Archives', 'lbmn' );

	endif;


	if ( is_category() ) :
		// show an optional category description
		$category_description = category_description();
		if ( ! empty( $category_description ) ) :
			$output_secondarytitle = apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );
		endif;

	elseif ( is_tag() ) :
		// show an optional tag description
		$tag_description = tag_description();
		if ( ! empty( $tag_description ) ) :
			$output_secondarytitle = apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
		endif;

	endif;

} else {
	$output_primarytitle = single_post_title( '', false );
}

if ( !$disable_title ):
?>
<?php
if ( is_search() ) {
	echo '<div class="searchpage-searchform brand-bgcolor"><div class="row"><div class="large-12 columns">';
		get_search_form();
	echo '</div></div></div>';
}
?>
<header class="page-title">
	<div class="row">
		<div class="large-12 columns">
			<?php if ( $output_primarytitle ): ?>
				<h1 class="page-title__primary-title h1"><?php echo $output_primarytitle; ?></h1>
			<?php endif ?>
			<?php
				if ( isset($theme_settings['lbmn_title_breadcrumbs']) && ($theme_settings['lbmn_title_breadcrumbs'] != '0')  ) {
					// lbmn_breadcrumbs( 'page-title__breadcrumbs', 6 )
					// disabled until breadcrumbs bug on iPhone will be solved
					// when re-enable check its work in portfolio projects
				}
			?>
			<?php if ( $output_secondarytitle ): ?>
				<h3 class="page-title__secondary-title"><?php echo $output_secondarytitle; ?></h3>
			<?php endif ?>
		</div>
	</div>
</header><!-- .entry-header -->
<?php
endif; // !$disable_title
?>
