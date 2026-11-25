<?php
/**
 * Hub showcase grid.
 *
 * @package Nydla_Biz
 */

$cards   = nydla_biz_get_hub_cards();
$heading = (string) nydla_biz_mod( 'nydla_biz_hub_heading', __( 'Live showcases', 'nydla-biz' ) );
$intro   = (string) nydla_biz_mod( 'nydla_biz_hub_intro', __( 'Open a mini-site for product detail. Purchases path through TAC-USA.', 'nydla-biz' ) );
$tac_url = (string) nydla_biz_mod( 'nydla_biz_tac_url', 'https://tac-usa.com/' );
$tac_lab = (string) nydla_biz_mod( 'nydla_biz_tac_label', __( 'Shop via TAC-USA', 'nydla-biz' ) );

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
					<a class="biz-hub__card" href="<?php echo esc_url( $card['url'] ? $card['url'] : '#' ); ?>">
						<span class="biz-hub__mark" aria-hidden="true"></span>
						<?php if ( ! empty( $card['logo'] ) ) : ?>
							<span class="biz-hub__logo">
								<img src="<?php echo esc_url( $card['logo'] ); ?>" alt="" loading="lazy" decoding="async">
							</span>
						<?php endif; ?>
						<span class="biz-hub__name"><?php echo esc_html( $card['title'] ); ?></span>
						<?php if ( ! empty( $card['text'] ) ) : ?>
							<span class="biz-hub__line"><?php echo esc_html( $card['text'] ); ?></span>
						<?php endif; ?>
						<span class="biz-hub__go"><?php esc_html_e( 'Open showcase', 'nydla-biz' ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php if ( $tac_url && $tac_lab ) : ?>
			<p class="biz-hub__tac">
				<a class="biz-btn biz-btn--ghost" href="<?php echo esc_url( $tac_url ); ?>"><?php echo esc_html( $tac_lab ); ?></a>
			</p>
		<?php endif; ?>
	</div>
</section>
