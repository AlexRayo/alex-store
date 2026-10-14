<?php
/**
 * Empty Cart Page Template (Amazon.com Inspired)
 *
 * @package TechStore
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart_empty');
?>

<div class="site-container py-8">

    <div class="bg-white rounded-3xl border border-neutral-200 p-8 sm:p-14 shadow-subtle text-center max-w-3xl mx-auto my-6">
        
        <div class="w-20 h-20 bg-neutral-100 text-neutral-800 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm">
            <?php echo alex_store_svg_icon('cart', 'w-10 h-10 text-neutral-700'); ?>
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight mb-2">
            <?php esc_html_e('Tu carrito de compras está vacío', 'alex-store'); ?>
        </h1>

        <p class="text-xs sm:text-sm text-neutral-500 max-w-md mx-auto mb-8 leading-relaxed">
            <?php esc_html_e('No tienes ningún artículo en tu carrito. Explora nuestras ofertas en celulares, laptops, gaming y accesorios con financiamiento Credex.', 'alex-store'); ?>
        </p>

        <?php if (wc_get_page_id('shop') > 0) : ?>
            <div class="flex items-center justify-center gap-4 flex-wrap">
                <a href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" class="button ubx-btn-primary py-3.5 px-8 text-sm font-bold">
                    <span><?php esc_html_e('Explorar Productos & Ofertas', 'alex-store'); ?></span>
                    <?php echo alex_store_svg_icon('arrow-right', 'w-4 h-4'); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>

    <!-- Suggested Products to Fill the Cart -->
    <?php
    $featured_products = wc_get_products([
        'limit'   => 4,
        'status'  => 'publish',
        'orderby' => 'popularity',
    ]);

    if (!empty($featured_products)) :
    ?>
        <div class="mt-14 pt-8 border-t border-neutral-200">
            <div class="mb-6">
                <h3 class="text-xl sm:text-2xl font-bold text-neutral-900 tracking-tight">
                    <?php esc_html_e('Artículos Populares para Ti', 'alex-store'); ?>
                </h3>
                <p class="text-xs text-neutral-500">
                    <?php esc_html_e('Los productos de tecnología más vendidos esta semana', 'alex-store'); ?>
                </p>
            </div>

            <ul class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 p-0 m-0 list-none">
                <?php foreach ($featured_products as $p) : ?>
                    <?php echo alex_store_product_card($p); ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>

<?php do_action('woocommerce_cart_is_empty'); ?>
