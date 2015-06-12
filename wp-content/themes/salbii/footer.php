<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
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
?>

</div><!-- #main -->
<?php get_template_part('/template-parts/footer', 'prefooter'); ?>
<?php get_template_part('/template-parts/footer', 'calltoaction') ?>
<?php
$footer_main_switch = true;
$footer_menu_switch = true;
$footer_copyrights_switch = true;

if (isset($theme_settings['lbmn_footer_menu_switch']) && ( $theme_settings['lbmn_footer_menu_switch'] == '0' )) {
    $footer_menu_switch = false;
}

if (isset($theme_settings['lbmn_footer_main_switch']) && ( $theme_settings['lbmn_footer_main_switch'] == '0' )) {
    $footer_main_switch = false;
}

if (isset($theme_settings['lbmn_footer_copyrights_switch']) && ( $theme_settings['lbmn_footer_copyrights_switch'] == '0' )) {
    $footer_copyrights_switch = false;
}

if ($footer_main_switch || $footer_menu_switch || $footer_copyrights_switch):
    ?>
    <footer class="site-footer" role="contentinfo">
        <?php
        $menu_locations = get_nav_menu_locations();
        if ($footer_menu_switch && isset($menu_locations['footer-menu'])):
            ?>
            <div class="site-footer__menu hide-for-small">
                <div class='contain-to-grid'>
                    <nav class='top-bar'>
                        <ul class='title-area'><li class='name'><!-- no standard title --></li></ul>
                        <section class='top-bar-section'>
                            <?php
                            echo lbmn_menu_output($menu_locations['footer-menu'], 'left');
                            ?>
                        </section>
                    </nav>
                </div>
            </div>
        <?php endif; //$footer_menu_switch  ?>
        <?php if ($footer_main_switch): ?>
            <?php
            $footer_layout = 'footer-columns-4';
            if (isset($theme_settings['lbmn_footer_layout'])) {
                $footer_layout = $theme_settings['lbmn_footer_layout'];
            }

            if ($footer_layout == 'footer-columns-1'):
                ?>
                <div class="site-footer__primary">
                    <div class="row">
                        <div class="large-12 columns">
                            <?php dynamic_sidebar('footer-col1'); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($footer_layout == 'footer-columns-2'): ?>
                <div class="site-footer__primary">
                    <div class="row">
                        <div class="large-6 columns">
                            <?php dynamic_sidebar('footer-col1'); ?>
                        </div>
                        <div class="large-6 columns">
                            <?php dynamic_sidebar('footer-col2'); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($footer_layout == 'footer-columns-2-alt1'): ?>
                <div class="site-footer__primary">
                    <div class="row">
                        <div class="large-8 columns">
                            <?php dynamic_sidebar('footer-col1'); ?>
                        </div>
                        <div class="large-4 columns">
                            <?php dynamic_sidebar('footer-col2'); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($footer_layout == 'footer-columns-2-alt2'): ?>
                <div class="site-footer__primary">
                    <div class="row">
                        <div class="large-4 columns">
                            <?php dynamic_sidebar('footer-col1'); ?>
                        </div>
                        <div class="large-8 columns">
                            <?php dynamic_sidebar('footer-col2'); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($footer_layout == 'footer-columns-3'): ?>
                <div class="site-footer__primary">
                    <div class="row">
                        <div class="large-4 columns">
                            <?php dynamic_sidebar('footer-col1'); ?>
                        </div>
                        <div class="large-4 columns">
                            <?php dynamic_sidebar('footer-col2'); ?>
                        </div>
                        <div class="large-4 columns">
                            <?php dynamic_sidebar('footer-col3'); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($footer_layout == 'footer-columns-3-alt1'): ?>
                <div class="site-footer__primary">
                    <div class="row">
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col1'); ?>
                        </div>
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col2'); ?>
                        </div>
                        <div class="large-6 columns">
                            <?php dynamic_sidebar('footer-col3'); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($footer_layout == 'footer-columns-3-alt2'): ?>
                <div class="site-footer__primary">
                    <div class="row">
                        <div class="large-6 columns">
                            <?php dynamic_sidebar('footer-col1'); ?>
                        </div>
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col2'); ?>
                        </div>
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col3'); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($footer_layout == 'footer-columns-3-alt3'): ?>
                <div class="site-footer__primary">
                    <div class="row">
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col1'); ?>
                        </div>
                        <div class="large-6 columns">
                            <?php dynamic_sidebar('footer-col2'); ?>
                        </div>
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col3'); ?>
                        </div>
                    </div>
                </div>
            <?php else: // default is 4 columns  ?>
                <div class="site-footer__primary">
                    <div class="row">
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col1'); ?>
                        </div>
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col2'); ?>
                        </div>
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col3'); ?>
                        </div>
                        <div class="large-3 columns">
                            <?php dynamic_sidebar('footer-col4'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; //$footer_layout == ...  ?>
        <?php endif; //$footer_main_switch  ?>
        <?php if ($footer_copyrights_switch): ?>
            <div class="site-footer__copyrights">
                <div class="row">
                    <div class="large-6 small-6 columns text-left">
                        <?php
                        echo $theme_settings['lbmn_footer_copyrights_left'];
                        ?>
                    </div>
                    <div class="large-6 small-6 columns text-right">
                        <?php
                        echo $theme_settings['lbmn_footer_copyrights_right'];
                        ?>
                    </div>
                </div>
            </div><!-- .site-footer__copyrights-->
        <?php endif; //$footer_copyrights_switch  ?>
    </footer><!-- #colophon -->
<?php endif; //$footer_main_switch ?>
</div><!--  .global-wrapper -->
<a class="exit-off-canvas"></a>
</section> <!-- class="main-section" -->
</div><!-- .global-container -->
</div> <!-- class="off-canvas-wrap" -->

<?php wp_footer(); ?>
<?php
$custom_js = $theme_settings['lbmn_js'];
if (strlen($custom_js) > 20) {
    echo "\n<!-- User's JavaScript -->\n" . $custom_js . "\n\n";
}
?>

<?php if (defined('THEME_COLORS') && THEME_COLORS == true): ?>
    <div id="popout-menu" class="hidden">
        <div class="trigger"><img src="/wp-content/themes/salbii/images/gear.gif" /></div>
        <div class="menu">
            <ul class="tabs four side-nav">
                <li>THEME OPTIONS</li>                
                
                <li>
                    <a href="#" class="no-action">LAYOUT</a>
                    <ul>
                        <li><a href="#" data-remove-class="boxed-layout img img1 img2 img3 patt patt1 patt2 patt3 patt4 patt5 patt6">Full Width</a></li>
                        <li><a href="#" data-add-class="boxed-layout">Boxed</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="no-action">HEADER LAYOUT</a>
                    <ul>
                        <li><a href="#" data-remove-class="header-2 header-3" data-add-class="header-1">Standard</a></li>
                        <li><a href="#" data-remove-class="header-1 header-3" data-add-class="header-2">Centered</a></li>
                        <li><a href="#" data-remove-class="header-1 header-2" data-add-class="header-3">Advanced</a></li>                        
                    </ul>
                </li>
                <li>
                    <a href="#" class="no-action">BACKGROUND PATTERN</a>
                    <ul class="thumbs">
                    	<?
                    		for($i=1;$i<=12;$i++) {
                    			echo "<li><a href=\"#\" class=\"pattern\" data-remove-class=\"img img1 img2 img3";
                    			for($j=1;$j<=12;$j++) {
                    				if($j != $i) echo " patt".$j;
                    			}
                    			echo "\" data-add-class=\"boxed-layout patt patt".$i."\" style=\"background-image:url('/wp-content/themes/salbii/images/wp-admin/layout-backgrounds/bg".$i."-thumb.png')\">pattern ".$i."</a></li>\n";
                    		}
                    	?>                      
                    </ul>
                </li>
                <li>
                    <a href="#" class="no-action">BACKGROUND IMAGE</a>
                    <ul class="thumbs">
                    	<?
                    		for($i=1;$i<=3;$i++) {
                    			echo "<li><a href=\"#\" data-remove-class=\"patt";
                    			for($j=1;$j<=3;$j++) {
                    				echo " patt".$j;
                    				if($j != $i) echo " img".$j;
                    			}
                    			echo "\" data-add-class=\"boxed-layout img img".$i."\"><img src=\"";
                    			if($i==1) echo "/wp-content/themes/salbii/images/wp-admin/layout-backgrounds/bgimg1.jpg";
                    			if($i==2) echo "/wp-content/themes/salbii/images/wp-admin/layout-backgrounds/bgimg2.jpg";
                    			if($i==3) echo "/wp-content/themes/salbii/images/wp-admin/layout-backgrounds/bgimg3.jpg";
                    			echo "\" alt=\"pattern ".$i."\" width=\"53\" /></a></li>\n";
                    		}
                    	?>
                    </ul>                    
                </li>
                <li>
                    <a href="#" class="reset" >RESET OPTIONS</a>
                </li>
            </ul>
        </div>
    </div>
<?php endif; ?>
</body>
</html>