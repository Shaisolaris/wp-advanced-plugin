<?php
defined('ABSPATH') || exit;

class WP_Advanced_REST_Controller {
    private string $namespace = 'wp-advanced/v1';

    public function register_routes(): void {
        register_rest_route($this->namespace, '/portfolio', [
            ['methods' => 'GET', 'callback' => [$this, 'get_portfolio'], 'permission_callback' => '__return_true'],
        ]);
        register_rest_route($this->namespace, '/portfolio/(?P<id>\d+)', [
            ['methods' => 'GET', 'callback' => [$this, 'get_portfolio_item'], 'permission_callback' => '__return_true'],
        ]);
        register_rest_route($this->namespace, '/testimonials', [
            ['methods' => 'GET', 'callback' => [$this, 'get_testimonials'], 'permission_callback' => '__return_true'],
        ]);
        register_rest_route($this->namespace, '/services', [
            ['methods' => 'GET', 'callback' => [$this, 'get_services'], 'permission_callback' => '__return_true'],
        ]);
        register_rest_route($this->namespace, '/stats', [
            ['methods' => 'GET', 'callback' => [$this, 'get_stats'], 'permission_callback' => [$this, 'check_admin']],
        ]);
    }

    public function get_portfolio(\WP_REST_Request $request): \WP_REST_Response {
        $args = ['post_type' => 'portfolio', 'posts_per_page' => $request->get_param('per_page') ?? 10, 'paged' => $request->get_param('page') ?? 1, 'orderby' => 'date', 'order' => 'DESC'];
        if ($type = $request->get_param('type')) $args['tax_query'] = [['taxonomy' => 'project_type', 'field' => 'slug', 'terms' => $type]];
        $query = new \WP_Query($args);
        $items = array_map(fn($post) => $this->format_portfolio($post), $query->posts);
        return new \WP_REST_Response(['items' => $items, 'total' => $query->found_posts, 'pages' => $query->max_num_pages], 200);
    }

    public function get_portfolio_item(\WP_REST_Request $request): \WP_REST_Response {
        $post = get_post((int) $request['id']);
        if (!$post || $post->post_type !== 'portfolio') return new \WP_REST_Response(['error' => 'Not found'], 404);
        return new \WP_REST_Response($this->format_portfolio($post), 200);
    }

    public function get_testimonials(): \WP_REST_Response {
        $posts = get_posts(['post_type' => 'testimonial', 'posts_per_page' => 20]);
        $items = array_map(fn($p) => ['id' => $p->ID, 'content' => $p->post_content, 'name' => get_post_meta($p->ID, '_testimonial_name', true), 'role' => get_post_meta($p->ID, '_testimonial_role', true), 'rating' => (int) get_post_meta($p->ID, '_testimonial_rating', true), 'image' => get_the_post_thumbnail_url($p->ID, 'thumbnail')], $posts);
        return new \WP_REST_Response($items, 200);
    }

    public function get_services(): \WP_REST_Response {
        $posts = get_posts(['post_type' => 'service', 'posts_per_page' => 20, 'orderby' => 'menu_order', 'order' => 'ASC']);
        $items = array_map(fn($p) => ['id' => $p->ID, 'title' => $p->post_title, 'content' => $p->post_content, 'excerpt' => $p->post_excerpt, 'image' => get_the_post_thumbnail_url($p->ID, 'medium')], $posts);
        return new \WP_REST_Response($items, 200);
    }

    public function get_stats(): \WP_REST_Response {
        return new \WP_REST_Response(['portfolio' => wp_count_posts('portfolio')->publish, 'testimonials' => wp_count_posts('testimonial')->publish, 'services' => wp_count_posts('service')->publish], 200);
    }

    public function check_admin(): bool { return current_user_can('manage_options'); }

    private function format_portfolio(\WP_Post $post): array {
        return ['id' => $post->ID, 'title' => $post->post_title, 'content' => $post->post_content, 'excerpt' => $post->post_excerpt, 'slug' => $post->post_name, 'client' => get_post_meta($post->ID, '_portfolio_client', true), 'url' => get_post_meta($post->ID, '_portfolio_url', true), 'date' => get_post_meta($post->ID, '_portfolio_date', true), 'image' => get_the_post_thumbnail_url($post->ID, 'large'), 'types' => wp_get_post_terms($post->ID, 'project_type', ['fields' => 'names']), 'skills' => wp_get_post_terms($post->ID, 'skill', ['fields' => 'names'])];
    }
}
