<?php
// inc/shortcodes.php — Browse, Category List, and Home Page Shortcodes

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Prefer the new category image meta key and fallback gracefully.
function aspv5_shortcode_category_image_url( $term_id, $size = 'medium' ) {
	$image_id = absint( get_term_meta( $term_id, '_aspv5_category_image', true ) );
	if ( $image_id ) {
		$url = wp_get_attachment_image_url( $image_id, $size );
		if ( $url ) {
			return $url;
		}
	}

	if ( function_exists( 'aspv5_get_category_image' ) ) {
		return aspv5_get_category_image( $term_id, $size );
	}

	return '';
}

// ═══════════════════════════════════════════════════════════════════════════════
// BROWSE PAGE SHORTCODE
// ═══════════════════════════════════════════════════════════════════════════════

/**
 * Browse Apps & Games Shortcode
 * 
 * Displays a filterable grid of apps and games with advanced search.
 * 
 * Usage: [aspv5_browse type="both" per_page="12"]
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML
 */
function aspv5_shortcode_browse( $atts ) {
	$atts = shortcode_atts( [
		'type'     => 'both', // 'both', 'app', 'game'
		'per_page' => 12,
		'orderby'  => 'date',
		'order'    => 'DESC',
	], $atts, 'aspv5_browse' );

	ob_start();
	?>
	<div class="aspv5-browse-wrapper">
		<!-- Hero Section -->
		<section class="py-12 bg-gradient-to-b from-slate-50 to-white mb-10">
			<div class="max-w-6xl mx-auto px-4">
				<div class="text-center mb-8">
					<p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-orange mb-4">
						<span class="w-2 h-2 rounded-full bg-orange"></span>
						Download Free Apps & Games
					</p>
					<h1 class="text-4xl font-bold text-gray-900 mb-4">
						Explore Your Favorite <span class="text-orange">MOD APK</span> Games & Apps
					</h1>
					<p class="text-gray-600 max-w-2xl mx-auto">
						Search, filter, and download thousands of applications and games for Android.
					</p>
				</div>

				<!-- Search Form -->
				<form id="aspv5-browse-form" class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100">
					<!-- Search Bar -->
					<div class="mb-6">
						<div class="relative">
							<input 
								type="text" 
								id="browse-search" 
								placeholder="Search for apps, games..." 
								class="w-full rounded-full border border-gray-200 px-6 py-4 text-gray-900 outline-none focus:ring-2 focus:ring-orange focus:border-transparent"
							>
							<button type="submit" class="absolute inset-y-0 right-2 flex items-center pr-4 text-orange hover:text-orange-hover" aria-label="Search">
								<i class="bx bx-search text-xl"></i>
							</button>
						</div>
					</div>

					<!-- Filters Grid -->
					<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
						<!-- Category Filter -->
						<div>
							<label class="block text-sm font-semibold text-gray-900 mb-2">Category</label>
							<select id="browse-category" class="w-full rounded-lg border border-gray-200 px-4 py-2">
								<option value="">All Categories</option>
								<?php
								$categories = get_terms( [
									'taxonomy'   => 'app-category',
									'hide_empty' => false,
									'number'     => 100,
								] );
								foreach ( $categories as $cat ) {
									echo '<option value="' . esc_attr( $cat->term_id ) . '">' . esc_html( $cat->name ) . '</option>';
								}
								?>
							</select>
						</div>

						<!-- App Type Filter -->
						<div>
							<label class="block text-sm font-semibold text-gray-900 mb-2">App Type</label>
							<select id="browse-type" class="w-full rounded-lg border border-gray-200 px-4 py-2">
								<option value="">All Types</option>
								<option value="mod">MOD APK</option>
								<option value="premium">Premium</option>
								<option value="free">Free</option>
								<option value="paid">Paid</option>
								<option value="original">Original</option>
							</select>
						</div>

						<!-- Sort Filter -->
						<div>
							<label class="block text-sm font-semibold text-gray-900 mb-2">Sort By</label>
							<select id="browse-sort" class="w-full rounded-lg border border-gray-200 px-4 py-2">
								<option value="date-desc">Newest First</option>
								<option value="date-asc">Oldest First</option>
								<option value="title-asc">A to Z</option>
								<option value="rating-desc">Highest Rated</option>
							</select>
						</div>
					</div>
				</form>
			</div>
		</section>

		<!-- Results Grid -->
		<section class="max-w-6xl mx-auto px-4 pb-12">
			<div id="browse-results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php echo aspv5_render_browse_results( $atts ); ?>
			</div>

			<!-- Pagination -->
			<div id="browse-pagination" class="mt-8 text-center"></div>
		</section>
	</div>

	<script>
		(function ($) {
			'use strict';

			$('#aspv5-browse-form').on('submit', function (e) {
				e.preventDefault();
				aspv5_load_browse_results();
			});

			$('#browse-category, #browse-type, #browse-sort').on('change', function () {
				aspv5_load_browse_results();
			});

			$('#browse-search').on('keyup', function () {
				clearTimeout(this.searchTimeout);
				this.searchTimeout = setTimeout(function () {
					aspv5_load_browse_results();
				}, 500);
			});

			function aspv5_load_browse_results() {
				var data = {
					action: 'aspv5_browse_results',
					security: aspv5.nonce,
					search: $('#browse-search').val(),
					category: $('#browse-category').val(),
					type: $('#browse-type').val(),
					sort: $('#browse-sort').val(),
					paged: 1
				};

				$.post(aspv5.ajaxUrl, data, function (response) {
					$('#browse-results').html(response);
				});
			}

			// Load initial results
			aspv5_load_browse_results();
		})(jQuery);
	</script>

	<?php
	return ob_get_clean();
}
add_shortcode( 'aspv5_browse', 'aspv5_shortcode_browse' );

