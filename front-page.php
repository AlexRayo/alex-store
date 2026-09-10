<?php
/**
 * The front-page template for Alex Store (Dynamic Primary Color - MR Soluciones)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Fetch Categories
$categories = [];
if (class_exists('WooCommerce')) {
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'number'     => 12,
        'orderby'    => 'count',
        'order'      => 'DESC',
    ]);
}

// Fetch On-Sale / Featured Products
$on_sale_products = [];
$featured_products = [];

if (class_exists('WooCommerce')) {
    $on_sale_products = wc_get_products([
        'limit'   => 8,
        'status'  => 'publish',
        'on_sale' => true,
    ]);

    if (empty($on_sale_products)) {
        $on_sale_products = wc_get_products([
            'limit'  => 8,
            'status' => 'publish',
        ]);
    }

    $featured_products = wc_get_products([
        'limit'   => 8,
        'status'  => 'publish',
        'featured'=> true,
    ]);

    if (empty($featured_products)) {
        $featured_products = wc_get_products([
            'limit'   => 8,
            'status'  => 'publish',
            'orderby' => 'popularity',
        ]);
    }
}

// Customizer Theme Mods
$hero_badge    = get_theme_mod('alex_hero_badge', get_theme_mod('tech_hero_badge', __('⚡ 3 Meses 0% Interés con Credex', 'alex-store')));
$hero_title    = get_theme_mod('alex_hero_title', get_theme_mod('tech_hero_title', __('Tecnología de última generación a tu alcance.', 'alex-store')));
$hero_subtitle = get_theme_mod('alex_hero_subtitle', get_theme_mod('tech_hero_subtitle', __('Encuentra los últimos modelos en celulares, computadoras, gaming, audio y seguridad con respaldo oficial.', 'alex-store')));
$whatsapp_num  = get_theme_mod('alex_whatsapp_number', get_theme_mod('tech_whatsapp_number', '50557935010'));
?>

<main id="primary" class="site-main">
    
    <!-- 1. HERO TECH SHOWCASE (Dynamic Primary Color Section) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Big Banner (2 cols) -> Uses bg-primary dynamically -->
            <div class="lg:col-span-2 relative bg-primary rounded-3xl p-6 sm:p-12 text-white overflow-hidden flex flex-col justify-between min-h-[420px] shadow-card border border-white/10 group">
                <div class="absolute -right-24 -top-24 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none group-hover:scale-110 transition-transform duration-700"></div>
                <div class="absolute left-1/3 -bottom-24 w-80 h-80 bg-black/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-lg">
                    <?php if ($hero_badge) : ?>
                        <span class="inline-flex items-center gap-1.5 bg-black/30 backdrop-blur-md text-white text-xs font-semibold uppercase px-3 py-1 rounded-full mb-4 border border-white/20">
                            <?php echo esc_html($hero_badge); ?>
                        </span>
                    <?php endif; ?>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white leading-[1.15] tracking-tight mb-4">
                        <?php echo esc_html($hero_title); ?>
                    </h1>
                    <p class="text-sm sm:text-base text-white/80 mb-6 font-normal leading-relaxed">
                        <?php echo esc_html($hero_subtitle); ?>
                    </p>
                </div>

                <div class="relative z-10 flex items-center gap-3 flex-wrap">
                    <a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('shop')) : esc_url(home_url('/shop')); ?>" class="bg-white hover:bg-neutral-100 text-neutral-950 font-bold px-6 py-3 rounded-xl text-sm transition-all shadow-sm flex items-center gap-2">
                        <?php esc_html_e('Ver Catálogo Completo', 'alex-store'); ?>
                        <?php echo alex_store_svg_icon('arrow-right', 'w-4 h-4'); ?>
                    </a>
                    <span class="text-xs text-white/70 font-medium px-3 py-2 rounded-xl border border-white/15 backdrop-blur-sm">
                        🛡️ <?php esc_html_e('Garantía y Asistencia Técnica', 'alex-store'); ?>
                    </span>
                </div>
            </div>

            <!-- Side Dual Banners (1 col) -->
            <div class="flex flex-col gap-6">
                <!-- Top Mini Banner: Smart Assistants / Audio (bg-primary-dark) -->
                <div class="flex-1 bg-primary-dark text-white rounded-3xl p-6 relative overflow-hidden flex flex-col justify-between border border-white/10 shadow-sm group">
                    <div class="relative z-10">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-white/70 mb-1 block">
                            <?php esc_html_e('Hogar Inteligente & Sonido', 'alex-store'); ?>
                        </span>
                        <h3 class="text-lg font-bold text-white leading-snug mb-1.5">
                            <?php esc_html_e('Asistentes de Voz & Audio', 'alex-store'); ?>
                        </h3>
                        <p class="text-xs text-white/70">
                            <?php esc_html_e('Amazon Alexa, audífonos con cancelación de ruido y parlantes.', 'alex-store'); ?>
                        </p>
                    </div>
                    <div class="relative z-10 mt-4">
                        <a href="<?php echo esc_url(home_url('/shop')); ?>" class="inline-flex items-center gap-1 text-xs font-bold text-white hover:underline">
                            <?php esc_html_e('Explorar categoría', 'alex-store'); ?> &rarr;
                        </a>
                    </div>
                </div>

                <!-- Bottom Mini Banner: Financing / Credex -->
                <div class="flex-1 bg-neutral-100 text-neutral-900 rounded-3xl p-6 relative overflow-hidden flex flex-col justify-between border border-neutral-200 shadow-sm group">
                    <div class="relative z-10">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-neutral-500 mb-1 block">
                            <?php esc_html_e('Facilidades de Pago', 'alex-store'); ?>
                        </span>
                        <h3 class="text-lg font-bold text-neutral-900 leading-snug mb-1.5">
                            <?php esc_html_e('Compra en Cuotas sin Intereses', 'alex-store'); ?>
                        </h3>
                        <p class="text-xs text-neutral-600 font-normal">
                            <?php esc_html_e('Aplica con Credex y tarjetas bancarias en minutos.', 'alex-store'); ?>
                        </p>
                    </div>
                    <div class="relative z-10 mt-4">
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp_num)); ?>" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-neutral-900 hover:underline">
                            <?php esc_html_e('Consultar por WhatsApp', 'alex-store'); ?> &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 2. SEASONAL PROMOTIONAL BANNER (Optional from Customizer) -->
    <?php get_template_part('template-parts/components/promo-banner'); ?>

    <!-- 3. POPULAR CATEGORIES GRID (Neutral Minimalist Cards) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 tracking-tight">
                    <?php esc_html_e('Departamentos de Tecnología', 'alex-store'); ?>
                </h2>
                <p class="text-xs sm:text-sm text-neutral-500">
                    <?php esc_html_e('Selecciona una categoría para explorar los productos', 'alex-store'); ?>
                </p>
            </div>
            <a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('shop')) : esc_url(home_url('/shop')); ?>" class="text-xs font-bold text-neutral-900 hover:underline flex items-center gap-1">
                <?php esc_html_e('Ver todo', 'alex-store'); ?> &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
            <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                <?php foreach ($categories as $cat) : 
                    if ($cat->slug === 'uncategorized' || $cat->slug === 'sin-categorizar') continue;
                    $thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    $cat_img  = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'thumbnail') : '';
                ?>
                    <a 
                        href="<?php echo esc_url(get_term_link($cat)); ?>" 
                        class="group bg-white p-4 rounded-2xl border border-neutral-200 shadow-subtle hover:shadow-card hover:border-primary transition-all text-center flex flex-col items-center justify-center gap-2"
                    >
                        <div class="w-14 h-14 rounded-xl bg-neutral-100 group-hover:bg-neutral-200 flex items-center justify-center transition-colors overflow-hidden p-2">
                            <?php if ($cat_img) : ?>
                                <img src="<?php echo esc_url($cat_img); ?>" alt="<?php echo esc_attr($cat->name); ?>" class="w-full h-full object-contain" />
                            <?php else : ?>
                                <span class="text-neutral-800 font-bold text-base"><?php echo esc_html(mb_substr($cat->name, 0, 1)); ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-neutral-900 group-hover:text-primary transition-colors line-clamp-1">
                                <?php echo esc_html($cat->name); ?>
                            </h4>
                            <span class="text-[10px] text-neutral-400 font-medium">
                                <?php printf(esc_html__('%d artículos', 'alex-store'), absint($cat->count)); ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <?php
                $sample_cats = [
                    'Celulares', 'Computadoras', 'Audífonos', 'Gaming', 
                    'Monitores', 'Almacenamiento', 'Cámaras', 'Relojes', 
                    'Tablets', 'Parlantes', 'Baterías', 'Accesorios'
                ];
                foreach ($sample_cats as $s_cat) :
                ?>
                    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="group bg-white p-4 rounded-2xl border border-neutral-200 shadow-subtle hover:border-primary transition-all text-center flex flex-col items-center justify-center gap-2">
                        <div class="w-12 h-12 rounded-xl bg-neutral-100 flex items-center justify-center text-neutral-700 font-bold text-sm">
                            <?php echo esc_html(mb_substr($s_cat, 0, 1)); ?>
                        </div>
                        <h4 class="text-xs font-semibold text-neutral-900 line-clamp-1"><?php echo esc_html($s_cat); ?></h4>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- 4. FEATURED PRODUCTS (Clean Grid) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 tracking-tight">
                    <?php esc_html_e('Ofertas & Destacados', 'alex-store'); ?>
                </h2>
                <p class="text-xs sm:text-sm text-neutral-500">
                    <?php esc_html_e('Productos seleccionados con disponibilidad inmediata', 'alex-store'); ?>
                </p>
            </div>
            <a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('shop')) : esc_url(home_url('/shop')); ?>" class="ubx-btn-outline text-xs">
                <?php esc_html_e('Ver Todos', 'alex-store'); ?>
            </a>
        </div>

        <?php if (!empty($on_sale_products)) : ?>
            <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 p-0 m-0">
                <?php foreach ($on_sale_products as $p) : ?>
                    <?php echo alex_store_product_card($p); ?>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <div class="bg-white p-8 rounded-2xl border border-neutral-200 text-center">
                <p class="text-sm text-neutral-500"><?php esc_html_e('Añade productos en WooCommerce para visualizarlos aquí.', 'alex-store'); ?></p>
            </div>
        <?php endif; ?>
    </section>

    <!-- 5. DUAL PROMO TECH BANNERS (Dynamic Primary Color) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Promo 1: Gaming / PC (bg-primary) -->
            <div class="bg-primary text-white rounded-3xl p-8 relative overflow-hidden flex flex-col justify-between border border-white/10 shadow-subtle min-h-[220px]">
                <div class="relative z-10 max-w-sm">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-white/70 mb-1 block">
                        <?php esc_html_e('Alto Rendimiento', 'alex-store'); ?>
                    </span>
                    <h3 class="text-2xl font-bold text-white mb-2 leading-tight">
                        <?php esc_html_e('Gaming, Laptops & Monitores', 'alex-store'); ?>
                    </h3>
                    <p class="text-xs text-white/70 mb-6">
                        <?php esc_html_e('Equipos de alta potencia y periféricos para oficina o entretenimiento.', 'alex-store'); ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="bg-white hover:bg-neutral-100 text-neutral-950 font-semibold text-xs py-2.5 px-4 rounded-xl inline-block transition-colors">
                        <?php esc_html_e('Ver Colección', 'alex-store'); ?>
                    </a>
                </div>
            </div>

            <!-- Promo 2: Mobile / Apple / Accessories (bg-primary-dark) -->
            <div class="bg-primary-dark text-white rounded-3xl p-8 relative overflow-hidden flex flex-col justify-between border border-white/10 shadow-subtle min-h-[220px]">
                <div class="relative z-10 max-w-sm">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-white/70 mb-1 block">
                        <?php esc_html_e('Movilidad & Accesorios', 'alex-store'); ?>
                    </span>
                    <h3 class="text-2xl font-bold text-white mb-2 leading-tight">
                        <?php esc_html_e('Smartphones & Accesorios Originales', 'alex-store'); ?>
                    </h3>
                    <p class="text-xs text-white/70 mb-6">
                        <?php esc_html_e('Cargadores rápidos, fundas de protección y almacenamiento.', 'alex-store'); ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="bg-white/10 hover:bg-white/20 text-white font-semibold text-xs py-2.5 px-4 rounded-xl inline-block transition-colors border border-white/20">
                        <?php esc_html_e('Explorar Catálogo', 'alex-store'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. HOW IT WORKS / COMPRA EN CUOTAS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white rounded-3xl border border-neutral-200 p-6 sm:p-10 shadow-subtle">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-neutral-500 mb-1 block">
                    <?php esc_html_e('Proceso Simple', 'alex-store'); ?>
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight">
                    <?php esc_html_e('¿Cómo comprar en MR Soluciones?', 'alex-store'); ?>
                </h2>
                <p class="text-xs sm:text-sm text-neutral-500 mt-2">
                    <?php esc_html_e('Comprar en línea de forma segura y rápida en 4 sencillos pasos.', 'alex-store'); ?>
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <div class="p-4 rounded-2xl bg-neutral-50 border border-neutral-100">
                    <span class="w-10 h-10 rounded-full bg-primary text-white font-bold flex items-center justify-center mx-auto mb-3 text-sm">1</span>
                    <h4 class="text-sm font-bold text-neutral-900 mb-1"><?php esc_html_e('Elige tu producto', 'alex-store'); ?></h4>
                    <p class="text-xs text-neutral-500"><?php esc_html_e('Explora nuestro catálogo de tecnología y selecciona lo que necesitas.', 'alex-store'); ?></p>
                </div>
                <div class="p-4 rounded-2xl bg-neutral-50 border border-neutral-100">
                    <span class="w-10 h-10 rounded-full bg-primary text-white font-bold flex items-center justify-center mx-auto mb-3 text-sm">2</span>
                    <h4 class="text-sm font-bold text-neutral-900 mb-1"><?php esc_html_e('Agrega al carrito', 'alex-store'); ?></h4>
                    <p class="text-xs text-neutral-500"><?php esc_html_e('Revisa tu pedido en el carrito lateral y aplica tus cupones.', 'alex-store'); ?></p>
                </div>
                <div class="p-4 rounded-2xl bg-neutral-50 border border-neutral-100">
                    <span class="w-10 h-10 rounded-full bg-primary text-white font-bold flex items-center justify-center mx-auto mb-3 text-sm">3</span>
                    <h4 class="text-sm font-bold text-neutral-900 mb-1"><?php esc_html_e('Ingresa tus datos', 'alex-store'); ?></h4>
                    <p class="text-xs text-neutral-500"><?php esc_html_e('Especifica tu dirección de entrega o retiro en sucursal.', 'alex-store'); ?></p>
                </div>
                <div class="p-4 rounded-2xl bg-neutral-50 border border-neutral-100">
                    <span class="w-10 h-10 rounded-full bg-primary text-white font-bold flex items-center justify-center mx-auto mb-3 text-sm">4</span>
                    <h4 class="text-sm font-bold text-neutral-900 mb-1"><?php esc_html_e('Recibe tu compra', 'alex-store'); ?></h4>
                    <p class="text-xs text-neutral-500"><?php esc_html_e('Paga con tarjeta, Credex o transferencia y recibe de inmediato.', 'alex-store'); ?></p>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
