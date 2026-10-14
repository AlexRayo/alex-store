<?php
/**
 * WooCommerce Customizations & Hooks
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WooCommerce')) {
    return;
}

/**
 * Remove default WooCommerce wrapper markup and add Tailwind-friendly container
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'alex_store_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'alex_store_wrapper_end', 10);

function alex_store_wrapper_start() {
    echo '<main id="main" class="site-main site-container py-8">';
}

function alex_store_wrapper_end() {
    echo '</main>';
}

/**
 * Custom Cart Fragments for Header & Drawer count synchronization
 */
function alex_store_cart_fragments($fragments) {
    $count = WC()->cart->get_cart_contents_count();
    $subtotal = WC()->cart->get_cart_subtotal();

    $badge_class = $count > 0 ? '' : 'hidden';

    // Header count badge
    $badge_html = '<span class="alex-cart-count-badge ' . esc_attr($badge_class) . ' absolute -top-1 -right-1 bg-accent text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">' . absint($count) . '</span>';
    $fragments['span.alex-cart-count-badge'] = $badge_html;
    $fragments['span.tech-cart-count-badge'] = $badge_html;

    // Cart drawer subtotal
    $subtotal_html = '<span class="alex-cart-subtotal font-black text-lg text-dark">' . wp_kses_post($subtotal) . '</span>';
    $fragments['span.alex-cart-subtotal'] = $subtotal_html;
    $fragments['span.tech-cart-subtotal'] = $subtotal_html;

    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'alex_store_cart_fragments');

/**
 * Customize WooCommerce Breadcrumb separator & styling
 */
function alex_store_woocommerce_breadcrumbs() {
    return [
        'delimiter'   => ' <span class="text-neutral-subtle mx-1.5">/</span> ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb text-xs font-medium text-neutral-subtle mb-6 flex items-center flex-wrap" aria-label="' . esc_attr__('Migas de pan', 'alex-store') . '">',
        'wrap_after'  => '</nav>',
        'before'      => '<span class="text-dark font-semibold">',
        'after'       => '</span>',
        'home'        => _x('Inicio', 'breadcrumb', 'alex-store'),
    ];
}
add_filter('woocommerce_breadcrumb_defaults', 'alex_store_woocommerce_breadcrumbs');

/**
 * Adjust number of related products
 */
function alex_store_related_products_args($args) {
    $args['posts_per_page'] = 4;
    $args['columns']        = 4;
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'alex_store_related_products_args');

/**
 * Disable default WooCommerce CSS if we want 100% Tailwind control, or allow minimal core
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Ensure WooCommerce checkout privacy policy text is in Spanish
 */
function alex_store_privacy_policy_text_spanish($text, $type) {
    if ($type === 'checkout') {
        if (empty($text) || strpos($text, 'Your personal data') !== false) {
            return __('Tus datos personales se utilizarán para procesar tu pedido, mejorar tu experiencia en este sitio web y para otros fines descritos en nuestra [privacy_policy].', 'alex-store');
        }
    }
    return $text;
}
add_filter('woocommerce_get_privacy_policy_text', 'alex_store_privacy_policy_text_spanish', 20, 2);
