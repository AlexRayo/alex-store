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

// Customizer Theme Mods - Hero Slider & Side Banners
$whatsapp_num = get_theme_mod('alex_whatsapp_number', get_theme_mod('tech_whatsapp_number', '50557935010'));
$default_wa   = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp_num);
$shop_url     = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');

// Helper to clean legacy emojis
$alex_clean_txt = function($txt) {
    return trim(preg_replace('/[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}]/u', '', (string)$txt));
};

// Slide 1
$s1_badge     = $alex_clean_txt(get_theme_mod('alex_slide1_badge', get_theme_mod('alex_hero_badge', get_theme_mod('tech_hero_badge', __('3 Meses 0% Interés con Credex', 'alex-store')))));
$s1_title     = get_theme_mod('alex_slide1_title', get_theme_mod('alex_hero_title', get_theme_mod('tech_hero_title', __('Tecnología de última generación a tu alcance.', 'alex-store'))));
$s1_subtitle  = get_theme_mod('alex_slide1_subtitle', get_theme_mod('alex_hero_subtitle', get_theme_mod('tech_hero_subtitle', __('Encuentra los últimos modelos en celulares, computadoras, gaming, audio y seguridad con respaldo oficial.', 'alex-store'))));
$s1_pills_raw = $alex_clean_txt(get_theme_mod('alex_slide1_pills', 'Pantallas OLED 120Hz, Garantía Oficial 1 Año, Envíos Rápidos'));
$s1_pills     = array_filter(array_map('trim', explode(',', $s1_pills_raw)));
$s1_btn1_text = get_theme_mod('alex_slide1_btn1_text', __('Ver Catálogo Completo', 'alex-store'));
$s1_btn1_url  = get_theme_mod('alex_slide1_btn1_url', '');
if (empty($s1_btn1_url)) $s1_btn1_url = $shop_url;
$s1_btn2_text = get_theme_mod('alex_slide1_btn2_text', __('Explorar Celulares', 'alex-store'));
$s1_btn2_url  = get_theme_mod('alex_slide1_btn2_url', '');
if (empty($s1_btn2_url)) $s1_btn2_url = $shop_url;
$s1_bg_image  = get_theme_mod('alex_slide1_bg_image', '');

// Slide 2
$s2_badge     = $alex_clean_txt(get_theme_mod('alex_slide2_badge', __('ALTO RENDIMIENTO & GAMING', 'alex-store')));
$s2_title     = get_theme_mod('alex_slide2_title', __('Laptops Pro & Setups Gaming de Élite', 'alex-store'));
$s2_subtitle  = get_theme_mod('alex_slide2_subtitle', __('Potencia sin límites para programadores, creadores y gamers. Laptops con GPU RTX serie 40, procesadores M3 y monitores de alta frecuencia.', 'alex-store'));
$s2_pills_raw = $alex_clean_txt(get_theme_mod('alex_slide2_pills', 'RTX Serie 40 Ready, 32GB RAM DDR5, Monitores 240Hz'));
$s2_pills     = array_filter(array_map('trim', explode(',', $s2_pills_raw)));
$s2_btn1_text = get_theme_mod('alex_slide2_btn1_text', __('Explorar Gaming & PC', 'alex-store'));
$s2_btn1_url  = get_theme_mod('alex_slide2_btn1_url', '');
if (empty($s2_btn1_url)) $s2_btn1_url = $shop_url;
$s2_btn2_text = get_theme_mod('alex_slide2_btn2_text', __('Ver Laptops', 'alex-store'));
$s2_btn2_url  = get_theme_mod('alex_slide2_btn2_url', '');
if (empty($s2_btn2_url)) $s2_btn2_url = $shop_url;
$s2_bg_image  = get_theme_mod('alex_slide2_bg_image', '');

