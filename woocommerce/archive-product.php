<?php
/**
 * The Template for displaying product archives (Full Width Grid without Aside)
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Determine columns class from Customizer
$shop_cols  = get_theme_mod('tech_shop_columns', '4');
$cols_class = 'lg:grid-cols-4';
if ($shop_cols === '3') {
    $cols_class = 'lg:grid-cols-3';
} elseif ($shop_cols === '5') {
    $cols_class = 'lg:grid-cols-5';
}
?>

<div class="site-container py-6">
    
    <!-- Breadcrumbs -->
    <?php woocommerce_breadcrumb(); ?>

    <!-- Seasonal Promotional Banner (if enabled for shop/all) -->
    <?php get_template_part('template-parts/components/promo-banner'); ?>

    <!-- Archive Title & Description (Dynamic bg-primary Header) -->
    <header class="woocommerce-products-header mb-8 bg-primary text-white p-6 sm:p-8 rounded-3xl shadow-sm border border-white/10 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="woocommerce-products-header__title page-title text-2xl sm:text-3xl font-black tracking-tight text-white mb-2 capitalize">
                <?php woocommerce_page_title(); ?>
            </h1>
            <div class="text-white/80 text-xs sm:text-sm">
                <?php do_action('woocommerce_archive_description'); ?>
            </div>
        </div>
    </header>

    <!-- Full-Width Products Area -->
    <div class="w-full">
        
        <?php if (woocommerce_product_loop()) : ?>

            <!-- Toolbar (Results count + Ordering) -->
            <div class="bg-white p-4 rounded-2xl border border-neutral-200 mb-6 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-subtle">
                <div class="text-xs font-medium text-neutral-500">
                    <?php woocommerce_result_count(); ?>
                </div>
                <div class="w-full sm:w-auto text-xs">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
            </div>

            <!-- Products Grid (Dynamic columns: 3, 4, or 5) -->
            <?php woocommerce_product_loop_start(); ?>

            <ul id="collection" class="grid grid-cols-2 md:grid-cols-3 <?php echo esc_attr($cols_class); ?> gap-4 sm:gap-6 p-0 m-0 list-none">
                <?php
                while (have_posts()) : the_post();
                    do_action('woocommerce_shop_loop');
                    global $product;
                    echo alex_store_product_card($product);
                endwhile;
                ?>
            </ul>

            <?php woocommerce_product_loop_end(); ?>

            <!-- Pagination -->
            <div class="mt-10 flex justify-center">
                <?php do_action('woocommerce_after_shop_loop'); ?>
            </div>

        <?php else : ?>
            <div class="bg-white rounded-3xl border border-neutral-200 p-12 text-center shadow-subtle">
                <div class="w-16 h-16 bg-neutral-100 text-neutral-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <?php echo alex_store_svg_icon('search', 'w-8 h-8'); ?>
                </div>
                <h2 class="text-lg font-bold text-neutral-900 mb-2">
                    <?php esc_html_e('No se encontraron productos', 'alex-store'); ?>
                </h2>
                <p class="text-xs text-neutral-500 mb-6 max-w-sm mx-auto">
                    <?php esc_html_e('No hay productos que coincidan con los criterios seleccionados.', 'alex-store'); ?>
                </p>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ubx-btn-primary">
                    <?php esc_html_e('Ver todo el catálogo', 'alex-store'); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
