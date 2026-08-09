/**
 * Page Doctors Script — Alya Esthetic Center
 * Features: tab filter + name search + AJAX pagination
 */

(function () {
  'use strict';

  /* ── State ── */
  var state = {
    category: 'all',
    search:   '',
    paged:    1,
    maxPages: 1,
    loading:  false,
  };

  /* ── DOM refs ── */
  var grid       = document.getElementById('doctorsGrid');
  var pagination = document.getElementById('doctorsPagination');
  var tabs       = document.querySelectorAll('#doctorTabs .tab');
  var searchInput = document.getElementById('doctorSearch');

  if (!grid) return; // not on doctors page

  /* ── Debounce utility ── */
  function debounce(fn, delay) {
    var timer;
    return function () {
      var args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function () { fn.apply(null, args); }, delay);
    };
  }

  /* ── Loading state ── */
  function setLoading(on) {
    state.loading = on;
    grid.classList.toggle('is-loading', on);
  }

  /* ── Build pagination HTML ── */
  function buildPagination(current, max) {
    if (max <= 1) {
      pagination.innerHTML = '';
      return;
    }

    var html = '<nav class="pagination"><ul>';

    // Prev
    if (current > 1) {
      html += '<li><button class="page-btn" data-page="' + (current - 1) + '">&laquo; Sebelumnya</button></li>';
    }

    // Page numbers — show up to 5 around current
    var start = Math.max(1, current - 2);
    var end   = Math.min(max, current + 2);

    if (start > 1) {
      html += '<li><button class="page-btn" data-page="1">1</button></li>';
      if (start > 2) html += '<li><span class="page-dots">&hellip;</span></li>';
    }

    for (var i = start; i <= end; i++) {
      if (i === current) {
        html += '<li><span class="page-btn page-btn--active">' + i + '</span></li>';
      } else {
        html += '<li><button class="page-btn" data-page="' + i + '">' + i + '</button></li>';
      }
    }

    if (end < max) {
      if (end < max - 1) html += '<li><span class="page-dots">&hellip;</span></li>';
      html += '<li><button class="page-btn" data-page="' + max + '">' + max + '</button></li>';
    }

    // Next
    if (current < max) {
      html += '<li><button class="page-btn" data-page="' + (current + 1) + '">Selanjutnya &raquo;</button></li>';
    }

    html += '</ul></nav>';
    pagination.innerHTML = html;

    /* Bind pagination buttons */
    pagination.querySelectorAll('.page-btn[data-page]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var page = parseInt(btn.getAttribute('data-page'), 10);
        if (page !== state.paged) {
          state.paged = page;
          fetchDoctors(true);
        }
      });
    });
  }

  /* ── Scroll to grid top ── */
  function scrollToGrid() {
    var filterBar = document.getElementById('doctorFilterBar');
    var offset    = filterBar ? filterBar.getBoundingClientRect().bottom + window.scrollY + 16 : grid.getBoundingClientRect().top + window.scrollY - 20;
    window.scrollTo({ top: offset, behavior: 'smooth' });
  }

  /* ── Empty state ── */
  function showEmpty() {
    grid.innerHTML = '<p class="doctors-empty">Tidak ada dokter yang ditemukan untuk pencarian "<strong>' +
      escapeHtml(state.search) + '</strong>".</p>';
    pagination.innerHTML = '';
  }

  function escapeHtml(str) {
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  /* ── Main fetch ── */
  function fetchDoctors(scrollUp) {
    if (state.loading) return;
    setLoading(true);

    var data = new FormData();
    data.append('action',   'alya_doctors_filter');
    data.append('nonce',    alyaData.nonce);
    data.append('s',        state.search);
    data.append('category', state.category);
    data.append('paged',    state.paged);

    fetch(alyaData.ajaxUrl, { method: 'POST', body: data })
      .then(function (res) { return res.json(); })
      .then(function (res) {
        setLoading(false);

        if (!res.success) return;

        var payload = res.data;
        state.maxPages = payload.max_pages || 1;

        if (!payload.html || !payload.html.trim()) {
          showEmpty();
        } else {
          grid.innerHTML = payload.html;
          buildPagination(state.paged, state.maxPages);
        }

        if (scrollUp) scrollToGrid();
      })
      .catch(function () {
        setLoading(false);
      });
  }

  /* ── Tab filter ── */
  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      tabs.forEach(function (t) { t.classList.remove('active'); });
      tab.classList.add('active');

      state.category = tab.getAttribute('data-filter') || 'all';
      state.paged    = 1;
      fetchDoctors(false);
    });
  });

  /* ── Search input (debounced 400ms) ── */
  if (searchInput) {
    searchInput.addEventListener('input', debounce(function () {
      state.search = searchInput.value.trim();
      state.paged  = 1;
      fetchDoctors(false);
    }, 400));

    /* Clear search when user empties the field via keyboard / clear button */
    searchInput.addEventListener('search', function () {
      if (searchInput.value === '') {
        state.search = '';
        state.paged  = 1;
        fetchDoctors(false);
      }
    });
  }

})();
