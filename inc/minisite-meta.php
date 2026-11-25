<?php
/**
 * Mini-site page meta (per-sponsor accent + CTA overrides).
 *
 * @package Nydla_Biz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register meta for REST / Customizer-adjacent editors.
 */
function nydla_biz_register_minisite_meta() {
	$keys = array(
		'nydla_biz_accent'        => 'sanitize_hex_color',
		'nydla_biz_cta_label'     => 'sanitize_text_field',
		'nydla_biz_cta_url'       => 'esc_url_raw',
		'nydla_biz_product_line'  => 'sanitize_text_field',
	);

	foreach ( $keys as $key => $sanitize ) {
		register_post_meta(
			'page',
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'auth_callback'     => static function () {
					return current_user_can( 'edit_pages' );
				},
				'sanitize_callback' => $sanitize,
			)
		);
	}
}
add_action( 'init', 'nydla_biz_register_minisite_meta' );

/**
 * Meta box UI.
 */
function nydla_biz_minisite_meta_box() {
	add_meta_box(
		'nydla_biz_minisite',
		__( 'NYDLA.biz mini-site', 'nydla-biz' ),
		'nydla_biz_minisite_meta_box_render',
		'page',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'nydla_biz_minisite_meta_box' );

/**
 * Render meta box.
 *
 * @param WP_Post $post Post.
 */
function nydla_biz_minisite_meta_box_render( $post ) {
	wp_nonce_field( 'nydla_biz_minisite_save', 'nydla_biz_minisite_nonce' );
	$accent = get_post_meta( $post->ID, 'nydla_biz_accent', true );
	$line   = get_post_meta( $post->ID, 'nydla_biz_product_line', true );
	$label  = get_post_meta( $post->ID, 'nydla_biz_cta_label', true );
	$url    = get_post_meta( $post->ID, 'nydla_biz_cta_url', true );
	?>
	<p>
		<label for="nydla_biz_accent"><strong><?php esc_html_e( 'Sponsor accent', 'nydla-biz' ); ?></strong></label><br>
		<input type="text" class="widefat" id="nydla_biz_accent" name="nydla_biz_accent" value="<?php echo esc_attr( $accent ); ?>" placeholder="#e08920">
	</p>
	<p>
		<label for="nydla_biz_product_line"><strong><?php esc_html_e( 'Product line (short)', 'nydla-biz' ); ?></strong></label><br>
		<input type="text" class="widefat" id="nydla_biz_product_line" name="nydla_biz_product_line" value="<?php echo esc_attr( $line ); ?>">
	</p>
	<p>
		<label for="nydla_biz_cta_label"><strong><?php esc_html_e( 'CTA label', 'nydla-biz' ); ?></strong></label><br>
		<input type="text" class="widefat" id="nydla_biz_cta_label" name="nydla_biz_cta_label" value="<?php echo esc_attr( $label ); ?>" placeholder="<?php esc_attr_e( 'Learn more', 'nydla-biz' ); ?>">
	</p>
	<p>
		<label for="nydla_biz_cta_url"><strong><?php esc_html_e( 'CTA URL', 'nydla-biz' ); ?></strong></label><br>
		<input type="url" class="widefat" id="nydla_biz_cta_url" name="nydla_biz_cta_url" value="<?php echo esc_url( $url ); ?>">
	</p>
	<p class="description"><?php esc_html_e( 'Use the Mini-site page template. Empty fields fall back to Customizer defaults.', 'nydla-biz' ); ?></p>
	<?php
}

/**
 * Save meta box.
 *
 * @param int $post_id Post ID.
 */
function nydla_biz_minisite_meta_save( $post_id ) {
	if ( ! isset( $_POST['nydla_biz_minisite_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nydla_biz_minisite_nonce'] ) ), 'nydla_biz_minisite_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$map = array(
		'nydla_biz_accent'       => 'sanitize_hex_color',
		'nydla_biz_product_line' => 'sanitize_text_field',
		'nydla_biz_cta_label'    => 'sanitize_text_field',
		'nydla_biz_cta_url'      => 'esc_url_raw',
	);

	foreach ( $map as $key => $sanitize ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$val = call_user_func( $sanitize, $raw );
		if ( '' === (string) $val ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $val );
		}
	}
}
add_action( 'save_post_page', 'nydla_biz_minisite_meta_save' );

/**
 * Resolved mini-site settings for a page.
 *
 * @param int|null $post_id Page ID.
 * @return array<string, string>
 */
function nydla_biz_minisite_settings( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$accent  = (string) get_post_meta( $post_id, 'nydla_biz_accent', true );
	if ( '' === $accent ) {
		$accent = (string) nydla_biz_mod( 'nydla_biz_minisite_accent', '#e08920' );
	}
	$label = (string) get_post_meta( $post_id, 'nydla_biz_cta_label', true );
	if ( '' === $label ) {
		$label = (string) nydla_biz_mod( 'nydla_biz_minisite_cta_label', __( 'Learn more', 'nydla-biz' ) );
	}
	$url = (string) get_post_meta( $post_id, 'nydla_biz_cta_url', true );
	if ( '' === $url ) {
		$url = (string) nydla_biz_mod( 'nydla_biz_cta_primary_url', '#' );
	}

	return array(
		'accent'       => $accent,
		'product_line' => (string) get_post_meta( $post_id, 'nydla_biz_product_line', true ),
		'cta_label'    => $label,
		'cta_url'      => $url,
	);
}
