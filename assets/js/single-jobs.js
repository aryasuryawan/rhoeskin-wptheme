/**
 * Single Jobs Script — Alya Esthetic Center
 * Source of Truth: karir-detail.html
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var copyBtn = document.getElementById('copyLink');
    if (!copyBtn) return;

    copyBtn.addEventListener('click', function (e) {
      e.preventDefault();
      var currentUrl = window.location.href;

      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(currentUrl).then(function () {
          alert('Tautan lowongan berhasil disalin!');
        }).catch(function () {
          fallbackCopyText(currentUrl);
        });
      } else {
        fallbackCopyText(currentUrl);
      }
    });

    function fallbackCopyText(text) {
      var input = document.createElement('input');
      input.value = text;
      document.body.appendChild(input);
      input.select();
      document.execCommand('copy');
      document.body.removeChild(input);
      alert('Tautan lowongan berhasil disalin!');
    }
  });
})();
