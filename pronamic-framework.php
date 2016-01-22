<?php
/*
Plugin Name: Pronamic Framework
Plugin URI: http://www.pronamic.eu/plugins/pronamic-framework/
Description: This plugin contains some handy WordPress functions and extends the WordPress admin interface with some nice functions, widgets and more.

Version: 1.4.7
Requires at least: 3.0

Author: Pronamic
Author URI: http://www.pronamic.eu/

Text Domain: pronamic_framework
Domain Path: /languages/

License: GPL

GitHub URI: https://github.com/pronamic/wp-pronamic-ideal
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
require_once 'includes/settings-fields.php';

global $ponamic_framework_plugin;

$ponamic_framework_plugin = new Pronamic_Framework( __FILE__ );

Pronamic_Framework::bootstrap( __FILE__ );
