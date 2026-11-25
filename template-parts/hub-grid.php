<?php
/**
 * Hub showcase grid.
 *
 * @package Nydla_Biz
 */

$cards   = nydla_biz_get_hub_cards();
$heading = (string) nydla_biz_mod( 'nydla_biz_hub_heading', __( 'Sponsors', 'nydla-biz' ) );
$intro   = (string) nydla_biz_mod( 'nydla_biz_hub_intro', __( 'Choose a sponsor to open their product page.', 'nydla-biz' ) );

if ( empty( $cards ) ) {
	return;
}
?>
<section class="biz-hub" id="showcases">
	<div class="biz-wrap">
		<header class="biz-hub__head">
			<?php if ( $heading ) : ?>
				<h2 class="biz-hub__title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php if ( $intro ) : ?>
				<p class="biz-hub__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</header>

		<ul class="biz-hub__grid">
			<?php foreach ( $cards as $card ) : ?>
				<li class="biz-hub__item" style="--card-accent: <?php echo esc_attr( $card['accent'] ? $card['accent'] : 'var(--biz-accent)' ); ?>">
					<?php $card_url = $card['url'] ? $card['url'] : '#'; ?>
					<a class="biz-hub__card" href="<?php echo esc_url( $card_url ); ?>"<?php echo nydla_biz_link_target_attrs( $card_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php if ( ! empty( $card['logo'] ) ) : ?>
							<span class="biz-hub__logo">
								<img src="<?php echo esc_url( $card['logo'] ); ?>" alt="" loading="lazy" decoding="async">
							</span>
						<?php endif; ?>
						<span class="biz-hub__name"><?php echo esc_html( $card['title'] ); ?></span>
						<?php if ( ! empty( $card['text'] ) ) : ?>
							<span class="biz-hub__line"><?php echo esc_html( $card['text'] ); ?></span>
						<?php endif; ?>
						<span class="biz-hub__go"><?php esc_html_e( 'View', 'nydla-biz' ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
