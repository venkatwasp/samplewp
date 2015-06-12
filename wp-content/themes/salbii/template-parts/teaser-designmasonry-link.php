<?php
/**
 * Blog teaser: link format
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */


?>
<?php

?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('isotope-item post-format'); ?>>
		<div class="isotope-item_inner-wrapper">
		<?php
			echo '<div class="content-part break-teaser-padding colored-card-part">';
				// output div with post featured image as background
				// see founction source in /inc/template-tags.php
				echo lbmn_postteaserbg();
				$external_link = lbmn_get_content_link( get_the_content() );
				echo '<div class="content-part__innercontent" >';
					echo '<div class="post-format-icon"></div>';
					the_content( '' );
					echo '<cite>'.$external_link.'</cite>';
				echo '</div>';
				echo '<a href="' . $external_link . '" class="post-link" target="_blank"></a>';
			echo '</div>';
		?>
			<div  class="content-part">
				<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php
				// Post categories
				echo lbmn_postcategories();

				// Post author, date & comments count
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
				?>
			</div>
		</div>
	</article><!-- #post-## -->