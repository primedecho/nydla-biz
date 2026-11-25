<?php
/**
 * 404.
 *
 * @package Nydla_Biz
 */

get_header();
?>

<section class="biz-band">
	<div class="biz-wrap">
		<p class="biz-eyebrow"><?php esc_html_e( '404', 'nydla-biz' ); ?></p>
		<h1><?php esc_html_e( 'Page not found', 'nydla-biz' ); ?></h1>
		<p><a class="biz-btn biz-btn--accent" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to hub', 'nydla-biz' ); ?></a></p>
	</div>
</section>

<?php
get_footer();
