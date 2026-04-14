<?php
// template-parts/global/site-header.php
?>
<header class="site-header" id="site-header">
	<div class="header-inner">
		<a href="<?= esc_url( home_url( '/' ) ); ?>" class="site-logo" rel="home">
			<?php $logo = get_theme_mod( 'custom_logo' ); ?>
			<?php if ( $logo ) : ?>
				<img src="<?= esc_url( wp_get_attachment_image_url( $logo, 'full' ) ); ?>" class="logo-android-img" width="36" height="36" alt="<?= esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php else : ?>
				<img src="<?= esc_url( get_template_directory_uri() ); ?>/assets/images/android-icon.svg" class="logo-android-img" width="36" height="36" alt="<?= esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php endif; ?>
			<span class="logo-text"><?= esc_html( get_bloginfo( 'name' ) ); ?></span>
		</a>

		<div class="header-actions">
			<div class="theme-color-picker" role="group" aria-label="<?php esc_attr_e( 'Choose theme colour', 'appstorepro' ); ?>">
				<?php foreach ( appstorepro_get_color_themes() as $theme ) : ?>
					<button class="theme-dot<?= ( $theme['name'] === 'Orange' ) ? ' active' : ''; ?>"
						data-primary="<?= esc_attr( $theme['primary'] ); ?>"
						data-light="<?= esc_attr( $theme['light'] ); ?>"
						data-bg="<?= esc_attr( $theme['bg'] ); ?>"
						style="background:<?= esc_attr( $theme['primary'] ); ?>;"
						title="<?= esc_attr( $theme['name'] ); ?>"
						aria-label="<?= esc_attr( $theme['name'] ); ?> theme"></button>
				<?php endforeach; ?>
			</div>

			<button class="dark-mode-toggle" id="dark-mode-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'appstorepro' ); ?>">
				<div class="dm-knob">
					<svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="4"/><line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/>
						<line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
						<line x1="2" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="22" y2="12"/>
						<line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
					</svg>
					<svg class="icon-moon" viewBox="0 0 24 24" fill="currentColor" stroke="none">
						<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
					</svg>
				</div>
			</button>

			<button class="btn-icon" id="particle-toggle" aria-label="<?php esc_attr_e( 'Toggle particles', 'appstorepro' ); ?>">
				<svg id="particle-icon-on" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/>
					<circle cx="5" cy="5" r="1.5" fill="currentColor" stroke="none" opacity="0.6"/>
					<circle cx="19" cy="5" r="1" fill="currentColor" stroke="none" opacity="0.4"/>
					<circle cx="5" cy="19" r="1" fill="currentColor" stroke="none" opacity="0.4"/>
					<circle cx="19" cy="19" r="1.5" fill="currentColor" stroke="none" opacity="0.6"/>
					<circle cx="12" cy="4" r="1" fill="currentColor" stroke="none" opacity="0.5"/>
					<circle cx="20" cy="12" r="1" fill="currentColor" stroke="none" opacity="0.5"/>
				</svg>
				<svg id="particle-icon-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none">
					<circle cx="12" cy="12" r="2" fill="currentColor" stroke="none" opacity="0.3"/>
					<line x1="4" y1="4" x2="20" y2="20" stroke-width="2"/>
				</svg>
			</button>

			<button class="btn-icon" id="search-toggle" aria-label="<?php esc_attr_e( 'Search', 'appstorepro' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
					<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
				</svg>
			</button>
		</div>
	</div>

	<div class="header-search-dropdown" id="header-search" style="display:none;">
		<form role="search" method="get" action="<?= esc_url( home_url( '/' ) ); ?>">
			<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search apps & games...', 'appstorepro' ); ?>" value="<?= esc_attr( get_search_query() ); ?>" autocomplete="off" autofocus>
			<button type="submit">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
					<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
				</svg>
			</button>
		</form>
	</div>
</header>
<canvas id="pas-particles" aria-hidden="true"></canvas>
