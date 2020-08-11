<?php
/**
 * Theme CSS & JS scripts
 *
 * @package HelloElementor
 * @subpackage HelloElementorChild
 * @since 1.0.0
 */

use MatthiasMullie\Minify;

/**
 * Register & enqueue theme CSS & JS files.
 *
 * @since 1.0.0
 */
function hello_elementor_child_scripts() {
  // Non-critial CSS, loaded on every page.
  wp_enqueue_style( 'hello-elementor-child-non-critical', get_stylesheet_directory_uri() . '/assets/css/non-critical.css', [], wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts', PHP_INT_MAX );

/**
 * Inline critical (above page fold) CSS.
 *
 * @since 1.0.0
 *
 * @return string HTML style tag & styles output for the critical CSS.
 */
function hello_elementor_child_critical_path_css() {
  $minifier = new Minify\CSS( get_stylesheet_directory() . '/assets/css/critical.css' );
  ob_start();
  ?>
  <style>
    <?php echo $minifier->minify(); ?>
  </style>
  <?php
  echo ob_get_clean();
}
add_action( 'wp_head', 'hello_elementor_child_critical_path_css' );
