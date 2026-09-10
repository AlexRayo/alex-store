<?php
/**
 * Checkout terms and conditions area.
 *
 * @package TechStore
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

if (apply_filters('woocommerce_checkout_show_terms', true) && function_exists('wc_terms_and_conditions_checkbox_enabled')) {
    do_action('woocommerce_checkout_before_terms_and_conditions');

    ?>
    <div class="woocommerce-terms-and-conditions-wrapper mb-4 text-xs text-neutral-600">
        <?php
        /**
         * Terms and conditions hook used to inject content.
         *
         * @since 3.4.0
         * @hooked wc_checkout_privacy_policy_text() - 20
         * @hooked wc_terms_and_conditions_page_content() - 30
         */
        do_action('woocommerce_checkout_terms_and_conditions');
        ?>

        <?php if (wc_terms_and_conditions_checkbox_enabled()) : ?>
            <p class="form-row validate-required mt-2">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox flex items-start gap-2.5 cursor-pointer select-none text-xs text-neutral-700">
                    <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox w-4 h-4 mt-0.5 rounded text-primary focus:ring-primary border-neutral-300" name="terms" <?php checked(apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms'])), true); // WPCS: input var ok, csrf ok. ?> id="terms" />
                    <span class="woocommerce-terms-and-conditions-checkbox-text">
                        <?php wc_terms_and_conditions_checkbox_text(); ?>
                    </span>&nbsp;<abbr class="required text-rose-500 font-bold" title="<?php esc_attr_e('obligatorio', 'tech-store'); ?>">*</abbr>
                </label>
                <input type="hidden" name="terms-field" value="1" />
            </p>
        <?php endif; ?>
    </div>
    <?php

    do_action('woocommerce_checkout_after_terms_and_conditions');
}
