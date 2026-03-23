<?php
// inc/apk-extractor.php — APK Extractor Admin Panel

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ── Register admin menu ──────────────────────────────────────────────────────
function appstorepro_apk_extractor_menu() {
	add_submenu_page(
		'edit.php?post_type=app',
		__( 'APK Extractor', 'appstorepro' ),
		__( 'APK Extractor', 'appstorepro' ),
		'edit_posts',
		'appstorepro-apk-extractor',
		'appstorepro_apk_extractor_page'
	);
}
add_action( 'admin_menu', 'appstorepro_apk_extractor_menu' );

// ── Enqueue admin assets ─────────────────────────────────────────────────────
function appstorepro_apk_extractor_assets( $hook ) {
	if ( 'app_page_appstorepro-apk-extractor' !== $hook ) {
		return;
	}
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style(
		'appstorepro-apk-extractor',
		get_template_directory_uri() . '/assets/css/apk-extractor.css',
		[],
		$ver
	);
	wp_enqueue_script(
		'appstorepro-apk-extractor',
		get_template_directory_uri() . '/assets/js/apk-extractor.js',
		[ 'jquery' ],
		$ver,
		true
	);
	wp_localize_script( 'appstorepro-apk-extractor', 'ApkExtractor', [
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'appstorepro_apk_extractor' ),
		'i18n'    => [
			'scraping'      => __( 'Scraping…', 'appstorepro' ),
			'done'          => __( 'Done!', 'appstorepro' ),
			'error'         => __( 'Error', 'appstorepro' ),
			'creating'      => __( 'Creating app post…', 'appstorepro' ),
			'created'       => __( 'App post created!', 'appstorepro' ),
			'no_title'      => __( 'Could not determine app title. Please check the URL.', 'appstorepro' ),
			'invalid_url'   => __( 'Please enter a valid Play Store URL.', 'appstorepro' ),
			'bulk_start'    => __( 'Starting bulk scrape…', 'appstorepro' ),
			'bulk_progress' => __( 'Processing', 'appstorepro' ),
			'bulk_done'     => __( 'Bulk scrape complete!', 'appstorepro' ),
			'view_post'     => __( 'View Post', 'appstorepro' ),
			'edit_post'     => __( 'Edit Post', 'appstorepro' ),
		],
	] );
}
add_action( 'admin_enqueue_scripts', 'appstorepro_apk_extractor_assets' );

