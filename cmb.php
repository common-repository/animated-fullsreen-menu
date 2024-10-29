<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'animatedfsmenu_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  animatedFullScreen Menbu
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

if ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}


if ( file_exists( dirname( __FILE__ ) . '/CMB2/cmb2-icon-picker/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/cmb2-icon-picker/init.php';
	function backend_styles() { //phpcs:ignore
		wp_enqueue_style( 'styles', plugins_url( 'admin/css/styles.css', __FILE__ ), array(), '1.0' );
		wp_enqueue_style( 'font-awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '1.0' );
	}
	add_action( 'admin_enqueue_scripts', 'backend_styles' );
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 $cmb CMB2 object.
 *
 * @return bool      True if metabox should show
 */
function animatedfsmenu_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field $field Field object.
 *
 * @return bool              True if metabox should show
 */
function animatedfsmenu_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}


add_action( 'cmb2_admin_init', 'animatedfsmenu_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function animatedfsmenu_register_theme_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box(
		array(
			'id'           => 'animatedfsmenu_theme_options_page',
			'title'        => esc_html__( 'Animated Fullscreen Menu', 'animatedfsmenu' ),
			'object_types' => array( 'options-page' ),
			'option_key'   => 'animatedfsm_settings',
			'icon_url'     => 'dashicons-menu',
		)
	);

	$cmb_options->add_field(
		array(
			'name' => esc_html__( 'Activate Animated Fullscreen Menu', 'animatedfsm' ),
			'desc' => esc_html__( 'Leave unchecked if you want to desactivate it.', 'animatedfsm' ),
			'id'   => 'animatedfsm_on',
			'type' => 'checkbox',
		)
	);

	$cmb_options->add_field(
		array(
			'name' => esc_html__( 'Mobile only?', 'animatedfsm' ),
			'desc' => esc_html__( 'This menu should be appears only for mobile devices? We consider mobile devices as fewer than 1024px resolution.', 'animatedfsm' ),
			'id'   => 'animatedfsm_mobile_only',
			'type' => 'checkbox',
		)
	);

	$cmb_options->add_field(
		array(
			'name'    => esc_html__( 'Initial Background Menu', 'animatedfsm' ),
			'desc'    => esc_html__( 'First color (closed Menu).', 'animatedfsm' ),
			'id'      => 'animatedfsm_background01',
			'type'    => 'colorpicker',
			'default' => '#000000',
		)
	);

	$cmb_options->add_field(
		array(
			'name'    => esc_html__( 'Opened Background Menu', 'animatedfsm' ),
			'desc'    => esc_html__( 'Menu color when is opened.', 'animatedfsm' ),
			'id'      => 'animatedfsm_background02',
			'type'    => 'colorpicker',
			'default' => '#3a3a3a',
		)
	);

	$cmb_options->add_field(
		array(
			'name' => esc_html__( 'Background Image', 'animatedfsm' ),
			'desc' => esc_html__( 'Background Image when menu is opened. Leave blank to use colors above.', 'animatedfsm' ),
			'id'   => 'animatedfsm_backgroundimage',
			'type' => 'file',
		)
	);

	$cmb_options->add_field(
		array(
			'name'    => esc_html__( 'Font Color', 'animatedfsm' ),
			'desc'    => esc_html__( 'Color for fonts, social media icons and navbar hamburger.', 'animatedfsm' ),
			'id'      => 'animatedfsm_textcolor',
			'type'    => 'colorpicker',
			'default' => '#FFFFFF',
		)
	);

	$cmb_options->add_field(
		array(
			'name'    => esc_html__( 'Select Menu', 'animatedfsm' ),
			'desc'    => esc_html__( 'These menus area editable at Appearence->Menus.', 'animatedfsm' ),
			'id'      => 'animatedfsm_menuselected',
			'type'    => 'select',
			'options' => animatedfsm_get_menus(),
		)
	);

	$cmb_options->add_field(
		array(
			'name'    => esc_html__( 'Select Font Family', 'animatedfsm' ),
			'desc'    => esc_html__( 'Font for Menu Text. Leave blank if you want use your actual font from your theme.', 'animatedfsm' ),
			'id'      => 'animatedfsm_font',
			'type'    => 'select',
			'options' => animatedfsm_get_fonts(),
		)
	);

	$cmb_options->add_field(
		array(
			'name' => esc_html__( 'Include Privacy Policy Page (GPRD)', 'animatedfsm' ),
			'desc' => esc_html__( 'This page is selected at Settings -> Privacy.', 'animatedfsm' ),
			'id'   => 'animatedfsm_privacy_on',
			'type' => 'checkbox',
		)
	);

	$cmb_options->add_field(
		array(
			'id'         => 'socialicons_group',
			'name'       => '<br>' . esc_html__( 'Social Icons', 'animatedfsm' ) . '<br><br>',
			'type'       => 'group',
			'repeatable' => true,
			'required'   => false,
			'options'    => array(
				'group_title'   => 'Social Icon {#}',
				'add_button'    => esc_html__( 'Add Another Icon' ),
				'remove_button' => 'Remove Icon',
				'closed'        => true,
				'sortable'      => true,
			),
		)
	);

	$cmb_options->add_group_field(
		'socialicons_group',
		array(
			'name' => esc_html__( 'Social Icon Title', 'animatedfsm' ),
			'desc' => esc_html__( 'Enter the post title for the link text.', 'animatedfsm' ),
			'id'   => 'title',
			'type' => 'text',
		)
	);

	$cmb_options->add_group_field(
		'socialicons_group',
		array(
			'name'       => esc_html__( 'Social Icon', 'animatedfsm' ),
			'id'         => 'icon',
			'desc'       => __( 'Choose your Icon (Font Awesome library).' ),
			'show_names' => true,
			'type'       => 'icon_picker',
			'options'    => array(
				// Select icons we want to show (shows all dashicons by default).
				'icons'      => array(
					'fa-instagram',
					'fa-facebook-f',
					'fa-twitter',
					'fa-github',
					'fa-envelope',
					'fa-behance',
					'fa-linkedin',
					'fa-slack',
					'fa-tripadvisor',
					'fa-vimeo',
					'fa-whatsapp',
					'fa-youtube-play',
					'fa-wordpress',
				),
				// Use as multicheck instead of radio, deafult is radio.
				'fonts'      => array( 'FontAwesome' ),
				'multicheck' => false,
			),
		)
	);

	$cmb_options->add_group_field(
		'socialicons_group',
		array(
			'name' => esc_html__( 'Social URL', 'animatedfsm' ),
			'desc' => esc_html__( 'Enter the url of the social media.', 'animatedfsm' ),
			'id'   => 'animatedfsm_url',
			'type' => 'text_url',
		)
	);

	$cmb_options->add_field(
		array(
			'name'    => esc_html__( 'Animation Direction', 'animatedfsm' ),
			'desc'    => esc_html__( 'Select your animation direction.', 'animatedfsm' ),
			'id'      => 'animatedfsm_animation',
			'type'    => 'select',
			'options' => array(
				'top'   => 'From Top to Bottom',
				'left'  => 'From Left to Right',
				'right' => 'From Right to Left',
			),
		)
	);

	if ( function_exists( 'pll_the_languages' ) ) :
		$cmb_options->add_field(
			array(
				'name' => esc_html__( 'Add Language Switcher', 'animatedfsm' ),
				'desc' => esc_html__( 'Check this if you want to use language switcher from Polylang Plugin.', 'animatedfsm' ),
				'id'   => 'animatedfsm_languageswitcher',
				'type' => 'checkbox',
			)
		);
	endif;

	if ( class_exists( 'WooCommerce' ) ) :
		$cmb_options->add_field(
			array(
				'name' => esc_html__( 'Add WooCommerce Menu?', 'animatedfsm' ),
				'desc' => esc_html__( 'Adds "My Account", "Shop", "Cart" and "Checkout" menus', 'animatedfsm' ),
				'id'   => 'animatedfsm_woocommerce_on',
				'type' => 'checkbox',
			)
		);
	endif;

	$cmb_options->add_field(
		array(
			'name' => esc_html__( 'Remove Data after uninstall', 'animatedfsm' ),
			'desc' => esc_html__( 'If you do not select this option, your data is not deleted.', 'animatedfsm' ),
			'id'   => 'animatedfsm_removedata_on',
			'type' => 'checkbox',
		)
	);

}


function animatedfsm_get_menus() { //phpcs:ignore

	$animatedfsm_all_menus = get_terms(
		'nav_menu',
		array(
			'hide_empty' => true,
		)
	);

	$array_menus         = [];
	$array_menus['none'] = __( 'None/Empty', 'animatedfsm' );

	if ( $animatedfsm_all_menus ) {
		foreach ( $animatedfsm_all_menus as $menu ) {
			$array_menus[ $menu->term_id ] = $menu->name;
		}
	}
	return $array_menus;
}

function animatedfsm_get_fonts() { //phpcs:ignore

	$google_fonts_name = [
		'Nunito Sans',
		'Roboto',
		'Open Sans',
		'Lato',
		'Oswald',
		'Source Sans Pro',
		'Montserrat',
		'Raleway',
		'PT Sans',
	];

	$google_fonts;

	$google_fonts['blank'] = 'Default Font from your Theme';

	foreach ( $google_fonts_name as $font ) {
		$google_fonts[ $font ] = $font;
	}
	return $google_fonts;
}
