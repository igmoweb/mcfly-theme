<?php

add_action( 'admin_init', 'mcfly_register_gallery_meta_box' );
function mcfly_register_gallery_meta_box() {
	add_meta_box( 'mcfly-gallery', __( 'Project Gallery', 'mcfly' ), 'mcfly_gallery_meta_box', array( 'jetpack-portfolio' ), 'advanced', 'high' );
}


function mcfly_gallery_meta_box( $post ) {
	$gallery = mcfly_get_gallery( $post->ID );
	$value = implode( ',', $gallery );

	?>
	<label for="project-gallery"><span class="screen-reader-text"><?php _e( 'Subtitle', 'mcfly' ); ?></span></label>
	<button class="button" id="portfolio-gallery-select"><?php _e( 'Select images', 'mcfly' ); ?></button>
	<input type="hidden" class="widefat" name="project-gallery" id="project-gallery" value="<?php echo $value; ?>">
	<ul id="project-gallery-images">
		<?php mcfly_project_images_html( $gallery ); ?>
	</ul>
	<style>
		#project-gallery-images li {
			display: inline-block;
			margin-right:6px;
		}
	</style>
	<script>
		jQuery(document).ready( function() {
			var media_uploader = null;

			function open_media_uploader_image()
			{
				media_uploader = wp.media({
					frame:    "post",
					state:    "insert",
					multiple: true
				});

				var field = jQuery( '#project-gallery' );

				media_uploader.on('open', function() {
					var selection = media_uploader.state().get('selection');
					var currentSelection = field.val().split(',');
					for ( i in currentSelection ) {
						selection.add(wp.media.attachment(currentSelection[i]));
					}
					console.log(selection);
				});

				media_uploader.on("insert", function(){
					var length = media_uploader.state().get("selection").length;
					var images = media_uploader.state().get("selection").models;
					var imageIds = [];

					for (var i = 0; i < length; i++) {
						imageIds.push(images[i].get('id'));
					}
					imageIds = imageIds.join(',');
					field.val(imageIds);
				});

				media_uploader.open();
			}

			jQuery('#portfolio-gallery-select').click( function(e) {
				e.preventDefault();
				open_media_uploader_image();
			});
		});
	</script>
	<?php
	wp_nonce_field( 'mcfly-gallery-box', 'mcfly-gallery-box' );
}

add_action( 'save_post', 'mcfly_save_gallery_box' );
function mcfly_save_gallery_box( $post_id ) {
	if ( ! isset( $_POST['mcfly-gallery-box'] ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( 'jetpack-portfolio' !== get_post_type( $post_id ) ) {
		return;
	}

	check_admin_referer( 'mcfly-gallery-box', 'mcfly-gallery-box' );

	$gallery = explode( ',', $_POST['project-gallery'] );
	$gallery = array_map( 'absint', $gallery );
	$value = array();
	foreach ( $gallery as $item ) {
		if ( get_post( $item ) ) {
			$value[] = $item;
		}
	}
	if ( empty( $value ) ) {
		delete_post_meta( $post_id, '_gallery' );
	}
	else {
		update_post_meta( $post_id, '_gallery', $gallery );
	}
}

function mcfly_get_gallery( $post_id = false ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$gallery = get_post_meta( $post_id, '_gallery', true );
	if ( ! is_array( $gallery ) ) {
		$gallery = array();
	}

	return array_map( 'absint', $gallery );

}

function mcfly_project_images_html( $gallery ) {
	?>
	<?php foreach ( $gallery as $image_id ): ?>
		<li><?php echo wp_get_attachment_image( $image_id, array( 40, 40 ) ); ?></li>
	<?php endforeach; ?>
	<?php
}