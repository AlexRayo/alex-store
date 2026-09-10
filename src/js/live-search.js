/**
 * Alex Store - Live Predictive Search (Desktop & Mobile Amazon Style)
 */

export function initLiveSearch() {
  const searchInputs = document.querySelectorAll('.alex-live-search-input, .tech-live-search-input');
  const getParams = () => window.alexStoreData || window.techStoreParams || {};

  searchInputs.forEach(input => {
    const container = input.closest('.alex-search-wrapper, .tech-search-wrapper');
    if (!container) return;

    const resultsBox = container.querySelector('.alex-search-results, .tech-search-results');
    let debounceTimer = null;

    input.addEventListener('input', function() {
      const query = this.value.trim();
      clearTimeout(debounceTimer);

      if (query.length < 2) {
        if (resultsBox) {
          resultsBox.innerHTML = '';
          resultsBox.classList.add('hidden');
        }
        return;
      }

      debounceTimer = setTimeout(async () => {
        if (!resultsBox) return;
        resultsBox.classList.remove('hidden');
        resultsBox.innerHTML = '<div class="p-4 text-center text-xs sm:text-sm text-neutral-500 flex items-center justify-center gap-2"><span class="loading-spinner border-primary border-t-transparent inline-block w-4 h-4"></span> Buscando productos...</div>';

        try {
          const params = getParams();
          const formData = new FormData();
          formData.append('action', 'alex_store_ajax_search');
          formData.append('query', query);
          formData.append('nonce', params.nonce || '');

          const response = await fetch(params.ajaxUrl || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData,
          });

          const data = await response.json();
          if (data.success && data.data && data.data.products && data.data.products.length > 0) {
            let html = '<div class="divide-y divide-neutral-100 p-1">';
            data.data.products.forEach(p => {
              html += `
                <a href="${p.permalink}" class="flex items-center gap-3 p-3 hover:bg-neutral-50 rounded-xl transition-colors">
                  <img src="${p.image}" alt="${p.title}" class="w-12 h-12 object-contain rounded-lg bg-neutral-50 border border-neutral-200 flex-shrink-0 p-1" />
                  <div class="flex-1 min-w-0">
                    <span class="text-[10px] uppercase font-semibold text-neutral-400 block truncate">${p.category || 'Tecnología'}</span>
                    <h4 class="text-xs sm:text-sm font-semibold text-neutral-900 line-clamp-1 capitalize">${p.title}</h4>
                    <div class="text-xs font-bold text-neutral-900 mt-0.5">${p.price}</div>
                  </div>
                </a>
              `;
            });
            html += `
              <div class="p-2.5 text-center bg-neutral-50 border-t border-neutral-100 rounded-b-xl">
                <button type="button" onclick="this.closest('form').submit()" class="text-xs font-bold text-neutral-700 hover:text-cta transition-colors">
                  Ver todos los resultados para "${query}" &rarr;
                </button>
              </div>
            </div>`;
            resultsBox.innerHTML = html;
          } else {
            resultsBox.innerHTML = '<div class="p-5 text-center text-xs sm:text-sm text-neutral-500">No se encontraron productos para "' + query + '".</div>';
          }
        } catch (err) {
          console.error('Search error:', err);
          resultsBox.innerHTML = '<div class="p-4 text-center text-xs text-rose-500">Error al consultar productos.</div>';
        }
      }, 250);
    });

    // Close search results dropdown on outside click
    document.addEventListener('click', function(e) {
      if (!container.contains(e.target) && resultsBox) {
        resultsBox.classList.add('hidden');
      }
    });

    // Reopen results on focus if query is present
    input.addEventListener('focus', function() {
      if (this.value.trim().length >= 2 && resultsBox && resultsBox.children.length > 0) {
        resultsBox.classList.remove('hidden');
      }
    });
  });
}
