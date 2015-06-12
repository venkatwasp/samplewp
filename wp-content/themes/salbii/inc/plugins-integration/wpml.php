<?php
/**
 * Fucntions used to integrate WPML plugin the better way
 *
 *
 * Theme designed and developed by Vladimir Mitcovschi (vladimir@twindots.com) for Twin Dots Limited
 * based on _s theme by Automattic and custom code libraries by Vladimir Mitcovschi for Twin Dots Limited
 * Distributed on ThemeForest under GNU General Public License
 */

if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')){

function lbmn_languages_selector( $custom_class = ''){
		if ($custom_class) {
			$custom_class = ' ' . $custom_class;
		}
		global $sitepress_settings;
		$active_languages = icl_get_languages('skip_missing=0');

		// lbmn_debug( $sitepress_settings['icl_lso_flags'] );

		if(empty($active_languages)) return;

		ob_start();
?>
		<ul class="language-switch menu<?php echo $custom_class; ?>">
			<?php if ($sitepress_settings['icl_lang_sel_type'] == 'dropdown'): ?>
			<li class="has-dropdown">
				<?php lbmn_render_active_laguages(true); ?>
				<ul class="dropdown">
					<?php lbmn_render_active_laguages(); ?>
				</ul>
			</li><!-- has-dropdown -->
			<?php else:?>
				<?php lbmn_render_active_laguages(); ?>
			<?php endif;?>
		</ul>
<?php
		$output = ob_get_clean();
		return $output;
}

function lbmn_render_active_laguages($current_only = '') {
	global $sitepress, $sitepress_settings, $icl_language_switcher_preview;
	$active_languages = icl_get_languages('skip_missing=0');
	if(empty($active_languages)) return;

	foreach($active_languages as $lang): ?>
	<?php if ( ( ($lang['language_code'] == $sitepress->get_current_language()) && $current_only ) || !$current_only ): ?>
		<?php if ( !$current_only ): ?>
			<li class="menu-item icl-<?php echo $lang['language_code'] ?>">
		<?php endif; ?>
				<a href="<?php echo apply_filters('WPML_filter_link', $lang['url'], $lang)?>"<?php if ($lang['language_code'] == $sitepress->get_current_language()) echo ' class="lang_sel_sel"'; else echo ' class="lang_sel_other"'; ?>>
				<?php if( $sitepress_settings['icl_lso_flags'] || $icl_language_switcher_preview):?>
				<img <?php if( !$sitepress_settings['icl_lso_flags'] ):?>style="display:none"<?php endif?> class="iclflag" src="<?php echo $lang['country_flag_url'] ?>" alt="<?php echo $lang['language_code'] ?>" title="<?php echo $sitepress_settings['icl_lso_display_lang'] ? esc_attr($lang['translated_name']) : esc_attr($lang['native_name']) ; ?>" />&nbsp;
				<?php endif; ?>
				<?php
						if($icl_language_switcher_preview){
								$lang_native = $lang['native_name'];
								if($sitepress_settings['icl_lso_native_lang']){
										$lang_native_hidden = false;
								}else{
										$lang_native_hidden = true;
								}
								$lang_translated = $lang['translated_name'];
								if($sitepress_settings['icl_lso_display_lang']){
										$lang_translated_hidden = false;
								}else{
										$lang_translated_hidden = true;
								}
						}else{
								if($sitepress_settings['icl_lso_native_lang']){
										$lang_native = $lang['native_name'];
								}else{
										$lang_native = false;
								}
								if($sitepress_settings['icl_lso_display_lang']){
										$lang_translated = $lang['translated_name'];
								}else{
										$lang_translated = false;
								}
						}
						echo @icl_disp_language($lang_native, $lang_translated, $lang_native_hidden, $lang_translated_hidden);
						 ?>
				</a>
		<?php if ( !$current_only ): ?>
			</li>
		<?php endif; ?>
	<?php endif; ?>
	<?php endforeach;
}

} else {
	function lbmn_languages_selector($custom_class=''){}
	function lbmn_render_active_laguages($current_only='') {}
}