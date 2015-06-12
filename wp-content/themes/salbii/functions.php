<?php
/**
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */
     
// if enabled each template file will output html comment with it's name
define('lbmn_DEBUG_INFO', true);

define('lbmn_THEME_NAME', 'salbii');
define('lbmn_THEME_NAME_DISPLAY', 'Salbii');

// Default Colors
define('BRAND_COLOR_DEFAULT', '#3498DB');
define('BRAND_COLOR_CONTRAST_DEFAULT', '#fff');

define('lbmn_LAYOUTOPTION_BOXED_OUTER_BG_COLOR', 'none');
define('lbmn_PAGE_BG_COLOR', '#fff');

define('lbmn_TOPPANEL_BACKGROUNDCOLOR_DEFAULT', '#282828');
define('lbmn_TOPPANEL_LINKCOLOR_DEFAULT', '#a0a6b3');
define('lbmn_TOPPANEL_LINKHOVERCOLOR_DEFAULT', '#ffffff');
define('lbmn_TOPPANEL_TEXTCOLOR_DEFAULT', '#a0a6b3');

define('lbmn_HEADERTOP_BACKGROUNDCOLOR_DEFAULT', '#fff');
define('lbmn_HEADERTOP_LINKCOLOR_DEFAULT', '#888888');
define('lbmn_HEADERTOP_LINKHOVERCOLOR_DEFAULT', '#0a0a0a');
define('lbmn_HEADERTOP_TEXTCOLOR_DEFAULT', '#888888');

define('lbmn_FOOTER_BACKGROUNDCOLOR_DEFAULT', '#33363C');
define('lbmn_FOOTER_TEXTCOLOR_DEFAULT', '#B3B3B3');
define('lbmn_FOOTER_LINKCOLOR_DEFAULT', '#fefefe');
define('lbmn_FOOTER_LINKHOVERCOLOR_DEFAULT', '#5AA3BF');

define('lbmn_FOOTER_MENU_LINKCOLOR_DEFAULT', '#B3B3B3');
define('lbmn_FOOTER_MENU_LINKHOVERCOLOR_DEFAULT', '#ffffff');

define('lbmn_MENU_BACKGROUNDCOLOR_DEFAULT', '#fcfcfc');
define('lbmn_MENU_DIVIDERCOLOR_DEFAULT', '#F6F6F6');

// This is to hide the auto update tab of the Ultimate Addons for Visual Composer plugin
define("ULTIMATE_USE_BUILTIN",true);

//Add upgraded var_dump/print_r for debugging
if( ! function_exists('pa') ) :
function pa($mixed, $stop = false) {
	$my_ip = array(
		'10.1.1.57',
		'95.142.158.250',
		'82.117.254.111',
	);
	$real_ip = $_SERVER['REMOTE_ADDR'];
	echo $real_ip;
	if( in_array($real_ip, $my_ip) ){
		$ar = debug_backtrace();
		$key = pathinfo($ar[0]['file']);
		$key = $key['basename'].':'.$ar[0]['line'];
		$print = array($key => $mixed);
		echo( '<pre>'.(print_r($print,1)).'</pre>' );
		if($stop == 1) exit();
	}
}
endif;
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
if ( ! function_exists( 'lbmn_setup' ) ) :
function lbmn_setup() {
	if(is_plugin_active('js_composer/js_composer.php')){
		require( get_template_directory() . '/inc/plugins-integration/visualcomposer/visualcomposer.php');	// Visuall Composer integration
	}

	require( get_template_directory() . '/inc/template-tags.php' ); 						// Custom template tags for this theme.
	require( get_template_directory() . '/inc/extras.php' ); 										//  Custom functions that act independently of the theme templates

	load_theme_textdomain( 'lbmn', get_template_directory() . '/languages' );						// Make theme available for translation
	add_theme_support( 'automatic-feed-links' ); 																							//Add default posts and comments RSS feed links to head
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );	// Enable support for Post Formats
	add_theme_support( 'post-thumbnails' ); // Enable support for Post Thumbnails on posts and pages @link http://goo.gl/hTka3

	// This theme uses wp_nav_menu()
	register_nav_menus( array(
		'primary-menu'    => __( 'Header Primary Menu', 'lbmn' ),
		'secondary-links' => __( 'Header Secondary Links', 'lbmn' ),
		'footer-menu'   	=> __( 'Footer Menu', 'lbmn' ),
	) );
}
endif; // lbmn_setup

