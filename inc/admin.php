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
		$submenu['themes.php'][] = array(
			__( 'Sass Docs', 'hello-elementor-child' ),
			'edit_themes',
			get_stylesheet_directory_uri() . '/assets/sassdoc/',
		);
	}
}
add_action( 'admin_menu', 'hello_elementor_child_admin_menu' );

/**
 * The theme settings page.
 *
 * @since 1.0.0
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
 * Validates the submitted theme options.
 *
 * @since 1.0.0
 *
 * @param array $input The submitted fields.
 * @return array The validated submitted fields.
 */
function hello_elementor_child_validate_options( $input ) {
	return $input;
}

/**
 * Registers the theme settings.
 *
 * @since 1.0.0
 */
function hello_elementor_child_admin_init() {
	register_setting( 'hello_elementor_child', 'hello_elementor_child', 'hello_elementor_child_validate_options' );

	add_settings_section( 'hello_elementor_child_general_settings', __( 'General Settings', 'hello-elementor-child' ), 'hello_elementor_child_general_settings_cb', 'hello_elementor_child' );

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
			'class'       => 'regular-text',
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
			'placeholder' => __( 'e.g. Copy & paste the Google Fonts URL.', 'hello-elementor-child' ),
			'class'       => 'regular-text',
			'desc'        => 'The Google Fonts URL.',
		)
	);
}
add_action( 'admin_init', 'hello_elementor_child_admin_init' );

/**
 * General settings section output.
 *
 * @since 1.0.0
 */
function hello_elementor_child_general_settings_cb() {
	esc_html_e( 'Configure the theme\'s general settings below.', 'hello-elementor-child' );
}

/**
 * Outputs a theme setting field.
 *
 * @since 1.0.0
 *
 * @param array $args The field arguments.
 */
function hello_elementor_child_field_cb( $args ) {
	$options = get_option( 'hello_elementor_child' );

	switch ( $args['type'] ) {
		case 'url':
		case 'text':
		case 'password':
		case 'number':
		case 'email':
			?>
			<input
				class="<?php echo esc_attr( $args['class'] ); ?>"
				type="<?php echo esc_attr( $args['type'] ); ?>"
				<?php if ( ! empty( $options[ $args['label_for'] ] ) ): ?>
					value="<?php echo esc_attr( $options[ $args['label_for'] ] ); ?>"
				<?php endif; ?>
				<?php if ( ! empty( $args['placeholder'] ) ): ?>
					placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
				<?php endif; ?>
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="hello_elementor_child[<?php echo esc_attr( $args['label_for'] ); ?>]"
			>
			<?php if ( ! empty( $args['suffix'] ) ) : ?>
				<?php echo ' ' . wp_kses( $args['suffix'], array() ); ?>
			<?php endif; ?>
			<p class="description"><?php echo wp_kses( $args['desc'], array() ); ?></p>
			<?php
			break;
		case 'textarea':
			?>
			<textarea
				rows="10"
				class="<?php echo esc_attr( $args['class'] ); ?>"
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="hello_elementor_child[<?php echo esc_attr( $args['label_for'] ); ?>]"
			>
				<?php if ( ! empty( $options[ $args['label_for'] ] ) ) : ?>
					<?php echo esc_attr( $options[ $args['label_for'] ] ); ?>
				<?php endif; ?>
			</textarea>
			<p class="description"><?php echo wp_kses( $args['desc'], array() ); ?></p>
			<?php
			break;
		case 'select':
			?>
			<select name="hello_elementor_child[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] ); ?>">
				<?php foreach ( $args['options'] as $key => $label ) : ?>
					<option value="<?php echo $key; ?>"<?php if ( $key === $options[ $args['label_for'] ] ) : ?>
						selected="selected"
					<?php endif; ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
			<p class="description"><?php echo wp_kses( $args['desc'], array() ); ?></p>
			<?php
			break;
		case 'checkbox':
			?>
			<?php foreach ( $args['options'] as $key => $label ): ?>
				<label for="<?php echo esc_attr( $args['label_for'] . $key ); ?>">
					<input
						type="checkbox"
						<?php if ( ! empty( $args['class'] ) ) : ?>
							class="<?php echo esc_attr( $args['class'] ); ?>"
						<?php endif; ?>
						id="<?php echo esc_attr( $args['label_for'] . $key ); ?>"
						name="hello_elementor_child[<?php echo esc_attr( $args['label_for'] ); ?>]<?php if ( $args['multi'] ): ?>[<?php echo esc_attr( $key ); ?>]<?php endif; ?>"
						value="<?php echo esc_attr( $key ); ?>"
						<?php if ( $args['multi'] && $key === $options[ $args['label_for'] ][ $key ] || ! $args['multi'] && $key === $options[ $args['label_for'] ] ): ?>
							checked="checked"
						<?php endif; ?>
					/> <?php echo wp_kses( $label, array() ); ?>
				</label>
			<?php endforeach; ?>
			<p class="description"><?php echo wp_kses( $args['desc'], array() ); ?></p>
			<?php
			break;
		case 'radio':
			?>
			<?php foreach ( $args['options'] as $key => $label ): ?>
				<label for="<?php echo esc_attr( $args['label_for'] . $key ); ?>">
					<input
						type="radio"
						<?php if ( ! empty( $args['class'] ) ) : ?>
							class="<?php echo esc_attr( $args['class'] ); ?>"
						<?php endif; ?>
						id="<?php echo esc_attr( $args['label_for'] . $key ); ?>"
						name="hello_elementor_child[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $key ); ?>"
						<?php if ( $key === $options[ $args['label_for'] ] ) : ?>
							checked="checked"
						<?php endif; ?>
					/> <?php echo wp_kses( $label, array() ); ?>
				</label><br />
			<?php endforeach; ?>
			<p class="description"><?php echo wp_kses( $args['desc'], array() ); ?></p>
			<?php
			break;
	}
}


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
