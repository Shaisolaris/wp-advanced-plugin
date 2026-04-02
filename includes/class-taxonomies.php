<?php
defined('ABSPATH') || exit;

class WP_Advanced_Taxonomies {
    public static function register(): void {
        register_taxonomy('project_type', 'portfolio', [
            'labels' => ['name' => __('Project Types', 'wp-advanced'), 'singular_name' => __('Project Type', 'wp-advanced')],
            'public' => true, 'hierarchical' => true, 'show_in_rest' => true, 'rewrite' => ['slug' => 'project-type'],
        ]);

        register_taxonomy('skill', 'portfolio', [
            'labels' => ['name' => __('Skills', 'wp-advanced'), 'singular_name' => __('Skill', 'wp-advanced')],
            'public' => true, 'hierarchical' => false, 'show_in_rest' => true, 'rewrite' => ['slug' => 'skill'],
        ]);

        register_taxonomy('service_category', 'service', [
            'labels' => ['name' => __('Service Categories', 'wp-advanced'), 'singular_name' => __('Category', 'wp-advanced')],
            'public' => true, 'hierarchical' => true, 'show_in_rest' => true,
        ]);
    }
}
