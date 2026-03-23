<?php
// inc/customizer.php — Theme customizer options

function appstorepro_customize_register( $wp_customize ) {

	// Panel: Theme Settings
	$wp_customize->add_panel( 'appstorepro_theme_settings', [
		'title'    => __( 'Theme Settings', 'appstorepro' ),
		'priority' => 130,
	] );

	// Section: Header Settings
	$wp_customize->add_section( 'appstorepro_header', [
		'title' => __( 'Header Settings', 'appstorepro' ),
		'panel' => 'appstorepro_theme_settings',
	] );
	$wp_customize->add_setting( 'appstorepro_logo_url', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
	$wp_customize->add_control( 'appstorepro_logo_url', [
		'label'   => __( 'Logo URL', 'appstorepro' ),
		'section' => 'appstorepro_header',
		'type'    => 'url',
	] );
	$wp_customize->add_setting( 'appstorepro_site_name', [ 'default' => get_bloginfo( 'name' ), 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_site_name', [
		'label'   => __( 'Site Name', 'appstorepro' ),
		'section' => 'appstorepro_header',
		'type'    => 'text',
	] );
	$wp_customize->add_setting( 'appstorepro_tagline', [ 'default' => get_bloginfo( 'description' ), 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_tagline', [
		'label'   => __( 'Tagline', 'appstorepro' ),
		'section' => 'appstorepro_header',
		'type'    => 'text',
	] );

	// Section: Colors
	$wp_customize->add_section( 'appstorepro_colors', [
		'title' => __( 'Colors', 'appstorepro' ),
		'panel' => 'appstorepro_theme_settings',
	] );
	$wp_customize->add_setting( 'appstorepro_primary_color', [
		'default'           => '#FF6A00',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'appstorepro_primary_color', [
		'label'   => __( 'Primary Color', 'appstorepro' ),
		'section' => 'appstorepro_colors',
	] ) );
	$wp_customize->add_setting( 'appstorepro_secondary_color', [
		'default'           => '#3DDC84',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'appstorepro_secondary_color', [
		'label'   => __( 'Secondary/Accent Color', 'appstorepro' ),
		'section' => 'appstorepro_colors',
	] ) );

	// Section: Homepage Settings
	$wp_customize->add_section( 'appstorepro_homepage', [
		'title' => __( 'Homepage Settings', 'appstorepro' ),
		'panel' => 'appstorepro_theme_settings',
	] );
	$wp_customize->add_setting( 'appstorepro_hero_title', [ 'default' => 'Premium mods,', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_hero_title', [
		'label'   => __( 'Hero Title', 'appstorepro' ),
		'section' => 'appstorepro_homepage',
		'type'    => 'text',
	] );
	$wp_customize->add_setting( 'appstorepro_hero_subtitle', [ 'default' => 'Ad-free apps, unlocked games & unlimited resources for Android.', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_hero_subtitle', [
		'label'   => __( 'Hero Subtitle', 'appstorepro' ),
		'section' => 'appstorepro_homepage',
		'type'    => 'textarea',
	] );
	$wp_customize->add_setting( 'appstorepro_hero_badge', [ 'default' => '★ TRUSTED MOD STORE', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_hero_badge', [
		'label'   => __( 'Hero Badge Text', 'appstorepro' ),
		'section' => 'appstorepro_homepage',
		'type'    => 'text',
	] );
	$wp_customize->add_setting( 'appstorepro_show_popular_slider', [ 'default' => '1', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_show_popular_slider', [
		'label'   => __( 'Show Popular Apps Slider', 'appstorepro' ),
		'section' => 'appstorepro_homepage',
		'type'    => 'checkbox',
	] );
	$wp_customize->add_setting( 'appstorepro_popular_slider_count', [ 'default' => '8', 'sanitize_callback' => 'absint' ] );
	$wp_customize->add_control( 'appstorepro_popular_slider_count', [
		'label'   => __( 'Popular Slider: Number of Apps', 'appstorepro' ),
		'section' => 'appstorepro_homepage',
		'type'    => 'number',
	] );

	// Section: CTA Settings
	$wp_customize->add_section( 'appstorepro_cta', [
		'title' => __( 'CTA Settings', 'appstorepro' ),
		'panel' => 'appstorepro_theme_settings',
	] );
	$wp_customize->add_setting( 'appstorepro_telegram_cta_title', [ 'default' => 'Join Our Telegram', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_telegram_cta_title', [
		'label'   => __( 'Telegram CTA Title', 'appstorepro' ),
		'section' => 'appstorepro_cta',
		'type'    => 'text',
	] );
	$wp_customize->add_setting( 'appstorepro_telegram_cta_desc', [ 'default' => 'Get latest MODs, APKs & updates instantly!', 'sanitize_callback' => 'sanitize_textarea_field' ] );
	$wp_customize->add_control( 'appstorepro_telegram_cta_desc', [
		'label'   => __( 'Telegram CTA Description', 'appstorepro' ),
		'section' => 'appstorepro_cta',
		'type'    => 'textarea',
	] );
	$wp_customize->add_setting( 'appstorepro_telegram_cta_btn', [ 'default' => 'Join Now', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_telegram_cta_btn', [
		'label'   => __( 'Telegram CTA Button Text', 'appstorepro' ),
		'section' => 'appstorepro_cta',
		'type'    => 'text',
	] );
	$wp_customize->add_setting( 'appstorepro_telegram_cta_url', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
	$wp_customize->add_control( 'appstorepro_telegram_cta_url', [
		'label'   => __( 'Telegram CTA URL', 'appstorepro' ),
		'section' => 'appstorepro_cta',
		'type'    => 'url',
	] );
	$wp_customize->add_setting( 'appstorepro_telegram_cta_members', [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_telegram_cta_members', [
		'label'   => __( 'Telegram CTA Members Count', 'appstorepro' ),
		'section' => 'appstorepro_cta',
		'type'    => 'text',
	] );

	// Section: Footer Settings
	$wp_customize->add_section( 'appstorepro_footer', [
		'title' => __( 'Footer Settings', 'appstorepro' ),
		'panel' => 'appstorepro_theme_settings',
	] );
	$wp_customize->add_setting( 'appstorepro_footer_text', [ 'default' => '© ' . gmdate( 'Y' ) . ' AppStore Pro. All rights reserved.', 'sanitize_callback' => 'wp_kses_post' ] );
	$wp_customize->add_control( 'appstorepro_footer_text', [
		'label'   => __( 'Footer Text', 'appstorepro' ),
		'section' => 'appstorepro_footer',
		'type'    => 'textarea',
	] );
	$wp_customize->add_setting( 'appstorepro_footer_telegram_url', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
	$wp_customize->add_control( 'appstorepro_footer_telegram_url', [
		'label'   => __( 'Telegram URL', 'appstorepro' ),
		'section' => 'appstorepro_footer',
		'type'    => 'url',
	] );
	$wp_customize->add_setting( 'appstorepro_footer_telegram_members', [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp_customize->add_control( 'appstorepro_footer_telegram_members', [
		'label'   => __( 'Telegram Members Count', 'appstorepro' ),
		'section' => 'appstorepro_footer',
		'type'    => 'text',
	] );

	// Section: Social Links
	$wp_customize->add_section( 'appstorepro_social', [
		'title' => __( 'Social Links', 'appstorepro' ),
		'panel' => 'appstorepro_theme_settings',
	] );
	$wp_customize->add_setting( 'appstorepro_social_telegram', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
	$wp_customize->add_control( 'appstorepro_social_telegram', [
		'label'   => __( 'Telegram URL', 'appstorepro' ),
		'section' => 'appstorepro_social',
		'type'    => 'url',
	] );
	$wp_customize->add_setting( 'appstorepro_social_youtube', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
	$wp_customize->add_control( 'appstorepro_social_youtube', [
		'label'   => __( 'YouTube URL', 'appstorepro' ),
		'section' => 'appstorepro_social',
		'type'    => 'url',
	] );
}
add_action( 'customize_register', 'appstorepro_customize_register' );
