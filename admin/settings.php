<div class="wrap">
	<?php screen_icon(); ?>

	<h2>
		<?php _e('Pronamic', 'pronamic_framework'); ?>
	</h2>

	<form method="post" action="options.php">
		<?php 

		// @doc http://codex.wordpress.org/Function_Reference/settings_fields
		settings_fields('pronamic-framework'); 

		?>

		<h3>
			<?php _e('Pages', 'horses'); ?>
		</h3>

		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="pronamic_framework_edit_post_page_id"><?php _e('Edit Post Page', 'pronamic_framework'); ?></label>
				</th>
				<td>
					<?php 

					wp_dropdown_pages(array(
						'name' => 'pronamic_framework_edit_post_page_id' , 
						'selected' => get_option('pronamic_framework_edit_post_page_id', '') ,  
						'show_option_none' => __('&mdash; Select a page &mdash;', 'pronamic_framework') 
					)); 

					?>
				</td>
			</tr>
		</table>

		<?php submit_button(); ?>
	</form>
</div>