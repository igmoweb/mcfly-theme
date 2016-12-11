<article <?php post_class( 'column large-12 small-12' ); ?> id="post-<?php the_ID(); ?>">
	<header class="post-header">
		<?php if ( has_post_thumbnail() ): ?>
			<?php the_post_thumbnail( 'post-blog' ); ?>
		<?php endif; ?>
	</header>
	<div class="post-content row align-center">
		<div class="column small-12">
			<div class="post-date"><small><?php the_time( get_option( 'date_format' ) ); ?></small></div>
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<?php the_category( '' ); ?>
			<?php the_content(); ?>
		</div>
	</div>
	<footer class="post-footer row"></footer>
</article>