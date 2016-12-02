<?php get_header(); ?>

<h1 class="page-title"><?php the_title(); ?></h1>
<?php if ( mcfly_get_subtitle() ): ?>
	<h2 class="page-subtitle"><?php echo esc_html( mcfly_get_subtitle() ); ?></h2>
<?php endif; ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'parts/content', 'portfolio' ); ?>
<?php endwhile; endif; ?>

<?php get_footer(); ?>