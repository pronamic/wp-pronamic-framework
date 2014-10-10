<?php

/**
 * Login form
 */
function pronamic_framework_lostpassword_form( $args = '' ) {
	$args = wp_parse_args( $args, array(
		'redirect_to' => get_permalink()
	) );

	// Globals
	global $pronamic_framework_lostpassword_form_i;

	if ( $pronamic_framework_lostpassword_form_i == null ) {
		$pronamic_framework_lostpassword_form_i = 1;
	}

	$i = $pronamic_framework_lostpassword_form_i++;

	// Output
	$output = '';

	$reset = filter_input( INPUT_GET, 'reset', FILTER_VALIDATE_BOOLEAN );
	if ( $reset ) {
		$output .= '	<div class="notification">';
		$output .= '		' . __( 'Check your e-mail for the confirmation link.', 'pronamic_framework' );
		$output .= '	</div>';
	}

	$output .= '<form method="post" action="' . site_url( 'wp-login.php?action=lostpassword', 'login_post' ) . '" class="wp-user-form">';
	$output .= '	<p class="username">';
	$output .= '		<label for="user_login" class="hide">';
	$output .= '			' . __( 'Username or Email:', 'pronamic_framework' );
	$output .= '		</label>';

	$output .= '		<input type="text" name="user_login" class="input-text" size="40" value="" id="user_login" />';
	$output .= '	</p>';

	$output .= '	<p class="login_fields">';
	$output .= '		<input type="hidden" name="redirect_to" value="' . add_query_arg( 'reset', true, get_permalink() ) . '" />';
	$output .= '		<input type="hidden" name="user-cookie" value="1" />';

	$output .= '		<input type="submit" name="user-submit" value="' . __( 'Reset Password', 'pronamic_framework' ) . '" class="button" />';
	$output .= '	</p>';

	$output .= '</form>';

	return $output;
}

/**
 * Lost password form shortcode
 */
function pronamic_framework_shortcode_lostpassword_form( $atts, $content = null ) {
	$result = '';

	$result = pronamic_framework_lostpassword_form();

	return $result;
}

add_shortcode( 'pronamic_lostpassword_form', 'pronamic_framework_shortcode_lostpassword_form' );
