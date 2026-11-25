<?php
/**
 * Footer — lean utility strip (purchase path once).
 *
 * @package Nydla_Biz
 */

$copy = (string) nydla_biz_mod( 'nydla_biz_footer_copy', __( 'NYDLA.biz', 'nydla-biz' ) );
$note = trim( (string) nydla_biz_mod( 'nydla_biz_footer_note', '' ) );
$tac  = (string) nydla_biz_mod( 'nydla_biz_tac_url', 'https://tac-usa.com/' );
$tlab = trim( (string) nydla_biz_mod( 'nydla_biz_tac_label', __( 'Purchase path', 'nydla-biz' ) ) );
$sec  = (string) nydla_biz_mod( 'nydla_biz_cta_secondary_url', 'mailto:info@nydla.org' );
$slab = (string) nydla_biz_mod( 'nydla_biz_cta_secondary_label', __( 'Contact', 'nydla-biz' ) );
?>
</main>

<footer class="site-footer" role="contentinfo">
	<div class="site-footer__inner">
		<p class="site-footer__copy"><?php echo esc_html( $copy ); ?></p>
		<p class="site-footer__links">
			<?php if ( $sec && $slab ) : ?>
				<a href="<?php echo esc_url( $sec ); ?>"<?php echo nydla_biz_link_target_attrs( $sec ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $slab ); ?></a>
			<?php endif; ?>
			<?php if ( $sec && $slab && $tac && $tlab ) : ?>
				<span class="site-footer__sep" aria-hidden="true">|</span>
			<?php endif; ?>
			<?php if ( $tac && $tlab ) : ?>
				<a href="<?php echo esc_url( $tac ); ?>"<?php echo nydla_biz_link_target_attrs( $tac ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $tlab ); ?></a>
			<?php endif; ?>
		</p>
		<?php if ( $note ) : ?>
			<p class="site-footer__note"><?php echo esc_html( $note ); ?></p>
		<?php endif; ?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
