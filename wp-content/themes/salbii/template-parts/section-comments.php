<?php
/**
 * The Template for displaying comments section part across the pages and posts.
 *
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */


?>

<?php
// If comments are open or we have at least one comment, load up the comment template
if ( comments_open() || '0' != get_comments_number() ): ?>
<section class="comments-section">
	<div class="row">
		<div class="large-12 columns">
		<?php comments_template(); ?>
		</div>
	</div><!-- .row -->
</section>
<?php endif; // if comments_open ?>
