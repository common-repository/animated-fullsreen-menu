<?php

add_action( 'wp_enqueue_scripts', 'animatedfsmenu_enqueue_scripts', 22, 1 );


function animatedfsmenu_get_woocommerce_menu() {
	$account  = ( null !== wc_get_page_id( 'myaccount' ) ? wc_get_page_id( 'myaccount' ) : '' );
	$shop     = ( null !== wc_get_page_id( 'shop' ) ? wc_get_page_id( 'shop' ) : '' );
	$cart     = ( null !== wc_get_page_id( 'cart' ) ? wc_get_page_id( 'cart' ) : '' );
	$checkout = ( null !== wc_get_page_id( 'checkout' ) ? wc_get_page_id( 'checkout' ) : '' );

	if ( function_exists( 'pll_the_languages' ) ) {
		$account  = pll_get_post( $account );
		$shop     = pll_get_post( $shop );
		$cart     = pll_get_post( $cart );
		$checkout = pll_get_post( $checkout );
	}

	$woocommerce_menu = array(
		'account'  => array(
			'page_title' => get_the_title( $account ),
			'page_url'   => get_the_permalink( $account ),
			'icon'       => 'fa-user',
		),
		'shop'     => array(
			'page_title' => get_the_title( $shop ),
			'page_url'   => get_the_permalink( $shop ),
			'icon'       => 'fa-store',
		),
		'cart'     => array(
			'page_title' => get_the_title( $cart ),
			'page_url'   => get_the_permalink( $cart ),
			'icon'       => 'fa-shopping-cart',
		),
		'checkout' => array(
			'page_title' => get_the_title( $checkout ),
			'page_url'   => get_the_permalink( $checkout ),
			'icon'       => 'fa-shopping-bag',
		),
	);

	return $woocommerce_menu;
}

