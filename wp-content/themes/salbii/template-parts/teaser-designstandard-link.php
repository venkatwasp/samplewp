<?php
/**
 * Link blog teaser design
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
			<?php
				echo '<h2 class="entry-title h1">';
					$external_link = lbmn_get_content_link( get_the_content() );
					echo '<a href="' . $external_link . '" target="_blank">'. get_the_title() .'</a>';
				echo '</h2>';
			?>
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
		}
	?>
		<div class="large-10 columns large-offset-2">
			<?php
				get_template_part( 'template-parts/teaser-designstandard-part-content' );
				// get content part. see: /template-parts/teaser-designstandard-part-content.php
			?>
		</div>
	</div><!-- .row -->
	</article><!-- #post-## -->