/**
 * Page Blog Script — Alya Esthetic Center
 * Source of Truth: artikel.html
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var chips = document.querySelectorAll('.chip');
    var cards = document.querySelectorAll('#blogGrid .post-card');
    var empty = document.getElementById('emptyState');
    var search = document.getElementById('searchInput');

    if (!cards.length) return;

    function applyFilters() {
      var activeChipEl = document.querySelector('.chip.active');
      var activeFilter = activeChipEl ? (activeChipEl.dataset.filter || activeChipEl.dataset.cat || '') : '';
      var q = search ? search.value.trim().toLowerCase() : '';
      var visibleCount = 0;

      cards.forEach(function (card) {
        var cat = card.dataset.cat || '';
        var title = card.querySelector('h3') ? card.querySelector('h3').textContent.toLowerCase() : '';
        var matchCat = (!activeFilter || activeFilter === 'semua' || cat.indexOf(activeFilter) > -1);
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
