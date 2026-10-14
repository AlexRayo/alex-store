/**
 * Real-Time Checkout Form Validation & Button State
 * Disables "Realizar Pedido" until all required fields are filled,
 * providing clear, accessible feedback to the user.
 */

export function initCheckoutValidation() {
  const checkoutForm = document.querySelector('form.checkout');
  if (!checkoutForm) return;

  function isFieldVisible(field) {
    if (!field) return false;
    // Check if element or any ancestor is hidden
    if (field.type === 'hidden') return false;
    if (field.offsetParent === null) return false;

    // Check specific WooCommerce toggle containers
    const shippingSection = field.closest('.shipping_address, #shipping_address');
    if (shippingSection) {
      const shipToDifferent = document.getElementById('ship-to-different-address-checkbox');
      if (shipToDifferent && !shipToDifferent.checked) {
        return false;
      }
    }

    const accountSection = field.closest('.create-account');
    if (accountSection) {
      const createAccount = document.getElementById('createaccount');
      if (createAccount && !createAccount.checked) {
        return false;
      }
    }

    return true;
  }

  function getFieldCleanLabel(field) {
    const row = field.closest('.form-row');
    if (row) {
      const label = row.querySelector('label');
      if (label) {
        const clone = label.cloneNode(true);
        clone.querySelectorAll('abbr, span.optional, .screen-reader-text').forEach(el => el.remove());
        const text = clone.textContent.trim().replace(/[*:]/g, '').trim();
        if (text) return text;
      }
    }

    // Common Fallback Labels for WooCommerce standard fields
    const idMap = {
      billing_first_name: 'Nombre',
      billing_last_name: 'Apellidos',
      billing_phone: 'Teléfono',
      billing_email: 'Correo electrónico',
      billing_address_1: 'Dirección',
      billing_city: 'Ciudad / Municipio',
      billing_state: 'Departamento / Estado',
      billing_postcode: 'Código postal',
      shipping_first_name: 'Nombre de envío',
      shipping_last_name: 'Apellidos de envío',
      shipping_address_1: 'Dirección de envío',
      shipping_city: 'Ciudad de envío',
      shipping_state: 'Departamento de envío',
      terms: 'Términos y condiciones',
      account_password: 'Contraseña de la cuenta'
    };

    if (idMap[field.id]) return idMap[field.id];
    return field.getAttribute('placeholder') || field.name || 'Campo obligatorio';
  }

  function isFieldValid(field) {
    if (field.type === 'checkbox') {
      return field.checked;
    }

    const val = field.value ? field.value.trim() : '';
    if (val.length === 0) return false;

    // Email format validation
    if (field.type === 'email' || field.id.includes('email')) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
    }

    return true;
  }

  function validateCheckout() {
    const placeOrderBtn = document.getElementById('place_order');
    const noticeBox = document.getElementById('tech-checkout-validation-notice');
    const missingList = document.getElementById('tech-checkout-missing-fields');

    // 1. Gather all required fields in the checkout form
    const candidateFields = checkoutForm.querySelectorAll(
      '.validate-required input, .validate-required select, .validate-required textarea, input#terms'
    );

    const missing = [];
    const seenIds = new Set();

    candidateFields.forEach(field => {
      if (!isFieldVisible(field)) return;
      if (seenIds.has(field.id || field.name)) return;

      if (!isFieldValid(field)) {
        seenIds.add(field.id || field.name);
        missing.push({
          id: field.id || field.name,
          label: getFieldCleanLabel(field),
          element: field
        });
      }
    });

    // Check payment method selection
    const paymentMethods = checkoutForm.querySelectorAll('input[name="payment_method"]');
    if (paymentMethods.length > 0) {
      const selected = Array.from(paymentMethods).some(r => r.checked);
      if (!selected) {
        missing.push({
          id: 'payment_methods',
          label: 'Método de pago',
          element: paymentMethods[0]
        });
      }
    }

    // 2. Update Place Order Button state
    if (placeOrderBtn) {
      if (missing.length > 0) {
        placeOrderBtn.disabled = true;
        placeOrderBtn.classList.add('opacity-50', 'cursor-not-allowed');
        placeOrderBtn.setAttribute('aria-disabled', 'true');
      } else {
        placeOrderBtn.disabled = false;
        placeOrderBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        placeOrderBtn.removeAttribute('aria-disabled');
      }
    }

    // 3. Update Feedback Notice
    if (noticeBox) {
      if (missing.length > 0) {
        noticeBox.classList.remove('hidden');
        if (missingList) {
          missingList.innerHTML = '';
          missing.forEach(item => {
            const badge = document.createElement('button');
            badge.type = 'button';
            badge.className = 'inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-amber-300 text-amber-950 hover:bg-amber-100 hover:border-amber-400 transition-colors cursor-pointer shadow-xs active:scale-95';
            badge.innerHTML = `<svg class="w-3 h-3 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg><span>${item.label}</span>`;
            badge.addEventListener('click', (e) => {
              e.preventDefault();
              if (item.element) {
                item.element.focus();
                item.element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                item.element.classList.add('ring-2', 'ring-amber-500');
                setTimeout(() => item.element.classList.remove('ring-2', 'ring-amber-500'), 2000);
              }
            });
            missingList.appendChild(badge);
          });
        }
      } else {
        noticeBox.classList.add('hidden');
        if (missingList) missingList.innerHTML = '';
      }
    }
  }

  // Intercept clicks on disabled button wrapper to guide the user
  document.addEventListener('click', (e) => {
    const wrapper = e.target.closest('#tech-place-order-wrapper');
    const placeOrderBtn = document.getElementById('place_order');
    if (wrapper && placeOrderBtn && placeOrderBtn.disabled) {
      e.preventDefault();
      e.stopPropagation();

      // Focus first missing required field
      const firstMissingBadge = document.querySelector('#tech-checkout-missing-fields button');
      if (firstMissingBadge) {
        firstMissingBadge.click();
      } else {
        const firstRequired = checkoutForm.querySelector('.validate-required input, .validate-required select');
        if (firstRequired) {
          firstRequired.focus();
          firstRequired.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      }
    }
  }, true);

  // Form input and change events
  checkoutForm.addEventListener('input', validateCheckout);
  checkoutForm.addEventListener('change', validateCheckout);

  // Listen to WooCommerce jQuery events if jQuery is available
  if (window.jQuery) {
    window.jQuery(document.body).on('updated_checkout checkout_error payment_method_selected', () => {
      setTimeout(validateCheckout, 50);
    });
  }

  // MutationObserver to catch WooCommerce AJAX replacements of #order_review
  const orderReview = document.getElementById('order_review');
  if (orderReview) {
    const observer = new MutationObserver(() => {
      validateCheckout();
    });
    observer.observe(orderReview, { childList: true, subtree: true });
  }

  // Initial check on load
  setTimeout(validateCheckout, 100);
}
