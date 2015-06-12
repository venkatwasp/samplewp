<?php
/**
 * functions called on theme initialization
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 *
 * Code based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Some code is based on open-source tools or open-published code snippets
 *
 * Distributed via ThemeForest under GPLv2 (or later)
 */


/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! isset( $content_width ) ) {
	$content_width = 1120; /* pixels;*/
	// TODO: strange bug here: with width = 1130 videos doesn't work at all
}

// Change image compression
add_filter('jpeg_quality', 'change_image_quality');
function change_image_quality($arg){
	return 95;
}

/**
 * ----------------------------------------------------------------------
 * Enqueue scripts and styles
 */

function lbmn_scripts() {

	if (!is_admin()) {
		/**
		 * @link http://foundation.zurb.com/docs/javascript.html
		 * @link https://github.com/milohuang/reverie
		 */
		wp_register_script( 'lbmn-modernizr', get_template_directory_uri() . '/javascripts/custom.modernizr.js', false, '2.6.2', false ); // 1
		wp_register_script( 'lbmn-foundation-js', get_template_directory_uri() . '/javascripts/foundation/foundation.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'lbmn-parallax-js', 	get_template_directory_uri() . '/javascripts/jquery.parallax-1.1.3.js', array( 'jquery' ), '20140306', true );
		// wp_register_script( 'lbmn-textareasize-js', 	get_template_directory_uri() . '/javascripts/jquery.textarea-autosize-min.js', array( 'jquery' ), '', true );
		wp_register_script( 'lbmn-custom-js', 	get_template_directory_uri() . '/javascripts/scripts.js', 		array( 'jquery' ), '20140306', true );
		wp_register_script( 'lbmn-clients-js', 	get_template_directory_uri() . '/javascripts/custom-scripts.js', 		array( 'jquery' ), '', true );
		wp_enqueue_script( 'lbmn-skip-link-focus-fix', get_template_directory_uri() . '/javascripts/skip-link-focus-fix.js', array(), '20130115', true );
		// fixable navbar
		wp_register_script( 'lbmn-headroom-js', 	get_template_directory_uri() . '/javascripts/headroom.min.js', array( 'jquery' ), '20131223', true );
		wp_register_script( 'lbmn-headroom-jquery-js', 	get_template_directory_uri() . '/javascripts/jquery.headroom.min.js', array( 'jquery', 'lbmn-headroom-js' ), '20131223', true );

		wp_enqueue_script( 'lbmn-modernizr' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'lbmn-foundation-js' );
		wp_enqueue_script( 'lbmn-parallax-js' );
		// wp_enqueue_script( 'lbmn-textareasize-js' );
		wp_enqueue_script( 'lbmn-custom-js' );
		wp_enqueue_script( 'lbmn-headroom-js' );
		wp_enqueue_script( 'lbmn-headroom-jquery-js' );
		wp_enqueue_script( 'lbmn-clients-js' );

		wp_enqueue_style( 'lbmn-foundation-style', get_template_directory_uri() . '/framework.css');
		wp_enqueue_style( 'lbmn-iconfont', get_template_directory_uri() . '/iconfont/style.css');
		wp_enqueue_style( 'lbmn-style', get_stylesheet_uri() );
		wp_enqueue_style( 'lbmn-custom-styles', get_template_directory_uri() . '/custom-styles.css');

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( is_singular() && wp_attachment_is_image() ) {
			wp_enqueue_script( 'lbmn-keyboard-image-navigation', get_template_directory_uri() . '/javascripts/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'lbmn_scripts' );


/**
* ----------------------------------------------------------------------
* Scripts to load in WP admin area
*/

function lbmn_adminscripts() {
	if (is_admin()) {
		wp_enqueue_style( 'lbmn-adminstyles', get_template_directory_uri() . '/adminstyle.css');
		wp_enqueue_style( 'lbmn-iconfont', get_template_directory_uri() . '/iconfont/style.css'); // Icon font used in VC form

		wp_enqueue_script(
			'admin-js',
			get_template_directory_uri().'/inc/plugins-integration/visualcomposer/vc_admin.js',
			array('jquery'),
			'3.83',
			true
		);

		wp_enqueue_script(
			'redux-js',
			get_template_directory_uri().'/inc/admin/redux-admin.js',
			array('jquery'),
			'3.83',
			true
		);


		wp_enqueue_script(
			'vc-fix-js',
			get_template_directory_uri().'/inc/plugins-integration/visualcomposer/vc_views.js',
			array('wpb_js_composer_js_custom_views'),
			false,
			true
		);
	}
}
add_action( 'admin_enqueue_scripts', 'lbmn_adminscripts' );



/**
 * ----------------------------------------------------------------------
 * Register widgetized area and update sidebar with default widgets
 */

function lbmn_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Mobile Off-canvas', 'lbmn' ),
		'id'            => 'mobile-offcanvas',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar', 'lbmn' ),
		'id'            => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Prefooter - Column 1', 'lbmn' ),
		'id'            => 'prefooter-col1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Prefooter - Column 2', 'lbmn' ),
		'id'            => 'prefooter-col2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Prefooter - Column 3', 'lbmn' ),
		'id'            => 'prefooter-col3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Prefooter - Column 4', 'lbmn' ),
		'id'            => 'prefooter-col4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer - Column 1', 'lbmn' ),
		'id'            => 'footer-col1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer - Column 2', 'lbmn' ),
		'id'            => 'footer-col2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer - Column 3', 'lbmn' ),
		'id'            => 'footer-col3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer - Column 4', 'lbmn' ),
		'id'            => 'footer-col4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
}
add_action( 'widgets_init', 'lbmn_widgets_init' );



