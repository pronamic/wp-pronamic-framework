<div class="wrap">
	<h1><?php esc_html_e( 'Pronamic', 'pronamic_framework' ); ?></h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'pronamic_framework' ); ?>

		<?php do_settings_sections( 'pronamic_framework' ); ?>

		<?php submit_button(); ?>
	</form>
</div>
