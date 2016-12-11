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
    <div class="column large-4">
        <div class="site-branding">
		    <?php mcfly_blog_title(); ?>
        </div>
    </div>
    <div class="column large-8 text-right">
        <div class="title-bar-title show-for-sr">Menu</div>
        <button id="menu-icon" class="menu-icon show-for-small-only" type="button"></button>
        <?php if ( has_nav_menu( 'primary' ) ): ?>
            <div id="primary-menu" class="hide-for-small-only">
		        <?php
		        // Primary navigation menu.
		        wp_nav_menu( array(
			        'menu_class'     => 'horizontal menu',
			        'theme_location' => 'primary'
		        ) );
		        ?>
            </div>
        <?php endif; ?>
    </div>
</header>

<script>
    ( function() {
        var menuIcon = document.getElementById( 'menu-icon' );
        var menu = document.getElementById('primary-menu');
        function toggleMenu() {
            var className = 'hide-for-small-only';
            if ( isMenuVisible() ) {
                if (menu.classList)
                    menu.classList.add(className);
                else
                    menu.className += ' ' + className;
            }
            else {
                if (menu.classList)
                    menu.classList.remove(className);
                else
                    menu.className = menu.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
            }
        }

        function isMenuVisible() {
            if (menu.classList)
                return ! menu.classList.contains('hide-for-small-only');
            else
                return ! new RegExp('(^| )hide-for-small-only( |$)', 'gi').test(menu.className);
        }
        menuIcon.onclick = toggleMenu;
    }());
</script>

<div id="content" class="row <?php echo mcfly_content_class(); ?>" role="main">