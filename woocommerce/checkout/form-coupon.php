<?php
/**
 * Checkout coupon form
 *
 * @package TechStore
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

if (!wc_coupons_enabled()) {
    return;
}
?>
<div class="woocommerce-form-coupon-toggle mb-6">
    <div class="p-4 rounded-2xl bg-white border border-neutral-200 shadow-subtle flex items-center justify-between">
        <div class="flex items-center gap-2.5 text-xs text-neutral-700 font-medium">
            <?php echo alex_store_svg_icon('tag', 'w-4 h-4 text-neutral-500'); ?>
            <span><?php esc_html_e('¿Tienes un código de descuento o cupón?', 'alex-store'); ?></span>
        </div>
        <a href="#" class="showcoupon text-xs font-bold text-cta hover:text-cta-hover transition-colors underline decoration-2 underline-offset-2">
            <?php esc_html_e('Haz clic aquí para ingresarlo', 'alex-store'); ?>
        </a>
    </div>
</div>

<form class="checkout_coupon woocommerce-form-coupon bg-white p-5 rounded-2xl border border-neutral-200 shadow-subtle mb-6" method="post" style="display:none">
    <p class="text-xs text-neutral-600 mb-3">
        <?php esc_html_e('Si tienes un código de cupón, por favor ingrésalo a continuación.', 'alex-store'); ?>
    </p>

    <div class="flex gap-2.5">
        <input 
            type="text" 
            name="coupon_code" 
            class="input-text w-full bg-neutral-50 border border-neutral-300 rounded-xl px-3.5 py-2.5 text-xs text-neutral-900 uppercase focus:border-primary focus:bg-white outline-none" 
            placeholder="<?php esc_attr_e('Código de cupón', 'alex-store'); ?>" 
            id="coupon_code" 
            value="" 
        />
        <button type="submit" class="button ubx-btn-primary px-5 py-2.5 text-xs font-bold whitespace-nowrap" name="apply_coupon" value="<?php esc_attr_e('Aplicar cupón', 'alex-store'); ?>">
            <?php esc_html_e('Aplicar cupón', 'alex-store'); ?>
        </button>
    </div>
    <div class="clear"></div>
</form>
