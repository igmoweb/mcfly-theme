<?php get_header(); ?>
<div class="portfolio-types-filter-wrap">
	<h1 class="page-title"><?php _e( 'Portfolio', 'mcfly' ); ?></h1>
	<div class="portfolio-types-filter">
		<?php mcfly_the_portfolio_types(); ?>
	</div>
</div>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'parts/content-archive', 'portfolio' ); ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>