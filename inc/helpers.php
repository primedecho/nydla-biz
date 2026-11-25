<?php
/**
 * Theme helpers.
 *
 * @package Nydla_Biz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme mod with default.
 *
 * @param string $key     Mod key.
 * @param mixed  $default Default.
 * @return mixed
 */
function nydla_biz_mod( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

/**
 * Brand logo URL — Customizer logo, then bundled mark.
 *
 * @return string
 */
function nydla_biz_logo_url() {
	$custom_id = (int) get_theme_mod( 'custom_logo' );
	if ( $custom_id ) {
		$url = wp_get_attachment_image_url( $custom_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	$path = NYDLA_BIZ_DIR . '/assets/images/brand/nydla-logo.png';
	if ( file_exists( $path ) ) {
		return add_query_arg( 'v', (string) filemtime( $path ), trailingslashit( NYDLA_BIZ_URI ) . 'assets/images/brand/nydla-logo.png' );
	}

	return trailingslashit( NYDLA_BIZ_URI ) . 'assets/images/brand/nydla-logo.png';
}

/**
 * Sanitize hex or empty.
 *
 * @param string $color Color.
 * @return string
 */
function nydla_biz_sanitize_hex( $color ) {
	$color = sanitize_hex_color( $color );
	return $color ? $color : '';
}

/**
 * Clamp int.
 *
 * @param mixed $value Value.
 * @param int   $min   Min.
 * @param int   $max   Max.
 * @param int   $fallback Fallback.
 * @return int
 */
function nydla_biz_clamp_int( $value, $min, $max, $fallback ) {
	$n = (int) $value;
	if ( $n < $min || $n > $max ) {
		return (int) $fallback;
	}
	return $n;
}

/**
 * Fallback primary nav when no menu is assigned.
 */
function nydla_biz_nav_fallback() {
	echo '<ul class="site-nav__list">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'nydla-biz' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#showcases' ) ) . '">' . esc_html__( 'Sponsors', 'nydla-biz' ) . '</a></li>';
	echo '</ul>';
}

/**
 * One-time soft migrate from the first dark / marketing-heavy defaults.
 */
function nydla_biz_migrate_light_pass() {
	if ( '1.0.1' === (string) get_theme_mod( 'nydla_biz_pass', '' ) ) {
		return;
	}

	$colors = array(
		'nydla_biz_color_ink'     => array( '#070a0f', '#f3f4f6' ),
		'nydla_biz_color_panel'   => array( '#10151e', '#ffffff' ),
		'nydla_biz_color_line'    => array( '#243044', '#d8dde5' ),
		'nydla_biz_color_fog'     => array( '#9aa6b8', '#5b6575' ),
		'nydla_biz_color_paper'   => array( '#f4f6f9', '#16191f' ),
		'nydla_biz_color_accent'  => array( '#e08920', '#c9852a' ),
		'nydla_biz_color_accent2' => array( '#3d9cf0', '#1f4f8a' ),
	);
	foreach ( $colors as $key => $pair ) {
		$current = get_theme_mod( $key, null );
		if ( null === $current || '' === $current || strtolower( (string) $current ) === strtolower( $pair[0] ) ) {
			set_theme_mod( $key, $pair[1] );
		}
	}

	$copy = array(
		'nydla_biz_hero_title'   => array( 'Vendor product theater', 'Sponsor showcases' ),
		'nydla_biz_hero_text'    => array(
			'Live sponsor mini-sites — sharp product stories, not a second association sitemap.',
			'Product pages from NYDLA sponsors — clear, short, and ready to share.',
		),
		'nydla_biz_hub_heading'  => array( 'Live showcases', 'Sponsors' ),
		'nydla_biz_hub_intro'    => array(
			'Open a mini-site for product detail. Purchases path through TAC-USA.',
			'Choose a sponsor to open their product page.',
		),
		'nydla_biz_tac_label'    => array( 'Shop via TAC-USA', 'Purchase path' ),
		'nydla_biz_footer_copy'  => array( 'NYDLA.biz — sponsor showcases for the NYDLA network.', 'NYDLA.biz' ),
		'nydla_biz_footer_note'  => array( 'Purchases path through TAC-USA. No cart on this site.', '' ),
	);
	foreach ( $copy as $key => $pair ) {
		$current = (string) get_theme_mod( $key, $pair[0] );
		if ( $current === $pair[0] ) {
			set_theme_mod( $key, $pair[1] );
		}
	}

	set_theme_mod( 'nydla_biz_pass', '1.0.1' );
}
add_action( 'after_setup_theme', 'nydla_biz_migrate_light_pass', 20 );
