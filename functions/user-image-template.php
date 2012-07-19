<?php
/**
 * Pronamic User Image Template Functions
 * 
 * @see http://core.trac.wordpress.org/browser/tags/3.4.1/wp-includes/post-thumbnail-template.php
 */

/**
 * Check if user has an image attached.
 * 
 * @param int $user_id
 * @return bool Whether user has an image attached.
 */
function pronamic_has_user_image( $user_id = null ) {
	return (bool) pronamic_get_user_image_id( $user_id );
}

/**
 * Retrieve User Image ID.
 * 
 * @param int $user_id
 * @return int
 */
function pronamic_get_user_image_id( $user_id = null ) {
	$user_id = ( null === $user_id ) ? get_the_author_meta('ID') : $user_id;

	return get_user_meta( $user_id, '_pronamic_image_id', true );
}

/**
 * Display User Image.
 * 
 * @param string|array $size
 * @param string|array $attr
 */
function pronamic_the_user_image( $size = 'post-thumbnail', $attr = '') {
	echo pronamic_get_the_user_image( null, $size, $attr );
}

/**
 * Retrieve User Image.
 * 
 * @param int $user_id
 * @param string|array $size
 * @param string|array $attr
 */
function pronamic_get_the_user_image( $user_id = null, $size = 'post-thumbnail', $attr = '' ) {
	$user_id = ( null === $user_id ) ? get_the_author_meta('ID') : $user_id;

	$user_image_id = pronamic_get_user_image_id( $user_id );

	if ( $user_image_id ) {
		$html = wp_get_attachment_image( $user_image_id, $size, false, $attr );
	} else {
		$html = '';
	}

	return $html;
}