function render_animatedfsmenu_nav() { //phpcs:ignore

	$settings = get_option( 'animatedfsm_settings' );

	$privacy_policy_on  = ( isset( $settings['animatedfsm_privacy_on'] ) ? $settings['animatedfsm_privacy_on'] : false );
	$googlefont         = $settings['animatedfsm_font'];
	$background01       = $settings['animatedfsm_background01'];
	$background02       = $settings['animatedfsm_background02'];
	$background_image   = ( isset( $settings['animatedfsm_backgroundimage'] ) ? $settings['animatedfsm_backgroundimage'] : null );
	$menu_id            = $settings['animatedfsm_menuselected'];
	$textcolor          = $settings['animatedfsm_textcolor'];
	$social_media_array = $settings['socialicons_group'];
	$animation_class    = 'animatedfsmenu__' . esc_attr( $settings['animatedfsm_animation'] );
	$mobile_only        = ( isset( $settings['animatedfsm_mobile_only'] ) ? $settings['animatedfsm_mobile_only'] : false );
	$mobile_class       = ( 'on' === $mobile_only ? 'animatedfsmenu__mobile' : '' );
	$woocommerce_on     = ( isset( $settings['animatedfsm_woocommerce_on'] ) ? $settings['animatedfsm_woocommerce_on'] : false );
	$language_switcher  = ( isset( $settings['animatedfsm_languageswitcher'] ) ? $settings['animatedfsm_languageswitcher'] : false );

	if ( count( $social_media_array ) > 0 || 'on' === $woocommerce_on ) {
		animatedfsm_enqueue_fontawesome();
	}

	if ( $googlefont ) {
		animatedfsm_enqueue_google_fonts( $googlefont );
		?>
		<style>
			.animatedfsmenu{
			font-family: <?php echo esc_attr( $googlefont ); ?> !important;
			}
		</style>	
		<?php
	}

	if ( null !== $background_image ) {
			render_animatedfsmenu_backgroundimages( $background_image );
	}

	function animatedfsm_getlanguages( $display = 'flag', $flags = false ) { //phpcs:ignore

		if ( function_exists( 'pll_the_languages' ) ) {
			echo '<ul class="navbar__languages">';
			pll_the_languages(
				array(
					'display_names_as' => $display,
					'show_flags'       => $flags,
				)
			);
			echo '</ul>';
		}
	}
	?>

<style>

.turbolinks-progress-bar, .animatedfsmenu{
	background-color: <?php echo esc_attr( $background01 ); ?> !important;
}

.animatedfsmenu.navbar-expand-md, .animatedfsmenu.navbar-expand-ht{
	background-color: <?php echo esc_attr( $background02 ); ?> !important;
}
.animatedfsmenu button:focus, .animatedfsmenu button:hover{
	background: <?php echo esc_attr( $background01 ); ?> !important;
}
.animatedfsmenu .navbar-toggler{
	background: <?php echo esc_attr( $background01 ); ?>;
}
.animatedfs_menu_list a{
	color: <?php echo esc_attr( $textcolor ); ?> !important;
}
.animatedfs_menu_list li > a:before, .animatedfsmenu .navbar-toggler .bar{
	background: <?php echo esc_attr( $textcolor ); ?> !important;
}
.animatedfsmenu .privacy_policy{
	color: <?php echo esc_attr( $textcolor ); ?>;
}
.animatedfsmenu .social-media li{
	border-color: <?php echo esc_attr( $textcolor ); ?>;
}
</style>

<div class="animatedfsmenu <?php echo esc_attr( $mobile_class ); ?> <?php echo esc_attr( $animation_class ); ?>">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<div class="bar top"></div>
			<div class="bar bot"></div>
			<div class="bar mid"></div>
		</button>

	<div class="navbar-collapse animatedfs_menu_list">
	<?php

	// get languages if there is Polylang Plugin installed
	if ( 'on' === $language_switcher ) {
		animatedfsm_getlanguages( 'slug', true );
	}

	if ( 'none' !== $menu_id ) {
			wp_nav_menu(
				array(
					'menu' => $menu_id,
				)
			);
	}
	?>
		<?php if ( count( $social_media_array ) > 0 ) : ?>
			<div class="social-media">
				
				<ul>	
					<?php
					foreach ( $social_media_array as $social ) :
						$url = ( isset( $social['url'] ) ? $social['url'] : '#' );
						?>
					<li>		
						<a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $social['title'] ); ?>" target="_blank">
							<i class="fab <?php echo esc_attr( $social['icon'] ); ?>"></i>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php
			endif;

		if ( class_exists( 'WooCommerce' ) && 'on' === $woocommerce_on ) :
			// get woocommerce pages id

			$woocommerce_menu = animatedfsmenu_get_woocommerce_menu();

			$render_woocommerce_menu = '<ul class="animatedfsmenu_woocommerce">';

			foreach ( $woocommerce_menu as $menu ) {
				$render_woocommerce_menu .= '<li><a href="' . esc_attr( $menu['page_url'] ) . '"><i class="fas ' . esc_attr( $menu['icon'] ) . '"></i>' . esc_html( $menu['page_title'] ) . '</a></li>';
			}

			$render_woocommerce_menu .= '</ul>';

			echo $render_woocommerce_menu; //phpcs:ignore
		endif;

		$privacy_policy = get_option( 'wp_page_for_privacy_policy' );

		if ( 'on' === $privacy_policy_on && $privacy_policy ) {
			?>
			<div class="privacy_policy">
				<?php
					echo '<a href="' . esc_attr( get_the_permalink( $privacy_policy ) ) . '" target="_blank">' .
						esc_html( get_the_title( $privacy_policy ) ) . '</a>';
				?>
			</div>
			<?php
		}
		?>
	</div>



</div>

	<?php

}


add_action( 'wp_footer', 'render_animatedfsmenu_nav' );

function animatedfsmenu_enqueue_scripts() { //phpcs:ignore

	if ( is_admin() ) {
		return;
	}

	wp_enqueue_style( 'styles', plugins_url( '/frontend/css/nav.css', __FILE__ ) );
	wp_enqueue_script( 'scripts', plugins_url( '/frontend/js/nav.js', __FILE__ ), '', '', true );
}


function animatedfsm_enqueue_fontawesome() { //phpcs:ignore
	wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css' );
}


function animatedfsm_enqueue_google_fonts( $font ) { //phpcs:ignore
	wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=' . $font );

}

function render_animatedfsmenu_backgroundimages( $background_image ) { //phpcs:ignore

	$background_image_id = attachment_url_to_postid( $background_image );
	$background_image    = wp_get_attachment_metadata( $background_image_id );

	$background_image['sizes'] = array_reverse( $background_image['sizes'] );
	?>
	<style>
		.animatedfsmenu{
			background-image: url( <?php echo esc_attr( wp_upload_dir()['baseurl'] . '/' . $background_image['file'] ); ?> );
		}
		<?php
		foreach ( $background_image['sizes'] as $sizes => $image ) :
			?>
			@media screen and (max-width: <?php echo esc_attr( $image['width'] ); ?>px) {
				.animatedfsmenu{
					background-image: url(<?php echo esc_attr( wp_get_attachment_image_url( $background_image_id, $sizes ) ); ?>);
				}
			}
		<?php endforeach; ?>

	</style>
	<?php
}
