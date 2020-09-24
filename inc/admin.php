<?php
/**
 * Admin functionality
 *
 * @package HelloElementor
 * @subpackage HelloElementorChild
 */

/**
 * Add admin menu links.
 */
function hello_elementor_child_admin_menu() {
	global $submenu;

	add_submenu_page(
		'themes.php',
		__( 'Theme Settings', 'hello-elementor-child' ),
		__( 'Theme Settings', 'hello-elementor-child' ),
		'manage_options',
		'hello-elementor-child-settings',
		'hello_elementor_child_settings_page'
	);

	// Add the Sass Docs link if available.
	if ( is_dir( HELLO_ELEMENTOR_CHILD_DIRECTORY . '/assets/sassdoc' ) ) {
		$submenu['themes.php'][] = array( // phpcs:ignore
			__( 'Sass Docs', 'hello-elementor-child' ),
			'edit_themes',
			get_stylesheet_directory_uri() . '/assets/sassdoc/',
		);
	}
}
add_action( 'admin_menu', 'hello_elementor_child_admin_menu' );

/**
 * The theme settings page.
 */
function hello_elementor_child_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
		<?php
		settings_fields( 'hello_elementor_child' );
		do_settings_sections( 'hello_elementor_child' );
		submit_button( 'Save Settings' );
		?>
		</form>
	</div>
	<?php
}

/**
 * Registers the theme settings.
 */
function hello_elementor_child_admin_init() {
	register_setting( 'hello_elementor_child', 'hello_elementor_child', 'hello_elementor_child_validate_options' );

	add_settings_section( 'hello_elementor_child_general_settings', __( 'General Settings', 'hello-elementor-child' ), 'hello_elementor_child_general_settings', 'hello_elementor_child' );

	// Hide page titles.
	add_settings_field(
		'hide_title',
		__( 'Hide Page/Post Titles', 'hello-elementor-child' ),
		'hello_elementor_child_field_cb',
		'hello_elementor_child',
		'hello_elementor_child_general_settings',
		array(
			'label_for' => 'hide_title',
			'type'      => 'checkbox',
			'desc'      => 'Hide default post and page titles.',
			'options'   => array(
				'on' => __( 'Enabled', 'hello-elementor-child' ),
			),
		)
	);

	// Google Analytics tracking ID.
	add_settings_field(
		'ga_tracking_id',
		__( 'Google Analytics Tracking ID', 'hello-elementor-child' ),
		'hello_elementor_child_field_cb',
		'hello_elementor_child',
		'hello_elementor_child_general_settings',
		array(
			'label_for'   => 'ga_tracking_id',
			'type'        => 'text',
			'placeholder' => __( 'e.g. UA-XXXXXXXX-X', 'hello-elementor-child' ),
			'field_class' => 'regular-text',
			'desc'        => 'Enter the sites\' Google Analytics tracking ID.',
		)
	);

	// Google Font URL.
	add_settings_field(
		'google_font_url',
		__( 'Google Fonts URL', 'hello-elementor-child' ),
		'hello_elementor_child_field_cb',
		'hello_elementor_child',
		'hello_elementor_child_general_settings',
		array(
			'label_for'   => 'google_font_url',
			'type'        => 'url',
			'placeholder' => __( 'https://fonts.googleapis.com/css2?family=XXX&display=swap', 'hello-elementor-child' ),
			'field_class' => 'regular-text',
			'desc'        => __( 'Copy & paste the Google Fonts URL. <strong>Note:</strong> Elementor integrates with Google Fonts. This setting is only needed for advanced theming and optimization.', 'hello-elementor-child' ),
		)
	);
}
add_action( 'admin_init', 'hello_elementor_child_admin_init' );

/**
 * Output for the admin settings section.
 */
function hello_elementor_child_general_settings() {}

/**
 * Outputs a theme setting field.
 *
 * @param array $args The field arguments.
 */
function hello_elementor_child_field_cb( $args ) {
	$options = get_option( 'hello_elementor_child' );

	$value = $options[ $args['label_for'] ];
	$name  = HELLO_ELEMENTOR_CHILD_KEY . '[' . $args['label_for'] . ']';

	switch ( $args['type'] ) {
		case 'checkbox':
		case 'radio':
			foreach ( $args['options'] as $key => $label ) {
				$checked = false;
				$id      = $args['label_for'] . '_' . $key;
				if ( ! empty( $args['multi'] ) ) {
					$name .= '[' . $key . ']';
				}

				if ( ! empty( $args['multi'] ) && $key === $value[ $key ] || $key === $value ) {
					$checked = true;
				}
				?>
				<label for="<?php echo esc_attr( $id ); ?>">
					<input
						type="<?php echo esc_attr( $args['type'] ); ?>"
						id="<?php echo esc_attr( $id ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						<?php if ( $checked ) : ?>
							checked="checked"
						<?php endif; ?>
						value="<?php echo esc_attr( $key ); ?>"
					/>
					<?php
					echo wp_kses(
						$label,
						array(
							'a'    => array(
								'href'   => array(),
								'target' => array(),
								'rel'    => array(),
							),
							'code' => array(),
						)
					);
					?><br />
				</label>
				<?php
			}
			break;
		case 'text':
		case 'url':
		case 'password':
		case 'email':
		case 'number':
			?>
			<input
				type="<?php echo esc_attr( $args['type'] ); ?>"
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="<?php echo esc_attr( $name ); ?>"
				value="<?php echo esc_attr( $value ); ?>"
				<?php if ( ! empty( $args['placeholder'] ) ) : ?>
					placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
				<?php endif; ?>
				<?php if ( ! empty( $args['field_class'] ) ) : ?>
					class="<?php echo esc_attr( $args['field_class'] ); ?>"
				<?php endif; ?>
			/>
			<?php
			break;
	}

	if ( ! empty( $args['suffix'] ) ) {
		echo esc_html( $args['suffix'] );
	}

	if ( ! empty( $args['desc'] ) ) {
		echo '<p class="description">' . wp_kses(
			$args['desc'],
			array(
				'a' => array(
					'target' => array(),
					'rel'    => array(),
					'href'   => array(),
				),
				'strong' => array(),
			)
		) . '</p>';
	}
}

/**
 * Update the default login logo with the site logo if available.
 */
function hello_elementor_child_login() {
	$logo = get_theme_mod( 'custom_logo' );

	if ( ! $logo ) {
		return;
	}

	$image = wp_get_attachment_image_src( $logo, 'full' );
	?>
	<style type="text/css">
	#login h1 a, .login h1 a {
		background-image: url('<?php echo esc_url( $image[0] ); ?>');
		background-size: contain;
		height: 25px;
		width: 320px;
		background-repeat: no-repeat;
	}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'hello_elementor_child_login' );

/**
 * Filter the login logo URL.
 */
function hello_elementor_child_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'hello_elementor_child_logo_url' );

/**
 * Filter the login logo title.
 */
function hello_elementor_child_logo_url_title() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'hello_elementor_child_logo_url_title' );

/**
 * Enqueue admin & login scripts.
 */
function hello_elementor_child_login_scripts() {
	//wp_enqueue_style( 'hello-elementor-child-login', get_stylesheet_directory_uri() . '/assets/css/pages/wordpress-login.css', array(), HELLO_ELEMENTOR_CHILD_VERSION );
}
add_action( 'login_enqueue_scripts', 'hello_elementor_child_login_scripts' );
