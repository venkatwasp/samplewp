<?php
/**
 * Video blog teaser design
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */


?>
<?php

?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('design-standard post-format'); ?>>
	<div class="row">
		<div class="large-10 columns large-offset-2 small-11 small-offset-1">
			<?php
				if ( 'post' == get_post_type() ) { // Hide category and tag text for pages on Search
						/* translators: used between list items, there is a space after the comma */
						$categories_list = get_the_category_list( __( ', ', 'lbmn' ) );
						if ( $categories_list && lbmn_categorized_blog() ) {
							echo ' <span class="cat-links">';
							echo $categories_list;
							echo '</span>';
						}
				}
			?>
		</div>
	</div><!-- .row -->
	<div class="row">
		<div class="large-2 small-1 columns">
			<div class='post-format-icon'></div>
		</div>
		<div class="large-10 small-11 columns">
			<h2 class="entry-title h1"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</div>
	</div><!-- .row -->
	<div class="row">
	<?php
		if ( has_post_thumbnail() ) {
			echo '<div class="large-12 columns entry-featured-img">';
			if( !is_single() ) {  echo '<a href="' . get_permalink() . '">'; }

				$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
				$post_thumbnail_meta = wp_prepare_attachment_for_js( $post_thumbnail_id );

				$img_url = wp_get_attachment_url( $post_thumbnail_id,'full' );
				$post_thumbnail = bfi_thumb( $img_url, array( 'width' => 820, 'height' => 330, 'crop' => true ) );

				echo '<img src="'.$post_thumbnail.'" alt="'.$post_thumbnail_meta['alt'].'" />';

			if( !is_single() ) {  echo'</a>'; }
			echo '</div>';
		} else {
			echo '<div class="large-12 columns entry-featured-img">';
				$external_link = lbmn_get_content_link( get_the_content() );
				echo '<div class="flex-video" >';
					global $wp_embed;
					echo $wp_embed->run_shortcode(' [embed]'.$external_link.'[/embed] ' );
					// echo do_shortcode( ' [embed]'.$external_link.'[/embed] ' ); doens't work here
				echo '</div>';
			echo '</div>';
		}
	?>
		<div class="large-10 columns large-offset-2">
			<?php
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
                                
                                echo lbmn_get_posttags();
			?>

		</div>
	</div><!-- .row -->
	</article><!-- #post-## -->