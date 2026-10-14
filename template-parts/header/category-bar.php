<?php
/**
 * Category Navigation Bar Component (Neutral Monochrome Edition)
 *
 * @package TechStore
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
        'orderby'    => 'count',
        'order'      => 'DESC',
    ]);
}
?>

<div class="bg-white border-b border-neutral-200/60 py-2.5 shadow-subtle overflow-hidden">
    <div class="site-container">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
            
            <!-- All / Catalog Pill -->
            <a 
                href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('shop')) : esc_url(home_url('/shop')); ?>" 
                class="ubx-pill-tab flex items-center gap-1.5 font-semibold text-neutral-900 bg-neutral-100 hover:bg-neutral-900 hover:text-white"
            >
                <?php echo alex_store_svg_icon('sparkles', 'w-3.5 h-3.5 text-amber-500'); ?>
                <span><?php esc_html_e('Todos los Productos', 'alex-store'); ?></span>
            </a>

            <!-- Dynamic Category Pills from WooCommerce -->
            <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                <?php foreach ($categories as $cat) : 
                    if ($cat->slug === 'uncategorized' || $cat->slug === 'sin-categorizar') continue;
                    $is_current = is_tax('product_cat', $cat->term_id);
                ?>
                    <a 
                        href="<?php echo esc_url(get_term_link($cat)); ?>" 
                        class="ubx-pill-tab <?php echo $is_current ? 'active' : ''; ?>"
                    >
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Categorías canónicas de MR Soluciones -->
                <?php
                $sample_cats = [
                    __('Celulares', 'alex-store'),
                    __('Computadoras', 'alex-store'),
                    __('Audífonos', 'alex-store'),
                    __('Audio y Video', 'alex-store'),
                    __('Gaming', 'alex-store'),
                    __('Monitores', 'alex-store'),
                    __('Almacenamiento', 'alex-store'),
                    __('Cámaras de Vigilancia', 'alex-store'),
                    __('Relojes Inteligentes', 'alex-store'),
                    __('Tablets', 'alex-store'),
                    __('Accesorios', 'alex-store'),
                ];
                foreach ($sample_cats as $sample) :
                ?>
                    <a href="<?php echo esc_url(home_url('/?s=' . urlencode($sample) . '&post_type=product')); ?>" class="ubx-pill-tab">
                        <?php echo esc_html($sample); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
