<?php
// single.php — Single blog post
get_header();
?>
<main id="main" class="site-main" tabindex="-1">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content/content', 'post' ); ?>
			<?php
			the_post_navigation( [
				'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'appstorepro' ) . '</span> <span class="nav-title">%title</span>',
				'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'appstorepro' ) . '</span> <span class="nav-title">%title</span>',
			] );
			?>
			<?php if ( comments_open() || get_comments_number() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>
