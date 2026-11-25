<?php
/**
 * Fallback index.
 *
 * @package Nydla_Biz
 */

get_header();
?>

<section class="biz-band">
	<div class="biz-wrap">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article <?php post_class( 'biz-post' ); ?>>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found.', 'nydla-biz' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
