<?php
/**
 * Slide-over Cart Drawer Component
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<!-- Cart Drawer Overlay -->
<div 
    id="alex-cart-drawer-overlay" 
    class="hidden fixed inset-0 bg-dark/60 backdrop-blur-sm z-[999] opacity-0 pointer-events-none transition-opacity duration-300"
    aria-hidden="true"
>
    <!-- Cart Drawer Panel -->
    <div 
        id="alex-cart-drawer-panel" 
        class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-drawer z-[1000] flex flex-col transform translate-x-full transition-transform duration-300 ease-out"
        role="dialog" 
        aria-modal="true" 
        aria-label="<?php esc_attr_e('Carrito de Compras', 'alex-store'); ?>"
    >
        <!-- Header -->
        <div class="px-5 py-4 border-b border-neutral-border flex items-center justify-between bg-white">
            <div class="flex items-center gap-2">
                <span class="text-primary font-bold">
                    <?php echo alex_store_svg_icon('cart', 'w-5 h-5'); ?>
                </span>
                <h3 class="text-base font-black text-dark tracking-tight">
                    <?php esc_html_e('Tu Carrito', 'alex-store'); ?>
                </h3>
            </div>
            <button 
                type="button" 
                data-action="close-cart-drawer" 
                class="p-2 text-neutral-subtle hover:text-dark rounded-xl hover:bg-neutral-100 transition-colors"
                aria-label="<?php esc_attr_e('Cerrar carrito', 'alex-store'); ?>"
            >
                <?php echo alex_store_svg_icon('close', 'w-5 h-5'); ?>
            </button>
        </div>

        <!-- Dynamic Cart Content Loaded by PHP / AJAX -->
        <div id="alex-cart-drawer-items" class="flex-1 flex flex-col overflow-hidden">
            <?php echo alex_store_get_cart_drawer_items_html(); ?>
        </div>
    </div>
</div>
