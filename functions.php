<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 * @subpackage HelloElementorChild
 */

// Define theme constants.
define( 'HELLO_ELEMENTOR_CHILD_VERSION', '1.0.0' );
define( 'HELLO_ELEMENTOR_CHILD_KEY', 'hello_elementor_child' );
define( 'HELLO_ELEMENTOR_CHILD_DIRECTORY', dirname( __FILE__ ) . '/' );

/**
 * Vendor files
 */
require get_stylesheet_directory() . '/vendor/autoload.php';

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_stylesheet_directory() . '/inc/tgm-plugin-activation.php';

/**
 * Include theme scripts where all CSS & JS is registered & enqueued.
 */
require_once get_stylesheet_directory() . '/inc/scripts.php';

/**
 * Include admin functionality.
 */
require_once get_stylesheet_directory() . '/inc/admin.php';

/**
 * Include theme filters.
 */
require_once get_stylesheet_directory() . '/inc/filters.php';
