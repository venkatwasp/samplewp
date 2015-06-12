<?php
/**
 * The default template for displaying list/grid of post teasers.
 * Used for home/index/archive/search.
 * Used as a hub that redirects to the right teaser/full page template files based on options.
 *
 * Template files that use this teasers.php:
 * 	– home.php
 *  – archive.php
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */
GLOBAL $theme_settings; // get theme options





if ( have_posts() || is_page_template('page-demoblog.php') ) {

	/**
	* ----------------------------------------------------------------------
	* Blog teaser design
	*/

	// Get selected [Blog Design] option from Theme Options panel
	if ( isset($theme_settings['lbmn_blog_design']) ) {
		$selected_blog_teaser_design = $theme_settings['lbmn_blog_design'];
	} else {
		$selected_blog_teaser_design = 'standard';
	}

	// [Blog Design] setting can be overrided by custom fields (used for theme demo mainly)
	//switch ( get_post_meta( get_option( 'page_for_posts' ), 'blog_design', true ) ) {
	switch ( get_post_meta( get_the_ID(), 'blog_design', true ) ) {
		case 'standard':
				$selected_blog_teaser_design = 'standard';
			break;
		case 'masonry':
				$selected_blog_teaser_design = 'masonry';
			break;
	}




	/**
	* ----------------------------------------------------------------------
	* Blog columns number
	*/

	if ( $selected_blog_teaser_design == 'masonry' ) {

		// Get selected [Blog Columns Number] option from Theme Options panel
		if ( isset($theme_settings['lbmn_blog_columns']) ) {
			$blog_columns = $theme_settings['lbmn_blog_columns'];
		} else {
			$blog_columns = 'blog-columns-3';
		}

		// [Blog Columns Number] setting can be overrided by custom fields (used for theme demo mainly)
		switch ( get_post_meta( get_the_ID(), 'blog_columns', true ) ) {
			case 'blog-columns-2':
					$blog_columns = 'blog-columns-2';
				break;
			case 'blog-columns-3':
					$blog_columns = 'blog-columns-3';
				break;
			case 'blog-columns-4':
					$blog_columns = 'blog-columns-4';
				break;
		}

		// Change columns classes in accordance with VC project grid
		switch ( $blog_columns ) {
			case 'blog-columns-2':
					$blog_columns = 'columns_count_2';
				break;
			case 'blog-columns-3':
					$blog_columns = 'columns_count_3';
				break;
			case 'blog-columns-4':
					$blog_columns = 'columns_count_4';
				break;
		}

		$blog_columns_num = preg_replace("/[^0-9]/","",$blog_columns);
	}

	// Define teaser design
	switch ( $selected_blog_teaser_design ) {
		case 'masonry':
			$teaser_design = 'masonry';
			function lbmn_isotope_scripts() {
				wp_enqueue_script( 'lbmn-isotope', get_template_directory_uri() . '/javascripts/jquery.isotope.min.js', array('jquery'), '05092013', true );
			}
			add_action( 'wp_footer', 'lbmn_isotope_scripts' ); // register isotope javascript library
			?>
			<script type="text/javascript">
			(function($) {			
				$(document).ready(function($){
				
					/**
					 * Isotope init
					 */
					var $teasersgrid = $('.masonry-grid .masonry-teasers-container');
					var teasersColumnWidth = $teasersgrid.innerWidth() / <?php echo $blog_columns_num; ?>;

					$teasersgrid.imagesLoaded( function(){
						$teasersgrid.isotope({
							itemSelector : '.isotope-item',
							containerClass: 'isotope',
							masonry: { columnWidth: teasersColumnWidth }
						});
					});

					// Isotope per project loading
					$('.masonry-grid .masonry-teasers-container .isotope-item').each(function (i) {
						$(this).delay(i * 300).animate({
							'opacity': 1
						}, 800);
					});

					$(window).resize(function(){
						teasersColumnWidth = $teasersgrid.innerWidth() / <?php echo $blog_columns_num; ?>;

						$teasersgrid.isotope({
							masonry: { columnWidth: teasersColumnWidth }
						});
					});

				});
			})(jQuery);
			</script>
			<?php

			break;

		default:
			$teaser_design = 'standard';
			break;
	}



	/**
	* ----------------------------------------------------------------------
	* Blog sidebar position
	*/

	// Get blog sidebar position settigns value from Theme Options
	if ( isset($theme_settings['lbmn_blog_index_layout']) ) {
		$blog_sidebar_position = $theme_settings['lbmn_blog_index_layout'];
	} else {
		$blog_sidebar_position = 'full';
	}

	// Blog sidebar position can be overrided by custom fields (used mainly for theme demo)
	//switch ( get_post_meta( get_option( 'page_for_posts' ), 'blog_layout', true ) ) {
	switch ( get_post_meta( get_the_ID(), 'blog_layout', true ) ) {
		case 'full':
				$blog_sidebar_position = 'full';
			break;
		case 'right':
				$blog_sidebar_position = 'right';
			break;
		case 'left':
				$blog_sidebar_position = 'left';
			break;
	}



	/**
	* ----------------------------------------------------------------------
	* Blog teasers output
	*/
	$featured_post_is_sticky = false;
	// Featured Post
	// Promote first post for masonry layout (only on the first page)
	if ( $teaser_design == 'masonry' && ( get_query_var('paged') == 0 )  && !is_archive() && !is_search() ) {
		query_posts('posts_per_page=1&post_type=post');
		// while ( have_posts() ) { // Start the Loop
		if ( have_posts() ) {
		// changed 'while' to 'if' as it outputs all the sitcky postst when defined (I don't like it)
			the_post(); // Standard thing.

			if( is_sticky() ) {
				$featured_post_is_sticky = true;
			}
			// Get current post format
			// we use it to style teasers appropriately
			$post_format = get_post_format();
			if ( false === $post_format ) {
				$post_format = 'standard';
			}

			echo '<div class="row"><div class="large-12 columns"><div class="featured-post">';
				get_template_part( 'template-parts/teaser-design'. $teaser_design, $post_format ); // Include the Post-Format-specific template for the content.
			echo '</div></div></div>';
		}
		wp_reset_query();  // Restore global post data
	}


	$blog_layout_close = "";

	// Output the grid variation needed based on selected sidebar position
	switch ( $blog_sidebar_position ) {
		case 'right':
			if ( $teaser_design == 'masonry' ) {
				$blog_columns = ' '.$blog_columns;
				echo "<div class='row'><div class='large-12 columns page-column-content no-sidebar blog-masonry masonry-grid{$blog_columns}'><div class='masonry-teasers-container'>";
			} else {
				echo "<div class='row'><div class='large-9 columns page-column-content sidebar-on-right'>";
			}
			$blog_layout_close = "</div><div class='large-3 columns page-column-sidebar page-column-sidebar__right'>";
			break;

		case 'left':
			if ( $teaser_design == 'masonry' ) {
				$blog_columns = ' '.$blog_columns;
				echo "<div class='row'><div class='large-12 columns page-column-content no-sidebar blog-masonry masonry-grid{$blog_columns}'><div class='masonry-teasers-container'>";
			} else {
				echo "<div class='row'><div class='large-9 columns push-3 page-column-sidebar page-column-sidebar__left'>";
			}
			$blog_layout_close = "</div><div class='large-3 columns pull-9 page-column-content sidebar-on-left'>";
			break;

		default:
			if ( $teaser_design == 'masonry' ) {
				$blog_columns = ' '.$blog_columns;
				echo "<div class='row'><div class='large-12 columns page-column-content no-sidebar blog-masonry masonry-grid{$blog_columns}'><div class='masonry-teasers-container'>";
			} else {
				echo "<div class='row'><div class='large-8 columns large-offset-2 page-column-content no-sidebar'>";
			}
			break;
	}

			// Skip first post for masonry layout (we promote it specia way above)
			if ( $teaser_design == 'masonry' && !is_archive() && !is_search() ) {
				$default_posts_per_page = get_option( 'posts_per_page' );
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				// Remove latest post from the first page of paged blog home
				// BUT not when featured post is sticky
				// http://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
				if ( !$featured_post_is_sticky ) {
					$offset = 1;
				} else {
					$offset = 0;
				}

				if ( $paged != 1) {
					$offset = ($offset-1) + ( ($paged-1) * get_option('posts_per_page') );
				}

				$args = array(
					'offset' => $offset,
					'posts_per_page' => $default_posts_per_page,
					'paged' => $paged,
					'post_type' => 'post'
				);

				query_posts($args);

			} else {
                            
				$default_posts_per_page = get_option( 'posts_per_page' );
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				if ( !is_search() ) {
					
					// If it's not search results – display only blog posts
					$args = array(
						'posts_per_page' => $default_posts_per_page,
						'paged' => $paged,
						'post_type' => 'post'
					);

				} else {
					// If it's search results page - include all content types
					$args = array(
						'posts_per_page' => $default_posts_per_page,
						'paged' => $paged,
						'post_type' => 'any'
					);
                                        
                                        
				}
                                
                                
                        
				if( !is_search() && !get_query_var('tag') && !get_query_var('cat')) {
					//leading to bug at date sorting and categories. 04.04 by max
					query_posts($args);
				}
			}
                        
			//TG. filtering options, that should be connected with the masonry and things above i think ?
                        if (!is_search() && $teaser_design != 'masonry') {                           

                            if (!isset($query_string) || $query_string == NULL)
                                $query_string = '';
                            
                            if (isset($author) && $author != ''){
                                $query_string .= $query_string . '&author=' . $author;
                            }

                            if (isset($order) && $order != '')
                                $query_string .= $query_string . '&order=' . $order;

                            if (isset($cat) && $cat != '')
                                $query_string .= $query_string . '&cat=' . $cat;

                            if (isset($monthnum) && isset($year) && ($monthnum != '' && $year != ''))
                                $query_string .= $query_string . '&monthnum=' . $monthnum . '&year=' . $year;

                            if (isset($tag) && $tag != '')
                                $query_string .= $query_string . '&tag=' . $tag;
                        
                            if (isset($paged) && $paged != '') {
                                $query_string .= $query_string . '&paged=' . $paged;
                            }
                            
                            if (isset($query_string) && $query_string != '')
                                query_posts($query_string);
                        }

                        //END OF filtering options.
			

			while ( have_posts() ) { // Start the Loop

				the_post(); // Standard thing.
				
				//check if author filter ON
//				if(isset($current_author) && get_the_author() != $current_author)
//					continue;


				// Get current post format
				// we use it to style teasers appropriately
				$post_format = get_post_format();
				if ( false === $post_format ) {
					$post_format = 'standard';
				}

				get_template_part( 'template-parts/teaser-design'. $teaser_design, $post_format ); // Include the Post-Format-specific template for the content.
			}
			wp_reset_query();  // Restore global post data


		if ( $teaser_design == 'masonry' ) {
			echo "</div>"; // class='masonry-teasers-container'
		}

		// Layout divider between content column and sidebar
		echo $blog_layout_close;

		// Blog Sidebar
		// (output only for "Left" & "Right" sidebar position options)
		if ( $blog_sidebar_position != 'full' ) {
			//removing sidebar from Masonry design
			if($teaser_design != 'masonry'){
				get_sidebar();
			}
		}

		echo '</div><!--  .column -->';
	echo '</div><!--  .row -->';

	lbmn_content_nav( 'nav-below' );


} else { // !have_posts()
	echo "<div class='row'><div class='large-12 columns'>";
		get_template_part( 'no-results', 'index' );
	echo '</div><!--  .column --></div><!--  .row -->';
} //  have_posts()