// ── Render browse results via AJAX ────────────────────────────────────────────
function aspv5_render_browse_results( $args = [] ) {
	$defaults = [
		'search'   => isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '',
		'category' => isset( $_POST['category'] ) ? absint( wp_unslash( $_POST['category'] ) ) : 0,
		'type'     => isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '',
		'sort'     => isset( $_POST['sort'] ) ? sanitize_text_field( wp_unslash( $_POST['sort'] ) ) : 'date-desc',
		'per_page' => 12,
		'paged'    => max( 1, isset( $_POST['paged'] ) ? absint( wp_unslash( $_POST['paged'] ) ) : 1 ),
	];
	$args = wp_parse_args( $args, $defaults );

	// Build query args
	$query_args = [
		'post_type'      => [ 'app', 'game' ],
		'posts_per_page' => $args['per_page'],
		'paged'          => $args['paged'],
		'orderby'        => 'date',
		'order'          => 'DESC',
	];

	// Search
	if ( $args['search'] ) {
		$query_args['s'] = $args['search'];
	}

	// Category filter
	if ( $args['category'] ) {
		$query_args['tax_query'] = [
			[
				'taxonomy' => 'app-category',
				'field'    => 'term_id',
				'terms'    => $args['category'],
			],
		];
	}

	// Type filter (MOD info meta)
	if ( $args['type'] ) {
		$query_args['meta_query'] = [
			[
				'key'   => '_app_mod_info',
				'value' => '',
				'compare' => $args['type'] === 'mod' ? '!=' : '=',
			],
		];
	}

	// Sorting
	if ( 'title-asc' === $args['sort'] ) {
		$query_args['orderby'] = 'title';
		$query_args['order']   = 'ASC';
	} elseif ( 'rating-desc' === $args['sort'] ) {
		$query_args['orderby'] = 'meta_value_num';
		$query_args['meta_key'] = '_app_rating';
		$query_args['order']   = 'DESC';
	}

	$query = new WP_Query( $query_args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			aspv5_render_app_card();
		}
		wp_reset_postdata();
	} else {
		echo '<div class="col-span-full text-center py-12"><p class="text-gray-500">No apps found. Try different filters.</p></div>';
	}
}

