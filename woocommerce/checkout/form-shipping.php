<?php
/**
 * Checkout Shipping Information & Order Notes Template
 *
 * @package TechStore
 * @version 3.6.0
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-shipping-fields">

    <?php if (true === WC()->cart->needs_shipping_address()) : ?>

        <div class="flex items-center justify-between pb-4 border-b border-neutral-100 mb-6">
            <h3 id="ship-to-different-address" class="text-lg font-black text-neutral-900 flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-xl bg-primary text-white flex items-center justify-center text-xs font-bold shadow-sm">2</span>
                <span><?php esc_html_e('Dirección de entrega', 'alex-store'); ?></span>
            </h3>
            
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox flex items-center gap-2 cursor-pointer select-none text-xs font-bold text-neutral-700 hover:text-primary transition-colors">
                <input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox w-4 h-4 rounded text-primary focus:ring-primary border-neutral-300" <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0), 1); ?> type="checkbox" name="ship_to_different_address" value="1" />
                <span><?php esc_html_e('¿Enviar a una dirección diferente?', 'alex-store'); ?></span>
            </label>
        </div>

        <div class="shipping_address space-y-4 mb-6">
            <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

            <div class="woocommerce-shipping-fields__field-wrapper">
                <?php
                $fields = $checkout->get_checkout_fields('shipping');

                foreach ($fields as $key => $field) {
                    woocommerce_form_field($key, $field, $checkout->get_value($key));
                }
                ?>
            </div>

            <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>
        </div>

    <?php else : ?>

        <div class="flex items-center justify-between pb-4 border-b border-neutral-100 mb-6">
            <h3 class="text-lg font-black text-neutral-900 flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-xl bg-primary text-white flex items-center justify-center text-xs font-bold shadow-sm">2</span>
                <span><?php esc_html_e('Instrucciones del pedido', 'alex-store'); ?></span>
            </h3>
        </div>

    <?php endif; ?>

</div>

<div class="woocommerce-additional-fields pt-4 border-t border-neutral-100">
    <?php do_action('woocommerce_before_order_notes', $checkout); ?>

    <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>

        <div class="woocommerce-additional-fields__field-wrapper">
            <?php foreach ($checkout->get_checkout_fields('order') as $key => $field) : ?>
                <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <?php do_action('woocommerce_after_order_notes', $checkout); ?>
</div>
