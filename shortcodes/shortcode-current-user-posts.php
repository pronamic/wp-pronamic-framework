<?php

/**
 * Shortcode current user posts
 */
function pronamic_framework_current_user_posts( $atts, $content = null ) {
	$result = '';

	// Globals set
	$GLOBALS['pronamic_framework_is_current_user_posts'] = true;

	if ( is_user_logged_in() ) {
		extract( shortcode_atts( array(
			'query' => array()
		), $atts ) );

		$user = wp_get_current_user();

		// Query args
		if ( is_string( $query ) ) {
			$query = html_entity_decode( $query );
		}

		$query_args = wp_parse_args( $query, array(
			'author'         => $user->ID, 
			'posts_per_page' => -1
		) );

		// Query start
		global $wp_query;

		$original_query = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query( $query_args );

		// Template
		ob_start();
		
		$templates = array();
		$templates[] = 'pronamic-current-user-posts.php';

		$template = locate_template( $templates );

		if ( !$template ) {
			$template = plugin_dir_path( Pronamic_Framework::$file ) . '/templates/current-user-posts.php';
		}

		load_template( $template, false );
		
		$result = ob_get_clean();

		// Query end
		$wp_query = null;
		$wp_query = $original_query;
		wp_reset_postdata();
	}

	// Globals unset
	unset( $GLOBALS['pronamic_framework_is_current_user_posts'] );

	return $result;
}

add_shortcode( 'pronamic_current_user_posts', 'pronamic_framework_current_user_posts' );

function pronamic_framework_is_current_user_posts() {
	global $pronamic_framework_is_current_user_posts;

	return $pronamic_framework_is_current_user_posts;
}

/**
 * Get edit post link
 * 
 * @param string $url
 * @param string $postId
 * @param string $context
 */
function pronamic_framework_get_edit_post_link( $url, $post_id, $context ) {
	if ( pronamic_framework_is_current_user_posts() ) {
		$edit_post_page_id = get_option( 'pronamic_framework_edit_post_page_id' );

		if ( !empty( $edit_post_page_id ) ) {
			$link = get_permalink( $edit_post_page_id );

			if ( $link ) {
				$key = get_option( 'pronamic_framework_edit_post_id_key', __( 'post', 'pronamic_framework' ) );

				$url = add_query_arg( $key, $post_id, $link );
			}
		}
	}

	return $url;
}

add_filter( 'get_edit_post_link', 'pronamic_framework_get_edit_post_link', 10, 3 );
