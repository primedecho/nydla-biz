<?php
/**
 * Customizer — sponsor hub showcase slots (1–12).
 *
 * @package Nydla_Biz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Max hub cards.
 *
 * @return int
 */
function nydla_biz_hub_max() {
	return 12;
}

/**
 * Active hub card count.
 *
 * @return int
 */
function nydla_biz_hub_count() {
	return nydla_biz_clamp_int( nydla_biz_mod( 'nydla_biz_hub_count', 6 ), 1, nydla_biz_hub_max(), 6 );
}

/**
 * Default hub card seeds.
 *
 * @return array<int, array<string, string>>
 */
function nydla_biz_hub_defaults() {
	$seeds = array(
		1 => array(
			'title'  => 'GoTo',
			'text'   => 'Modern meetings for teams that teach and train.',
			'url'    => '#',
			'accent' => '#f45d48',
		),
		2 => array(
			'title'  => 'AireSpring',
			'text'   => 'Cloud communications and managed connectivity.',
			'url'    => '#',
			'accent' => '#3d9cf0',
		),
		3 => array(
			'title'  => 'Zoom',
			'text'   => 'Bring teams together on the platform you know.',
			'url'    => '#',
			'accent' => '#2d8cff',
		),
		4 => array(
			'title'  => 'HubSpot',
			'text'   => 'Marketing, sales, and service on one platform.',
			'url'    => '#',
			'accent' => '#ff7a59',
		),
		5 => array(
			'title'  => 'Meeting Owl',
			'text'   => '360° hybrid meetings that feel face-to-face.',
			'url'    => '#',
			'accent' => '#6c5ce7',
		),
		6 => array(
			'title'  => 'Clover',
			'text'   => 'Run the business smarter — payments to people.',
			'url'    => '#',
			'accent' => '#228822',
		),
	);

	for ( $i = 7; $i <= nydla_biz_hub_max(); $i++ ) {
		$seeds[ $i ] = array(
			'title'  => sprintf(
				/* translators: %d: showcase number */
				__( 'Showcase %d', 'nydla-biz' ),
				$i
			),
			'text'   => __( 'Add this sponsor mini-site in Appearance → Customize → Hub showcases.', 'nydla-biz' ),
			'url'    => '#',
			'accent' => '#e08920',
		);
	}

	return $seeds;
}

/**
 * Active callback for hub slot N.
 *
 * @param WP_Customize_Control $control Control.
 * @return bool
 */
function nydla_biz_hub_slot_active( $control ) {
	if ( ! preg_match( '/nydla_biz_hub_(\d+)_/', $control->id, $m ) ) {
		return true;
	}
	return (int) $m[1] <= nydla_biz_hub_count();
}

