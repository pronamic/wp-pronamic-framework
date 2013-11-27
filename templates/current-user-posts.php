<?php if ( have_posts() ): ?>
	
	<table>
		<thead>
			<tr>
				<th scope="col">
					<?php _e( 'Title', 'pronamic_framework' ); ?>
				</th>
				<th scope="col">
					<?php _e( 'Date', 'pronamic_framework' ); ?>
				</th>
				<th scope="col">
					<?php _e( 'Actions', 'pronamic_framework' ); ?>
				</th>
			</tr>
		</thead>
	
		<tbody>
	
			<?php while ( have_posts() ): the_post(); ?>
		
				<tr>
					<td>
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</td>
					<td>
						<?php the_time( get_option( 'date_format' ) ); ?>
					</td>
					<td>
						<?php edit_post_link(); ?>
						<?php delete_post_link(); ?>
					</td>
				</tr>
	
			<?php endwhile; ?>
	
		</tbody>
	</table>

<?php else: ?>

	

<?php endif; ?>