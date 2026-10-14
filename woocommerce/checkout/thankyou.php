<?php
/**
 * Thankyou page (Modern Order Confirmation inspired by Amazon & Ubalux)
 *
 * @package TechStore
 * @version 8.1.0
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">

    <?php if ($order) : ?>

        <?php do_action('woocommerce_before_thankyou', $order->get_id()); ?>

        <?php if ($order->has_status('failed')) : ?>

            <div class="bg-rose-50 border border-rose-200 rounded-3xl p-6 sm:p-8 text-center space-y-4 mb-8">
                <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto shadow-sm">
                    <?php echo alex_store_svg_icon('alert-triangle', 'w-8 h-8'); ?>
                </div>
                <h1 class="text-2xl font-black text-rose-900 tracking-tight">
                    <?php esc_html_e('El pago no pudo ser procesado', 'alex-store'); ?>
                </h1>
                <p class="text-xs sm:text-sm text-rose-700 max-w-md mx-auto">
                    <?php esc_html_e('Desafortunadamente no se pudo completar tu transacción. Tu cuenta bancaria no ha sido cargada.', 'alex-store'); ?>
                </p>
                <div class="pt-2 flex justify-center gap-3">
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="ubx-btn-primary py-3 px-6 text-xs sm:text-sm font-bold">
                        <?php esc_html_e('Reintentar pago', 'alex-store'); ?>
                    </a>
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="ubx-btn-secondary py-3 px-6 text-xs sm:text-sm font-bold">
                            <?php esc_html_e('Mi cuenta', 'alex-store'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        <?php else : ?>

            <!-- Success Celebration Banner -->
            <div class="bg-white rounded-3xl border border-neutral-200 p-6 sm:p-10 shadow-subtle text-center space-y-4 mb-8">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-sm">
                    <?php echo alex_store_svg_icon('check', 'w-8 h-8 stroke-[2.5]'); ?>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 inline-block mb-2">
                        <?php esc_html_e('Pedido Confirmado con Éxito', 'alex-store'); ?>
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight">
                        <?php esc_html_e('¡Muchas gracias por tu compra!', 'alex-store'); ?>
                    </h1>
                    <p class="text-xs sm:text-sm text-neutral-500 mt-1 max-w-lg mx-auto">
                        <?php printf(esc_html__('Hemos recibido tu pedido #%s y te hemos enviado un correo de confirmación con el detalle.', 'alex-store'), '<strong class="text-neutral-900">' . esc_html($order->get_order_number()) . '</strong>'); ?>
                    </p>
                </div>

                <!-- Key Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 pt-4 border-t border-neutral-100 text-left">
                    
                    <div class="p-3.5 rounded-2xl bg-neutral-50 border border-neutral-100">
                        <span class="text-[11px] font-semibold text-neutral-400 block"><?php esc_html_e('Número de pedido:', 'alex-store'); ?></span>
                        <strong class="text-sm font-black text-neutral-900">#<?php echo esc_html($order->get_order_number()); ?></strong>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-neutral-50 border border-neutral-100">
                        <span class="text-[11px] font-semibold text-neutral-400 block"><?php esc_html_e('Fecha:', 'alex-store'); ?></span>
                        <strong class="text-sm font-black text-neutral-900"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></strong>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-neutral-50 border border-neutral-100">
                        <span class="text-[11px] font-semibold text-neutral-400 block"><?php esc_html_e('Total:', 'alex-store'); ?></span>
                        <strong class="text-sm font-black text-neutral-900"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-neutral-50 border border-neutral-100">
                        <span class="text-[11px] font-semibold text-neutral-400 block"><?php esc_html_e('Método de pago:', 'alex-store'); ?></span>
                        <strong class="text-sm font-black text-neutral-900 line-clamp-1"><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                    </div>

                </div>
            </div>

        <?php endif; ?>

        <!-- Payment method specific details (e.g. Bank Account info / BACS) -->
        <div class="thankyou-payment-instructions mb-8">
            <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
        </div>

        <!-- Order details hook (renders order items table and addresses) -->
        <div class="thankyou-order-details bg-white rounded-3xl border border-neutral-200 p-6 sm:p-8 shadow-subtle space-y-6">
            <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
        </div>

        <!-- Back to Store Action -->
        <div class="mt-8 text-center">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ubx-btn-primary py-3.5 px-8 text-sm font-bold">
                <?php esc_html_e('Continuar explorando productos', 'alex-store'); ?>
            </a>
        </div>

    <?php else : ?>

        <div class="bg-white rounded-3xl border border-neutral-200 p-8 text-center space-y-4">
            <p class="text-sm text-neutral-600">
                <?php esc_html_e('Gracias. Tu pedido ha sido recibido.', 'alex-store'); ?>
            </p>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ubx-btn-primary py-3 px-6 text-xs font-bold">
                <?php esc_html_e('Ir a la tienda', 'alex-store'); ?>
            </a>
        </div>

    <?php endif; ?>

</div>
