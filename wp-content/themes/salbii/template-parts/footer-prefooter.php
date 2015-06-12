<?php
/**
 * The template for displaying pre-footer area.
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */


GLOBAL $theme_settings;
?>
	<?php
		$prefooter_main_switch = true;

		if ( isset( $theme_settings[ 'lbmn_prefooter_main_switch'] ) && ( $theme_settings[ 'lbmn_prefooter_main_switch'] == '0' ) ) {
			$prefooter_main_switch = false;
		}

		if ( $prefooter_main_switch ):

				$prefooter_layout = 'prefooter-columns-4';
				if ( isset( $theme_settings[ 'lbmn_prefooter_layout'] ) ) {
					$prefooter_layout = $theme_settings[ 'lbmn_prefooter_layout'];
				}

				if ( $prefooter_layout == 'prefooter-columns-1' ):
			?>
					<?php if ( is_active_sidebar( 'prefooter-col1' ) ): ?>
						<div class="site-prefooter">
							<div class="row">
								<div class="large-12 columns">
									<?php dynamic_sidebar( 'prefooter-col1' ); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php elseif ( $prefooter_layout == 'prefooter-columns-2' ): ?>
					<?php if ( is_active_sidebar( 'prefooter-col1' ) || is_active_sidebar( 'prefooter-col2' ) ): ?>
						<div class="site-prefooter">
							<div class="row">
								<div class="large-6 columns">
									<?php dynamic_sidebar('prefooter-col1'); ?>
								</div>
								<div class="large-6 columns">
									<?php dynamic_sidebar('prefooter-col2'); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php elseif ( $prefooter_layout == 'prefooter-columns-2-alt1' ): ?>
					<?php if ( is_active_sidebar( 'prefooter-col1' ) || is_active_sidebar( 'prefooter-col2' ) ): ?>
						<div class="site-prefooter">
							<div class="row">
								<div class="large-8 columns">
									<?php dynamic_sidebar('prefooter-col1'); ?>
								</div>
								<div class="large-4 columns">
									<?php dynamic_sidebar('prefooter-col2'); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php elseif ( $prefooter_layout == 'prefooter-columns-2-alt2' ): ?>
					<?php if ( is_active_sidebar( 'prefooter-col1' ) || is_active_sidebar( 'prefooter-col2' ) ): ?>
						<div class="site-prefooter">
							<div class="row">
								<div class="large-4 columns">
									<?php dynamic_sidebar('prefooter-col1'); ?>
								</div>
								<div class="large-8 columns">
									<?php dynamic_sidebar('prefooter-col2'); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php elseif ( $prefooter_layout == 'prefooter-columns-3' ): ?>
					<?php if ( is_active_sidebar( 'prefooter-col1' ) || is_active_sidebar( 'prefooter-col2' ) || is_active_sidebar( 'prefooter-col3' ) ): ?>
						<div class="site-prefooter">
							<div class="row">
								<div class="large-4 columns">
									<?php dynamic_sidebar('prefooter-col1'); ?>
								</div>
								<div class="large-4 columns">
									<?php dynamic_sidebar('prefooter-col2'); ?>
								</div>
								<div class="large-4 columns">
									<?php dynamic_sidebar('prefooter-col3'); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php elseif ( $prefooter_layout == 'prefooter-columns-3-alt1' ): ?>
					<?php if ( is_active_sidebar( 'prefooter-col1' ) || is_active_sidebar( 'prefooter-col2' ) || is_active_sidebar( 'prefooter-col3' ) ): ?>
						<div class="site-prefooter">
							<div class="row">
								<div class="large-3 columns">
									<?php dynamic_sidebar('prefooter-col1'); ?>
								</div>
								<div class="large-3 columns">
									<?php dynamic_sidebar('prefooter-col2'); ?>
								</div>
								<div class="large-6 columns">
									<?php dynamic_sidebar('prefooter-col3'); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php elseif ( $prefooter_layout == 'prefooter-columns-3-alt2' ): ?>
					<?php if ( is_active_sidebar( 'prefooter-col1' ) || is_active_sidebar( 'prefooter-col2' ) || is_active_sidebar( 'prefooter-col3' ) ): ?>
						<div class="site-prefooter">
							<div class="row">
								<div class="large-6 columns">
									<?php dynamic_sidebar('prefooter-col1'); ?>
								</div>
								<div class="large-3 columns">
									<?php dynamic_sidebar('prefooter-col2'); ?>
								</div>
								<div class="large-3 columns">
									<?php dynamic_sidebar('prefooter-col3'); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php else: // default is 4 columns ?>
					<?php if ( is_active_sidebar( 'prefooter-col1' ) || is_active_sidebar( 'prefooter-col2' ) || is_active_sidebar( 'prefooter-col3' ) || is_active_sidebar( 'prefooter-col4' ) ): ?>
						<div class="site-prefooter">
							<div class="row">
								<div class="large-3 columns">
									<?php dynamic_sidebar('prefooter-col1'); ?>
								</div>
								<div class="large-3 columns">
									<?php dynamic_sidebar('prefooter-col2'); ?>
								</div>
								<div class="large-3 columns">
									<?php dynamic_sidebar('prefooter-col3'); ?>
								</div>
								<div class="large-3 columns">
									<?php dynamic_sidebar('prefooter-col4'); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; //$prefooter_layout == ... ?>
	<?php endif; //$prefooter_main_switch ?>