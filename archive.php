<?php get_header(); ?>
	<h1 class="page-title"><?php the_archive_title(); ?></h1>


	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'parts/content' ); ?>
	<?php endwhile; endif; ?>

<?php get_footer(); ?>