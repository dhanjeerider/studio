<?php
// index.php
get_header();

if ( is_home() && ! is_front_page() ) :
	get_template_part( 'template-parts/content/content', 'none' );
else :
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content/content', get_post_type() );
		endwhile;

		the_posts_pagination( [
			'class'     => 'pas-pagination',
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
		] );
	else :
		get_template_part( 'template-parts/content/content', 'none' );
	endif;
endif;

get_footer();
