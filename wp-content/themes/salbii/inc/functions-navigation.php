<?php
/**
 * functions that extends navigation WP functioanlity
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */

/**
 * ----------------------------------------------------------------------
 * Change standard 'menu_class' argument for menus (from 'menu' to 'menu side-nav')
 * Widget menus with '.side-nav' looks nice in Zurb Framework.
 * To use other than '.side-nav' class use wp_nav_menu with cutom srguments.
 */

if ( ! function_exists('lbmn_wp_nav_menu_args') ) {
	function lbmn_wp_nav_menu_args( $args = '' ) {
		$args['menu_class'] = 'side-nav menu';
		return $args;
	}
	add_filter( 'wp_nav_menu_args', 'lbmn_wp_nav_menu_args' );
}


/**
 * ----------------------------------------------------------------------
 * Add Foundation 'active' class for the current menu item
 * From reverie framework
 */

if ( ! function_exists('lbmn_active_nav_class') ) {
	function lbmn_active_nav_class( $classes, $item ) {
		if ( $item->current == 1 || $item->current_item_ancestor == true ) {
			$classes[] = 'active';
		}
		return $classes;
	}
	add_filter( 'nav_menu_css_class', 'lbmn_active_nav_class', 10, 2 );
}


/**
 * ----------------------------------------------------------------------
 * class required_walker
 * Custom output to enable the the ZURB Navigation style.
 * Courtesy of Kriesi.at. http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
 * From required+ Foundation http://themes.required.ch
 */

class lbmn_walker extends Walker_Nav_Menu {

	/**
	 * Specify the item type to allow different walkers
	 * @var array
	 */
	var $nav_bar = '';

	function __construct( $nav_args = '' ) {

		$defaults = array(
			'item_type' => 'li',
		);
		$this->nav_bar = apply_filters( 'req_nav_args', wp_parse_args( $nav_args, $defaults ) );
	}

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		}

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// Check if array of classes has 'icon-*' etnry, if so apply this class to li>a element
		$iconclass = '';
		foreach ($item->classes as $class_key => $classes_item) {
			if (preg_match("/icon-/", $classes_item)) {
				$iconclass = $classes_item;
				unset($classes["$class_key"]);	// remove from <li> element - this was causing font render issue on Firefox
			}
		}

		$classes[] = 'menu-item-' . $item->ID;

		// Check for flyout
		$flyout_toggle = '';
		if ( $args->has_children && $this->nav_bar['item_type'] == 'li' ) {
			$classes[] = 'has-dropdown';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		if ( $depth > 0 ) {
			// $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
			$output .= $indent . '<li ' . $value . $class_names .'>'; // removed menu item id to solve "Duplicate ID menu-item-###" error
		} else {
			// $output .= $indent . '<' . $this->nav_bar['item_type'] . ' id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
			$output .= $indent . '<' . $this->nav_bar['item_type'] . ' ' . $value . $class_names .'>'; // removed menu item id to solve "Duplicate ID menu-item-###" error
		}

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		if ( $iconclass ) {
			$attributes .= ' class="menu-item-with-icon"';
		}

		$item_output  = $args->before;
		$item_output .= '<a '. $attributes .'>';

		// insert icon if $iconclass in not empty
		if ( $iconclass ) {
			$item_output .= "<span aria-hidden='true' class='menu-item__icon $iconclass'></span>&nbsp;<span class='menu-item__icon-label'>";
			// &nbps -- keed empty menu from collapsing don't remove it
		}

		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

		if ( $iconclass ) {
			$item_output .= "</span>"; // closing .menu-item__icon-label opened above
		}

		$item_output .= '</a>';

		$item_output .= $flyout_toggle; // Add possible flyout toggle
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ( $depth > 0 ) {
			$output .= "</li>\n";
		} else {
			$output .= "</" . $this->nav_bar['item_type'] . ">\n";
		}
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {

		if ( $depth == 0 && $this->nav_bar['item_type'] == 'li' ) {
			$indent = str_repeat("\t", 1);
				$output .= "\n$indent<ul class=\"dropdown sub-menu\">\n";
			} else {
			$indent = str_repeat("\t", $depth);
				$output .= "\n$indent<ul class=\"dropdown sub-menu\">\n";
		}
	}
}


