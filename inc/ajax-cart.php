<?php
/**
 * AJAX Cart Endpoints and Cart Drawer Renderer (Capitalized Titles & Alt)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle AJAX Add to Cart
 */
function alex_store_ajax_add_to_cart() {
    if (!check_ajax_referer('alex_store_nonce', 'nonce', false) && !check_ajax_referer('tech_store_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => __('Sesión expirada', 'alex-store')]);
    }

    if (!class_exists('WooCommerce')) {
        wp_send_json_error(['message' => __('WooCommerce no está activo', 'alex-store')]);
    }

    $product_id   = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $quantity     = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;
    $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;

    if (!$product_id) {
        wp_send_json_error(['message' => __('ID de producto no válido', 'alex-store')]);
    }

    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id)) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        $cart_count  = WC()->cart->get_cart_contents_count();
        $drawer_html = alex_store_get_cart_drawer_items_html();

        wp_send_json_success([
            'cart_count'  => $cart_count,
            'drawer_html' => $drawer_html,
            'message'     => __('Producto añadido al carrito', 'alex-store'),
        ]);
    } else {
        wp_send_json_error(['message' => __('No se pudo añadir el producto al carrito', 'alex-store')]);
    }
}
add_action('wp_ajax_alex_store_add_to_cart', 'alex_store_ajax_add_to_cart');
add_action('wp_ajax_nopriv_alex_store_add_to_cart', 'alex_store_ajax_add_to_cart');
add_action('wp_ajax_tech_store_add_to_cart', 'alex_store_ajax_add_to_cart');
add_action('wp_ajax_nopriv_tech_store_add_to_cart', 'alex_store_ajax_add_to_cart');

/**
 * Handle AJAX Update Cart Item Quantity / Remove
 */
