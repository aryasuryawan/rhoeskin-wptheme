/**
 * Single Treatment Script — Alya Esthetic Center
 * Source of Truth: treatment.html
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var WA_NUMBER = '6281290000000';
    var bookBtn = document.getElementById('bookBtn');

    if (!bookBtn) return;

    bookBtn.addEventListener('click', function () {
      var fNama = document.getElementById('fNama');
      var fWA = document.getElementById('fWA');
      var fTanggal = document.getElementById('fTanggal');
      var heroTitle = document.querySelector('.t-hero h1');

      var nama = fNama ? fNama.value.trim() : '';
      var wa = fWA ? fWA.value.trim() : '';
      var tanggal = fTanggal ? fTanggal.value : '';
      var treatmentName = heroTitle ? heroTitle.textContent.trim() : 'Treatment';

      var text = 'Halo Alya Esthetic Center, saya ingin booking treatment *' + treatmentName + '*.\n'
        + '------------------------------------------\n'
        + 'Nama      : ' + (nama || '-') + '\n'
        + 'No. WA    : ' + (wa || '-') + '\n';

      if (tanggal) {
        text += 'Tanggal   : ' + tanggal + '\n';
      }

      text += '------------------------------------------\nSaya diarahkan dari website. Terima kasih!';

      var url = 'https://web.whatsapp.com/send?phone=' + WA_NUMBER + '&text=' + encodeURIComponent(text);
      if (/iPhone|iPad|Android|Mobile/i.test(navigator.userAgent)) {
        url = 'https://api.whatsapp.com/send?phone=' + WA_NUMBER + '&text=' + encodeURIComponent(text);
      }

      window.open(url, '_blank');
    });
  });
})();
