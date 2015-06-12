<?php
/**
 * The Template for displaying all single posts.
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */
get_header();


GLOBAL $theme_settings;

?>

	<div id="primary" class="content-area">
		<?php get_template_part( 'template-parts/title', 'single' ); ?>
		<div id="content" class="site-content" role="main">
				<?php
                                if (isset($theme_settings['lbmn_blog_post_layout'])){
                                    $blog_sidebar_position = $theme_settings['lbmn_blog_post_layout'];
                                } else {
                                    $blog_sidebar_position="";
                                }
				$blog_layout_close = "";

				switch ( $blog_sidebar_position ) {
					case 'full':
						echo "<div class='row'><div class='large-12 columns'>";
						break;
					case 'left':
						echo "<div class='row'><div class='large-9 columns push-3 page-column-sidebar page-column-sidebar__left'>";
						$blog_layout_close = "</div><div class='large-3 columns pull-9 page-column-content sidebar-on-left'>";
						break;
					default:
						echo "<div class='row'><div class='large-9 columns page-column-content sidebar-on-right'>";
						$blog_layout_close = "</div><div class='large-3 columns page-column-sidebar page-column-sidebar__right'>";
						break;
				}
				?>

				<?php
					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/content', 'single' );
						lbmn_content_nav( 'nav-below' ); // prev / next post links
						get_template_part( 'template-parts/section', 'comments' );
					}                                       
				?>
				<?php echo $blog_layout_close; ?>
				<?php				
				if ( 'full' != $blog_sidebar_position ) {
                                    echo get_sidebar();
				 } ?>
				</div>
			</div><!-- .row -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php /*get_sidebar();*/ ?>
<?php get_footer(); ?>