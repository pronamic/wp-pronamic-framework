<?php

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

		load_plugin_textdomain(self::SLUG, false, $relPath);

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
			'menu_icon' =>  plugins_url('/admin/icons/block.png', self::$file) ,
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
		));
	}

	////////////////////////////////////////////////////////////

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
