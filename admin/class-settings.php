<?php
defined('ABSPATH') || exit;

class WP_Advanced_Settings {
    public static function register(): void {
        add_menu_page(__('WP Advanced', 'wp-advanced'), __('WP Advanced', 'wp-advanced'), 'manage_options', 'wp-advanced', [__CLASS__, 'render_page'], 'dashicons-admin-generic', 80);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function register_settings(): void {
        register_setting('wp_advanced_settings', 'wp_advanced_portfolio_per_page', ['type' => 'integer', 'default' => 12, 'sanitize_callback' => 'absint']);
        register_setting('wp_advanced_settings', 'wp_advanced_show_testimonials', ['type' => 'boolean', 'default' => true]);
        register_setting('wp_advanced_settings', 'wp_advanced_accent_color', ['type' => 'string', 'default' => '#0073aa', 'sanitize_callback' => 'sanitize_hex_color']);
        add_settings_section('wp_advanced_general', __('General Settings', 'wp-advanced'), null, 'wp-advanced');
        add_settings_field('portfolio_per_page', __('Portfolio items per page', 'wp-advanced'), [__CLASS__, 'render_number_field'], 'wp-advanced', 'wp_advanced_general', ['option' => 'wp_advanced_portfolio_per_page']);
        add_settings_field('show_testimonials', __('Show testimonials', 'wp-advanced'), [__CLASS__, 'render_checkbox'], 'wp-advanced', 'wp_advanced_general', ['option' => 'wp_advanced_show_testimonials']);
    }

    public static function render_page(): void {
        echo '<div class="wrap"><h1>' . esc_html(get_admin_page_title()) . '</h1><form method="post" action="options.php">';
        settings_fields('wp_advanced_settings');
        do_settings_sections('wp-advanced');
        submit_button();
        echo '</form></div>';
    }

    public static function render_number_field(array $args): void {
        $value = get_option($args['option'], 12);
        echo '<input type="number" name="' . esc_attr($args['option']) . '" value="' . esc_attr($value) . '" min="1" max="100">';
    }

    public static function render_checkbox(array $args): void {
        $value = get_option($args['option'], true);
        echo '<input type="checkbox" name="' . esc_attr($args['option']) . '" value="1"' . checked($value, true, false) . '>';
    }
}
