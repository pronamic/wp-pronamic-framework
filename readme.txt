=== Pronamic Framework ===
Contributors: pronamic, remcotolsma 
Tags: pronamic, framework
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 1.3.2

This plugin contains some handy WordPress functions and extends the WordPress admin 
interface with some nice functions, widgets and more.


== Description ==

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

= trunk =
*	Removed the use of class constant in translation function, now use normal strings
*	Changed the text domain name from 'pronamic-framework' to 'pronamic_framework'
*	Improved the custom post type 'pronamic_block' WordPress admin menu icon
*	Added the [pronamic_login_form]  shortcode
*	Added the [pronamic_current_user_posts] shortcode

= 1.3.2 =
*	Removed admin menu item 'Pronamic'
*	Removed HTTP header 'X-Powered-By' => 'Pronamic | pronamic.nl | info@pronamic.nl'
*	Removed credit funtions
*	Removed admin footer function
*	Removed Pronamic admin dashboard widget

= 1.3.1 =
*	Removed comments support from the custom post type 'pronamic_block'
*	Fixed the link to CSS file style.css in the enqueue style function call

= 1.3 =
*	Removed the "developer" and "developer-website" meta elements, they are not on the HTML5 whitelist
*	Fixed an issue with the classes in multiple files and the plugin paths
*	Added widget for Pronamic block post types

= 1.2 =
*	Added custom post type "pronamic_block"

= 1.1.2 =
*	Added esc_attr() function to some code

= 1.1.1 =
*	Fixed a bug with an unclosed span element

= 1.1 =
*	Added dashboard widget
*	Added multilanguage support (English and Dutch)
*	Added admin bar menu links
*	Added "pronamic_credits" action
*	Added "X-Powered-By" header

= 1.0 =
*	Initial release


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

