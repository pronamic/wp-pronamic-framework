## Shortcodes

*	**Login form**
	
		[pronamic_login_form]

		[pronamic_login_form redirect_to="/"]

*	**Lost password form**

		[pronamic_lostpassword_form]

*	**Current user posts**

		[pronamic_current_user_posts]

		[pronamic_current_user_posts query="post_type=company"]

*	**Edit post form**

		[pronamic_edit_post_form]

*	**Terms index**

		[pronamic_terms_index taxonomy="category"]
		[pronamic_terms_index taxonomy="category" parent=""]


## Template Functions

*	**Has user image**

		pronamic_has_user_image( $user_id = null )

*	**Get user image ID**

		pronamic_get_user_image_id( $user_id = null )

*	**The user image**

		pronamic_the_user_image( $size = 'post-thumbnail', $attr = '')

*	**Get user image**

```php
pronamic_get_the_user_image( $user_id = null, $size = 'post-thumbnail', $attr = '' )
```

*	**Get post type archive description**



*	**How to use?**

```
<?php

$author = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );

if ( function_exists( 'pronamic_get_the_user_image' ) ) {
	echo pronamic_get_the_user_image( $author->ID, array( 93, 140 ) );
} else {
	echo get_avatar( get_the_author_meta( 'user_email', $author->ID ), apply_filters( 'pronamic_author_bio_avatar_size', 90 ) );
}

```

## Query to display block

	<?php

	$query = new WP_Query( array( 
		'post_type' => 'pronamic_block', 
		'name'      => 'contact',
	) );

	while( $query->have_posts() ) { $query->the_post();
		the_content();
	}

	?>

## Template Hierarchy Pronamic Block Widget

1.	pronamic-block-widget-{sidebar_id}.php
2.	pronamic-block-widget-{widget_id}.php
3.	pronamic-block-widget-{block_slug}.php
4.	pronamic-block-widget-{block_id}.php
5.	pronamic-block-widget.php

## Installation 

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your 
WordPress installation and then activate the Plugin from Plugins page.

## Pronamic plugins

*	[Pronamic Google Maps](http://wordpress.org/extend/plugins/pronamic-google-maps/)
*	[Gravity Forms (nl)](http://wordpress.org/extend/plugins/gravityforms-nl/)
*	[Pronamic Page Widget](http://wordpress.org/extend/plugins/pronamic-page-widget/)
*	[Pronamic Page Teasers](http://wordpress.org/extend/plugins/pronamic-page-teasers/)
*	[Maildit](http://wordpress.org/extend/plugins/maildit/)
*	[Pronamic Framework](http://wordpress.org/extend/plugins/pronamic-framework/)
*	[Pronamic iDEAL](http://wordpress.org/extend/plugins/pronamic-ideal/)

