<?php
/**
 * Enqueue scripts and styles (Dynamic Google Fonts)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

function alex_store_enqueue_assets() {
    // Dynamic Google Font based on Customizer selection
    $font_family = get_theme_mod('alex_font_family', get_theme_mod('tech_font_family', 'Inter'));
    $font_urls = [
        'Inter'             => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap',
        'Montserrat'       => 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap',
        'Plus Jakarta Sans' => 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
        'Poppins'           => 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap',
        'Outfit'            => 'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap',
    ];

    $google_font_url = isset($font_urls[$font_family]) ? $font_urls[$font_family] : $font_urls['Inter'];

    wp_enqueue_style(
        'alex-store-google-fonts',
        $google_font_url,
        [],
        null
    );

    // Compiled Tailwind CSS
    $css_file = ALEX_STORE_DIR . '/dist/css/main.css';
    $css_ver  = file_exists($css_file) ? filemtime($css_file) : ALEX_STORE_VERSION;
    wp_enqueue_style(
        'alex-store-main-style',
        ALEX_STORE_URI . '/dist/css/main.css',
        [],
        $css_ver
    );

    // Root Theme Style (required by WP)
    wp_enqueue_style('alex-store-root', get_stylesheet_uri(), ['alex-store-main-style'], ALEX_STORE_VERSION);

    // Compiled JavaScript Bundle
    $js_file = ALEX_STORE_DIR . '/dist/js/main.bundle.js';
    $js_ver  = file_exists($js_file) ? filemtime($js_file) : ALEX_STORE_VERSION;
    wp_enqueue_script(
        'alex-store-main',
        ALEX_STORE_URI . '/dist/js/main.bundle.js',
        ['jquery'],
        $js_ver,
        true
    );

    // Localize parameters for AJAX & dynamic cart
    $cart_url     = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart');
    $checkout_url = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout');
    $currency     = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '$';
    $cart_count   = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;

    $params = [
        'ajaxUrl'               => admin_url('admin-ajax.php'),
        'nonce'                 => wp_create_nonce('alex_store_nonce'),
        'cartUrl'               => esc_url($cart_url),
        'checkoutUrl'           => esc_url($checkout_url),
        'currencySymbol'        => esc_html($currency),
        'cartCount'             => absint($cart_count),
        'freeShippingThreshold' => apply_filters('alex_store_free_shipping_threshold', 25000),
    ];

    wp_localize_script('alex-store-main', 'alexStoreData', $params);
    wp_localize_script('alex-store-main', 'techStoreParams', $params); // backward compatibility alias

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'alex_store_enqueue_assets');
