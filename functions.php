<?php

include_once( 'lib/template-tags.php' );
include_once( 'lib/subtitle-box.php' );

class McFly_Theme {
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Theme initialization
	 */
	public function init() {
		load_child_theme_textdomain( 'mcfly', get_stylesheet_directory() . '/languages' );

		add_theme_support( 'custom-logo' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );

		$defaults = array(
			'default-color'          => '#F0F0EA',
		);
		add_theme_support( 'custom-background', $defaults );

		// Image sizes
		add_image_size( 'post-blog', 1218, 450, true );
		add_image_size( 'portfolio-item', 500, 500, true );
		add_image_size( 'porfolio-gallery', 600, 500, true );

		// Sidebars
		register_sidebar( array(
			'name' => __( 'Footer Left', 'mcfly' ),
			'id' => 'footer-left',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		) );

		register_sidebar( array(
			'name' => __( 'Footer Center Left', 'mcfly' ),
			'id' => 'footer-center-left',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		) );

		register_sidebar( array(
			'name' => __( 'Footer Center Right', 'mcfly' ),
			'id' => 'footer-center-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		) );

		register_sidebar( array(
			'name' => __( 'Footer Right', 'mcfly' ),
			'id' => 'footer-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		) );

		// Nav menus
		register_nav_menus( array(
			'primary' => __( 'Primary Menu',      'mcfly' ),
			'social'  => __( 'Social Links Menu', 'mcfly' ),
		) );
	}

	function enqueue_scripts() {
		wp_enqueue_style( 'mcfly-fonts', 'https://fonts.googleapis.com/css?family=Roboto|Suranna' );
		wp_enqueue_style( 'mcfly', get_template_directory_uri() . '/css/mcfly.css', array(), '201611251000' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script(
			'mcfly-foundation',
			get_template_directory_uri() . '/js/foundation.min.js',
			array( 'jquery' )
		);

		$js = '
jQuery( document ).ready( function() {
	jQuery(document).foundation();
} );		
';
		wp_add_inline_script( 'mcfly-foundation', $js );
	}
}

new McFly_Theme();


/**
 * Get the children of a page
 *
 * @param $id
 *
 * @return array
 */
function mcfly_get_page_children( $id = false ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}
	if ( 'page' != get_post_type( $id ) ) {
		return array();
	}

	$_children = get_children( array(
		'post' => $id,
		'post_type' => 'page',
		'post_status' => 'publish',
		'post_parent' => $id
	) );

	$children = array();
	foreach ( $_children as $child ) {
		$children[] = array(
			'post_content' => $child->post_content,
			'post_title' => get_the_title( $child->ID )
		);
	}
	return $children;
}
