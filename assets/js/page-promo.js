/**
 * Page Promo Script — Alya Esthetic Center
 * Source of Truth: promo/index.html + promo/skin-booster-agustus.html
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    // Mobile menu + burger handled globally in main.js

    // Filter chips + search (archive)
    var chips = document.querySelectorAll('.chip');
    var items = document.querySelectorAll('#promoGrid .promo-item');
    var search = document.getElementById('searchInput');

    if (chips.length && items.length) {
      function applyFilters() {
        var activeChipEl = document.querySelector('.chip.active');
        var f = activeChipEl ? (activeChipEl.dataset.filter || '') : '';
        var q = search ? search.value.trim().toLowerCase() : '';

        items.forEach(function (item) {
          var cats = (item.dataset.cat || '').split(' ').filter(Boolean);
          var title = item.querySelector('h3') ? item.querySelector('h3').textContent.toLowerCase() : '';
          var matchCat = (!f || f === 'semua' || cats.indexOf(f) > -1);
          var matchSearch = !q || title.indexOf(q) > -1;
          item.style.display = (matchCat && matchSearch) ? '' : 'none';
        });
      }

      chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
          chips.forEach(function (c) { c.classList.remove('active'); });
          chip.classList.add('active');
          applyFilters();
        });
      });

      if (search) {
        search.addEventListener('input', function () {
          chips.forEach(function (c) { c.classList.remove('active'); });
          applyFilters();
        });
      }
    }

    // Copy link (single)
    var copyBtn = document.getElementById('copyLink');
    if (copyBtn) {
      copyBtn.addEventListener('click', function (e) {
        e.preventDefault();
        navigator.clipboard.writeText(window.location.href).then(function () {
          copyBtn.setAttribute('title', 'Tautan disalin!');
        });
      });
    }
  });
})();
