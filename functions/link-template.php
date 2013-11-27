<?php 

if ( !function_exists( 'delete_post_link' ) ) {
	/**
	 * Display edit post link for post.
	 *
	 * @since 1.0.0
	 *
	 * @param string $link Optional. Anchor text.
	 * @param string $before Optional. Display before edit link.
	 * @param string $after Optional. Display after edit link.
	 * @param int $id Optional. Post ID.
	 */
	function delete_post_link( $link = null, $before = '', $after = '', $id = 0 ) {
		if ( !$post = get_post( $id ) )
			return;
	
		if ( !$url = get_delete_post_link( $post->ID ) )
			return;
	
		if ( null === $link )
			$link = __( 'Delete This', 'pronamic_framework' );
	
		$post_type_obj = get_post_type_object( $post->post_type );
		$link = '<a class="post-delete-link" href="' . $url . '">' . $link . '</a>';
		echo $before . apply_filters( 'delete_post_link', $link, $post->ID ) . $after;
	}
}