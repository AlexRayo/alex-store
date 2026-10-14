<?php
/**
 * Seasonal / Event Promotional Banner Component (Dynamic Primary Color)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

$enable_banner = get_theme_mod('alex_promo_banner_enable', get_theme_mod('tech_promo_banner_enable', false));
if (!$enable_banner) {
    return;
}

$location     = get_theme_mod('alex_promo_banner_location', get_theme_mod('tech_promo_banner_location', 'home'));
$is_home_page = is_front_page() || is_home();
$is_shop_page = function_exists('is_shop') && (is_shop() || is_product_taxonomy());

if ($location === 'home' && !$is_home_page) {
    return;
}
if ($location === 'shop' && !$is_shop_page) {
    return;
}

$banner_img   = get_theme_mod('alex_promo_banner_image', get_theme_mod('tech_promo_banner_image', ''));
$badge        = get_theme_mod('alex_promo_banner_badge', get_theme_mod('tech_promo_banner_badge', __('Promoción Especial por Tiempo Limitado', 'alex-store')));
$badge_clean  = preg_replace('/[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}]/u', '', $badge);
$title        = get_theme_mod('alex_promo_banner_title', get_theme_mod('tech_promo_banner_title', __('Hasta 40% OFF en Celulares & Gaming', 'alex-store')));
$subtitle     = get_theme_mod('alex_promo_banner_subtitle', get_theme_mod('tech_promo_banner_subtitle', __('Aprovecha descuentos únicos con entrega rápida en todo el país y financiamiento Credex sin intereses.', 'alex-store')));
$btn_text     = get_theme_mod('alex_promo_banner_btn_text', get_theme_mod('tech_promo_banner_btn_text', __('Ver Ofertas Especiales', 'alex-store')));
$btn_link     = get_theme_mod('alex_promo_banner_btn_link', get_theme_mod('tech_promo_banner_btn_link', ''));
if (empty($btn_link)) {
    $btn_link = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
}
?>

<div class="site-container my-6">
    <div class="relative bg-primary text-white rounded-3xl p-6 sm:p-10 lg:p-12 overflow-hidden shadow-card border border-white/10 flex flex-col md:flex-row items-center justify-between gap-6">
        
        <?php if (!empty($banner_img)) : ?>
            <img src="<?php echo esc_url($banner_img); ?>" alt="<?php echo esc_attr($title); ?>" class="absolute inset-0 w-full h-full object-cover pointer-events-none z-0" />
            <div class="absolute inset-0 bg-gradient-to-r from-black/75 to-black/50 pointer-events-none z-[1]" aria-hidden="true"></div>
        <?php else : ?>
            <!-- Ambient blurred lighting -->
            <div class="absolute -right-16 -top-16 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-80 h-80 bg-black/20 rounded-full blur-3xl pointer-events-none"></div>
        <?php endif; ?>

        <div class="relative z-10 max-w-2xl text-center md:text-left">
            <?php if (!empty($badge_clean)) : ?>
                <span class="inline-flex items-center gap-1.5 bg-black/30 backdrop-blur-md text-white text-xs font-semibold uppercase px-3 py-1 rounded-full mb-3 border border-white/20">
                    <?php echo alex_store_svg_icon('flame', 'w-3.5 h-3.5 text-amber-400'); ?>
                    <span><?php echo esc_html(trim($badge_clean)); ?></span>
                </span>
            <?php endif; ?>

            <?php if (!empty($title)) : ?>
                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight leading-tight mb-2">
                    <?php echo esc_html($title); ?>
                </h3>
            <?php endif; ?>

            <?php if (!empty($subtitle)) : ?>
                <p class="text-xs sm:text-sm text-white/80 font-normal leading-relaxed">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="relative z-10 flex-shrink-0">
            <a href="<?php echo esc_url($btn_link); ?>" class="bg-white hover:bg-neutral-100 text-neutral-950 font-bold px-6 py-3.5 rounded-xl text-xs sm:text-sm shadow-md transition-all inline-flex items-center gap-2">
                <span><?php echo esc_html($btn_text); ?></span>
                <?php echo alex_store_svg_icon('arrow-right', 'w-4 h-4'); ?>
            </a>
        </div>
    </div>
</div>