// ── Admin page HTML ──────────────────────────────────────────────────────────
function appstorepro_apk_extractor_page() {
	?>
	<div class="wrap apk-extractor-wrap">
		<h1 class="apk-extractor-title">
			<span class="apk-icon-title">&#127381;</span>
			<?php esc_html_e( 'APK Extractor', 'appstorepro' ); ?>
		</h1>
		<p class="apk-extractor-desc">
			<?php esc_html_e( 'Paste a Google Play Store URL to scrape app details and auto-create an App post. Use Bulk mode to process multiple URLs at once.', 'appstorepro' ); ?>
		</p>

		<?php /* Tab Navigation */ ?>
		<nav class="apk-tabs" role="tablist">
			<button class="apk-tab active" data-tab="single" role="tab" aria-selected="true" aria-controls="tab-single">
				<?php esc_html_e( 'Single URL', 'appstorepro' ); ?>
			</button>
			<button class="apk-tab" data-tab="bulk" role="tab" aria-selected="false" aria-controls="tab-bulk">
				<?php esc_html_e( 'Bulk URLs', 'appstorepro' ); ?>
			</button>
		</nav>

		<?php /* ── Single URL Tab ── */ ?>
		<div id="tab-single" class="apk-tab-panel active" role="tabpanel">
			<div class="apk-card">
				<div class="apk-field-row">
					<label for="apk-single-url"><?php esc_html_e( 'Play Store URL', 'appstorepro' ); ?></label>
					<div class="apk-input-group">
						<input type="url" id="apk-single-url" class="regular-text apk-url-input"
							placeholder="https://play.google.com/store/apps/details?id=com.example.app"
							autocomplete="off">
						<button type="button" id="apk-scrape-btn" class="button button-primary apk-btn-primary">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
							<?php esc_html_e( 'Scrape', 'appstorepro' ); ?>
						</button>
					</div>
					<p class="apk-hint"><?php esc_html_e( 'e.g. https://play.google.com/store/apps/details?id=com.whatsapp', 'appstorepro' ); ?></p>
				</div>
			</div>

			<div id="apk-single-status" class="apk-status" style="display:none;"></div>

			<div id="apk-single-result" class="apk-result-panel" style="display:none;">
				<div class="apk-result-header">
					<div class="apk-result-app-icon" id="apk-result-icon-wrap"></div>
					<div class="apk-result-app-meta">
						<h2 id="apk-result-title"></h2>
						<p id="apk-result-developer" class="apk-result-dev"></p>
						<div class="apk-result-pills" id="apk-result-pills"></div>
					</div>
				</div>

				<table class="apk-data-table widefat">
					<tbody id="apk-data-rows"></tbody>
				</table>

				<div class="apk-result-actions">
					<button type="button" id="apk-create-btn" class="button button-primary apk-btn-primary apk-btn-large">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
						<?php esc_html_e( 'Create App Post', 'appstorepro' ); ?>
					</button>
					<button type="button" id="apk-rescrape-btn" class="button apk-btn-secondary">
						<?php esc_html_e( 'Re-scrape', 'appstorepro' ); ?>
					</button>
				</div>
				<div id="apk-create-status" class="apk-status" style="display:none;"></div>
			</div>
		</div>

		<?php /* ── Bulk URLs Tab ── */ ?>
		<div id="tab-bulk" class="apk-tab-panel" role="tabpanel" hidden>
			<div class="apk-card">
				<div class="apk-field-row">
					<label for="apk-bulk-urls"><?php esc_html_e( 'Play Store URLs (one per line)', 'appstorepro' ); ?></label>
					<textarea id="apk-bulk-urls" class="large-text apk-bulk-textarea" rows="8"
						placeholder="https://play.google.com/store/apps/details?id=com.whatsapp&#10;https://play.google.com/store/apps/details?id=com.instagram.android&#10;…"></textarea>
				</div>
				<div class="apk-field-row">
					<label>
						<input type="checkbox" id="apk-bulk-skip-existing" checked>
						<?php esc_html_e( 'Skip if app with same package name already exists', 'appstorepro' ); ?>
					</label>
				</div>
				<div class="apk-field-row">
					<button type="button" id="apk-bulk-btn" class="button button-primary apk-btn-primary apk-btn-large">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 12l4-4 4 4M12 8v8"/></svg>
						<?php esc_html_e( 'Start Bulk Import', 'appstorepro' ); ?>
					</button>
				</div>
			</div>

			<div id="apk-bulk-progress-wrap" style="display:none;">
				<div class="apk-bulk-progress-bar-wrap">
					<div class="apk-bulk-progress-bar" id="apk-bulk-progress-bar"></div>
				</div>
				<div class="apk-bulk-progress-label" id="apk-bulk-progress-label"></div>
			</div>

			<table class="apk-bulk-results widefat" id="apk-bulk-results" style="display:none;">
				<thead>
					<tr>
						<th><?php esc_html_e( '#', 'appstorepro' ); ?></th>
						<th><?php esc_html_e( 'App', 'appstorepro' ); ?></th>
						<th><?php esc_html_e( 'Status', 'appstorepro' ); ?></th>
						<th><?php esc_html_e( 'Actions', 'appstorepro' ); ?></th>
					</tr>
				</thead>
				<tbody id="apk-bulk-results-body"></tbody>
			</table>
		</div>
	</div>
	<?php
}

// ── AJAX: Scrape single URL ──────────────────────────────────────────────────
function appstorepro_ajax_scrape_playstore() {
	check_ajax_referer( 'appstorepro_apk_extractor', 'nonce' );

	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_send_json_error( [ 'message' => __( 'Permission denied.', 'appstorepro' ) ] );
	}

	$url = isset( $_POST['url'] ) ? sanitize_url( wp_unslash( $_POST['url'] ) ) : '';
	if ( ! $url || ! preg_match( '#play\.google\.com/store/apps/details#', $url ) ) {
		wp_send_json_error( [ 'message' => __( 'Invalid Play Store URL.', 'appstorepro' ) ] );
	}

	$data = appstorepro_fetch_playstore_data( $url );

	if ( is_wp_error( $data ) ) {
		wp_send_json_error( [ 'message' => $data->get_error_message() ] );
	}

	wp_send_json_success( $data );
}
add_action( 'wp_ajax_appstorepro_scrape_playstore', 'appstorepro_ajax_scrape_playstore' );

