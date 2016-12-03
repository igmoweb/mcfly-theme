<?php

add_action( 'wp_enqueue_scripts', 'mcfly_child_enqueue_styles' );
function mcfly_child_enqueue_styles() {
	wp_enqueue_style( 'mcfly-parent', get_stylesheet_uri() );
}