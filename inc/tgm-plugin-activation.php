<?php
/**
 * Contains the TGM Plugin Activation configuration for required & recommended
 * plugins.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage HelloElementorChild
 * @version    2.6.1 for child theme Hello Elementor Child
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_stylesheet_directory() . '/classes/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'hello_elementor_child_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function hello_elementor_child_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = [
		[
			'name'      => 'Akismet Anti-Spam',
			'slug'      => 'akismet',
			'required'  => false,
    ],
    [
			'name'      => 'Wordfence Security – Firewall & Malware Scan',
			'slug'      => 'wordfence',
			'required'  => false,
    ],
    [
			'name'      => 'Google Analytics for WordPress by MonsterInsights',
			'slug'      => 'google-analytics-for-wordpress',
			'required'  => false,
    ],
    [
			'name'      => 'Regenerate Thumbnails',
			'slug'      => 'regenerate-thumbnails',
			'required'  => false,
    ],
    [
			'name'      => 'Elementor Page Builder',
			'slug'      => 'elementor',
			'required'  => false,
    ],
    [
			'name'      => 'Redirection',
			'slug'      => 'redirection',
			'required'  => false,
    ],
    [
			'name'      => 'WP Mail SMTP by WPForms',
			'slug'      => 'wp-mail-smtp',
			'required'  => false,
    ],
    [
			'name'      => 'WP-Optimize',
			'slug'      => 'wp-optimize',
			'required'  => false,
    ],
    [
			'name'        => 'Advanced Custom Fields',
      'slug'        => 'advanced-custom-fields',
      'is_callable' => 'acf',
			'required'    => true,
    ],
    [
			'name'        => 'WPS Hide Login',
      'slug'        => 'wps-hide-login',
			'required'    => false,
    ],
		[
			'name'        => 'WordPress SEO by Yoast',
			'slug'        => 'wordpress-seo',
      'is_callable' => 'wpseo_init',
      'required'    => false,
    ],
    [
			'name'        => 'SVG Support',
      'slug'        => 'svg-support',
			'required'    => false,
    ],
  ];

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'hello-elementor-child',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'hello-elementor-child' ),
			'menu_title'                      => __( 'Install Plugins', 'hello-elementor-child' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'hello-elementor-child' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'hello-elementor-child' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'hello-elementor-child' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'hello-elementor-child'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'hello-elementor-child'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'hello-elementor-child'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'hello-elementor-child'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'hello-elementor-child'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'hello-elementor-child'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'hello-elementor-child'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'hello-elementor-child'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'hello-elementor-child'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'hello-elementor-child' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'hello-elementor-child' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'hello-elementor-child' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'hello-elementor-child' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'hello-elementor-child' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'hello-elementor-child' ),
			'dismiss'                         => __( 'Dismiss this notice', 'hello-elementor-child' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'hello-elementor-child' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'hello-elementor-child' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}