// ── AJAX: Create app post from scraped data ──────────────────────────────────
function appstorepro_ajax_create_app_post() {
	check_ajax_referer( 'appstorepro_apk_extractor', 'nonce' );

	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_send_json_error( [ 'message' => __( 'Permission denied.', 'appstorepro' ) ] );
	}

	$raw = isset( $_POST['app_data'] ) ? wp_unslash( $_POST['app_data'] ) : '';
	$app = json_decode( $raw, true );

	if ( ! $app || empty( $app['title'] ) ) {
		wp_send_json_error( [ 'message' => __( 'Invalid app data.', 'appstorepro' ) ] );
	}

	$skip_existing = ! empty( $_POST['skip_existing'] );
	$package       = sanitize_text_field( $app['package'] ?? '' );

	// Check for existing post with same package
	if ( $skip_existing && $package ) {
		$existing = get_posts( [
			'post_type'      => 'app',
			'posts_per_page' => 1,
			'meta_query'     => [
				[
					'key'     => '_app_package',
					'value'   => $package,
					'compare' => '=',
				],
			],
			'post_status'    => 'any',
			'fields'         => 'ids',
		] );
		if ( $existing ) {
			wp_send_json_success( [
				'skipped' => true,
				'post_id' => $existing[0],
				'title'   => sanitize_text_field( $app['title'] ),
				'edit_url'=> get_edit_post_link( $existing[0], 'raw' ),
				'view_url'=> get_permalink( $existing[0] ),
			] );
		}
	}

	$post_id = wp_insert_post( [
		'post_title'   => sanitize_text_field( $app['title'] ),
		'post_content' => wp_kses_post( $app['description'] ?? '' ),
		'post_status'  => 'draft',
		'post_type'    => 'app',
		'post_author'  => get_current_user_id(),
	], true );

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( [ 'message' => $post_id->get_error_message() ] );
	}

	// Save meta
	$meta_map = [
		'_app_package'        => $app['package'] ?? '',
		'_app_version'        => $app['version'] ?? '',
		'_app_size'           => $app['size'] ?? '',
		'_app_developer'      => $app['developer'] ?? '',
		'_app_icon_url'       => $app['icon'] ?? '',
		'_app_rating'         => $app['rating'] ?? '',
		'_app_android_version'=> $app['android_version'] ?? '',
		'_app_play_store_url' => $app['play_store_url'] ?? '',
		'_app_hero_image_url' => $app['hero'] ?? '',
		'_app_screenshots'    => implode( "\n", array_map( 'esc_url_raw', array_filter( (array) ( $app['screenshots'] ?? [] ) ) ) ),
		'_app_mod_info'       => $app['mod_info'] ?? '',
	];

	foreach ( $meta_map as $key => $value ) {
		if ( '' !== $value ) {
			update_post_meta( $post_id, $key, sanitize_text_field( (string) $value ) );
		}
	}

	// Set category
	if ( ! empty( $app['category'] ) ) {
		$cat_slug = sanitize_title( $app['category'] );
		$term     = get_term_by( 'slug', $cat_slug, 'app-category' );
		if ( ! $term ) {
			$result = wp_insert_term( sanitize_text_field( $app['category'] ), 'app-category', [ 'slug' => $cat_slug ] );
			if ( ! is_wp_error( $result ) ) {
				$term_id = $result['term_id'];
			}
		} else {
			$term_id = $term->term_id;
		}
		if ( ! empty( $term_id ) ) {
			wp_set_object_terms( $post_id, (int) $term_id, 'app-category' );
		}
	}

	// Set featured image from icon URL
	if ( ! empty( $app['icon'] ) ) {
		appstorepro_sideload_image( $app['icon'], $post_id );
	}

	wp_send_json_success( [
		'post_id'  => $post_id,
		'title'    => sanitize_text_field( $app['title'] ),
		'edit_url' => get_edit_post_link( $post_id, 'raw' ),
		'view_url' => get_permalink( $post_id ),
		'skipped'  => false,
	] );
}
add_action( 'wp_ajax_appstorepro_create_app_post', 'appstorepro_ajax_create_app_post' );

