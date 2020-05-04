<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 * @subpackage HelloElementorChild
 * @since 1.0.0
 */

// Define theme constants
define('HELLO_ELEMENTOR_CHILD_DIRECTORY', dirname(__FILE__) . '/');

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

/**
 * Include theme shortcodes.
 */
require_once get_stylesheet_directory() . '/inc/shortcodes.php';

/**
 * Include Elementor functionality.
 */
require_once get_stylesheet_directory() . '/inc/elementor.php';
