/**
 * Alex Store - Static Prototype Application Logic
 * Standalone, self-contained interactivity for client presentation.
 */

(function () {
  'use strict';

  // Mock Products Database for Interactive Live Search & Cart
  const MOCK_PRODUCTS = [
    {
      id: 1,
      title: 'Galaxy S26 Plus 256GB 12GB RAM',
      price: 34000.28,
      regularPrice: 39733.81,
      image: 'assets/img/galaxy-s26.jpg',
      category: 'Celulares',
      inStock: true
    },
    {
      id: 2,
      title: 'Apple iPhone 16 Pro Max 256GB Titanio',
      price: 42500.00,
      regularPrice: 46900.00,
      image: 'assets/img/iphone-16-pro.jpg',
      category: 'Celulares',
      inStock: true
    },
    {
      id: 3,
      title: 'Apple MacBook Pro 16" Chip M3 Max 36GB',
      price: 89900.00,
      regularPrice: 99500.00,
      image: 'assets/img/macbook-pro.png',
      category: 'Laptops',
      inStock: true
    },
    {
      id: 4,
      title: 'Nvidia GeForce RTX 5090 32GB GDDR7',
      price: 78900.00,
      regularPrice: null,
      image: 'assets/img/rtx-5090.jpg',
      category: 'Componentes',
      inStock: true
    },
    {
      id: 5,
      title: 'Control Razer Raiju V3 Pro PS5 / PC Inalámbrico',
      price: 8981.81,
      regularPrice: 9879.99,
      image: 'assets/img/ps5-controller.jpg',
      category: 'Gaming',
      inStock: true
    },
    {
      id: 6,
      title: 'Cámara DJI Osmo Pocket 3 Creator Combo 4K',
      price: 20481.02,
      regularPrice: 24718.44,
      image: 'assets/img/osmo-pocket.jpg',
      category: 'Cámaras',
      inStock: false // Out of stock to demonstrate the new "No disponible" behavior!
    },
    {
      id: 7,
      title: 'Audífonos Aurae Hi-Fi ANC Cancelación Activa de Ruido',
      price: 6850.00,
      regularPrice: 7990.00,
      image: 'assets/img/headphones.jpg',
      category: 'Audio',
      inStock: true
    },
    {
      id: 8,
      title: 'Amazon Echo Dot 5ta Gen con Asistente de Voz Alexa',
      price: 2150.00,
      regularPrice: 2650.00,
      image: 'assets/img/echo-dot.jpg',
      category: 'Smart Home',
      inStock: true
    }
  ];

  // In-Memory Cart State
  let cart = [
    { id: 1, qty: 1 },
    { id: 5, qty: 1 }
  ];

  function formatMoney(amount) {
    return 'C$ ' + amount.toLocaleString('es-NI', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  // 1. Tech Slider (1:1 Drag / Sweep Physics)
  function initTechSlider() {
    const slider = document.querySelector('[data-tech-slider]');
    if (!slider) return;

    const track = slider.querySelector('.tech-slider-track');
    const slides = slider.querySelectorAll('.tech-slider-slide');
    const prevBtn = slider.querySelector('.tech-slider-prev');
    const nextBtn = slider.querySelector('.tech-slider-next');
    const dotsContainer = slider.querySelector('.tech-slider-dots');

    if (!track || slides.length === 0) return;

    let currentIndex = 0;
    const totalSlides = slides.length;
    let autoInterval = null;
    const intervalTime = 6000;
    let isHovered = false;

    // Gesture State
    let isDragging = false;
    let hasMoved = false;
    let startX = 0;
    let startY = 0;
    let currentDeltaX = 0;
    let sliderWidth = 0;

    function goToSlide(index, withTransition = true) {
      if (index < 0) {
        currentIndex = totalSlides - 1;
      } else if (index >= totalSlides) {
        currentIndex = 0;
      } else {
        currentIndex = index;
      }

      if (withTransition) {
        track.classList.remove('no-transition');
      } else {
        track.classList.add('no-transition');
      }

      track.style.transform = `translate3d(-${currentIndex * 100}%, 0, 0)`;

      if (dotsContainer) {
        const dots = dotsContainer.querySelectorAll('.tech-slider-dot');
        dots.forEach((dot, i) => {
          if (i === currentIndex) {
            dot.classList.add('active');
            dot.setAttribute('aria-current', 'true');
          } else {
            dot.classList.remove('active');
            dot.removeAttribute('aria-current');
          }
        });
      }
    }

    function nextSlide() { goToSlide(currentIndex + 1); }
    function prevSlide() { goToSlide(currentIndex - 1); }

    function startAutoRotation() {
      stopAutoRotation();
      if (totalSlides <= 1) return;
      autoInterval = setInterval(() => {
        if (!isHovered && !isDragging) {
          nextSlide();
        }
      }, intervalTime);
    }

    function stopAutoRotation() {
      if (autoInterval) {
        clearInterval(autoInterval);
        autoInterval = null;
      }
    }

    function restartAutoRotation() {
      stopAutoRotation();
      startAutoRotation();
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        prevSlide();
        restartAutoRotation();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        nextSlide();
        restartAutoRotation();
      });
    }

    if (dotsContainer) {
      const dots = dotsContainer.querySelectorAll('.tech-slider-dot');
      dots.forEach((dot, idx) => {
        dot.addEventListener('click', (e) => {
          e.preventDefault();
          goToSlide(idx);
          restartAutoRotation();
        });
      });
    }

    slider.addEventListener('mouseenter', () => { isHovered = true; });
    slider.addEventListener('mouseleave', () => { isHovered = false; });

    // Drag / Sweep Gesture Handlers
    function getPointerX(e) {
      return e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
    }
    function getPointerY(e) {
      return e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
    }

    function onDragStart(e) {
      if (e.type === 'mousedown' && e.button !== 0) return;
      if (e.target.closest('.tech-slider-arrow') || e.target.closest('.tech-slider-dot')) return;

      isDragging = true;
      hasMoved = false;
      startX = getPointerX(e);
      startY = getPointerY(e);
      currentDeltaX = 0;
      sliderWidth = slider.offsetWidth || 1;

      track.classList.add('no-transition');
      slider.classList.add('is-dragging');
      stopAutoRotation();
    }

    function onDragMove(e) {
      if (!isDragging) return;

      const currentX = e.type.includes('touch') ? (e.touches[0] ? e.touches[0].clientX : startX) : e.clientX;
      const currentY = e.type.includes('touch') ? (e.touches[0] ? e.touches[0].clientY : startY) : e.clientY;

      const diffX = currentX - startX;
      const diffY = currentY - startY;

      if (e.type.includes('touch') && !hasMoved) {
        if (Math.abs(diffY) > Math.abs(diffX) && Math.abs(diffY) > 8) {
          isDragging = false;
          slider.classList.remove('is-dragging');
          track.classList.remove('no-transition');
          goToSlide(currentIndex, true);
          return;
        }
      }

      if (Math.abs(diffX) > 6) {
        hasMoved = true;
        if (e.cancelable && e.type.includes('touch')) {
          e.preventDefault();
        }
      }

      currentDeltaX = diffX;
      let percentMove = (diffX / sliderWidth) * 100;

      if ((currentIndex === 0 && diffX > 0) || (currentIndex === totalSlides - 1 && diffX < 0)) {
        percentMove = percentMove * 0.35;
      }

      const basePercent = -currentIndex * 100;
      track.style.transform = `translate3d(${basePercent + percentMove}%, 0, 0)`;
    }

    function onDragEnd() {
      if (!isDragging) return;
      isDragging = false;
      slider.classList.remove('is-dragging');
      track.classList.remove('no-transition');

      const swipeThreshold = Math.min(sliderWidth * 0.12, 50);

      if (currentDeltaX < -swipeThreshold) {
        nextSlide();
      } else if (currentDeltaX > swipeThreshold) {
        prevSlide();
      } else {
        goToSlide(currentIndex, true);
      }

      currentDeltaX = 0;
      restartAutoRotation();
      setTimeout(() => { hasMoved = false; }, 60);
    }

    slider.addEventListener('mousedown', onDragStart);
    window.addEventListener('mousemove', onDragMove);
    window.addEventListener('mouseup', onDragEnd);

    slider.addEventListener('touchstart', onDragStart, { passive: true });
    slider.addEventListener('touchmove', onDragMove, { passive: false });
    slider.addEventListener('touchend', onDragEnd, { passive: true });
    slider.addEventListener('touchcancel', onDragEnd, { passive: true });

    slider.addEventListener('click', (e) => {
      if (hasMoved) {
        e.preventDefault();
        e.stopPropagation();
      }
    }, true);

    goToSlide(0, false);
    startAutoRotation();
  }

  // 2. Interactive Cart Drawer
  function initCartDrawer() {
    const overlay = document.getElementById('alex-cart-drawer-overlay');
    const panel = document.getElementById('alex-cart-drawer-panel');
    const openBtns = document.querySelectorAll('[data-action="open-cart-drawer"]');
    const closeBtns = document.querySelectorAll('[data-action="close-cart-drawer"]');
    const itemsContainer = document.getElementById('alex-cart-drawer-items');
    const subtotalEl = document.getElementById('alex-cart-drawer-subtotal');
    const badges = document.querySelectorAll('.alex-cart-count-badge');

    function openDrawer() {
      if (!overlay || !panel) return;
      renderCart();
      overlay.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
      overlay.classList.add('opacity-100');
      panel.classList.remove('translate-x-full');
      panel.classList.add('translate-x-0');
      document.body.classList.add('overflow-hidden');
    }

    function closeDrawer() {
      if (!overlay || !panel) return;
      overlay.classList.remove('opacity-100');
      overlay.classList.add('opacity-0', 'pointer-events-none');
      panel.classList.remove('translate-x-0');
      panel.classList.add('translate-x-full');
      document.body.classList.remove('overflow-hidden');
      setTimeout(() => { overlay.classList.add('hidden'); }, 300);
    }

    openBtns.forEach(btn => btn.addEventListener('click', (e) => {
      e.preventDefault();
      openDrawer();
    }));

    closeBtns.forEach(btn => btn.addEventListener('click', (e) => {
      e.preventDefault();
      closeDrawer();
    }));

    if (overlay) {
      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeDrawer();
      });
    }

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeDrawer();
    });

    // Add to cart buttons on product cards
    document.addEventListener('click', (e) => {
      const addBtn = e.target.closest('.alex-ajax-add-to-cart');
      if (!addBtn) return;
      e.preventDefault();

      const prodId = parseInt(addBtn.dataset.productId, 10);
      const existing = cart.find(item => item.id === prodId);
      if (existing) {
        existing.qty += 1;
      } else {
        cart.push({ id: prodId, qty: 1 });
      }

      updateCartBadge();
      openDrawer();
    });

    // Quantity & removal inside drawer
    if (itemsContainer) {
      itemsContainer.addEventListener('click', (e) => {
        const qtyBtn = e.target.closest('[data-cart-action="update-qty"]');
        const removeBtn = e.target.closest('[data-cart-action="remove-item"]');

        if (qtyBtn) {
          e.preventDefault();
          const prodId = parseInt(qtyBtn.dataset.productId, 10);
          const change = parseInt(qtyBtn.dataset.qtyChange, 10);
          const item = cart.find(i => i.id === prodId);
          if (item) {
            item.qty += change;
            if (item.qty <= 0) {
              cart = cart.filter(i => i.id !== prodId);
            }
            renderCart();
            updateCartBadge();
          }
        }

        if (removeBtn) {
          e.preventDefault();
          const prodId = parseInt(removeBtn.dataset.productId, 10);
          cart = cart.filter(i => i.id !== prodId);
          renderCart();
          updateCartBadge();
        }
      });
    }

    function updateCartBadge() {
      const totalCount = cart.reduce((acc, cur) => acc + cur.qty, 0);
      badges.forEach(b => {
        b.textContent = totalCount;
        if (totalCount > 0) {
          b.classList.remove('hidden');
        } else {
          b.classList.add('hidden');
        }
      });
    }

    function renderCart() {
      if (!itemsContainer) return;
      if (cart.length === 0) {
        itemsContainer.innerHTML = `
          <div class="py-16 text-center text-neutral-500">
            <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-3 text-neutral-400">
              <i data-lucide="shopping-cart" class="w-8 h-8"></i>
            </div>
            <p class="text-sm font-semibold text-neutral-900 mb-1">Tu carrito está vacío</p>
            <p class="text-xs text-neutral-500">Explora nuestras ofertas y añade tus productos favoritos.</p>
          </div>
        `;
        if (subtotalEl) subtotalEl.textContent = 'C$ 0.00';
        if (window.lucide && lucide.createIcons) lucide.createIcons();
        return;
      }

      let subtotal = 0;
      let html = '<div class="divide-y divide-neutral-100">';

      cart.forEach(item => {
        const prod = MOCK_PRODUCTS.find(p => p.id === item.id);
        if (!prod) return;
        const lineTotal = prod.price * item.qty;
        subtotal += lineTotal;

        html += `
          <div class="py-4 flex items-center gap-3">
            <img src="${prod.image}" alt="${prod.title}" class="w-16 h-16 object-contain rounded-lg border border-neutral-200 bg-white p-1 flex-shrink-0" />
            <div class="flex-1 min-w-0">
              <h4 class="text-xs font-semibold text-neutral-900 line-clamp-1">${prod.title}</h4>
              <p class="text-xs font-bold text-neutral-900 mt-0.5">${formatMoney(prod.price)}</p>
              
              <div class="flex items-center gap-2 mt-2">
                <div class="inline-flex items-center border border-neutral-200 rounded-md bg-neutral-50">
                  <button type="button" class="w-6 h-6 flex items-center justify-center text-xs text-neutral-600 hover:bg-neutral-200" data-cart-action="update-qty" data-product-id="${prod.id}" data-qty-change="-1">-</button>
                  <span class="w-7 text-center text-xs font-bold text-neutral-800">${item.qty}</span>
                  <button type="button" class="w-6 h-6 flex items-center justify-center text-xs text-neutral-600 hover:bg-neutral-200" data-cart-action="update-qty" data-product-id="${prod.id}" data-qty-change="1">+</button>
                </div>
                <button type="button" class="text-[11px] text-rose-500 hover:underline" data-cart-action="remove-item" data-product-id="${prod.id}">Eliminar</button>
              </div>
            </div>
            <div class="text-xs font-bold text-neutral-900 text-right">
              ${formatMoney(lineTotal)}
            </div>
          </div>
        `;
      });

      html += '</div>';
      itemsContainer.innerHTML = html;
      if (subtotalEl) subtotalEl.textContent = formatMoney(subtotal);
    }

    updateCartBadge();
    renderCart();
  }

  // 3. Live Predictive Search Modal
  function initLiveSearch() {
    const searchModal = document.getElementById('alex-search-modal');
    const openBtns = document.querySelectorAll('[data-action="open-search-modal"]');
    const closeBtn = document.getElementById('alex-close-search-modal');
    const searchInput = document.getElementById('alex-live-search-input');
    const resultsContainer = document.getElementById('alex-search-modal-results');

    function openSearch() {
      if (!searchModal) return;
      searchModal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
      setTimeout(() => { searchInput?.focus(); }, 100);
      renderResults(searchInput?.value || '');
    }

    function closeSearch() {
      if (!searchModal) return;
      searchModal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }

    openBtns.forEach(btn => btn.addEventListener('click', (e) => {
      e.preventDefault();
      openSearch();
    }));

    if (closeBtn) closeBtn.addEventListener('click', closeSearch);
    if (searchModal) {
      searchModal.addEventListener('click', (e) => {
        if (e.target === searchModal) closeSearch();
      });
    }

    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        renderResults(e.target.value.trim());
      });
    }

    function renderResults(query) {
      if (!resultsContainer) return;
      if (!query || query.length < 2) {
        resultsContainer.innerHTML = `
          <div class="p-8 text-center text-neutral-400 text-xs sm:text-sm">
            Escribe al menos 2 caracteres para buscar entre smartphones, gaming, laptops y audio...
          </div>
        `;
        return;
      }

      const q = query.toLowerCase();
      const filtered = MOCK_PRODUCTS.filter(p => p.title.toLowerCase().includes(q) || p.category.toLowerCase().includes(q));

      if (filtered.length === 0) {
        resultsContainer.innerHTML = `
          <div class="p-8 text-center text-neutral-500 text-xs sm:text-sm">
            No se encontraron productos para "<strong>${query}</strong>".
          </div>
        `;
        return;
      }

      let html = '<div class="divide-y divide-neutral-100 p-2">';
      filtered.forEach(p => {
        html += `
          <div class="p-3 hover:bg-neutral-50 rounded-xl flex items-center justify-between gap-4 transition-colors">
            <div class="flex items-center gap-3">
              <img src="${p.image}" alt="${p.title}" class="w-12 h-12 object-contain rounded-lg border border-neutral-200 bg-white p-1" />
              <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-neutral-400">${p.category}</span>
                <h4 class="text-xs sm:text-sm font-semibold text-neutral-900">${p.title}</h4>
              </div>
            </div>
            <div class="text-right">
              <span class="text-xs sm:text-sm font-bold text-neutral-900 block">${p.inStock ? formatMoney(p.price) : '<span class="text-xs font-semibold text-neutral-400">No disponible</span>'}</span>
              ${p.inStock ? `<button type="button" class="alex-ajax-add-to-cart text-[11px] font-bold text-cta hover:underline mt-1" data-product-id="${p.id}">Añadir +</button>` : ''}
            </div>
          </div>
        `;
      });
      html += '</div>';
      resultsContainer.innerHTML = html;
    }
  }

  // 4. Header & Announcement Bar
  function initHeaderAndBars() {
    const bar = document.getElementById('alex-announcement-bar');
    const closeBtn = document.getElementById('alex-close-announcement');
    if (bar && closeBtn) {
      if (localStorage.getItem('alex-demo-announcement-dismissed') === 'true') {
        bar.classList.add('hidden');
      }
      closeBtn.addEventListener('click', () => {
        bar.classList.add('hidden');
        localStorage.setItem('alex-demo-announcement-dismissed', 'true');
      });
    }

    // Mobile Menu Drawer
    const menuBtn = document.getElementById('alex-mobile-menu-toggle');
    const menuDrawer = document.getElementById('alex-mobile-menu-drawer');
    const menuOverlay = document.getElementById('alex-mobile-menu-overlay');
    const menuClose = document.getElementById('alex-close-mobile-menu');

    function openMobileMenu() {
      if (!menuDrawer || !menuOverlay) return;
      menuOverlay.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
      menuOverlay.classList.add('opacity-100');
      menuDrawer.classList.remove('-translate-x-full');
      menuDrawer.classList.add('translate-x-0');
      document.body.classList.add('overflow-hidden');
    }

    function closeMobileMenu() {
      if (!menuDrawer || !menuOverlay) return;
      menuOverlay.classList.remove('opacity-100');
      menuOverlay.classList.add('opacity-0', 'pointer-events-none');
      menuDrawer.classList.remove('translate-x-0');
      menuDrawer.classList.add('-translate-x-full');
      document.body.classList.remove('overflow-hidden');
      setTimeout(() => { menuOverlay.classList.add('hidden'); }, 300);
    }

    if (menuBtn) menuBtn.addEventListener('click', openMobileMenu);
    if (menuClose) menuClose.addEventListener('click', closeMobileMenu);
    if (menuOverlay) menuOverlay.addEventListener('click', closeMobileMenu);
  }

  // Initialize all prototype modules on DOM load
  document.addEventListener('DOMContentLoaded', () => {
    initTechSlider();
    initCartDrawer();
    initLiveSearch();
    initHeaderAndBars();
    if (window.lucide && lucide.createIcons) {
      lucide.createIcons();
    }
  });

})();
