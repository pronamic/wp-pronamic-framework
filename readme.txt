=== Pronamic Framework ===
Contributors: pronamic, remcotolsma 
Tags: pronamic, framework
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 1.2

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


== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your 
WordPress installation and then activate the Plugin from Plugins page.


== Screenshots ==

...


== Changelog ==

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