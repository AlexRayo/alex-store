<?php
/**
 * Template Helper Functions & Tags (Primary Color Sale Badges & Capitalize Edition)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Helper to Capitalize text cleanly (UTF-8 safe)
 */
function alex_store_capitalize_text($text) {
    if (empty($text)) return '';
    return mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');
}
function tech_store_capitalize_text($text) { return alex_store_capitalize_text($text); }

/**
 * Returns inline SVG icons
 */
function alex_store_svg_icon($name, $classes = 'w-5 h-5') {
    $icons = [
        'cart' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>',
        'search' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>',
        'user' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'heart' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>',
        'truck' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18.5" r="2.5"/><circle cx="7" cy="18.5" r="2.5"/></svg>',
        'shield' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>',
        'award' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>',
        'headphones' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/></svg>',
        'star' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'close' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>',
        'menu' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>',
        'chevron-right' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>',
        'chevron-down' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>',
        'plus' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>',
        'minus' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>',
        'trash' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>',
        'arrow-right' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>',
        'filter' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>',
        'check' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
        'whatsapp' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="currentColor"><path d="M12.031 0C5.397 0 .017 5.38.017 12.014c0 2.118.552 4.185 1.602 6.007L.001 24l6.155-1.614a11.968 11.968 0 0 0 5.875 1.53h.005c6.633 0 12.013-5.38 12.013-12.014 0-3.208-1.25-6.223-3.518-8.491A11.933 11.933 0 0 0 12.031 0zm0 21.96a9.927 9.927 0 0 1-5.06-1.385l-.363-.215-3.76.986.999-3.666-.236-.376A9.923 9.923 0 0 1 2.062 12.01c0-5.498 4.473-9.972 9.974-9.972 2.664 0 5.168 1.038 7.051 2.92a9.914 9.914 0 0 1 2.923 7.056c0 5.498-4.474 9.972-9.979 9.972zm5.466-7.469c-.3-.15-1.774-.875-2.049-.975-.274-.1-.474-.15-.674.15s-.774.975-.95 1.175-.35.225-.65.075c-.3-.15-1.267-.467-2.413-1.489-.892-.796-1.494-1.78-1.669-2.08-.175-.3-.019-.462.131-.611.135-.135.3-.35.45-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525s-.674-1.625-.924-2.225c-.244-.585-.493-.506-.674-.515-.175-.009-.375-.011-.575-.011s-.525.075-.8.375c-.275.3-1.05 1.025-1.05 2.5s1.075 2.899 1.225 3.1c.15.2 2.115 3.23 5.125 4.529.716.309 1.275.494 1.71.633.72.229 1.375.197 1.893.12.578-.086 1.774-.725 2.024-1.425.25-.7.25-1.3.175-1.425-.075-.125-.275-.2-.575-.35z"/></svg>',
        'credit' => '<svg class="' . esc_attr($classes) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>',
    ];

    return isset($icons[$name]) ? $icons[$name] : '';
}
function tech_store_svg_icon($name, $classes = 'w-5 h-5') { return alex_store_svg_icon($name, $classes); }

/**
 * Calculate discount percentage
 */
function alex_store_get_discount_percentage($product) {
    if (!$product || !$product->is_on_sale()) {
        return 0;
    }

    if ($product->is_type('variable')) {
        $available_variations = $product->get_available_variations();
        $max_percentage = 0;
        foreach ($available_variations as $variation) {
            if ($variation['display_regular_price'] > $variation['display_price']) {
                $percentage = round((($variation['display_regular_price'] - $variation['display_price']) / $variation['display_regular_price']) * 100);
                if ($percentage > $max_percentage) {
                    $max_percentage = $percentage;
                }
            }
        }
        return $max_percentage;
    }

    $regular_price = (float) $product->get_regular_price();
    $sale_price    = (float) $product->get_sale_price();

    if ($regular_price > 0 && $sale_price > 0 && $regular_price > $sale_price) {
        return round((($regular_price - $sale_price) / $regular_price) * 100);
    }

    return 0;
}
function tech_store_get_discount_percentage($product) { return alex_store_get_discount_percentage($product); }

/**
 * Render Clean Product Card (Sale Badge with Primary Brand Color)
 */
