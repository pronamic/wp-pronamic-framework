<?php if(have_posts()): ?>

<div>

	<?php while(have_posts()): the_post(); ?>

	<form method="post" action="">
		<input type="hidden" id="post_ID" name="post_ID" value="<?php esc_attr( get_the_ID() ); ?>" />

		<p>
			<label for="pronamic_framework_post_title_field"><?php _e('Title:', 'pronamic_framework'); ?></label>

			<input id="pronamic_framework_post_title_field" type="text" name="post_title" size="30" tabindex="1" value="<?php echo esc_attr( htmlspecialchars( get_the_title() ) ); ?>" autocomplete="off" />
		</p>

		<p>
			<input type="submit" name="pronamic_framework_edit_post_submit" value="<?php esc_attr_e('Update', 'pronamic_framework' ); ?>" />
		</p>
	</form>

	<?php endwhile; ?>

</div>	

<?php else: ?>



<?php endif; ?>