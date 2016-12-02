</div>
<footer id="colophon" class="row site-footer" role="contentinfo">
	<div class="column large-3 small-12">
		<?php if ( is_active_sidebar( 'footer-left' ) ): ?>

			<?php dynamic_sidebar( 'footer-left' ); ?>

		<?php endif; ?>
	</div>
	<div class="column large-3 small-12">
		<?php if ( is_active_sidebar( 'footer-center-left' ) ): ?>

			<?php dynamic_sidebar( 'footer-center-left' ); ?>

		<?php endif; ?>
	</div>
	<div class="column large-3 small-12">

		<?php if ( is_active_sidebar( 'footer-center-right' ) ): ?>

			<?php dynamic_sidebar( 'footer-center-right' ); ?>

		<?php endif; ?>
	</div>
	<div class="column large-3 small-12">
		<?php if ( is_active_sidebar( 'footer-right' ) ): ?>

			<?php dynamic_sidebar( 'footer-right' ); ?>

		<?php endif; ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>