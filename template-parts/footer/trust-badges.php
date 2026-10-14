<?php
/**
 * Footer Trust Badges / Value Propositions (Dynamic Primary Color)
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="bg-white border-y border-neutral-200/80 py-8">
    <div class="site-container">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Benefit 1 -->
            <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-neutral-50 border border-neutral-100">
                <div class="p-3 bg-primary text-white rounded-xl shadow-sm flex-shrink-0">
                    <?php echo alex_store_svg_icon('truck', 'w-5 h-5'); ?>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-neutral-900 mb-0.5">
                        <?php esc_html_e('Envíos a Todo el País', 'alex-store'); ?>
                    </h4>
                    <p class="text-[11px] sm:text-xs text-neutral-500">
                        <?php esc_html_e('Entregas rápidas y seguras directo a tu puerta.', 'alex-store'); ?>
                    </p>
                </div>
            </div>

            <!-- Benefit 2 -->
            <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-neutral-50 border border-neutral-100">
                <div class="p-3 bg-primary text-white rounded-xl shadow-sm flex-shrink-0">
                    <?php echo alex_store_svg_icon('credit', 'w-5 h-5'); ?>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-neutral-900 mb-0.5">
                        <?php esc_html_e('Crédito con Credex', 'alex-store'); ?>
                    </h4>
                    <p class="text-[11px] sm:text-xs text-neutral-500">
                        <?php esc_html_e('Hasta 3 meses sin intereses en tus compras.', 'alex-store'); ?>
                    </p>
                </div>
            </div>

            <!-- Benefit 3 -->
            <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-neutral-50 border border-neutral-100">
                <div class="p-3 bg-primary text-white rounded-xl shadow-sm flex-shrink-0">
                    <?php echo alex_store_svg_icon('award', 'w-5 h-5'); ?>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-neutral-900 mb-0.5">
                        <?php esc_html_e('Garantía Oficial', 'alex-store'); ?>
                    </h4>
                    <p class="text-[11px] sm:text-xs text-neutral-500">
                        <?php esc_html_e('Productos originales con respaldo directo.', 'alex-store'); ?>
                    </p>
                </div>
            </div>

            <!-- Benefit 4 -->
            <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-neutral-50 border border-neutral-100">
                <div class="p-3 bg-primary text-white rounded-xl shadow-sm flex-shrink-0">
                    <?php echo alex_store_svg_icon('headphones', 'w-5 h-5'); ?>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-neutral-900 mb-0.5">
                        <?php esc_html_e('Atención Personalizada', 'alex-store'); ?>
                    </h4>
                    <p class="text-[11px] sm:text-xs text-neutral-500">
                        <?php esc_html_e('Soporte continuo vía WhatsApp y tiendas físicas.', 'alex-store'); ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