// Bind theme setup callback
add_action( 'after_setup_theme', 'lbmn_setup' );

require_once(get_template_directory() . '/inc/bfi_thumb.php');
require_once( get_template_directory() . '/inc/plugins-integration/class-tgm-plugin-activation.php' );
require( get_template_directory() . '/inc/plugins-integration/metaboxes.php' ); // Metaboxes plugin integration
require_once( get_template_directory() . '/inc/admin/options.php'); 					// Theme option panel @link http://www.reduxframework.com/
$theme_settings = get_option('lbmn_theme_settings');

require_once( get_template_directory() . '/inc/customized-css.php');		// Generated css
require( get_template_directory() . '/inc/class-menu.php' ); 						// Class that create custom menus programmatically
require( get_template_directory() . '/inc/functions-ini.php' ); 				// Functions called on theme initialization
require( get_template_directory() . '/inc/functions-navigation.php' ); 	// Functions that extends navigation WP functioanlity
require( get_template_directory() . '/inc/functions-header.php' ); 			// Functions used to make customizible headers

require( get_template_directory() . '/inc/plugins-integration/jetpack.php' ); 			// Load Jetpack compatibility file.
require_once( get_template_directory() . '/inc/functions-commentform.php');        // Custom layout of the comment form
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require( get_template_directory() . '/inc/plugins-integration/wpml.php' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */

// Register plugins that our theme depends on
add_action( 'tgmpa_register', 'lbmn_register_required_plugins' );

function lbmn_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Required plugins for proper theme work ========================================

		// Include 'WPBakery Visual Composer' plugin pre-packaged with a theme
		array(
			'name'     				=> 'WPBakery Visual Composer', // The plugin name
			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/inc/plugins-integration/plugin-installables/js_composer-4.5.2.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '4.5.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),

		// Include 'LBMN Projects' plugin pre-packaged with a theme
		array(
			'name'     				=> 'LBMN Projects',
			'slug'     				=> 'lbmn-projects',
			'source'   				=> get_template_directory() . '/inc/plugins-integration/plugin-installables/lbmn-projects.0.2.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		// Include 'Tfingi Megamenu Plugin' plugin pre-packaged with a theme
		array(
			'name'     				=> 'Tfingi Megamenu Plugin',
			'slug'     				=> 'tfingi-megamenu',
			'source'   				=> get_template_directory() . '/inc/plugins-integration/plugin-installables/tfingi-megamenu.1.4.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		// Include 'Meta Box' plugin pre-packaged with a theme
		array(
			'name'     				=> 'Meta Box',
			'slug'     				=> 'meta-box',
			// 'source'   				=> get_template_directory() . '/inc/plugins-integration/plugin-installables/meta-box.4.3.6.zip',
			'required' 				=> true,
			'version' 				=> '4.3.8',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		// Optional plugins that absence will not make big troubles ========================================


		// Include 'Easy Social Share Buttons for WordPress' plugin pre-packaged with a theme
		array(
			'name'     				=> 'Easy Social Share Buttons for WordPress',
			'slug'     				=> 'easy-social-share-buttons',
			'source'   				=> get_template_directory_uri()  . '/inc/plugins-integration/plugin-installables/easy-social-share-buttons-2.0.6.1.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		// Include 'LayerSlider WP' plugin pre-packaged with a theme
		array(
			'name'     				=> 'LayerSlider WP',
			'slug'     				=> 'LayerSlider',
			'source'   				=> get_template_directory() . '/inc/plugins-integration/plugin-installables/layerslider-5.4.0.zip',
			'required' 				=> false,
			'version' 				=> '',
			'force_activation' 		=> true,
			'force_deactivation' 	=> true,
			'external_url' 			=> '',
		),

		// Include 'Ultimate VC Addons' plugin pre-packaged with a theme
		array(
			'name'     				=> 'Ultimate VC Addons',
			'slug'     				=> 'Ultimate_VC_Addons',
			'source'   				=> get_template_directory() . '/inc/plugins-integration/plugin-installables/Ultimate_VC_Addons-3.11.0.zip',
			'required' 				=> false,
			'version' 				=> '3.11.0',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		// Include 'WooSidebars' plugin pre-packaged with a theme
		array(
			'name'     				=> 'WooSidebars',
			'slug'     				=> 'woosidebars',
			'required' 				=> false,
			'version' 				=> '1.3.1',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),
		
		// Include 'Widget Importer & Exporter' plugin pre-packaged with a theme
		array(
			'name'     				=> 'Widget Importer & Exporter',
			'slug'     				=> 'widget-importer-exporter',
			'required' 				=> false,
			'version' 				=> '1.1.4',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		
		
		// Include 'WordPress Importer' plugin pre-packaged with a theme
		array(
			'name'     				=> 'WordPress Importer',
			'slug'     				=> 'wordpress-importer',
			'required' 				=> false,
			'version' 				=> '0.6.1',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		// Include 'Contact Form 7' plugin pre-packaged with a theme
		array(
			'name'     				=> 'Contact Form 7',
			'slug'     				=> 'contact-form-7',
			'required' 				=> false,
			'version' 				=> '4.0.2',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),
            
        // Include 'Slider Revolution' plugin pre-packaged with a theme
		array(
			'name'     				=> 'Slider Revolution',
			'slug'     				=> 'revslider',
			'source'   				=> get_template_directory() . '/inc/plugins-integration/plugin-installables/revslider-4.6.93.zip',
			'required' 				=> false,
			'version' 				=> '',
			'force_activation'                      => false,
			'force_deactivation'                    => false,
			'external_url'                          => '',
		),
	);

	/**
	 * Array of configuration settings.
	 */
	$config = array(
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'dismissable'  		=> true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  		=> '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
		// 	'page_title'                       			=> __( 'Install Required Plugins', 'lbmn' ),
		// 	'menu_title'                       			=> __( 'Install Plugins', 'lbmn' ),
		// 	'installing'                       			=> __( 'Installing Plugin: %s', 'lbmn' ), // %1$s = plugin name
		// 	'oops'                             			=> __( 'Something went wrong with the plugin API.', 'lbmn' ),
		// 	'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
		// 	'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
		// 	'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
		// 	'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
		// 	'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
		// 	'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
		'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s. First deactivate and delete the plugin. You will then be prompted to install the new version.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s. First deactivate and delete the plugins. You will then be prompted to install the new versions.' ), // %1$s = plugin name(s)
		// 	'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
		// 	'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
		// 	'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
		// 	'return'                           			=> __( 'Return to Required Plugins Installer', 'lbmn' ),
		// 	'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'lbmn' ),
		// 	'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'lbmn' ), // %1$s = dashboard link
		// 	'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
if(function_exists('vc_set_as_theme')) vc_set_as_theme();

// Disable Visual Composer frontend editor
if(function_exists('vc_disable_frontend')) vc_disable_frontend();


// Disable LayerSlider autoupdates box
add_action('layerslider_ready', 'lbmn_layerslider_overrides');
function lbmn_layerslider_overrides() {
	// Disable auto-updates
	$GLOBALS['lsAutoUpdateBox'] = false;
}


// Hide by default some anoying shipped plugins meta-boxes
add_filter('hidden_meta_boxes', 'lbmn_hidden_meta_boxes', 10, 2);
function lbmn_hidden_meta_boxes($hidden, $screen) {
    // $post_type= $screen->id;
    // switch ($post_type) {
        // case 'post', 'page', 'link', 'attachment', and any custom post types
        $hidden[] = 'essb_advanced'; //hide by default: Easy Social Share Buttons Custom Share and Like Addresses
        $hidden[] = 'essb_metabox'; // hide by default: Easy Social Share Buttons
    // }
    return $hidden;
}


// Configure Visual Composer once it installed
add_action( 'init', 'lbmn_integrate_js_composer' );
function lbmn_integrate_js_composer(){
	// First check if this function has not been activated before
	if (get_option('salbii_vc_configured') != 'true') {
		require( get_template_directory() . '/inc/plugins-integration/visualcomposer/visualcomposer-config.php');	// Visuall Composer configuration
		update_option('salbii_vc_configured', 'true' );
	}
}

// Used for debugin during theme development
function lbmn_debug($var) {
	echo '<pre>';
		print_r($var);
	echo '</pre>';
}


// Remove update notifications for bundled plugins
add_filter('site_transient_update_plugins', 'remove_bundled_update_notification');
function remove_bundled_update_notification($value) {
	if ( isset( $value ) && is_object( $value ) ) {
		unset($value->response['js_composer/js_composer.php']);
		unset($value->response['LayerSlider/layerslider.php']);
		unset($value->response['Ultimate_VC_Addons/Ultimate_VC_Addons.php']);
		unset($value->response['easy-social-share-buttons/easy-social-share-buttons.php']);
		unset($value->response['revslider/revslider.php']);
		return $value;
	}
}