// Slide 3
$s3_badge     = $alex_clean_txt(get_theme_mod('alex_slide3_badge', __('FINANCIAMIENTO 0% INTERÉS', 'alex-store')));
$s3_title     = get_theme_mod('alex_slide3_title', __('Sonido Inmersivo & Facilidades con Credex', 'alex-store'));
$s3_subtitle  = get_theme_mod('alex_slide3_subtitle', __('Audífonos con cancelación de ruido activa, asistentes de voz Alexa y seguridad para tu hogar. Llévatelo hoy hasta en 3 meses al 0%.', 'alex-store'));
$s3_pills_raw = $alex_clean_txt(get_theme_mod('alex_slide3_pills', 'Cancelación Activa ANC, 3 Meses 0% con Credex, Smart Living'));
$s3_pills     = array_filter(array_map('trim', explode(',', $s3_pills_raw)));
$s3_btn1_text = get_theme_mod('alex_slide3_btn1_text', __('Solicitar Cuotas por WhatsApp', 'alex-store'));
$s3_btn1_url  = get_theme_mod('alex_slide3_btn1_url', '');
if (empty($s3_btn1_url)) $s3_btn1_url = $default_wa;
$s3_btn2_text = get_theme_mod('alex_slide3_btn2_text', __('Ver Colección de Audio', 'alex-store'));
$s3_btn2_url  = get_theme_mod('alex_slide3_btn2_url', '');
if (empty($s3_btn2_url)) $s3_btn2_url = $shop_url;
$s3_bg_image  = get_theme_mod('alex_slide3_bg_image', '');

// Side Mini Banners
$side1_badge  = get_theme_mod('alex_side1_badge', __('Sonido & Smart Living', 'alex-store'));
$side1_title  = get_theme_mod('alex_side1_title', __('Asistentes de Voz & Audio', 'alex-store'));
$side1_desc   = get_theme_mod('alex_side1_desc', __('Amazon Alexa, audífonos con cancelación de ruido y parlantes inteligentes.', 'alex-store'));
$side1_link   = get_theme_mod('alex_side1_link', '');
if (empty($side1_link)) $side1_link = $shop_url;

$side2_badge  = get_theme_mod('alex_side2_badge', __('Facilidades de Pago', 'alex-store'));
$side2_title  = get_theme_mod('alex_side2_title', __('Compra en Cuotas sin Intereses', 'alex-store'));
$side2_desc   = get_theme_mod('alex_side2_desc', __('Aplica con Credex y tarjetas bancarias en minutos con entrega inmediata.', 'alex-store'));
$side2_link   = get_theme_mod('alex_side2_link', '');
if (empty($side2_link)) $side2_link = $default_wa;
?>

