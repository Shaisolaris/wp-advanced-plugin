<?php
defined('ABSPATH') || exit;

class WP_Advanced_Post_Types {
    public static function register(): void {
        register_post_type('portfolio', [
            'labels' => [
                'name' => __('Portfolio', 'wp-advanced'),
                'singular_name' => __('Project', 'wp-advanced'),
                'add_new_item' => __('Add New Project', 'wp-advanced'),
                'edit_item' => __('Edit Project', 'wp-advanced'),
                'search_items' => __('Search Projects', 'wp-advanced'),
            ],
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions'],
            'menu_icon' => 'dashicons-portfolio',
            'rewrite' => ['slug' => 'portfolio'],
        ]);

        register_post_type('testimonial', [
            'labels' => [
                'name' => __('Testimonials', 'wp-advanced'),
                'singular_name' => __('Testimonial', 'wp-advanced'),
            ],
            'public' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
            'menu_icon' => 'dashicons-format-quote',
        ]);

        register_post_type('service', [
            'labels' => [
                'name' => __('Services', 'wp-advanced'),
                'singular_name' => __('Service', 'wp-advanced'),
            ],
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
            'menu_icon' => 'dashicons-admin-tools',
        ]);
    }
}
