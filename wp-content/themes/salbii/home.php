<?php
/**
 * The blog index template file.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy, reference
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */
get_header();


?>

	<div id="primary" class="content-area">
		<?php
		// Output page title
		// see: /template-parts/title-page.php
		get_template_part( 'template-parts/title-page' );
		?>
		<div id="content" class="site-content" role="main">
			<?php
			// Output teasers list
			// see: /template-parts/teasers.php
			get_template_part( 'template-parts/teasers');
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>