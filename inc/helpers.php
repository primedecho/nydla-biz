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
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Hub', 'nydla-biz' ) . '</a></li>';
	$tac = (string) nydla_biz_mod( 'nydla_biz_tac_url', 'https://tac-usa.com/' );
	$lab = (string) nydla_biz_mod( 'nydla_biz_tac_label', __( 'Shop via TAC-USA', 'nydla-biz' ) );
	if ( $tac ) {
		echo '<li><a href="' . esc_url( $tac ) . '">' . esc_html( $lab ) . '</a></li>';
	}
	echo '</ul>';
}
