<?php
/**
 * Sponsor hub — front page.
 *
 * @package Nydla_Biz
 */

get_header();

get_template_part( 'template-parts/hub', 'hero' );
get_template_part( 'template-parts/hub', 'grid' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$content = trim( (string) get_the_content() );
		if ( $content ) :
			?>
			<section class="biz-band">
				<div class="biz-wrap entry-content">
					<?php the_content(); ?>
				</div>
			</section>
			<?php
		endif;
	endwhile;
endif;

get_footer();