/**
 * Register hub Customizer controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function nydla_biz_customize_hub( $wp_customize ) {
	$wp_customize->add_section(
		'nydla_biz_hub',
		array(
			'title'       => __( 'Hub showcases', 'nydla-biz' ),
			'description' => __( 'Directory of live sponsor mini-sites on the .biz home. Raise the count to add a card; lower to hide (content is kept).', 'nydla-biz' ),
			'panel'       => 'nydla_biz_theme',
			'priority'    => 45,
		)
	);

	$wp_customize->add_setting(
		'nydla_biz_hub_count',
		array(
			'default'           => 6,
			'sanitize_callback' => static function ( $v ) {
				return nydla_biz_clamp_int( $v, 1, nydla_biz_hub_max(), 6 );
			},
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'nydla_biz_hub_count',
		array(
			'label'       => __( 'Number of showcases', 'nydla-biz' ),
			'section'     => 'nydla_biz_hub',
			'type'        => 'number',
			'priority'    => 1,
			'input_attrs' => array(
				'min'  => 1,
				'max'  => nydla_biz_hub_max(),
				'step' => 1,
			),
		)
	);

	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_hub_heading',
		'nydla_biz_hub',
		array(
			'label'    => __( 'Section heading', 'nydla-biz' ),
			'default'  => __( 'Live showcases', 'nydla-biz' ),
			'type'     => 'text',
			'priority' => 2,
		)
	);
	nydla_biz_add_control(
		$wp_customize,
		'nydla_biz_hub_intro',
		'nydla_biz_hub',
		array(
			'label'    => __( 'Section intro', 'nydla-biz' ),
			'default'  => __( 'Open a mini-site for product detail. Purchases path through TAC-USA.', 'nydla-biz' ),
			'type'     => 'textarea',
			'priority' => 3,
		)
	);

	$defaults = nydla_biz_hub_defaults();

	for ( $i = 1; $i <= nydla_biz_hub_max(); $i++ ) {
		$active = array( 'active_callback' => 'nydla_biz_hub_slot_active' );
		$def    = $defaults[ $i ];

		$wp_customize->add_setting(
			"nydla_biz_hub_{$i}_title",
			array(
				'default'           => $def['title'],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"nydla_biz_hub_{$i}_title",
			array_merge(
				array(
					/* translators: %d: showcase number */
					'label'    => sprintf( __( 'Showcase %d — name', 'nydla-biz' ), $i ),
					'section'  => 'nydla_biz_hub',
					'type'     => 'text',
					'priority' => 10 + ( $i * 10 ),
				),
				$active
			)
		);

		$wp_customize->add_setting(
			"nydla_biz_hub_{$i}_text",
			array(
				'default'           => $def['text'],
				'sanitize_callback' => 'sanitize_textarea_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"nydla_biz_hub_{$i}_text",
			array_merge(
				array(
					/* translators: %d: showcase number */
					'label'    => sprintf( __( 'Showcase %d — line', 'nydla-biz' ), $i ),
					'section'  => 'nydla_biz_hub',
					'type'     => 'textarea',
					'priority' => 11 + ( $i * 10 ),
				),
				$active
			)
		);

		$wp_customize->add_setting(
			"nydla_biz_hub_{$i}_url",
			array(
				'default'           => $def['url'],
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"nydla_biz_hub_{$i}_url",
			array_merge(
				array(
					/* translators: %d: showcase number */
					'label'    => sprintf( __( 'Showcase %d — URL', 'nydla-biz' ), $i ),
					'section'  => 'nydla_biz_hub',
					'type'     => 'url',
					'priority' => 12 + ( $i * 10 ),
				),
				$active
			)
		);

		$wp_customize->add_setting(
			"nydla_biz_hub_{$i}_accent",
			array(
				'default'           => $def['accent'],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				"nydla_biz_hub_{$i}_accent",
				array_merge(
					array(
						/* translators: %d: showcase number */
						'label'    => sprintf( __( 'Showcase %d — accent', 'nydla-biz' ), $i ),
						'section'  => 'nydla_biz_hub',
						'priority' => 13 + ( $i * 10 ),
					),
					$active
				)
			)
		);

		$wp_customize->add_setting(
			"nydla_biz_hub_{$i}_logo",
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"nydla_biz_hub_{$i}_logo",
				array_merge(
					array(
						/* translators: %d: showcase number */
						'label'    => sprintf( __( 'Showcase %d — logo', 'nydla-biz' ), $i ),
						'section'  => 'nydla_biz_hub',
						'priority' => 14 + ( $i * 10 ),
					),
					$active
				)
			)
		);
	}
}
add_action( 'customize_register', 'nydla_biz_customize_hub', 12 );

/**
 * Collected hub cards for the front.
 *
 * @return array<int, array<string, string>>
 */
function nydla_biz_get_hub_cards() {
	$defaults = nydla_biz_hub_defaults();
	$cards    = array();
	$count    = nydla_biz_hub_count();

	for ( $i = 1; $i <= $count; $i++ ) {
		$def   = isset( $defaults[ $i ] ) ? $defaults[ $i ] : $defaults[1];
		$title = trim( (string) get_theme_mod( "nydla_biz_hub_{$i}_title", $def['title'] ) );
		if ( '' === $title ) {
			continue;
		}
		$cards[] = array(
			'title'  => $title,
			'text'   => (string) get_theme_mod( "nydla_biz_hub_{$i}_text", $def['text'] ),
			'url'    => (string) get_theme_mod( "nydla_biz_hub_{$i}_url", $def['url'] ),
			'accent' => (string) get_theme_mod( "nydla_biz_hub_{$i}_accent", $def['accent'] ),
			'logo'   => (string) get_theme_mod( "nydla_biz_hub_{$i}_logo", '' ),
		);
	}

	return $cards;
}
