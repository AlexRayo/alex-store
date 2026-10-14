<?php
/**
 * Footer Main Navigation & Info (Customizer-connected)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

$categories = [];
if (class_exists('WooCommerce')) {
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'number'     => 6,
    ]);
}

$whatsapp_num   = get_theme_mod('alex_whatsapp_number', get_theme_mod('tech_whatsapp_number', '50557935010'));
$phone_sec      = get_theme_mod('alex_phone_secondary', get_theme_mod('tech_phone_secondary', '+505 8849 0653'));
$branch_1       = get_theme_mod('alex_branch_1', get_theme_mod('tech_branch_1', 'Esquina de los bancos 75 varas al este, Estelí, Nicaragua'));
$branch_2       = get_theme_mod('alex_branch_2', get_theme_mod('tech_branch_2', 'Súper Las Segovias media cuadra al sur, Estelí, Nicaragua'));
$branch_3       = get_theme_mod('alex_branch_3', get_theme_mod('tech_branch_3', 'Plaza Puntaldia, Managua, Nicaragua'));
$store_hours    = get_theme_mod('alex_store_hours', get_theme_mod('alex_store_hours', "Lunes a Viernes: 8:00 AM ~ 6:00 PM\nSábados: 9:00 AM ~ 5:00 PM"));
?>

<div class="bg-neutral-900 text-neutral-300 pt-12 pb-20 md:pb-12 border-t border-neutral-800">
    <div class="site-container">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
            
            <!-- Column 1: Brand & Description -->
            <div class="lg:col-span-2 space-y-4">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-neutral-950 font-black text-sm">
                        MR
                    </span>
                    <span class="text-lg font-black tracking-tight text-white uppercase">
                        MR<span class="text-neutral-400">SOLUCIONES</span>
                    </span>
                </a>
                <p class="text-xs text-neutral-400 leading-relaxed max-w-sm">
                    <?php esc_html_e('Especialistas en tecnología, telefonía móvil, computación, audio, gaming y sistemas de seguridad. Ofrecemos financiamiento sin intereses y envíos a todo el país.', 'alex-store'); ?>
                </p>

                <div class="pt-2">
                    <a 
                        href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp_num)); ?>" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 bg-neutral-800 border border-neutral-700 text-white font-semibold px-3.5 py-2 rounded-xl text-xs hover:bg-neutral-700 transition-colors"
                    >
                        <?php echo alex_store_svg_icon('whatsapp', 'w-4 h-4 text-emerald-400'); ?>
                        <span>WhatsApp: <?php echo esc_html($whatsapp_num); ?></span>
                    </a>
                </div>
            </div>

            <!-- Column 2: Sucursales (Visítanos) -->
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">
                    <?php esc_html_e('Nuestras Sucursales', 'alex-store'); ?>
                </h4>
                <ul class="space-y-2.5 text-xs text-neutral-400">
                    <?php if ($branch_1) : ?>
                        <li>
                            <strong class="text-neutral-200 block"><?php esc_html_e('Estelí (Central):', 'alex-store'); ?></strong>
                            <?php echo esc_html($branch_1); ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($branch_2) : ?>
                        <li>
                            <strong class="text-neutral-200 block"><?php esc_html_e('Estelí (Sucursal 2):', 'alex-store'); ?></strong>
                            <?php echo esc_html($branch_2); ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($branch_3) : ?>
                        <li>
                            <strong class="text-neutral-200 block"><?php esc_html_e('Managua:', 'alex-store'); ?></strong>
                            <?php echo esc_html($branch_3); ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Column 3: Horarios & Atención -->
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">
                    <?php esc_html_e('Horario de Atención', 'alex-store'); ?>
                </h4>
                <div class="text-xs text-neutral-400 whitespace-pre-line leading-relaxed">
                    <?php echo esc_html($store_hours); ?>
                </div>
            </div>

            <!-- Column 4: Links & Políticas -->
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">
                    <?php esc_html_e('Información', 'alex-store'); ?>
                </h4>
                <ul class="space-y-2 text-xs text-neutral-400 font-medium">
                    <li><a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('shop')) : '#'; ?>" class="hover:text-white transition-colors"><?php esc_html_e('Tienda Online', 'alex-store'); ?></a></li>
                    <li><a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('myaccount')) : '#'; ?>" class="hover:text-white transition-colors"><?php esc_html_e('Mi Cuenta', 'alex-store'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/politica-de-privacidad')); ?>" class="hover:text-white transition-colors"><?php esc_html_e('Política de Privacidad', 'alex-store'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/terminos-y-condiciones')); ?>" class="hover:text-white transition-colors"><?php esc_html_e('Términos y Condiciones', 'alex-store'); ?></a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom Bar / Payment Methods & Copyright -->
        <div class="pt-8 border-t border-neutral-800 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs text-neutral-500 text-center md:text-left">
                &copy; <?php echo date('Y'); ?> <span class="font-semibold text-neutral-300">MR Soluciones</span>. <?php esc_html_e('Todos los derechos reservados. Tecnología a tu alcance.', 'alex-store'); ?>
            </p>

            <!-- Payment badges placeholder -->
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 text-[10px] font-bold tracking-wider bg-neutral-800 border border-neutral-700 rounded text-neutral-300">CREDEX</span>
                <span class="px-2.5 py-1 text-[10px] font-bold tracking-wider bg-neutral-800 border border-neutral-700 rounded text-neutral-300">VISA</span>
                <span class="px-2.5 py-1 text-[10px] font-bold tracking-wider bg-neutral-800 border border-neutral-700 rounded text-neutral-300">MASTERCARD</span>
                <span class="px-2.5 py-1 text-[10px] font-bold tracking-wider bg-neutral-800 border border-neutral-700 rounded text-neutral-300">TRANSFERENCIA</span>
            </div>
        </div>
    </div>
</div>
