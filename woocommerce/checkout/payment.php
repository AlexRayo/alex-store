<?php
/**
 * Checkout Payment Section Template
 *
 * @package TechStore
 * @version 8.1.0
 */

defined('ABSPATH') || exit;

if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>
<div id="payment" class="woocommerce-checkout-payment pt-4 border-t border-neutral-200">
    
    <div class="mb-4">
        <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-wider mb-3">
            <?php esc_html_e('Selecciona tu método de pago', 'alex-store'); ?>
        </h3>
    </div>

    <?php if (WC()->cart->needs_payment()) : ?>
        <ul class="wc_payment_methods payment_methods methods space-y-3 list-none p-0 m-0 mb-6">
            <?php
            if (!empty($available_gateways)) {
                foreach ($available_gateways as $gateway) {
                    wc_get_template('checkout/payment-method.php', ['gateway' => $gateway]);
                }
            } else {
                echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info p-4 rounded-2xl bg-neutral-50 text-xs text-neutral-600">' . apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('No parece haber ningún método de pago disponible para tu estado. Por favor ponte en contacto con nosotros si necesitas ayuda.', 'alex-store') : esc_html__('Por favor rellena tus datos para ver los métodos de pago disponibles.', 'alex-store')) . '</li>';
            }
            ?>
        </ul>
    <?php endif; ?>

    <div class="form-row place-order space-y-4">
        <noscript>
            <?php
            /* translators: $1 and $2 opening and closing emphasis tags respectively */
            printf(esc_html__('Dado que tu navegador no admite JavaScript, o lo tiene desactivado, asegúrate de hacer clic en el botón %1$sActualizar totales%2$s antes de realizar tu pedido.', 'alex-store'), '<em>', '</em>');
            ?>
            <br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e('Actualizar totales', 'alex-store'); ?>"><?php esc_html_e('Actualizar totales', 'alex-store'); ?></button>
        </noscript>

        <?php wc_get_template('checkout/terms.php'); ?>

        <?php do_action('woocommerce_review_order_before_submit'); ?>

        <!-- Dynamic Real-Time Checkout Validation Feedback -->
        <div id="tech-checkout-validation-notice" class="hidden rounded-2xl border border-amber-200 bg-amber-50/90 p-4 text-xs text-amber-900 transition-all space-y-2">
            <div class="flex items-start gap-2.5">
                <?php echo alex_store_svg_icon('alert-triangle', 'w-4 h-4 text-amber-600 shrink-0 mt-0.5'); ?>
                <div class="flex-1">
                    <span class="font-bold text-neutral-900 block mb-0.5">
                        <?php esc_html_e('Completa los campos obligatorios para continuar', 'alex-store'); ?>
                    </span>
                    <p class="text-neutral-600 text-[11px] leading-relaxed mb-2.5">
                        <?php esc_html_e('El botón de realizar pedido se habilitará automáticamente al llenar los siguientes datos:', 'alex-store'); ?>
                    </p>
                    <div id="tech-checkout-missing-fields" class="flex flex-wrap gap-1.5">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <?php
        $order_button_text = apply_filters('woocommerce_order_button_text', __('Realizar el pedido', 'alex-store'));
        echo apply_filters(
            'woocommerce_order_button_html',
            '<div id="tech-place-order-wrapper" class="relative">' .
            '<button type="submit" class="button alt ubx-btn-primary w-full py-4 text-base font-extrabold rounded-2xl flex items-center justify-center gap-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' .
            '<span>' . esc_html($order_button_text) . '</span>' .
            '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>' .
            '</button>' .
            '</div>'
        );
        ?>

        <?php do_action('woocommerce_review_order_after_submit'); ?>

        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
    </div>

</div>
<?php
if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}
