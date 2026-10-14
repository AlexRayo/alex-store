<?php
/**
 * Checkout login form
 *
 * @package TechStore
 * @version 3.8.0
 */

defined('ABSPATH') || exit;

if (is_user_logged_in() || 'no' === get_option('woocommerce_enable_checkout_login_reminder')) {
    return;
}
?>
<div class="woocommerce-form-login-toggle mb-6">
    <div class="p-4 rounded-2xl bg-neutral-50 border border-neutral-200 shadow-subtle flex items-center justify-between">
        <div class="flex items-center gap-2.5 text-xs text-neutral-700 font-medium">
            <?php echo alex_store_svg_icon('user', 'w-4 h-4 text-neutral-500'); ?>
            <span><?php esc_html_e('¿Ya eres cliente de Tech Store?', 'alex-store'); ?></span>
        </div>
        <a href="#" class="showlogin text-xs font-bold text-cta hover:text-cta-hover transition-colors underline decoration-2 underline-offset-2">
            <?php esc_html_e('Inicia sesión aquí', 'alex-store'); ?>
        </a>
    </div>
</div>

<?php
woocommerce_login_form(
    [
        'message'  => esc_html__('Si ya has comprado con nosotros antes, por favor introduce tus datos a continuación.', 'alex-store'),
        'redirect' => wc_get_checkout_url(),
        'hidden'   => true,
    ]
);
