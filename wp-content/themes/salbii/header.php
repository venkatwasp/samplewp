<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * (c) Twin Dots Limited
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 *
 * Code based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Some code is based on open-source tools or open-published code snippets
 *
 * Distributed via ThemeForest under GPLv2 (or later)
 */
GLOBAL $theme_settings;
?><!doctype html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
 <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
<?php 
	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
		header('X-UA-Compatible: IE=edge,chrome=1');
	}
?>
<meta name="viewport" content="width=device-width" />
<meta name="theme" content="Salbii 2.5" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lte IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/javascripts/html5.js" type="text/javascript"></script>
<style  type="text/css">
.right-off-canvas-menu, .off-canvas-area {
display:none!important;
}
</style>
<![endif]-->
<?php wp_head(); ?>
<?php
	// output custom CSS defined in theme options
	$custom_css = $theme_settings[ 'lbmn_css'];
	if ( strlen($custom_css) > 5 ) {
		echo "<style type='text/css'>";
		echo $custom_css;
		echo "</style>";
	}
?>
</head>

<body <?php body_class(); ?> data-default-class="<?php echo $theme_settings['default_body_class']; ?>">
<div class="off-canvas-wrap">
<div class="site global-container inner-wrap" id="global-container">
		<aside class="right-off-canvas-menu off-canvas-area">
			<?php if ( is_active_sidebar( 'mobile-offcanvas' ) ): /* Mobile off-canvas */ ?>
				<div class="close-offcanvas">
				<a class="right-off-canvas-toggle" href="#"><i aria-hidden="true" class="icon-cross"></i> <span>close</span></a>
				</div>
				<?php dynamic_sidebar( 'mobile-offcanvas' ); ?>
			<?php endif; ?>
		</aside>
	<section class="main-section">
	<div class="global-wrapper">
	<?php do_action( 'before' ); ?>
	<div class="header-wrapper">
	<?php
		get_template_part( 'template-parts/header', 'toppanel'); // get top bar

		// Prepare aditional parameters in case in theme options selected that the header is floating on scroll
		$header_float_desktop = @$theme_settings[ 'lbmn_header_option'] == 'floating' ? 1 : 0;
                $header_float_mobile = @$theme_settings[ 'lbmn_header_floating_mobile'];                
                $header_sticky = (!empty($theme_settings['lbmn_header_option']) && $theme_settings['lbmn_header_option'] == 'sticky') ? 1 : 0;
//		$header_params = '';
//		if ( $header_float ) {
//			echo '<div class="site-header__spacer js-site-header__spacer hide-for-small"></div>';
//			$header_params = 'data-headroom data-tolerance="8" data-offset="400" data-classes=\'{"pinned":"slideInDown","unpinned":"slideOutUp"}\'';
//			// $header_params = 'data-headroom data-tolerance="8" data-offset="140" data-classes=\'{"initial":"animated","pinned":"slideInDown","unpinned":"slideOutUp"}\'';
//		}
	?>
		<header class="site-header <?php echo $header_float_desktop == 1 ? 'fixedDesktop' : ''; ?> <?php echo $header_float_mobile == 1 ? 'fixedMobile' : ''; ?> <?php echo $header_sticky == 1 ? 'headerSticky' : ''; ?> " role="banner">
			<?php get_template_part( 'template-parts/header', 'main' ); // get top bar ?>
		</header><!-- #masthead -->
	</div><!-- .header-wrapper -->
	<div class="site-main">