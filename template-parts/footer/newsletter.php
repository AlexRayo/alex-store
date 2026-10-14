<?php
/**
 * Newsletter Component (Dynamic Primary Dark Color)
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="bg-primary text-white py-12 px-4 sm:px-6 lg:px-8 border-t border-white/10">
    <div class="max-w-4xl mx-auto text-center">
        <span class="inline-block bg-white/10 text-white text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-3 border border-white/20">
            <?php esc_html_e('Ofertas & Novedades', 'alex-store'); ?>
        </span>
        <h3 class="text-2xl sm:text-3xl font-black text-white mb-2 tracking-tight">
            <?php esc_html_e('Suscríbete a nuestro boletín tecnológico', 'alex-store'); ?>
        </h3>
        <p class="text-xs sm:text-sm text-white/80 max-w-lg mx-auto mb-6">
            <?php esc_html_e('Recibe lanzamientos de nuevos productos, promociones exclusivas y avisos de stock antes que nadie.', 'alex-store'); ?>
        </p>

        <form class="max-w-md mx-auto flex flex-col sm:flex-row gap-2" onsubmit="event.preventDefault(); alert('¡Gracias por suscribirte!');">
            <input 
                type="email" 
                placeholder="<?php esc_attr_e('Tu correo electrónico...', 'alex-store'); ?>" 
                required
                class="flex-1 px-4 py-3 bg-black/20 text-white text-sm rounded-xl outline-none focus:ring-1 focus:ring-white border border-white/20 placeholder-white/50"
            />
            <button type="submit" class="bg-white hover:bg-neutral-100 text-neutral-950 font-bold py-3 px-6 rounded-xl text-xs sm:text-sm transition-colors shadow-md">
                <?php esc_html_e('Suscribirme', 'alex-store'); ?>
            </button>
        </form>
    </div>
</div>
