<?php $images = get_children( array(
	'post_parent' => get_the_ID(),
	'post_type' => 'attachment',
) );
$post_thumbnail_id = get_post_thumbnail_id();
$thumbnail_included = in_array( $post_thumbnail_id, wp_list_pluck( $images, 'ID' ) );
?>
<article <?php post_class( 'column large-12' ); ?> id="post-<?php the_ID(); ?>">
	<div class="row">
		<header class="post-header">
		</header>
		<div class="post-content column medium-5 small-12">
			<div class="post-categories">
				<?php mcfly_the_portfolio_category( ' ', true ); ?>
			</div>
			<?php the_content(); ?>
			<div class="post-tags">
			</div>
		</div>
		<footer class="post-footer column medium-6 small-12">
			<?php if ( ! $thumbnail_included ): ?>
				<div class="portfolio-image">
					<?php the_post_thumbnail( 'porfolio-gallery' ); ?>
				</div>
			<?php endif; ?>
			<?php foreach ( $images as $image ): ?>
				<div class="portfolio-image">
					<?php echo wp_get_attachment_image( $image->ID, 'porfolio-gallery' ); ?>
				</div>
			<?php endforeach; ?>

		</footer>
	</div>
</article>

