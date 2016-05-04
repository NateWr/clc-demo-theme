<?php
/**
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    clc-demo-theme
 * @subpackage Functions
 * @version    0.0.1
 * @author     Nate Wright <https://github.com/NateWr>
 * @copyright  Copyright (c) 2015, Theme of the Crop
 * @link      https://github.com/NateWr/clc-demo-theme
 * @license    GNU General Public License v2.0 or later
 */

/**
 * Set up the theme
 *
 * @since 0.0.1
 */
function clcdt_setup_theme() {

	// Load the controller class
	include_once( get_template_directory() . '/lib/content-layout-control/dist/content-layout-control.php' );

	// Instantiate the controller object
	CLC_Content_Layout_Control(
		array(
			// The URL to the content-layout-control framework
			'url'  => get_template_directory_uri() . '/lib/content-layout-control/dist',

			// Translatable strings should be defined with the theme's textdomain
			'i18n' => array(
				'delete'         => esc_html__( 'Delete', 'clc-demo-theme' ),
				'control-toggle' => esc_html__( 'Open/close this component', 'clc-demo-theme' ),
			)
		)
	);

	// Load the components you'd like to use with this theme
	// This filter must be present for the customizer as well as in requests to
	// the content-layout-control's REST API endpoints.
	add_filter( 'clc_register_components', 'clcdt_register_components' );

	// Register our content-layout-control with the customizer
	add_action( 'customize_register', 'clcdt_customize_register' );

	// Finally, take care of a bit of theme house-keeping. Not required for clc.
	add_action( 'wp_enqueue_scripts', function() { wp_enqueue_style( 'luigi', get_stylesheet_uri() ); } );
	load_theme_textdomain( 'clc-demo-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'clcdt_setup_theme' );

/**
 * Load the components you'd like to use with this theme
 *
 * @param array Components already registered
 * @since 0.0.1
 */
function clcdt_register_components( $components ) {

	// No components are registered by default. You must register each component
	// you want to support in your theme, including the default components that
	// come with content-layout-control.

	// content-block
	//
	// Default component. The array key should match the component class's $type
	// property.
	$components['content-block'] = array(

		// Path to the component class file
		'file' => get_template_directory() . '/lib/content-layout-control/dist/components/content-block.php',

		// Name of the component class
		'class' => 'CLC_Component_Content_Block',

		// Name and description used in component selection
		'name' => esc_html__( 'Content Block', 'clc-demo-theme' ),
		'description' => esc_html__( 'A simple content block with an image, title, text and links.', 'clc-demo-theme' ),

		// Translateable strings used in the component controls
		'i18n' =>  array(
			'title'                => esc_html__( 'Title', 'clc-demo-theme' ),
			'content'              => esc_html__( 'Content', 'clc-demo-theme' ),
			'image'                => esc_html__( 'Image', 'clc-demo-theme' ),
			'image_placeholder'    => esc_html__( 'No image selected', 'clc-demo-theme' ),
			'image_position'       => esc_html__( 'Image Position', 'clc-demo-theme' ),
			'image_position_left'  => esc_html__( 'Left', 'clc-demo-theme' ),
			'image_position_right' => esc_html__( 'Right', 'clc-demo-theme' ),
			'image_select_button'  => esc_html__( 'Select Image', 'clc-demo-theme' ),
			'image_change_button'  => esc_html__( 'Change Image', 'clc-demo-theme' ),
			'image_remove_button'  => esc_html__( 'Remove', 'clc-demo-theme' ),
			'links'                => esc_html__( 'Links', 'clc-demo-theme' ),
			'links_add_button'     => esc_html__( 'Add Link', 'clc-demo-theme' ),
			'links_remove_button'  => esc_html__( 'Remove', 'clc-demo-theme' ),
		),
	);

	// posts
	//
	// Default component.
	$components['posts'] = array(

		// Path to the component class file
		'file' => get_template_directory() . '/lib/content-layout-control/dist/components/posts.php',

		// Name of the component class
		'class' => 'CLC_Component_Posts',

		// Name and description used in component selection
		'name' => esc_html__( 'Posts', 'clc-demo-theme' ),
		'description' => esc_html__( 'Display one or more posts.', 'clc-demo-theme' ),

		// Limit the number of posts allowed to be added to a single component
		'limit_posts' => 3,

		// Translateable strings used in the component controls
		'i18n' =>  array(
			'posts_loading' => esc_html__( 'Loading', 'clc-demo-theme' ),
			'posts_remove_button' => esc_html__( 'Remove', 'clc-demo-theme' ),
			'placeholder'         => esc_html__( 'No post selected.', 'clc-demo-theme' ),
			'posts_add_button'    => esc_html__( 'Add Post', 'clc-demo-theme' ),
		),
	);

	// Don't forget to return the $components array
	return $components;
}

/**
 * Register our content-layout-control with the customizer
 *
 * @since 0.0.1
 */
function clcdt_customize_register( $wp_customize ) {

	// Let's put our control in it's own section
	// You can put it in any section you'd like.
	$wp_customize->add_section(
		'content_layout_control',
		array(
			'capability' => 'edit_posts',
			'title'      => __( 'Content Layout Control', 'clc-demo-theme' ),
		)
	);

	// Create a etting for our control
	$wp_customize->add_setting(

		// Leave the setting named `content_layout_control`
		'content_layout_control',

		array(

			// This method loops over the components and calls an appropriate
			// sanitization function on each one.
			'sanitize_callback' => 'CLC_Content_Layout_Control::sanitize',

			// Avoid unnecessary page refreshes
			// @see https://developer.wordpress.org/themes/advanced-topics/customizer-api/#using-postmessage-for-improved-setting-previewing
			'transport' => 'postMessage',

			// Don't change this unless you know what you're doing
			'type' => 'content_layout',
		)
	);

	// Finally, let's define our control
	//
	// This extends the normal customizer control class. Look at the customizer
	// docs for any undescribed arguments.
	$wp_customize->add_control(
		new CLC_WP_Customize_Content_Layout_Control(
			$wp_customize,
			'content_layout_control',
			array(
				'section' => 'content_layout_control',
				'priority' => 1,

				// After registering our components, we white-list the ones
				// we want to allow with this control.
				'components' => array( 'content-block', 'posts' ),

				// An optional active_callback can be passed. The default is
				// is_page(). But you'll probably want to further restrict it to
				// specific page templates or even just the homepage.
				//
				// This example for limiting to the homepage is PHP 5.3+ only!
				// 'active_callback' => function() { return is_page() && is_front_page() },

				// Translateable strings
				'i18n' => array(
					'add_component'                 => esc_html__( 'Add Component', 'clc-demo-theme' ),
					'edit_component'                => esc_html__( 'Edit', 'clc-demo-theme' ),
					'close'                         => esc_attr__( 'Close', 'clc-demo-theme' ),
					'post_search_label'             => esc_html__( 'Search content', 'clc-demo-theme' ),
					'links_add_button'              => esc_html__( 'Add Link', 'clc-demo-theme' ),
					'links_url'                     => esc_html__( 'URL', 'clc-demo-theme' ),
					'links_text'                    => esc_html__( 'Link Text', 'clc-demo-theme' ),
					'links_search_existing_content' => esc_html__( 'Search existing content &rarr;', 'clc-demo-theme' ),
					'links_back'                    => esc_html__( '&larr; Back to link form', 'clc-demo-theme' ),
				),
			)
		)
	);
}
