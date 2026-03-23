<?php
// template-parts/content/content-app.php
$layout      = $args['layout'] ?? 'grid';
$post_id     = get_the_ID();
$icon_url    = appstorepro_get_app_meta( $post_id, '_app_icon_url' );
$rating      = appstorepro_get_app_meta( $post_id, '_app_rating' );
$size        = appstorepro_get_app_meta( $post_id, '_app_size' );
$version     = appstorepro_get_app_meta( $post_id, '_app_version' );
$is_mod      = appstorepro_get_app_meta( $post_id, '_app_is_mod' );
$developer   = appstorepro_get_app_meta( $post_id, '_app_developer' );
$terms       = get_the_terms( $post_id, 'app-category' );
$cat_name    = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
$cat_link    = ( $terms && ! is_wp_error( $terms ) ) ? get_term_link( $terms[0] ) : '';

if ( $layout === 'list' ) : ?>
<article class="app-row pas-reveal" id="post-<?php the_ID(); ?>" <?php post_class( 'app-row' ); ?>>
	<a href="<?= esc_url( get_the_permalink() ); ?>" class="app-row-link" aria-label="<?= esc_attr( get_the_title() ); ?>">
		<div class="app-row-icon">
			<?php if ( $icon_url ) : ?>
				<img src="<?= esc_url( $icon_url ); ?>" alt="<?= esc_attr( get_the_title() ); ?>" loading="lazy" width="56" height="56">
			<?php elseif ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'app-icon', [ 'alt' => get_the_title(), 'loading' => 'lazy' ] ); ?>
			<?php else : ?>
				<div class="app-icon-placeholder"><?= esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></div>
			<?php endif; ?>
		</div>
		<div class="app-row-info">
			<h3 class="app-row-title"><?= esc_html( get_the_title() ); ?></h3>
			<?php if ( $developer ) : ?>
				<div class="app-row-dev"><?= esc_html( $developer ); ?></div>
			<?php endif; ?>
			<div class="app-row-meta">
				<?php if ( $rating ) : ?>
					<span class="app-row-rating"><?= esc_html( $rating ); ?> ★</span>
				<?php endif; ?>
				<?php if ( $size ) : ?>
					<span class="app-row-size"><?= esc_html( $size ); ?></span>
				<?php endif; ?>
				<?php if ( $is_mod ) : ?>
					<span class="badge-mod">MOD</span>
				<?php endif; ?>
			</div>
		</div>
	</a>
</article>
<?php else : ?>
<article class="app-card pas-reveal" id="post-<?php the_ID(); ?>" <?php post_class( 'app-card' ); ?>>
	<a href="<?= esc_url( get_the_permalink() ); ?>" class="app-card-link" aria-label="<?= esc_attr( get_the_title() ); ?>">
		<div class="app-card-icon">
			<?php if ( $icon_url ) : ?>
				<img src="<?= esc_url( $icon_url ); ?>" alt="<?= esc_attr( get_the_title() ); ?>" loading="lazy" width="72" height="72">
			<?php elseif ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'app-icon', [ 'alt' => get_the_title(), 'loading' => 'lazy' ] ); ?>
			<?php else : ?>
				<div class="app-icon-placeholder"><?= esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></div>
			<?php endif; ?>
			<?php if ( $is_mod ) : ?>
				<span class="badge-mod app-card-mod-badge">MOD</span>
			<?php endif; ?>
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
					<span class="app-card-rating">
						<span class="star-val"><?= esc_html( $rating ); ?></span>
						<span class="star-icon">★</span>
					</span>
				<?php endif; ?>
				<?php if ( $size ) : ?>
					<span class="app-card-size"><?= esc_html( $size ); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</a>
</article>
<?php endif; ?>
