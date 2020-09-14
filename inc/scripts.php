<?php
/**
 * Theme CSS & JS scripts
 *
 * @package HelloElementor
 * @subpackage HelloElementorChild
 */

use MatthiasMullie\Minify;

/**
 * Register & enqueue theme CSS & JS files.
 */
function hello_elementor_child_scripts() {
	// Non-critial CSS, loaded on every page.
	wp_enqueue_style( 'hello-elementor-child-non-critical', get_stylesheet_directory_uri() . '/assets/css/non-critical.css', array(), HELLO_ELEMENTOR_CHILD_VERSION );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts', PHP_INT_MAX );

/**
 * Inline critical (above page fold) CSS.
 */
function hello_elementor_child_critical_path_css() {
	$minifier = new Minify\CSS( get_stylesheet_directory() . '/assets/css/critical.css' );
	ob_start();
	?>
	<style>
		<?php echo $minifier->minify(); // phpcs:ignore ?>
	</style>
	<?php
	echo ob_get_clean(); // phpcs:ignore
}
add_action( 'wp_head', 'hello_elementor_child_critical_path_css' );
