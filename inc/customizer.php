<?php
/**
 * Customizer — brand, chrome, colors, CTAs, footer.
 *
 * @package Nydla_Biz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer panel + chrome sections.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function nydla_biz_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'nydla_biz_theme',
		array(
			'title'       => __( 'NYDLA.biz Theme', 'nydla-biz' ),
			'description' => __( 'Sponsor hub and mini-site look — brand, colors, CTAs, hub showcases. Page copy stays in the page editor.', 'nydla-biz' ),
			'priority'    => 28,
		)
	);

	/* Brand */
	$wp_customize->add_section(
		'nydla_biz_brand',
		array(
			'title'    => __( 'Brand & logo', 'nydla-biz' ),
			'panel'    => 'nydla_biz_theme',
			'priority' => 10,
		)
	);

	$logo = $wp_customize->get_control( 'custom_logo' );
	if ( $logo ) {
		$logo->section     = 'nydla_biz_brand';
		$logo->priority    = 5;
		$logo->description = __( 'Header logo. If empty, the bundled NYDLA mark is used.', 'nydla-biz' );
	}

	$icon = $wp_customize->get_control( 'site_icon' );
	if ( $icon ) {
		$icon->section  = 'nydla_biz_brand';
		$icon->priority = 6;
	}

	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_logo_max_h',
		'nydla_biz_brand',
		array(
			'label'       => __( 'Logo max height (px)', 'nydla-biz' ),
			'default'     => 48,
			'type'        => 'number',
			'input_attrs' => array( 'min' => 28, 'max' => 120, 'step' => 1 ),
			'priority'    => 10,
		)
	);

	/* Colors */
	$wp_customize->add_section(
		'nydla_biz_colors',
		array(
			'title'    => __( 'Colors & surfaces', 'nydla-biz' ),
			'panel'    => 'nydla_biz_theme',
			'priority' => 20,
		)
	);

	$colors = array(
		'nydla_biz_color_ink'     => array( 'label' => __( 'Page background', 'nydla-biz' ), 'default' => '#f3f4f6' ),
		'nydla_biz_color_panel'   => array( 'label' => __( 'Panel / header', 'nydla-biz' ), 'default' => '#ffffff' ),
		'nydla_biz_color_line'    => array( 'label' => __( 'Lines / borders', 'nydla-biz' ), 'default' => '#d8dde5' ),
		'nydla_biz_color_fog'     => array( 'label' => __( 'Muted text', 'nydla-biz' ), 'default' => '#5b6575' ),
		'nydla_biz_color_paper'   => array( 'label' => __( 'Primary text', 'nydla-biz' ), 'default' => '#16191f' ),
		'nydla_biz_color_accent'  => array( 'label' => __( 'Accent (buttons / marks)', 'nydla-biz' ), 'default' => '#c9852a' ),
		'nydla_biz_color_accent2' => array( 'label' => __( 'Link accent', 'nydla-biz' ), 'default' => '#1f4f8a' ),
	);

	foreach ( $colors as $id => $args ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $args['default'],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$id,
				array(
					'label'   => $args['label'],
					'section' => 'nydla_biz_colors',
				)
			)
		);
	}

	/* Header */
	$wp_customize->add_section(
		'nydla_biz_header',
		array(
			'title'    => __( 'Header', 'nydla-biz' ),
			'panel'    => 'nydla_biz_theme',
			'priority' => 30,
		)
	);

	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_header_sticky',
		'nydla_biz_header',
		array(
			'label'   => __( 'Sticky header', 'nydla-biz' ),
			'default' => true,
			'type'    => 'checkbox',
		)
	);

	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_header_tagline',
		'nydla_biz_header',
		array(
			'label'   => __( 'Header tagline (optional)', 'nydla-biz' ),
			'default' => __( 'Sponsor showcases', 'nydla-biz' ),
			'type'    => 'text',
		)
	);

	/* Hub hero */
	$wp_customize->add_section(
		'nydla_biz_hub_hero',
		array(
			'title'       => __( 'Hub hero', 'nydla-biz' ),
			'description' => __( 'Top of the sponsor hub (.biz home). Keep it short.', 'nydla-biz' ),
			'panel'       => 'nydla_biz_theme',
			'priority'    => 40,
		)
	);

	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_hero_eyebrow',
		'nydla_biz_hub_hero',
		array(
			'label'   => __( 'Eyebrow', 'nydla-biz' ),
			'default' => __( 'NYDLA.biz', 'nydla-biz' ),
			'type'    => 'text',
		)
	);
	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_hero_title',
		'nydla_biz_hub_hero',
		array(
			'label'   => __( 'Headline', 'nydla-biz' ),
			'default' => __( 'Sponsor showcases', 'nydla-biz' ),
			'type'    => 'text',
		)
	);
	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_hero_text',
		'nydla_biz_hub_hero',
		array(
			'label'   => __( 'Supporting line', 'nydla-biz' ),
			'default' => __( 'Product pages from NYDLA sponsors — clear, short, and ready to share.', 'nydla-biz' ),
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'nydla_biz_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'nydla_biz_hero_image',
			array(
				'label'       => __( 'Hero product visual', 'nydla-biz' ),
				'description' => __( 'Optional product / vendor image beside the headline.', 'nydla-biz' ),
				'section'     => 'nydla_biz_hub_hero',
			)
		)
	);

	/* CTAs */
	$wp_customize->add_section(
		'nydla_biz_ctas',
		array(
			'title'       => __( 'CTAs', 'nydla-biz' ),
			'description' => __( 'Primary and contact buttons. Optional purchase path appears once in the footer.', 'nydla-biz' ),
			'panel'       => 'nydla_biz_theme',
			'priority'    => 50,
		)
	);

	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_cta_primary_label',
		'nydla_biz_ctas',
		array(
			'label'   => __( 'Primary CTA label', 'nydla-biz' ),
			'default' => __( 'Learn more', 'nydla-biz' ),
			'type'    => 'text',
		)
	);
	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_cta_primary_url',
		'nydla_biz_ctas',
		array(
			'label'   => __( 'Primary CTA URL', 'nydla-biz' ),
			'default' => '#showcases',
			'type'    => 'url',
		)
	);
	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_cta_secondary_label',
		'nydla_biz_ctas',
		array(
			'label'   => __( 'Secondary CTA label', 'nydla-biz' ),
			'default' => __( 'Contact', 'nydla-biz' ),
			'type'    => 'text',
		)
	);
	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_cta_secondary_url',
		'nydla_biz_ctas',
		array(
			'label'   => __( 'Secondary CTA URL', 'nydla-biz' ),
			'default' => 'mailto:info@nydla.org',
			'type'    => 'url',
		)
	);
	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_tac_label',
		'nydla_biz_ctas',
		array(
			'label'       => __( 'Footer purchase-path label', 'nydla-biz' ),
			'description' => __( 'Shown once in the footer. Leave blank to hide.', 'nydla-biz' ),
			'default'     => __( 'Purchase path', 'nydla-biz' ),
			'type'        => 'text',
		)
	);
	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_tac_url',
		'nydla_biz_ctas',
		array(
			'label'   => __( 'Footer purchase-path URL', 'nydla-biz' ),
			'default' => 'https://tac-usa.com/',
			'type'    => 'url',
		)
	);

	/* Mini-site defaults */
	$wp_customize->add_section(
		'nydla_biz_minisite',
		array(
			'title'       => __( 'Mini-site defaults', 'nydla-biz' ),
			'description' => __( 'Shared defaults for sponsor mini-site pages. Per-page accent can be set on each page.', 'nydla-biz' ),
			'panel'       => 'nydla_biz_theme',
			'priority'    => 60,
		)
	);

	$wp_customize->add_setting(
		'nydla_biz_minisite_accent',
		array(
		'default'           => '#c9852a',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'nydla_biz_minisite_accent',
			array(
				'label'   => __( 'Default sponsor accent', 'nydla-biz' ),
				'section' => 'nydla_biz_minisite',
			)
		)
	);

	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_minisite_cta_label',
		'nydla_biz_minisite',
		array(
			'label'   => __( 'Default mini-site CTA label', 'nydla-biz' ),
			'default' => __( 'Learn more', 'nydla-biz' ),
			'type'    => 'text',
		)
	);

	/* Footer */
	$wp_customize->add_section(
		'nydla_biz_footer',
		array(
			'title'    => __( 'Footer', 'nydla-biz' ),
			'panel'    => 'nydla_biz_theme',
			'priority' => 70,
		)
	);

	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_footer_copy',
		'nydla_biz_footer',
		array(
			'label'   => __( 'Copyright / line', 'nydla-biz' ),
			'default' => __( 'NYDLA.biz', 'nydla-biz' ),
			'type'    => 'text',
		)
	);
	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_footer_note',
		'nydla_biz_footer',
		array(
			'label'       => __( 'Footer note (optional)', 'nydla-biz' ),
			'description' => __( 'Usually leave blank — the purchase-path link is enough.', 'nydla-biz' ),
			'default'     => '',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', 'nydla_biz_customize_register' );

/**
 * Add a simple setting + control.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 * @param string               $id          Setting id.
 * @param string               $section     Section id.
 * @param array                $args        Args.
 */
function nydla_biz_add_control( $wp_customize, $id, $section, $args ) {
	$default  = isset( $args['default'] ) ? $args['default'] : '';
	$type     = isset( $args['type'] ) ? $args['type'] : 'text';
	$sanitize = 'sanitize_text_field';
	if ( 'textarea' === $type ) {
		$sanitize = 'sanitize_textarea_field';
	} elseif ( 'url' === $type ) {
		$sanitize = 'esc_url_raw';
	} elseif ( 'checkbox' === $type ) {
		$sanitize = static function ( $v ) {
			return (bool) $v;
		};
	} elseif ( 'number' === $type ) {
		$sanitize = static function ( $v ) use ( $args ) {
			$min = isset( $args['input_attrs']['min'] ) ? (int) $args['input_attrs']['min'] : 0;
			$max = isset( $args['input_attrs']['max'] ) ? (int) $args['input_attrs']['max'] : 9999;
			return nydla_biz_clamp_int( $v, $min, $max, (int) $args['default'] );
		};
	}

	$wp_customize->add_setting(
		$id,
		array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		)
	);

	$control = array(
		'label'   => isset( $args['label'] ) ? $args['label'] : $id,
		'section' => $section,
		'type'    => $type,
	);
	if ( ! empty( $args['description'] ) ) {
		$control['description'] = $args['description'];
	}
	if ( ! empty( $args['input_attrs'] ) ) {
		$control['input_attrs'] = $args['input_attrs'];
	}
	if ( isset( $args['priority'] ) ) {
		$control['priority'] = $args['priority'];
	}
	if ( ! empty( $args['choices'] ) ) {
		$control['choices'] = $args['choices'];
	}

	$wp_customize->add_control( $id, $control );
}

