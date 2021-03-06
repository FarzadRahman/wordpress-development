<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Britt
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="preloader">
	<div class="sk-folding-cube">
		<div class="sk-cube1 sk-cube"></div>
		<div class="sk-cube2 sk-cube"></div>
		<div class="sk-cube4 sk-cube"></div>
		<div class="sk-cube3 sk-cube"></div>
	</div>
</div>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'britt' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="mobile-toggle">
			<button class="btn-menu"><?php esc_html_e( 'Menu', 'britt' ); ?></button>
		</div>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="container">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
				<span class="menu-decoration"></span>
			</div>
		</nav><!-- #site-navigation -->	
		<div class="container">
			<div class="site-branding">
				<?php
				britt_custom_logo();

				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title" data-title="<?php bloginfo( 'name' ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; ?></p>
				<?php
				endif; ?>

				<?php if ( has_nav_menu( 'social' ) ) : ?>
				<nav class="social-navigation clearfix">
						<?php wp_nav_menu( array( 'theme_location' => 'social', 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'menu_class' => 'menu clearfix', 'fallback_cb' => false ) ); ?>
				</nav>
				<?php endif; ?>	

			</div><!-- .site-branding -->

		</div>
	</header><!-- #masthead -->

	<?php do_action('britt_under_header'); ?>

	<div id="content" class="site-content">
		<div class="left-bar"></div>
		
		<?php do_action('britt_featured_area'); ?>	

		<div class="container content-wrapper clearfix">