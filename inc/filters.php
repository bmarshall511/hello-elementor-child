<?php
/**
 * Theme filters
 *
 * @package HelloElementor
 * @subpackage HelloElementorChild
 */

add_action(
	'init',
	function() {
		$options = get_option( HELLO_ELEMENTOR_CHILD_KEY );

		if ( ! empty( $options['hide_title'] ) && 'on' === $options['hide_title'] ) {
			add_filter( 'hello_elementor_page_title', '__return_false' );
		}
	}
);
