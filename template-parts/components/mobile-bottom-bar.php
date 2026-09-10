<?php
/**
 * Mobile Bottom Sticky Navigation Bar
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart_count  = (class_exists('WooCommerce') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
$account_url = function_exists('wc_get_account_endpoint_url') ? wc_get_page_permalink('myaccount') : wp_login_url();
$shop_url    = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
?>

<div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-lg border-t border-neutral-border py-2 px-3 shadow-[0_-4px_20px_rgba(0,0,0,0.06)]">
    <div class="flex items-center justify-around">
        
        <!-- Home -->
        <a 
            href="<?php echo esc_url(home_url('/')); ?>" 
            class="flex flex-col items-center gap-0.5 text-neutral-subtle hover:text-primary transition-colors text-[10px] font-bold"
        >
            <span class="p-1">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </span>
            <span><?php esc_html_e('Inicio', 'alex-store'); ?></span>
        </a>

        <!-- Categories / Shop -->
        <a 
            href="<?php echo esc_url($shop_url); ?>" 
            class="flex flex-col items-center gap-0.5 text-neutral-subtle hover:text-primary transition-colors text-[10px] font-bold"
        >
            <span class="p-1">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
            </span>
            <span><?php esc_html_e('Catálogo', 'alex-store'); ?></span>
        </a>

        <!-- Search Modal Button -->
        <button 
            type="button" 
            data-action="open-search-modal"
            class="flex flex-col items-center gap-0.5 text-neutral-subtle hover:text-primary transition-colors text-[10px] font-bold"
        >
            <span class="p-1">
                <?php echo alex_store_svg_icon('search', 'w-5 h-5'); ?>
            </span>
            <span><?php esc_html_e('Buscar', 'alex-store'); ?></span>
        </button>

        <!-- Account -->
        <a 
            href="<?php echo esc_url($account_url); ?>" 
            class="flex flex-col items-center gap-0.5 text-neutral-subtle hover:text-primary transition-colors text-[10px] font-bold"
        >
            <span class="p-1">
                <?php echo alex_store_svg_icon('user', 'w-5 h-5'); ?>
            </span>
            <span><?php esc_html_e('Cuenta', 'alex-store'); ?></span>
        </a>

        <!-- Cart Drawer Trigger -->
        <button 
            type="button" 
            data-action="open-cart-drawer"
            class="flex flex-col items-center gap-0.5 text-neutral-subtle hover:text-primary transition-colors text-[10px] font-bold relative"
        >
            <div class="relative p-1">
                <?php echo alex_store_svg_icon('cart', 'w-5 h-5'); ?>
                <span class="alex-cart-count-badge tech-cart-count-badge <?php echo $cart_count > 0 ? '' : 'hidden'; ?> absolute top-0 right-0 bg-accent text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center border border-white">
                    <?php echo absint($cart_count); ?>
                </span>
            </div>
            <span><?php esc_html_e('Carrito', 'alex-store'); ?></span>
        </button>
    </div>
</div>