// ── Render single app card ────────────────────────────────────────────────────
function aspv5_render_app_card() {
	$icon     = get_post_meta( get_the_ID(), '_app_icon_url', true );
	$rating   = get_post_meta( get_the_ID(), '_app_rating', true );
	$mod_info = get_post_meta( get_the_ID(), '_app_mod_info', true );
	$version  = get_post_meta( get_the_ID(), '_app_version', true );
	$size     = get_post_meta( get_the_ID(), '_app_size', true );
	$categories = wp_get_post_terms( get_the_ID(), 'app-category' );

	// Get featured image fallback
	if ( ! $icon && has_post_thumbnail() ) {
		$icon = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
	}

	?>
	<article class="group relative bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
		<?php if ( $mod_info ) : ?>
			<div class="absolute top-3 left-3 z-10">
				<span class="inline-flex items-center gap-1 bg-orange text-white px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">
					<i class="bx bxs-bolt text-xs"></i>MOD
				</span>
			</div>
		<?php endif; ?>

		<a href="<?php the_permalink(); ?>" class="block aspect-square overflow-hidden bg-gray-100">
			<?php if ( $icon ) : ?>
				<img src="<?php echo esc_url( $icon ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
			<?php else : ?>
				<div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500 text-4xl font-bold">
					<?php echo strtoupper( substr( get_the_title(), 0, 1 ) ); ?>
				</div>
			<?php endif; ?>
		</a>

		<div class="p-4">
			<a href="<?php the_permalink(); ?>" class="block text-sm font-semibold text-gray-900 truncate hover:text-orange transition-colors"><?php the_title(); ?></a>

			<div class="text-xs text-gray-500 mt-2">
				<?php if ( $version || $size ) : ?>
					<div class="inline-flex items-center gap-1.5">
						<i class="bx bx-package text-sm"></i>
						<?php if ( $version ) echo esc_html( $version ); ?>
						<?php if ( $version && $size ) echo ' • '; ?>
						<?php if ( $size ) echo esc_html( $size ); ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="flex items-center gap-2 mt-3 text-xs">
				<?php if ( $rating ) : ?>
					<span class="inline-flex items-center gap-1 text-amber-600 font-semibold"><i class="bx bxs-star"></i><?php echo esc_html( $rating ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $categories ) ) : ?>
					<span class="inline-flex items-center gap-1 text-gray-500">
						<i class="bx bx-category-alt"></i>
						<?php echo esc_html( $categories[0]->name ); ?>
					</span>
				<?php endif; ?>
			</div>

			<a href="<?php the_permalink(); ?>" class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-orange text-white text-sm font-semibold py-2.5 hover:opacity-90 transition-opacity">
				<i class="bx bx-download text-base"></i>
				<span><?php esc_html_e( 'Open', 'aspv5' ); ?></span>
			</a>
		</div>
	</article>
	<?php
}

// ── AJAX handler for browse results ───────────────────────────────────────────
function aspv5_ajax_browse_results() {
	check_ajax_referer( 'aspv5_nonce', 'security' );
	aspv5_render_browse_results();
	wp_die();
}
add_action( 'wp_ajax_aspv5_browse_results', 'aspv5_ajax_browse_results' );
add_action( 'wp_ajax_nopriv_aspv5_browse_results', 'aspv5_ajax_browse_results' );

// ═══════════════════════════════════════════════════════════════════════════════
// CATEGORIES LIST SHORTCODE
// ═══════════════════════════════════════════════════════════════════════════════

/**
 * Categories List Shortcode
 * 
 * Displays all app/game categories in a grid with images.
 * 
 * Usage: [aspv5_categories columns="3" show_count="yes"]
 */
