<?php
/**
 * Cart Totals Template (Amazon.com Inspired Sticky Order Summary)
 *
 * @package TechStore
 * @version 2.3.6
 */

defined('ABSPATH') || exit;

$cart_count   = WC()->cart->get_cart_contents_count();
$subtotal_num = (float) WC()->cart->get_subtotal();
$threshold    = (float) apply_filters('tech_store_free_shipping_threshold', 25000);
$diff         = $threshold - $subtotal_num;
$percentage   = $threshold > 0 ? min(100, round(($subtotal_num / $threshold) * 100)) : 100;
?>

<div class="cart_totals <?php echo (WC()->customer->has_calculated_shipping()) ? 'calculated_shipping' : ''; ?> bg-white rounded-3xl border border-neutral-200 p-6 sm:p-8 shadow-card space-y-6">
    
    <?php do_action('woocommerce_before_cart_totals'); ?>

    <!-- 1. Free Shipping Notification (Amazon Style) -->
    <div class="p-4 rounded-2xl bg-neutral-50 border border-neutral-100 space-y-2">
        <?php if ($diff > 0) : ?>
            <p class="text-xs font-medium text-neutral-700 flex items-center gap-2">
                <span class="text-primary"><?php echo tech_store_svg_icon('truck', 'w-4 h-4'); ?></span>
                <span><?php printf(esc_html__('Agrega %s más para ENVÍO GRATIS.', 'tech-store'), '<strong class="text-neutral-900">' . wc_price($diff) . '</strong>'); ?></span>
            </p>
        <?php else : ?>
            <p class="text-xs font-bold text-emerald-700 flex items-center gap-2">
                <span><?php echo tech_store_svg_icon('check', 'w-4 h-4 text-emerald-600'); ?></span>
                <span><?php esc_html_e('¡Tu pedido califica para ENVÍO GRATIS!', 'tech-store'); ?></span>
            </p>
        <?php endif; ?>

        <!-- Progress Bar -->
        <div class="w-full bg-neutral-200 rounded-full h-1.5 overflow-hidden">
            <div class="bg-cta h-1.5 rounded-full progress-bar-fill" style="width: <?php echo esc_attr($percentage); ?>%;"></div>
        </div>
    </div>

    <!-- 2. Subtotal Headline -->
    <div class="space-y-1">
        <div class="text-xs text-neutral-500 font-medium">
            <?php printf(esc_html__('Subtotal (%d artículos):', 'tech-store'), absint($cart_count)); ?>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight">
            <?php wc_cart_totals_subtotal_html(); ?>
        </div>
    </div>

    <!-- 3. Primary Proceed to Checkout CTA Button (Full Width, Big) -->
    <div class="wc-proceed-to-checkout pt-1">
        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout-button ubx-btn-primary w-full py-4 text-base font-extrabold shadow-cta rounded-2xl flex items-center justify-center gap-2">
            <span><?php esc_html_e('Proceder al pago', 'tech-store'); ?></span>
            <?php echo tech_store_svg_icon('arrow-right', 'w-5 h-5'); ?>
        </a>
    </div>

    <!-- 4. Credex Financing Box (MR Soluciones) -->
    <div class="p-3.5 rounded-2xl bg-neutral-50 border border-neutral-200/80 flex items-center gap-3 text-xs text-neutral-700">
        <span class="p-2 bg-white border border-neutral-200 rounded-xl text-primary font-black shadow-subtle text-[11px]">
            CREDEX
        </span>
        <div>
            <strong class="text-neutral-900 block font-bold"><?php esc_html_e('Paga en cuotas al 0% interés', 'tech-store'); ?></strong>
            <span class="text-[11px] text-neutral-500"><?php esc_html_e('Hasta 3 y 6 meses con Credex y tarjetas bancarias.', 'tech-store'); ?></span>
        </div>
    </div>

    <!-- 5. Collapsible Coupon Code Accordion -->
    <?php if (wc_coupons_enabled()) : ?>
        <details class="group border border-neutral-200 rounded-2xl p-3.5 text-xs">
            <summary class="font-bold text-neutral-800 cursor-pointer flex items-center justify-between select-none">
                <span class="flex items-center gap-1.5">
                    <span>🏷️</span>
                    <span><?php esc_html_e('¿Tienes un código de cupón?', 'tech-store'); ?></span>
                </span>
                <span class="text-neutral-400 group-open:rotate-180 transition-transform">
                    <?php echo tech_store_svg_icon('chevron-down', 'w-4 h-4'); ?>
                </span>
            </summary>
            <div class="pt-3">
                <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post" class="flex gap-2">
                    <input 
                        type="text" 
                        name="coupon_code" 
                        id="coupon_code" 
                        value="" 
                        placeholder="<?php esc_attr_e('Código de cupón', 'tech-store'); ?>" 
                        class="w-full bg-neutral-50 border border-neutral-300 rounded-xl px-3 py-2 text-xs text-neutral-900 uppercase focus:border-primary focus:bg-white outline-none"
                    />
                    <button type="submit" name="apply_coupon" value="<?php esc_attr_e('Aplicar', 'tech-store'); ?>" class="ubx-btn-outline px-4 py-2 text-xs font-bold whitespace-nowrap">
                        <?php esc_html_e('Aplicar', 'tech-store'); ?>
                    </button>
                    <?php do_action('woocommerce_cart_coupon'); ?>
                </form>
            </div>
        </details>
    <?php endif; ?>

    <!-- 6. Detailed Totals Breakdown (Coupons, Fees, Taxes, Shipping) -->
    <div class="divide-y divide-neutral-100 text-xs text-neutral-600 pt-2">
        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
            <div class="py-2 flex justify-between items-center text-emerald-700 font-medium">
                <span><?php wc_cart_totals_coupon_label($coupon); ?></span>
                <span><?php wc_cart_totals_coupon_html($coupon); ?></span>
            </div>
        <?php endforeach; ?>

        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
            <div class="py-2.5">
                <?php do_action('woocommerce_cart_totals_before_shipping'); ?>
                <?php wc_cart_totals_shipping_html(); ?>
                <?php do_action('woocommerce_cart_totals_after_shipping'); ?>
            </div>
        <?php endif; ?>

        <?php foreach (WC()->cart->get_fees() as $fee) : ?>
            <div class="py-2 flex justify-between">
                <span><?php echo esc_html($fee->name); ?></span>
                <span class="font-bold text-neutral-900"><?php wc_cart_totals_fee_html($fee); ?></span>
            </div>
        <?php endforeach; ?>

        <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
            <div class="py-2 flex justify-between">
                <span><?php echo esc_html(WC()->countries->tax_or_vat()); ?></span>
                <span class="font-bold text-neutral-900"><?php wc_cart_totals_taxes_total_html(); ?></span>
            </div>
        <?php endif; ?>

        <div class="py-3 flex justify-between items-baseline text-sm font-bold text-neutral-900 pt-3">
            <span><?php esc_html_e('Total Estimado', 'tech-store'); ?></span>
            <span class="text-xl font-black text-neutral-900"><?php wc_cart_totals_order_total_html(); ?></span>
        </div>
    </div>

    <!-- 7. Security Guarantee / Safe Checkout -->
    <div class="pt-2 text-center text-[11px] text-neutral-400 space-y-1">
        <p class="flex items-center justify-center gap-1">
            <span>🔒</span>
            <span><?php esc_html_e('Transacción 100% Segura con Encriptación SSL', 'tech-store'); ?></span>
        </p>
        <p><?php esc_html_e('Garantía directa de cambio y devolución en MR Soluciones.', 'tech-store'); ?></p>
    </div>

    <?php do_action('woocommerce_after_cart_totals'); ?>

</div>
