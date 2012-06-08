<?php if(have_posts()): ?>

<table>
	<thead>
		<tr>
			<th scope="col">
				<?php _e('Title', 'pronamic_framework'); ?>
			</th>
			<th scope="col">
				<?php _e('Actions', 'pronamic_framework'); ?>
			</th>
		</tr>
	</thead>

	<tbody>

		<?php while(have_posts()): the_post(); ?>

		<tr>
			<td>
				<?php the_title(); ?>
			</td>
			<td>
				<?php edit_post_link(); ?>
			</td>
		</tr>

		<?php endwhile; ?>

	</tbody>
</table>

<?php else: ?>



<?php endif; ?>