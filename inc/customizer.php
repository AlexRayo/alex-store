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
function alex_store_customize_register($wp_customize) {

    // =========================================================
    // PANEL: Ajustes de la Tienda (Tech Store / MR Soluciones)
    // =========================================================
    $wp_customize->add_panel('alex_store_theme_options', [
        'title'       => __('Opciones de Tienda (Tech Store)', 'alex-store'),
        'description' => __('Personaliza colores, tipografías, anuncios, columnas del catálogo, promociones, envíos y sucursales.', 'alex-store'),
        'priority'    => 25,
    ]);

    // ---------------------------------------------------------
    // 1. SECCIÓN: Colores & Tipografía
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_colors_typography_section', [
        'title'    => __('Colores & Tipografía', 'alex-store'),
        'panel'    => 'alex_store_theme_options',
        'priority' => 10,
    ]);

    // Selector de Tipografía
    $wp_customize->add_setting('tech_font_family', [
        'default'           => 'Inter',
        'sanitize_callback' => 'alex_store_sanitize_font_family',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('tech_font_family', [
        'type'        => 'select',
        'label'       => __('Tipografía Principal (Google Fonts)', 'alex-store'),
        'description' => __('Selecciona la fuente tipográfica de la tienda.', 'alex-store'),
        'section'     => 'alex_store_colors_typography_section',
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
        'label'       => __('Color Primario (Marca / Banners / Badges / Estructura)', 'alex-store'),
        'description' => __('Color de cabeceras, banners hero, promociones, badges de descuento y footer.', 'alex-store'),
        'section'     => 'alex_store_colors_typography_section',
    ]));

    // Color Primario al Hover / Oscuro
    $wp_customize->add_setting('tech_primary_hover_color', [
        'default'           => '#020617',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tech_primary_hover_color', [
        'label'       => __('Color Primario Oscuro (Hover en Banners)', 'alex-store'),
        'section'     => 'alex_store_colors_typography_section',
    ]));

    // Color Call to Action (CTA - Botones de Compra / Checkout)
    $wp_customize->add_setting('tech_cta_color', [
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tech_cta_color', [
        'label'       => __('Color Call to Action (CTA / Botones de Compra)', 'alex-store'),
        'description' => __('Color para los botones de Añadir al Carrito, Finalizar Compra y compra rápida.', 'alex-store'),
        'section'     => 'alex_store_colors_typography_section',
    ]));

    // Color CTA Hover
    $wp_customize->add_setting('tech_cta_hover_color', [
        'default'           => '#1d4ed8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tech_cta_hover_color', [
        'label'       => __('Color CTA al Hover (Botones de Compra)', 'alex-store'),
        'section'     => 'alex_store_colors_typography_section',
    ]));

    // Color de Fondo de Barra de Anuncios
    $wp_customize->add_setting('tech_announcement_bg_color', [
        'default'           => '#0a0a0a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tech_announcement_bg_color', [
        'label'       => __('Fondo de Barra de Anuncios Superior', 'alex-store'),
        'section'     => 'alex_store_colors_typography_section',
    ]));

    // ---------------------------------------------------------
    // 2. SECCIÓN: Grid del Catálogo (Columnas)
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_catalog_grid_section', [
        'title'    => __('Catálogo de Tienda (Columnas)', 'alex-store'),
        'panel'    => 'alex_store_theme_options',
        'priority' => 15,
    ]);

    $wp_customize->add_setting('tech_shop_columns', [
        'default'           => '4',
        'sanitize_callback' => 'alex_store_sanitize_columns',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('tech_shop_columns', [
        'type'        => 'select',
        'label'       => __('Número de Columnas en Catálogo (Escritorio)', 'alex-store'),
        'description' => __('Ajusta la cantidad de productos por fila en pantallas grandes.', 'alex-store'),
        'section'     => 'alex_store_catalog_grid_section',
        'choices'     => [
            '3' => __('3 Columnas (Tarjetas Grandes)', 'alex-store'),
            '4' => __('4 Columnas (Estándar Recomendado)', 'alex-store'),
            '5' => __('5 Columnas (Alta Densidad)', 'alex-store'),
        ],
    ]);

    // ---------------------------------------------------------
    // 3. SECCIÓN: Banner de Promoción Temporal (Campañas / Eventos)
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_promo_banner_section', [
        'title'    => __('Banner de Promoción Temporal', 'alex-store'),
        'panel'    => 'alex_store_theme_options',
        'priority' => 20,
    ]);

    $wp_customize->add_setting('tech_promo_banner_enable', [
        'default'           => false,
        'sanitize_callback' => 'alex_store_sanitize_checkbox',
    ]);
    $wp_customize->add_control('tech_promo_banner_enable', [
        'type'        => 'checkbox',
        'label'       => __('Activar Banner de Promoción Temporal', 'alex-store'),
        'description' => __('Muestra un banner destacado para eventos especiales (Black Friday, Cyber Monday, Promociones Credex, etc.).', 'alex-store'),
        'section'     => 'alex_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_location', [
        'default'           => 'home',
        'sanitize_callback' => 'alex_store_sanitize_banner_location',
    ]);
    $wp_customize->add_control('tech_promo_banner_location', [
        'type'        => 'select',
        'label'       => __('Ubicación del Banner', 'alex-store'),
        'section'     => 'alex_store_promo_banner_section',
        'choices'     => [
            'home' => __('Solo en Página de Inicio', 'alex-store'),
            'shop' => __('Solo en Tienda / Catálogo', 'alex-store'),
            'all'  => __('En Inicio y Tienda', 'alex-store'),
        ],
    ]);

    $wp_customize->add_setting('tech_promo_banner_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'tech_promo_banner_image', [
        'label'       => __('Imagen de Fondo del Banner (Opcional)', 'alex-store'),
        'description' => __('Recomendado: 1400x400 px', 'alex-store'),
        'section'     => 'alex_store_promo_banner_section',
    ]));

    $wp_customize->add_setting('tech_promo_banner_badge', [
        'default'           => __('Promoción Especial por Tiempo Limitado', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_promo_banner_badge', [
        'type'        => 'text',
        'label'       => __('Etiqueta Superior del Banner', 'alex-store'),
        'section'     => 'alex_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_title', [
        'default'           => __('Hasta 40% OFF en Celulares & Gaming', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_promo_banner_title', [
        'type'        => 'text',
        'label'       => __('Título Principal del Banner', 'alex-store'),
        'section'     => 'alex_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_subtitle', [
        'default'           => __('Aprovecha descuentos únicos con entrega rápida en todo el país y financiamiento Credex sin intereses.', 'alex-store'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('tech_promo_banner_subtitle', [
        'type'        => 'textarea',
        'label'       => __('Descripción / Subtítulo', 'alex-store'),
        'section'     => 'alex_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_btn_text', [
        'default'           => __('Ver Ofertas Especiales', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_promo_banner_btn_text', [
        'type'        => 'text',
        'label'       => __('Texto del Botón', 'alex-store'),
        'section'     => 'alex_store_promo_banner_section',
    ]);

    $wp_customize->add_setting('tech_promo_banner_btn_link', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('tech_promo_banner_btn_link', [
        'type'        => 'url',
        'label'       => __('Enlace del Botón (URL de destino)', 'alex-store'),
        'section'     => 'alex_store_promo_banner_section',
    ]);

    // ---------------------------------------------------------
    // 4. SECCIÓN: Barra Superior de Anuncios
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_announcement_section', [
        'title'    => __('Barra Superior de Anuncios', 'alex-store'),
        'panel'    => 'alex_store_theme_options',
        'priority' => 25,
    ]);

    $wp_customize->add_setting('tech_show_announcement', [
        'default'           => true,
        'sanitize_callback' => 'alex_store_sanitize_checkbox',
    ]);
    $wp_customize->add_control('tech_show_announcement', [
        'type'        => 'checkbox',
        'label'       => __('Mostrar Barra de Anuncios Superior', 'alex-store'),
        'section'     => 'alex_store_announcement_section',
    ]);

    $wp_customize->add_setting('tech_announcement_text', [
        'default'           => __('3 meses 0% intereses con Credex | Envíos rápidos y seguros a todo el país', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_announcement_text', [
        'type'        => 'text',
        'label'       => __('Texto del Anuncio', 'alex-store'),
        'section'     => 'alex_store_announcement_section',
    ]);

    // ---------------------------------------------------------
    // 5. SECCIÓN: Envíos & Carrito
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_shipping_cart_section', [
        'title'    => __('Envíos & Carrito Lateral', 'alex-store'),
        'panel'    => 'alex_store_theme_options',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('tech_free_shipping_threshold', [
        'default'           => 25000,
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('tech_free_shipping_threshold', [
        'type'        => 'number',
        'label'       => __('Monto Mínimo para Envío Gratis', 'alex-store'),
        'description' => __('Monto para la barra de progreso en el carrito.', 'alex-store'),
        'section'     => 'alex_store_shipping_cart_section',
    ]);

    // ---------------------------------------------------------
    // 6. SECCIÓN: Contacto, WhatsApp & Sucursales
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_contact_branches_section', [
        'title'    => __('Contacto & Sucursales', 'alex-store'),
        'panel'    => 'alex_store_theme_options',
        'priority' => 40,
    ]);

    $wp_customize->add_setting('tech_whatsapp_number', [
        'default'           => '50557935010',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_whatsapp_number', [
        'type'        => 'text',
        'label'       => __('Número de WhatsApp (con código de país sin +)', 'alex-store'),
        'section'     => 'alex_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('tech_phone_secondary', [
        'default'           => '+505 8849 0653',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_phone_secondary', [
        'type'        => 'text',
        'label'       => __('Teléfono Secundario / Oficina', 'alex-store'),
        'section'     => 'alex_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('tech_branch_1', [
        'default'           => 'Esquina de los bancos 75 varas al este, Estelí, Nicaragua',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_branch_1', [
        'type'        => 'textarea',
        'label'       => __('Sucursal 1 (Estelí Central)', 'alex-store'),
        'section'     => 'alex_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('tech_branch_2', [
        'default'           => 'Súper Las Segovias media cuadra al sur, Estelí, Nicaragua',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_branch_2', [
        'type'        => 'textarea',
        'label'       => __('Sucursal 2 (Estelí)', 'alex-store'),
        'section'     => 'alex_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('tech_branch_3', [
        'default'           => 'Plaza Puntaldia, Managua, Nicaragua',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('tech_branch_3', [
        'type'        => 'textarea',
        'label'       => __('Sucursal 3 (Managua)', 'alex-store'),
        'section'     => 'alex_store_contact_branches_section',
    ]);

    $wp_customize->add_setting('alex_store_hours', [
        'default'           => "Lunes a Viernes: 8:00 AM ~ 6:00 PM\nSábados: 9:00 AM ~ 5:00 PM",
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('alex_store_hours', [
        'type'        => 'textarea',
        'label'       => __('Horario de Atención', 'alex-store'),
        'section'     => 'alex_store_contact_branches_section',
    ]);

    // ---------------------------------------------------------
    // 7. SECCIÓN: Hero Slider - Diapositiva 1 (Principal)
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_slide1_section', [
        'title'       => __('Hero Slider: Diapositiva 1', 'alex-store'),
        'panel'       => 'alex_store_theme_options',
        'priority'    => 50,
        'description' => __('Personaliza el primer slide del hero (Smartphones & Ecosistema).', 'alex-store'),
    ]);

    // Badge
    $wp_customize->add_setting('alex_slide1_badge', [
        'default'           => __('3 Meses 0% Interés con Credex', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide1_badge', [
        'type'        => 'text',
        'label'       => __('Badge / Etiqueta Superior', 'alex-store'),
        'section'     => 'alex_store_slide1_section',
    ]);

    // Título
    $wp_customize->add_setting('alex_slide1_title', [
        'default'           => __('Tecnología de última generación a tu alcance.', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide1_title', [
        'type'        => 'text',
        'label'       => __('Título Principal', 'alex-store'),
        'section'     => 'alex_store_slide1_section',
    ]);

    // Subtítulo
    $wp_customize->add_setting('alex_slide1_subtitle', [
        'default'           => __('Encuentra los últimos modelos en celulares, computadoras, gaming, audio y seguridad con respaldo oficial.', 'alex-store'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('alex_slide1_subtitle', [
        'type'        => 'textarea',
        'label'       => __('Descripción / Subtítulo', 'alex-store'),
        'section'     => 'alex_store_slide1_section',
    ]);

    // Specs Telemetry Pills (separadas por comas)
    $wp_customize->add_setting('alex_slide1_pills', [
        'default'           => 'Pantallas OLED 120Hz, Garantía Oficial 1 Año, Envíos Rápidos',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide1_pills', [
        'type'        => 'text',
        'label'       => __('Etiquetas de Especificaciones (Separadas por comas)', 'alex-store'),
        'description' => __('Ejemplo: Pantallas OLED 120Hz, Garantía Oficial 1 Año, Envíos Rápidos', 'alex-store'),
        'section'     => 'alex_store_slide1_section',
    ]);

    // Botón 1 Texto
    $wp_customize->add_setting('alex_slide1_btn1_text', [
        'default'           => __('Ver Catálogo Completo', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide1_btn1_text', [
        'type'        => 'text',
        'label'       => __('Texto Botón 1 (Principal)', 'alex-store'),
        'section'     => 'alex_store_slide1_section',
    ]);

    // Botón 1 URL
    $wp_customize->add_setting('alex_slide1_btn1_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('alex_slide1_btn1_url', [
        'type'        => 'url',
        'label'       => __('Enlace Botón 1 (URL)', 'alex-store'),
        'description' => __('Deja vacío para redirigir a la tienda automáticamente.', 'alex-store'),
        'section'     => 'alex_store_slide1_section',
    ]);

    // Botón 2 Texto
    $wp_customize->add_setting('alex_slide1_btn2_text', [
        'default'           => __('Explorar Celulares', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide1_btn2_text', [
        'type'        => 'text',
        'label'       => __('Texto Botón 2 (Secundario)', 'alex-store'),
        'section'     => 'alex_store_slide1_section',
    ]);

    // Botón 2 URL
    $wp_customize->add_setting('alex_slide1_btn2_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('alex_slide1_btn2_url', [
        'type'        => 'url',
        'label'       => __('Enlace Botón 2 (URL)', 'alex-store'),
        'section'     => 'alex_store_slide1_section',
    ]);

    // Imagen de Fondo Opcional
    $wp_customize->add_setting('alex_slide1_bg_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alex_slide1_bg_image', [
        'label'       => __('Imagen de Fondo Slide 1 (Opcional)', 'alex-store'),
        'description' => __('Imagen panorámica recomendada: 1200x500 px', 'alex-store'),
        'section'     => 'alex_store_slide1_section',
    ]));

    // ---------------------------------------------------------
    // 8. SECCIÓN: Hero Slider - Diapositiva 2 (Gaming & PC)
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_slide2_section', [
        'title'       => __('Hero Slider: Diapositiva 2', 'alex-store'),
        'panel'       => 'alex_store_theme_options',
        'priority'    => 52,
        'description' => __('Personaliza el segundo slide del hero (Gaming, PC & Laptops).', 'alex-store'),
    ]);

    $wp_customize->add_setting('alex_slide2_badge', [
        'default'           => __('ALTO RENDIMIENTO & GAMING', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide2_badge', [
        'type'        => 'text',
        'label'       => __('Badge / Etiqueta Superior', 'alex-store'),
        'section'     => 'alex_store_slide2_section',
    ]);

    $wp_customize->add_setting('alex_slide2_title', [
        'default'           => __('Laptops Pro & Setups Gaming de Élite', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide2_title', [
        'type'        => 'text',
        'label'       => __('Título Principal', 'alex-store'),
        'section'     => 'alex_store_slide2_section',
    ]);

    $wp_customize->add_setting('alex_slide2_subtitle', [
        'default'           => __('Potencia sin límites para programadores, creadores y gamers. Laptops con GPU RTX serie 40, procesadores M3 y monitores de alta frecuencia.', 'alex-store'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('alex_slide2_subtitle', [
        'type'        => 'textarea',
        'label'       => __('Descripción / Subtítulo', 'alex-store'),
        'section'     => 'alex_store_slide2_section',
    ]);

    $wp_customize->add_setting('alex_slide2_pills', [
        'default'           => 'RTX Serie 40 Ready, 32GB RAM DDR5, Monitores 240Hz',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide2_pills', [
        'type'        => 'text',
        'label'       => __('Etiquetas de Especificaciones', 'alex-store'),
        'section'     => 'alex_store_slide2_section',
    ]);

    $wp_customize->add_setting('alex_slide2_btn1_text', [
        'default'           => __('Explorar Gaming & PC', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide2_btn1_text', [
        'type'        => 'text',
        'label'       => __('Texto Botón 1 (Principal)', 'alex-store'),
        'section'     => 'alex_store_slide2_section',
    ]);

    $wp_customize->add_setting('alex_slide2_btn1_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('alex_slide2_btn1_url', [
        'type'        => 'url',
        'label'       => __('Enlace Botón 1 (URL)', 'alex-store'),
        'section'     => 'alex_store_slide2_section',
    ]);

    $wp_customize->add_setting('alex_slide2_btn2_text', [
        'default'           => __('Ver Laptops', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide2_btn2_text', [
        'type'        => 'text',
        'label'       => __('Texto Botón 2 (Secundario)', 'alex-store'),
        'section'     => 'alex_store_slide2_section',
    ]);

    $wp_customize->add_setting('alex_slide2_btn2_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('alex_slide2_btn2_url', [
        'type'        => 'url',
        'label'       => __('Enlace Botón 2 (URL)', 'alex-store'),
        'section'     => 'alex_store_slide2_section',
    ]);

    $wp_customize->add_setting('alex_slide2_bg_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alex_slide2_bg_image', [
        'label'       => __('Imagen de Fondo Slide 2 (Opcional)', 'alex-store'),
        'section'     => 'alex_store_slide2_section',
    ]));

    // ---------------------------------------------------------
    // 9. SECCIÓN: Hero Slider - Diapositiva 3 (Audio & Cuotas)
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_slide3_section', [
        'title'       => __('Hero Slider: Diapositiva 3', 'alex-store'),
        'panel'       => 'alex_store_theme_options',
        'priority'    => 54,
        'description' => __('Personaliza el tercer slide del hero (Audio, Smart Home & Cuotas Credex).', 'alex-store'),
    ]);

    $wp_customize->add_setting('alex_slide3_badge', [
        'default'           => __('FINANCIAMIENTO 0% INTERÉS', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide3_badge', [
        'type'        => 'text',
        'label'       => __('Badge / Etiqueta Superior', 'alex-store'),
        'section'     => 'alex_store_slide3_section',
    ]);

    $wp_customize->add_setting('alex_slide3_title', [
        'default'           => __('Sonido Inmersivo & Facilidades con Credex', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide3_title', [
        'type'        => 'text',
        'label'       => __('Título Principal', 'alex-store'),
        'section'     => 'alex_store_slide3_section',
    ]);

    $wp_customize->add_setting('alex_slide3_subtitle', [
        'default'           => __('Audífonos con cancelación de ruido activa, asistentes de voz Alexa y seguridad para tu hogar. Llévatelo hoy hasta en 3 meses al 0%.', 'alex-store'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('alex_slide3_subtitle', [
        'type'        => 'textarea',
        'label'       => __('Descripción / Subtítulo', 'alex-store'),
        'section'     => 'alex_store_slide3_section',
    ]);

    $wp_customize->add_setting('alex_slide3_pills', [
        'default'           => 'Cancelación Activa ANC, 3 Meses 0% con Credex, Smart Living',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide3_pills', [
        'type'        => 'text',
        'label'       => __('Etiquetas de Especificaciones', 'alex-store'),
        'section'     => 'alex_store_slide3_section',
    ]);

    $wp_customize->add_setting('alex_slide3_btn1_text', [
        'default'           => __('Solicitar Cuotas por WhatsApp', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide3_btn1_text', [
        'type'        => 'text',
        'label'       => __('Texto Botón 1 (WhatsApp / Principal)', 'alex-store'),
        'section'     => 'alex_store_slide3_section',
    ]);

    $wp_customize->add_setting('alex_slide3_btn1_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('alex_slide3_btn1_url', [
        'type'        => 'url',
        'label'       => __('Enlace Botón 1 (URL)', 'alex-store'),
        'description' => __('Deja vacío para usar el WhatsApp configurado en la tienda.', 'alex-store'),
        'section'     => 'alex_store_slide3_section',
    ]);

    $wp_customize->add_setting('alex_slide3_btn2_text', [
        'default'           => __('Ver Colección de Audio', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_slide3_btn2_text', [
        'type'        => 'text',
        'label'       => __('Texto Botón 2 (Secundario)', 'alex-store'),
        'section'     => 'alex_store_slide3_section',
    ]);

    $wp_customize->add_setting('alex_slide3_btn2_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('alex_slide3_btn2_url', [
        'type'        => 'url',
        'label'       => __('Enlace Botón 2 (URL)', 'alex-store'),
        'section'     => 'alex_store_slide3_section',
    ]);

    $wp_customize->add_setting('alex_slide3_bg_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alex_slide3_bg_image', [
        'label'       => __('Imagen de Fondo Slide 3 (Opcional)', 'alex-store'),
        'section'     => 'alex_slide3_section',
    ]));

    // ---------------------------------------------------------
    // 10. SECCIÓN: Hero - Banners Laterales
    // ---------------------------------------------------------
    $wp_customize->add_section('alex_store_side_banners_section', [
        'title'       => __('Hero: Banners Laterales', 'alex-store'),
        'panel'       => 'alex_store_theme_options',
        'priority'    => 56,
        'description' => __('Personaliza los dos banners tech ubicados a la par del slider.', 'alex-store'),
    ]);

    // Banner Superior
    $wp_customize->add_setting('alex_side1_badge', [
        'default'           => __('Sonido & Smart Living', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_side1_badge', [
        'type'        => 'text',
        'label'       => __('Banner 1 (Arriba): Etiqueta', 'alex-store'),
        'section'     => 'alex_store_side_banners_section',
    ]);

    $wp_customize->add_setting('alex_side1_title', [
        'default'           => __('Asistentes de Voz & Audio', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_side1_title', [
        'type'        => 'text',
        'label'       => __('Banner 1: Título', 'alex-store'),
        'section'     => 'alex_store_side_banners_section',
    ]);

    $wp_customize->add_setting('alex_side1_desc', [
        'default'           => __('Amazon Alexa, audífonos con cancelación de ruido y parlantes inteligentes.', 'alex-store'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('alex_side1_desc', [
        'type'        => 'textarea',
        'label'       => __('Banner 1: Descripción', 'alex-store'),
        'section'     => 'alex_store_side_banners_section',
    ]);

    $wp_customize->add_setting('alex_side1_link', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('alex_side1_link', [
        'type'        => 'url',
        'label'       => __('Banner 1: Enlace URL', 'alex-store'),
        'section'     => 'alex_store_side_banners_section',
    ]);

    // Banner Inferior
    $wp_customize->add_setting('alex_side2_badge', [
        'default'           => __('Facilidades de Pago', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_side2_badge', [
        'type'        => 'text',
        'label'       => __('Banner 2 (Abajo): Etiqueta', 'alex-store'),
        'section'     => 'alex_store_side_banners_section',
    ]);

    $wp_customize->add_setting('alex_side2_title', [
        'default'           => __('Compra en Cuotas sin Intereses', 'alex-store'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('alex_side2_title', [
        'type'        => 'text',
        'label'       => __('Banner 2: Título', 'alex-store'),
        'section'     => 'alex_store_side_banners_section',
    ]);

    $wp_customize->add_setting('alex_side2_desc', [
        'default'           => __('Aplica con Credex y tarjetas bancarias en minutos con entrega inmediata.', 'alex-store'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('alex_side2_desc', [
        'type'        => 'textarea',
        'label'       => __('Banner 2: Descripción', 'alex-store'),
        'section'     => 'alex_store_side_banners_section',
    ]);

    $wp_customize->add_setting('alex_side2_link', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('alex_side2_link', [
        'type'        => 'url',
        'label'       => __('Banner 2: Enlace URL', 'alex-store'),
        'section'     => 'alex_store_side_banners_section',
    ]);
}
add_action('customize_register', 'alex_store_customize_register');

/**
 * Sanitization Callbacks
 */
function alex_store_sanitize_checkbox($checked) {
    return (isset($checked) && true === (bool) $checked) ? true : false;
}

function alex_store_sanitize_font_family($font) {
    $valid = ['Inter', 'Montserrat', 'Plus Jakarta Sans', 'Poppins', 'Outfit'];
    return in_array($font, $valid, true) ? $font : 'Inter';
}

function alex_store_sanitize_columns($cols) {
    $valid = ['3', '4', '5'];
    return in_array($cols, $valid, true) ? $cols : '4';
}

function alex_store_banner_location($loc) {
    $valid = ['home', 'shop', 'all'];
    return in_array($loc, $valid, true) ? $loc : 'home';
}

/**
 * Dynamically Inject Customizer Colors (Primary & CTA) & Font into Head
 */
function alex_store_customizer_css() {
    $font_family          = get_theme_mod('alex_font_family', get_theme_mod('tech_font_family', 'Inter'));
    $primary_color        = get_theme_mod('alex_primary_color', get_theme_mod('tech_primary_color', '#0f172a'));
    $primary_hover_color  = get_theme_mod('alex_primary_hover_color', get_theme_mod('tech_primary_hover_color', '#020617'));
    $cta_color            = get_theme_mod('alex_cta_color', get_theme_mod('tech_cta_color', '#2563eb'));
    $cta_hover_color      = get_theme_mod('alex_cta_hover_color', get_theme_mod('tech_cta_hover_color', '#1d4ed8'));
    $announcement_bg      = get_theme_mod('alex_announcement_bg_color', get_theme_mod('tech_announcement_bg_color', '#0a0a0a'));

    $custom_css = "
        :root {
            --font-sans: '{$font_family}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --color-primary: {$primary_color};
            --color-primary-dark: {$primary_hover_color};
            --color-cta: {$cta_color};
            --color-cta-hover: {$cta_hover_color};
            --color-announcement-bg: {$announcement_bg};
            --ring: {$cta_color};
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
add_action('wp_enqueue_scripts', 'alex_store_customizer_css', 20);

/**
 * Filter Free Shipping Threshold with Customizer value
 */
function alex_store_customizer_free_shipping_threshold($threshold) {
    $mod_threshold = get_theme_mod('tech_free_shipping_threshold', 25000);
    return absint($mod_threshold);
}
add_filter('alex_store_free_shipping_threshold', 'alex_store_customizer_free_shipping_threshold');

/**
 * Filter Catalog Loop Columns with Customizer value
 */
function alex_store_customizer_loop_columns($columns) {
    $mod_cols = get_theme_mod('tech_shop_columns', '4');
    return absint($mod_cols);
}
add_filter('loop_shop_columns', 'alex_store_customizer_loop_columns', 20);