// ── Scrape Play Store page ───────────────────────────────────────────────────
function appstorepro_fetch_playstore_data( $url ) {
	$url = add_query_arg( 'hl', 'en', $url );

	$response = wp_remote_get( $url, [
		'timeout'    => 20,
		'user-agent' => 'Mozilla/5.0 (Linux; Android 10; Mobile) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/Mobile Safari/537.36',
		'headers'    => [
			'Accept-Language' => 'en-US,en;q=0.9',
			'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		],
	] );

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'fetch_failed', sprintf(
			/* translators: %s: error message */
			__( 'Failed to fetch Play Store page: %s', 'appstorepro' ),
			$response->get_error_message()
		) );
	}

	$code = wp_remote_retrieve_response_code( $response );
	if ( 200 !== (int) $code ) {
		return new WP_Error( 'bad_response', sprintf(
			/* translators: %s: HTTP code */
			__( 'Play Store returned HTTP %s. The URL may be invalid or blocked.', 'appstorepro' ),
			(int) $code
		) );
	}

	$html = wp_remote_retrieve_body( $response );
	if ( ! $html ) {
		return new WP_Error( 'empty_body', __( 'Empty response from Play Store.', 'appstorepro' ) );
	}

	return appstorepro_parse_playstore_html( $html, $url );
}

