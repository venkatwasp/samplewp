<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */

if ( ! function_exists( 'lbmn_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function lbmn_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<div class="navigation-wrapper">
		<div class="row">
			<div class="twelve columns">
				<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
					<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'lbmn' ); ?></h1>

				<?php if ( is_single() ) : // navigation links for single posts ?>

					<?php
						previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'lbmn' ) . '</span> <span class="show-for-small">'.__( 'Previous', 'lbmn' ).'</span><span class="hide-for-small">%title</span>' );
						next_post_link( '<div class="nav-next">%link</div>', '<span class="show-for-small">'.__( 'Next', 'lbmn' ).'</span><span class="hide-for-small">%title</span> <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'lbmn' ) . '</span>' );
					?>

				<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

					<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'lbmn' ) ); ?></div>
					<?php endif; ?>

					<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'lbmn' ) ); ?></div>
					<?php endif; ?>

				<?php endif; ?>

				</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
			</div>
		</div>
	</div>
	<?php
}
endif; // lbmn_content_nav


if ( ! function_exists( 'lbmn_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function lbmn_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'lbmn' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'lbmn' ), '<span class="edit-link">', '<span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'lbmn' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'lbmn' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'lbmn' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( 'Edit', 'lbmn' ), '<span class="edit-link">', '<span>' ); ?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
			<?php
				comment_reply_link( array_merge( $args,array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				) ) );
			?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for lbmn_comment()


if ( ! function_exists( 'lbmn_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function lbmn_posted_by($version = 'category') {
	echo '<span class="byline">';
	printf( __( 'Posted by <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', 'lbmn' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'lbmn' ), get_the_author() ) ),
		get_the_author()
	);

	if ( 'post' == get_post_type() ) { // Hide category and tag text for pages on Search
		if ( $version == 'category' ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'lbmn' ) );
			if ( $categories_list && lbmn_categorized_blog() ) {
				echo ' <span class="cat-links">';
				printf( __( 'in %1$s', 'lbmn' ), $categories_list );
				echo '</span>';
			}
		} elseif ( $version == 'date' ) {
			echo ' <span class="posted-date">';
			//printf( __( 'on %1$s', 'lbmn' ), '<a href="' . get_permalink() . '" title="' . __( 'Read: ', 'lbmn' ) . esc_attr(get_the_title()) . '" >' . get_the_date() . '</a>' );
                        printf( __( 'on %1$s', 'lbmn' ), '<span title="' . __( 'Read: ', 'lbmn' ) . esc_attr(get_the_title()) . '" >' . get_the_date() . '</span>' );
			echo '</span>';
		}
	}

	echo '</span>';
}
endif;


/**
 * Returns true if a blog has more than 1 category
 */
if ( ! function_exists( 'lbmn_categorized_blog' ) ) :
function lbmn_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so lbmn_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so lbmn_categorized_blog should return false
		return false;
	}
}
endif;


/**
* ----------------------------------------------------------------------
* Place tags after post content
*/

// add_filter( 'the_content', 'lbmn_add_posttags', 10, 1 );

if ( ! function_exists( 'lbmn_get_posttags' ) ):
function lbmn_get_posttags() {
	$html = '';
	$tag_list = get_the_tag_list( '','' );
	if ( '' != $tag_list ) {
			$html = "<p class='post-footer-meta__tags'><span class='post-footer-meta__label'>" . __('Tagged:','lbmn') . "</span>" . $tag_list . "</p>";
	}
	return $html;
}
endif; //function_exists




/**
* ----------------------------------------------------------------------
* Snippet: post format teaser custom bg
*
* output div with post featured image as background
* Used in /template-parts/teaser-******.php
*/

if ( ! function_exists( 'lbmn_postteaserbg' ) ):
function lbmn_postteaserbg() {
    
    
	$output = '';
	$output .= '<div class="content-part__imagebg" ';
	if ( has_post_thumbnail() ) {
		$post_thumbnail_id = get_post_thumbnail_id( get_post()->ID );
		$img_url = wp_get_attachment_url( $post_thumbnail_id,'full' );
		$post_thumbnail = bfi_thumb( $img_url, array( 'width' => 545 ) );

		$output .= 'style="background:url(' . $post_thumbnail . ') center center no-repeat; background-size: cover;" ';
	}
	$output .= '></div>';
	return $output;
}
endif; //function_exists


if (!function_exists('lbmn_category_transient_flusher')){
    /**
     * Flush out the transients used in lbmn_categorized_blog
     */
    function lbmn_category_transient_flusher() {
            // Like, beat it. Dig?
            delete_transient( 'all_the_cool_cats' );
    }
    add_action( 'edit_category', 'lbmn_category_transient_flusher' );
    add_action( 'save_post', 'lbmn_category_transient_flusher' );
}