function aspv5_shortcode_categories( $atts ) {
	$atts = shortcode_atts( [
		'columns'   => 3,
		'show_count' => 'yes',
	], $atts, 'aspv5_categories' );

	$columns = max( 1, min( 4, absint( $atts['columns'] ) ) );
	$grid_map = [
		1 => 'grid-cols-1',
		2 => 'grid-cols-1 sm:grid-cols-2',
		3 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
		4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
	];
	$grid_class = isset( $grid_map[ $columns ] ) ? $grid_map[ $columns ] : $grid_map[3];

	ob_start();

	$categories = get_terms( [
		'taxonomy'   => 'app-category',
		'hide_empty' => false,
		'number'     => 100,
	] );

	if ( empty( $categories ) || is_wp_error( $categories ) ) {
		return '<p>No categories found.</p>';
	}

	?>
	<div class="aspv5-categories-wrapper my-10">
		<div class="grid <?php echo esc_attr( $grid_class ); ?> gap-5">
			<?php foreach ( $categories as $category ) : ?>
				<?php
				$image_url = aspv5_shortcode_category_image_url( $category->term_id, 'medium' );
				$link      = get_term_link( $category );
				$count     = $category->count;
				?>
				<a href="<?php echo esc_url( $link ); ?>" class="group block rounded-2xl overflow-hidden bg-white border border-gray-100 shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
					<div class="relative w-full aspect-square overflow-hidden bg-gray-100">
						<?php if ( $image_url ) : ?>
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" loading="lazy" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
						<?php else : ?>
							<div class="absolute inset-0 w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300 text-gray-500">
								<i class="bx bx-category text-5xl"></i>
							</div>
						<?php endif; ?>
					</div>
					<div class="p-4 text-center">
						<h3 class="text-base font-semibold text-gray-900"><?php echo esc_html( $category->name ); ?></h3>
						<?php if ( 'yes' === $atts['show_count'] ) : ?>
							<p class="text-sm text-gray-500 mt-1 inline-flex items-center gap-1"><i class="bx bx-grid-alt"></i><?php printf( _n( '%d app', '%d apps', $count, 'aspv5' ), $count ); ?></p>
						<?php endif; ?>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>

	<?php
	return ob_get_clean();
}
add_shortcode( 'aspv5_categories', 'aspv5_shortcode_categories' );

// ═══════════════════════════════════════════════════════════════════════════════
// HOME PAGE SHORTCODE
// ═══════════════════════════════════════════════════════════════════════════════

/**
 * Home Page Hero Shortcode
 * 
 * Displays featured apps and game collections.
 * 
 * Usage: [aspv5_home_hero]
 */
