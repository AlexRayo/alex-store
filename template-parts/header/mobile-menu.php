<?php
/**
 * Mobile Slide-over Menu Drawer
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

$categories = [];
if (class_exists('WooCommerce')) {
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'number'     => 12,
    ]);
}
?>

<div 
    id="alex-mobile-menu-overlay" 
    class="hidden fixed inset-0 bg-dark/60 backdrop-blur-sm z-[999] opacity-0 pointer-events-none transition-opacity duration-300"
    aria-hidden="true"
>
    <div 
        id="alex-mobile-menu-drawer" 
        class="fixed top-0 left-0 h-full w-full max-w-xs bg-white shadow-drawer z-[1000] flex flex-col transform -translate-x-full transition-transform duration-300 ease-out"
        role="dialog"
        aria-modal="true"
    >
        <!-- Header -->
        <div class="p-4 border-b border-neutral-border flex items-center justify-between bg-primary-50">
            <span class="text-base font-black text-dark tracking-tight">
                ALEX<span class="text-primary">STORE</span>
            </span>
            <button 
                type="button" 
                id="alex-close-mobile-menu" 
                class="p-2 text-neutral-subtle hover:text-dark rounded-xl hover:bg-white transition-colors"
                aria-label="<?php esc_attr_e('Cerrar menú', 'alex-store'); ?>"
            >
                <?php echo alex_store_svg_icon('close', 'w-5 h-5'); ?>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 overflow-y-auto p-4 space-y-6">
            
            <!-- Standard Menu -->
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-subtle mb-3">
                    <?php esc_html_e('Navegación', 'alex-store'); ?>
                </h4>
                <?php
                if (has_nav_menu('mobile-menu') || has_nav_menu('primary-menu')) {
                    wp_nav_menu([
                        'theme_location' => has_nav_menu('mobile-menu') ? 'mobile-menu' : 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'space-y-1 text-sm font-semibold text-dark',
                        'fallback_cb'    => false,
                    ]);
                } else {
                ?>
                    <ul class="space-y-1 text-sm font-semibold text-dark">
                        <li>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="block py-2 px-3 rounded-xl hover:bg-primary-50 hover:text-primary transition-colors">
                                <?php esc_html_e('Inicio', 'alex-store'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('shop')) : esc_url(home_url('/shop')); ?>" class="block py-2 px-3 rounded-xl hover:bg-primary-50 hover:text-primary transition-colors">
                                <?php esc_html_e('Tienda Completa', 'alex-store'); ?>
                            </a>
                        </li>
                    </ul>
                <?php } ?>
            </div>

            <!-- Categories Section -->
            <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                <div class="border-t border-neutral-border pt-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-subtle mb-3">
                        <?php esc_html_e('Categorías Populares', 'alex-store'); ?>
                    </h4>
                    <ul class="space-y-1 text-sm font-medium text-dark">
                        <?php foreach ($categories as $cat) : 
                            if ($cat->slug === 'uncategorized' || $cat->slug === 'sin-categorizar') continue;
                        ?>
                            <li>
                                <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="flex items-center justify-between py-2 px-3 rounded-xl hover:bg-primary-50 hover:text-primary transition-colors">
                                    <span><?php echo esc_html($cat->name); ?></span>
                                    <span class="text-xs text-neutral-subtle">(<?php echo esc_html($cat->count); ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Contact & Help -->
            <div class="border-t border-neutral-border pt-4">
                <a 
                    href="https://wa.me/50671682181?text=Hola,%20quisiera%20consultar%20sobre%20un%20producto" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="flex items-center justify-center gap-2 bg-[#25D366] text-white font-bold py-2.5 px-4 rounded-xl shadow-sm text-sm"
                >
                    <?php echo alex_store_svg_icon('whatsapp', 'w-5 h-5'); ?>
                    <span><?php esc_html_e('Atención por WhatsApp', 'alex-store'); ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
