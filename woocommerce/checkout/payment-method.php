<?php
/**
 * Output a single payment method (Clean Card Style with Radio & Icon)
 *
 * @package TechStore
 * @version 3.5.0
 */

defined('ABSPATH') || exit;
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr($gateway->id); ?> border border-neutral-200 rounded-2xl p-4 transition-all bg-white hover:border-neutral-300">
    <div class="flex items-center justify-between gap-3">
        <label for="payment_method_<?php echo esc_attr($gateway->id); ?>" class="flex items-center gap-3 cursor-pointer select-none text-xs sm:text-sm font-bold text-neutral-800 flex-1">
            <input 
                id="payment_method_<?php echo esc_attr($gateway->id); ?>" 
                type="radio" 
                class="input-radio w-4 h-4 text-primary focus:ring-primary border-neutral-300" 
                name="payment_method" 
                value="<?php echo esc_attr($gateway->id); ?>" 
                <?php checked($gateway->chosen, true); ?> 
                data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" 
            />
            <span><?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></span>
        </label>
        
        <?php if ($gateway->get_icon()) : ?>
            <div class="payment-icon flex-shrink-0">
                <?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
        <div class="payment_box payment_method_<?php echo esc_attr($gateway->id); ?> mt-3 pt-3 border-t border-neutral-100 text-xs text-neutral-600 leading-relaxed" <?php if (!$gateway->chosen) : ?>style="display:none;"<?php endif; ?>>
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>
