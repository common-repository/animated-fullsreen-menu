<?php

/**
 * Plugin Name: Animated FullScreen Menu
 * Description: Give your website an additional cool-design Menu
 * Author: Samuel Silva
 * Version: 1.2
 * Author URI: https://samuelsilva.pt
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'add_action' ) ) {
	exit;
}



class AnimatedfsMenu {

	//register plugin
	function register() {
		require_once dirname( __FILE__ ) . '/cmb.php';

	}

	/*
	* activate plugin
	*/
	function activate() {

	}


}



if ( class_exists( 'AnimatedfsMenu' ) ) {
	$animated_fs_menu = new AnimatedfsMenu();
	$animated_fs_menu->register();
}


register_activation_hook( __FILE__, array( $animated_fs_menu, 'activate' ) );


if ( 'on' === get_option( 'animatedfsm_settings' )['animatedfsm_on'] ) {
	require_once dirname( __FILE__ ) . '/frontend-animatedfsmenu.php';
}
