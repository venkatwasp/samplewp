<?php
/**
 * The Template for displaying header+preheader for separate pages and single posts.
 * Used with get_template_part()
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */


?>
<header class="page-title page-titile__single">
	<div class="page-titile__primary row">
		<div class="large-8 columns">
			<h1 class="page-title__primary-title h1"><?php single_post_title(); ?> </h1>
		</div>
		<div class="page-title__addon large-3 columns hide-for-small">
			<?php
				$show_author_info = true; // TODO: move it into theme settings panel
				if ( $show_author_info && is_single() ):

				global $post;
				$author_id=$post->post_author;
			?>
			<div class="author-info">
				<div class="author-info__avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email', $author_id ), apply_filters( 'tfingi_author_bio_avatar_size', 50 ) ); ?>
				</div>
				<div class="author-info__description-block small">
					<h4 class="author-info__name"><small><?php echo _e('By', 'wordpress'); ?></small> <a href="<?php echo get_author_posts_url( $author_id ); ?>"><?php the_author_meta( 'display_name', $author_id ); ?></a><small>,</small> </h4>
					<span class="single-post__date"><?php echo get_the_date(); ?></span>
				</div>
			</div>
			<?php endif; /* $show_author_info */ ?>
		</div>
	</div>
</header><!-- .entry-header -->
