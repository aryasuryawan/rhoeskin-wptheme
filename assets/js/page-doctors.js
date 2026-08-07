/**
 * Page Doctors Script — Alya Esthetic Center
 * Source of Truth: dokter.html
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('.filter-tabs .tab');
    var cards = document.querySelectorAll('.doctors-grid .doc-card');

    if (!tabs.length || !cards.length) return;

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        var filter = tab.dataset.filter || 'all';

        tabs.forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');

        cards.forEach(function (card) {
          var cat = card.dataset.cat || '';
          if (filter === 'all' || cat.indexOf(filter) > -1) {
            card.style.display = '';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  });
})();
