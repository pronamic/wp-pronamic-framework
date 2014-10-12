=== Pronamic Framework ===
Contributors: pronamic, remcotolsma 
Tags: pronamic, framework
Donate link: http://pronamic.eu/donate/?for=wp-plugin-pronamic-framework&source=wp-plugin-readme-txt
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 1.4.6

This plugin contains some handy WordPress functions and extends the WordPress admin 
interface with some nice functions, widgets and more.


== Description ==

= Shortcodes =

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


= Template Functions =

*	**Has user image**

		pronamic_has_user_image( $user_id = null )

*	**Get user image ID**

		pronamic_get_user_image_id( $user_id = null )

*	**The user image**

		pronamic_the_user_image( $size = 'post-thumbnail', $attr = '')

*	**Get user image**

		pronamic_get_the_user_image( $user_id = null, $size = 'post-thumbnail', $attr = '' )

*	**How to use?**

		$author = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

		if(function_exists('pronamic_get_the_user_image')) {
			echo pronamic_get_the_user_image( $author->ID, array(93, 140) );
		} else {
			echo get_avatar(get_the_author_meta('user_email', $author->ID), apply_filters('horses_author_bio_avatar_size', 90));
		}


= Query to display block =

	<?php

	$query = new WP_Query();
	$query->query(array(
		'post_type' => 'pronamic_block' , 
		'name' => 'contact' 
	));

	while($query->have_posts()) {
		$query->the_post();

		the_content();
	}

	?>

= Template Hierarchy Pronamic Block Widget =

1.	pronamic-block-widget-{sidebar_id}.php
2.	pronamic-block-widget-{widget_id}.php
3.	pronamic-block-widget-{block_slug}.php
4.	pronamic-block-widget-{block_id}.php
5.	pronamic-block-widget.php

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your 
WordPress installation and then activate the Plugin from Plugins page.


== Screenshots ==

...


== Changelog ==

= 1.4.7 =
*	Removed frontent style.css file.
*	Fixed JavaScript issue in AJAX success event.
*	WordPress Coding Standards optimizations.

= 1.4.6 =
*	Added before comment form text option.

= 1.4.5 =
*	Fixed issue with WPML and Pronamic Block widget.

= 1.4.4 =
*	Added shortcode for an terms index.
*	Improved Pronamic Block widget for WPML.

= 1.4.3 =
*	Added field for custom head HTML.
*	Added field for custom footer HTML.
*	Added fields for post typ descriptions (can be used on archive page).

= 1.4.2 =
*	Fix logout page if no logout page is selected.
*	Added translations for the logout page.

= 1.4.1 =
*	Changed the user image template function, now by default use the author ID instead of logged in user ID.
*	Added logout page support.

= 1.4 =
*	Improved default template for the edit post form shortcode.
*	Improved the query to retrieve the post to edit in the edit post form shortcode.
*	Added media select.
*	Added user image.
*	Fixed login form shortcode redirect_to parameter.

= 1.3.3 =
*	Removed the use of class constant in translation function, now use normal strings.
*	Changed the text domain name from 'pronamic-framework' to 'pronamic_framework'.
*	Improved the custom post type 'pronamic_block' WordPress admin menu icon.
*	Added the [pronamic_login_form]  shortcode.
*	Added the [pronamic_current_user_posts] shortcode.
*	Added the [pronamic_lostpassword_form]  shortcode.
*	Added Pronamic settings page to set some pages.

= 1.3.2 =
*	Removed admin menu item 'Pronamic'.
*	Removed HTTP header 'X-Powered-By' => 'Pronamic | pronamic.nl | info@pronamic.nl'.
*	Removed credit funtions.
*	Removed admin footer function.
*	Removed Pronamic admin dashboard widget.

= 1.3.1 =
*	Removed comments support from the custom post type 'pronamic_block'.
*	Fixed the link to CSS file style.css in the enqueue style function call.

= 1.3 =
*	Removed the "developer" and "developer-website" meta elements, they are not on the HTML5 whitelist.
*	Fixed an issue with the classes in multiple files and the plugin paths.
*	Added widget for Pronamic block post types.

= 1.2 =
*	Added custom post type "pronamic_block".

= 1.1.2 =
*	Added esc_attr() function to some code.

= 1.1.1 =
*	Fixed a bug with an unclosed span element.

= 1.1 =
*	Added dashboard widget.
*	Added multilanguage support (English and Dutch).
*	Added admin bar menu links.
*	Added "pronamic_credits" action.
*	Added "X-Powered-By" header.

= 1.0 =
*	Initial release.


== ToDo ==

*	List of Pronamic plugins
*	E-mailaddress support@pronamic.nl
*	Help texts
*	Default ad sizes widgets
*	Pronamic Shop
*	Openprovider
*	Mailtomail
*	Twinfield
*	Flickr Sync


== Links ==

*	[Pronamic](http://pronamic.eu/)
*	[Remco Tolsma](http://remcotolsma.nl/)
*	[Markdown's Syntax Documentation][markdown syntax]	

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"


== Pronamic plugins ==

*	[Pronamic Google Maps](http://wordpress.org/extend/plugins/pronamic-google-maps/)
*	[Gravity Forms (nl)](http://wordpress.org/extend/plugins/gravityforms-nl/)
*	[Pronamic Page Widget](http://wordpress.org/extend/plugins/pronamic-page-widget/)
*	[Pronamic Page Teasers](http://wordpress.org/extend/plugins/pronamic-page-teasers/)
*	[Maildit](http://wordpress.org/extend/plugins/maildit/)
*	[Pronamic Framework](http://wordpress.org/extend/plugins/pronamic-framework/)
*	[Pronamic iDEAL](http://wordpress.org/extend/plugins/pronamic-ideal/)

