<?php
// inc/template-tags.php — Helper functions

// appstorepro_get_app_meta
function appstorepro_get_app_meta( $post_id, $key ) {
	return get_post_meta( $post_id, $key, true );
}

// appstorepro_get_app_rating_stars
function appstorepro_get_app_rating_stars( $rating ) {
	$rating  = (float) $rating;
	$output  = '';
	$full    = floor( $rating );
	$half    = ( $rating - $full ) >= 0.5 ? 1 : 0;
	$empty   = 5 - $full - $half;
	$output .= str_repeat( '<span class="star star-full">★</span>', $full );
	if ( $half ) {
		$output .= '<span class="star star-half">½</span>';
	}
	$output .= str_repeat( '<span class="star star-empty">☆</span>', max( 0, $empty ) );
	return $output;
}

// appstorepro_allowed_svg_kses
function appstorepro_allowed_svg_kses() {
	return [
		'svg'     => [ 'viewbox' => true, 'viewBox' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'width' => true, 'height' => true, 'xmlns' => true, 'aria-hidden' => true ],
		'path'    => [ 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true ],
		'circle'  => [ 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ],
		'line'    => [ 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true ],
		'polyline'=> [ 'points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true ],
		'polygon' => [ 'points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ],
		'rect'    => [ 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ],
	];
}

// appstorepro_get_category_icon_svg
function appstorepro_get_category_icon_svg( $slug ) {
	$icons = [
		'game'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="13" rx="3"/><path d="M8 11h4m-2-2v4"/><circle cx="17" cy="13" r=".5" fill="currentColor"/><circle cx="15" cy="11" r=".5" fill="currentColor"/></svg>',
		'games'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="13" rx="3"/><path d="M8 11h4m-2-2v4"/><circle cx="17" cy="13" r=".5" fill="currentColor"/><circle cx="15" cy="11" r=".5" fill="currentColor"/></svg>',
		'education' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 1.1 2.7 2 6 2s6-.9 6-2v-5"/></svg>',
		'tools'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>',
		'social'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>',
		'music'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>',
		'video'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>',
		'photo'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>',
		'health'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>',
		'finance'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>',
		'news'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 002-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2v16a2 2 0 01-2 2zm0 0a2 2 0 01-2-2v-9c0-1.1.9-2 2-2h2"/><line x1="16" y1="2" x2="16" y2="6"/><path d="M12 14H8"/><path d="M16 10H8"/></svg>',
		'travel'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>',
		'shopping'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>',
		'sports'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 000 20M2 12h20"/><path d="M12 2C6.5 2 2 6.5 2 12M12 22c5.5 0 10-4.5 10-10"/></svg>',
		'books'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>',
		'app'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
		'apps'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
		'mod'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
		'mods'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
		'utilities' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2M12 20v2M20 12h2M2 12h2M17.66 17.66l1.41 1.41M4.93 19.07l1.41-1.41"/></svg>',
		'productivity' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>',
		'communication' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>',
		'entertainment' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.97C5.12 20 12 20 12 20s6.88 0 8.59-.45a2.78 2.78 0 001.95-1.97A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>',
		'lifestyle'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>',
		'security'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
	];

	return $icons[ $slug ] ?? $icons['app'];
}

// appstorepro_get_color_themes
function appstorepro_get_color_themes() {
	return [
		[ 'name' => 'Green',  'primary' => '#3DDC84', 'light' => '#5DE89A', 'bg' => '#F0FFF6' ],
		[ 'name' => 'Blue',   'primary' => '#4A90E2', 'light' => '#6AA8F0', 'bg' => '#EEF5FD' ],
		[ 'name' => 'Orange', 'primary' => '#FF6A00', 'light' => '#FF8C38', 'bg' => '#FFF4EC' ],
		[ 'name' => 'Purple', 'primary' => '#9B59B6', 'light' => '#B07AC6', 'bg' => '#F7F0FC' ],
		[ 'name' => 'Pink',   'primary' => '#E91E8C', 'light' => '#F04EA3', 'bg' => '#FEF0F7' ],
		[ 'name' => 'Yellow', 'primary' => '#F1C40F', 'light' => '#F5D237', 'bg' => '#FEFBE8' ],
	];
}

// appstorepro_posted_on
function appstorepro_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
	echo '<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>';
}

// appstorepro_posted_by
function appstorepro_posted_by() {
	echo '<span class="byline"><span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span></span>';
}

// appstorepro_format_download_count — format large numbers as 1K, 1M, etc.
function appstorepro_format_download_count( $count ) {
	$count = (int) preg_replace( '/[^0-9]/', '', (string) $count );
	if ( $count >= 1000000000 ) {
		return round( $count / 1000000000, 1 ) . 'B+';
	}
	if ( $count >= 1000000 ) {
		return round( $count / 1000000, 1 ) . 'M+';
	}
	if ( $count >= 1000 ) {
		return round( $count / 1000, 1 ) . 'K+';
	}
	return $count > 0 ? number_format( $count ) . '+' : '';
}

// appstorepro_format_rating — format rating to max 1 decimal
function appstorepro_format_rating( $rating ) {
	if ( ! $rating ) return '';
	return number_format( (float) $rating, 1 );
}
