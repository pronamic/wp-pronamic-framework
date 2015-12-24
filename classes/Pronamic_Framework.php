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

		add_action( 'wp_head',    array( __CLASS__, 'wp_head' ) );
		add_action( 'wp_footer',  array( __CLASS__, 'wp_footer'  ) );

		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );

		add_action( 'widgets_init',      array( __CLASS__, 'widgets_init' ) );

		add_action( 'template_redirect', array( __CLASS__, 'maybe_logout' ) );

		add_action( 'comment_form_before', array( __CLASS__, 'show_comment_form_before_text' ) );

		// Filters
		add_filter( 'login_url', array( __CLASS__, 'login_url' ), 10, 2 );
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

	/**
	 * Head
	 */
	public static function wp_head() {
		echo get_option( 'pronamic_framework_html_head' );
	}

	/**
	 * Footer
	 */
	public static function wp_footer() {
		echo get_option( 'pronamic_framework_html_footer' );
	}

	//////////////////////////////////////////////////

	/**
	 * Admin initialize
	 */
	public static function admin_init() {
		// Settings - Pages
		add_settings_section(
			'pronamic_framework_pages', // id
			__( 'Pages', 'pronamic_framework' ), // title
			array( __CLASS__, 'settings_section' ), // callback
			'pronamic_framework' // page
		);

		add_settings_field(
			'pronamic_framework_login_page_id', // id
			__( 'Login Page', 'pronamic_framework' ), // title
			array( __CLASS__, 'input_page' ),  // callback
			'pronamic_framework', // page
			'pronamic_framework_pages', // section
			array( 'label_for' => 'pronamic_framework_login_page_id' ) // args
		);

		add_settings_field(
			'pronamic_framework_logout_page_id', // id
			__( 'Logout Page', 'pronamic_framework' ), // title
			array( __CLASS__, 'input_page' ),  // callback
			'pronamic_framework', // page
			'pronamic_framework_pages', // section
			array( 'label_for' => 'pronamic_framework_logout_page_id' ) // args
		);

		add_settings_field(
			'pronamic_framework_lostpassword_page_id', // id
			__( 'Lost Password Page', 'pronamic_framework' ), // title
			array( __CLASS__, 'input_page' ),  // callback
			'pronamic_framework', // page
			'pronamic_framework_pages', // section
			array( 'label_for' => 'pronamic_framework_lostpassword_page_id' ) // args
		);

		add_settings_field(
			'pronamic_framework_edit_post_page_id', // id
			__( 'Edit Post Page', 'pronamic_framework' ), // title
			array( __CLASS__, 'input_page' ),  // callback
			'pronamic_framework', // page
			'pronamic_framework_pages', // section
			array( 'label_for' => 'pronamic_framework_edit_post_page_id' ) // args
		);

		add_settings_field(
			'pronamic_framework_edit_post_id_key', // id
			__( 'Edit Post ID Key', 'pronamic_framework' ), // title
			array( __CLASS__, 'input_text' ),  // callback
			'pronamic_framework', // page
			'pronamic_framework_pages', // section
			array( // args
				'description' => sprintf( __( 'Default is <code>%s</code>', 'pronamic_framework' ), __( 'post', 'pronamic_framework' ) ),
				'label_for'   => 'pronamic_framework_edit_post_id_key',
			)
		);

		// Settings - Comment Form
		add_settings_section(
			'pronamic_framework_comment_form', // id
			__( 'Comment Form', 'pronamic_framework' ), // title
			array( __CLASS__, 'settings_section' ), // callback
			'pronamic_framework' // page
		);

		add_settings_field(
			'pronamic_framework_comment_form_before_text', // id
			__( 'Before comment form text', 'pronamic_framework' ), // title
			array( __CLASS__, 'input_wp_editor' ), // callback
			'pronamic_framework', // page
			'pronamic_framework_comment_form', // section
			array( 'label_for' => 'pronamic_framework_comment_form_before_text' ) // args
		);

		// Settings - HTML
		add_settings_section(
			'pronamic_framework_html', // id
			__( 'HTML', 'pronamic_framework' ), // title
			array( __CLASS__, 'settings_section' ), // callback
			'pronamic_framework' // page
		);

		add_settings_field(
			'pronamic_framework_html_head', // id
			__( 'Head', 'pronamic_companies' ), // title
			array( __CLASS__, 'input_textarea' ),  // callback
			'pronamic_framework', // page
			'pronamic_framework_html', // section
			array( 'label_for' => 'pronamic_framework_html_head' ) // args
		);

		add_settings_field(
			'pronamic_framework_html_footer', // id
			__( 'Footer', 'pronamic_companies' ), // title
			array( __CLASS__, 'input_textarea' ),  // callback
			'pronamic_framework', // page
			'pronamic_framework_html', // section
			array( 'label_for' => 'pronamic_framework_html_footer' ) // args
		);

		// Settings - Post type descriptions
		$post_types = get_post_types( array(), 'objects' );

		if ( ! empty( $post_types ) ) {
			add_settings_section(
				'pronamic_framework_post_type_descriptions', // id
				__( 'Post Type Descriptions', 'pronamic_framework' ), // title
				array( __CLASS__, 'settings_section' ), // callback
				'pronamic_framework' // page
			);

			foreach ( $post_types as $post_type ) {
				$name = 'pronamic_framework_post_type_description_' . $post_type->name;

				add_settings_field(
					$name, // id
					isset( $post_type->label ) ? $post_type->label : $post_type->name, // title
					array( __CLASS__, 'input_wp_editor' ),  // callback
					'pronamic_framework', // page
					'pronamic_framework_post_type_descriptions', // section
					array( 'label_for' => $name ) // args
				);
			}
		}

		// Settings
		register_setting( 'pronamic_framework', 'pronamic_framework_login_page_id' );
		register_setting( 'pronamic_framework', 'pronamic_framework_logout_page_id' );
		register_setting( 'pronamic_framework', 'pronamic_framework_lostpassword_page_id' );
		register_setting( 'pronamic_framework', 'pronamic_framework_edit_post_page_id' );
		register_setting( 'pronamic_framework', 'pronamic_framework_edit_post_id_key' );

		register_setting( 'pronamic_framework', 'pronamic_framework_html_head' );
		register_setting( 'pronamic_framework', 'pronamic_framework_html_footer' );

		register_setting( 'pronamic_framework', 'pronamic_framework_comment_form_before_text' );

		foreach ( $post_types as $post_type ) {
			$name = 'pronamic_framework_post_type_description_' . $post_type->name;

			register_setting( 'pronamic_framework', $name );
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Settings section
	 */
	public static function settings_section() {

	}

	/**
	 * Input text
	 *
	 * @param array $args
	 */
	public static function input_text( $args ) {
		printf(
			'<input name="%s" id="%s" type="text" value="%s" class="%s" />',
			esc_attr( $args['label_for'] ),
			esc_attr( $args['label_for'] ),
			esc_attr( get_option( $args['label_for'] ) ),
			'regular-text code'
		);

		if ( isset( $args['description'] ) ) {
			printf(
				'<p class="description">%s</p>',
				$args['description']
			);
		}
	}

	/**
	 * Input text
	 *
	 * @param array $args
	 */
	public static function input_textarea( $args ) {
		printf(
			'<textarea name="%s" id="%s" class="%s" rows="10" cols="60">%s</textarea>',
			esc_attr( $args['label_for'] ),
			esc_attr( $args['label_for'] ),
			'regular-text code',
			esc_textarea( get_option( $args['label_for'] ) )
		);
	}

	/**
	 * Input page
	 *
	 * @param array $args
	 */
	public static function input_page( $args ) {
		$name = $args['label_for'];

		wp_dropdown_pages( array(
			'name'             => $name,
			'selected'         => get_option( $name, '' ),
			'show_option_none' => __( '&mdash; Select a page &mdash;', 'pronamic_framework' )
		) );
	}

	/**
	 * Input WordPress editor
	 *
	 * @param array $args
	 */
	public static function input_wp_editor( $args ) {
		$name = $args['label_for'];

		wp_editor( get_option( $name, '' ), $name );
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
			'pronamic_framework' , // menu_slug
			array( __CLASS__, 'options_page' ) // function
		);
	}

	//////////////////////////////////////////////////

	/**
	 * Options page
	 */
	public static function options_page() {
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
		register_post_type( 'pronamic_block', array(
			'labels' => array(
				'name'               => _x( 'Blocks', 'post type general name', 'pronamic_framework' ),
				'singular_name'      => _x( 'Block', 'post type singular name', 'pronamic_framework' ),
				'add_new'            => _x( 'Add New', 'block', 'pronamic_framework' ),
				'add_new_item'       => __( 'Add New Block', 'pronamic_framework' ),
				'edit_item'          => __( 'Edit Block', 'pronamic_framework' ),
				'new_item'           => __( 'New Block', 'pronamic_framework' ),
				'view_item'          => __( 'View Block', 'pronamic_framework' ),
				'search_items'       => __( 'Search Blocks', 'pronamic_framework' ),
				'not_found'          => __( 'No blocks found', 'pronamic_framework' ),
				'not_found_in_trash' => __( 'No blocks found in Trash', 'pronamic_framework' ),
				'parent_item_colon'  => __( 'Parent Block:', 'pronamic_framework' ),
				'menu_name'          => __( 'Blocks', 'pronamic_framework' ),
			),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'page',
			'has_archive'        => false,
			'hierarchical'       => true,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-grid-view',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
		) );
	}

	////////////////////////////////////////////////////////////

	/**
	 * Admin enqueue scripts
	 */
	public static function admin_enqueue_scripts() {
		// This stylesheet is required on all admin pages because of the admin menu icon
		wp_enqueue_style( 'pronamic_framework', plugins_url( '/assets/css/admin.css', self::$file ) );
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

	////////////////////////////////////////////////////////////

	/**
	 * Show text before comment form
	 */
	public static function show_comment_form_before_text() {
		echo get_option( 'pronamic_framework_comment_form_before_text', '' );
	}

	//////////////////////////////////////////////////

	/**
	 * Login URL
	 *
	 * @param string $login_url
	 * @param boolean $redirect
	 * @return string
	 */
	public static function login_url( $login_url, $redirect ) {
		$login_page_id = get_option( 'pronamic_framework_login_page_id' );

		if ( empty( $login_page_id ) ) {
			return $login_url;
		}

		$permalink = get_permalink( $login_page_id );

		if ( empty( $permalink ) ) {
			return $login_url;
		}

		$login_url = $permalink;

		if ( ! empty( $redirect ) ) {
			$login_url = add_query_arg( 'redirect_to', urlencode( $redirect ), $login_url );
		}

		return $login_url;
	}
}
