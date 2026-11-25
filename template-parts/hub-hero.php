<?php
/**
 * Hub hero.
 *
 * @package Nydla_Biz
 */

$eyebrow = (string) nydla_biz_mod( 'nydla_biz_hero_eyebrow', __( 'NYDLA.biz', 'nydla-biz' ) );
$title   = (string) nydla_biz_mod( 'nydla_biz_hero_title', __( 'Sponsor showcases', 'nydla-biz' ) );
$text    = (string) nydla_biz_mod( 'nydla_biz_hero_text', __( 'Product pages from NYDLA sponsors — clear, short, and ready to share.', 'nydla-biz' ) );
$image   = (string) nydla_biz_mod( 'nydla_biz_hero_image', '' );
$p_lab   = (string) nydla_biz_mod( 'nydla_biz_cta_primary_label', __( 'Learn more', 'nydla-biz' ) );
$p_url   = (string) nydla_biz_mod( 'nydla_biz_cta_primary_url', '#showcases' );
$s_lab   = (string) nydla_biz_mod( 'nydla_biz_cta_secondary_label', __( 'Contact', 'nydla-biz' ) );
$s_url   = (string) nydla_biz_mod( 'nydla_biz_cta_secondary_url', 'mailto:info@nydla.org' );
?>
<section class="biz-hero">
	<div class="biz-wrap biz-hero__grid<?php echo $image ? ' biz-hero__grid--split' : ''; ?>">
		<div class="biz-hero__copy">
			<?php if ( $eyebrow ) : ?>
				<p class="biz-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<h1 class="biz-hero__title"><?php echo esc_html( $title ); ?></h1>
			<?php if ( $text ) : ?>
				<p class="biz-hero__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
			<p class="biz-hero__actions">
				<?php if ( $p_lab && $p_url ) : ?>
					<a class="biz-btn biz-btn--accent" href="<?php echo esc_url( $p_url ); ?>"><?php echo esc_html( $p_lab ); ?></a>
				<?php endif; ?>
				<?php if ( $s_lab && $s_url ) : ?>
					<a class="biz-btn biz-btn--ghost" href="<?php echo esc_url( $s_url ); ?>"><?php echo esc_html( $s_lab ); ?></a>
				<?php endif; ?>
			</p>
		</div>
		<?php if ( $image ) : ?>
			<figure class="biz-hero__visual">
				<img src="<?php echo esc_url( $image ); ?>" alt="" width="960" height="640" decoding="async" fetchpriority="high">
			</figure>
		<?php endif; ?>
	</div>
</section>
