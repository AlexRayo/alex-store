<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main max-w-3xl mx-auto px-4 py-20 text-center">
    <div class="bg-white rounded-3xl border border-neutral-border p-8 sm:p-14 shadow-card">
        <span class="text-7xl font-black text-primary block mb-2">404</span>
        <h1 class="text-2xl sm:text-3xl font-black text-dark tracking-tight mb-3">
            <?php esc_html_e('¡Ups! Página no encontrada', 'alex-store'); ?>
        </h1>
        <p class="text-sm text-neutral-subtle max-w-md mx-auto mb-8">
            <?php esc_html_e('La página o el producto que buscas ya no está disponible o ha cambiado de dirección.', 'alex-store'); ?>
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="ubx-btn-primary py-3 px-6">
                <?php esc_html_e('Volver al Inicio', 'alex-store'); ?>
            </a>
            <a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('shop')) : esc_url(home_url('/shop')); ?>" class="ubx-btn-outline py-3 px-6">
                <?php esc_html_e('Explorar Tienda', 'alex-store'); ?>
            </a>
        </div>
    </div>
</main>

<?php
get_footer();
