<?php

/**
 * Shortcode current user posts
 */
function pronamic_framework_current_user_posts($atts, $content = null) {
	$result = '';

	// Globals set
	$GLOBALS['pronamic_framework_is_current_user_posts'] = true;

	if(is_user_logged_in()) {
		extract(shortcode_atts(array(
			'query' => array()
		), $atts));

		$user = wp_get_current_user();

		// Query args
		if(is_string($query)) {
			$query = html_entity_decode($query);
		}

		$queryArgs = wp_parse_args($query, array(
			'author' => $user->ID , 
			'posts_per_page' => -1
		));

		// Query start
		global $wp_query;

		$original_query = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query($queryArgs);

		// Template
		ob_start();
		
		$template = plugin_dir_path(Pronamic_Framework::$file) . '/templates/current-user-posts.php';

		load_template($template, false);
		
		$result = ob_get_clean();

		// Query end
		$wp_query = null;
		$wp_query = $original_query;
		wp_reset_postdata();
	}

	// Globals unset
	unset($GLOBALS['pronamic_framework_is_current_user_posts']);

	return $result;
}

add_shortcode('pronamic_current_user_posts', 'pronamic_framework_current_user_posts');

function pronamic_framework_is_current_user_posts() {
	global $pronamic_framework_is_current_user_posts;

	return $pronamic_framework_is_current_user_posts;
}

/**
 * 
 * Enter description here ...
 * @param unknown_type $url
 * @param unknown_type $postId
 * @param unknown_type $context
 */
function pronamic_framework_get_edit_post_link($url, $postId, $context) {
	if(pronamic_framework_is_current_user_posts()) {
		$editPostPageId = get_option('pronamic_framework_edit_post_page_id');

		if(!empty($editPostPageId)) {
			$link = get_permalink($editPostPageId);

			if($link) {
				$url = add_query_arg('post', $postId, $link);
			}
		}
	}

	return $url;
}

add_filter('get_edit_post_link', 'pronamic_framework_get_edit_post_link', 10, 3);
