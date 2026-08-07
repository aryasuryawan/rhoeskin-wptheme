/**
 * Page Jobs Script — Alya Esthetic Center
 * Source of Truth: karir.html
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var chips = document.querySelectorAll('.chip');
    var cards = document.querySelectorAll('#jobsGrid .job-card');
    var empty = document.getElementById('emptyJobsState');
    var search = document.querySelector('.searchbox input');

    if (!cards.length) return;

    function applyFilters() {
      var activeChipEl = document.querySelector('.chip.active');
      var activeFilter = activeChipEl ? (activeChipEl.dataset.careerCategory || activeChipEl.dataset.filter || '') : '';
      var q = search ? search.value.trim().toLowerCase() : '';
      var visibleCount = 0;

      cards.forEach(function (card) {
        var cat = card.dataset.cat || card.dataset.careerCategory || '';
        var title = card.querySelector('h3') ? card.querySelector('h3').textContent.toLowerCase() : '';
        var matchCat = (!activeFilter || activeFilter === 'semua' || cat.indexOf(activeFilter) > -1);
        var matchSearch = !q || (title.indexOf(q) > -1);
        var show = matchCat && matchSearch;

        card.style.display = show ? '' : 'none';
        if (show) visibleCount++;
      });

      if (empty) {
        empty.style.display = visibleCount === 0 ? 'block' : 'none';
      }
    }

    chips.forEach(function (chip) {
      chip.addEventListener('click', function (e) {
        e.preventDefault();
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
