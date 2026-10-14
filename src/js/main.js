/**
 * Alex Store - Main JavaScript Entrypoint
 */

import { initCartDrawer } from './cart-drawer.js';
import { initLiveSearch } from './live-search.js';
import { initProductGallery } from './product-gallery.js';
import { initTechSlider } from './tech-slider.js';
import { initCheckoutValidation } from './checkout-validation.js';

document.addEventListener('DOMContentLoaded', () => {
  // Initialize Core Modules
  initCartDrawer();
  initLiveSearch();
  initProductGallery();
  initTechSlider();
  initCheckoutValidation();

  // Announcement Bar Dismiss
  initAnnouncementBar();

  // Smart Auto-Hiding Header
  initSmartHeader();

  // Mobile Navigation Menu Toggle
  initMobileMenu();

  // Tab Switching Utility
  initTabSwitchers();

  // Search Modal Toggle (Mobile & Desktop)
  initSearchModal();

  // Amazon-style Cart Page Auto-Update
  initCartPageAutoUpdate();
});

function initAnnouncementBar() {
  const bar = document.getElementById('alex-announcement-bar') || document.getElementById('tech-announcement-bar');
  const closeBtn = document.getElementById('alex-close-announcement') || document.getElementById('tech-close-announcement');
  if (!bar) return;

  if (localStorage.getItem('alex-announcement-dismissed') === 'true' || localStorage.getItem('tech-announcement-dismissed') === 'true') {
    bar.classList.add('hidden');
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      bar.classList.add('hidden');
      localStorage.setItem('alex-announcement-dismissed', 'true');
    });
  }
}

/**
 * Smart Auto-Hiding Header on Scroll
 */
function initSmartHeader() {
  const header = document.getElementById('alex-main-header') || document.getElementById('tech-main-header') || document.querySelector('header');
  if (!header) return;

  let lastScrollY = window.scrollY;
  const scrollThreshold = 10;

  window.addEventListener('scroll', () => {
    const currentScrollY = window.scrollY;

    if (currentScrollY <= 80) {
      header.classList.remove('-translate-y-full');
      header.classList.add('translate-y-0');

      if (currentScrollY <= 20) {
        header.classList.remove('shadow-md', 'bg-white/95', 'backdrop-blur-md');
      } else {
        header.classList.add('shadow-subtle');
      }
      lastScrollY = currentScrollY;
      return;
    }

    if (Math.abs(currentScrollY - lastScrollY) < scrollThreshold) {
      return;
    }

    if (currentScrollY > lastScrollY) {
      // SCROLLING DOWN -> Hide Header
      header.classList.add('-translate-y-full');
      header.classList.remove('translate-y-0');

      const searchResults = document.querySelector('.alex-search-results, .tech-search-results');
      if (searchResults && !searchResults.classList.contains('hidden')) {
        searchResults.classList.add('hidden');
      }
    } else {
      // SCROLLING UP -> Show Header
      header.classList.remove('-translate-y-full');
      header.classList.add('translate-y-0', 'shadow-md', 'bg-white/95', 'backdrop-blur-md');
    }

    lastScrollY = currentScrollY;
  }, { passive: true });
}

function initMobileMenu() {
  const toggleBtn = document.getElementById('alex-mobile-menu-toggle') || document.getElementById('tech-mobile-menu-toggle');
  const mobileDrawer = document.getElementById('alex-mobile-menu-drawer') || document.getElementById('tech-mobile-menu-drawer');
  const mobileOverlay = document.getElementById('alex-mobile-menu-overlay') || document.getElementById('tech-mobile-menu-overlay');
  const closeBtn = document.getElementById('alex-close-mobile-menu') || document.getElementById('tech-close-mobile-menu');

  function openMenu() {
    if (!mobileDrawer || !mobileOverlay) return;
    mobileOverlay.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
    mobileOverlay.classList.add('opacity-100');
    mobileDrawer.classList.remove('-translate-x-full');
    mobileDrawer.classList.add('translate-x-0');
    document.body.classList.add('overflow-hidden');
  }

  function closeMenu() {
    if (!mobileDrawer || !mobileOverlay) return;
    mobileOverlay.classList.remove('opacity-100');
    mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
    mobileDrawer.classList.remove('translate-x-0');
    mobileDrawer.classList.add('-translate-x-full');
    document.body.classList.remove('overflow-hidden');
    setTimeout(() => {
      mobileOverlay.classList.add('hidden');
    }, 300);
  }

  if (toggleBtn) toggleBtn.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);
  if (mobileOverlay) mobileOverlay.addEventListener('click', closeMenu);
}

function initTabSwitchers() {
  const tabContainers = document.querySelectorAll('[data-tabs-container]');
  tabContainers.forEach(container => {
    const tabButtons = container.querySelectorAll('[data-tab-target]');
    const tabPanels = container.querySelectorAll('[data-tab-panel]');

    tabButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = btn.dataset.tabTarget;

        tabButtons.forEach(b => {
          b.classList.remove('active', 'bg-primary', 'text-white', 'border-primary');
          b.classList.add('bg-white', 'text-dark', 'border-neutral-border');
        });

        btn.classList.add('active', 'bg-primary', 'text-white', 'border-primary');
        btn.classList.remove('bg-white', 'text-dark', 'border-neutral-border');

        tabPanels.forEach(panel => {
          if (panel.id === targetId) {
            panel.classList.remove('hidden');
          } else {
            panel.classList.add('hidden');
          }
        });
      });
    });
  });
}

function initSearchModal() {
  const openButtons = document.querySelectorAll('[data-action="open-search-modal"]');
  const searchModal = document.getElementById('alex-search-modal') || document.getElementById('tech-search-modal');
  const closeBtn = document.getElementById('alex-close-search-modal') || document.getElementById('tech-close-search-modal');
  const searchInput = searchModal?.querySelector('.alex-live-search-input, .tech-live-search-input');

  if (!searchModal) return;

  function openModal() {
    searchModal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    setTimeout(() => {
      searchInput?.focus();
    }, 100);
  }

  function closeModal() {
    searchModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }

  openButtons.forEach(b => b.addEventListener('click', (e) => {
    e.preventDefault();
    openModal();
  }));

  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  searchModal.addEventListener('click', (e) => {
    if (e.target === searchModal) {
      closeModal();
    }
  });
}

function initCartPageAutoUpdate() {
  const cartForm = document.querySelector('.woocommerce-cart-form');
  if (!cartForm) return;

  let updateTimeout;
  cartForm.addEventListener('change', (e) => {
    if (e.target && (e.target.classList.contains('alex-cart-qty-input') || e.target.classList.contains('tech-cart-qty-input') || e.target.classList.contains('qty'))) {
      clearTimeout(updateTimeout);
      updateTimeout = setTimeout(() => {
        const updateBtn = cartForm.querySelector('[name="update_cart"]');
        if (updateBtn) {
          updateBtn.disabled = false;
          updateBtn.click();
        } else {
          cartForm.submit();
        }
      }, 500);
    }
  });
}
