<?php
/**
 * Default page template.
 *
 * @package Nydla_Biz
 */

get_header();
?>

<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<article <?php post_class( 'biz-page' ); ?>>
		<header class="biz-page__hero">
			<div class="biz-wrap">
				<h1 class="biz-page__title"><?php the_title(); ?></h1>
			</div>
		</header>
		<div class="biz-band">
			<div class="biz-wrap entry-content">
				<?php the_content(); ?>
			</div>
		</div>
	</article>
<?php endwhile; ?>

<?php
get_footer();
