<?php
/**
 * Admin functionality
 *
 * @package HelloElementor
 * @subpackage HelloElementorChild
 * @since 1.0.0
 */

/**
 * Add admin menu links.
 *
 * @since 1.0.0
 */
function hello_elementor_child_admin_menu() {
  global $submenu;

  // Add the Sass Docs link if available
  if ( is_dir( HELLO_ELEMENTOR_CHILD_DIRECTORY . '/assets/sassdoc' ) ) {
    $submenu['themes.php'][] = [
      __( 'Sass Docs', 'hello-elementor-child' ),
      'edit_themes',
      get_stylesheet_directory_uri() . '/assets/sassdoc/'
    ];
  }
}
add_action('admin_menu', 'hello_elementor_child_admin_menu');
