<?php
/**
 * Template Name: Mini-site
 * Template Post Type: page
 * Description: Sponsor product page — big visual, short copy, CTAs.
 *
 * @package Nydla_Biz
 */

get_header();

while ( have_posts() ) :
	the_post();
	$settings = nydla_biz_minisite_settings( get_the_ID() );
	$contact  = (string) nydla_biz_mod( 'nydla_biz_cta_secondary_url', 'mailto:info@nydla.org' );
	$c_lab    = (string) nydla_biz_mod( 'nydla_biz_cta_secondary_label', __( 'Contact', 'nydla-biz' ) );
	?>
	<article <?php post_class( 'biz-minisite' ); ?> style="--mini-accent: <?php echo esc_attr( $settings['accent'] ); ?>">
		<section class="biz-minisite__hero">
			<div class="biz-wrap biz-minisite__hero-grid">
				<div class="biz-minisite__copy">
					<p class="biz-eyebrow"><?php esc_html_e( 'Sponsor', 'nydla-biz' ); ?></p>
					<h1 class="biz-minisite__title"><?php the_title(); ?></h1>
					<?php if ( $settings['product_line'] ) : ?>
						<p class="biz-minisite__line"><?php echo esc_html( $settings['product_line'] ); ?></p>
					<?php endif; ?>
					<p class="biz-minisite__actions">
						<?php if ( $settings['cta_label'] && $settings['cta_url'] ) : ?>
							<a class="biz-btn biz-btn--accent" href="<?php echo esc_url( $settings['cta_url'] ); ?>"<?php echo nydla_biz_link_target_attrs( $settings['cta_url'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['cta_label'] ); ?></a>
						<?php endif; ?>
						<?php if ( $contact && $c_lab ) : ?>
							<a class="biz-btn biz-btn--ghost" href="<?php echo esc_url( $contact ); ?>"<?php echo nydla_biz_link_target_attrs( $contact ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $c_lab ); ?></a>
						<?php endif; ?>
					</p>
				</div>
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="biz-minisite__visual">
						<?php the_post_thumbnail( 'nydla-biz-hero' ); ?>
					</figure>
				<?php endif; ?>
			</div>
		</section>

		<section class="biz-band">
			<div class="biz-wrap entry-content">
				<?php the_content(); ?>
			</div>
		</section>
	</article>
	<?php
endwhile;

get_footer();
