<?php
/**
 * Theme Customizer Settings & Controls (Extended Edition with Primary & CTA Colors)
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Customizer Panels, Sections, and Controls
 */
function tech_store_customize_register($wp_customize) {

    // =========================================================
    // PANEL: Ajustes de la Tienda (Tech Store / MR Soluciones)
    // =========================================================
    $wp_customize->add_panel('tech_store_theme_options', [
        'title'       => __('🛍️ Opciones de Tienda (Tech Store)', 'tech-store'),
        'description' => __('Personaliza colores, tipografías, anuncios, columnas del catálogo, promociones, envíos y sucursales.', 'tech-store'),
        'priority'    => 25,
    ]);

    // ---------------------------------------------------------
    // 1. SECCIÓN: Colores & Tipografía
    // ---------------------------------------------------------
    $wp_customize->add_section('tech_store_colors_typography_section', [
        'title'    => __('Colores & Tipografía', 'tech-store'),
        'panel'    => 'tech_store_theme_options',
        'priority' => 10,
    ]);

    // Selector de Tipografía
    $wp_customize->add_setting('tech_font_family', [
        'default'           => 'Inter',
        'sanitize_callback' => 'tech_store_sanitize_font_family',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('tech_font_family', [
        'type'        => 'select',
        'label'       => __('Tipografía Principal (Google Fonts)', 'tech-store'),
        'description' => __('Selecciona la fuente tipográfica de la tienda.', 'tech-store'),
        'section'     => 'tech_store_colors_typography_section',
        'choices'     => [
            'Inter'              => 'Inter (Minimalista & Ultra Moderna)',
            'Montserrat'        => 'Montserrat (Elegante & Comercial)',
            'Plus Jakarta Sans'  => 'Plus Jakarta Sans (Moderna & Tech)',
            'Poppins'            => 'Poppins (Geométrica & Premium)',
            'Outfit'             => 'Outfit (Vanguardista & Limpia)',
        ],
    ]);

    // Color Primario (Estructura, Banners, Cabeceras, Footer, Badges de Descuento)
    $wp_customize->add_setting('tech_primary_color', [
        'default'           => '#0f172a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tech_primary_color', [
        'label'       => __('Color Primario (Marca / Banners / Badges / Estructura)', 'tech-store'),
        'description' => __('Color de cabeceras, banners hero, promociones, badges de descuento y footer.', 'tech-store'),
        'section'     => 'tech_store_colors_typography_section',
    ]));

    // Color Primario al Hover / Oscuro
    $wp_customize->add_setting('tech_primary_hover_color', [
        'default'           => '#020617',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tech_primary_hover_color', [
        'label'       => __('Color Primario Oscuro (Hover en Banners)', 'tech-store'),
        'section'     => 'tech_store_colors_typography_section',
    ]));

    // Color Call to Action (CTA - Botones de Compra / Checkout)
    $wp_customize->add_setting('tech_cta_color', [
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tech_cta_color', [
        'label'       => __('🔥 Color Call to Action (CTA / Botones de Compra)', 'tech-store'),
        'description' => __('Color para los botones de Añadir al Carrito, Finalizar Compra y compra rápida.', 'tech-store'),
        'section'     => 'tech_store_colors_typography_section',
    ]));

    // Color CTA Hover
    $wp_customize->add_setting('tech_cta_hover_color', [
        'default'           => '#1d4ed8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tech_cta_hover_color', [
        'label'       => __('Color CTA al Hover (Botones de Compra)', 'tech-store'),
        'section'     => 'tech_store_colors_typography_section',
    ]));

    // Color de Fondo de Barra de Anuncios
    $wp_customize->add_setting('tech_announcement_bg_color', [
        'default'           => '#0a0a0a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tech_announcement_bg_color', [
        'label'       => __('Fondo de Barra de Anuncios Superior', 'tech-store'),
        'section'     => 'tech_store_colors_typography_section',
    ]));

    // ---------------------------------------------------------
    // 2. SECCIÓN: Grid del Catálogo (Columnas)
    // ---------------------------------------------------------
    $wp_customize->add_section('tech_store_catalog_grid_section', [
        'title'    => __('Catálogo de Tienda (Columnas)', 'tech-store'),
        'panel'    => 'tech_store_theme_options',
        'priority' => 15,
    ]);

    $wp_customize->add_setting('tech_shop_columns', [
        'default'           => '4',
        'sanitize_callback' => 'tech_store_sanitize_columns',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('tech_shop_columns', [
        'type'        => 'select',
        'label'       => __('Número de Columnas en Catálogo (Escritorio)', 'tech-store'),
        'description' => __('Ajusta la cantidad de productos por fila en pantallas grandes.', 'tech-store'),
        'section'     => 'tech_store_catalog_grid_section',
        'choices'     => [
            '3' => __('3 Columnas (Tarjetas Grandes)', 'tech-store'),
            '4' => __('4 Columnas (Estándar Recomendado)', 'tech-store'),
            '5' => __('5 Columnas (Alta Densidad)', 'tech-store'),
        ],
    ]);

    // ---------------------------------------------------------
    // 3. SECCIÓN: Banner de Promoción Temporal (Campañas / Eventos)
    // ---------------------------------------------------------
    $wp_customize->add_section('tech_store_promo_banner_section', [
        'title'    => __('Banner de Promoción Temporal', 'tech-store'),
        'panel'    => 'tech_store_theme_options',
        'priority' => 20,
    ]);

    $wp_customize->add_setting('tech_promo_banner_enable', [
        'default'           => false,
        'sanitize_callback' => 'tech_store_sanitize_checkbox',
    ]);
    $wp_customize->add_control('tech_promo_banner_enable', [
        'type'        => 'checkbox',
        'label'       => __('Activar Banner de Promoción Temporal', 'tech-store'),
        'description' => __('Muestra un banner destacado para eventos especiales (Black Friday, Cyber Monday, Promociones Credex, etc.).', 'tech-store'),
        'section'     => 'tech_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_location', [
        'default'           => 'home',
        'sanitize_callback' => 'tech_store_sanitize_banner_location',
    ]);
    $wp_customize->add_control('tech_promo_banner_location', [
        'type'        => 'select',
        'label'       => __('Ubicación del Banner', 'tech-store'),
        'section'     => 'tech_store_promo_banner_section',
        'choices'     => [
            'home' => __('Solo en Página de Inicio', 'tech-store'),
            'shop' => __('Solo en Tienda / Catálogo', 'tech-store'),
            'all'  => __('En Inicio y Tienda', 'tech-store'),
        ],
    ]);

    $wp_customize->add_setting('tech_promo_banner_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'tech_promo_banner_image', [
        'label'       => __('Imagen de Fondo del Banner (Opcional)', 'tech-store'),
        'description' => __('Recomendado: 1400x400 px', 'tech-store'),
        'section'     => 'tech_store_promo_banner_section',
    ]));

    $wp_customize->add_setting('tech_promo_banner_badge', [
        'default'           => __('🔥 Promoción Especial por Tiempo Limitado', 'tech-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_promo_banner_badge', [
        'type'        => 'text',
        'label'       => __('Etiqueta Superior del Banner', 'tech-store'),
        'section'     => 'tech_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_title', [
        'default'           => __('Hasta 40% OFF en Celulares & Gaming', 'tech-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_promo_banner_title', [
        'type'        => 'text',
        'label'       => __('Título Principal del Banner', 'tech-store'),
        'section'     => 'tech_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_subtitle', [
        'default'           => __('Aprovecha descuentos únicos con entrega rápida en todo el país y financiamiento Credex sin intereses.', 'tech-store'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('tech_promo_banner_subtitle', [
        'type'        => 'textarea',
        'label'       => __('Descripción / Subtítulo', 'tech-store'),
        'section'     => 'tech_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_btn_text', [
        'default'           => __('Ver Ofertas Especiales', 'tech-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_promo_banner_btn_text', [
        'type'        => 'text',
        'label'       => __('Texto del Botón', 'tech-store'),
        'section'     => 'tech_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_btn_link', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('tech_promo_banner_btn_link', [
        'type'        => 'url',
        'label'       => __('Enlace del Botón (URL de destino)', 'tech-store'),
        'section'     => 'tech_store_promo_banner_section',
    ]);

    // ---------------------------------------------------------
    // 4. SECCIÓN: Barra Superior de Anuncios
    // ---------------------------------------------------------
    $wp_customize->add_section('tech_store_announcement_section', [
        'title'    => __('Barra Superior de Anuncios', 'tech-store'),
        'panel'    => 'tech_store_theme_options',
        'priority' => 25,
    ]);

    $wp_customize->add_setting('tech_show_announcement', [
        'default'           => true,
        'sanitize_callback' => 'tech_store_sanitize_checkbox',
    ]);
    $wp_customize->add_control('tech_show_announcement', [
        'type'        => 'checkbox',
        'label'       => __('Mostrar Barra de Anuncios Superior', 'tech-store'),
        'section'     => 'tech_store_announcement_section',
    ]);

    $wp_customize->add_setting('tech_announcement_text', [
        'default'           => __('💳 3 meses 0% intereses con Credex | Envíos rápidos y seguros a todo el país', 'tech-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_announcement_text', [
        'type'        => 'text',
        'label'       => __('Texto del Anuncio', 'tech-store'),
        'section'     => 'tech_store_announcement_section',
    ]);

    // ---------------------------------------------------------
    // 5. SECCIÓN: Envíos & Carrito
    // ---------------------------------------------------------
    $wp_customize->add_section('tech_store_shipping_cart_section', [
        'title'    => __('Envíos & Carrito Lateral', 'tech-store'),
        'panel'    => 'tech_store_theme_options',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('tech_free_shipping_threshold', [
        'default'           => 25000,
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('tech_free_shipping_threshold', [
        'type'        => 'number',
        'label'       => __('Monto Mínimo para Envío Gratis', 'tech-store'),
        'description' => __('Monto para la barra de progreso en el carrito.', 'tech-store'),
        'section'     => 'tech_store_shipping_cart_section',
    ]);

    // ---------------------------------------------------------
    // 6. SECCIÓN: Contacto, WhatsApp & Sucursales
    // ---------------------------------------------------------
    $wp_customize->add_section('tech_store_contact_branches_section', [
        'title'    => __('Contacto & Sucursales', 'tech-store'),
        'panel'    => 'tech_store_theme_options',
        'priority' => 40,
    ]);

    $wp_customize->add_setting('tech_whatsapp_number', [
        'default'           => '50557935010',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_whatsapp_number', [
        'type'        => 'text',
        'label'       => __('Número de WhatsApp (con código de país sin +)', 'tech-store'),
        'section'     => 'tech_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('tech_phone_secondary', [
        'default'           => '+505 8849 0653',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_phone_secondary', [
        'type'        => 'text',
        'label'       => __('Teléfono Secundario / Oficina', 'tech-store'),
        'section'     => 'tech_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('tech_branch_1', [
        'default'           => 'Esquina de los bancos 75 varas al este, Estelí, Nicaragua',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_branch_1', [
        'type'        => 'textarea',
        'label'       => __('Sucursal 1 (Estelí Central)', 'tech-store'),
        'section'     => 'tech_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('tech_branch_2', [
        'default'           => 'Súper Las Segovias media cuadra al sur, Estelí, Nicaragua',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_branch_2', [
        'type'        => 'textarea',
        'label'       => __('Sucursal 2 (Estelí)', 'tech-store'),
        'section'     => 'tech_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('tech_branch_3', [
        'default'           => 'Plaza Puntaldia, Managua, Nicaragua',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_branch_3', [
        'type'        => 'textarea',
        'label'       => __('Sucursal 3 (Managua)', 'tech-store'),
        'section'     => 'tech_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('tech_store_hours', [
        'default'           => "Lunes a Viernes: 8:00 AM ~ 6:00 PM\nSábados: 9:00 AM ~ 5:00 PM",
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('tech_store_hours', [
        'type'        => 'textarea',
        'label'       => __('Horario de Atención', 'tech-store'),
        'section'     => 'tech_store_contact_branches_section',
    ]);

    // ---------------------------------------------------------
    // 7. SECCIÓN: Portada (Hero Banner & Textos)
    // ---------------------------------------------------------
    $wp_customize->add_section('tech_store_hero_section', [
        'title'    => __('Portada & Textos Hero', 'tech-store'),
        'panel'    => 'tech_store_theme_options',
        'priority' => 50,
    ]);

    $wp_customize->add_setting('tech_hero_badge', [
        'default'           => __('⚡ 3 Meses 0% Interés con Credex', 'tech-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_hero_badge', [
        'type'        => 'text',
        'label'       => __('Badge / Etiqueta del Hero Banner', 'tech-store'),
        'section'     => 'tech_store_hero_section',
    ]);

    $wp_customize->add_setting('tech_hero_title', [
        'default'           => __('Tecnología de última generación a tu alcance.', 'tech-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_hero_title', [
        'type'        => 'text',
        'label'       => __('Título Principal del Hero', 'tech-store'),
        'section'     => 'tech_store_hero_section',
    ]);

    $wp_customize->add_setting('tech_hero_subtitle', [
        'default'           => __('Encuentra los últimos modelos en celulares, computadoras, gaming, audio y seguridad con respaldo oficial.', 'tech-store'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('tech_hero_subtitle', [
        'type'        => 'textarea',
        'label'       => __('Subtítulo del Hero', 'tech-store'),
        'section'     => 'tech_store_hero_section',
    ]);
}
add_action('customize_register', 'tech_store_customize_register');

/**
 * Sanitization Callbacks
 */
function tech_store_sanitize_checkbox($checked) {
    return (isset($checked) && true === (bool) $checked) ? true : false;
}

function tech_store_sanitize_font_family($font) {
    $valid = ['Inter', 'Montserrat', 'Plus Jakarta Sans', 'Poppins', 'Outfit'];
    return in_array($font, $valid, true) ? $font : 'Inter';
}

function tech_store_sanitize_columns($cols) {
    $valid = ['3', '4', '5'];
    return in_array($cols, $valid, true) ? $cols : '4';
}

function tech_store_banner_location($loc) {
    $valid = ['home', 'shop', 'all'];
    return in_array($loc, $valid, true) ? $loc : 'home';
}

/**
 * Dynamically Inject Customizer Colors (Primary & CTA) & Font into Head
 */
function tech_store_customizer_css() {
    $font_family          = get_theme_mod('tech_font_family', 'Inter');
    $primary_color        = get_theme_mod('tech_primary_color', '#0f172a');
    $primary_hover_color  = get_theme_mod('tech_primary_hover_color', '#020617');
    $cta_color            = get_theme_mod('tech_cta_color', '#2563eb');
    $cta_hover_color      = get_theme_mod('tech_cta_hover_color', '#1d4ed8');
    $announcement_bg      = get_theme_mod('tech_announcement_bg_color', '#0a0a0a');

    $custom_css = "
        :root {
            --font-sans: '{$font_family}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --color-primary: {$primary_color};
            --color-primary-dark: {$primary_hover_color};
            --color-cta: {$cta_color};
            --color-cta-hover: {$cta_hover_color};
            --color-announcement-bg: {$announcement_bg};
        }
        body, button, input, select, textarea {
            font-family: var(--font-sans) !important;
        }
        
        /* Dynamic Theme Primary Backgrounds (Structure / Identity / Sale Badges) */
        .bg-primary {
            background-color: var(--color-primary) !important;
        }
        .bg-primary-dark {
            background-color: var(--color-primary-dark) !important;
        }
        .text-primary {
            color: var(--color-primary) !important;
        }
        .border-primary {
            border-color: var(--color-primary) !important;
        }
        .hover\\:bg-primary-dark:hover {
            background-color: var(--color-primary-dark) !important;
        }

        /* Dynamic Discount Badge (Uses Primary Color from CMS) */
        .badge-sale {
            background-color: var(--color-primary) !important;
            color: #ffffff !important;
        }

        /* Dynamic Call to Action (CTA / Conversión) */
        .bg-cta {
            background-color: var(--color-cta) !important;
        }
        .text-cta {
            color: var(--color-cta) !important;
        }
        .border-cta {
            border-color: var(--color-cta) !important;
        }
        .hover\\:bg-cta-hover:hover {
            background-color: var(--color-cta-hover) !important;
        }

        /* Purchasing Buttons & High-Conversion CTAs */
        .ubx-btn-primary, 
        button.tech-ajax-add-to-cart, 
        #place_order, 
        form.cart .single_add_to_cart_button {
            background-color: var(--color-cta) !important;
            border-color: var(--color-cta) !important;
            color: #ffffff !important;
        }
        .ubx-btn-primary:hover, 
        button.tech-ajax-add-to-cart:hover, 
        #place_order:hover, 
        form.cart .single_add_to_cart_button:hover {
            background-color: var(--color-cta-hover) !important;
            border-color: var(--color-cta-hover) !important;
        }

        .ubx-pill-tab.active {
            background-color: var(--color-primary) !important;
            border-color: var(--color-primary) !important;
            color: #ffffff !important;
        }

        /* Active Page in Pagination (Uses Primary Color & White Text) */
        .woocommerce-pagination .page-numbers.current {
            background-color: var(--color-primary) !important;
            border-color: var(--color-primary) !important;
            color: #ffffff !important;
        }

        #tech-announcement-bar {
            background-color: var(--color-announcement-bg) !important;
        }
    ";

    wp_add_inline_style('tech-store-main-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'tech_store_customizer_css', 20);

/**
 * Filter Free Shipping Threshold with Customizer value
 */
function tech_store_customizer_free_shipping_threshold($threshold) {
    $mod_threshold = get_theme_mod('tech_free_shipping_threshold', 25000);
    return absint($mod_threshold);
}
add_filter('tech_store_free_shipping_threshold', 'tech_store_customizer_free_shipping_threshold');

/**
 * Filter Catalog Loop Columns with Customizer value
 */
function tech_store_customizer_loop_columns($columns) {
    $mod_cols = get_theme_mod('tech_shop_columns', '4');
    return absint($mod_cols);
}
add_filter('loop_shop_columns', 'tech_store_customizer_loop_columns', 20);
