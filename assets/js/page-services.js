/**
 * Page Services Script — Alya Esthetic Center
 * Source of Truth: services.html
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var chips = document.querySelectorAll('.chip');
    var cards = document.querySelectorAll('#treatGrid .t-card');
    var empty = document.getElementById('emptyState');
    var search = document.getElementById('searchInput');

    if (!cards.length) return;

    function applyFilters() {
      var activeChipEl = document.querySelector('.chip.active');
      var activeFilter = activeChipEl ? (activeChipEl.dataset.filter || activeChipEl.dataset.service || '') : '';
      var q = search ? search.value.trim().toLowerCase() : '';
      var visibleCount = 0;

      cards.forEach(function (card) {
        var cat = card.dataset.cat || card.dataset.service || '';
        var title = card.querySelector('h4') ? card.querySelector('h4').textContent.toLowerCase() : '';
        var matchCat = (!activeFilter || activeFilter === 'semua' || cat === activeFilter);
        var matchSearch = !q || (title.indexOf(q) > -1);
        var show = matchCat && matchSearch;

        card.style.display = show ? '' : 'none';
        if (show) visibleCount++;
      });

      if (empty) {
        empty.classList.toggle('show', visibleCount === 0);
      }
    }

    chips.forEach(function (chip) {
      chip.addEventListener('click', function (e) {
        // If it's a normal link navigation with query params, allow if required or filter client side
        chips.forEach(function (c) { c.classList.remove('active'); });
        chip.classList.add('active');
        applyFilters();
      });
    });

    if (search) {
      search.addEventListener('input', applyFilters);
    }
  });
})();