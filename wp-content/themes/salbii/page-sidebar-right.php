<?php
/**
 * Template Name: Sidebar – Right
 *
 * This is the template that displays a page with sidebar on the left
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */
get_header();


?>

	<div id='primary' class='content-area'>
		<?php get_template_part( 'template-parts/title', 'page' ); ?>
		<div id='content' class='site-content' role='main'>
			<div class='row'>
				<div class='large-9 columns page-column-content sidebar-on-right'>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'page' ); ?>
						<?php get_template_part( 'template-parts/section', 'comments' ); ?>
					<?php endwhile; // end of the loop. ?>
				</div>
				<div class='large-3 columns page-column-sidebar page-column-sidebar__right'>
					<?php get_sidebar(); ?>
				</div>
			</div><!-- .row -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>