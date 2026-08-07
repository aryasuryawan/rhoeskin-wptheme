/**
 * Page About JavaScript — Alya Esthetic Center
 * Source of Truth: tentang.html
 */

document.addEventListener('DOMContentLoaded', function () {
  var dCar = document.getElementById('docsCarousel');
  var dNext = document.getElementById('docsNext');
  var dPrev = document.getElementById('docsPrev');

  if (dCar) {
    if (dNext) {
      dNext.addEventListener('click', function () {
        dCar.scrollBy({ left: 300, behavior: 'smooth' });
      });
    }
    if (dPrev) {
      dPrev.addEventListener('click', function () {
        dCar.scrollBy({ left: -300, behavior: 'smooth' });
      });
    }
    setInterval(function () {
      if (dCar.scrollLeft + dCar.clientWidth >= dCar.scrollWidth - 4) {
        dCar.scrollTo({ left: 0, behavior: 'smooth' });
      } else {
        dCar.scrollBy({ left: 300, behavior: 'smooth' });
      }
    }, 4000);
  }
});
