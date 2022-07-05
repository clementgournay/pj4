<?php
add_action( 'cmb2_admin_init', 'gon_cmb2_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 */
function gon_cmb2_sample_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_gon_';

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'header_style',
		'title'         => esc_html__( 'Header Settings', 'kokomi' ),
		'object_types'  => array( 'page', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// Regular text field
	$cmb->add_field( array(
		'name'       => esc_html__( 'Choose Header Style', 'kokomi' ),
		'id'         => $prefix . 'header_style',
		'type'    => 'select',
		'options' => array(
			'layout-0' => esc_html__( 'Choose header layout', 'kokomi' ),
			'layout-1'   => esc_html__( 'Header layout 1', 'kokomi' ),
			'layout-2'     => esc_html__( 'Header layout 2', 'kokomi' ),
			'layout-3'     => esc_html__( 'Header layout 3', 'kokomi' ),
			'layout-4'     => esc_html__( 'Header layout 4', 'kokomi' ),
		),
	) );

}