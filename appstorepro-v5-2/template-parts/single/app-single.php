<?php
// template-parts/single/app-single.php — AppStore Pro V5
$post_id         = get_the_ID();
$icon_url        = aspv5_get_app_meta( $post_id, '_app_icon_url' );
$hero_img        = aspv5_get_app_meta( $post_id, '_app_hero_image_url' );
$version         = aspv5_get_app_meta( $post_id, '_app_version' );
$size            = aspv5_get_app_meta( $post_id, '_app_size' );
$developer       = aspv5_get_app_meta( $post_id, '_app_developer' );
$rating_raw      = aspv5_get_app_meta( $post_id, '_app_rating' );
$rating          = $rating_raw ? number_format( (float) $rating_raw, 1, '.', '' ) : '';
$android_ver     = aspv5_get_app_meta( $post_id, '_app_android_version' );
$download_url    = aspv5_get_app_meta( $post_id, '_app_download_url' );
$play_store_url  = aspv5_get_app_meta( $post_id, '_app_play_store_url' );
$telegram_url    = get_theme_mod( 'aspv5_social_telegram', aspv5_get_app_meta( $post_id, '_app_telegram_url' ) );
$tg_members      = get_theme_mod( 'aspv5_social_telegram_status', aspv5_get_app_meta( $post_id, '_app_telegram_members' ) );
$youtube_url     = aspv5_get_app_meta( $post_id, '_app_youtube_url' );
$is_mod          = aspv5_get_app_meta( $post_id, '_app_is_mod' );
$mod_info        = aspv5_get_app_meta( $post_id, '_app_mod_info' );
$downloads_raw   = aspv5_get_app_meta( $post_id, '_app_downloads' );
$downloads       = aspv5_format_downloads( $downloads_raw );
$short_summary   = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ? get_the_excerpt() : get_the_content() ), 20 );
$extra_downloads_raw = aspv5_get_app_meta( $post_id, '_app_extra_downloads' );
$extra_downloads = [];
if ( $extra_downloads_raw ) {
	foreach ( preg_split( '/\r?\n/', $extra_downloads_raw ) as $download_line ) {
		$download_line = trim( $download_line );
		if ( '' === $download_line ) {
			continue;
		}

		$label = '';
		$url   = '';

		if ( false !== strpos( $download_line, '|' ) ) {
			list( $label, $url ) = array_map( 'trim', explode( '|', $download_line, 2 ) );
		} elseif ( preg_match( '#^(https?://\S+)\s*[-:]\s*(.+)$#', $download_line, $match ) ) {
			$url   = trim( $match[1] );
			$label = trim( $match[2] );
		} else {
			$url = $download_line;
		}

		$url = esc_url_raw( $url );
		if ( ! $url ) {
			continue;
		}

		if ( '' === $label ) {
			$label = basename( wp_parse_url( $url, PHP_URL_PATH ) ?: '' );
			$label = $label ? preg_replace( '/\.(apk|zip|xapk|apkm)$/i', '', $label ) : __( 'Old Version', 'aspv5' );
		}

		$extra_downloads[] = [
			'label' => sanitize_text_field( $label ),
			'url'   => $url,
		];
	}
}
$screenshots_raw = aspv5_get_app_meta( $post_id, '_app_screenshots' );
$screenshots     = $screenshots_raw ? array_filter( array_map( 'trim', explode( "\n", $screenshots_raw ) ) ) : [];
$screenshots     = array_values( array_filter( $screenshots, static function( $url ) use ( $icon_url ) {
	if ( ! $url ) {
		return false;
	}

	$u = strtolower( trim( $url ) );
	if ( strpos( $u, 'play-lh.googleusercontent.com' ) !== false ) {
		if ( preg_match( '/=s\\d{1,3}(?:-[^\\s]*)?$/', $u ) || preg_match( '/=w\\d{1,3}-h\\d{1,3}/', $u ) || strpos( $u, 'w48-h16' ) !== false ) {
			return false;
		}
	}

	if ( $icon_url && untrailingslashit( $u ) === untrailingslashit( strtolower( $icon_url ) ) ) {
		return false;
	}

	return true;
} ) );
$terms           = get_the_terms( $post_id, 'app-category' );
$cat_name        = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
$cat_link        = ( $terms && ! is_wp_error( $terms ) ) ? get_term_link( $terms[0] ) : '';
$icon_src        = $icon_url ?: ( has_post_thumbnail() ? get_the_post_thumbnail_url( $post_id, 'app-icon' ) : '' );
$post_type_label = get_post_type() === 'game' ? __( 'Game', 'aspv5' ) : __( 'App', 'aspv5' );
$quick_stats     = array_filter( [
	__( 'Version', 'aspv5' )   => $version,
	__( 'Size', 'aspv5' )      => $size,
	__( 'Downloads', 'aspv5' ) => $downloads,
	__( 'Android', 'aspv5' )   => $android_ver ? $android_ver . '+' : '',
] );
$post_ad_code    = get_theme_mod( 'aspv5_ad_post', '' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'pb-20 sa-single-shell bg-gray-900 text-gray-200' ); ?>>

	<!-- ── Hero Banner ── -->
	<div class="relative bg-gray-900 overflow-hidden"
	     style="height: clamp(180px, 34vw, 360px);">
		<?php if ( $hero_img ) : ?>
			<img src="<?php echo esc_url( $hero_img ); ?>"
			     alt="<?php echo esc_attr( get_the_title() ); ?>"
			     class="absolute inset-0 w-full h-full object-cover opacity-65"
			     loading="eager">
		<?php elseif ( $screenshots ) : ?>
			<img src="<?php echo esc_url( reset( $screenshots ) ); ?>"
			     alt="<?php echo esc_attr( get_the_title() ); ?>"
			     class="absolute inset-0 w-full h-full object-cover opacity-55"
			     loading="eager">
		<?php else : ?>
			<div class="absolute inset-0 bg-gradient-to-br from-[color:var(--asp-primary)] to-orange-600 opacity-80"></div>
		<?php endif; ?>
		<div class="absolute inset-0 bg-gradient-to-b from-black/25 via-black/45 to-black/80"></div>

		<div class="absolute inset-x-0 bottom-0 z-10">
			<div class="max-w-6xl mx-auto px-4 pb-4">
				<div class="bg-red-500/95 text-white rounded-xl p-4 sm:p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
					<div class="flex items-center gap-4 min-w-0">
						<div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border-2 border-white/60 flex-shrink-0 bg-white/20">
							<?php if ( $icon_src ) : ?>
								<img src="<?php echo esc_url( $icon_src ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full h-full object-cover" loading="eager">
							<?php endif; ?>
						</div>
						<div class="min-w-0">
							<h1 class="text-xl sm:text-3xl font-bold leading-tight text-white truncate sm:whitespace-normal"><?php echo esc_html( get_the_title() ); ?></h1>
							<?php if ( $developer ) : ?>
								<p class="text-white/90 text-sm mt-1"><?php echo esc_html( $developer ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- ── Breadcrumb ── -->
	<div class="max-w-6xl mx-auto px-4 py-4 text-green-400 text-sm">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-green-300"><?php esc_html_e( 'Home', 'aspv5' ); ?></a>
		<span class="mx-1 text-gray-500">&gt;</span>
		<?php if ( get_post_type_archive_link( get_post_type() ) ) : ?>
			<a href="<?php echo esc_url( get_post_type_archive_link( get_post_type() ) ); ?>" class="hover:text-green-300"><?php echo esc_html( get_post_type() === 'game' ? __( 'Games', 'aspv5' ) : __( 'Apps', 'aspv5' ) ); ?></a>
			<span class="mx-1 text-gray-500">&gt;</span>
		<?php endif; ?>
		<?php if ( $cat_name && $cat_link ) : ?>
			<a href="<?php echo esc_url( $cat_link ); ?>" class="hover:text-green-300"><?php echo esc_html( $cat_name ); ?></a>
			<span class="mx-1 text-gray-500">&gt;</span>
		<?php endif; ?>
		<span class="text-orange-400"><?php echo esc_html( get_the_title() ); ?></span>
	</div>

	<!-- ── App Info Card ── -->
	<div class="max-w-6xl mx-auto px-4">
		<div class="mb-6">
			<div class="max-w-2xl mx-auto bg-gray-800 rounded-xl shadow-lg p-6 space-y-4 border border-gray-700">

				<!-- Icon -->
				<div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-900 flex-shrink-0 border border-gray-700">
					<?php if ( $icon_src ) : ?>
						<img src="<?php echo esc_url( $icon_src ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full h-full object-cover" loading="eager">
					<?php else : ?>
						<div class="app-icon-placeholder h-full"><span><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span></div>
					<?php endif; ?>
				</div>

				<!-- Meta -->
				<div class="flex-1 min-w-0">
					<div class="flex gap-1 mb-1 flex-wrap">
						<?php if ( $is_mod ) : ?>
							<span class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold"><?php esc_html_e( 'PREMIUM', 'aspv5' ); ?></span>
						<?php endif; ?>
						<span class="bg-orange-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold"><?php esc_html_e( 'Editor\'s Choice', 'aspv5' ); ?></span>
					</div>
					<h2 class="text-xl font-bold text-white leading-tight mb-1">
						<?php echo esc_html( get_the_title() ); ?>
					</h2>
					<?php if ( $developer ) : ?>
						<p class="text-green-400 text-sm"><?php echo esc_html( $developer ); ?></p>
					<?php endif; ?>

					<?php if ( $mod_info ) : ?>
						<p class="text-orange-400 italic text-sm mt-2"><?php echo esc_html( $mod_info ); ?></p>
					<?php endif; ?>

					<?php if ( $short_summary ) : ?>
						<p class="text-gray-300 text-sm mt-1"><?php echo esc_html( $short_summary ); ?></p>
					<?php endif; ?>

					<!-- CTA Buttons -->
					<div class="mt-4">
						<?php if ( $download_url ) : ?>
							<a href="<?php echo esc_url( $download_url ); ?>"
							   class="w-full inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition-colors"
							   rel="nofollow noopener" target="_blank">
								<i class="bx bxs-download text-base"></i>
								<?php esc_html_e( 'Download APK', 'aspv5' ); ?>
							</a>
						<?php endif; ?>
						<div class="flex items-center justify-between mt-4 text-sm text-gray-400">
							<button class="inline-flex items-center gap-1 hover:text-white" id="sa-share-btn" aria-label="<?php esc_attr_e( 'Share', 'aspv5' ); ?>">
								<i class="bx bx-share-alt text-base"></i>
								<span><?php esc_html_e( 'Share', 'aspv5' ); ?></span>
							</button>
							<a href="#" class="inline-flex items-center gap-1 hover:text-white" rel="nofollow">
								<i class="bx bx-plus text-base"></i>
								<span><?php esc_html_e( 'Request Update', 'aspv5' ); ?></span>
							</a>
						</div>
					</div>

					<?php if ( $extra_downloads ) : ?>
						<details class="mt-3 sa-download-accordion rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-50 dark:bg-gray-800/50">
							<summary class="list-none cursor-pointer flex items-center justify-between gap-3 px-4 py-3 font-semibold text-sm text-gray-800 dark:text-gray-200">
								<span><?php esc_html_e( 'More Downloads / Old Versions', 'aspv5' ); ?></span>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="sa-download-arrow w-4 h-4 text-gray-400 transition-transform"><polyline points="6 9 12 15 18 9"/></svg>
							</summary>
							<div class="px-4 pb-4 grid gap-2">
								<?php foreach ( $extra_downloads as $extra_download ) : ?>
									<a href="<?php echo esc_url( $extra_download['url'] ); ?>" target="_blank" rel="nofollow noopener"
									   class="inline-flex items-center justify-between gap-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm font-semibold text-gray-800 dark:text-gray-100 hover:border-[color:var(--asp-primary)] hover:text-[color:var(--asp-primary)] transition-colors">
										<span><?php echo esc_html( $extra_download['label'] ); ?></span>
										<i class="bx bx-download text-base opacity-80"></i>
									</a>
								<?php endforeach; ?>
							</div>
						</details>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>

	<!-- ── Screenshots ── -->
	<?php if ( $screenshots ) : ?>
	<section class="mb-6">
		<div class="max-w-6xl mx-auto px-4">
			<h2 class="text-base font-bold text-gray-800 dark:text-gray-200 mb-3"><?php esc_html_e( 'Screenshots', 'aspv5' ); ?></h2>
			<div class="aspv5-hscroll" id="sa-sc-scroll">
				<?php foreach ( $screenshots as $i => $sc_url ) : ?>
					<div class="sa-sc-item w-36 rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-800 flex-shrink-0 shadow-sm">
						<img src="<?php echo esc_url( $sc_url ); ?>"
						     alt="<?php printf( esc_attr__( 'Screenshot %d', 'aspv5' ), $i + 1 ); ?>"
						     class="w-full h-auto"
						     loading="lazy">
					</div>
				<?php endforeach; ?>
			</div>
			<?php if ( count( $screenshots ) > 1 ) : ?>
				<div class="flex justify-center gap-1.5 mt-3" id="sa-sc-dots">
					<?php foreach ( $screenshots as $i => $sc_url ) : ?>
						<button class="sa-sc-dot<?php echo $i === 0 ? ' active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>" aria-label="<?php printf( esc_attr__( 'Screenshot %d', 'aspv5' ), $i + 1 ); ?>"></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<!-- ── Telegram Card ── -->
	<?php if ( $telegram_url ) : ?>
	<section class="mb-6 aspv5-reveal">
		<div class="max-w-6xl mx-auto px-4">
			<div class="flex items-center gap-4 bg-[#0088cc]/10 dark:bg-[#0088cc]/10 border border-[#0088cc]/20 rounded-2xl p-4">
				<div class="w-12 h-12 rounded-full bg-[#0088cc]/20 flex items-center justify-center flex-shrink-0 text-[#0088cc]">
					<i class="bx bxl-telegram text-2xl"></i>
				</div>
				<div class="flex-1 min-w-0">
					<h3 class="font-semibold text-gray-900 dark:text-white text-sm"><?php esc_html_e( 'Join our Telegram', 'aspv5' ); ?></h3>
					<?php if ( $tg_members ) : ?>
						<p class="text-xs text-gray-500 dark:text-gray-400"><?php echo esc_html( $tg_members ); ?></p>
					<?php endif; ?>
				</div>
				<a href="<?php echo esc_url( $telegram_url ); ?>"
				   class="flex-shrink-0 bg-[#0088cc] hover:bg-[#006da8] text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors"
				   target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Join', 'aspv5' ); ?>
				</a>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- ── Info Bar ── -->
	<section class="mb-6 aspv5-reveal">
		<div class="max-w-6xl mx-auto px-4">
			<div class="info-bar-scroll">
				<div class="info-bar-item">
					<div class="info-bar-label"><?php esc_html_e( 'VERSION', 'aspv5' ); ?></div>
					<div class="info-bar-value"><?php echo esc_html( $version ?: '-' ); ?></div>
					<div class="info-bar-sub"><?php esc_html_e( 'Latest', 'aspv5' ); ?></div>
				</div>
				<div class="info-bar-item">
					<div class="info-bar-label"><?php esc_html_e( 'SIZE', 'aspv5' ); ?></div>
					<div class="info-bar-value"><?php echo esc_html( $size ?: '-' ); ?></div>
					<div class="info-bar-sub"><?php esc_html_e( 'Total', 'aspv5' ); ?></div>
				</div>
				<div class="info-bar-item">
					<div class="info-bar-label"><?php esc_html_e( 'GENRE', 'aspv5' ); ?></div>
					<div class="info-bar-icon"><i class="bx bx-category"></i></div>
					<div class="info-bar-sub"><?php if ( $cat_name && $cat_link ) : ?><a class="text-primary font-medium" href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a><?php else : ?>-<?php endif; ?></div>
				</div>
				<div class="info-bar-item">
					<div class="info-bar-label"><?php esc_html_e( 'DEVELOPER', 'aspv5' ); ?></div>
					<div class="info-bar-icon"><i class="bx bx-user"></i></div>
					<div class="info-bar-sub"><span class="text-primary font-medium"><?php echo esc_html( $developer ?: '-' ); ?></span></div>
				</div>
				<div class="info-bar-item">
					<div class="info-bar-label"><?php esc_html_e( 'REACHED', 'aspv5' ); ?></div>
					<div class="info-bar-value"><?php echo esc_html( $downloads ?: '-' ); ?></div>
					<div class="info-bar-sub"><?php esc_html_e( 'Views', 'aspv5' ); ?></div>
				</div>
				<div class="info-bar-item">
					<div class="info-bar-label"><?php esc_html_e( 'UPDATED', 'aspv5' ); ?></div>
					<div class="info-bar-value info-bar-value--sm"><?php echo esc_html( get_the_modified_date( 'M j' ) ); ?></div>
					<div class="info-bar-sub"><?php echo esc_html( get_the_modified_date( 'Y' ) ); ?></div>
				</div>
				<div class="info-bar-item">
					<div class="info-bar-label"><?php esc_html_e( 'RATING', 'aspv5' ); ?></div>
					<div class="info-bar-value"><?php echo esc_html( $rating ? $rating . ' ★' : '-' ); ?></div>
					<div class="info-bar-sub"><?php esc_html_e( 'Score', 'aspv5' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- ── YouTube Tutorial ── -->
	<?php if ( $youtube_url ) :
		$yt_id = '';
		if ( preg_match( '/(?:[?&]v=|\/embed\/|youtu\.be\/|\/shorts\/)([a-zA-Z0-9_-]{11})/', $youtube_url, $m ) ) { $yt_id = $m[1]; }
		$embed_url = $yt_id ? 'https://www.youtube-nocookie.com/embed/' . $yt_id . '?rel=0' : '';
	?>
	<section class="mb-6 aspv5-reveal">
		<div class="max-w-6xl mx-auto px-4">
			<button class="w-full flex items-center justify-between bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl px-4 py-3 sa-tut-tog group"
			        aria-expanded="false">
				<span class="flex items-center gap-2 text-sm font-semibold text-gray-800 dark:text-gray-200">
					<svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-red-500"><path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
					<?php esc_html_e( 'Watch Tutorial', 'aspv5' ); ?>
				</span>
				<svg class="sa-tut-arrow w-4 h-4 text-gray-400 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
			</button>
			<div class="sa-tut-body" style="display:none;">
				<div class="mt-2 rounded-2xl overflow-hidden bg-black" style="aspect-ratio:16/9;">
					<?php if ( $embed_url ) : ?>
						<iframe src="<?php echo esc_url( $embed_url ); ?>"
						        class="w-full h-full"
						        loading="lazy"
						        title="<?php esc_attr_e( 'YouTube Tutorial', 'aspv5' ); ?>"
						        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
						        referrerpolicy="strict-origin-when-cross-origin"
						        allowfullscreen></iframe>
					<?php else : ?>
						<div class="w-full h-full flex items-center justify-center text-gray-300 text-sm px-4 text-center"><?php esc_html_e( 'Invalid YouTube URL. Please update the tutorial link.', 'aspv5' ); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- ── App Content ── -->
	<?php if ( get_the_content() ) : ?>
	<section class="mb-6 aspv5-reveal">
		<div class="max-w-6xl mx-auto px-4">
			<h2 class="text-base font-bold text-gray-800 dark:text-gray-200 mb-3"><?php esc_html_e( 'About', 'aspv5' ); ?></h2>
			<div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
				<div class="entry-content text-sm leading-relaxed text-gray-700 dark:text-gray-300" id="sa-entry-content">
					<?php the_content(); ?>
				</div>
				<button class="mt-4 w-full text-center text-sm font-semibold text-primary hover:opacity-80 transition-opacity"
				        id="sa-show-more"
				        type="button"
				        data-show-label="<?php esc_attr_e( 'Show more', 'aspv5' ); ?>"
				        data-hide-label="<?php esc_attr_e( 'Show less', 'aspv5' ); ?>">
					<?php esc_html_e( 'Show more', 'aspv5' ); ?>
				</button>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $post_ad_code ) : ?>
	<section class="mb-6 aspv5-reveal">
		<div class="max-w-6xl mx-auto px-4 aspv5-ad-slot aspv5-ad-post">
			<?php echo do_shortcode( wp_kses_post( $post_ad_code ) ); ?>
		</div>
	</section>
	<?php endif; ?>

	<!-- ── Play Store Link ── -->
	<?php if ( $play_store_url ) : ?>
	<section class="mb-6 aspv5-reveal">
		<div class="max-w-6xl mx-auto px-4">
			<a href="<?php echo esc_url( $play_store_url ); ?>"
			   class="flex items-center gap-3 p-4 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 hover:border-green-300 dark:hover:border-green-800 transition-colors group"
			   target="_blank" rel="noopener noreferrer">
				<div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
					<svg viewBox="0 0 24 24" class="w-5 h-5" aria-hidden="true"><path fill="#4285F4" d="M12.6 11.5l3.6-3.8L4.5 1.2c-.4-.2-.8-.2-1.2 0l9.3 10.3z"></path><path fill="#34A853" d="M19.8 10.1L16.2 8l-3.6 3.5 3.6 3.5 3.6-2.1c.7-.4.7-1.4 0-1.8z"></path><path fill="#FBBC04" d="M3.3 1.2C3.1 1.5 3 1.8 3 2.2v19.6c0 .4.1.7.3 1l9.3-9.3L3.3 1.2z"></path><path fill="#EA4335" d="M12.6 12.5L3.3 21.8c.4.2.8.2 1.2 0l11.7-6.5-3.6-2.8z"></path></svg>
				</div>
				<div class="flex-1">
					<div class="text-[10px] uppercase tracking-wide text-gray-500 dark:text-gray-400"><?php esc_html_e( 'Get it on', 'aspv5' ); ?></div>
					<div class="text-sm font-semibold text-gray-900 dark:text-gray-100"><?php esc_html_e( 'Google Play', 'aspv5' ); ?></div>
					<div class="text-xs text-gray-500 dark:text-gray-400"><?php esc_html_e( 'Official version', 'aspv5' ); ?></div>
				</div>
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="w-4 h-4 text-gray-300 dark:text-gray-600 flex-shrink-0"><polyline points="9 18 15 12 9 6"/></svg>
			</a>
		</div>
	</section>
	<?php endif; ?>

	<!-- ── Author Card ── -->
	<section class="mb-6 aspv5-reveal">
		<div class="max-w-6xl mx-auto px-4">
			<div class="flex items-center gap-3 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-4">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 44, '', get_the_author(), [ 'class' => 'w-11 h-11 rounded-full flex-shrink-0' ] ); ?>
				<div class="flex-1 min-w-0">
					<div class="text-[10px] text-gray-500 dark:text-gray-400 uppercase tracking-wide"><?php esc_html_e( 'Published by', 'aspv5' ); ?></div>
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:text-primary transition-colors"><?php echo esc_html( get_the_author() ); ?></a>
				</div>
				<div class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0"><?php echo esc_html( get_the_date() ); ?></div>
			</div>
		</div>
	</section>

	<!-- ── Related Apps ── -->
	<?php
	$related_args = [
		'post_type'      => get_post_type(),
		'posts_per_page' => 4,
		'post__not_in'   => [ $post_id ],
		'orderby'        => 'rand',
		'post_status'    => 'publish',
	];
	if ( $terms && ! is_wp_error( $terms ) ) {
		$related_args['tax_query'] = [ [
			'taxonomy' => 'app-category',
			'field'    => 'term_id',
			'terms'    => wp_list_pluck( $terms, 'term_id' ),
		] ];
	}
	$related = new WP_Query( $related_args );
	?>
	<?php if ( $related->have_posts() ) : ?>
	<section class="mb-6 aspv5-reveal">
		<div class="max-w-6xl mx-auto px-4">
			<h2 class="text-base font-bold text-gray-800 dark:text-gray-200 mb-3"><?php esc_html_e( 'Related', 'aspv5' ); ?></h2>
			<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
				<?php while ( $related->have_posts() ) : $related->the_post(); ?>
					<?php get_template_part( 'template-parts/content/content', 'app', [ 'layout' => 'grid' ] ); ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</article>

<!-- ── Sticky Download Bar ── -->
<?php if ( $download_url ) : ?>
<div class="sa-sticky bg-white/95 dark:bg-gray-900/95 backdrop-blur-md border-t border-gray-100 dark:border-gray-800 shadow-xl" id="sa-sticky">
	<div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-3">
		<div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 flex-shrink-0">
			<?php if ( $icon_src ) : ?>
				<img src="<?php echo esc_url( $icon_src ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full h-full object-cover" loading="lazy">
			<?php endif; ?>
		</div>
		<div class="flex-1 min-w-0">
			<div class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate"><?php echo esc_html( get_the_title() ); ?></div>
			<?php if ( $version ) : ?>
				<div class="text-xs text-gray-500 dark:text-gray-400">v<?php echo esc_html( $version ); ?></div>
			<?php endif; ?>
		</div>
		<a href="<?php echo esc_url( $download_url ); ?>"
		   class="flex-shrink-0 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-colors"
		   rel="nofollow noopener" target="_blank">
			<?php esc_html_e( 'GET', 'aspv5' ); ?>
		</a>
	</div>
</div>
<?php endif; ?>