function alex_store_product_card($product, $args = []) {
    if (!$product) return '';

    if (is_numeric($product)) {
        $product = wc_get_product($product);
    }
    if (!$product) return '';

    $product_id      = $product->get_id();
    $permalink       = $product->get_permalink();
    $raw_title       = $product->get_name();
    $title           = alex_store_capitalize_text($raw_title);
    $price_html      = $product->get_price_html();
    $is_on_sale      = $product->is_on_sale();
    $discount_pct    = $is_on_sale ? alex_store_get_discount_percentage($product) : 0;
    $is_in_stock     = $product->is_in_stock();
    $image_id        = $product->get_image_id();
    $image_url       = $image_id ? wp_get_attachment_image_url($image_id, 'alex-product-card') : wc_placeholder_img_src('woocommerce_single');

    // Category
    $categories = wc_get_product_category_list($product_id, ', ', '<span class="text-[11px] uppercase font-semibold tracking-wider text-neutral-400 mb-1 block">', '</span>');

    ob_start();
    ?>
    <li class="product-card group ubx-card list-none h-full relative" data-product-id="<?php echo esc_attr($product_id); ?>">
        <!-- 1. FIGURE / IMAGEN -->
        <figure class="relative w-full h-48 md:h-52 bg-white flex items-center justify-center p-4 overflow-hidden border-b border-neutral-100">
            <?php if ($is_on_sale && $discount_pct > 0) : ?>
                <!-- Sale Badge with Primary Color (CMS configurable) -->
                <span class="badge-sale absolute top-2.5 left-2.5 z-10 bg-primary text-white text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded shadow-sm">
                    -<?php echo esc_html($discount_pct); ?>%
                </span>
            <?php endif; ?>

            <a href="<?php echo esc_url($permalink); ?>" class="block w-full h-full flex items-center justify-center">
                <img 
                    src="<?php echo esc_url($image_url); ?>" 
                    alt="<?php echo esc_attr($title); ?>" 
                    loading="lazy" 
                    class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105"
                />
            </a>

            <!-- Quick Add to Cart Button (bg-cta) -->
            <div class="absolute bottom-2.5 right-2.5 z-10 opacity-90 group-hover:opacity-100 transition-opacity">
                <?php if ($product->is_type('simple') && $is_in_stock) : ?>
                    <button 
                        type="button" 
                        class="alex-ajax-add-to-cart bg-cta hover:bg-cta-hover text-white p-2.5 rounded-xl shadow-cta hover:shadow-cta-hover transition-all duration-200 active:scale-95 flex items-center justify-center"
                        data-product-id="<?php echo esc_attr($product_id); ?>"
                        data-quantity="1"
                        title="<?php esc_attr_e('Añadir al carrito', 'alex-store'); ?>"
                    >
                        <?php echo alex_store_svg_icon('cart', 'w-4 h-4'); ?>
                    </button>
                <?php else : ?>
                    <a 
                        href="<?php echo esc_url($permalink); ?>" 
                        class="bg-neutral-100 hover:bg-neutral-200 text-neutral-900 p-2.5 rounded-xl border border-neutral-200 shadow-sm transition-all duration-200 flex items-center justify-center"
                        title="<?php esc_attr_e('Ver opciones', 'alex-store'); ?>"
                    >
                        <?php echo alex_store_svg_icon('arrow-right', 'w-4 h-4'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </figure>

        <!-- 2. PRECIO (Destacado arriba del texto) -->
        <div class="px-4 pt-3 pb-1 bg-white">
            <div class="flex items-baseline gap-2">
                <span class="text-base font-bold text-neutral-900 tracking-tight">
                    <?php echo wp_kses_post($price_html); ?>
                </span>
            </div>
        </div>

        <!-- 3. TEXTO / TÍTULO / STOCK (Capitalize Style) -->
        <div class="px-4 pb-4 pt-1 flex-1 flex flex-col justify-between">
            <div>
                <?php if (!empty($categories)) : ?>
                    <div class="mb-1">
                        <?php echo wp_kses_post($categories); ?>
                    </div>
                <?php endif; ?>

                <h3 class="text-xs sm:text-sm font-semibold text-neutral-800 hover:text-cta transition-colors line-clamp-2 mb-1.5 leading-snug capitalize">
                    <a href="<?php echo esc_url($permalink); ?>">
                        <?php echo esc_html($title); ?>
                    </a>
                </h3>
            </div>

            <div class="mt-3 pt-2.5 border-t border-neutral-100 flex items-center justify-between">
                <div>
                    <?php if ($is_in_stock) : ?>
                        <span class="inline-flex items-center text-[10px] font-semibold text-neutral-700 bg-neutral-100 px-2 py-0.5 rounded">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                            <?php esc_html_e('Disponible', 'alex-store'); ?>
                        </span>
                    <?php else : ?>
                        <span class="inline-flex items-center text-[10px] font-semibold text-neutral-400 bg-neutral-100 px-2 py-0.5 rounded">
                            <?php esc_html_e('Agotado', 'alex-store'); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="text-[10px] text-neutral-400 font-medium">
                    <?php esc_html_e('Garantía oficial', 'alex-store'); ?>
                </div>
            </div>
        </div>
    </li>
    <?php
    return ob_get_clean();
}
function tech_store_product_card($product, $args = []) { return alex_store_product_card($product, $args); }
