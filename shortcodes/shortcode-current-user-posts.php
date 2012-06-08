<?php

/**
 * Shortcode current user posts
 */
function pronamic_framework_current_user_posts($atts, $content = null) {
	$result = '';

	if(is_user_logged_in()) {
		extract(shortcode_atts(array(
			'query' => array()
		), $atts));

		$user = wp_get_current_user();

		// Query args
		$queryArgs = wp_parse_args($query, array(
			'author' => $user->ID , 
			'posts_per_page' => -1
		));

		query_posts($queryArgs);

		ob_start();
		
		$template = plugin_dir_path(Pronamic_Framework::$file) . '/templates/current-user-posts.php';

		load_template($template, false);
		
		$result = ob_get_clean();

		wp_reset_query();
	}

	return $result;
}

add_shortcode('pronamic_current_user_posts', 'pronamic_framework_current_user_posts');

/**
 * 
 * Enter description here ...
 * @param unknown_type $url
 * @param unknown_type $postId
 * @param unknown_type $context
 */
function pronamic_framework_get_edit_post_link($url, $postId, $context) {
	return $url;
}

add_filter('get_edit_post_link', 'pronamic_framework_get_edit_post_link', 10, 3);
