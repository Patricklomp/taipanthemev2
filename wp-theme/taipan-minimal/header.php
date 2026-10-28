<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main">Liigu sisu juurde</a>

<nav class="nav site-nav" aria-label="Peamenüü">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-brand"><?php bloginfo( 'name' ); ?></a>
	<div class="site-nav-links">
		<?php taipan_nav_links(); ?>
	</div>
</nav>
