<?php
/**
 * Top Announcement Bar Component (Customizer-enabled)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

$show_announcement = get_theme_mod('alex_show_announcement', get_theme_mod('tech_show_announcement', true));
if (!$show_announcement) {
    return;
}

$announcement_text = get_theme_mod('alex_announcement_text', get_theme_mod('tech_announcement_text', __('💳 3 meses 0% intereses con Credex | Envíos rápidos y seguros a todo el país', 'alex-store')));
?>
<div id="alex-announcement-bar" class="bg-neutral-900 text-neutral-200 text-xs font-medium py-2 px-4 relative z-50 border-b border-neutral-800">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex-1 text-center truncate px-6">
            <span class="inline-flex items-center gap-2">
                <span><?php echo esc_html($announcement_text); ?></span>
            </span>
        </div>
        <button 
            type="button" 
            id="alex-close-announcement" 
            class="text-neutral-400 hover:text-white p-1 rounded-full hover:bg-neutral-800 transition-colors"
            aria-label="<?php esc_attr_e('Cerrar anuncio', 'alex-store'); ?>"
        >
            <?php echo alex_store_svg_icon('close', 'w-3.5 h-3.5'); ?>
        </button>
    </div>
</div>
