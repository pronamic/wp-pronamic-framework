<?php

/**
 * Shortcode terms index
 */
function pronamic_framework_shortcode_terms_index( $atts ) {
	extract( shortcode_atts( array(
		'taxonomy' => null,
		'parent'   => 0
	), $atts ) );

	$result = '';

	if ( $taxonomy ) {
		$terms = get_terms( $taxonomy );
		$alphabet = array();

		foreach ( $terms as $term ) {
			$letter = strtoupper( substr( $term->name, 0, 1 ) );

			if ( ! isset( $alphabet[$letter] ) ) {
				$alphabet[$letter] = array();
			}

			$alphabet[$letter][] = $term;
		}

		if ( ! empty( $alphabet ) ) {
			$result .= '<ul class="pronamic-terms-index-list">';

			foreach ( $alphabet as $letter => $terms ) {
				$result .= '<li>';

				$result .= $letter;

				if ( ! empty( $terms ) ) {
					$result .= '<ul>';

					foreach ( $terms as $term ) {
						$result .= '<li>';
						$result .= sprintf(
							'<a href="%s">%s</a>',
							get_term_link( $term ),
							$term->name
						);
						$result .= '</li>';
					}

					$result .= '</ul>';
				}

				$result .= '</li>';
			}

			$result .= '</ul>';
		}
	}

	return $result;
}

add_shortcode( 'pronamic_terms_index', 'pronamic_framework_shortcode_terms_index' );
