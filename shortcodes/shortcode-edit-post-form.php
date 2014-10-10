<?php

/**
 * Pronamic framework edit post
 */
function pronamic_framework_shortcode_edit_post_form( $atts, $content = null ) {
	$result = '';

	if ( is_user_logged_in() ) {
		$post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );

		// Post
		$post = get_post( $post_id );
		$post_type = get_post_type( $post_id );
		$post_type_object = get_post_type_object( $post_type );

		if ( $post_type_object ) {
			if ( current_user_can( $post_type_object->cap->edit_posts, $post_id ) ) {
				// Query start
				global $wp_query;

				$query = array(
					'p'         => $post_id,
					'post_type' => 'any',
				);

				$original_query = $wp_query;
				$wp_query = null;
				$wp_query = new WP_Query( $query );

				// Template
				ob_start();

				$template = plugin_dir_path( Pronamic_Framework::$file ) . '/templates/edit-post-form.php';

				load_template( $template, false );

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

add_shortcode( 'pronamic_edit_post_form', 'pronamic_framework_shortcode_edit_post_form' );

function pronamic_framework_maybe_save_post() {
	if ( isset( $_POST['pronamic_framework_edit_post_submit'] ) ) {
		$post_ID = filter_input( INPUT_POST, 'post_ID', FILTER_SANITIZE_NUMBER_INT );

		// Post
		$post_title = filter_input( INPUT_POST, 'post_title', FILTER_SANITIZE_STRING );

		$post_content = filter_input( INPUT_POST, 'post_content', FILTER_UNSAFE_RAW );
		$post_content = wp_kses_post( $post_content );

		$post = array(
			'ID'           => $post_ID,
			'post_title'   => $post_title,
			'post_content' => $post_content,
		);

		$result = wp_update_post( $post );

		if ( 0 !== $result ) {

		} else {

		}

		// Meta
		$meta = filter_input( INPUT_POST, 'post_meta', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post_ID, $key, $value );
		}

		// Attachments
		if ( isset( $_FILES['post_attachments'] ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
			require_once ABSPATH . 'wp-admin/includes/post.php';

			$post_mime_types = get_post_mime_types();

			foreach ( $_FILES['post_attachments']['error'] as $key => $error ) {
				if ( UPLOAD_ERR_OK == $error ) { // no error
					$tmp_name = $_FILES['post_attachments']['tmp_name'][ $key ];
					$name     = $_FILES['post_attachments']['name'][ $key ];

					$bits = file_get_contents( $tmp_name );

					$result = wp_upload_bits( $name, null, $bits );

					if ( false === $result['error'] ) { // no error
						$file_type = wp_check_filetype( $result['file'] );

						$keys = array_keys( wp_match_mime_types( array_keys( $post_mime_types ), $file_type ) );
						$type = array_shift( $keys );

						$attachment = array(
							'post_title'     => $name,
							'post_mime_type' => $file_type['type'],
							'guid'           => $result['url'],
							'post_parent'    => $post_ID,
						);

						$attachment_id = wp_insert_attachment( $attachment, $result['file'], $post_ID );

						$meta_data = wp_generate_attachment_metadata( $attachment_id, $result['file'] );

						$updated = wp_update_attachment_metadata( $attachment_id, $meta_data );

						if ( 'image' == $type ) {
							update_post_meta( $post_ID, '_thumbnail_id', $attachment_id );
						}
					}
				}
			}
		}
	}
}

add_action( 'init', 'pronamic_framework_maybe_save_post' );
