<?php
$images = mcfly_get_gallery( get_the_ID() );
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
			<?php foreach ( $images as $image ): ?>
				<div class="portfolio-image">
					<?php echo wp_get_attachment_image( $image, 'porfolio-gallery' ); ?>
				</div>
			<?php endforeach; ?>

		</footer>
	</div>
</article>

