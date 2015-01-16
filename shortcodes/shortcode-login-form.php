<?php

/**
 * Handle login
 */
function pronamic_framework_maybe_login() {
	// Initialize global
	global $pronamic_framework_error, $pronamic_framework_login_form_i;

	// Maybe login
	if ( filter_has_var( INPUT_POST, 'action' ) && 'log-in' == filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING ) ) {
		global $pronamic_framework_error;

		$result = wp_signon();

		if ( is_wp_error( $result ) ) {
			$pronamic_framework_error = $result;
		} else {
			wp_set_current_user( $result->ID );

			$redirect_to = filter_input( INPUT_POST, 'redirect_to', FILTER_SANITIZE_URL );

			if ( $redirect_to ) {
				wp_safe_redirect( $redirect_to );

				exit;
			}
		}
	}
}

add_action( 'init', 'pronamic_framework_maybe_login' );

/**
 * Login form
 */
function pronamic_framework_login_form( $args = '' ) {
	$args = wp_parse_args( $args, array(
		'redirect_to' => '',
	) );

	// Output
	$output = '';

	if ( is_user_logged_in() ) {
		$user = wp_get_current_user();

		$output .= '<p class="alert">';
		$output .= sprintf(
			__( 'You are currently logged in as <a href="%1$s" title="%2$s">%2$s</a>.', 'pronamic_framework' ),
			get_author_posts_url( $user->ID ),
			$user->display_name
		);
		$output .= sprintf( '<a href="%s" title="%s">%s</a>',
			esc_attr( wp_logout_url( home_url() ) ),
			esc_attr__( 'Log out of this account', 'pronamic_framework' ),
			esc_attr__( 'Log out &raquo;', 'pronamic_framework' )
		);
		$output .= '</p>';
	} else { // Not logged in
		global $pronamic_framework_error, $pronamic_framework_login_form_i;

		if ( $pronamic_framework_login_form_i == null ) {
			$pronamic_framework_login_form_i = 1;
		}

		$i = $pronamic_framework_login_form_i++;

		$output .= '<form action="" method="post">';
		$output .= '	<p class="login-form-username">';
		$output .= '		<label for="log-field-' . $i. '">';
		$output .= __( 'Username', 'pronamic_framework' );
		$output .= '		</label>';

		$output .= '		<input id="log-field-' . $i. '" name="log" type="text" class="text-input" value="' . esc_attr( filter_input( INPUT_POST, 'log', FILTER_SANITIZE_STRING ) ) . '" />';
		$output .= '	</p>';

		$output .= '	<p class="login-form-password">';
		$output .= '		<label for="pwd-field-' . $i. '">';
		$output .= __( 'Password', 'pronamic_framework' );
		$output .= '		</label>';

		$output .= '		<input id="pwd-field-' . $i. '" name="pwd" type="password" class="text-input" value="' . esc_attr( filter_input( INPUT_POST, 'pwd', FILTER_SANITIZE_STRING ) ) . '" />';
		$output .= '	</p>';

		if ( is_wp_error( $pronamic_framework_error ) ) {
			$output .= '<p class="error">';

			if ( $message = $pronamic_framework_error->get_error_message() ) {
				$output .= $message;
			} else {
				$output .= __( 'An unknown error has occurred.', 'pronamic_framework' );
			}

			$output .= '</p>';
		}

		$output .= '	<p class="login-form-submit">';

		$redirect_to = $args['redirect_to'];

		$value = filter_input( INPUT_GET, 'redirect_to', FILTER_SANITIZE_STRING );
		if ( ! empty( $value ) ) {
			$redirect_to = $value;
		}

		$value = filter_input( INPUT_SERVER, 'HTTP_REFERER', FILTER_SANITIZE_STRING );
		if ( $redirect_to == 'referer' && !empty($value) ) {
			$redirect_to = $value;
		}

		$output .= '		<input type="hidden" name="redirect_to" value="' . esc_attr( $redirect_to ) . '" />';
		$output .= '		<input type="hidden" name="action" value="log-in" />';
		$output .= '		<input type="submit" name="submit" class="submit button" value="' . esc_attr__( 'Log in', 'pronamic_framework' ) . '" />';
		$output .= '		<input id="rememberme-field-' . $i. '" name="rememberme"  type="checkbox" class="remember-me checkbox" checked="checked" value="forever" />';

		$output .= '		<label for="rememberme-field-' . $i. '">';
		$output .= __( 'Remember me', 'pronamic_framework' );
		$output .= '		</label>';
		$output .= '	</p>';
		$output .= '</form>';
	}

	return $output;
}

/**
 * Login shortcocde
 */
function pronamic_framework_shortcode_login_form( $atts, $content = null ) {
	$result = '';

	extract( shortcode_atts( array(
		'redirect_to' => null,
	), $atts ) );

	if ( ! is_user_logged_in() ) {
		$args = array(
			'redirect_to' => $redirect_to,
			'echo'        => false,
		);

		$result = pronamic_framework_login_form( $args );
	}

	return $result;
}

add_shortcode( 'pronamic_login_form', 'pronamic_framework_shortcode_login_form' );
