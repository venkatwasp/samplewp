<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 *
 * Code based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Some code is based on open-source tools or open-published code snippets
 */



get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<div class="row">
				<div class="large-12 columns">

					<article id="post-0" class="post error404 not-found">
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'lbmn' ); ?></h1>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'lbmn' ); ?></p>

							<?php get_search_form(); ?>

							<div class="row">
								<div class="large-4 columns">
									<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
								</div>
								<div class="large-4 columns">
									<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
								</div>
								<div class="large-4 columns">
									<?php if ( lbmn_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
									<div class="widget widget_categories">
										<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'lbmn' ); ?></h2>
										<ul>
										<?php
											wp_list_categories( array(
												'orderby'    => 'count',
												'order'      => 'DESC',
												'show_count' => 1,
												'title_li'   => '',
												'number'     => 10,
											) );
										?>
										</ul>
									</div><!-- .widget -->
									<?php endif; ?>
								</div>
							</div>


						</div><!-- .entry-content -->
					</article><!-- #post-0 .post .error404 .not-found -->

				</div>
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>