/**
* ----------------------------------------------------------------------
* Create custom pages on theme activation
* Front page, Blog home page, Portfolio Page
*
* http://themeforest.net/forums/thread/create-a-new-page-upon-theme-activation/33238
*/

function lbmn_create_page( $title = '', $content = '', $post_type = 'page', $post_meta = array() ) {
	$new_page_title = $title;
	$new_page_content = $content;
	$new_page_template = ''; //ex. template-custom.php. Leave blank if you don't want a custom page template.

	$page_check = get_page_by_title($new_page_title);
	$user_ID = get_current_user_id();
	$new_page = array(
			'post_type' => $post_type, // 'page'
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			'post_author' => $user_ID, // 1
	);
	if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			if(!empty($new_page_template)){
					update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
			}

			if(!empty($post_meta)){
				foreach ($post_meta as $key => $value) {
					update_post_meta($new_page_id, $key, $value);
				}
			}
	}
}



/**
* ----------------------------------------------------------------------
* Create custom menus on theme activation
* using class LMBNCreateMenu defined in /inc/class-menu.php
*
* http://codex.wordpress.org/Function_Reference/wp_create_nav_menu
* https://gist.github.com/OzzyCzech/4148529
*/

// add_action( 'init', 'lbmn_register_defaultmenus' ); // decided to use another approach
function lbmn_register_defaultmenus() {

	// Create menu: Primary Menu
	$primary = new LMBNCreateMenu('Primary Website Menu (auto-generated)');

		// page link: Main Page
		$home = get_option( 'page_on_front' ); // return FALSE if not set
		if ($home) {
			$primary->title('Home');
			$primary->object_id($home);
			$primary->object('page');
			$primary->type('post_type');
			$primary->save();
		}

		// page link: Portfolio
		if ($page = get_page_by_title('Portfolio (auto-generated)')) {
			$primary->title('Portfolio');
			$primary->object_id($page->ID);
			$primary->object('page');
			$primary->type('post_type');
			$primary->save();
		}

		// page link: Blog index
		$blog = get_option( 'page_for_posts' ); // return FALSE if not set
		if ($blog) {
			$primary->title('Blog');
			$primary->object_id($blog);
			$primary->object('page');
			$primary->type('post_type');
			$primary->save();
		}

	// ------------------------------------------------------------------------

	// Create menu: Social Icons List
	$social = new LMBNCreateMenu('Social Icons List');

		// custom links
		$social->title('Facebook')->url('https://www.facebook.com/themeforest')->classes('icon-facebook')->target('_blank')->save();
		$social->title('LinkedIn')->url('https://linkedin.com')->classes('icon-linkedin')->target('_blank')->save();
		$social->title('Google +')->url('https://plus.google.com/108763868013266824234/')->classes('icon-googleplus')->target('_blank')->save();
		$social->title('Instagram')->url('http://instagr.am')->classes('icon-instagram')->target('_blank')->save();
		$social->title('Vimeo')->url('https://vimeo.com')->classes('icon-vimeo')->target('_blank')->save();
		$social->title('YouTube')->url('https://youtube.com')->classes('icon-youtube')->target('_blank')->save();
		$social->title('Pinterest')->url('https://pinterest.com')->classes('icon-pinterest')->target('_blank')->save();
		$social->title('Dribbble')->url('https://dribbble.com')->classes('icon-dribbble')->target('_blank')->save();

	// ------------------------------------------------------------------------

	// 'Header Primary Menu' location
	if( !has_nav_menu( 'primary-menu' ) ){ // check if loaction has no menu assigned
		$primary->setLocation('primary-menu'); // Attach newcreated 'Primary Menu' to 'primary-menu' location
	}

	// 'Header Secondary Links' locaiton
	if( !has_nav_menu( 'secondary-links' ) ){
		$social->setLocation('secondary-links'); // Attach newcreated 'Social Icons List' to 'secondary-links' location
	}

	// 'Footer Menu' location
	if( !has_nav_menu( 'footer-menu' ) ){
		$primary->setLocation('footer-menu'); // Attach newcreated 'Primary Menu' to 'footer-menu' location
	}
}



