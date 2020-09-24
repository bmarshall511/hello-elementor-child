<?php
/**
 * Theme CSS & JS scripts
 *
 * @package HelloElementor
 * @subpackage HelloElementorChild
 */

/**
 * Register & enqueue theme CSS & JS files.
 */
function hello_elementor_child_scripts() {
	$options = get_option( HELLO_ELEMENTOR_CHILD_KEY );

	// Non-critial CSS, loaded on every page.
	wp_enqueue_style( 'hello-elementor-child-non-critical', get_stylesheet_directory_uri() . '/assets/css/non-critical.css', array(), HELLO_ELEMENTOR_CHILD_VERSION );

	if ( ! empty( $options['ga_tracking_id'] ) ) {
		wp_enqueue_script( 'hello-elementor-child-ga', 'https://www.googletagmanager.com/gtag/js?id=' . $options['ga_tracking_id'], array(), HELLO_ELEMENTOR_CHILD_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts', PHP_INT_MAX );

/**
 * Inline critical (above page fold) CSS.
 */
function hello_elementor_child_critical_path_css() {
	ob_start();
	?>
	<style>
	<?php echo file_get_contents( get_stylesheet_directory() . '/assets/css/critical.css' ); // phpcs:ignore ?>
	</style>
	<?php
	echo ob_get_clean(); // phpcs:ignore
}
add_action( 'wp_head', 'hello_elementor_child_critical_path_css' );

/**
 * Preconnect & preload resources.
 *
 * @since 1.0.0
 */
add_action(
	'wp_head',
	function() {
		$options = get_option( HELLO_ELEMENTOR_CHILD_KEY );
		if ( ! empty( $options['ga_tracking_id'] ) ) :
			?>
			<link href="https://www.google-analytics.com" rel="preconnect" crossorigin />
		<?php endif; ?>
		<?php if ( ! did_action( 'elementor/loaded' ) ) : ?>
			<link rel="preload" href="https://www.benmarshall.me/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.woff2" as="font" crossorigin />
		<?php endif; ?>
		<?php
		if ( ! empty( $options['google_font_url'] ) ) :
			?>
			<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
			<link rel="preload" as="style" href="<?php echo esc_url( $options['google_font_url'] ); ?>" />
			<link rel="stylesheet" href="<?php echo esc_url( $options['google_font_url'] ); ?>" media="print" onload="this.media='all'" /> <?php // phpcs:ignore ?>
			<noscript>
				<link rel="stylesheet" href="<?php echo esc_url( $options['google_font_url'] ); ?>" /> <?php // phpcs:ignore ?>
			</noscript>
			<?php
		endif;
	}
);

/**
 * Add the GA tracking code if set.
 *
 * @since 1.0.0
 */
add_action(
	'wp_footer',
	function() {
		if ( current_user_can( 'administrator' ) ) {
			return;
		}

		$options = get_option( HELLO_ELEMENTOR_CHILD_KEY );
		if ( ! empty( $options['ga_tracking_id'] ) ) :
			?>
			<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '<?php echo esc_attr( $options['ga_tracking_id'] ); ?>');
			<?php if ( is_user_logged_in() ) : ?>
				gtag('set', {'user_id': '<?php echo intval( get_current_user_id() ); ?>'}); // Set the user ID using signed-in user_id.
			<?php endif; ?>
			</script>
			<?php
		endif;
	}
);
