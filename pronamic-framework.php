<?php
/*
Plugin Name: Pronamic Framework
Plugin URI: http://pronamic.eu/wordpress/framework/
Description: This plugin contains some handy WordPress functions and extends the WordPress admin interface with some nice functions, widgets and more.
Version: 1.2
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

class Pronamic_Framework {
	/**
	 * The slug of this plugin
	 * 
	 * @var string
	 */
	const SLUG = 'pronamic-framework';

	////////////////////////////////////////////////////////////

	/**
	 * The URL to the Pronamic RSS feed
	 * 
	 * @var string
	 */
	const RSS_URL_PRONAMIC = 'http://feeds.feedburner.com/pronamic';

	////////////////////////////////////////////////////////////

	/**
	 * Bootstrap this plugin
	 */
	public static function bootstrap() {
		// Actions
		add_action('init', array(__CLASS__, 'initialize'));

		add_action('wp_head', array(__CLASS__, 'head'));

		add_action('wp_print_styles', array(__CLASS__, 'printStyles'));

		add_action('wp_dashboard_setup', array(__CLASS__, 'dashboardSetup'));

		add_action('pronamic_credits', array(__CLASS__, 'credits'));

		add_action('admin_bar_menu', array(__CLASS__, 'adminBarMenu'), 100);

		// Filters
		add_filter('admin_footer_text', array(__CLASS__, 'adminFooter'));

		add_filter('wp_headers', array(__CLASS__, 'headers'));
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the plugin
	 */
	public static function initialize() {
		// Load plugin text domain
		$relPath = dirname(plugin_basename(__FILE__)) . '/languages/';

		load_plugin_textdomain(self::SLUG, false, $relPath);

		// Register post types
		self::registerPostTypeBlock();
	}

	//////////////////////////////////////////////////

	/**
	 * Register post type block
	 */
	public static function registerPostTypeBlock() {
		register_post_type('pronamic_block', array(
			'labels' => array(
				'name' => _x('Blocks', 'post type general name', self::SLUG) , 
				'singular_name' => _x('Block', 'post type singular name', self::SLUG) , 
				'add_new' => _x('Add New', 'block', self::SLUG) , 
				'add_new_item' => __('Add New Block', self::SLUG) , 
				'edit_item' => __('Edit Block', self::SLUG) , 
				'new_item' => __('New Block', self::SLUG) , 
				'view_item' => __('View Block', self::SLUG) , 
				'search_items' => __('Search Blocks', self::SLUG) , 
				'not_found' =>  __('No blocks found', self::SLUG) , 
				'not_found_in_trash' => __('No blocks found in Trash', self::SLUG) , 
				'parent_item_colon' => __('Parent Block:', self::SLUG) ,
				'menu_name' => __('Blocks', self::SLUG) , 
			) , 
			'public' => false , 
			'publicly_queryable' => false , 
			'show_ui' => true , 
			'show_in_menu' => true ,  
			'query_var' => true , 
			'rewrite' => true , 
			'capability_type' => 'page' , 
			'has_archive' => true , 
			'hierarchical' => true , 
			'menu_position' => null , 
			'menu_icon' =>  plugins_url('/admin/icons/block.png', __FILE__) ,
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
		));
	}

	//////////////////////////////////////////////////

	/**
	 * Admin bar menu
	 */
	public static function adminBarMenu() {
		global $wp_admin_bar;

		$wp_admin_bar->add_menu(array(
			'id' => 'pronamic' ,  
			'title' => __('Pronamic', self::SLUG) ,  
			'href' => __('http://pronamic.eu/', self::SLUG) , 
			'meta' => array('target' => '_blank')
		));

		$wp_admin_bar->add_menu(array(
			'parent' => 'pronamic' ,  
			'id' => 'pronamic-contact' , 
			'title' => __('Contact', self::SLUG) , 
			'href' => __('http://pronamic.eu/contact/', self::SLUG) ,  
			'meta' => array('target' => '_blank') 
		));
	}

	//////////////////////////////////////////////////

	/**
	 * Render dashboard
	 */
	public static function dashboard() {
		?>
		<h4><?php _e('Support', self::SLUG); ?></h4>

		<p> 
			<?php printf(__('Telephone: %s', self::SLUG), sprintf('<a href="tel:+315164812000">%s</a>', __('+31 516 481 200', self::SLUG))); ?><br />
			<?php printf(__('E-mail: %s', self::SLUG), sprintf('<a href="mailto:%1$s">%1$s</a>', __('support@pronamic.eu', self::SLUG))); ?><br />
			<?php printf(__('Website: %s', self::SLUG), sprintf('<a href="%1$s">%1$s</a>', __('http://pronamic.eu/', self::SLUG))); ?>
		</p> 

		<h4><?php _e('News', self::SLUG); ?></h4>

		<?php

		wp_widget_rss_output(self::RSS_URL_PRONAMIC, array(
			'link' => __('http://pronamic.eu/', self::SLUG) , 
			'url' => self::RSS_URL_PRONAMIC ,
			'title' => __('Pronamic News', self::SLUG) ,
			'items' => 5
		));
	}

	/**
	 * Dashboard setup
	 */
	public static function dashboardSetup() {
		wp_add_dashboard_widget(
			self::SLUG , 
			__('Pronamic', self::SLUG) , 
			array(__CLASS__, 'dashboard') 
		);
	}

	////////////////////////////////////////////////////////////

	/**
	 * Print the styles
	 */
	public static function printStyles() {
		wp_enqueue_style(
			self::SLUG , 
			plugins_url('/style.css', __FILE__)  
		);
	}

	////////////////////////////////////////////////////////////

	/**
	 * Get the credits
	 * 
	 * @return string
	 */
	public static function getCredits() {
		return sprintf('<span id="pronamic-credits">%s</span>', 
			sprintf(__('Concept and realisation by %s', self::SLUG) ,
				sprintf('<a href="%s" title="%s" rel="developer">%s</a>' , 
					esc_attr(__('http://pronamic.eu/', self::SLUG)) , 
					esc_attr(__('Pronamic - Internet, marketing & WordPress specialist', self::SLUG)) ,
					__('Pronamic', self::SLUG)
				)
			)
		);
	}

	////////////////////////////////////////////////////////////

	/**
	 * Credits
	 */
	public static function credits() {
		echo self::getCredits();		
	}

	////////////////////////////////////////////////////////////

	/**
	 * Extend the headers with a Pronamic powered by header
	 * 
	 * @param array $headers
	 * @return array
	 */
	public static function headers($headers) {
		$headers['X-Powered-By'] = 'Pronamic | pronamic.nl | info@pronamic.nl';

		return $headers;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Extend the admin footer text with a Pronamic text
	 * 
	 * @param string $text
	 * @return string
	 */
	public static function adminFooter($text) {
		$text .= ' | ' . self::getCredits();
	
		return $text;
	}

	////////////////////////////////////////////////////////////
	
	/**
	 * Extend the WordPress HTML head section with some Pronamic comments
	 */
	public static function head() {
		?>
		<meta name="developer" content="<?php _e('Pronamic', self::SLUG); ?>" />
		<meta name="developer-website" content="<?php _e('http://pronamic.eu/', self::SLUG); ?>" />
		<?php
	}
}

Pronamic_Framework::bootstrap();
