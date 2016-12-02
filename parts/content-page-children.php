<?php $children = mcfly_get_page_children(); ?>
<article <?php post_class( 'column large-12 has-children' ); ?> id="post-<?php the_ID(); ?>">
	<header class="post-header">
		<?php if ( has_post_thumbnail() ): ?>
			<?php the_post_thumbnail( 'post-blog' ); ?>
		<?php endif; ?>
	</header>
	<div class="post-content row align-center">
		<div class="column large-12">
			<?php the_content(); ?>
			<div class="page-children">
				<?php foreach ( $children as $child ): ?>
					<div class="page-child row collapse">
						<div class="page-child-title column large-3 small-12"><?php echo $child['post_title']; ?></div>
						<div class="page-child-content column large-9 small-12"><?php echo $child['post_content']; ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<footer class="post-footer row"></footer>
</article>