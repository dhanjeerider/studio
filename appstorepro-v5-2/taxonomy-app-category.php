<?php
/**
 * taxonomy-app-category.php — AppStore Pro V5
 * App/Game category taxonomy archive with 4-layout switcher
 */
get_header();

$term           = get_queried_object();
$show_switcher  = get_theme_mod( 'aspv5_show_layout_switcher', '1' );
$default_layout = get_theme_mod( 'aspv5_default_layout', 'grid' );
$valid_layouts  = [ 'grid', 'list', 'banner', 'compact' ];
$current_layout = isset( $_GET['layout'] ) ? sanitize_key( wp_unslash( $_GET['layout'] ) ) : $default_layout;
$current_layout = in_array( $current_layout, $valid_layouts, true ) ? $current_layout : $default_layout;
$GLOBALS['aspv5_current_layout'] = $current_layout;
$cat_image_id   = $term ? get_term_meta( $term->term_id, '_aspv5_category_image', true ) : '';
$cat_image_url  = $cat_image_id ? wp_get_attachment_image_url( $cat_image_id, 'app-hero' ) : '';
$is_term_page   = ( $term instanceof WP_Term ) && ! empty( $term->term_id );

$grid_classes = [
	'grid'    => 'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4',
	'list'    => 'flex flex-col gap-3',
	'banner'  => 'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4',
	'compact' => 'grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3',
];
?>
<main id="main" class="pb-8 pt-4 min-h-screen" tabindex="-1">
	<div class="max-w-6xl mx-auto px-4">

		<?php if ( ! $is_term_page ) : ?>
			<?php
			$all_categories = get_terms( [
				'taxonomy'   => 'app-category',
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
			] );
			?>
			<header class="aspv5-reveal mb-6">
				<h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2"><?php esc_html_e( 'All Categories', 'aspv5' ); ?></h1>
				<p class="text-sm text-gray-500 dark:text-gray-400"><?php esc_html_e( 'Browse all app and game categories.', 'aspv5' ); ?></p>
			</header>

			<?php if ( ! is_wp_error( $all_categories ) && $all_categories ) : ?>
				<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
					<?php foreach ( $all_categories as $cat_item ) : ?>
						<?php
						$cat_img = aspv5_get_category_image( $cat_item->term_id, 'thumbnail' );
						$cat_url = get_term_link( $cat_item );
						?>
						<a href="<?php echo esc_url( $cat_url ); ?>" class="aspv5-reveal flex flex-col items-center gap-2 p-3 rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 hover:border-primary/30 transition-colors text-center">
							<div class="w-16 h-16 rounded-2xl overflow-hidden bg-[color:var(--asp-primary)]/10 dark:bg-gray-800 flex items-center justify-center">
								<?php if ( $cat_img ) : ?>
									<img src="<?php echo esc_url( $cat_img ); ?>" alt="<?php echo esc_attr( $cat_item->name ); ?>" class="w-full h-full object-cover" loading="lazy">
								<?php else : ?>
									<span class="text-[color:var(--asp-primary)] text-2xl"><?php echo wp_kses( aspv5_get_category_icon_svg( $cat_item->slug ), aspv5_allowed_svg_kses() ); ?></span>
								<?php endif; ?>
							</div>
							<span class="text-xs font-semibold text-gray-800 dark:text-gray-200 line-clamp-2"><?php echo esc_html( $cat_item->name ); ?></span>
							<span class="text-[10px] text-gray-500 dark:text-gray-400"><?php echo esc_html( number_format_i18n( (int) $cat_item->count ) ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
			<?php endif; ?>
		<?php else : ?>

		<!-- Category Header -->
		<header class="aspv5-reveal mb-6">
			<?php if ( $cat_image_url ) : ?>
				<div class="relative rounded-2xl overflow-hidden h-32 sm:h-44">
					<img src="<?php echo esc_url( $cat_image_url ); ?>" alt="<?php echo esc_attr( $term->name ); ?>" class="absolute inset-0 w-full h-full object-cover" loading="eager">
					<div class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/10 to-transparent"></div>
				</div>
				<div class="mt-4 px-1">
					<h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white"><?php echo esc_html( $term->name ); ?></h1>
					<?php if ( $term && $term->description ) : ?>
						<p class="text-sm text-gray-500 dark:text-gray-400 mt-2"><?php echo esc_html( $term->description ); ?></p>
					<?php endif; ?>
				</div>
			<?php else : ?>
				<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
					<div>
						<p class="text-xs font-bold uppercase tracking-widest text-primary mb-1"><?php esc_html_e( 'Category', 'aspv5' ); ?></p>
						<h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
							<?php echo esc_html( $term ? $term->name : '' ); ?>
						</h1>
						<?php if ( $term && $term->description ) : ?>
							<p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><?php echo esc_html( $term->description ); ?></p>
						<?php endif; ?>
						<p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
							<?php
							$total = $wp_query->found_posts;
							printf(
								/* translators: %d: number of items */
								esc_html( _n( '%d item', '%d items', $total, 'aspv5' ) ),
								esc_html( number_format_i18n( $total ) )
							);
							?>
						</p>
					</div>
					<?php if ( $show_switcher ) : ?>
					<?php get_template_part( 'template-parts/global/layout-switcher' ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $cat_image_url && $show_switcher ) : ?>
				<div class="flex justify-end mt-3">
					<?php get_template_part( 'template-parts/global/layout-switcher' ); ?>
				</div>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>

			<div class="<?php echo esc_attr( $grid_classes[ $current_layout ] ); ?>"
			     data-layout-container
			     data-layout-server="1"
			     id="aspv5-posts-container"
			     data-grid-classes="<?php echo esc_attr( wp_json_encode( $grid_classes ) ); ?>">

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content/content', 'app', [ 'layout' => $current_layout ] ); ?>
				<?php endwhile; ?>

			</div>

			<?php the_posts_pagination( [
				'class'     => 'aspv5-pagination flex flex-wrap justify-center gap-1.5 mt-10',
				'prev_text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="w-4 h-4"><polyline points="15 18 9 12 15 6"/></svg>',
				'next_text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="w-4 h-4"><polyline points="9 18 15 12 9 6"/></svg>',
			] ); ?>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
		<?php endif; ?>

		<?php endif; ?>

	</div>
</main>

<?php
// Layout switcher inline script — same as archive pages
?>
<script>
(function() {
	var layoutBtns = document.querySelectorAll('.aspv5-layout-btn');
	layoutBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			var url = new URL(window.location.href);
			url.searchParams.set('layout', btn.dataset.layout);
			url.searchParams.delete('paged');
			window.location.href = url.toString();
		});
	});
})();
</script>

<?php get_footer(); ?>
