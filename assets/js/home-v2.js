/**
 * Home V2 JavaScript Interactions — Alya Esthetic Center
 * Source of Truth: index_v2.html
 */

document.addEventListener('DOMContentLoaded', function () {

  /* ── 1. One-Page Scrollspy ── */
  var sectionIds = ['beranda', 'tentang', 'layanan', 'dokter', 'testimoni', 'faq', 'kontak'];
  var sections = sectionIds.map(function (id) {
    return document.getElementById(id);
  }).filter(Boolean);

  if (navLinks && sections.length > 0) {
    var links = navLinks.querySelectorAll('a[href^="#"], a[href*="#"]');

    function updateScrollspy() {
      var scrollPos = window.scrollY + 140;
      sections.forEach(function (sec) {
        if (scrollPos >= sec.offsetTop && scrollPos < sec.offsetTop + sec.offsetHeight) {
          links.forEach(function (l) { l.classList.remove('active'); });
          var match = navLinks.querySelector('a[href="#' + sec.id + '"], a[href*="#' + sec.id + '"]');
          if (match) match.classList.add('active');
        }
      });
    }

    window.addEventListener('scroll', updateScrollspy, { passive: true });
    updateScrollspy();
  }

  /* ── Footer year ── */
  var yearEl = document.getElementById('year') || document.getElementById('currentYear');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  /* ── 2. Doctors Slider (aktif bila data-use-slider=1) ── */
  var doctorsSection = document.getElementById('dokter');
  if (doctorsSection) {
    var useDocSlider = doctorsSection.getAttribute('data-use-slider') === '1';
    var docSwiperEl  = document.getElementById('docSwiper');

    if (useDocSlider && docSwiperEl && typeof Swiper !== 'undefined') {
      var docCount = parseInt(doctorsSection.getAttribute('data-doc-count') || '0', 10);
      new Swiper(docSwiperEl, {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: docCount >= 10, // loop hanya jika cukup banyak slide
        grabCursor: true,
        pagination: {
          el: '.doc-swiper__pagination',
          clickable: true,
        },
        navigation: {
          prevEl: '.doc-swiper__prev',
          nextEl: '.doc-swiper__next',
        },
        breakpoints: {
          560:  { slidesPerView: 3, spaceBetween: 20 },
          768:  { slidesPerView: 4, spaceBetween: 24 },
          1080: { slidesPerView: 5, spaceBetween: 24 },
        },
      });
    }
  }

  /* ── 3. Testimonials — switcher + optional Swiper strip (aktif bila data-use-slider=1) ── */
  var testiSection = document.getElementById('testimoni');
  var useSlider    = testiSection && testiSection.getAttribute('data-use-slider') === '1';

  /* Helper: build star HTML */
  function buildStars(filled) {
    var html = '';
    for (var i = 1; i <= 5; i++) {
      html += i <= filled
        ? '<span class="star star--filled">&#9733;</span>'
        : '<span class="star">&#9734;</span>';
    }
    return html;
  }

  /* Helper: update featured card */
  function updateFeat(btn) {
    var featMedia = document.getElementById('testiFeatMedia');
    var featName  = document.getElementById('testiFeatName');
    var featRole  = document.getElementById('testiFeatRole');
    var featQuote = document.getElementById('testiFeatQuote');
    var featStars = document.getElementById('testiFeatStars');

    if (featMedia) {
      if (btn.dataset.img) {
        featMedia.innerHTML = '<img src="' + btn.dataset.img + '" alt="' + (btn.dataset.name || '') + '">';
      } else {
        featMedia.innerHTML = '<div class="testi-feat__initial">' + (btn.dataset.name || 'A').charAt(0) + '</div>';
      }
    }
    if (featName)  featName.textContent  = btn.dataset.name  || '';
    if (featRole)  featRole.textContent  = btn.dataset.role  || '';
    if (featQuote) featQuote.textContent = btn.dataset.quote || '';
    if (featStars) featStars.innerHTML   = buildStars(parseInt(btn.dataset.rating, 10) || 5);
  }

  var testiStrip = document.getElementById('testiStrip');

  if (useSlider && testiStrip && typeof Swiper !== 'undefined') {
    /* Swiper mode — strip menjadi carousel, klik slide update featured card */
    var avatarSwiper = new Swiper('#testiAvatarSwiper', {
      slidesPerView: 2,
      spaceBetween: 8,
      grabCursor: true,
      centeredSlides: false,
      pagination: {
        el: '.testi-swiper__pagination',
        clickable: true,
      },
      navigation: {
        prevEl: '.testi-swiper__prev',
        nextEl: '.testi-swiper__next',
      },
      breakpoints: {
        480: { slidesPerView: 3, spaceBetween: 8 },
        768: { slidesPerView: 4, spaceBetween: 10 },
        1080: { slidesPerView: 6, spaceBetween: 10 },
      },
    });

    /* Klik avatar di dalam Swiper */
    testiStrip.addEventListener('click', function (e) {
      var btn = e.target.closest('.testi-avatar');
      if (!btn) return;
      testiStrip.querySelectorAll('.testi-avatar').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      updateFeat(btn);
    });

  } else if (testiStrip) {
    /* Mode default — strip scroll biasa, klik avatar update featured card */
    var avatars = testiStrip.querySelectorAll('.testi-avatar');
    avatars.forEach(function (btn) {
      btn.addEventListener('click', function () {
        avatars.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        updateFeat(btn);
      });
    });
  }

  /* ── 4. FAQ Tabs & Scroll Arrows ── */
  var faqTabs = document.getElementById('faqTabs');
  if (faqTabs) {
    var tabs   = faqTabs.querySelectorAll('.faq-tab');
    var panels = document.querySelectorAll('.faq-panel');

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) { t.classList.remove('active'); });
        panels.forEach(function (p) { p.classList.remove('active'); });
        tab.classList.add('active');

        var targetId = tab.dataset.target;
        if (targetId) {
          var targetPanel = document.getElementById(targetId);
          if (targetPanel) {
            targetPanel.classList.add('active');
            targetPanel.querySelectorAll('.faq-item.open .faq-item__a').forEach(function (ans) {
              ans.style.maxHeight = ans.scrollHeight + 'px';
            });
          }
        }
      });
    });

    var faqPrev = document.getElementById('faqPrev');
    var faqNext = document.getElementById('faqNext');
    if (faqPrev) faqPrev.addEventListener('click', function () { faqTabs.scrollBy({ left: -200, behavior: 'smooth' }); });
    if (faqNext) faqNext.addEventListener('click', function () { faqTabs.scrollBy({ left:  200, behavior: 'smooth' }); });
  }

  /* Initial open accordion heights */
  document.querySelectorAll('.faq-item.open .faq-item__a').forEach(function (ans) {
    ans.style.maxHeight = ans.scrollHeight + 'px';
  });

});
