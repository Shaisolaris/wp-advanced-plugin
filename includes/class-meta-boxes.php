<?php
defined('ABSPATH') || exit;

class WP_Advanced_Meta_Boxes {
    public static function register(): void {
        add_action('add_meta_boxes', [__CLASS__, 'add_meta_boxes']);
        add_action('save_post', [__CLASS__, 'save_meta']);
    }

    public static function add_meta_boxes(): void {
        add_meta_box('portfolio_details', __('Project Details', 'wp-advanced'), [__CLASS__, 'render_portfolio_meta'], 'portfolio', 'normal', 'high');
        add_meta_box('testimonial_details', __('Testimonial Details', 'wp-advanced'), [__CLASS__, 'render_testimonial_meta'], 'testimonial', 'side', 'default');
    }

    public static function render_portfolio_meta(\WP_Post $post): void {
        wp_nonce_field('wp_advanced_meta', 'wp_advanced_nonce');
        $client = get_post_meta($post->ID, '_portfolio_client', true);
        $url = get_post_meta($post->ID, '_portfolio_url', true);
        $date = get_post_meta($post->ID, '_portfolio_date', true);
        echo '<p><label>Client: <input type="text" name="portfolio_client" value="' . esc_attr($client) . '" class="widefat"></label></p>';
        echo '<p><label>Project URL: <input type="url" name="portfolio_url" value="' . esc_attr($url) . '" class="widefat"></label></p>';
        echo '<p><label>Completion Date: <input type="date" name="portfolio_date" value="' . esc_attr($date) . '"></label></p>';
    }

    public static function render_testimonial_meta(\WP_Post $post): void {
        wp_nonce_field('wp_advanced_meta', 'wp_advanced_nonce');
        $name = get_post_meta($post->ID, '_testimonial_name', true);
        $role = get_post_meta($post->ID, '_testimonial_role', true);
        $rating = get_post_meta($post->ID, '_testimonial_rating', true);
        echo '<p><label>Name: <input type="text" name="testimonial_name" value="' . esc_attr($name) . '" class="widefat"></label></p>';
        echo '<p><label>Role: <input type="text" name="testimonial_role" value="' . esc_attr($role) . '" class="widefat"></label></p>';
        echo '<p><label>Rating: <select name="testimonial_rating">';
        for ($i = 1; $i <= 5; $i++) echo '<option value="' . $i . '"' . selected($rating, $i, false) . '>' . $i . ' Star' . ($i > 1 ? 's' : '') . '</option>';
        echo '</select></label></p>';
    }

    public static function save_meta(int $post_id): void {
        if (!isset($_POST['wp_advanced_nonce']) || !wp_verify_nonce($_POST['wp_advanced_nonce'], 'wp_advanced_meta')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        $fields = ['portfolio_client', 'portfolio_url', 'portfolio_date', 'testimonial_name', 'testimonial_role', 'testimonial_rating'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