/**
* ----------------------------------------------------------------------
* Perform custom fucntions on theme activation
* http://wordpress.stackexchange.com/a/80320/34582
*/

if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {

	// First check if these function has not been activated before
	// (on multiply theme switch by nervious customers ;-)
	if (get_option('salbii_basic_setup') != 'done') {

		// create some basic predefined pages

		// Create a default front page if it's no page defined in WP > Settings > Reading > Front page
		$home = get_option( 'page_on_front' ); // return FALSE if not set
		if ( !$home ) {
			lbmn_create_page(
				$title = 'Main page (auto-generated)',
				$content = '<h2 style="text-align:center;">Thank you for buying '.lbmn_THEME_NAME_DISPLAY.'!</h2>',
				$post_type = 'page',
				$post_meta = array(
					'lbmn_page_title_settings' => 'hidden',
				)
			);
		}

		// Create a default posts index page if no page already defined in WP > Settings > Reading > Posts page
		$blog = get_option( 'page_for_posts' ); // return FALSE if not set
		if ( !$blog ) {
			lbmn_create_page(
				$title = 'Blog index (auto-generated)',
				$content = '<h2 style="text-align:center;">This is your home for blog posts.</h2>'
			);
		}

		lbmn_create_page(
			$title = 'Portfolio (auto-generated)',
			$content = '<h2 style="text-align:center;">This is your portfolio.</h2>'
		);

		// Set static front page and blog page if it's not already set
		// http://kuttler.eu/code/set-static-front-page-and-blog-page-programmatically-in-wordpress/
		// Use a static front page
		if ( !$home ) {
			$home = get_page_by_title( 'Main page (auto-generated)' );
			update_option( 'page_on_front', $home->ID );
			update_option( 'show_on_front', 'page' );
		}

		if ( !$blog ) {
			// Set the blog page
			$blog   = get_page_by_title( 'Blog index (auto-generated)' );
			update_option( 'page_for_posts', $blog->ID );
		}

		// create some basic predefined menus
		lbmn_register_defaultmenus();

		//now after these functions has been run, set option so it wont run again
		update_option( 'salbii_basic_setup', 'done' );
	}
}



/**
* ----------------------------------------------------------------------
* Visual Editor Stylesheet
*/

add_action( 'init', 'lbmn_add_editor_styles' );
if ( ! function_exists( 'lbmn_add_editor_styles' ) ):
	function lbmn_add_editor_styles() {
			add_editor_style( 'editor-style.css' );
	}
endif; //function_exists


/*
 * Modifying TinyMCE editor to remove unused items.
 * http://wordpress.org/support/topic/tinymce-formatting-options-remove-h1-h1-pre
 * http://www.tinymce.com/wiki.php/Configuration
 *
 *bold,italic,strikethrough,bullist,numlist,blockquote,justifyleft,justifycenter,
 *justifyright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv,|,scn_button
 *
 *
 * bold, italic, underline, strikethrough,
 * justifyleft, justifycenter, justifyright, justifyfull,
 * bullist, numlist, outdent, indent, cut, copy
 * paste, undo, redo, link, unlink, image, cleanup,
 * help, code, hr,
 * removeformat, formatselect, fontselect, fontsizeselect
 *  styleselect, sub, sup, forecolor, backcolor, forecolorpicker, backcolorpicker,
 *  charmap, visualaid, anchor, newdocument, blockquote,
 *  separator ( | is possible as separator, too)
 */


