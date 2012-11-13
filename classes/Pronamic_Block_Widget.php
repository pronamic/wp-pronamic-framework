<?php

/**
 * Title: Pronamic block widget
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * 
 * @class Pronamic_Block_Widget
 * @package Pronamic Framework
 * @since 1.0
 * @category Class
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Block_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'pronamic_block_widget',
			__( 'Pronamic Block', 'pronamic_framework'),
			array( // widget options
				'classname' => 'pronamic-block'
			),
			array( // control options
				
			)
		);
	}

	function form( $instance ) {
		$title = strip_tags( $instance['title'] );

		$post_id = null;
		if ( isset( $instance['post_id'] ) ) {
			$post_id = $instance['post_id'];
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:' ); ?>
			</label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_id' ); ?>">
				<?php _e(' Block:', 'pronamic_framework' ); ?>

          		<select class="widefat" id="<?php echo $this->get_field_id( 'post_id' ); ?>" name="<?php echo $this->get_field_name( 'post_id' ); ?>">

					<?php 
				
					$query = new WP_Query();
					$query->query(
						array(
							'post_type'      => 'pronamic_block',
							'posts_per_page' => -1
						)
					);

					if ( $query->have_posts()) while( $query->have_posts() ) {
						$query->the_post();

						$extra = '';
						if ( get_the_ID() == $post_id ) {
							 $extra = 'selected="selected"';
						}
						
						echo '<option value="', get_the_ID(), '" ', $extra, '>', get_the_title(), '</option>';
					} 
					
					?>
				</select>
			</label>
		</p>

		<?php 
		
		wp_reset_query();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['post_id'] = strip_tags( $new_instance['post_id'] );

		return $instance;
	}

	function widget($arguments, $instance) {
		global $post;

		extract($arguments);

		$query = new WP_Query();
		$query->query( array(
			'p'              => $instance['post_id'],
			'post_type'      => 'pronamic_block',
			'posts_per_page' => -1
		) );

		echo $before_widget;
		
		if ( $query->have_posts() ) while ( $query->have_posts() ) {
			$query->the_post();

			$templates = array();
			$templates[] = 'pronamic-block-widget-' . $id . '.php';
			$templates[] = 'pronamic-block-widget-' . $widget_id . '.php';
			$templates[] = 'pronamic-block-widget-' . $post->post_name . '.php'; 
			$templates[] = 'pronamic-block-widget-' . $post->ID . '.php';
			$templates[] = 'pronamic-block-widget.php';

			$template = locate_template( $templates );

			if ( !$template ) {
				$template = __DIR__ . '/pronamic-block-widget.php';
			}

			if ( is_file( $template ) ) {
				include $template;
			}
		}
		
		wp_reset_postdata();

		echo $after_widget;
	}
}
