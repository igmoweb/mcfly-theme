<article <?php post_class( 'column large-12 small-12' ); ?> id="post-<?php the_ID(); ?>">
	<header class="post-header">
		<?php if ( has_post_thumbnail() ): ?>
			<?php the_post_thumbnail( 'post-blog' ); ?>
		<?php endif; ?>
	</header>
	<div class="post-content row align-center">
		<div class="column large-12">
			<?php the_content(); ?>
		</div>
	</div>
	<footer class="post-footer row"></footer>
</article>