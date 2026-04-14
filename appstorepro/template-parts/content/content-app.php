<?php
// template-parts/content/content-app.php
$layout         = $args['layout'] ?? 'grid';
$post_id        = get_the_ID();
$icon_url       = appstorepro_get_app_meta( $post_id, '_app_icon_url' );
$hero_img       = appstorepro_get_app_meta( $post_id, '_app_hero_image_url' );
$screenshots_raw = appstorepro_get_app_meta( $post_id, '_app_screenshots' );
$screenshots    = $screenshots_raw ? array_filter( array_map( 'trim', explode( "\n", $screenshots_raw ) ) ) : [];
$rating         = appstorepro_format_rating( appstorepro_get_app_meta( $post_id, '_app_rating' ) );
$size           = appstorepro_get_app_meta( $post_id, '_app_size' );
$version        = appstorepro_get_app_meta( $post_id, '_app_version' );
$is_mod         = appstorepro_get_app_meta( $post_id, '_app_is_mod' );
$developer      = appstorepro_get_app_meta( $post_id, '_app_developer' );
$download_count = appstorepro_format_download_count( appstorepro_get_app_meta( $post_id, '_app_download_count' ) );
$terms          = get_the_terms( $post_id, 'app-category' );
$cat_name       = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
$cat_link       = ( $terms && ! is_wp_error( $terms ) ) ? get_term_link( $terms[0] ) : '';
$is_sticky      = is_sticky( $post_id );
$card_img       = $hero_img ?: ( $screenshots ? $screenshots[0] : '' );
$icon_src       = $icon_url ?: ( has_post_thumbnail() ? get_the_post_thumbnail_url( $post_id, 'app-icon' ) : '' );

if ( $layout === 'list' ) : ?>
<article class="app-row pas-reveal<?= $is_sticky ? ' app-row--sticky' : ''; ?>" id="post-<?php the_ID(); ?>" <?php post_class( 'app-row' ); ?>>
	<a href="<?= esc_url( get_the_permalink() ); ?>" class="app-row-link" aria-label="<?= esc_attr( get_the_title() ); ?>">
		<div class="app-row-icon">
			<?php if ( $icon_src ) : ?>
				<img src="<?= esc_url( $icon_src ); ?>" alt="<?= esc_attr( get_the_title() ); ?>" loading="lazy" width="56" height="56">
			<?php else : ?>
				<div class="app-icon-placeholder"><?= esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></div>
			<?php endif; ?>
			<?php if ( $is_mod ) : ?><span class="badge-mod app-row-mod">MOD</span><?php endif; ?>
			<?php if ( $is_sticky ) : ?><span class="badge-hot">HOT</span><?php endif; ?>
		</div>
		<div class="app-row-info">
			<h3 class="app-row-title"><?= esc_html( get_the_title() ); ?></h3>
			<?php if ( $developer ) : ?><div class="app-row-dev"><?= esc_html( $developer ); ?></div><?php endif; ?>
			<div class="app-row-meta">
				<?php if ( $rating ) : ?>
					<span class="app-row-rating"><span class="star-val"><?= esc_html( $rating ); ?></span> ★</span>
				<?php endif; ?>
				<?php if ( $download_count ) : ?>
					<span class="app-row-dl"><i class='bx bx-download'></i> <?= esc_html( $download_count ); ?></span>
				<?php endif; ?>
				<?php if ( $size ) : ?><span class="app-row-size"><?= esc_html( $size ); ?></span><?php endif; ?>
				<?php if ( $is_mod ) : ?><span class="badge-mod">MOD</span><?php endif; ?>
			</div>
		</div>
		<div class="app-row-arrow"><i class='bx bx-chevron-right'></i></div>
	</a>
