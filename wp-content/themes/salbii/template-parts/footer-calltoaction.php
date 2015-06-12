<?php
/**
 * The template for displaying call to action block before menu.
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */


GLOBAL $theme_settings;
?>
<?php
if ( isset( $theme_settings['lbmn_calltoaction_switch'] ) && ( $theme_settings['lbmn_calltoaction_switch'] != '0' ) ): ?>
	<section class="calltoaction-area brand-bgcolor">
		<div class="row">
			<div class="large-9 columns">
			<?php
				$calltoaction_title = $theme_settings['lbmn_calltoaction_title'];

				if ( strlen($calltoaction_title) > 2 ) {
					echo "<h2 class='calltoaction-area__title brand-color-contrast brand-color-contrast-children'>$calltoaction_title</h2>";
				}
			?>
			</div>
			<div class="large-3 columns">
				<?php
					$calltoaction_button_text = $theme_settings['lbmn_calltoaction_button_text'];
					$calltoaction_button_url = $theme_settings['lbmn_calltoaction_button_url'];

					if ( strlen($calltoaction_button_text) > 2 ) {
						echo "<a href='$calltoaction_button_url' class='button large radius calltoaction-area__button border brand-contrast_bordercolor'>$calltoaction_button_text</a>";
					}
				?>
			</div>
		</div>
	</section>
<?php endif; // calltoaction_switch ?>