function aspv5_shortcode_home_hero( $atts ) {
	ob_start();

	// Get featured apps
	$featured_apps = new WP_Query( [
		'post_type'      => [ 'app', 'game' ],
		'posts_per_page' => 6,
		'orderby'        => 'date',
		'order'          => 'DESC',
	] );

	?>
	<section class="aspv5-home-hero py-12 bg-gradient-to-b from-blue-50 to-transparent">
		<div class="max-w-6xl mx-auto px-4">
			<!-- Hero Title -->
			<div class="text-center mb-12">
				<p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-orange mb-4">
					<span class="w-2 h-2 rounded-full bg-orange"></span>
					Discover Amazing Apps
				</p>
				<h1 class="text-5xl font-bold text-gray-900 mb-4">
					Download Premium <span class="text-orange">MOD APK</span> Apps
				</h1>
				<p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
					Get free access to premium apps and games with all features unlocked.
				</p>
				<a href="#browse" class="inline-block px-8 py-4 bg-orange text-white rounded-full font-semibold hover:bg-orange-hover transition-colors">
					Explore Now
				</a>
			</div>

			<!-- Featured Apps Carousel -->
			<?php if ( $featured_apps->have_posts() ) : ?>
				<div class="featured-carousel mb-16">
					<h2 class="text-2xl font-bold mb-6">Featured Applications</h2>
					<div class="flex gap-4 overflow-x-auto snap-x snap-mandatory pb-4">
						<?php while ( $featured_apps->have_posts() ) : ?>
							<?php $featured_apps->the_post(); ?>
							<?php
							$icon = get_post_meta( get_the_ID(), '_app_icon_url', true );
							if ( ! $icon && has_post_thumbnail() ) {
								$icon = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
							}
							$category = wp_get_post_terms( get_the_ID(), 'app-category' );
							?>
							<a href="<?php the_permalink(); ?>" class="snap-start shrink-0 w-[85%] sm:w-[60%] md:w-[45%] lg:w-[30%] rounded-2xl overflow-hidden no-underline text-dark bg-white block relative group">
								<div class="relative w-full aspect-video overflow-hidden">
									<?php if ( $icon ) : ?>
										<img src="<?php echo esc_url( $icon ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
									<?php else : ?>
										<div class="w-full h-full bg-gray-200 flex items-center justify-center text-5xl font-bold text-gray-400">
											<?php echo strtoupper( substr( get_the_title(), 0, 1 ) ); ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="p-4 flex items-center gap-3 bg-white/50 backdrop-blur-sm absolute bottom-0 left-0 right-0">
									<?php if ( $icon ) : ?>
										<img src="<?php echo esc_url( $icon ); ?>" class="w-10 h-10 rounded-xl shadow-sm" alt="<?php the_title_attribute(); ?>">
									<?php endif; ?>
									<div>
										<h3 class="font-semibold text-dark text-md m-0 leading-tight"><?php the_title(); ?></h3>
										<?php if ( ! empty( $category ) ) : ?>
											<p class="text-xs font-semibold text-orange mt-0.5"><?php echo esc_html( $category[0]->name ); ?></p>
										<?php endif; ?>
									</div>
								</div>
							</a>
						<?php endwhile; ?>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</section>

	<?php
	return ob_get_clean();
}
add_shortcode( 'aspv5_home_hero', 'aspv5_shortcode_home_hero' );

/**
 * Home Page Collections Shortcode
 * 
 * Displays app collections/categories in grid.
 * 
 * Usage: [aspv5_home_collections]
 */
function aspv5_shortcode_home_collections( $atts ) {
	ob_start();

	$collections = [
		[
			'title' => 'Must Have Collection',
			'icon'  => 'settings',
		],
		[
			'title' => 'Gaming Paradise',
			'icon'  => 'gamepad',
		],
		[
			'title' => 'Creative Tools',
			'icon'  => 'palette',
		],
	];

	?>
	<section class="py-12">
		<div class="max-w-6xl mx-auto px-4">
			<h2 class="text-3xl font-bold mb-8">Collections & Curated Lists</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<?php
				$categories = get_terms( [
					'taxonomy'   => 'app-category',
					'hide_empty' => false,
					'number'     => 3,
				] );

				foreach ( $categories as $category ) :
					$image_url = aspv5_shortcode_category_image_url( $category->term_id, 'large' );
					$link      = get_term_link( $category );
					?>
					<a href="<?php echo esc_url( $link ); ?>" class="collection-card relative rounded-2xl overflow-hidden aspect-square group cursor-pointer no-underline text-dark">
						<?php if ( $image_url ) : ?>
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500">
						<?php else : ?>
							<div class="absolute inset-0 w-full h-full bg-gradient-to-br from-orange-100 to-blue-100"></div>
						<?php endif; ?>

						<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent transition-opacity duration-300 group-hover:opacity-50"></div>

						<div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 z-[2]">
							<h2 class="text-white font-bold text-lg sm:text-xl leading-snug drop-shadow">
								<?php echo esc_html( $category->name ); ?>
							</h2>
							<p class="text-white/80 text-sm mt-2 drop-shadow">
								<?php printf( _n( '%d app', '%d apps', $category->count, 'aspv5' ), $category->count ); ?>
							</p>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
	return ob_get_clean();
}
add_shortcode( 'aspv5_home_collections', 'aspv5_shortcode_home_collections' );
