/**
 * Alex Store - Tech Hero Slider (shadcn/ui Carousel Inspired)
 * Features:
 *  - Full Mouse Drag/Sweep gesture support with real-time 1:1 physics
 *  - Full Mobile Touch/Swipe gesture support (touch-action aware)
 *  - Autoplay with Pause-on-Hover, Pause-on-Focus and Pause-on-Drag
 *  - Keyboard Navigation (ArrowLeft / ArrowRight)
 *  - Click-suppression on links/buttons when dragging
 *  - ARIA Accessibility
 */

export function initTechSlider() {
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
  let autoplayTimer = null;
  const autoplayDelay = 6000; // 6 seconds per slide
  let isHovered = false;

  // Drag / Sweep State
  let isDragging = false;
  let hasDragged = false;
  let startX = 0;
  let startY = 0;
  let currentDeltaX = 0;
  let sliderWidth = 0;

  function updateSlider(index, animate = true) {
    if (index < 0) {
      currentIndex = totalSlides - 1;
    } else if (index >= totalSlides) {
      currentIndex = 0;
    } else {
      currentIndex = index;
    }

    if (animate) {
      track.classList.remove('no-transition');
    } else {
      track.classList.add('no-transition');
    }

    // Move track using hardware-accelerated transform
    track.style.transform = `translate3d(-${currentIndex * 100}%, 0, 0)`;

    // Update dots
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

    // Update ARIA attributes
    slides.forEach((slide, i) => {
      if (i === currentIndex) {
        slide.setAttribute('aria-hidden', 'false');
        slide.removeAttribute('inert');
      } else {
        slide.setAttribute('aria-hidden', 'true');
        slide.setAttribute('inert', '');
      }
    });
  }

  function nextSlide() {
    updateSlider(currentIndex + 1);
  }

  function prevSlide() {
    updateSlider(currentIndex - 1);
  }

  function startAutoplay() {
    stopAutoplay();
    if (totalSlides <= 1) return;
    autoplayTimer = setInterval(() => {
      if (!isHovered && !isDragging) {
        nextSlide();
      }
    }, autoplayDelay);
  }

  function stopAutoplay() {
    if (autoplayTimer) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  }

  function resetAutoplay() {
    stopAutoplay();
    startAutoplay();
  }

  // Bind Previous / Next Buttons
  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      e.preventDefault();
      prevSlide();
      resetAutoplay();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      e.preventDefault();
      nextSlide();
      resetAutoplay();
    });
  }

  // Bind Indicator Dots
  if (dotsContainer) {
    const dots = dotsContainer.querySelectorAll('.tech-slider-dot');
    dots.forEach((dot, i) => {
      dot.addEventListener('click', (e) => {
        e.preventDefault();
        updateSlider(i);
        resetAutoplay();
      });
    });
  }

  // Pause on Hover & Focus
  slider.addEventListener('mouseenter', () => {
    isHovered = true;
  });

  slider.addEventListener('mouseleave', () => {
    isHovered = false;
  });

  slider.addEventListener('focusin', () => {
    isHovered = true;
  });

  slider.addEventListener('focusout', () => {
    isHovered = false;
  });

  // Keyboard navigation
  slider.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
      e.preventDefault();
      prevSlide();
      resetAutoplay();
    } else if (e.key === 'ArrowRight') {
      e.preventDefault();
      nextSlide();
      resetAutoplay();
    }
  });

  // =========================================================
  // Drag & Swipe Interaction (Mouse sweep + Mobile touch)
  // =========================================================
  function getEventX(e) {
    return e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
  }

  function getEventY(e) {
    return e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
  }

  function onDragStart(e) {
    // Only accept left mouse click (button === 0) or touch
    if (e.type === 'mousedown' && e.button !== 0) return;

    // Do not initiate drag if user clicked directly on arrow buttons or dots
    if (e.target.closest('.tech-slider-arrow') || e.target.closest('.tech-slider-dot')) {
      return;
    }

    isDragging = true;
    hasDragged = false;
    startX = getEventX(e);
    startY = getEventY(e);
    currentDeltaX = 0;
    sliderWidth = slider.offsetWidth || 1;

    track.classList.add('no-transition');
    slider.classList.add('is-dragging');
    stopAutoplay();
  }

  function onDragMove(e) {
    if (!isDragging) return;

    const currentX = e.type.includes('touch') ? (e.touches[0] ? e.touches[0].clientX : startX) : e.clientX;
    const currentY = e.type.includes('touch') ? (e.touches[0] ? e.touches[0].clientY : startY) : e.clientY;

    const deltaX = currentX - startX;
    const deltaY = currentY - startY;

    // For touch: if user is scrolling vertically, cancel drag to allow native page scroll
    if (e.type.includes('touch') && !hasDragged && Math.abs(deltaY) > Math.abs(deltaX) && Math.abs(deltaY) > 8) {
      isDragging = false;
      slider.classList.remove('is-dragging');
      track.classList.remove('no-transition');
      updateSlider(currentIndex, true);
      return;
    }

    if (Math.abs(deltaX) > 6) {
      hasDragged = true;
      if (e.cancelable && e.type.includes('touch')) {
        e.preventDefault(); // prevent native scroll once horizontal intent is confirmed
      }
    }

    currentDeltaX = deltaX;

    // Real-time track position calculation
    let dragPercent = (deltaX / sliderWidth) * 100;

    // Resistance at the boundaries if looping is disabled
    if ((currentIndex === 0 && deltaX > 0) || (currentIndex === totalSlides - 1 && deltaX < 0)) {
      dragPercent *= 0.35; // rubber-band dampening
    }

    const currentPercent = -currentIndex * 100 + dragPercent;
    track.style.transform = `translate3d(${currentPercent}%, 0, 0)`;
  }

  function onDragEnd() {
    if (!isDragging) return;

    isDragging = false;
    slider.classList.remove('is-dragging');
    track.classList.remove('no-transition');

    const threshold = Math.min(sliderWidth * 0.12, 50); // 12% width or 50px

    if (currentDeltaX < -threshold) {
      // Swiped Left -> Next Slide
      nextSlide();
    } else if (currentDeltaX > threshold) {
      // Swiped Right -> Previous Slide
      prevSlide();
    } else {
      // Snap back to current slide
      updateSlider(currentIndex, true);
    }

    currentDeltaX = 0;
    resetAutoplay();

    // Reset hasDragged after a short delay so the click event can be captured and canceled
    setTimeout(() => {
      hasDragged = false;
    }, 60);
  }

  // Mouse drag events
  slider.addEventListener('mousedown', onDragStart);
  window.addEventListener('mousemove', onDragMove);
  window.addEventListener('mouseup', onDragEnd);

  // Touch drag events (mobiles & tablets)
  slider.addEventListener('touchstart', onDragStart, { passive: true });
  slider.addEventListener('touchmove', onDragMove, { passive: false });
  slider.addEventListener('touchend', onDragEnd, { passive: true });
  slider.addEventListener('touchcancel', onDragEnd, { passive: true });

  // Suppress link/button clicks if the user was dragging/sweeping
  slider.addEventListener('click', (e) => {
    if (hasDragged) {
      e.preventDefault();
      e.stopPropagation();
    }
  }, true); // Capture phase

  // Prevent native image dragging
  const images = slider.querySelectorAll('img');
  images.forEach(img => {
    img.addEventListener('dragstart', (e) => e.preventDefault());
  });

  // Initialize
  updateSlider(0, false);
  startAutoplay();
}
