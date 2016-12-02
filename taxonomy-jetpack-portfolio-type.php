<?php get_header(); ?>
<h1 class="page-title"><?php echo get_the_archive_title(); ?></h1>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'parts/content-archive', 'portfolio' ); ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>