<?php
/**
 * Checkout Form Template (Modern 2-Column Layout inspired by Amazon & Ubalux)
 *
 * @package TechStore
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
?>

<div class="site-container py-2 sm:py-4">

    <!-- 1. Header & Step Breadcrumbs -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-200">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight flex items-center gap-3">
                    <span><?php esc_html_e('Finalizar compra', 'alex-store'); ?></span>
                </h1>
                <p class="text-xs text-neutral-500 mt-1">
                    <?php printf(esc_html__('Estás a un paso de completar tu pedido (%d artículos)', 'alex-store'), absint($cart_count)); ?>
                </p>
            </div>

            <!-- Trust Indicator Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-neutral-100 border border-neutral-200 text-xs font-semibold text-neutral-700 self-start sm:self-auto">
                <?php echo alex_store_svg_icon('lock', 'w-3.5 h-3.5 text-emerald-600'); ?>
                <span><?php esc_html_e('Pago 100% Seguro & Encriptado', 'alex-store'); ?></span>
            </div>
        </div>

        <!-- 3-Step Progress Indicator -->
        <nav aria-label="Progreso del pedido" class="mt-4 flex items-center justify-center sm:justify-start gap-2 sm:gap-4 text-xs font-bold text-neutral-400 overflow-x-auto pb-1">
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="flex items-center gap-1.5 text-neutral-700 hover:text-primary transition-colors">
                <span class="w-5 h-5 rounded-full bg-neutral-200 text-neutral-800 flex items-center justify-center">
                    <?php echo alex_store_svg_icon('check', 'w-3 h-3'); ?>
                </span>
                <span><?php esc_html_e('1. Carrito', 'alex-store'); ?></span>
            </a>
            <span class="text-neutral-300">&rarr;</span>
            <div class="flex items-center gap-1.5 text-primary">
                <span class="w-5 h-5 rounded-full bg-primary text-white flex items-center justify-center text-[10px]">2</span>
                <span class="underline decoration-2 underline-offset-4"><?php esc_html_e('2. Envío y Pago', 'alex-store'); ?></span>
            </div>
            <span class="text-neutral-300">&rarr;</span>
            <div class="flex items-center gap-1.5 text-neutral-400">
                <span class="w-5 h-5 rounded-full bg-neutral-100 text-neutral-400 flex items-center justify-center text-[10px]">3</span>
                <span><?php esc_html_e('3. Confirmación', 'alex-store'); ?></span>
            </div>
        </nav>
    </div>

    <!-- Login & Coupon Notices -->
    <?php do_action('woocommerce_before_checkout_form', $checkout); ?>

    <?php
    // If checkout registration is disabled and not logged in, the user cannot checkout
    if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
        echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('Debes iniciar sesión para finalizar la compra.', 'alex-store')));
        return;
    }
    ?>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: Customer Information & Shipping Details (7 cols / ~58%) -->
            <div class="lg:col-span-7 space-y-6">
                
                <?php if ($checkout->get_checkout_fields()) : ?>

                    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                    <div id="customer_details" class="space-y-6">
                        
                        <!-- Billing Details Section -->
                        <div class="bg-white rounded-3xl border border-neutral-200 p-6 sm:p-8 shadow-subtle">
                            <?php do_action('woocommerce_checkout_billing'); ?>
                        </div>

                        <!-- Shipping Details & Order Notes Section -->
                        <div class="bg-white rounded-3xl border border-neutral-200 p-6 sm:p-8 shadow-subtle">
                            <?php do_action('woocommerce_checkout_shipping'); ?>
                        </div>

                    </div>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                <?php endif; ?>

            </div>

            <!-- RIGHT COLUMN: Sticky Order Review, Payment Gateways & Place Order (5 cols / ~42%) -->
            <div class="lg:col-span-5 sticky top-24 space-y-6">

                <div class="bg-white rounded-3xl border border-neutral-200 p-6 sm:p-8 shadow-card space-y-6">
                    
                    <div class="flex items-center justify-between pb-3 border-b border-neutral-200">
                        <h2 id="order_review_heading" class="text-xl font-black text-neutral-900 tracking-tight">
                            <?php esc_html_e('Resumen del pedido', 'alex-store'); ?>
                        </h2>
                        <span class="text-xs font-bold text-neutral-500 bg-neutral-100 px-2.5 py-1 rounded-full">
                            <?php printf(esc_html__('%d items', 'alex-store'), absint($cart_count)); ?>
                        </span>
                    </div>

                    <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
                    <?php do_action('woocommerce_checkout_before_order_review'); ?>

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action('woocommerce_checkout_order_review'); ?>
                    </div>

                    <?php do_action('woocommerce_checkout_after_order_review'); ?>

                </div>

            </div>

        </div>

    </form>

    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>

</div>
