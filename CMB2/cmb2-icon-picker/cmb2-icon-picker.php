<?php
/**
 * CMB2_Icon_Picker loader
 *
 * Handles checking for and smartly loading the newest version of this library.
 *
 * @category  WordPressLibrary
 * @package   CMB2_Icon_Picker
 * @author    Lasse Mejlvang Tvedt <himself@lassemt.com>
 * @copyright 2016 Lasse Mejlvang Tvedt <himself@lassemt.com>
 * @license   GPL-2.0+
 * @version   0.1.0
 * @link      https://lassemt.com
 * @since     0.1.0
 */

/**
 * Copyright (c) 2016 Lasse Mejlvang Tvedt (email : himself@lassemt.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Loader versioning: http://jtsternberg.github.io/wp-lib-loader/
 */

if ( ! class_exists( 'CMB2_Icon_Picker_010', false ) ) {

	/**
	 * Versioned loader class-name
	 *
	 * This ensures each version is loaded/checked.
	 *
	 * @category WordPressLibrary
	 * @package  CMB2_Icon_Picker
	 * @author   Lasse Mejlvang Tvedt <himself@lassemt.com>
	 * @license  GPL-2.0+
	 * @version  0.1.0
	 * @link     https://lassemt.com
	 * @since    0.1.0
	 */
	class CMB2_Icon_Picker_010 {

		/**
		 * CMB2_Icon_Picker version number
		 * @var   string
		 * @since 0.1.0
		 */
		const VERSION = '0.1.0';

		/**
		 * Current version hook priority.
		 * Will decrement with each release
		 *
		 * @var   int
		 * @since 0.1.0
		 */
		const PRIORITY = 9999;

		/**
		 * Starts the version checking process.
		 * Creates CMB2_ICON_PICKER_LOADED definition for early detection by
		 * other scripts.
		 *
		 * Hooks CMB2_Icon_Picker inclusion to the cmb2_icon_picker_load hook
		 * on a high priority which decrements (increasing the priority) with
		 * each version release.
		 *
		 * @since 0.1.0
		 */
		public function __construct() {
			if ( ! defined( 'CMB2_ICON_PICKER_LOADED' ) ) {
				/**
				 * A constant you can use to check if CMB2_Icon_Picker is loaded
				 * for your plugins/themes with CMB2_Icon_Picker dependency.
				 *
				 * Can also be used to determine the priority of the hook
				 * in use for the currently loaded version.
				 */
				define( 'CMB2_ICON_PICKER_LOADED', self::PRIORITY );
			}

			// Use the hook system to ensure only the newest version is loaded.
			add_action( 'cmb2_icon_picker_load', array( $this, 'include_lib' ), self::PRIORITY );

			/*
			 * Hook in to the first hook we have available and
			 * fire our `cmb2_icon_picker_load' hook.
			 */
			add_action( 'muplugins_loaded', array( __CLASS__, 'fire_hook' ), 9 );
			add_action( 'plugins_loaded', array( __CLASS__, 'fire_hook' ), 9 );
			add_action( 'after_setup_theme', array( __CLASS__, 'fire_hook' ), 9 );
		}

		/**
		 * Fires the cmb2_icon_picker_load action hook.
		 *
		 * @since 0.1.0
		 */
		public static function fire_hook() {
			if ( ! did_action( 'cmb2_icon_picker_load' ) ) {
				// Then fire our hook.
				do_action( 'cmb2_icon_picker_load' );
			}
		}

		/**
		 * A final check if CMB2_Icon_Picker exists before kicking off
		 * our CMB2_Icon_Picker loading.
		 *
		 * CMB2_ICON_PICKER_VERSION and CMB2_ICON_PICKER_DIR constants are
		 * set at this point.
		 *
		 * @since  0.1.0
		 */
		public function include_lib() {
			if ( class_exists( 'CMB2_Icon_Picker', false ) ) {
				return;
			}

			if ( ! defined( 'CMB2_ICON_PICKER_VERSION' ) ) {
				/**
				 * Defines the currently loaded version of CMB2_Icon_Picker.
				 */
				define( 'CMB2_ICON_PICKER_VERSION', self::VERSION );
			}

			if ( ! defined( 'CMB2_ICON_PICKER_DIR' ) ) {
				/**
				 * Defines the directory of the currently loaded version of CMB2_Icon_Picker.
				 */
				define( 'CMB2_ICON_PICKER_DIR', dirname( __FILE__ ) . '/' );
			}

			// Include and initiate CMB2_Icon_Picker.
			require_once CMB2_ICON_PICKER_DIR . 'init.php';
		}

	}

	// Kick it off.
	new CMB2_Icon_Picker_010;
}
