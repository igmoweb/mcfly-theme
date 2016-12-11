<?php

/**
 * Display logo/blog title in header
 */
function mcfly_blog_title() {
	$logo = get_custom_logo();
	if ( $logo ) {
		$blogname = '<span class="show-for-sr">' . get_bloginfo( 'blogname' ) . '</span>';
	}
	else {
		$blogname = get_bloginfo( 'blogname' );
	}

	if ( is_front_page() || is_home() )  {
		?>
		<h1 class="site-title">
			<a href="<?php bloginfo( 'url' ); ?>">
				<?php echo $blogname; ?>
				<?php if ( $logo ): ?>
					<?php the_custom_logo(); ?>
				<?php endif; ?>
			</a>
		</h1>
		<?php
	}
	else {
		?>
		<p class="site-title">
			<a href="<?php bloginfo( 'url' ); ?>">
				<?php echo $blogname; ?>
				<?php if ( $logo ): ?>
					<?php the_custom_logo(); ?>
				<?php endif; ?>
			</a>
		</p>
		<?php
	}
}

/**
 * Show a list of portfolio types for a proyect
 */
function mcfly_the_portfolio_category( $sep = ', ', $links = false ) {
	global $wp_rewrite;

	$post_id = get_the_ID();

	$categories = get_the_terms( $post_id, 'jetpack-portfolio-type' );
	if ( ! $categories || is_wp_error( $categories ) )
		$categories = array();

	$categories = array_values( $categories );

	$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="portfolio-type tag"' : 'rel="portfolio-type"';

	$thelist = '';
	$i = 0;
	foreach ( $categories as $category ) {
		if ( 0 < $i ) {
			$thelist .= $sep;
		}
		if ( $links ) {
			$thelist .= '<span><a href="' . esc_url( get_term_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name.'</a></span>';
		}
		else {
			$thelist .= '<span>' . $category->name . '</span>';
		}

		++$i;
	}

	echo $thelist;
}

function mcfly_the_portfolio_types() {
	$terms = get_terms(
		array(
			'taxonomy'     => 'jetpack-portfolio-type',
			'hierarchical' => false
		)
	);

	?>
	<ul>
		<?php foreach ( $terms as $term ): ?>
			<li>
				<a href="<?php echo esc_url( get_term_link( $term->term_id ) ); ?>"
				   title="<?php printf( esc_attr__( 'See projects within %s category', 'mcfly' ), $term->name ); ?>">
					<?php echo $term->name; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

function mcfly_the_project_gallery( $post_id ) {
	$images = mcfly_get_gallery( get_the_ID() );
    foreach ( $images as $image ) {
        $type  = mcfly_get_gallery_item_type( $image );
        if ( 'image' === $type ) {
            ?>
            <div class="portfolio-image portfolio-item">
		        <?php echo wp_get_attachment_image( $image, 'fullsize' ); ?>
            </div>
            <?php
        }
        elseif ( 'vimeo' === $type ) {
	        ?>
            <div class="portfolio-vimeo portfolio-item flex-video">
                <iframe src="https://player.vimeo.com/video/<?php echo $image; ?>?byline=0" width="800" height="450" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
	        <?php
        }
        else {
	        $url = wp_get_attachment_url( $image );
	        ?>
            <div class="portfolio-video portfolio-item flex-video">
                <?php echo do_shortcode( '[video src="' . $url . '"]' ); ?>
            </div>
	        <?php
        }
    }
}

function mcfly_content_class() {
    if ( is_single() && 'jetpack-portfolio' === get_post_type() ) {
        return 'align-justify';
    }
    return '';
}