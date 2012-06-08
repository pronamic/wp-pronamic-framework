<?php

/**
 * Title: Pronamic block widget
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * 
 * @class Pronamic_Framework
 * @package Pronamic Framework
 * @since 1.0
 * @category Class
 * @author Remco Tolsma
 * @version 1.0
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
	 * The plugin root file
	 * 
	 * @var string
	 */
	public static $file;

	////////////////////////////////////////////////////////////

	/**
	 * Bootstrap this plugin
	 */
	public static function bootstrap($file) {
		self::$file = $file;

		// Actions
		add_action('init', array(__CLASS__, 'initialize'));

		add_action('admin_enqueue_scripts', array(__CLASS__, 'adminEnqueueScripts'));

		add_action('wp_print_styles', array(__CLASS__, 'printStyles'));

		add_action('widgets_init', array(__CLASS__, 'initializeWidgets'));
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the plugin
	 */
	public static function initialize() {
		// Load plugin text domain
		$relPath = dirname(plugin_basename(self::$file)) . '/languages/';

		load_plugin_textdomain('pronamic_framework', false, $relPath);

		// Register post types
		self::registerPostTypeBlock();
	}
	
	/**
	 * Initialize widgets
	 */
	public static function initializeWidgets() {
		register_widget('Pronamic_Block_Widget');
	}

	//////////////////////////////////////////////////

	/**
	 * Register post type block
	 */
	public static function registerPostTypeBlock() {
		register_post_type('pronamic_block', array(
			'labels' => array(
				'name' => _x('Blocks', 'post type general name', 'pronamic_framework') , 
				'singular_name' => _x('Block', 'post type singular name', 'pronamic_framework') , 
				'add_new' => _x('Add New', 'block', 'pronamic_framework') , 
				'add_new_item' => __('Add New Block', 'pronamic_framework') , 
				'edit_item' => __('Edit Block', 'pronamic_framework') , 
				'new_item' => __('New Block', 'pronamic_framework') , 
				'view_item' => __('View Block', 'pronamic_framework') , 
				'search_items' => __('Search Blocks', 'pronamic_framework') , 
				'not_found' =>  __('No blocks found', 'pronamic_framework') , 
				'not_found_in_trash' => __('No blocks found in Trash', 'pronamic_framework') , 
				'parent_item_colon' => __('Parent Block:', 'pronamic_framework') ,
				'menu_name' => __('Blocks', 'pronamic_framework') , 
			) , 
			'public' => false , 
			'publicly_queryable' => false , 
			'show_ui' => true , 
			'show_in_menu' => true ,  
			'query_var' => true , 
			'rewrite' => true , 
			'capability_type' => 'page' , 
			'has_archive' => false , 
			'hierarchical' => true , 
			'menu_position' => null , 
			// 'menu_icon' =>  plugins_url('/admin/icons/block.png', self::$file) ,
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
		));
	}

	////////////////////////////////////////////////////////////

	/**
	 * Admin enqueue scripts
	 */
	public static function adminEnqueueScripts() {
		wp_enqueue_style('pronamic-framework', plugins_url('/assets/css/admin.css', self::$file));
	}

	/**
	 * Print the styles
	 */
	public static function printStyles() {
		wp_enqueue_style(
			self::SLUG , 
			plugins_url('/style.css', self::$file)  
		);
	}
}
