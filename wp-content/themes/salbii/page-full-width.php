<?php
/**
 * Template Name: Full width
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */
get_header();

global $post;
?>

	<div id="primary" class="content-area">
		<?php get_template_part( 'template-parts/title', 'page' ); ?>
		<div id="content" class="site-content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php
					if(($post->post_type) == 'lbmn_project'){
						lbmn_content_nav( 'nav-below' ); // prev / next post links
					}
				?>
				<?php get_template_part( 'template-parts/section', 'comments' ); ?>
				<?php /* get_template_part( 'content', 'page' ); */ ?>
			<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>