// ── Parse Play Store HTML ────────────────────────────────────────────────────
function appstorepro_parse_playstore_html( $html, $original_url ) {
	$data = [
		'title'           => '',
		'developer'       => '',
		'rating'          => '',
		'description'     => '',
		'icon'            => '',
		'hero'            => '',
		'screenshots'     => [],
		'category'        => '',
		'size'            => '',
		'android_version' => '',
		'version'         => '',
		'package'         => '',
		'play_store_url'  => $original_url,
	];

	// Package ID from URL
	if ( preg_match( '#[?&]id=([A-Za-z0-9._]+)#', $original_url, $m ) ) {
		$data['package'] = $m[1];
	}

	// ── Try JSON-LD first ──
	if ( preg_match_all( '#<script type="application/ld\+json"[^>]*>(.*?)</script>#si', $html, $ldm ) ) {
		foreach ( $ldm[1] as $ld_raw ) {
			$ld = json_decode( $ld_raw, true );
			if ( ! $ld ) {
				continue;
			}
			$type = $ld['@type'] ?? '';
			if ( in_array( $type, [ 'SoftwareApplication', 'MobileApplication', 'VideoGame' ], true ) ) {
				$data['title']       = $data['title']       ?: ( $ld['name'] ?? '' );
				$data['developer']   = $data['developer']   ?: ( $ld['author']['name'] ?? $ld['author'] ?? '' );
				$data['rating']      = $data['rating']      ?: ( $ld['aggregateRating']['ratingValue'] ?? '' );
				$data['description'] = $data['description'] ?: ( $ld['description'] ?? '' );
				$data['category']    = $data['category']    ?: ( $ld['applicationCategory'] ?? '' );
				$data['android_version'] = $data['android_version'] ?: ( $ld['operatingSystem'] ?? '' );
				if ( isset( $ld['image'] ) && is_string( $ld['image'] ) ) {
					$data['icon'] = $data['icon'] ?: $ld['image'];
				}
				break;
			}
		}
	}

	// ── Meta tags fallback ──
	if ( ! $data['title'] && preg_match( '#<meta\s+property="og:title"\s+content="([^"]*)"#i', $html, $m ) ) {
		$data['title'] = html_entity_decode( $m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	}
	if ( ! $data['title'] && preg_match( '#<title[^>]*>([^<]+)</title>#i', $html, $m ) ) {
		$raw_title = html_entity_decode( $m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		$data['title'] = preg_replace( '#\s*[-–|].*$#', '', $raw_title );
	}
	if ( ! $data['description'] && preg_match( '#<meta\s+(?:name|property)="(?:og:)?description"\s+content="([^"]*)"#i', $html, $m ) ) {
		$data['description'] = html_entity_decode( $m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	}
	if ( ! $data['icon'] && preg_match( '#<meta\s+property="og:image"\s+content="([^"]*)"#i', $html, $m ) ) {
		$data['icon'] = esc_url_raw( $m[1] );
	}

	// ── Try additional rating extraction if not found yet ──
	if ( ! $data['rating'] ) {
		// Try numeric rating like "4.5" near the word "star" or "rating"
		if ( preg_match( '#\b([1-4]\.\d)\b[^<]*(?:star|rating)#i', $html, $m ) ) {
			$data['rating'] = $m[1];
		} elseif ( preg_match( '#"ratingValue"\s*:\s*"?([0-9.]+)"?#', $html, $m ) ) {
			$data['rating'] = $m[1];
		}
	}

	// ── Screenshots from og/itemprop images ──
	preg_match_all( '#<img[^>]+src="(https://play-lh\.googleusercontent\.com/[^"]{40,})"[^>]*>#i', $html, $img_m );
	$seen_icons = [];
	foreach ( $img_m[1] as $img_url ) {
		// Icons are typically small; screenshots are large
		$clean = preg_replace( '#=\w\d+#', '', $img_url );
		if ( in_array( $clean, $seen_icons, true ) ) {
			continue;
		}
		$seen_icons[] = $clean;
		// First match is usually the icon; rest are screenshots
		if ( ! $data['icon'] ) {
			$data['icon'] = $img_url;
		} else {
			if ( count( $data['screenshots'] ) < 8 ) {
				$data['screenshots'][] = $img_url;
			}
		}
	}

	// ── Rating from itemprop ──
	if ( ! $data['rating'] ) {
		if ( preg_match( '#itemprop="ratingValue"[^>]*content="([^"]+)"#i', $html, $m ) ) {
			$data['rating'] = $m[1];
		} elseif ( preg_match( '#"(\d+\.\d)\s*(?:out of|\/)\s*5"#', $html, $m ) ) {
			$data['rating'] = $m[1];
		}
	}

	// ── Developer ──
	if ( ! $data['developer'] ) {
		if ( preg_match( '#itemprop="author"[^>]*>.*?<span[^>]*>([^<]+)</span>#si', $html, $m ) ) {
			$data['developer'] = html_entity_decode( trim( $m[1] ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		}
	}

	// ── Category ──
	if ( ! $data['category'] ) {
		if ( preg_match( '#itemprop="applicationCategory"[^>]*content="([^"]+)"#i', $html, $m ) ) {
			$data['category'] = html_entity_decode( $m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		}
	}

	// ── Android version ──
	if ( ! $data['android_version'] ) {
		if ( preg_match( '#Requires Android</span>[^<]*<span[^>]*>([0-9.]+\+?[^<]*)</span>#si', $html, $m ) ) {
			$data['android_version'] = trim( html_entity_decode( $m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
		} elseif ( preg_match( '#"Requires Android(?: version)?"\s*,\s*"([0-9.]+[^"]*)"#', $html, $m ) ) {
			$data['android_version'] = trim( $m[1] );
		}
	}

	// Sanitize all text fields
	foreach ( [ 'title', 'developer', 'rating', 'category', 'android_version', 'version', 'size', 'package' ] as $k ) {
		$data[ $k ] = sanitize_text_field( $data[ $k ] );
	}
	$data['description'] = wp_kses_post( $data['description'] );
	$data['icon']        = esc_url_raw( $data['icon'] );
	$data['hero']        = esc_url_raw( $data['hero'] );
	$data['screenshots'] = array_map( 'esc_url_raw', $data['screenshots'] );
	$data['play_store_url'] = esc_url_raw( $data['play_store_url'] );

	return $data;
}

// ── Sideload app icon as featured image ─────────────────────────────────────
function appstorepro_sideload_image( $icon_url, $post_id ) {
	if ( ! $icon_url || ! $post_id ) {
		return;
	}
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$attach_id = media_sideload_image( esc_url_raw( $icon_url ), $post_id, null, 'id' );
	if ( ! is_wp_error( $attach_id ) && $attach_id ) {
		set_post_thumbnail( $post_id, $attach_id );
	}
}
