<?php
/**
 * Gallery blog teaser design
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */

?>
<?php

?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('isotope-item  post-format'); ?>>
		<div class="isotope-item_inner-wrapper">
		<?php
			if ( has_post_thumbnail() ) {
				echo '<div class="entry-featured-img post-thumb colored-card-part">';
				if( !is_single() ) {  echo '<a href="' . get_permalink() . '">'; }

					$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
					$post_thumbnail_meta = wp_prepare_attachment_for_js( $post_thumbnail_id );

					$img_url = wp_get_attachment_url( $post_thumbnail_id,'full' );
					$post_thumbnail = bfi_thumb( $img_url, array( 'width' => 545 ) );

					echo '<img src="'.$post_thumbnail.'" alt="'.$post_thumbnail_meta['alt'].'" />';

				if( !is_single() ) {  echo'</a>'; }
				echo '</a></div>';
			} else {
				echo '<div class="entry-featured-img post-thumb colored-card-part">';
					$link_tofile = lbmn_get_content_link( get_the_content() );
					if( !is_single() ) {  echo '<a href="' . get_permalink() . '">'; }
						echo '<img src="'.$link_tofile.'" />';
					if( !is_single() ) {  echo'</a>'; }
				echo '</div>';
			}
		?>
		<div class="content-part">
		<?php
			// Post categories
			echo lbmn_postcategories();
		?>
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php
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
					}

					$post_id = get_the_ID();
					echo '<div class="entry-meta">';
						echo '<span class="byline">';
						printf( __( 'by <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', 'lbmn' ),
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
							esc_attr( sprintf( __( 'View all posts by %s', 'lbmn' ), get_the_author() ) ),
							get_the_author()
						);
							echo ' <span class="posted-date">';
								echo ' / ';
                                                                the_date();
							echo '</span>';
						echo '</span>';

						if ( comments_open( $post_id ) ) {
							echo '<a href="' . get_comments_link() . '" title="' . __( 'Comment on: ', 'lbmn' ) . esc_attr(get_the_title()) . '" class="call-to-comment">';
							echo "<b class='icon' aria-hidden='true' data-icon='&#xe050;'></b> ";
							comments_number('0', '1', '%');
							echo '</a>';
						}
					echo '</div>'; // post-meta
				}
			?>
			</div>
		</div>
	</article><!-- #post-## -->