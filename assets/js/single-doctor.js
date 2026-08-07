/**
 * Single Doctor Script — Alya Esthetic Center
 * Source of Truth: dokter-single.html
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var WA_NUMBER = '6281290000000';
    var docBookBtn = document.getElementById('docBookBtn');

    if (!docBookBtn) return;

    docBookBtn.addEventListener('click', function (e) {
      e.preventDefault();
      var fNama = document.getElementById('docNama');
      var fWA = document.getElementById('docWA');
      var fLayanan = document.getElementById('docLayanan');
      var fTanggal = document.getElementById('docTanggal');
      var fPesan = document.getElementById('docPesan');
      var docNameEl = document.querySelector('.doc-hero__info h1');

      var nama = fNama ? fNama.value.trim() : '';
      var wa = fWA ? fWA.value.trim() : '';
      var layanan = fLayanan ? fLayanan.value : '';
      var tanggal = fTanggal ? fTanggal.value : '';
      var pesan = fPesan ? fPesan.value.trim() : '';
      var docName = docNameEl ? docNameEl.textContent.trim() : 'Dokter';

      var text = 'Halo Alya Esthetic Center, saya ingin janji temu dengan *' + docName + '*.\n'
        + '------------------------------------------\n'
        + 'Nama      : ' + (nama || '-') + '\n'
        + 'No. WA    : ' + (wa || '-') + '\n';

      if (layanan) text += 'Layanan   : ' + layanan + '\n';
      if (tanggal) text += 'Tanggal   : ' + tanggal + '\n';
      if (pesan) text += 'Catatan   : ' + pesan + '\n';

      text += '------------------------------------------\nSaya diarahkan dari website. Terima kasih!';

      var url = 'https://web.whatsapp.com/send?phone=' + WA_NUMBER + '&text=' + encodeURIComponent(text);
      if (/iPhone|iPad|Android|Mobile/i.test(navigator.userAgent)) {
        url = 'https://api.whatsapp.com/send?phone=' + WA_NUMBER + '&text=' + encodeURIComponent(text);
      }

      window.open(url, '_blank');
    });
  });
})();
