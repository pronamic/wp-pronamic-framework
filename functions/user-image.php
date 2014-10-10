<?php

function pronamic_user_image($user) {
	?>
	<h3><?php _e('Media', 'pronamic_framework'); ?></h3>

	<table class="form-table">
		<tr>
			<th>
				<label for="user_image">
					<?php _e('Profile Image', 'pronamic_framework'); ?>
				</label>
			</th>
			<td>
				<?php pronamic_media_select_field( '_pronamic_image_id' , pronamic_get_user_image_id( $user->ID ) ); ?>
				<span class="description"><?php _e('Select an image from the media library. This may be shown publicly.', 'pronamic_framework'); ?></span>
			</td>
		</tr>
	</table>
	<?php
}

add_action('show_user_profile', 'pronamic_user_image');
add_action('edit_user_profile', 'pronamic_user_image');

function pronamic_save_user_image($user_id) {
	$image_id = filter_input(INPUT_POST, '_pronamic_image_id', FILTER_VALIDATE_INT);

	if( empty ( $image_id ) ) {
		delete_user_meta( $user_id , '_pronamic_image_id' );
	} else {
		update_user_meta( $user_id, '_pronamic_image_id', $image_id );
	}
}


add_action('personal_options_update', 'pronamic_save_user_image');
add_action('edit_user_profile_update', 'pronamic_save_user_image');

