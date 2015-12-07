<?php
/*
Plugin Name: Trinity Codes Admin Theme
Plugin URI: -
Description: Customizes the admin theme.
Version: 0.1
Author: Trinity Vandenacre
Author URI: http://trinitycodes.com
License: GPLV2
*/

class TC_Admin_Theme
{

	public function __construct() {

		/**
		 * Load the Admin Stylesheet
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'tc_admin_theme_style' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'tc_admin_theme_style' ) );

	}

	public function tc_admin_theme_style() {

		wp_enqueue_style( 'tc-admin-theme', plugins_url( 'css/wp-admin.css', __FILE__ ) );

	}

}
$admin_theme = new TC_Admin_Theme();