/**
 * ----------------------------------------------------------------------
 * Naviagation Menu Fallback for cased when menu is not set.
 */

// function lbmn_menu_fallback() {
// }

/**
 * ----------------------------------------------------------------------
 * Add Breadcrumbs
 *
 * @link http://www.branded3.com/blogs/creating-a-really-simple-breadcrumb-function-for-pages-in-wordpress/
 * @author Max Shearer
 */

if ( ! function_exists( 'lbmn_breadcrumbs' ) ) {
	function lbmn_breadcrumbs( $class = '', $depth = 0) {

		if( !is_front_page() && !is_search() ) {

			global $post;

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$trail = "<nav class='breadcrumbs $class'>\n";
			// add home page
			$trail .= "$indent\t<a href='". esc_url( home_url( '/' ) ) ."' class='no-slash'>".__('Home','lbmn')."</a> \n";

			// $trail .= "$indent\t<a href='#' class='unavailable' >".__('You are here: ','lbmn')."</a> \n";

			$page_title =  single_post_title( '', false ); //get_the_title($post->ID);

			if($post->post_parent) {
				$parent_id = $post->post_parent;

				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = "$indent\t<a href='".get_permalink($page->ID)."'>".get_the_title($page->ID)."</a> \n";
					$parent_id = $page->post_parent;
				}

				$breadcrumbs = array_reverse($breadcrumbs);
				foreach($breadcrumbs as $crumb) $trail .= $crumb;
			}

			if ( is_page() || is_home() ) {
				// add current page title
				$trail .= "$indent\t<a href='#' class='current' >".$page_title."</a> \n";

			} elseif ( is_archive() ) {
				// add category name
				$latest_trail_item = '';

				if ( is_category() ) :
					$latest_trail_item  = sprintf( __( 'Category: %s', 'lbmn' ), '<span>' . single_cat_title( '', false ) . '</span>' );

				elseif ( is_tag() ) :
					$latest_trail_item  = sprintf( __( 'Tag: %s', 'lbmn' ), '<span>' . single_tag_title( '', false ) . '</span>' );

				elseif ( is_author() ) :
					/* Queue the first post, that way we know
					 * what author we're dealing with (if that is the case).
					*/
					the_post();
					$latest_trail_item  = sprintf( __( 'Author: %s', 'lbmn' ), '<span class="vcard">' . get_the_author() . '</span>' );
					/* Since we called the_post() above, we need to
					 * rewind the loop back to the beginning that way
					 * we can run the loop properly, in full.
					 */
					rewind_posts();

				elseif ( is_day() ) :
					$latest_trail_item  = sprintf( __( 'Day: %s', 'lbmn' ), '<span>' . get_the_date() . '</span>' );

				elseif ( is_month() ) :
					$latest_trail_item  = sprintf( __( 'Month: %s', 'lbmn' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

				elseif ( is_year() ) :
					$latest_trail_item  = sprintf( __( 'Year: %s', 'lbmn' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

				elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
					$latest_trail_item  = __( 'Asides', 'lbmn' );

				elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
					$latest_trail_item  = __( 'Images', 'lbmn');

				elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
					$latest_trail_item  = __( 'Videos', 'lbmn' );

				elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
					$latest_trail_item  = __( 'Quotes', 'lbmn' );

				elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
					$latest_trail_item  = __( 'Links', 'lbmn' );

				else :
					$latest_trail_item  = __( 'Archives', 'lbmn' );

				endif;

				// add prepared value to the breadcrumbs chain
				$trail .= "$indent\t<a href='#' class='current' >".$latest_trail_item."</a> \n";
			}

			$trail .= "$indent</nav>\n";

			// if ( is_404() ) {
			// 	$trail .= "is 404";
			// }

			echo $trail;
		}
	}
}