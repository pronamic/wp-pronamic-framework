<?php
/*
Plugin Name: Pronamic Framework
Plugin URI: http://pronamic.eu/wordpress/framework/
Description: This plugin contains some handy WordPress functions and extends the WordPress admin interface with some nice functions, widgets and more.
Version: 1.4.5
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
require_once 'shortcodes/shortcode-terms-index.php';
require_once 'functions/media-select.php';
require_once 'functions/user-image-template.php';
require_once 'functions/user-image.php';

Pronamic_Framework::bootstrap( __FILE__ );
