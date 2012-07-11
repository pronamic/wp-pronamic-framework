<?php

function pronamic_admin_enqueue_scripts($hook_suffix) {
	wp_enqueue_style( 'thickbox' );

	wp_enqueue_script(
		'pronamic-file-select' , // handle 
		plugins_url( 'assets/js/file-select.js', Pronamic_Framework::$file ) , // src
		array( 'jquery', 'media-upload', 'thickbox' ) // dependencies
	);
	
	wp_localize_script(
		'pronamic-file-select' , // handle
		'pronamicFileSelect' , // object name
		array( // data
			'selectFileText' => esc_html__( 'Select File', 'pronamic_framework' ) , 
			'selectText' => esc_html__( 'Select', 'pronamic_framework' ) 
		)
	);

	if($hook_suffix == 'media-upload-popup') {
		$select = filter_input(INPUT_GET, 'pronamic_file_select_field', FILTER_SANITIZE_STRING);

		if( ! empty ( $select ) ) {
			wp_enqueue_script(
				'pronamic-file-select-media-upload' , // handle 
				plugins_url( 'assets/js/file-select-media-upload.js', Pronamic_Framework::$file ) , // src
				array( 'jquery', 'media-upload', 'thickbox' ) // dependencies
			);
			
			wp_localize_script(
				'pronamic-file-select-media-upload' , // handle
				'pronamicFileSelectMedia' , // object name
				array( // data
					
					'fieldId' => $select
				)
			);
		}
	}
}

add_action( 'admin_enqueue_scripts', 'pronamic_admin_enqueue_scripts' );

function pronamic_get_media_item_args($args) {
	$select = filter_input(INPUT_GET, 'test', FILTER_SANITIZE_STRING);

	if( ! empty ( $select ) ) {
		$args['send'] = false;
		$args['delete'] = false;
	}

	return $args;
}

add_filter('get_media_item_args', 'pronamic_get_media_item_args', 50);

function pronamic_attachment_fields_to_edit($form_fields, $post) {
	$select = filter_input(INPUT_GET, 'test', FILTER_SANITIZE_STRING);

	if( ! empty ( $select ) ) {
		$form_fields = array();
		$form_fields['pronamic_select_file'] =  array('tr' => '<tr><td colspan="2">Select</td></tr>');
	}

	$field = sprintf(
		'<a class="button pronamic-select-file-button" data-post_id="%s">%s</a>' , 
		$post->ID , 
		__( 'Select', 'pronamic_framework')
	);

	$form_fields['pronamic_select_file'] =  array('tr' => '<tr><td></td><td>' . $field . '</td></tr>');

	return $form_fields;
}

add_filter('attachment_fields_to_edit', 'pronamic_attachment_fields_to_edit', 50, 2);

// Output form button
function pronamic_file_select( $name, $value ) {
	?>
	<input id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" class="pronamic-file-select" />

	<div id="<?php echo esc_attr( $name ); ?>_preview" class="pronamic-file-select-preview">
		<?php echo pronamic_file_select_preview( $value ); ?>
	</div>
	<?php 
}

function pronamic_file_select_preview( $id ) {
	if ( ! empty( $id ) ) {
		if ( wp_attachment_is_image( $id ) ) {
			return wp_get_attachment_image( $id );
		} else {
			$attachment_url = wp_get_attachment_url( $id );
			$filetype_check = wp_check_filetype( $attachment_url );
			$filetype_parts = explode( '/', $filetype_check['type'] );
	
			return '<a href="' . wp_get_attachment_url( $id ) . '" style="display: block; min-height:32px; padding: 10px 0 0 38px; background: url(' . plugins_url( "img/icon-" . $filetype_parts[1] . ".png", __FILE__ ) . ') no-repeat; font-size: 13px; font-weight: bold;">' . basename( $attachment_url ) . '</a>';
		}
	}
}

function pronamic_file_select_preview_ajax() {
	$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

	echo pronamic_file_select_preview( $id );

	die();
}

add_action( 'wp_ajax_pronamic_file_select_preview', 'pronamic_file_select_preview_ajax' );