if ( ! function_exists( 'lbmn_customformatTinyMCE' ) ):
	function lbmn_customformatTinyMCE($init) {

		// add <hr> and removeformat button to the first line
		if( isset($init['theme_advanced_buttons1']) ) $init['theme_advanced_buttons1'] = preg_replace('/scn_button/', 'hr,removeformat,scn_button,', $init['theme_advanced_buttons1']);
		if( isset($init['theme_advanced_buttons2']) ) $init['theme_advanced_buttons2'] = preg_replace('/(formatselect,)|(underline,)|(justifyfull,)/', '', $init['theme_advanced_buttons2']);

		return $init;
	}
endif; //function_exists
add_filter('tiny_mce_before_init', 'lbmn_customformatTinyMCE' );





// Create "Styles" drop-down
add_filter( 'mce_buttons_2', 'lbmn_mce_editor_buttons' );
if ( ! function_exists( 'lbmn_mce_editor_buttons' ) ):
	function lbmn_mce_editor_buttons( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		
		$value = array_search( 'formatselect', $buttons );
		if ( FALSE !== $value ) {
		    foreach ( $buttons as $key => $value ) {
		        if ( 'formatselect' === $value )
		            unset( $buttons[$key] );
		    }
		}
		
		return $buttons;
	}
endif; //function_exists


// Add styles/classes to the "Styles" drop-down
add_filter( 'tiny_mce_before_init', 'lbmn_mce_before_init' );
if ( ! function_exists( 'lbmn_mce_before_init' ) ):
	function lbmn_mce_before_init( $settings ) {

	$style_formats = array(
		// Headings
		array(
			'title' => 'Headings',
			'items' => array(
				array(
					'title' => 'Heading 1',
					'block' => 'h1',
				),
				array(
					'title' => 'Heading 2',
					'block' => 'h2',
				),
				array(
					'title' => 'Heading 3',
					'block' => 'h3',
				),
				array(
					'title' => 'Heading 4',
					'block' => 'h4',
				),
				array(
					'title' => 'Heading 5',
					'block' => 'h5',
				),
				array(
					'title' => 'Heading 6',
					'block' => 'h6',
				)
			)
		),
		// Blocks
		array(
			'title' => 'Blocks',
			'items' => array(
				array(
					'title' => 'Paragraph',
					'block' => 'p',
				),
				array(
					'title' => 'Address',
					'block' => 'address',
				),
				array(
					'title' => 'Pre',
					'block' => 'pre',
				)
			)
		),
		// Inline
		array(
			'title' => 'Inline',
			'items' => array(
				array(
					'title' => 'Larger text size',
					'inline' => 'span',
					'classes' => 'larger',
				),
				array(
					'title' => 'Smaller text size',
					'inline' => 'span',
					'classes' => 'smaller',
				),
				array(
					'title' => 'Font weight: lighter',
					'inline' => 'span',
					'classes' => 'lighter',
				),
				array(
					'title' => 'Font weight: bolder',
					'inline' => 'span',
					'classes' => 'bolder',
				),
				array(
					'title' => 'Font weight: thin',
					'inline' => 'span',
					'classes' => 'thin',
				),
				array(
					'title' => 'Font weight: light',
					'inline' => 'span',
					'classes' => 'light',
				),
				array(
					'title' => 'Font weight: normal',
					'inline' => 'span',
					'classes' => 'normal',
				),
				array(
					'title' => 'Font weight: bold',
					'inline' => 'span',
					'classes' => 'bold',
				),
				array(
					'title' => 'With colored line',
					'inline' => 'span',
					'classes' => 'wpb_heading',
				),
				array(
					'title' => 'Uppercase',
					'inline' => 'span',
					'classes' => 'uppercase',
				),
				array(
					'title' => 'Margin top: 0',
					'inline' => 'span',
					'classes' => 'mt_0',
				),
				array(
					'title' => 'Margin bottom: 0',
					'inline' => 'span',
					'classes' => 'mb_0',
				),
				array(
					'title' => 'Font-size: h1+',
					'inline' => 'span',
					'classes' => 'h0',
				),
				array(
					'title' => 'Font-size: h1',
					'inline' => 'span',
					'classes' => 'h1',
				),
				array(
					'title' => 'Font-size: h2',
					'inline' => 'span',
					'classes' => 'h2',
				),
				array(
					'title' => 'Font-size: h3',
					'inline' => 'span',
					'classes' => 'h3',
				),
				array(
					'title' => 'Font-size: h4',
					'inline' => 'span',
					'classes' => 'h4',
				),
			)
		)
	);

	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;
}

endif; //function_exists
