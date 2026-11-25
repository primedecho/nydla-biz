<?php
/**
 * Header — commercial dark chrome, logo left / nav right.
 *
 * @package Nydla_Biz
 */

$nydla_biz_logo = nydla_biz_logo_url();
$nydla_biz_alt  = get_bloginfo( 'name', 'display' );
$sticky         = (bool) nydla_biz_mod( 'nydla_biz_header_sticky', true );
$tagline        = trim( (string) nydla_biz_mod( 'nydla_biz_header_tagline', __( 'Sponsor showcases', 'nydla-biz' ) ) );
$header_class   = 'site-header' . ( $sticky ? ' site-header--sticky' : '' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'nydla-biz' ); ?></a>

<header class="<?php echo esc_attr( $header_class ); ?>" role="banner">
	<div class="site-header__inner">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img
				src="<?php echo esc_url( $nydla_biz_logo ); ?>"
				alt="<?php echo esc_attr( $nydla_biz_alt ); ?>"
				width="280"
				height="72"
				decoding="async"
				fetchpriority="high"
			>
			<?php if ( $tagline ) : ?>
				<span class="site-logo__tag"><?php echo esc_html( $tagline ); ?></span>
			<?php endif; ?>
		</a>

		<button
			class="site-header__toggle"
			type="button"
			aria-controls="site-navigation"
			aria-expanded="false"
			data-biz-nav-toggle
		>
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'nydla-biz' ); ?></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</button>

		<nav id="site-navigation" class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'nydla-biz' ); ?>" data-biz-nav>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'fallback_cb'    => 'nydla_biz_nav_fallback',
					'depth'          => 1,
				)
			);
			?>
		</nav>
	</div>
</header>

<main id="main" class="site-main">

