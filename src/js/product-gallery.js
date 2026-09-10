/**
 * Tech Store - Single Product Gallery & Interactions
 */

export function initProductGallery() {
  const mainImage = document.getElementById('tech-main-product-image');
  const thumbnails = document.querySelectorAll('.tech-gallery-thumb');

  if (mainImage && thumbnails.length > 0) {
    thumbnails.forEach(thumb => {
      thumb.addEventListener('click', function(e) {
        e.preventDefault();
        const fullSrc = this.dataset.fullSrc;
        if (fullSrc) {
          mainImage.src = fullSrc;
          thumbnails.forEach(t => t.classList.remove('border-primary', 'ring-2', 'ring-primary/30'));
          this.classList.add('border-primary', 'ring-2', 'ring-primary/30');
        }
      });
    });
  }

  // Quantity input plus/minus buttons on single product
  const qtyWrappers = document.querySelectorAll('.tech-qty-control');
  qtyWrappers.forEach(wrapper => {
    const input = wrapper.querySelector('input[type="number"]');
    const plusBtn = wrapper.querySelector('[data-qty-btn="plus"]');
    const minusBtn = wrapper.querySelector('[data-qty-btn="minus"]');

    if (input && plusBtn && minusBtn) {
      plusBtn.addEventListener('click', () => {
        const val = parseInt(input.value || 1, 10);
        const max = parseInt(input.max || 9999, 10);
        if (val < max) input.value = val + 1;
        input.dispatchEvent(new Event('change'));
      });

      minusBtn.addEventListener('click', () => {
        const val = parseInt(input.value || 1, 10);
        const min = parseInt(input.min || 1, 10);
        if (val > min) input.value = val - 1;
        input.dispatchEvent(new Event('change'));
      });
    }
  });
}
