<?php

function pronamic_media_select_scripts( $hook_suffix ) {
	wp_enqueue_style( 'thickbox' );

	wp_enqueue_script(
		'pronamic-media-select' , // handle 
		plugins_url( 'assets/js/media-select.js', Pronamic_Framework::$file ) , // src
		array( 'jquery', 'media-upload', 'thickbox' ) // dependencies
	);
	
	wp_localize_script(
		'pronamic-media-select' , // handle
		'pronamicMediaSelectL10n' , // object name
		array( // data
			'selectMediaText' => __( 'Select Media&hellip;', 'pronamic_framework' ) , 
			'selectText' => __( 'Select', 'pronamic_framework' ) , 
			'deleteText' =>  __( 'Delete', 'pronamic_framework' ) , 
			'loadingPreviewText' =>  __( 'Loading preview&hellip;', 'pronamic_framework' ) ,
		)
	);
}

add_action( 'admin_enqueue_scripts', 'pronamic_media_select_scripts' );

function pronamic_attachment_fields_to_edit($form_fields, $post) {
	$field = sprintf(
		'<a class="button pronamic-media-select-button" data-post_id="%s">%s</a>' , 
		$post->ID , 
		__( 'Select', 'pronamic_framework')
	);

	$tr  = '';

	$tr .= '<tr class="pronamic-media-select">';
	$tr .= '	<td></td>';
	$tr .= '	<td>';
	$tr .= '		' . $field;
	$tr .= '	</td>';
	$tr .= '</tr>';

	$form_fields['pronamic_select_attachment'] =  array('tr' => $tr);

	return $form_fields;
}

add_filter('attachment_fields_to_edit', 'pronamic_attachment_fields_to_edit', 50, 2);

// Output form button
function pronamic_media_select_field( $name, $value ) {
	?>
	<div id="<?php echo esc_attr( $name ); ?>_preview" class="pronamic-media-select-preview">
		<?php echo pronamic_media_select_preview( $value ); ?>
	</div>

	<input id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" class="pronamic-media-select" />
	<?php 
}

function pronamic_media_select_preview( $id ) {
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

function pronamic_media_select_preview_ajax() {
	$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

	echo pronamic_media_select_preview( $id );

	die();
}

add_action( 'wp_ajax_pronamic_media_select_preview', 'pronamic_media_select_preview_ajax' );
