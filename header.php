<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header id="masthead" class="site-header row collapse" role="banner">
	<div class="site-branding column large-4">
		<?php mcfly_blog_title(); ?>
	</div>

	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<div class="column large-8">
			<div class="title-bar" data-responsive-toggle="primary-menu" data-hide-for="medium">
				<button class="menu-icon" type="button" data-toggle></button>
				<div class="title-bar-title show-for-sr"><?php _e( 'Menu', 'mcfly' ); ?>></div>
			</div>

			<div id="primary-menu">
			<?php
							// Primary navigation menu.
							wp_nav_menu( array(
								'menu_class'     => 'horizontal menu',
								'theme_location' => 'primary'
							) );
							?>
			</div>
		</div>
	<?php endif; ?>
</header>

<div id="content" class="row" role="main">