<main id="primary" class="site-main">
    
    <!-- 1. HERO TECH SHOWCASE (shadcn/ui Inspired Slider Carousel) -->
    <section class="site-container py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Tech Slider (2 cols) -> shadcn Carousel Architecture -->
            <div class="lg:col-span-2 relative tech-slider-wrapper shadow-card border border-neutral-200/80 bg-neutral-950 text-white min-h-[460px] md:min-h-[500px] flex flex-col justify-between" data-tech-slider aria-roledescription="carousel" aria-label="<?php esc_attr_e('Destacados Tecnológicos', 'alex-store'); ?>">
                
                <!-- Track / Slides Container -->
                <div class="tech-slider-track h-full">
                    
                    <!-- SLIDE 1: Flagship Tech / Smartphones & Ecosystem -->
                    <div class="tech-slider-slide relative bg-gradient-to-br from-primary via-primary-dark to-neutral-950 p-6 sm:p-10 lg:p-12 flex flex-col justify-between overflow-hidden">
                        <?php if (!empty($s1_bg_image)) : ?>
                            <img src="<?php echo esc_url($s1_bg_image); ?>" alt="" class="absolute inset-0 w-full h-full object-cover pointer-events-none z-0" />
                            <div class="absolute inset-0 bg-gradient-to-r from-black/75 to-black/50 pointer-events-none z-[1]" aria-hidden="true"></div>
                        <?php else : ?>
                            <div class="absolute -right-20 -top-20 w-96 h-96 bg-cta/20 rounded-full blur-3xl pointer-events-none"></div>
                            <div class="absolute right-1/4 -bottom-20 w-80 h-80 bg-primary-light/10 rounded-full blur-3xl pointer-events-none"></div>
                        <?php endif; ?>

                        <div class="relative z-10 max-w-xl">
                            <?php if (!empty($s1_badge)) : ?>
                                <span class="shadcn-badge bg-white/10 text-white border-white/20 backdrop-blur-md mb-4 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <?php echo esc_html($s1_badge); ?>
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($s1_title)) : ?>
                                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white leading-[1.12] tracking-tight mb-4">
                                    <?php echo esc_html($s1_title); ?>
                                </h1>
                            <?php endif; ?>

                            <?php if (!empty($s1_subtitle)) : ?>
                                <p class="text-sm sm:text-base text-white/80 mb-6 font-normal leading-relaxed max-w-lg">
                                    <?php echo esc_html($s1_subtitle); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Tech Telemetry Pills -->
                            <?php if (!empty($s1_pills)) : ?>
                                <div class="flex flex-wrap items-center gap-2 mb-6">
                                    <?php foreach ($s1_pills as $pill) : ?>
                                        <span class="text-[11px] font-semibold text-white/90 bg-white/10 px-2.5 py-1 rounded-md border border-white/15 backdrop-blur-sm">
                                            <?php echo esc_html($pill); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="relative z-10 flex items-center gap-3 flex-wrap">
                            <?php if (!empty($s1_btn1_text)) : ?>
                                <a href="<?php echo esc_url($s1_btn1_url); ?>" class="shadcn-btn bg-white hover:bg-neutral-100 text-neutral-950 font-bold px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm flex items-center gap-2">
                                    <?php echo esc_html($s1_btn1_text); ?>
                                    <?php echo alex_store_svg_icon('arrow-right', 'w-4 h-4'); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($s1_btn2_text)) : ?>
                                <a href="<?php echo esc_url($s1_btn2_url); ?>" class="shadcn-btn-dark-glass text-xs font-semibold px-4 py-2.5">
                                    <?php echo esc_html($s1_btn2_text); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- SLIDE 2: Gaming & Workstations (Pro Performance) -->
                    <div class="tech-slider-slide relative bg-gradient-to-br from-neutral-900 via-[#0c1222] to-neutral-950 p-6 sm:p-10 lg:p-12 flex flex-col justify-between overflow-hidden">
                        <?php if (!empty($s2_bg_image)) : ?>
                            <img src="<?php echo esc_url($s2_bg_image); ?>" alt="" class="absolute inset-0 w-full h-full object-cover pointer-events-none z-0" />
                            <div class="absolute inset-0 bg-gradient-to-r from-black/75 to-black/50 pointer-events-none z-[1]" aria-hidden="true"></div>
                        <?php else : ?>
                            <div class="absolute -right-20 -top-20 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
                            <div class="absolute left-1/3 -bottom-24 w-80 h-80 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>
                        <?php endif; ?>

                        <div class="relative z-10 max-w-xl">
                            <?php if (!empty($s2_badge)) : ?>
                                <span class="shadcn-badge bg-blue-500/20 text-blue-200 border-blue-400/30 backdrop-blur-md mb-4 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                    <?php echo esc_html($s2_badge); ?>
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($s2_title)) : ?>
                                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white leading-[1.12] tracking-tight mb-4">
                                    <?php echo esc_html($s2_title); ?>
                                </h2>
                            <?php endif; ?>

                            <?php if (!empty($s2_subtitle)) : ?>
                                <p class="text-sm sm:text-base text-white/80 mb-6 font-normal leading-relaxed max-w-lg">
                                    <?php echo esc_html($s2_subtitle); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Tech Telemetry Pills -->
                            <?php if (!empty($s2_pills)) : ?>
                                <div class="flex flex-wrap items-center gap-2 mb-6">
                                    <?php foreach ($s2_pills as $pill) : ?>
                                        <span class="text-[11px] font-semibold text-blue-200 bg-blue-950/60 px-2.5 py-1 rounded-md border border-blue-800/60 backdrop-blur-sm">
                                            <?php echo esc_html($pill); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="relative z-10 flex items-center gap-3 flex-wrap">
                            <?php if (!empty($s2_btn1_text)) : ?>
                                <a href="<?php echo esc_url($s2_btn1_url); ?>" class="shadcn-btn-primary px-6 py-2.5 text-sm font-bold">
                                    <?php echo esc_html($s2_btn1_text); ?>
                                    <?php echo alex_store_svg_icon('arrow-right', 'w-4 h-4'); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($s2_btn2_text)) : ?>
                                <a href="<?php echo esc_url($s2_btn2_url); ?>" class="shadcn-btn-dark-glass text-xs font-semibold px-4 py-2.5">
                                    <?php echo esc_html($s2_btn2_text); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- SLIDE 3: Audio Hi-Fi, Smart Home & Cuotas Credex -->
                    <div class="tech-slider-slide relative bg-gradient-to-br from-[#111827] via-[#1e1b4b] to-neutral-950 p-6 sm:p-10 lg:p-12 flex flex-col justify-between overflow-hidden">
                        <?php if (!empty($s3_bg_image)) : ?>
                            <img src="<?php echo esc_url($s3_bg_image); ?>" alt="" class="absolute inset-0 w-full h-full object-cover pointer-events-none z-0" />
                            <div class="absolute inset-0 bg-gradient-to-r from-black/75 to-black/50 pointer-events-none z-[1]" aria-hidden="true"></div>
                        <?php else : ?>
                            <div class="absolute -right-24 -top-24 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
                            <div class="absolute left-1/4 -bottom-24 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
                        <?php endif; ?>

                        <div class="relative z-10 max-w-xl">
                            <?php if (!empty($s3_badge)) : ?>
                                <span class="shadcn-badge bg-emerald-500/20 text-emerald-200 border-emerald-400/30 backdrop-blur-md mb-4 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    <?php echo esc_html($s3_badge); ?>
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($s3_title)) : ?>
                                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white leading-[1.12] tracking-tight mb-4">
                                    <?php echo esc_html($s3_title); ?>
                                </h2>
                            <?php endif; ?>

                            <?php if (!empty($s3_subtitle)) : ?>
                                <p class="text-sm sm:text-base text-white/80 mb-6 font-normal leading-relaxed max-w-lg">
                                    <?php echo esc_html($s3_subtitle); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Tech Telemetry Pills -->
                            <?php if (!empty($s3_pills)) : ?>
                                <div class="flex flex-wrap items-center gap-2 mb-6">
                                    <?php foreach ($s3_pills as $pill) : ?>
                                        <span class="text-[11px] font-semibold text-emerald-200 bg-emerald-950/60 px-2.5 py-1 rounded-md border border-emerald-800/60 backdrop-blur-sm">
                                            <?php echo esc_html($pill); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="relative z-10 flex items-center gap-3 flex-wrap">
                            <?php if (!empty($s3_btn1_text)) : ?>
                                <a href="<?php echo esc_url($s3_btn1_url); ?>" <?php echo strpos($s3_btn1_url, 'wa.me') !== false ? 'target="_blank"' : ''; ?> class="shadcn-btn bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm flex items-center gap-2">
                                    <?php if (strpos($s3_btn1_url, 'wa.me') !== false) : ?>
                                        <?php echo alex_store_svg_icon('whatsapp', 'w-4 h-4'); ?>
                                    <?php endif; ?>
                                    <?php echo esc_html($s3_btn1_text); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($s3_btn2_text)) : ?>
                                <a href="<?php echo esc_url($s3_btn2_url); ?>" class="shadcn-btn-dark-glass text-xs font-semibold px-4 py-2.5">
                                    <?php echo esc_html($s3_btn2_text); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <!-- Floating Navigation Arrows (shadcn Carousel style) -->
                <div class="absolute top-4 right-4 z-20 flex items-center gap-2">
                    <button type="button" class="tech-slider-prev tech-slider-arrow" aria-label="<?php esc_attr_e('Anterior slide', 'alex-store'); ?>">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <button type="button" class="tech-slider-next tech-slider-arrow" aria-label="<?php esc_attr_e('Siguiente slide', 'alex-store'); ?>">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>

                <!-- Bottom Progress Indicators (Pills) -->
                <div class="tech-slider-dots absolute bottom-5 right-6 z-20 flex items-center gap-2" role="tablist" aria-label="<?php esc_attr_e('Diapositivas', 'alex-store'); ?>">
                    <button type="button" class="tech-slider-dot active" role="tab" aria-label="<?php esc_attr_e('Slide 1', 'alex-store'); ?>" aria-current="true"></button>
                    <button type="button" class="tech-slider-dot" role="tab" aria-label="<?php esc_attr_e('Slide 2', 'alex-store'); ?>"></button>
                    <button type="button" class="tech-slider-dot" role="tab" aria-label="<?php esc_attr_e('Slide 3', 'alex-store'); ?>"></button>
                </div>

            </div>

            <!-- Side Dual Banners (1 col) -->
            <div class="flex flex-col gap-6">
                <!-- Top Mini Banner: Smart Assistants / Audio (bg-primary-dark) -->
                <div class="flex-1 bg-primary-dark text-white rounded-3xl p-6 sm:p-7 relative overflow-hidden flex flex-col justify-between border border-white/10 shadow-sm group hover:border-white/20 transition-all">
                    <div class="relative z-10">
                        <?php if (!empty($side1_badge)) : ?>
                            <span class="shadcn-badge bg-white/10 text-white/90 border-white/20 text-[10px] mb-2">
                                <?php echo esc_html($side1_badge); ?>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($side1_title)) : ?>
                            <h3 class="text-lg font-bold text-white leading-snug mb-1.5">
                                <?php echo esc_html($side1_title); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if (!empty($side1_desc)) : ?>
                            <p class="text-xs text-white/70 leading-relaxed">
                                <?php echo esc_html($side1_desc); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="relative z-10 mt-4">
                        <a href="<?php echo esc_url($side1_link); ?>" class="inline-flex items-center gap-1.5 text-xs font-bold text-white hover:text-white/80 group-hover:translate-x-1 transition-all">
                            <?php esc_html_e('Explorar categoría', 'alex-store'); ?> &rarr;
                        </a>
                    </div>
                </div>

                <!-- Bottom Mini Banner: Financing / Credex -->
                <div class="flex-1 bg-neutral-100 text-neutral-900 rounded-3xl p-6 sm:p-7 relative overflow-hidden flex flex-col justify-between border border-neutral-200/80 shadow-sm group hover:border-neutral-300 transition-all">
                    <div class="relative z-10">
                        <?php if (!empty($side2_badge)) : ?>
                            <span class="shadcn-badge bg-neutral-200 text-neutral-800 border-neutral-300 text-[10px] mb-2">
                                <?php echo esc_html($side2_badge); ?>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($side2_title)) : ?>
                            <h3 class="text-lg font-bold text-neutral-900 leading-snug mb-1.5">
                                <?php echo esc_html($side2_title); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if (!empty($side2_desc)) : ?>
                            <p class="text-xs text-neutral-600 leading-relaxed font-normal">
                                <?php echo esc_html($side2_desc); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="relative z-10 mt-4">
                        <a href="<?php echo esc_url($side2_link); ?>" <?php echo strpos($side2_link, 'wa.me') !== false ? 'target="_blank"' : ''; ?> class="inline-flex items-center gap-1.5 text-xs font-bold text-neutral-900 hover:text-cta group-hover:translate-x-1 transition-all">
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
    <section class="site-container py-8">
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
                        class="group bg-white p-4 rounded-2xl border border-neutral-200/80 shadow-subtle hover:shadow-card hover:border-primary transition-all text-center flex flex-col items-center justify-center gap-2"
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
    <section class="site-container py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 tracking-tight">
                    <?php esc_html_e('Ofertas & Destacados', 'alex-store'); ?>
                </h2>
                <p class="text-xs sm:text-sm text-neutral-500">
                    <?php esc_html_e('Productos seleccionados con disponibilidad inmediata', 'alex-store'); ?>
                </p>
            </div>
            <a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('shop')) : esc_url(home_url('/shop')); ?>" class="shadcn-btn-outline text-xs">
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
    <section class="site-container py-6">
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
    <section class="site-container py-10">
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
