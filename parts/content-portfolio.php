<article <?php post_class( 'column large-5 small-12' ); ?> id="post-<?php the_ID(); ?>">
    <header class="post-header">
    </header>
    <div class="post-content">
        <div class="post-categories">
            <?php mcfly_the_portfolio_category( ' ', true ); ?>
        </div>
        <?php the_content(); ?>
        <div class="post-tags">
        </div>
    </div>
    <footer class="post-footer"></footer>
</article>
<div class="column large-6 small-12 project-gallery">
	<?php mcfly_the_project_gallery( get_the_ID() ); ?>
</div>