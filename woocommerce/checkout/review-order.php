<?php
/**
 * Review order table (Amazon / Ubalux Inspired Modern Summary)
 *
 * @package TechStore
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
?>
<table class="shop_table woocommerce-checkout-review-order-table w-full text-xs">
    <thead>
        <tr class="border-b border-neutral-200">
            <th class="product-name py-2.5 text-left font-bold text-neutral-400 uppercase tracking-wider text-[11px]"><?php esc_html_e('Producto', 'tech-store'); ?></th>
            <th class="product-total py-2.5 text-right font-bold text-neutral-400 uppercase tracking-wider text-[11px]"><?php esc_html_e('Subtotal', 'tech-store'); ?></th>
        </tr>
    </thead>
    <tbody class="divide-y divide-neutral-100">
        <?php
        do_action('woocommerce_review_order_before_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $raw_name     = $_product->get_name();
                $product_name = function_exists('tech_store_capitalize_text') ? tech_store_capitalize_text($raw_name) : ucwords(strtolower($raw_name));
                $thumbnail    = $_product->get_image('thumbnail', ['class' => 'w-12 h-12 object-contain rounded-xl bg-neutral-50 p-1 border border-neutral-200 flex-shrink-0']);
                ?>
                <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                    <td class="product-name py-3 pr-2">
                        <div class="flex items-center gap-3">
                            <div class="relative flex-shrink-0">
                                <?php echo $thumbnail; ?>
                                <span class="absolute -top-1.5 -right-1.5 bg-neutral-900 text-white text-[10px] font-extrabold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                    <?php echo esc_html($cart_item['quantity']); ?>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="font-bold text-neutral-900 block leading-snug line-clamp-2 capitalize">
                                    <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $product_name, $cart_item, $cart_item_key)); ?>
                                </span>
                                <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                            </div>
                        </div>
                    </td>
                    <td class="product-total py-3 text-right font-extrabold text-neutral-900 whitespace-nowrap align-middle">
                        <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                    </td>
                </tr>
                <?php
            }
        }

        do_action('woocommerce_review_order_after_cart_contents');
        ?>
    </tbody>
    <tfoot>

        <!-- Subtotal -->
        <tr class="cart-subtotal border-t border-neutral-200">
            <th class="py-3 text-left font-semibold text-neutral-600"><?php esc_html_e('Subtotal', 'tech-store'); ?></th>
            <td class="py-3 text-right font-bold text-neutral-900"><?php wc_cart_totals_subtotal_html(); ?></td>
        </tr>

        <!-- Coupons -->
        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
            <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?> text-emerald-700">
                <th class="py-2 text-left font-semibold"><?php wc_cart_totals_coupon_label($coupon); ?></th>
                <td class="py-2 text-right font-bold"><?php wc_cart_totals_coupon_html($coupon); ?></td>
            </tr>
        <?php endforeach; ?>

        <!-- Shipping -->
        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
            <?php do_action('woocommerce_review_order_before_shipping'); ?>
            <tr class="woocommerce-shipping-totals shipping border-t border-neutral-100">
                <th class="py-3 text-left font-semibold text-neutral-600 align-top"><?php esc_html_e('Envío', 'tech-store'); ?></th>
                <td class="py-3 text-right font-medium text-neutral-800" data-title="<?php esc_attr_e('Envío', 'tech-store'); ?>">
                    <?php wc_cart_totals_shipping_html(); ?>
                </td>
            </tr>
            <?php do_action('woocommerce_review_order_after_shipping'); ?>
        <?php endif; ?>

        <!-- Fees -->
        <?php foreach (WC()->cart->get_fees() as $fee) : ?>
            <tr class="fee border-t border-neutral-100">
                <th class="py-2 text-left font-semibold text-neutral-600"><?php echo esc_html($fee->name); ?></th>
                <td class="py-2 text-right font-bold text-neutral-900"><?php wc_cart_totals_fee_html($fee); ?></td>
            </tr>
        <?php endforeach; ?>

        <!-- Taxes -->
        <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
            <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
                <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
                    <tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?> border-t border-neutral-100">
                        <th class="py-2 text-left font-semibold text-neutral-600"><?php echo esc_html($tax->label); ?></th>
                        <td class="py-2 text-right font-bold text-neutral-900"><?php echo wp_kses_post($tax->formatted_amount); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr class="tax-total border-t border-neutral-100">
                    <th class="py-2 text-left font-semibold text-neutral-600"><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
                    <td class="py-2 text-right font-bold text-neutral-900"><?php wc_cart_totals_taxes_total_html(); ?></td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>

        <?php do_action('woocommerce_review_order_before_order_total'); ?>

        <!-- Total -->
        <tr class="order-total border-t-2 border-neutral-900 pt-3">
            <th class="py-4 text-left font-black text-neutral-900 text-sm sm:text-base"><?php esc_html_e('Total a pagar', 'tech-store'); ?></th>
            <td class="py-4 text-right font-black text-neutral-900 text-lg sm:text-2xl"><?php wc_cart_totals_order_total_html(); ?></td>
        </tr>

        <?php do_action('woocommerce_review_order_after_order_total'); ?>

    </tfoot>
</table>
