<?php
/**
 * Theme Setup and Supports
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('alex_store_theme_setup')) {
    /**
     * Sets up theme defaults and registers support for various WordPress and WooCommerce features.
     */
    function alex_store_theme_setup() {
        // Make theme available for translation.
        load_theme_textdomain('alex-store', ALEX_STORE_DIR . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title.
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(800, 800, true);
        add_image_size('alex-product-card', 500, 500, true);
        add_image_size('alex-hero-banner', 1400, 600, true);
        add_image_size('tech-product-card', 500, 500, true);
        add_image_size('tech-hero-banner', 1400, 600, true);

        // Register Navigation Menus
        register_nav_menus([
            'primary-menu'    => __('Menú Principal', 'alex-store'),
            'categories-menu' => __('Barra de Categorías', 'alex-store'),
            'footer-menu'     => __('Enlaces del Footer', 'alex-store'),
            'mobile-menu'     => __('Menú Móvil', 'alex-store'),
        ]);

        // Switch default core markup to output valid HTML5.
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]);

        // Set up the WordPress core custom logo feature.
        add_theme_support('custom-logo', [
            'height'      => 80,
            'width'       => 240,
            'flex-width'  => true,
            'flex-height' => true,
        ]);

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Support full and wide align images.
        add_theme_support('align-wide');

        // Responsive embeds.
        add_theme_support('responsive-embeds');

        // WooCommerce Supports
        add_theme_support('woocommerce', [
            'thumbnail_image_width' => 450,
            'single_image_width'    => 800,
            'product_grid'          => [
                'default_rows'    => 4,
                'min_rows'        => 2,
                'max_rows'        => 8,
                'default_columns' => 4,
                'min_columns'     => 2,
                'max_columns'     => 5,
            ],
        ]);
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
}
add_action('after_setup_theme', 'alex_store_theme_setup');

/**
 * Register Widget Areas
 */
function alex_store_widgets_init() {
    register_sidebar([
        'name'          => __('Barra Lateral de Tienda (Filtros)', 'alex-store'),
        'id'            => 'shop-sidebar',
        'description'   => __('Añade widgets de filtros para el catálogo de productos.', 'alex-store'),
        'before_widget' => '<div id="%1$s" class="widget %2$s bg-white p-5 rounded-card border border-neutral-border mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title text-base font-bold text-dark mb-4 pb-2 border-b border-neutral-border">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'alex_store_widgets_init');
