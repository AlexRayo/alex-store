<?php
/**
 * Search Modal Component
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div 
    id="alex-search-modal" 
    class="hidden fixed inset-0 bg-dark/70 backdrop-blur-md z-[999] flex flex-col justify-start p-4 sm:p-6 md:p-12 overflow-y-auto"
    role="dialog" 
    aria-modal="true"
>
    <div class="max-w-2xl w-full mx-auto bg-white rounded-3xl shadow-modal overflow-hidden alex-search-wrapper tech-search-wrapper">
        <!-- Search Header -->
        <div class="p-4 border-b border-neutral-border flex items-center gap-3">
            <span class="text-primary pl-2">
                <?php echo alex_store_svg_icon('search', 'w-5 h-5'); ?>
            </span>
            <input 
                type="search" 
                placeholder="<?php esc_attr_e('Escribe el nombre del producto...', 'alex-store'); ?>" 
                class="alex-live-search-input tech-live-search-input flex-1 py-2 text-base text-dark placeholder-neutral-subtle outline-none border-0 focus:ring-0"
                autocomplete="off"
            />
            <button 
                type="button" 
                id="alex-close-search-modal" 
                class="p-2 text-neutral-subtle hover:text-dark rounded-xl hover:bg-neutral-100 transition-colors"
                aria-label="<?php esc_attr_e('Cerrar buscador', 'alex-store'); ?>"
            >
                <?php echo alex_store_svg_icon('close', 'w-5 h-5'); ?>
            </button>
        </div>

        <!-- Live Results Container -->
        <div class="alex-search-results tech-search-results max-h-[60vh] overflow-y-auto p-2"></div>
    </div>
</div>