function alex_store_ajax_update_cart_item() {
    if (!check_ajax_referer('alex_store_nonce', 'nonce', false) && !check_ajax_referer('tech_store_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => __('Sesión expirada', 'alex-store')]);
    }

    if (!class_exists('WooCommerce')) {
        wp_send_json_error();
    }

    $cart_key = isset($_POST['cart_key']) ? sanitize_text_field($_POST['cart_key']) : '';
    $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 0;

    if (empty($cart_key)) {
        wp_send_json_error(['message' => __('Clave de carrito inválida', 'alex-store')]);
    }

    if ($quantity > 0) {
        WC()->cart->set_quantity($cart_key, $quantity);
    } else {
        WC()->cart->remove_cart_item($cart_key);
    }

    $cart_count  = WC()->cart->get_cart_contents_count();
    $drawer_html = alex_store_get_cart_drawer_items_html();

    wp_send_json_success([
        'cart_count'  => $cart_count,
        'drawer_html' => $drawer_html,
    ]);
}
add_action('wp_ajax_alex_store_update_cart_item', 'alex_store_ajax_update_cart_item');
add_action('wp_ajax_nopriv_alex_store_update_cart_item', 'alex_store_ajax_update_cart_item');
add_action('wp_ajax_tech_store_update_cart_item', 'alex_store_ajax_update_cart_item');
add_action('wp_ajax_nopriv_tech_store_update_cart_item', 'alex_store_ajax_update_cart_item');

/**
 * Handle AJAX Get Cart Drawer HTML
 */
function alex_store_ajax_get_cart_drawer() {
    if (!check_ajax_referer('alex_store_nonce', 'nonce', false) && !check_ajax_referer('tech_store_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => __('Sesión expirada', 'alex-store')]);
    }

    $cart_count  = (class_exists('WooCommerce') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
    $drawer_html = alex_store_get_cart_drawer_items_html();

    wp_send_json_success([
        'cart_count'  => $cart_count,
        'drawer_html' => $drawer_html,
    ]);
}
add_action('wp_ajax_alex_store_get_cart_drawer', 'alex_store_ajax_get_cart_drawer');
add_action('wp_ajax_nopriv_alex_store_get_cart_drawer', 'alex_store_ajax_get_cart_drawer');
add_action('wp_ajax_tech_store_get_cart_drawer', 'alex_store_ajax_get_cart_drawer');
add_action('wp_ajax_nopriv_tech_store_get_cart_drawer', 'alex_store_ajax_get_cart_drawer');

/**
 * Generate the inner content of the Cart Drawer (Capitalized)
 */
function alex_store_get_cart_drawer_items_html() {
    if (!class_exists('WooCommerce') || !WC()->cart) {
        return '<div class="p-8 text-center text-neutral-500">' . esc_html__('El carrito no está disponible.', 'alex-store') . '</div>';
    }

    $cart_items = WC()->cart->get_cart();
    $subtotal   = WC()->cart->get_cart_subtotal();
    $subtotal_num = (float) WC()->cart->get_subtotal();
    $threshold  = (float) apply_filters('alex_store_free_shipping_threshold', 25000);
    $diff       = $threshold - $subtotal_num;
    $percentage = $threshold > 0 ? min(100, round(($subtotal_num / $threshold) * 100)) : 100;

    ob_start();
    ?>
    <!-- Free Shipping Progress Bar (Neutral) -->
    <div class="bg-neutral-50 p-4 border-b border-neutral-200">
        <?php if ($diff > 0) : ?>
            <p class="text-xs font-medium text-neutral-700 mb-2 flex items-center gap-1.5">
                <?php echo alex_store_svg_icon('truck', 'w-4 h-4 text-primary'); ?>
                <?php printf(esc_html__('Agrega %s más para obtener ENVÍO GRATIS', 'alex-store'), '<span class="font-bold text-neutral-900">' . wc_price($diff) . '</span>'); ?>
            </p>
        <?php else : ?>
            <p class="text-xs font-semibold text-emerald-700 mb-2 flex items-center gap-1.5">
                <?php echo alex_store_svg_icon('check', 'w-4 h-4 text-emerald-600'); ?>
                <?php esc_html_e('¡Tienes ENVÍO GRATIS en tu compra!', 'alex-store'); ?>
            </p>
        <?php endif; ?>
        <div class="w-full bg-neutral-200 rounded-full h-1.5 overflow-hidden">
            <div class="bg-cta h-1.5 rounded-full progress-bar-fill" style="width: <?php echo esc_attr($percentage); ?>%;"></div>
        </div>
    </div>

    <!-- Items List or Empty State -->
    <?php if (empty($cart_items)) : ?>
        <div class="flex-1 flex flex-col items-center justify-center p-8 text-center">
            <div class="w-16 h-16 bg-neutral-100 text-neutral-700 rounded-full flex items-center justify-center mb-4">
                <?php echo alex_store_svg_icon('cart', 'w-8 h-8'); ?>
            </div>
            <h4 class="text-base font-bold text-neutral-900 mb-1"><?php esc_html_e('Tu carrito está vacío', 'alex-store'); ?></h4>
            <p class="text-xs text-neutral-500 mb-6"><?php esc_html_e('Explora nuestro catálogo de tecnología y accesorios.', 'alex-store'); ?></p>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ubx-btn-primary" data-action="close-cart-drawer">
                <?php esc_html_e('Explorar Productos', 'alex-store'); ?>
            </a>
        </div>
    <?php else : ?>
        <div class="flex-1 overflow-y-auto p-4 divide-y divide-neutral-100">
            <?php foreach ($cart_items as $cart_item_key => $cart_item) :
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    $raw_name = $_product->get_name();
                    $product_name = function_exists('alex_store_capitalize_text') ? alex_store_capitalize_text($raw_name) : ucwords(strtolower($raw_name));
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('alex-product-card', ['class' => 'w-16 h-16 object-contain rounded-lg border border-neutral-200 bg-white p-1', 'alt' => esc_attr($product_name)]), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
            ?>
                    <div class="py-3.5 flex gap-3.5 items-start">
                        <div class="flex-shrink-0">
                            <?php if ($product_permalink) : ?>
                                <a href="<?php echo esc_url($product_permalink); ?>"><?php echo $thumbnail; ?></a>
                            <?php else : ?>
                                <?php echo $thumbnail; ?>
                            <?php endif; ?>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-semibold text-neutral-900 hover:text-cta transition-colors line-clamp-2 mb-1 capitalize">
                                <a href="<?php echo esc_url($product_permalink); ?>">
                                    <?php echo esc_html($product_name); ?>
                                </a>
                            </h4>

                            <div class="text-xs font-bold text-neutral-900 mb-2">
                                <?php echo wp_kses_post($product_price); ?>
                            </div>

                            <!-- Quantity Selector + Remove button -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center border border-neutral-200 rounded-lg bg-white">
                                    <button 
                                        type="button" 
                                        class="p-1 text-neutral-400 hover:text-black transition-colors"
                                        data-cart-action="update-qty"
                                        data-cart-key="<?php echo esc_attr($cart_item_key); ?>"
                                        data-current-qty="<?php echo esc_attr($cart_item['quantity']); ?>"
                                        data-qty-change="-1"
                                    >
                                        <?php echo alex_store_svg_icon('minus', 'w-3.5 h-3.5'); ?>
                                    </button>
                                    <span class="px-2 text-xs font-bold text-neutral-900"><?php echo esc_html($cart_item['quantity']); ?></span>
                                    <button 
                                        type="button" 
                                        class="p-1 text-neutral-400 hover:text-black transition-colors"
                                        data-cart-action="update-qty"
                                        data-cart-key="<?php echo esc_attr($cart_item_key); ?>"
                                        data-current-qty="<?php echo esc_attr($cart_item['quantity']); ?>"
                                        data-qty-change="1"
                                    >
                                        <?php echo alex_store_svg_icon('plus', 'w-3.5 h-3.5'); ?>
                                    </button>
                                </div>

                                <button 
                                    type="button" 
                                    class="text-neutral-400 hover:text-rose-600 p-1 text-xs transition-colors"
                                    data-cart-action="remove-item"
                                    data-cart-key="<?php echo esc_attr($cart_item_key); ?>"
                                    title="<?php esc_attr_e('Eliminar', 'alex-store'); ?>"
                                >
                                    <?php echo alex_store_svg_icon('trash', 'w-4 h-4'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>

        <!-- Footer / Checkout Buttons -->
        <div class="p-4 bg-white border-t border-neutral-200 shadow-md">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-neutral-500"><?php esc_html_e('Subtotal:', 'alex-store'); ?></span>
                <span class="alex-cart-subtotal text-lg font-black text-neutral-900"><?php echo wp_kses_post($subtotal); ?></span>
            </div>
            <p class="text-[11px] text-neutral-400 mb-4 text-center">
                <?php esc_html_e('Impuestos y envío calculados al finalizar compra.', 'alex-store'); ?>
            </p>
            <div class="space-y-2">
                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="ubx-btn-primary w-full py-3 text-sm font-bold shadow-cta">
                    <?php esc_html_e('Finalizar Compra', 'alex-store'); ?>
                    <?php echo alex_store_svg_icon('arrow-right', 'w-4 h-4'); ?>
                </a>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="ubx-btn-outline w-full py-2 text-xs font-semibold">
                    <?php esc_html_e('Ver Carrito de Compras', 'alex-store'); ?>
                </a>
            </div>
        </div>
    <?php endif; ?>
    <?php
    return ob_get_clean();
}
function tech_store_get_cart_drawer_items_html() { return alex_store_get_cart_drawer_items_html(); }
