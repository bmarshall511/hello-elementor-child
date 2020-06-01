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

/**
 * Update the default login logo with the site logo if available.
 *
 * @since 1.0.0
 */
function hello_elementor_child_login() {
  $logo = get_theme_mod( 'custom_logo' );

  if ( ! $logo ) { return; }

  $image = wp_get_attachment_image_src( $logo, 'full' );
  ?>
  <style type="text/css">
  #login h1 a, .login h1 a {
    background-image: url('<?php echo $image[0]; ?>');
    background-size: contain;
    height: 25px;
    width: 320px;
    background-repeat: no-repeat;
  }
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'hello_elementor_child_login' );

/**
 * Filter the login logo URL.
 *
 * @since 1.0.0
 */
function hello_elementor_child_logo_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'hello_elementor_child_logo_url' );

/**
 * Filter the login logo title.
 *
 * @since 1.0.0
 */
function hello_elementor_child_logo_url_title() {
  return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'hello_elementor_child_logo_url_title' );

/**
 * Enqueue admin & login scripts.
 *
 * @since 1.0.0
 */
function hello_elementor_child_login_scripts() {
  wp_enqueue_style( 'hello-elementor-child-login', get_stylesheet_directory_uri() . '/assets/css/add-ons/wordpress/login.css', [], wp_get_theme()->get( 'Version' ) );
}
add_action( 'login_enqueue_scripts', 'hello_elementor_child_login_scripts' );
