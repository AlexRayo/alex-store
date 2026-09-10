<?php
/**
 * Checkout Billing Information Template
 *
 * @package TechStore
 * @version 3.6.0
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-billing-fields">
    
    <div class="flex items-center justify-between pb-4 border-b border-neutral-100 mb-6">
        <h3 class="text-lg font-black text-neutral-900 flex items-center gap-2.5">
            <span class="w-7 h-7 rounded-xl bg-primary text-white flex items-center justify-center text-xs font-bold shadow-sm">1</span>
            <span><?php echo esc_html(apply_filters('woocommerce_billing_fields_heading', __('Detalles de facturación', 'tech-store'))); ?></span>
        </h3>
        <span class="text-[11px] font-semibold text-neutral-400 uppercase tracking-wider">
            <?php esc_html_e('Datos del Comprador', 'tech-store'); ?>
        </span>
    </div>

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="woocommerce-billing-fields__field-wrapper">
        <?php
        $fields = $checkout->get_checkout_fields('billing');

        foreach ($fields as $key => $field) {
            woocommerce_form_field($key, $field, $checkout->get_value($key));
        }
        ?>
    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>

</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
    <div class="woocommerce-account-fields pt-4 mt-6 border-t border-neutral-100">
        <?php if (!$checkout->is_registration_required()) : ?>
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox flex items-center gap-2.5 cursor-pointer select-none text-xs font-bold text-neutral-800">
                <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox w-4 h-4 rounded text-primary focus:ring-primary border-neutral-300" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox" name="createaccount" value="1" />
                <span><?php esc_html_e('¿Crear una cuenta en Tech Store?', 'tech-store'); ?></span>
            </label>
        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($checkout->get_checkout_fields('account')) : ?>
            <div class="create-account mt-4 pt-4 border-t border-neutral-100 space-y-4">
                <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
                    <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    </div>
<?php endif; ?>
