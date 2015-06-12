<?php
/**
 * Content part for most teasers of standard design
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */



$invite_to = 'readmore';

if ( is_search() ) { // Only display Excerpts for Search
	echo '<div class="entry-summary">';
		the_excerpt();
	echo '</div>';
} else {
	// Check the content for the more text
	$ismore = strpos( $post->post_content, '<!--more-->');
	$invite_to = 'readmore';
	if ( $post->post_excerpt && !$ismore ) { // display excerpt if there is no <!-- more --> tag and excerpt is set
		echo '<div class="entry-summary">';
			the_excerpt();
		echo '</div>';
	} elseif ($ismore) { // display summary as defined by <!-- more --> tag
		echo '<div class="entry-summary">';
			the_content( '' );
		echo '</div>';
	} else { // display full content
		get_template_part( 'template-parts/content-single' );
		$invite_to = 'leavecomment';
	}
}

$post_id = get_the_ID();
echo '<div class="entry-meta">';
	if ( $invite_to == 'readmore' ) {
		echo '<a href="' . get_permalink() . '" title="' . __( 'Read: ', 'lbmn' ) . esc_attr(get_the_title()) . '" class="button radius">' . __( 'Read more', 'lbmn' ) . '<span aria-hidden="true" class="icon-arrow-right-4"></span></a>';
	} elseif ( $invite_to == 'leavecomment' && comments_open( $post_id ) ) {
		echo '<a href="' . get_permalink() . '" title="' . __( 'Comment on: ', 'lbmn' ) . esc_attr(get_the_title()) . '" class="button radius">' . __( 'Leave your comment', 'lbmn' ) . '<span aria-hidden="true" class="icon-arrow-right-4"></span></a>';
	}

	lbmn_posted_by('date');

	if ( comments_open( $post_id ) ) {
		echo '<a href="' . get_comments_link() . '" title="' . __( 'Comment on: ', 'lbmn' ) . esc_attr(get_the_title()) . '" class="call-to-comment">';
		comments_number();
		echo '</a>';
	}
echo '</div>'; // post-meta
?>