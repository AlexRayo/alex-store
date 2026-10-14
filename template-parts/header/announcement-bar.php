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

$announcement_text = get_theme_mod('alex_announcement_text', get_theme_mod('tech_announcement_text', __('3 meses 0% intereses con Credex | Envíos rápidos y seguros a todo el país', 'alex-store')));
// Strip any legacy emojis if saved in DB
$announcement_clean = preg_replace('/[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}]/u', '', $announcement_text);
?>
<div id="alex-announcement-bar" class="bg-neutral-900 text-neutral-200 text-xs font-medium py-2 px-4 relative z-50 border-b border-neutral-800">
    <div class="site-container flex items-center justify-between">
        <div class="flex-1 text-center truncate px-6">
            <span class="inline-flex items-center justify-center gap-1.5">
                <?php echo alex_store_svg_icon('credit', 'w-3.5 h-3.5 text-neutral-400 inline-block shrink-0'); ?>
                <span><?php echo esc_html(trim($announcement_clean)); ?></span>
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
