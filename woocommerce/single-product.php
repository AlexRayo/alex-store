<?php
/**
 * The Template for displaying all single products (Primary Sale Badge Edition)
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- Breadcrumbs -->
    <?php woocommerce_breadcrumb(); ?>

    <?php while (have_posts()) : the_post();
        global $product;
        if (!$product) continue;

        $product_id        = $product->get_id();
        $raw_title         = $product->get_name();
        $title             = function_exists('tech_store_capitalize_text') ? tech_store_capitalize_text($raw_title) : ucwords(strtolower($raw_title));
        $price_html        = $product->get_price_html();
        $is_on_sale        = $product->is_on_sale();
        $discount_pct      = $is_on_sale ? tech_store_get_discount_percentage($product) : 0;
        $is_in_stock       = $product->is_in_stock();
        $image_id          = $product->get_image_id();
        $main_image_url    = $image_id ? wp_get_attachment_image_url($image_id, 'large') : wc_placeholder_img_src('woocommerce_single');
        $gallery_image_ids = $product->get_gallery_image_ids();
        $categories        = wc_get_product_category_list($product_id, ', ', '<span class="text-xs uppercase font-semibold tracking-wider text-neutral-400 mb-2 block">', '</span>');
    ?>
        <div id="product-<?php the_ID(); ?>" <?php wc_product_class('bg-white rounded-3xl border border-neutral-200 p-6 sm:p-10 shadow-subtle mb-12', $product); ?>>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-start">
                
                <!-- Left: Product Image & Gallery -->
                <div class="space-y-4">
                    <div class="relative bg-neutral-50 rounded-2xl border border-neutral-200 p-6 flex items-center justify-center min-h-[350px] sm:min-h-[450px] overflow-hidden group">
                        <?php if ($is_on_sale && $discount_pct > 0) : ?>
                            <!-- Sale Badge with Primary Color (Color de cabeceras, banners hero, promociones y footer) -->
                            <span class="badge-sale absolute top-4 left-4 z-10 bg-primary text-white text-xs font-bold uppercase px-3 py-1 rounded-md shadow-sm">
                                -<?php echo esc_html($discount_pct); ?>% OFF
                            </span>
                        <?php endif; ?>

                        <img 
                            id="tech-main-product-image"
                            src="<?php echo esc_url($main_image_url); ?>" 
                            alt="<?php echo esc_attr($title); ?>" 
                            class="max-h-[380px] w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                        />
                    </div>

                    <!-- Gallery Thumbnails -->
                    <?php if (!empty($gallery_image_ids)) : ?>
                        <div class="flex items-center gap-3 overflow-x-auto no-scrollbar py-1">
                            <button 
                                type="button" 
                                class="tech-gallery-thumb w-18 h-18 p-1.5 rounded-xl border-2 border-primary bg-white flex-shrink-0 cursor-pointer overflow-hidden"
                                data-full-src="<?php echo esc_url($main_image_url); ?>"
                            >
                                <img src="<?php echo esc_url($main_image_url); ?>" class="w-14 h-14 object-contain" alt="<?php echo esc_attr($title); ?>" />
                            </button>

                            <?php foreach ($gallery_image_ids as $g_id) :
                                $g_thumb = wp_get_attachment_image_url($g_id, 'thumbnail');
                                $g_full  = wp_get_attachment_image_url($g_id, 'large');
                            ?>
                                <button 
                                    type="button" 
                                    class="tech-gallery-thumb w-18 h-18 p-1.5 rounded-xl border border-neutral-200 hover:border-primary bg-white flex-shrink-0 cursor-pointer overflow-hidden transition-all"
                                    data-full-src="<?php echo esc_url($g_full); ?>"
                                >
                                    <img src="<?php echo esc_url($g_thumb); ?>" class="w-14 h-14 object-contain" alt="<?php echo esc_attr($title); ?>" />
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Product Summary & Purchase Options -->
                <div class="flex flex-col justify-between space-y-6">
                    <div>
                        <!-- Category -->
                        <?php if ($categories) : ?>
                            <?php echo wp_kses_post($categories); ?>
                        <?php endif; ?>

                        <!-- Title (Capitalized) -->
                        <h1 class="text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight mb-3 capitalize">
                            <?php echo esc_html($title); ?>
                        </h1>

                        <!-- Stock Status Bar -->
                        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-neutral-200">
                            <?php if ($is_in_stock) : ?>
                                <span class="text-xs font-semibold text-neutral-700 bg-neutral-100 px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <?php esc_html_e('En Stock - Listo para envío inmediato', 'tech-store'); ?>
                                </span>
                            <?php else : ?>
                                <span class="text-xs font-semibold text-neutral-400 bg-neutral-100 px-2.5 py-1 rounded-full">
                                    <?php esc_html_e('Agotado', 'tech-store'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Price Section -->
                        <div class="bg-neutral-50 p-4 rounded-2xl border border-neutral-200 mb-6 flex items-baseline gap-3">
                            <span class="text-2xl sm:text-3xl font-extrabold text-neutral-900">
                                <?php echo wp_kses_post($price_html); ?>
                            </span>
                        </div>

                        <!-- Short Description -->
                        <?php if ($product->get_short_description()) : ?>
                            <div class="text-xs sm:text-sm text-neutral-600 leading-relaxed mb-6">
                                <?php echo wp_kses_post($product->get_short_description()); ?>
                            </div>
                        <?php endif; ?>

                        <!-- WooCommerce Native Add to Cart form (CTA Color) -->
                        <div class="mb-6">
                            <?php woocommerce_template_single_add_to_cart(); ?>
                        </div>

                        <!-- WhatsApp Direct Inquiry -->
                        <div class="mb-6">
                            <a 
                                href="https://wa.me/50557935010?text=<?php echo urlencode('Hola, estoy interesado en el producto: ' . $title . ' ' . $product->get_permalink()); ?>" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center gap-2 w-full bg-neutral-900 hover:bg-black text-white font-semibold py-3 px-4 rounded-xl shadow-sm text-sm transition-all"
                            >
                                <?php echo tech_store_svg_icon('whatsapp', 'w-4 h-4 text-emerald-400'); ?>
                                <span><?php esc_html_e('Consultar por WhatsApp / Asesoría', 'tech-store'); ?></span>
                            </a>
                        </div>

                        <!-- Trust Guarantee Checklist -->
                        <div class="bg-neutral-50 p-4 rounded-2xl border border-neutral-200 space-y-2 text-xs text-neutral-600">
                            <div class="flex items-center gap-2">
                                <span class="text-primary"><?php echo tech_store_svg_icon('truck', 'w-4 h-4'); ?></span>
                                <span><?php esc_html_e('Envíos a todo el país o retiro en sucursales (Estelí y Managua).', 'tech-store'); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-primary"><?php echo tech_store_svg_icon('credit', 'w-4 h-4'); ?></span>
                                <span><?php esc_html_e('Disponible financiamiento con Credex a 3 meses sin intereses.', 'tech-store'); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-primary"><?php echo tech_store_svg_icon('shield', 'w-4 h-4'); ?></span>
                                <span><?php esc_html_e('Garantía y respaldo directo en MR Soluciones.', 'tech-store'); ?></span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Product Tabs -->
            <div class="mt-14 pt-10 border-t border-neutral-200" data-tabs-container>
                <div class="flex items-center gap-2 border-b border-neutral-200 pb-4 mb-6 overflow-x-auto no-scrollbar">
                    <button type="button" data-tab-target="tab-description" class="ubx-pill-tab active">
                        <?php esc_html_e('Descripción Detallada', 'tech-store'); ?>
                    </button>
                    <button type="button" data-tab-target="tab-specs" class="ubx-pill-tab">
                        <?php esc_html_e('Especificaciones Técnicas', 'tech-store'); ?>
                    </button>
                    <button type="button" data-tab-target="tab-shipping" class="ubx-pill-tab">
                        <?php esc_html_e('Envíos & Garantía', 'tech-store'); ?>
                    </button>
                </div>

                <!-- Tab 1: Description -->
                <div id="tab-description" data-tab-panel class="prose max-w-none text-neutral-600 text-sm leading-relaxed">
                    <?php the_content(); ?>
                </div>

                <!-- Tab 2: Additional Info / Specs -->
                <div id="tab-specs" data-tab-panel class="hidden prose max-w-none text-neutral-600 text-sm">
                    <?php do_action('woocommerce_product_additional_information', $product); ?>
                </div>

                <!-- Tab 3: Shipping & Returns -->
                <div id="tab-shipping" data-tab-panel class="hidden prose max-w-none text-neutral-600 text-sm leading-relaxed">
                    <h4 class="text-sm font-bold text-neutral-900 mb-2"><?php esc_html_e('Políticas de Envío & Retiro', 'tech-store'); ?></h4>
                    <p><?php esc_html_e('Realizamos envíos a toda Nicaragua o puedes retirar tu compra directamente en nuestras sucursales de Estelí (Esquina de los bancos y Súper Las Segovias) o en Managua (Plaza Puntaldia).', 'tech-store'); ?></p>
                    <h4 class="text-sm font-bold text-neutral-900 mt-4 mb-2"><?php esc_html_e('Garantía y Financiamiento', 'tech-store'); ?></h4>
                    <p><?php esc_html_e('Todos nuestros equipos cuentan con garantía de fabricante. Puedes consultar requisitos de financiamiento con Credex a través de nuestro canal de WhatsApp.', 'tech-store'); ?></p>
                </div>
            </div>

        </div>

        <!-- Related Products Section -->
        <?php
        $related_limit = 4;
        $related_ids = wc_get_related_products($product_id, $related_limit);

        if (!empty($related_ids)) :
        ?>
            <section class="mt-12">
                <div class="mb-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-neutral-900 tracking-tight">
                        <?php esc_html_e('Productos Relacionados', 'tech-store'); ?>
                    </h3>
                    <p class="text-xs text-neutral-500">
                        <?php esc_html_e('Otras opciones recomendadas para ti', 'tech-store'); ?>
                    </p>
                </div>

                <ul class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 p-0 m-0 list-none">
                    <?php foreach ($related_ids as $r_id) :
                        $r_product = wc_get_product($r_id);
                        if ($r_product) {
                            echo tech_store_product_card($r_product);
                        }
                    endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

    <?php endwhile; ?>

</div>

<?php
get_footer();
