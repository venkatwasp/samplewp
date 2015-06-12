<?php
/**
* ----------------------------------------------------------------------
* Custom metaboxes definisions
* Uses 'Meta Box' plugin by http://www.deluxeblogtips.com/
* See /plugins/meta-box/demo/demo.php for available controls
*
* (c) Twin Dots Limited 
* Distributed via ThemeForest under GPLv2 (or later)
*
*/

$prefix = 'lbmn_';
global $meta_boxes;
$meta_boxes = array();

/**
* ----------------------------------------------------------------------
* Page settings meta box
*/

$meta_boxes[] = array(
	// Meta box id, UNIQUE per meta box. Optional since 4.1.5
	'id' => 'lbmn-page-settings',

	// Meta box title - Will appear at the drag and drop handle bar. Required.
	'title' => __( 'Page Design Settings', 'lbmn' ),

	// Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
	'pages' => array( 'page', 'lbmn_project' ),

	// Where the meta box appear: normal (default), advanced, side. Optional.
	'context' => 'side',

	// Order of meta box: high (default), low. Optional.
	'priority' => 'high',

	// Auto save: true, false (default). Optional.
	'autosave' => true,

	// List of meta fields
	'fields' => array(
		// CHECKBOX LIST
		array(
			'name' => '',
			'id'   => "{$prefix}page_title_settings",
			'type' => 'checkbox_list',
			// Options of checkboxes, in format 'value' => 'Label'
			'options' => array(
				'hidden' => '<strong>' . __( 'Hide page title', 'lbmn' ) . '</strong>',
			),
		),
		// TEXT
		array(
			'name'  => '<strong>' . __( 'Secondary page title', 'lbmn' ) . '</strong>',
			'id'    => "{$prefix}secondary_page_title",
			// 'desc'  => __( 'Dispalys next to the main page title based on design selected.', 'lbmn' ),
			'type'  => 'text',
		),

		// DIVIDER
		array(
			'type' => 'divider',
			'id'   => 'page_settings_panel_divider_126', // Not used, but needed
		),
		// CHECKBOX LIST
		array(
			'name' => '<strong>' . __( 'Content margins', 'lbmn' ) . '</strong>',
			'id'   => "{$prefix}page_design_settings",
			'type' => 'checkbox_list',
			// Options of checkboxes, in format 'value' => 'Label'
			'options' => array(
				'no_top_padding' => __( 'Remove top spacing', 'lbmn' ),
				'no_bottom_padding' => __( 'Remove bottom spacing', 'lbmn' ),
			),
		),
	),
);


/**
* ----------------------------------------------------------------------
* Register defined meta boxes
*/
/**
 * Register meta boxes
 *
 * @return void
 */
function lbmn_register_custom_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'lbmn_register_custom_meta_boxes' );
