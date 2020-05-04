<?php
/**
 * Theme CSS & JS scripts
 *
 * @package HelloElementor
 * @subpackage HelloElementorChild
 * @since 1.0.0
 */

/**
 * Register & enqueue theme CSS & JS files
 *
 * @since 1.0.0
 */
function hello_elementor_child_scripts() {
  // CSS
  wp_enqueue_style( 'hello-elementor-child-core', get_stylesheet_directory_uri() . '/assets/css/core.css', [], wp_get_theme()->get( 'Version' ) );
  wp_enqueue_style( 'hello-elementor-child-global', get_stylesheet_directory_uri() . '/assets/css/global.css', [], wp_get_theme()->get( 'Version' ) );
  wp_enqueue_style( 'hello-elementor-child-elementor', get_stylesheet_directory_uri() . '/assets/css/add-ons/wordpress/elementor.css', [], wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts', PHP_INT_MAX );
