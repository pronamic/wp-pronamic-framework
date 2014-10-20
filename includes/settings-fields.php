<?php
/**
 * Settings fields callbacks
 * https://github.com/pronamic/wp-pronamic-framework/blob/develop/includes/settings-fields.php
 *
 * @package Pronamic Framework
 * @since 1.5.0
 */

if ( ! function_exists( 'pronamic_field_input_text' ) ) {
	/**
	 * Field dropdown pages
	 *
	 * @param array $args
	 */
	function pronamic_field_input_text( $args ) {
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

if ( ! function_exists( 'pronamic_field_input_media' ) ) {
	/**
	 * Field dropdown pages
	 *
	 * @param array $args
	 */
	function pronamic_field_input_media( $args ) {
		printf(
			'<input name="%s" id="%s" type="text" value="%s" class="%s" data-frame-title="%s" data-button-text="%s" data-library-type="%s" />',
			esc_attr( $args['label_for'] ),
			esc_attr( $args['label_for'] ),
			esc_attr( get_option( $args['label_for'] ) ),
			'code pronamic-media-picker',
			__( 'Select Media', 'pronamic' ),
			__( 'Select', 'pronamic' ),
			''
		);

		?>
		<script type="text/javascript">
			( function( $ ) {
				$( document ).ready( function() {
					var frame;

					$( '.pronamic-media-picker' ).each( function() {
						var $this = $( this );

						var selectLink = $( '<a />' ).text( 'Select media' );

						$this.after(selectLink);

						selectLink.click( function( event ) {
							var $el = $( this );

							event.preventDefault();

							// If the media frame already exists, reopen it.
							if ( frame ) {
								frame.open();
								return;
							}

							// Create the media frame.
							frame = wp.media.frames.projectAgreement = wp.media( {
								// Set the title of the modal.
								title: $el.data( 'choose' ),

								// Tell the modal to show only images.
								library: {
									type: $this.data( 'library-type' ),
								},

								// Customize the submit button.
								button: {
									// Set the text of the button.
									text: $this.data( 'button-text' ),
									// Tell the button not to close the modal, since we're
									// going to refresh the page when the image is selected.
									close: false
								}
							} );

							// When an image is selected, run a callback.
							frame.on( 'select', function() {
								// Grab the selected attachment.
								var attachment = frame.state().get( 'selection' ).first();

								$this.val( attachment.id );

								frame.close();
							} );

							// Finally, open the modal.
							frame.open();
						} );
					} );
				} );
			} )( jQuery );
		</script>
		<?php
	}
}

if ( ! function_exists( 'pronamic_field_input_color' ) ) {
	/**
	 * Field dropdown pages
	 *
	 * @param array $args
	 */
	function pronamic_field_input_color( $args ) {
		printf(
			'<input name="%s" id="%s" type="text" value="%s" class="%s" />',
			esc_attr( $args['label_for'] ),
			esc_attr( $args['label_for'] ),
			esc_attr( get_option( $args['label_for'] ) ),
			'code pronamic-color-picker'
		);

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				$( '.pronamic-color-picker' ).wpColorPicker();
			} );
		</script>
		<?php
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
	function pronamic_field_dropdown_gravityforms( $args ) {
		$name = $args['label_for'];

		$forms = array();

		if ( method_exists( 'RGFormsModel', 'get_forms' ) ) {
			$forms = RGFormsModel::get_forms();
		}

		if ( empty( $forms ) ) {
			_e( 'You don\'t  have any Gravity Forms forms.', 'pronamic_framework' );
		} else {
			$form_id = get_option( $name );

			printf( '<select name="%s" id="%s">', $name, $name );

			printf(
				'<option value="%s" %s>%s</option>',
				'',
				selected( $form_id, '', false ),
				__( '&mdash; Select a form &mdash;', 'pronamic_framework' )
			);

			foreach ( $forms as $form ) {
				printf( '<option value="%s" %s>%s</option>', $form->id, selected( $form_id, $form->id, false ), $form->title );
			}

			printf( '</select>' );
		}
	}
}
