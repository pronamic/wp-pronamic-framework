<?php
/*
Plugin Name: Pronamic Framework
Plugin URI: http://pronamic.eu/wordpress/framework/
Description: This plugin contains some handy WordPress functions and extends the WordPress admin interface with some nice functions, widgets and more.
Version: 1.3.3
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

require_once 'classes/Pronamic_Block_Widget.php';
require_once 'classes/Pronamic_Framework.php';
require_once 'shortcodes/shortcode-login-form.php';
require_once 'shortcodes/shortcode-lostpassword-form.php';
require_once 'shortcodes/shortcode-current-user-posts.php';
require_once 'shortcodes/shortcode-edit-post-form.php';

Pronamic_Framework::bootstrap(__FILE__);
