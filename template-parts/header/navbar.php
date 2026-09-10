<?php
/**
 * Main Navbar Component (Unfilled Cart Icon & Clean Layout in All Views)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart_count   = (class_exists('WooCommerce') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
$account_url  = function_exists('wc_get_account_endpoint_url') ? wc_get_page_permalink('myaccount') : wp_login_url();
$cart_url     = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart');
?>

<div class="border-b border-neutral-200/80 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- =========================================================
             1. DESKTOP VIEW (lg:flex single bar)
             ========================================================= -->
        <div class="hidden lg:flex items-center justify-between h-20 gap-8">
            
            <!-- Brand / Logo -->
            <div class="flex-shrink-0 flex items-center">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2.5">
                        <span class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-bold text-lg shadow-sm">
                            MR
                        </span>
                        <div class="flex flex-col">
                            <span class="text-xl font-black tracking-tight text-neutral-900 uppercase">
                                MR<span class="text-neutral-500">SOLUCIONES</span>
                            </span>
                            <span class="text-[9px] uppercase tracking-widest text-neutral-400 font-semibold -mt-1">
                                <?php esc_html_e('Tecnología a tu alcance', 'alex-store'); ?>
                            </span>
                        </div>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Central Live Search Bar (Desktop) -->
            <div class="flex-1 max-w-2xl relative alex-search-wrapper tech-search-wrapper">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="w-full relative">
                    <input type="hidden" name="post_type" value="product" />
                    <div class="relative flex items-center">
                        <input 
                            type="search" 
                            name="s" 
                            placeholder="<?php esc_attr_e('Buscar en MR Soluciones... (ej. Celulares, Laptops, Audio)', 'alex-store'); ?>" 
                            class="alex-live-search-input tech-live-search-input w-full pl-5 pr-14 py-3 bg-neutral-100/90 hover:bg-neutral-100 focus:bg-white text-neutral-900 text-sm rounded-2xl border border-neutral-200 focus:border-primary focus:ring-1 focus:ring-primary transition-all outline-none"
                            autocomplete="off"
                        />
                        <button 
                            type="submit" 
                            class="absolute right-1.5 p-2.5 bg-cta hover:bg-cta-hover text-white rounded-xl transition-colors shadow-sm"
                            aria-label="<?php esc_attr_e('Buscar', 'alex-store'); ?>"
                        >
                            <?php echo alex_store_svg_icon('search', 'w-4 h-4'); ?>
                        </button>
                    </div>
                </form>

                <!-- Live Predictive Results Dropdown Container -->
                <div class="alex-search-results tech-search-results hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-dropdown border border-neutral-200 z-50 max-h-96 overflow-y-auto"></div>
            </div>

            <!-- Desktop Actions (Account & Clean Unfilled Cart) -->
            <div class="flex items-center gap-3">
                <!-- Account -->
                <a 
                    href="<?php echo esc_url($account_url); ?>" 
                    class="flex items-center gap-2 p-2.5 text-neutral-800 hover:text-black rounded-xl hover:bg-neutral-100 transition-colors text-xs font-semibold"
                >
                    <span class="p-1.5 bg-neutral-100 text-neutral-800 rounded-lg">
                        <?php echo alex_store_svg_icon('user', 'w-5 h-5'); ?>
                    </span>
                    <span class="hidden xl:inline-block">
                        <span class="text-[10px] text-neutral-400 block font-normal leading-none mb-0.5">
                            <?php echo is_user_logged_in() ? esc_html__('Mi Cuenta', 'alex-store') : esc_html__('Bienvenido', 'alex-store'); ?>
                        </span>
                        <?php echo is_user_logged_in() ? esc_html__('Perfil', 'alex-store') : esc_html__('Iniciar Sesión', 'alex-store'); ?>
                    </span>
                </a>

                <!-- Clean Unfilled Cart Button -->
                <button 
                    type="button" 
                    data-action="open-cart-drawer"
                    class="relative p-2.5 text-neutral-900 hover:bg-neutral-100 rounded-xl transition-colors flex items-center gap-2 font-bold text-xs"
                    aria-label="<?php esc_attr_e('Ver Carrito', 'alex-store'); ?>"
                >
                    <div class="relative">
                        <?php echo alex_store_svg_icon('cart', 'w-6 h-6'); ?>
                        <span class="alex-cart-count-badge tech-cart-count-badge <?php echo $cart_count > 0 ? '' : 'hidden'; ?> absolute -top-1.5 -right-2 bg-cta text-white text-[10px] font-black w-4.5 h-4.5 rounded-full flex items-center justify-center shadow-sm">
                            <?php echo absint($cart_count); ?>
                        </span>
                    </div>
                    <span class="hidden sm:inline-block">
                        <?php esc_html_e('Carrito', 'alex-store'); ?>
                    </span>
                </button>
            </div>
        </div>

        <!-- =========================================================
             2. SMARTPHONE / MOBILE VIEW (Amazon.com Inspired Header)
             ========================================================= -->
        <div class="lg:hidden flex flex-col py-2.5">
            
            <!-- Mobile Row 1: [Menu ☰] [Logo MR Soluciones] [Ingresar › 👤] [Cart 🛒 (Count)] -->
            <div class="flex items-center justify-between gap-3 h-12">
                
                <!-- Left: Mobile Menu Trigger + Brand -->
                <div class="flex items-center gap-2.5">
                    <button 
                        type="button" 
                        id="alex-mobile-menu-toggle" 
                        class="p-2 -ml-1 text-neutral-900 hover:bg-neutral-100 rounded-xl transition-colors"
                        aria-label="<?php esc_attr_e('Abrir menú', 'alex-store'); ?>"
                    >
                        <?php echo alex_store_svg_icon('menu', 'w-6 h-6'); ?>
                    </button>

                    <!-- Logo -->
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            MR
                        </span>
                        <span class="text-base font-black tracking-tight text-neutral-900 uppercase">
                            MR<span class="text-neutral-500">SOLUCIONES</span>
                        </span>
                    </a>
                </div>

                <!-- Right: Account & Unfilled Cart Buttons -->
                <div class="flex items-center gap-2">
                    
                    <!-- Mobile Account Link -->
                    <a 
                        href="<?php echo esc_url($account_url); ?>" 
                        class="flex items-center gap-1 text-xs font-semibold text-neutral-800 hover:text-black py-1.5 px-2 rounded-lg hover:bg-neutral-100 transition-colors"
                    >
                        <span class="text-[11px] font-medium hidden xs:inline text-neutral-600">
                            <?php echo is_user_logged_in() ? esc_html__('Perfil', 'alex-store') : esc_html__('Ingresar ›', 'alex-store'); ?>
                        </span>
                        <?php echo alex_store_svg_icon('user', 'w-5 h-5'); ?>
                    </a>

                    <!-- Mobile Unfilled Cart Trigger with Floating Numerical Badge -->
                    <button 
                        type="button" 
                        data-action="open-cart-drawer"
                        class="relative p-2 text-neutral-900 hover:bg-neutral-100 rounded-xl transition-colors flex items-center justify-center"
                        aria-label="<?php esc_attr_e('Ver Carrito', 'alex-store'); ?>"
                    >
                        <?php echo alex_store_svg_icon('cart', 'w-6 h-6'); ?>
                        <span class="alex-cart-count-badge tech-cart-count-badge <?php echo $cart_count > 0 ? '' : 'hidden'; ?> absolute top-0.5 right-0.5 bg-cta text-white text-[10px] font-black w-4.5 h-4.5 rounded-full flex items-center justify-center shadow-sm">
                            <?php echo absint($cart_count); ?>
                        </span>
                    </button>

                </div>

            </div>

            <!-- Mobile Row 2: Full-Width Amazon-style Search Bar -->
            <div class="pt-2 pb-1 relative alex-search-wrapper tech-search-wrapper w-full">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="w-full relative">
                    <input type="hidden" name="post_type" value="product" />
                    <div class="relative flex items-center">
                        <input 
                            type="search" 
                            name="s" 
                            placeholder="<?php esc_attr_e('Buscar en MR Soluciones... (ej. Celulares, Laptops)', 'alex-store'); ?>" 
                            class="alex-live-search-input tech-live-search-input w-full pl-4 pr-12 py-2.5 bg-neutral-100 hover:bg-white focus:bg-white text-neutral-900 text-xs sm:text-sm rounded-2xl border border-neutral-300 focus:border-primary shadow-sm outline-none transition-all"
                            autocomplete="off"
                        />
                        <button 
                            type="submit" 
                            class="absolute right-1 top-1 bottom-1 px-3 bg-cta hover:bg-cta-hover text-white rounded-xl shadow-sm transition-colors flex items-center justify-center"
                            aria-label="<?php esc_attr_e('Buscar', 'alex-store'); ?>"
                        >
                            <?php echo alex_store_svg_icon('search', 'w-4 h-4'); ?>
                        </button>
                    </div>
                </form>

                <!-- Mobile Live Predictive Dropdown -->
                <div class="alex-search-results tech-search-results hidden absolute top-full left-0 right-0 mt-1 bg-white rounded-2xl shadow-dropdown border border-neutral-200 z-50 max-h-80 overflow-y-auto"></div>
            </div>

        </div>

    </div>
</div>
