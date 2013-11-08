<?php

if ( ! function_exists( 'pronamic_field_wp_editor' ) ) {
	/**
	 * Field dropdown pages
	 * 
	 * @param array $args
	 */
	function pronamic_field_wp_editor( $args ) {
		printf(
			'<input name="%s" id="%s" type="text" value="%s" class="%s" />',
			esc_attr( $args['label_for'] ),
			esc_attr( $args['label_for'] ),
			esc_attr( get_option( $args['label_for'] ) ),
			'regular-text code'
		);

		if ( isset( $args['description'] ) ) {
			printf(
				'<p class="description">%s</p>',
				$args['description']
			);
		}
	}
}

if ( ! function_exists( 'pronamic_field_dropdown_pages' ) ) {
	/**
	 * Field dropdown pages
	 * 
	 * @param array $args
	 */
	function pronamic_field_dropdown_pages( $args ) {
		$name = $args['label_for'];
		
		wp_dropdown_pages( array(
			'name'             => $name,
			'selected'         => get_option( $name, '' ),
			'show_option_none' => __( '&mdash; Select a page &mdash;', 'pronamic_framework' )
		) );
	}
}

if ( ! function_exists( 'pronamic_field_textarea' ) ) {
	/**
	 * Field dropdown pages
	 * 
	 * @param array $args
	 */
	function pronamic_field_textarea( $args ) {
		printf(
			'<textarea name="%s" id="%s" class="%s" rows="10" cols="60">%s</textarea>',
			esc_attr( $args['label_for'] ),
			esc_attr( $args['label_for'] ),
			'regular-text code',
			esc_textarea( get_option( $args['label_for'] ) )
		);
	}
}

if ( ! function_exists( 'pronamic_field_wp_editor' ) ) {
	/**
	 * Field WordPress editor
	 * 
	 * @param array $args
	 */
	function pronamic_field_wp_editor( $args ) {
		$name = $args['label_for'];
		
		wp_editor( get_option( $name, '' ), $name );
	}
}

if ( ! function_exists( 'pronamic_field_dropdown_gravityforms' ) ) {
	/**
	 * Field dropdown Gravity Forms
	 * 
	 * @param array $args
	 */
	function pronamic_field_dropdown_gravityforms( $args) {
		$name = $args['label_for'];

		$forms = array();
		
		if ( method_exists( 'RGFormsModel', 'get_forms') ) {
			$forms = RGFormsModel::get_forms();
		}
			
		if ( empty( $forms ) ) {
			_e( 'You don\'t  have any Gravity Forms forms.', 'pronamic_framework' );
		} else {
			$form_id = get_option( $name );
		
			printf( '<select name="%s" id="%s">', $name, $name );
			printf( '<option value="%s" %s>%s</option>', '', selected( $form_id, '', false ), '' );
			foreach ( $forms as $form ) {
				printf( '<option value="%s" %s>%s</option>', $form->id, selected( $form_id, $form->id, false ), $form->title );
			}
			printf( '</select>' );
		}
	}
}
