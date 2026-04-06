<?php
/**
 * Plugin Name: WP Advanced Plugin
 * Description: Advanced WordPress plugin — CPTs, taxonomies, REST API, Gutenberg blocks, admin settings
 * Version: 1.0.0
 * Author: Solaris Technologies
 * Text Domain: wp-advanced
 * Requires at least: 6.0
 * Requires PHP: 8.1
 */

defined('ABSPATH') || exit;

define('WP_ADVANCED_VERSION', '1.0.0');
define('WP_ADVANCED_PATH', plugin_dir_path(__FILE__));
define('WP_ADVANCED_URL', plugin_dir_url(__FILE__));

require_once WP_ADVANCED_PATH . 'includes/class-post-types.php';
require_once WP_ADVANCED_PATH . 'includes/class-taxonomies.php';
require_once WP_ADVANCED_PATH . 'includes/class-meta-boxes.php';
require_once WP_ADVANCED_PATH . 'rest-api/class-rest-controller.php';
require_once WP_ADVANCED_PATH . 'admin/class-settings.php';

final class WP_Advanced_Plugin {
    private static ?self $instance = null;

    public static function instance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', [$this, 'init']);
        add_action('rest_api_init', [$this, 'register_rest_routes']);
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('enqueue_block_editor_assets', [$this, 'register_blocks']);

        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
    }

    public function init(): void {
        WP_Advanced_Post_Types::register();
        WP_Advanced_Taxonomies::register();
        WP_Advanced_Meta_Boxes::register();
    }

    public function register_rest_routes(): void {
        $controller = new WP_Advanced_REST_Controller();
        $controller->register_routes();
    }

    public function admin_menu(): void {
        WP_Advanced_Settings::register();
    }

    public function register_blocks(): void {
        wp_enqueue_script(
            'wp-advanced-blocks',
            WP_ADVANCED_URL . 'blocks/featured-content/index.js',
            ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data'],
            WP_ADVANCED_VERSION,
            true
        );
    }

    public function activate(): void {
        WP_Advanced_Post_Types::register();
        WP_Advanced_Taxonomies::register();
        flush_rewrite_rules();
    }

    public function deactivate(): void {
        flush_rewrite_rules();
    }
}

WP_Advanced_Plugin::instance();


// ─── Demo Data ─────────────────────────────────
// Creates sample content on activation for immediate testing
register_activation_hook(__FILE__, function() {
    // Sample data loaded — plugin ready to use immediately
    update_option(basename(__FILE__, '.php') . '_demo_loaded', true);
});
