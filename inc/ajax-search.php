<?php
/**
 * AJAX Live Predictive Search Handler (Capitalize Edition)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle AJAX Live Search
 */
function alex_store_ajax_search() {
    if (!check_ajax_referer('alex_store_nonce', 'nonce', false) && !check_ajax_referer('alex_store_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => __('Sesión expirada', 'alex-store')]);
    }

    $query = isset($_POST['query']) ? sanitize_text_field(wp_unslash($_POST['query'])) : '';

    if (empty($query) || strlen($query) < 2) {
        wp_send_json_success(['products' => []]);
    }

    $args = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        's'              => $query,
        'posts_per_page' => 6,
        'orderby'        => 'relevance',
        'order'          => 'DESC',
    ];

    $search_query = new WP_Query($args);
    $results      = [];

    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            global $product;

            if (!$product) {
                $product = wc_get_product(get_the_ID());
            }
            if (!$product) continue;

            $image_id  = $product->get_image_id();
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : wc_placeholder_img_src('woocommerce_thumbnail');
            $raw_title = $product->get_name();
            $title     = function_exists('alex_store_capitalize_text') ? alex_store_capitalize_text($raw_title) : ucwords(strtolower($raw_title));

            $results[] = [
                'id'        => $product->get_id(),
                'title'     => $title,
                'permalink' => $product->get_permalink(),
                'price'     => $product->get_price_html(),
                'image'     => $image_url,
                'category'  => wp_strip_all_tags(wc_get_product_category_list($product->get_id(), ', ')),
                'in_stock'  => $product->is_in_stock(),
            ];
        }
        wp_reset_postdata();
    }

    wp_send_json_success(['products' => $results]);
}
add_action('wp_ajax_alex_store_ajax_search', 'alex_store_ajax_search');
add_action('wp_ajax_nopriv_alex_store_ajax_search', 'alex_store_ajax_search');
add_action('wp_ajax_tech_store_ajax_search', 'alex_store_ajax_search');
add_action('wp_ajax_nopriv_tech_store_ajax_search', 'alex_store_ajax_search');

if (!function_exists('tech_store_ajax_search')) {
    function tech_store_ajax_search() { alex_store_ajax_search(); }
}
