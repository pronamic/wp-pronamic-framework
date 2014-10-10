<?php

global $post;

if ( have_posts() ) : ?>

<div>

	<?php while ( have_posts() ) : the_post(); ?>

	<form <?php post_class(); ?> method="post" action="" enctype="multipart/form-data">
		<input type="hidden" id="post_ID" name="post_ID" value="<?php echo esc_attr( $post->ID ); ?>" />

		<p>
			<label for="pronamic_framework_post_title_field"><?php _e( 'Title:', 'pronamic_framework' ); ?></label>

			<input id="pronamic_framework_post_title_field" type="text" name="post_title" size="30" tabindex="1" value="<?php echo esc_attr( htmlspecialchars( get_the_title() ) ); ?>" autocomplete="off" />
		</p>

		<p class="profile">
			<?php

			wp_editor( $post->post_content , 'post_content' , array( 'media_buttons' => false ) );

			?>
		</p>

		<p class="image">
			<label for="pronamic_framework_thumbnail_field"><?php _e( 'Image:', 'pronamic_framework' ); ?></label>

			<input id="pronamic_framework_thumbnail_field" type="file" name="post_attachments[]" />
		</p>

		<?php do_action( 'pronamic_framework_edit_post_form_after_fields' ); ?>

		<p>
			<input type="submit" name="pronamic_framework_edit_post_submit" value="<?php esc_attr_e( 'Update', 'pronamic_framework' ); ?>" />
		</p>
	</form>

	<?php endwhile; ?>

</div>

<?php else: ?>

<p>
	<?php _e( 'You attempted to edit an item that doesn&#8217;t exist. Perhaps it was deleted?', 'pronamic_framework' ); ?>
</p>

<?php endif; ?>