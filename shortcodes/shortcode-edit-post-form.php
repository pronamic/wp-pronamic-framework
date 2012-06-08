<?php

/**
 * Pronamic framework edit post
 */
function pronamic_framework_edit_post($atts, $content = null) {
	$result = '';

	if(is_user_logged_in()) {
		$post_id = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);

		// Post
		$post = get_post($post_id);
		$post_type = get_post_type($post_id);
		$post_type_object = get_post_type_object($post_type);

		if( $post_type_object ) {
			if ( current_user_can( $post_type_object->cap->edit_posts, $post_id ) ) {
				// Query start
				global $wp_query;

				$query = array(
					'p' => $post_id
				);
		
				$original_query = $wp_query;
				$wp_query = null;
				$wp_query = new WP_Query($query);
		
				// Template
				ob_start();
		
				$template = plugin_dir_path(Pronamic_Framework::$file) . '/templates/edit-post-form.php';
		
				load_template($template, false);
				
				$result = ob_get_clean();
		
				// Query end
				$wp_query = null;
				$wp_query = $original_query;
				wp_reset_postdata();
			}
		}
	}

	return $result;
}

add_shortcode('pronamic_edit_post', 'pronamic_framework_edit_post');

function pronamic_framework_maybe_save_post() {
	if(isset($_POST['pronamic_framework_edit_post_submit'])) {
		$post_ID = filter_input(INPUT_POST, 'post_ID', FILTER_SANITIZE_NUMBER_INT);
		$post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_STRING);

		$post = array(
			'ID' => $post_ID , 
			'post_title' => $post_title 
		);

		$result = wp_insert_post($post, true);

		if(is_wp_error($result)) {
			
		} else {
			
		}
	}
}

add_action('init', 'pronamic_framework_maybe_save_post');
