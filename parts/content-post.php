<article <?php post_class( 'column large-12' ); ?> id="post-<?php the_ID(); ?>">
	<header class="post-header">
		<?php if ( has_post_thumbnail() ): ?>
			<?php the_post_thumbnail( 'post-blog' ); ?>
		<?php endif; ?>
	</header>
	<div class="post-content row align-center">
		<div class="column large-12">
			<div class="post-date"><small><?php the_time( get_option( 'date_format' ) ); ?></small></div>
			<?php the_category( '' ); ?>
			<?php the_content(); ?>
			<div class="post-tags">
				<?php the_tags( __( 'Tags:', 'mcfly' ) . ' ', ', ' ); ?>
			</div>
		</div>
	</div>
	<footer class="post-footer row"></footer>
</article>