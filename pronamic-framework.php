<?php
/*
Plugin Name: Pronamic Framework
Plugin URI: http://pronamic.eu/wordpress/framework/
Description: This plugin contains some handy WordPress functions and extends the WordPress admin interface with some nice functions, widgets and more.
Version: 1.0
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

function pronamic_framework_wp_head() {
	// Thanks to http://www.network-science.de/ascii/
	// Font: mini, rounded, small, standard
	// Thanks to http://patorjk.com/software/taag/

	?>
	<!-- 

	Developed by:
	Pronamic | http://pronamic.nl/ | info@pronamic.nl | <?php echo date('Y'); ?> 
	 _____                                  _      
	|  __ \                                (_)     
	| |__) |_ __ ___  _ __   __ _ _ __ ___  _  ___ 
	|  ___/| '__/ _ \| '_ \ / _` | '_ ` _ \| |/ __|
	| |    | | | (_) | | | | (_| | | | | | | | (__ 
	|_|    |_|  \___/|_| |_|\__,_|_| |_| |_|_|\___|

 	-->
	<?php
}

add_action('wp_head', 'pronamic_framework_wp_head');