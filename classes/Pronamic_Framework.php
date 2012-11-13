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
	 * The plugin root file
	 * 
	 * @var string
	 */
	public static $file;

	////////////////////////////////////////////////////////////

	/**
	 * Bootstrap this plugin
	 */
	public static function bootstrap( $file ) {
		self::$file = $file;

		// Actions
		add_action( 'init',       array( __CLASS__, 'init' ) );
		
		add_action( 'wp_head',    array( __CLASS__ , 'wp_head' ) );
		add_action( 'wp_footer',  array( __CLASS__ , 'wp_footer'  ) );
		
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );

		add_action( 'wp_print_styles',   array( __CLASS__, 'print_styles' ) );

		add_action( 'widgets_init',      array( __CLASS__, 'widgets_init' ) );
		
		add_action( 'template_redirect', array( __CLASS__, 'maybe_logout' ) );
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the plugin
	 */
	public static function init() {
		// Load plugin text domain
		$rel_path = dirname( plugin_basename( self::$file ) ) . '/languages/';

		load_plugin_textdomain( 'pronamic_framework', false, $rel_path );

		// Register post types
		self::register_post_type_block();
	}

	//////////////////////////////////////////////////

	public static function wp_head() {
		echo get_option( 'pronamic_framework_html_head' );
	}

	public static function wp_footer() {
		echo get_option( 'pronamic_framework_html_footer' );
	}

	//////////////////////////////////////////////////

	/**
	 * Admin initialize
	 */
	public static function admin_init() {
		// Settings
		register_setting( 'pronamic-framework', 'pronamic_framework_login_page_id' );
		register_setting( 'pronamic-framework', 'pronamic_framework_logout_page_id' );
		register_setting( 'pronamic-framework', 'pronamic_framework_lostpassword_page_id' );
		register_setting( 'pronamic-framework', 'pronamic_framework_edit_post_page_id' );

		register_setting( 'pronamic-framework', 'pronamic_framework_html_head' );
		register_setting( 'pronamic-framework', 'pronamic_framework_html_footer' );

		$post_types = get_post_types();

		foreach ( $post_types as $post_type ) {
			$name = 'pronamic_framework_post_type_description_' . $post_type;

			register_setting( 'pronamic-framework', $name );
		}
	}

	//////////////////////////////////////////////////
	
	/**
	 * Admin menu
	 */
	public static function admin_menu() {
		add_options_page(
			__( 'Pronamic', 'pronamic_framework' ) , // page_title
			__( 'Pronamic', 'pronamic_framework' ) , // menu_title 
			'manage_options' , // capability 
			'pronamic-framework' , // menu_slug
			array( __CLASS__, 'optionsPage' ) // function
		);
	}

	//////////////////////////////////////////////////

	/**
	 * Options page
	 */
	public static function optionsPage() {
		include plugin_dir_path( Pronamic_Framework::$file ) . '/admin/settings.php';
	}

	//////////////////////////////////////////////////
	
	/**
	 * Initialize widgets
	 */
	public static function widgets_init() {
		register_widget( 'Pronamic_Block_Widget' );
	}

	//////////////////////////////////////////////////

	/**
	 * Register post type block
	 */
	public static function register_post_type_block() {
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
	public static function admin_enqueue_scripts() {
		wp_enqueue_style( 'pronamic-framework', plugins_url( '/assets/css/admin.css', self::$file ) );
	}

	/**
	 * Print the styles
	 */
	public static function print_styles() {
		wp_enqueue_style( 'pronamic-framework' , plugins_url( '/style.css', self::$file ) );
	}

	////////////////////////////////////////////////////////////
	
	/**
	 * Logout
	 */
	public static function maybe_logout() {
		$page_id = get_option( 'pronamic_framework_logout_page_id' );

		if ( ! empty( $page_id ) && is_page( $page_id ) ) {
			wp_logout();

			$redirect_to = filter_input( INPUT_GET, 'redirect_to', FILTER_SANITIZE_STRING );

			if ( empty( $redirect_to ) ) {
				$redirect_to = site_url();
			}
			
			wp_safe_redirect( $redirect_to );
			
			exit;
		}
	}
}
