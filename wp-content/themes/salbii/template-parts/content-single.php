<?php
/**
 * The template for displaying blog post page.
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */
GLOBAL $theme_settings; // get theme options


?>
<?php if ( is_single() ): // do not render <article> tag if full blog post rendered in blog index ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	if ( has_post_thumbnail() && $theme_settings['lbmn_blog_disable_feature_image_on_blog_post_page'] == 0) {
		echo '<div class="entry-featured-img">';

		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$post_thumbnail_meta = wp_prepare_attachment_for_js( $post_thumbnail_id );

		$img_url = wp_get_attachment_url( $post_thumbnail_id,'full' );
		$post_thumbnail = bfi_thumb( $img_url, array( 'width' => 1130 ) );

		echo '<img src="'.$post_thumbnail.'" alt="'.$post_thumbnail_meta['alt'].'" />';
		echo '</div>';
	}
?>
<?php endif ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			echo '<div class="post-footer-meta">';
				wp_link_pages( array(
					'before' => '<div class="page-links"><span class="post-footer-meta__label">' . __( 'Pages:', 'lbmn' ) . '</span>',
					'after'  => '</div>',
				) );

				// Output post tags. Function defined in /inc/template-tags.php
				echo lbmn_get_posttags();
			echo '</div>';
		?>
	</div><!-- .entry-content -->

<?php if ( is_single() ):?>
</article><!-- #post-## -->
<?php endif ?>
