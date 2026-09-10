/**
 * Alex Store - Cart Drawer & AJAX Cart Interactions
 */

export function initCartDrawer() {
  const drawerOverlay = document.getElementById('alex-cart-drawer-overlay') || document.getElementById('tech-cart-drawer-overlay');
  const drawerPanel = document.getElementById('alex-cart-drawer-panel') || document.getElementById('tech-cart-drawer-panel');
  const openButtons = document.querySelectorAll('[data-action="open-cart-drawer"]');
  const closeButtons = document.querySelectorAll('[data-action="close-cart-drawer"]');
  const drawerContainer = document.getElementById('alex-cart-drawer-items') || document.getElementById('tech-cart-drawer-items');

  const getParams = () => window.alexStoreData || window.techStoreParams || {};

  function openDrawer() {
    if (!drawerOverlay || !drawerPanel) return;
    drawerOverlay.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
    drawerOverlay.classList.add('opacity-100');
    drawerPanel.classList.remove('translate-x-full');
    drawerPanel.classList.add('translate-x-0');
    document.body.classList.add('overflow-hidden');
  }

  function closeDrawer() {
    if (!drawerOverlay || !drawerPanel) return;
    drawerOverlay.classList.remove('opacity-100');
    drawerOverlay.classList.add('opacity-0', 'pointer-events-none');
    drawerPanel.classList.remove('translate-x-0');
    drawerPanel.classList.add('translate-x-full');
    document.body.classList.remove('overflow-hidden');
    setTimeout(() => {
      drawerOverlay.classList.add('hidden');
    }, 300);
  }

  openButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      openDrawer();
    });
  });

  closeButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      closeDrawer();
    });
  });

  if (drawerOverlay) {
    drawerOverlay.addEventListener('click', (e) => {
      if (e.target === drawerOverlay) {
        closeDrawer();
      }
    });
  }

  // Escape key closes drawer
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawerOverlay && !drawerOverlay.classList.contains('hidden')) {
      closeDrawer();
    }
  });

  // Listen to standard WooCommerce added_to_cart event
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
      refreshCartDrawer();
      openDrawer();
    });
  }

  // Handle AJAX quantity and remove clicks inside the drawer
  if (drawerContainer) {
    drawerContainer.addEventListener('click', async function(e) {
      const updateQtyBtn = e.target.closest('[data-cart-action="update-qty"]');
      const removeItemBtn = e.target.closest('[data-cart-action="remove-item"]');

      if (updateQtyBtn) {
        e.preventDefault();
        const key = updateQtyBtn.dataset.cartKey;
        const currentQty = parseInt(updateQtyBtn.dataset.currentQty, 10);
        const change = parseInt(updateQtyBtn.dataset.qtyChange, 10);
        const newQty = Math.max(0, currentQty + change);
        await updateCartItemQuantity(key, newQty);
      }

      if (removeItemBtn) {
        e.preventDefault();
        const key = removeItemBtn.dataset.cartKey;
        await updateCartItemQuantity(key, 0);
      }
    });
  }

  // Direct AJAX Add to Cart handler for custom buttons
  document.addEventListener('click', async function(e) {
    const addBtn = e.target.closest('.alex-ajax-add-to-cart, .tech-ajax-add-to-cart');
    if (!addBtn) return;

    e.preventDefault();
    const productId = addBtn.dataset.productId;
    const quantity = addBtn.dataset.quantity || 1;
    const variationId = addBtn.dataset.variationId || 0;

    if (!productId) return;

    const originalHtml = addBtn.innerHTML;
    addBtn.disabled = true;
    addBtn.innerHTML = '<span class="loading-spinner"></span>';

    try {
      const params = getParams();
      const formData = new FormData();
      formData.append('action', 'alex_store_add_to_cart');
      formData.append('product_id', productId);
      formData.append('quantity', quantity);
      formData.append('variation_id', variationId);
      formData.append('nonce', params.nonce || '');

      const response = await fetch(params.ajaxUrl || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData,
      });

      const data = await response.json();
      if (data.success) {
        updateCartBadge(data.data.cart_count);
        updateCartDrawerHtml(data.data.drawer_html);
        openDrawer();
      } else {
        alert(data.data?.message || 'Error al añadir el producto');
      }
    } catch (err) {
      console.error('Add to cart error:', err);
    } finally {
      addBtn.disabled = false;
      addBtn.innerHTML = originalHtml;
    }
  });

  async function updateCartItemQuantity(cartKey, newQty) {
    if (!drawerContainer) return;
    drawerContainer.classList.add('opacity-50', 'pointer-events-none');

    try {
      const params = getParams();
      const formData = new FormData();
      formData.append('action', 'alex_store_update_cart_item');
      formData.append('cart_key', cartKey);
      formData.append('quantity', newQty);
      formData.append('nonce', params.nonce || '');

      const response = await fetch(params.ajaxUrl || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData,
      });

      const data = await response.json();
      if (data.success) {
        updateCartBadge(data.data.cart_count);
        updateCartDrawerHtml(data.data.drawer_html);
      }
    } catch (err) {
      console.error('Update cart error:', err);
    } finally {
      drawerContainer.classList.remove('opacity-50', 'pointer-events-none');
    }
  }

  async function refreshCartDrawer() {
    try {
      const params = getParams();
      const formData = new FormData();
      formData.append('action', 'alex_store_get_cart_drawer');
      formData.append('nonce', params.nonce || '');

      const response = await fetch(params.ajaxUrl || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData,
      });

      const data = await response.json();
      if (data.success) {
        updateCartBadge(data.data.cart_count);
        updateCartDrawerHtml(data.data.drawer_html);
      }
    } catch (err) {
      console.error('Refresh cart error:', err);
    }
  }

  function updateCartBadge(count) {
    const badges = document.querySelectorAll('.alex-cart-count-badge, .tech-cart-count-badge');
    badges.forEach(b => {
      b.textContent = count;
      if (count > 0) {
        b.classList.remove('hidden');
      } else {
        b.classList.add('hidden');
      }
    });
  }

  function updateCartDrawerHtml(html) {
    if (drawerContainer) {
      drawerContainer.innerHTML = html;
    }
  }
}
