<article <?php post_class( 'column large-3 small-4 collapse' ); ?> id="post-<?php the_ID(); ?>" onclick="location.href='<?php echo esc_url( get_permalink() ); ?>'">
	<header class="post-header">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php if ( has_post_thumbnail() ): ?>
				<?php the_post_thumbnail( 'portfolio-item' ); ?>
			<?php endif; ?>
		</a>
	</header>
	<div class="post-content row">
		<h2 class="post-title"><?php the_title(); ?></h2>
		<div class="portfolio-types">
			<?php mcfly_the_portfolio_category(); ?>
		</div>
	</div>
	<footer class="post-footer row"></footer>
</article>