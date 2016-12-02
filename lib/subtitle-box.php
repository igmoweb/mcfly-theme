<?php

add_action( 'admin_init', 'mcfly_register_subtitle_meta_box' );
function mcfly_register_subtitle_meta_box() {
	add_meta_box( 'mcfly-subtitle', __( 'Subtitle', 'mcfly' ), 'mcfly_subtitle_meta_box', array( 'page', 'post', 'jetpack-portfolio' ), 'advanced', 'high' );
}


function mcfly_subtitle_meta_box( $post ) {
	?>
	<label for="subtitle"><?php _e( 'Subtitle', 'mcfly' ); ?></label>
	<input type="text" class="widefat" name="subtitle" id="subtitle">
	<?php
	wp_nonce_field( 'mcfly-subtitle-box', 'mcfly-subtitle-box' );
}

add_action( 'save_post', 'mcfly_save_subtitle_box' );
function mcfly_save_subtitle_box( $post_id ) {
	if ( ! isset( $_POST['mcfly-subtitle-box'] ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	check_admin_referer( 'mcfly-subtitle-box', 'mcfly-subtitle-box' );

	$subtitle = sanitize_text_field( $_POST['subtitle'] );
	if ( '' === $subtitle ) {
		delete_post_meta( $post_id, '_subtitle' );
	}
	else {
		update_post_meta( $post_id, '_subtitle', $subtitle );
	}
}

function mcfly_get_subtitle( $post_id = false ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	return get_post_meta( $post_id, '_subtitle', true );
}

