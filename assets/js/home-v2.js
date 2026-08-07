/**
 * Home V2 JavaScript Interactions — Alya Esthetic Center
 * Source of Truth: index_v2.html
 */

document.addEventListener('DOMContentLoaded', function () {
  // 1. Mobile Burger Menu Toggle
  var burger = document.getElementById('burger');
  var navLinks = document.getElementById('navLinks');
  if (burger && navLinks) {
    burger.addEventListener('click', function () {
      navLinks.classList.toggle('open');
    });
    navLinks.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () {
        navLinks.classList.remove('open');
      });
    });
  }

  // 2. One-Page Scrollspy (Anchor Nav active class)
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
          links.forEach(function (l) {
            l.classList.remove('active');
          });
          var match = navLinks.querySelector('a[href="#' + sec.id + '"], a[href*="#' + sec.id + '"]');
          if (match) match.classList.add('active');
        }
      });
    }

    window.addEventListener('scroll', updateScrollspy, { passive: true });
    updateScrollspy();
  }

  // Set footer current year
  var yearEl = document.getElementById('year') || document.getElementById('currentYear');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }

  // 3. Testimonials Switcher
  var testiStrip = document.getElementById('testiStrip');
  if (testiStrip) {
    var avatars = testiStrip.querySelectorAll('.testi-avatar');
    var featMedia = document.getElementById('testiFeatMedia');
    var featName = document.getElementById('testiFeatName');
    var featRole = document.getElementById('testiFeatRole');
    var featQuote = document.getElementById('testiFeatQuote');

    avatars.forEach(function (btn) {
      btn.addEventListener('click', function () {
        avatars.forEach(function (b) {
          b.classList.remove('active');
        });
        btn.classList.add('active');

        if (featMedia) {
          if (btn.dataset.img) {
            featMedia.innerHTML = '<img src="' + btn.dataset.img + '" alt="' + (btn.dataset.name || '') + '">';
          } else {
            var initial = (btn.dataset.name || 'A').charAt(0);
            featMedia.innerHTML = '<div class="testi-feat__initial">' + initial + '</div>';
          }
        }
        if (featName) featName.textContent = btn.dataset.name || '';
        if (featRole) featRole.textContent = btn.dataset.role || '';
        if (featQuote) featQuote.textContent = btn.dataset.quote || '';
      });
    });
  }

  // 4. FAQ Tabs & Scroll Arrows
  var faqTabs = document.getElementById('faqTabs');
  if (faqTabs) {
    var tabs = faqTabs.querySelectorAll('.faq-tab');
    var panels = document.querySelectorAll('.faq-panel');

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) {
          t.classList.remove('active');
        });
        panels.forEach(function (p) {
          p.classList.remove('active');
        });

        tab.classList.add('active');
        var targetId = tab.dataset.target;
        if (targetId) {
          var targetPanel = document.getElementById(targetId);
          if (targetPanel) {
            targetPanel.classList.add('active');
            // Re-calculate heights for open accordion items in target panel
            targetPanel.querySelectorAll('.faq-item.open .faq-item__a').forEach(function (ans) {
              ans.style.maxHeight = ans.scrollHeight + 'px';
            });
          }
        }
      });
    });

    var faqPrev = document.getElementById('faqPrev');
    var faqNext = document.getElementById('faqNext');
    if (faqPrev) {
      faqPrev.addEventListener('click', function () {
        faqTabs.scrollBy({ left: -200, behavior: 'smooth' });
      });
    }
    if (faqNext) {
      faqNext.addEventListener('click', function () {
        faqTabs.scrollBy({ left: 200, behavior: 'smooth' });
      });
    }
  }

  // 5. FAQ Accordion Expand/Collapse
  var faqQuestions = document.querySelectorAll('.faq-item__q');
  faqQuestions.forEach(function (q) {
    q.addEventListener('click', function () {
      var item = q.closest('.faq-item');
      if (!item) return;
      var ans = item.querySelector('.faq-item__a');
      if (!ans) return;

      var wasOpen = item.classList.contains('open');
      var parent = item.parentElement;

      // Close other items in the same panel
      if (parent) {
        parent.querySelectorAll('.faq-item').forEach(function (i) {
          i.classList.remove('open');
          var a = i.querySelector('.faq-item__a');
          if (a) a.style.maxHeight = null;
        });
      }

      if (!wasOpen) {
        item.classList.add('open');
        ans.style.maxHeight = ans.scrollHeight + 'px';
      }
    });
  });

  // Calculate height for initial open accordion items
  document.querySelectorAll('.faq-item.open .faq-item__a').forEach(function (ans) {
    ans.style.maxHeight = ans.scrollHeight + 'px';
  });
});
