<?php

add_action( 'admin_init', 'mcfly_register_gallery_meta_box' );
function mcfly_register_gallery_meta_box() {
	add_meta_box( 'mcfly-gallery', __( 'Project Gallery', 'mcfly' ), 'mcfly_gallery_meta_box', array( 'jetpack-portfolio' ), 'advanced', 'high' );
}


function mcfly_gallery_meta_box( $post ) {
	$gallery = mcfly_get_gallery( $post->ID );
	$value = implode( ',', $gallery );
	wp_enqueue_script( 'jquery-ui-sortable' );

	?>
	<label for="project-gallery"><span class="screen-reader-text"><?php _e( 'Subtitle', 'mcfly' ); ?></span></label>
	<button class="button" id="portfolio-gallery-select"><?php _e( 'Add Media', 'mcfly' ); ?></button>
	<button class="button" id="portfolio-vimeo-select"><?php _e( 'Add Vimeo', 'mcfly' ); ?></button>
	<input type="hidden" class="widefat" name="project-gallery" id="project-gallery" value="<?php echo $value; ?>">
	<ul id="project-gallery-images">
	</ul>
	<style>
		#project-gallery-images li {
			display: inline-block;
			margin-right:6px;
		}
	</style>
	<script>
		jQuery(document).ready( function($) {
			var media_uploader = null;

			function open_media_uploader_image()
			{
				media_uploader = wp.media({
					frame:    "post",
					state:    "insert",
					multiple: false
				});

				media_uploader.on("insert", function(){
					var length = media_uploader.state().get("selection").length;
					var images = media_uploader.state().get("selection").models;
					console.log(images);

					for (var i = 0; i < length; i++) {
                        add_item(images[i].get('id'));
					}
					refresh_images_list();
				});

				media_uploader.open();
			}

			function add_item( item_id ) {
                var field = jQuery( '#project-gallery' );
                var currentSelection = get_items();
                currentSelection.push(item_id );
                field.val(currentSelection.join(','));
            }

            function has_item( item_id ) {
                var currentSelection = get_items();
                var has_item = false;
                $.each( currentSelection, function( i , item ) {
                    if ( item == item_id ) {
                        has_item = true;
                    }
                });

                return has_item;
            }

            function get_items() {
                var field = jQuery( '#project-gallery' );
                if ( field.val() == '' ) {
                    return [];
                }
                return field.val().split(',');
            }

            function clear_items() {
                var field = jQuery( '#project-gallery' );
                field.val('');
            }

            function remove_item( item_id ) {
                var field = jQuery( '#project-gallery' );
                var currentSelection = get_items();
                var newSelection = [];
                console.log(item_id);
                for ( var i in currentSelection ) {
                    if ( item_id != currentSelection[i] ) {
                        newSelection.push( currentSelection[i] );
                    }
                }
                field.val(newSelection.join(','));
            }

			function refresh_images_list() {
                var field = jQuery( '#project-gallery' );
                var gallery = jQuery('#project-gallery-images')
                jQuery.post( ajaxurl, {gallery:field.val(), action:'load_gallery_list'}, function(response) {
                    gallery.html( response )
                        .sortable({
                            stop: function( event, ui) {
                                var items = gallery.children();
                                clear_items();
                                $.each( items, function( i, item ) {
                                    console.log($(item).data( 'img' ));
                                    add_item( $(item).data( 'img' ) );
                                });
                            }
                        });
                });
            }

            refresh_images_list();
			jQuery('#portfolio-gallery-select').click( function(e) {
				e.preventDefault();
				open_media_uploader_image();
			});

			$('#portfolio-vimeo-select').click(function(e) {
			    e.preventDefault();
                var vimeoId;
			   if ( vimeoId = prompt( 'Vimeo ID' ) ) {
                    add_item( vimeoId );
                    console.log(vimeoId);
                    refresh_images_list();
               }
            });

            jQuery('#project-gallery-images').on( 'click', '.portfolio-gallery-remove', function() {
                var $this = $(this);
                var imgId = $this.data('img');
                $this.parent().remove();
                remove_item(imgId);
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
	foreach ( $gallery as $image_id ): ?>
		<li id="project-gallery-item-<?php echo $image_id; ?>" data-img="<?php echo $image_id; ?>" class="project-gallery-item-<?php echo $type; ?>">
			<?php if ( 'vimeo' == mcfly_get_gallery_item_type( $image_id ) ): ?>
                <img width="40" src="<?php echo get_template_directory_uri() . '/images/vimeo.png'; ?>" alt="">
            <?php elseif ( 'image' !== mcfly_get_gallery_item_type( $image_id ) ): ?>
                <img width="40" src="<?php echo esc_url( includes_url( 'images/media/video.png' ) ); ?>" alt="">
            <?php else: ?>
	            <?php echo wp_get_attachment_image( $image_id, array( 40, 40 ) ); ?>
            <?php endif; ?>
            <br>
            <span data-img="<?php echo $image_id; ?>" class="portfolio-gallery-remove dashicons dashicons-no"></span>
        </li>
	<?php endforeach;
}

add_action( 'wp_ajax_load_gallery_list', 'mcfly_load_gallery_list' );
function mcfly_load_gallery_list() {
    $gallery = $_POST['gallery'];
	$gallery = explode( ',', $gallery );
	mcfly_project_images_html( $gallery );
    die();
}