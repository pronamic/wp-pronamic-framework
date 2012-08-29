<div class="wrap">
	<?php screen_icon(); ?>

	<h2>
		<?php _e( 'Pronamic', 'pronamic_framework' ); ?>
	</h2>

	<form method="post" action="options.php">
		<?php 

		// @doc http://codex.wordpress.org/Function_Reference/settings_fields
		settings_fields( 'pronamic-framework' ); 

		?>

		<h3>
			<?php _e( 'Pages', 'pronamic_framework' ); ?>
		</h3>

		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="pronamic_framework_login_page_id"><?php _e( 'Login Page', 'pronamic_framework' ); ?></label>
				</th>
				<td>
					<?php 

					wp_dropdown_pages( array(
						'name'             => 'pronamic_framework_login_page_id' , 
						'selected'         => get_option( 'pronamic_framework_login_page_id', '' ) ,  
						'show_option_none' => __( '&mdash; Select a page &mdash;', 'pronamic_framework' ) 
					) ); 

					?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="pronamic_framework_logout_page_id"><?php _e( 'Logout Page', 'pronamic_framework' ); ?></label>
				</th>
				<td>
					<?php 

					wp_dropdown_pages( array(
						'name'             => 'pronamic_framework_logout_page_id' , 
						'selected'         => get_option( 'pronamic_framework_logout_page_id', '' ) ,  
						'show_option_none' => __( '&mdash; Select a page &mdash;', 'pronamic_framework' ) 
					) ); 

					?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="pronamic_framework_lostpassword_page_id"><?php _e( 'Lost Password Page', 'pronamic_framework' ); ?></label>
				</th>
				<td>
					<?php 

					wp_dropdown_pages( array(
						'name'             => 'pronamic_framework_lostpassword_page_id' , 
						'selected'         => get_option( 'pronamic_framework_lostpassword_page_id', '' ) ,  
						'show_option_none' => __( '&mdash; Select a page &mdash;', 'pronamic_framework' ) 
					) ); 

					?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="pronamic_framework_edit_post_page_id"><?php _e( 'Edit Post Page', 'pronamic_framework' ); ?></label>
				</th>
				<td>
					<?php 

					wp_dropdown_pages( array(
						'name'             => 'pronamic_framework_edit_post_page_id' , 
						'selected'         => get_option( 'pronamic_framework_edit_post_page_id', '' ) ,  
						'show_option_none' => __( '&mdash; Select a page &mdash;', 'pronamic_framework' ) 
					) ); 

					?>
				</td>
			</tr>
		</table>

		<h3>
			<?php _e( 'HTML', 'pronamic_framework' ); ?>
		</h3>

		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="pronamic_framework_html_head"><?php _e( 'Head', 'pronamic_framework' ); ?></label>
				</th>
				<td>
					<textarea id="pronamic_framework_html_head" name="pronamic_framework_html_head" rows="10" cols="60"><?php echo esc_textarea( get_option( 'pronamic_framework_html_head' ) ); ?></textarea>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="pronamic_framework_html_footer"><?php _e( 'Footer', 'pronamic_framework' ); ?></label>
				</th>
				<td>
					<textarea id="pronamic_framework_html_footer" name="pronamic_framework_html_footer" rows="10" cols="60"><?php echo esc_textarea( get_option( 'pronamic_framework_html_footer' ) ); ?></textarea>
				</td>
			</tr>
		</table>

		<?php 
		
		$post_types = get_post_types( array(), 'objects' );

		if ( ! empty( $post_types ) ): ?>

			<h3>
				<?php _e( 'Post Type Descriptions', 'pronamic_framework' ); ?>
			</h3>
	
			<table class="form-table">
				<?php foreach ( $post_types as $post_type ): ?>
					<tr>
						<?php $name = 'pronamic_framework_post_type_description_' . $post_type->name; ?>
	
						<th scope="row">
							<label for="<?php echo $name; ?>">
								<?php echo isset( $post_type->label ) ? $post_type->label : $post_type->name; ?>
							</label>
						</th>
						<td>
							<?php wp_editor( get_option( $name, '' ), $name ); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>

		<?php endif; ?>

		<?php submit_button(); ?>
	</form>
</div>