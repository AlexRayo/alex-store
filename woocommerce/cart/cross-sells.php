<?php
/**
 * Cross-sells in Cart Template (Amazon Style)
 *
 * @package TechStore
 * @version 4.4.0
 */

defined('ABSPATH') || exit;

if ($cross_sells) : ?>

    <div class="cross-sells">
        <?php
        $heading = apply_filters('woocommerce_product_cross_sells_products_heading', __('Clientes que compraron artículos en su carrito también compraron', 'alex-store'));
        ?>
        <div class="mb-6">
            <h3 class="text-xl sm:text-2xl font-bold text-neutral-900 tracking-tight">
                <?php echo esc_html($heading); ?>
            </h3>
            <p class="text-xs text-neutral-500">
                <?php esc_html_e('Complementa tu compra con accesorios y tecnología recomendada', 'alex-store'); ?>
            </p>
        </div>

        <ul class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 p-0 m-0 list-none">
            <?php foreach ($cross_sells as $cross_sell) : ?>
                <?php echo alex_store_product_card($cross_sell); ?>
            <?php endforeach; ?>
        </ul>
    </div>

<?php endif;

wp_reset_postdata();