/**
 * Print CSS variables from Customizer.
 */
function nydla_biz_customizer_css() {
	$ink     = nydla_biz_mod( 'nydla_biz_color_ink', '#f3f4f6' );
	$panel   = nydla_biz_mod( 'nydla_biz_color_panel', '#ffffff' );
	$line    = nydla_biz_mod( 'nydla_biz_color_line', '#d8dde5' );
	$fog     = nydla_biz_mod( 'nydla_biz_color_fog', '#5b6575' );
	$paper   = nydla_biz_mod( 'nydla_biz_color_paper', '#16191f' );
	$accent  = nydla_biz_mod( 'nydla_biz_color_accent', '#c9852a' );
	$accent2 = nydla_biz_mod( 'nydla_biz_color_accent2', '#1f4f8a' );
	$logo_h  = (int) nydla_biz_mod( 'nydla_biz_logo_max_h', 48 );

	$css  = ':root{';
	$css .= '--biz-ink:' . $ink . ';';
	$css .= '--biz-panel:' . $panel . ';';
	$css .= '--biz-line:' . $line . ';';
	$css .= '--biz-fog:' . $fog . ';';
	$css .= '--biz-paper:' . $paper . ';';
	$css .= '--biz-accent:' . $accent . ';';
	$css .= '--biz-accent-2:' . $accent2 . ';';
	$css .= '--biz-logo-max-h:' . $logo_h . 'px;';
	$css .= '}';

	echo '<style id="nydla-biz-customizer-css">' . $css . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'nydla_biz_customizer_css', 60 );
