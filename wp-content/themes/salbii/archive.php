<?php
/**
 * The template for displaying Archive pages.
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */
get_header();


?>
	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			
			<?php
			// Output page title
			// see: /template-parts/title-page.php
			get_template_part( 'template-parts/title-page' );

			// Output teasers list
			// see: /template-parts/teasers.php
			get_template_part( 'template-parts/teasers');
			?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>