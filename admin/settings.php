<div class="wrap">
	<?php screen_icon(); ?>

	<h2>
		<?php _e( 'Pronamic', 'pronamic_framework' ); ?>
	</h2>

	<form method="post" action="options.php">
		<?php settings_fields( 'pronamic_framework' ); ?>

		<?php do_settings_sections( 'pronamic_framework' ); ?>

		<?php submit_button(); ?>
	</form>
</div>