<?php
/**
 * NYDLA.biz theme — sponsor hub + mini-sites.
 *
 * @package Nydla_Biz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NYDLA_BIZ_VERSION', '1.0.3' );
define( 'NYDLA_BIZ_DIR', get_template_directory() );
define( 'NYDLA_BIZ_URI', get_template_directory_uri() );

require_once NYDLA_BIZ_DIR . '/inc/helpers.php';
require_once NYDLA_BIZ_DIR . '/inc/customizer.php';
require_once NYDLA_BIZ_DIR . '/inc/customizer-hub.php';
require_once NYDLA_BIZ_DIR . '/inc/minisite-meta.php';

/**
 * Theme supports, menus, image sizes.
 */
function nydla_biz_setup() {
	load_theme_textdomain( 'nydla-biz', NYDLA_BIZ_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 72,
			'width'       => 280,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'nydla-biz' ),
			'footer'  => __( 'Footer Navigation', 'nydla-biz' ),
		)
	);

	add_image_size( 'nydla-biz-hero', 1600, 900, true );
	add_image_size( 'nydla-biz-card', 720, 480, true );
	add_image_size( 'nydla-biz-logo', 480, 160, false );
}
add_action( 'after_setup_theme', 'nydla_biz_setup' );

/**
 * Front assets.
 */
function nydla_biz_enqueue_assets() {
	$css = NYDLA_BIZ_DIR . '/assets/css/main.css';
	$js  = NYDLA_BIZ_DIR . '/assets/js/main.js';

	wp_enqueue_style(
		'nydla-biz-fonts',
		'https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'nydla-biz-main',
		NYDLA_BIZ_URI . '/assets/css/main.css',
		array( 'nydla-biz-fonts' ),
		file_exists( $css ) ? (string) filemtime( $css ) : NYDLA_BIZ_VERSION
	);

	if ( file_exists( $js ) && filesize( $js ) > 0 ) {
		wp_enqueue_script(
			'nydla-biz-main',
			NYDLA_BIZ_URI . '/assets/js/main.js',
			array(),
			(string) filemtime( $js ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'nydla_biz_enqueue_assets' );

/**
 * Content width.
 */
function nydla_biz_content_width() {
	$GLOBALS['content_width'] = 1120;
}
add_action( 'after_setup_theme', 'nydla_biz_content_width', 0 );
