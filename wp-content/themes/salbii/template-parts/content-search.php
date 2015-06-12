<?php
/**
 * Template for search teasers rendered on the search results page
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */


?>
<?php
	if ( has_post_thumbnail() ) {
		echo '<div class="entry-featured-img">';

		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$post_thumbnail_meta = wp_prepare_attachment_for_js( $post_thumbnail_id );

		$img_url = wp_get_attachment_url( $post_thumbnail_id,'full' );
		$post_thumbnail = bfi_thumb( $img_url, array( 'width' => 1130 ) );

		echo '<img src="'.$post_thumbnail.'" alt="'.$post_thumbnail_meta['alt'].'" />';

		echo '</div>';
	}
?>

	<div class="entry-content">
		<?php
			// Only display Excerpts for Search
			echo '<div class="entry-summary">';
				the_excerpt();
			echo '</div>';
		?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'lbmn' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'lbmn' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'lbmn' ) );

			if ( ! lbmn_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'lbmn' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'lbmn' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'lbmn' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'lbmn' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>

		<?php edit_post_link( __( 'Edit', 'lbmn' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