</article>
<?php elseif ( $layout === 'wide' ) : ?>
<article class="app-card-wide pas-reveal<?= $is_sticky ? ' app-card-wide--sticky' : ''; ?>" id="post-<?php the_ID(); ?>" <?php post_class( 'app-card-wide' ); ?>>
	<a href="<?= esc_url( get_the_permalink() ); ?>" class="app-card-wide-link">
		<div class="app-card-wide-img">
			<?php if ( $card_img ) : ?>
				<img src="<?= esc_url( $card_img ); ?>" alt="<?= esc_attr( get_the_title() ); ?>" loading="lazy">
			<?php else : ?>
				<div class="app-card-wide-placeholder">
					<?php if ( $icon_src ) : ?>
						<img src="<?= esc_url( $icon_src ); ?>" alt="<?= esc_attr( get_the_title() ); ?>" loading="lazy" width="72" height="72" class="app-card-wide-icon-fallback">
					<?php else : ?>
						<div class="app-icon-placeholder app-icon-xl"><?= esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if ( $is_sticky ) : ?><span class="badge-hot badge-hot--card">HOT</span><?php endif; ?>
			<?php if ( $is_mod ) : ?><span class="badge-mod badge-mod--card">MOD</span><?php endif; ?>
		</div>
		<div class="app-card-wide-body">
			<div class="app-card-wide-icon">
				<?php if ( $icon_src ) : ?>
					<img src="<?= esc_url( $icon_src ); ?>" alt="<?= esc_attr( get_the_title() ); ?>" loading="lazy" width="52" height="52">
				<?php endif; ?>
			</div>
			<div class="app-card-wide-info">
				<h3 class="app-card-wide-title"><?= esc_html( get_the_title() ); ?></h3>
				<?php if ( $developer ) : ?><div class="app-card-wide-dev"><?= esc_html( $developer ); ?></div><?php endif; ?>
				<div class="app-card-wide-meta">
					<?php if ( $rating ) : ?>
						<span class="app-rating-chip"><i class='bx bxs-star'></i> <?= esc_html( $rating ); ?></span>
					<?php endif; ?>
					<?php if ( $download_count ) : ?>
						<span class="app-dl-chip"><i class='bx bx-download'></i> <?= esc_html( $download_count ); ?></span>
					<?php endif; ?>
					<?php if ( $size ) : ?><span class="app-size-chip"><?= esc_html( $size ); ?></span><?php endif; ?>
					<?php if ( $cat_name ) : ?><span class="app-cat-chip"><?= esc_html( $cat_name ); ?></span><?php endif; ?>
				</div>
			</div>
		</div>
	</a>
</article>
<?php else : ?>
<article class="app-card pas-reveal<?= $is_sticky ? ' app-card--sticky' : ''; ?>" id="post-<?php the_ID(); ?>" <?php post_class( 'app-card' ); ?>>
	<a href="<?= esc_url( get_the_permalink() ); ?>" class="app-card-link" aria-label="<?= esc_attr( get_the_title() ); ?>">
		<div class="app-card-icon">
			<?php if ( $icon_src ) : ?>
				<img src="<?= esc_url( $icon_src ); ?>" alt="<?= esc_attr( get_the_title() ); ?>" loading="lazy" width="72" height="72">
			<?php elseif ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'app-icon', [ 'alt' => get_the_title(), 'loading' => 'lazy' ] ); ?>
			<?php else : ?>
				<div class="app-icon-placeholder"><?= esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></div>
			<?php endif; ?>
			<?php if ( $is_sticky ) : ?><span class="badge-hot">HOT</span><?php endif; ?>
			<?php if ( $is_mod ) : ?><span class="badge-mod app-card-mod-badge">MOD</span><?php endif; ?>
		</div>
		<div class="app-card-info">
			<h3 class="app-card-title"><?= esc_html( get_the_title() ); ?></h3>
			<?php if ( $cat_name && $cat_link ) : ?>
				<div class="app-card-cat"><?= esc_html( $cat_name ); ?></div>
			<?php elseif ( $developer ) : ?>
				<div class="app-card-cat"><?= esc_html( $developer ); ?></div>
			<?php endif; ?>
			<div class="app-card-meta">
				<?php if ( $rating ) : ?>
					<span class="app-card-rating"><span class="star-val"><?= esc_html( $rating ); ?></span><span class="star-icon">★</span></span>
				<?php endif; ?>
				<?php if ( $download_count ) : ?>
					<span class="app-card-dl"><?= esc_html( $download_count ); ?></span>
				<?php elseif ( $size ) : ?>
					<span class="app-card-size"><?= esc_html( $size ); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</a>
</article>
<?php endif; ?>
