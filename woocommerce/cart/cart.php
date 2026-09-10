<?php
/**
 * Cart Page Template (Amazon.com Inspired Layout - Capitalized Titles & Alt)
 *
 * @package TechStore
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');

$cart_count = WC()->cart->get_cart_contents_count();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 sm:py-4">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
        
        <!-- LEFT COLUMN: Product Items List (8 cols / ~67%) -->
        <div class="lg:col-span-8 space-y-6">
            
            <div class="bg-white rounded-3xl border border-neutral-200 p-6 sm:p-8 shadow-subtle">
                
                <!-- Amazon-style Cart Header -->
                <div class="flex items-baseline justify-between pb-4 border-b border-neutral-200 mb-6">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight">
                            <?php esc_html_e('Carrito de compras', 'tech-store'); ?>
                        </h1>
                        <p class="text-xs text-neutral-400 mt-0.5">
                            <?php printf(esc_html__('%d productos en tu lista', 'tech-store'), absint($cart_count)); ?>
                        </p>
                    </div>
                    <div class="hidden sm:block text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                        <?php esc_html_e('Precio', 'tech-store'); ?>
                    </div>
                </div>

                <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                    <?php do_action('woocommerce_before_cart_table'); ?>

                    <div class="divide-y divide-neutral-200">
                        <?php
                        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                $raw_name          = $_product->get_name();
                                $product_name      = function_exists('tech_store_capitalize_text') ? tech_store_capitalize_text($raw_name) : ucwords(strtolower($raw_name));
                                $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('tech-product-card', ['class' => 'w-20 h-20 sm:w-24 sm:h-24 object-contain rounded-2xl bg-neutral-50 p-2 border border-neutral-200', 'alt' => esc_attr($product_name)]), $cart_item, $cart_item_key);
                                $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                $product_subtotal  = apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                $is_in_stock       = $_product->is_in_stock();
                                $max_qty           = $_product->get_max_purchase_quantity();
                                ?>
                                <div class="woocommerce-cart-form__cart-item py-5 flex flex-col sm:flex-row items-start justify-between gap-4 sm:gap-6 <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                                    
                                    <!-- Product Image & Meta -->
                                    <div class="flex items-start gap-4 sm:gap-6 flex-1">
                                        <div class="flex-shrink-0">
                                            <?php if ($product_permalink) : ?>
                                                <a href="<?php echo esc_url($product_permalink); ?>"><?php echo $thumbnail; ?></a>
                                            <?php else : ?>
                                                <?php echo $thumbnail; ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="space-y-1.5 flex-1 min-w-0">
                                            <!-- Product Title (Capitalized) -->
                                            <h3 class="text-sm sm:text-base font-bold text-neutral-900 hover:text-cta transition-colors leading-snug capitalize">
                                                <?php if ($product_permalink) : ?>
                                                    <a href="<?php echo esc_url($product_permalink); ?>"><?php echo esc_html($product_name); ?></a>
                                                <?php else : ?>
                                                    <?php echo esc_html($product_name); ?>
                                                <?php endif; ?>
                                            </h3>

                                            <!-- Stock Status -->
                                            <div class="text-xs font-semibold">
                                                <?php if ($is_in_stock) : ?>
                                                    <span class="text-emerald-700 flex items-center gap-1">
                                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                        <?php esc_html_e('En stock - Listo para envío', 'tech-store'); ?>
                                                    </span>
                                                <?php else : ?>
                                                    <span class="text-rose-600">
                                                        <?php esc_html_e('Agotado', 'tech-store'); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Extra Variations Metadata -->
                                            <?php echo wc_get_formatted_cart_item_data($cart_item); ?>

                                            <!-- Free Shipping Eligible Badge -->
                                            <div class="text-[11px] text-neutral-500 font-medium pt-0.5">
                                                <?php esc_html_e('Aplica para Envío Gratis y Retiro en Sucursal', 'tech-store'); ?>
                                            </div>

                                            <!-- Amazon Style Controls: Quantity Dropdown + Delete Link -->
                                            <div class="flex items-center flex-wrap gap-4 pt-2 text-xs">
                                                
                                                <!-- Quantity Select or Input -->
                                                <div class="flex items-center bg-neutral-100 border border-neutral-300 rounded-xl px-2.5 py-1 gap-2 shadow-sm">
                                                    <label for="quantity_<?php echo esc_attr($cart_item_key); ?>" class="font-bold text-neutral-700 text-[11px]">
                                                        <?php esc_html_e('Cant:', 'tech-store'); ?>
                                                    </label>
                                                    <input 
                                                        type="number" 
                                                        id="quantity_<?php echo esc_attr($cart_item_key); ?>"
                                                        name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" 
                                                        value="<?php echo esc_attr($cart_item['quantity']); ?>" 
                                                        min="1" 
                                                        max="<?php echo esc_attr($max_qty > 0 ? $max_qty : 99); ?>" 
                                                        class="tech-cart-qty-input w-12 bg-white text-center font-bold text-neutral-900 border border-neutral-300 rounded-lg py-0.5 text-xs focus:ring-0 focus:border-primary outline-none"
                                                    />
                                                </div>

                                                <span class="text-neutral-300">|</span>

                                                <!-- Delete Link -->
                                                <?php
                                                echo apply_filters(
                                                    'woocommerce_cart_item_remove_link',
                                                    sprintf(
                                                        '<a href="%s" class="text-neutral-500 hover:text-rose-600 font-semibold transition-colors inline-flex items-center gap-1" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s %s</a>',
                                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                        esc_attr(sprintf(__('Eliminar %s', 'tech-store'), wp_strip_all_tags($product_name))),
                                                        esc_attr($product_id),
                                                        esc_attr($_product->get_sku()),
                                                        tech_store_svg_icon('trash', 'w-3.5 h-3.5'),
                                                        esc_html__('Eliminar', 'tech-store')
                                                    ),
                                                    $cart_item_key
                                                );
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price (Right Aligned on desktop) -->
                                    <div class="sm:text-right w-full sm:w-auto flex sm:flex-col items-baseline justify-between sm:justify-start">
                                        <span class="sm:hidden text-xs text-neutral-500 font-medium"><?php esc_html_e('Precio total:', 'tech-store'); ?></span>
                                        <span class="text-base sm:text-lg font-extrabold text-neutral-900">
                                            <?php echo wp_kses_post($product_subtotal); ?>
                                        </span>
                                    </div>

                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <!-- Action Bar -->
                    <div class="pt-4 flex justify-between items-center border-t border-neutral-200 mt-4">
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="text-xs font-bold text-neutral-700 hover:text-cta flex items-center gap-1 transition-colors">
                            &larr; <?php esc_html_e('Continuar comprando', 'tech-store'); ?>
                        </a>
                        <button type="submit" class="button ubx-btn-outline text-xs" name="update_cart" value="<?php esc_attr_e('Actualizar carrito', 'tech-store'); ?>">
                            <?php esc_html_e('Actualizar carrito', 'tech-store'); ?>
                        </button>
                        <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                    </div>

                    <?php do_action('woocommerce_after_cart_table'); ?>
                </form>

                <!-- Subtotal summary at the bottom of the list -->
                <div class="pt-6 border-t border-neutral-200 text-right">
                    <p class="text-sm sm:text-base text-neutral-700">
                        <?php printf(esc_html__('Subtotal (%d productos):', 'tech-store'), absint($cart_count)); ?>
                        <span class="text-xl sm:text-2xl font-black text-neutral-900 ml-1">
                            <?php wc_cart_totals_subtotal_html(); ?>
                        </span>
                    </p>
                </div>

            </div>

        </div>

        <!-- RIGHT COLUMN: Amazon-style Sticky Order Summary (4 cols / ~33%) -->
        <div class="lg:col-span-4 sticky top-28 space-y-6">
            <?php woocommerce_cart_totals(); ?>
        </div>

    </div>

    <!-- RECOMMENDED / CROSS-SELL PRODUCTS (Amazon Style) -->
    <div class="mt-12 pt-8 border-t border-neutral-200">
        <?php woocommerce_cross_sell_display(4, 4); ?>
    </div>

</div>

<?php do_action('woocommerce_after_cart'); ?>
