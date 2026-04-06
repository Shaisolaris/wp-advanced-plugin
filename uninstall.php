<?php
/**
 * Fired when the plugin is uninstalled.
 * Cleans up all plugin data from the database.
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Remove plugin options
delete_option('wp_advanced_portfolio_per_page');
delete_option('wp_advanced_show_testimonials');
delete_option('wp_advanced_accent_color');

// Remove custom post type data (optional — uncomment to enable)
// $post_types = ['portfolio', 'testimonial', 'service'];
// foreach ($post_types as $type) {
//     $posts = get_posts(['post_type' => $type, 'numberposts' => -1, 'post_status' => 'any']);
//     foreach ($posts as $post) {
//         wp_delete_post($post->ID, true);
//     }
// }

// Clear any cached data
wp_cache_flush();
