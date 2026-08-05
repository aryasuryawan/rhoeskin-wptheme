/**
 * Main JavaScript — Mobile Menu, Sticky Header, Slider, Accordion, Form Submit
 *
 * @package Alya_Esthetic
 */
(function() {
    'use strict';

    /* ─── DOM Ready ─── */
    document.addEventListener('DOMContentLoaded', init);

    function init() {
        initMobileMenu();
        initStickyHeader();
        initAccordion();
        initSmoothScroll();
        initFilterBar();
        initWhatsAppFloat();
        initJobApplyForm();
        initSwiper();
        initFaqV2();
        initTestimonialV2();
    }

    /* ─── Mobile Menu ─── */
    function initMobileMenu() {
        var toggle = document.querySelector('.site-header__toggle');
        var nav    = document.querySelector('.site-header__nav');
        if (!toggle || !nav) return;

        toggle.addEventListener('click', function() {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            nav.classList.toggle('is-open');
            document.body.style.overflow = expanded ? '' : 'hidden';
        });

        // Close on link click
        nav.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                toggle.setAttribute('aria-expanded', 'false');
                nav.classList.remove('is-open');
                document.body.style.overflow = '';
            });
        });

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && nav.classList.contains('is-open')) {
                toggle.setAttribute('aria-expanded', 'false');
                nav.classList.remove('is-open');
                document.body.style.overflow = '';
            }
        });
    }

    /* ─── Sticky Header ─── */
    function initStickyHeader() {
        var header = document.querySelector('.site-header--sticky');
        if (!header) return;

        var lastScroll = 0;

        window.addEventListener('scroll', function() {
            var currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                header.style.boxShadow = '0 2px 20px rgba(0,0,0,.08)';
            } else {
                header.style.boxShadow = 'none';
            }

            lastScroll = currentScroll;
        }, { passive: true });
    }

    /* ─── Accordion ─── */
    function initAccordion() {
        var items = document.querySelectorAll('.accordion__trigger');
        if (!items.length) return;

        items.forEach(function(trigger) {
            trigger.addEventListener('click', function() {
                var item    = this.closest('.accordion__item');
                var content = item.querySelector('.accordion__content');
                var isOpen  = item.classList.contains('accordion__item--active');

                // Close all
                item.closest('.accordion').querySelectorAll('.accordion__item').forEach(function(sibling) {
                    sibling.classList.remove('accordion__item--active');
                    sibling.querySelector('.accordion__trigger').setAttribute('aria-expanded', 'false');
                    sibling.querySelector('.accordion__content').setAttribute('aria-hidden', 'true');
                });

                // Toggle current
                if (!isOpen) {
                    item.classList.add('accordion__item--active');
                    this.setAttribute('aria-expanded', 'true');
                    content.setAttribute('aria-hidden', 'false');
                }
            });
        });
    }

    /* ─── Smooth Scroll ─── */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                var targetId = this.getAttribute('href');
                if (targetId === '#' || targetId === '#0') return;

                var target = document.querySelector(targetId);
                if (!target) return;

                e.preventDefault();
                var headerHeight = document.querySelector('.site-header').offsetHeight || 0;
                var targetPos    = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;

                window.scrollTo({
                    top: targetPos,
                    behavior: 'smooth'
                });
            });
        });
    }

    /* ─── Filter Bar (Services Archive) ─── */
    function initFilterBar() {
        var filterBtns = document.querySelectorAll('.filter-btn[data-filter]');
        if (!filterBtns.length) return;

        filterBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var filter = this.getAttribute('data-filter');

                // Update active state
                filterBtns.forEach(function(b) { b.classList.remove('filter-btn--active'); });
                this.classList.add('filter-btn--active');

                // Update URL without reload
                var url = new URL(window.location);
                if (filter === 'all') {
                    url.searchParams.delete('category');
                } else {
                    url.searchParams.set('category', filter);
                }
                window.history.pushState({}, '', url);

                // Filter cards
                var cards = document.querySelectorAll('.card--service');
                cards.forEach(function(card) {
                    if (filter === 'all') {
                        card.style.display = '';
                    } else {
                        // Note: This requires data-category attribute on cards
                        var category = card.getAttribute('data-category');
                        card.style.display = (category === filter) ? '' : 'none';
                    }
                });
            });
        });
    }

    /* ─── WhatsApp Float ─── */
    function initWhatsAppFloat() {
        var waFloat = document.getElementById('wa-float');
        if (!waFloat) return;

        var delay = parseInt(getComputedStyle(waFloat).getPropertyValue('--wa-delay')) || 2;

        setTimeout(function() {
            waFloat.style.display = 'block';
        }, delay * 1000);
    }

    /* ─── Job Apply Form (AJAX) ─── */
    function initJobApplyForm() {
        var form = document.getElementById('job-apply-form');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            var responseEl = document.getElementById('apply-response');
            var submitBtn  = form.querySelector('button[type="submit"]');
            var formData   = new FormData(form);

            // Validate
            var name  = form.querySelector('[name="applicant_name"]').value.trim();
            var email = form.querySelector('[name="applicant_email"]').value.trim();
            var cv    = form.querySelector('[name="applicant_cv"]');

            if (!name || !email) {
                showApplyResponse(responseEl, 'error', 'Nama dan email wajib diisi.');
                return;
            }

            if (!isValidEmail(email)) {
                showApplyResponse(responseEl, 'error', 'Format email tidak valid.');
                return;
            }

            if (cv && cv.files.length > 0) {
                var file     = cv.files[0];
                var maxSize  = 5 * 1024 * 1024; // 5MB
                var allowed  = ['pdf', 'doc', 'docx'];
                var ext      = file.name.split('.').pop().toLowerCase();

                if (file.size > maxSize) {
                    showApplyResponse(responseEl, 'error', 'Ukuran file maksimal 5MB.');
                    return;
                }

                if (allowed.indexOf(ext) === -1) {
                    showApplyResponse(responseEl, 'error', 'Format file harus PDF, DOC, atau DOCX.');
                    return;
                }
            }

            // Submit
            submitBtn.disabled = true;
            submitBtn.textContent = 'Mengirim...';

            fetch(alyaData.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    showApplyResponse(responseEl, 'success', data.data.message);
                    form.reset();
                } else {
                    showApplyResponse(responseEl, 'error', data.data.message);
                }
            })
            .catch(function() {
                showApplyResponse(responseEl, 'error', 'Terjadi kesalahan. Silakan coba lagi.');
            })
            .finally(function() {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Kirim Lamaran';
            });
        });
    }

    function showApplyResponse(el, type, message) {
        if (!el) return;
        el.style.display = 'block';
        el.className = 'apply-response apply-response--' + type;
        el.textContent = message;

        // Auto hide after 5s
        setTimeout(function() {
            el.style.display = 'none';
        }, 5000);
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    /* ─── Swiper Init ─── */
    function initSwiper() {
        var swiperEl = document.getElementById('testimonial-swiper');
        if (!swiperEl || typeof Swiper === 'undefined') return;

        new Swiper('#testimonial-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }

    /* ─── FAQ V2 — Tabs + Accordion ─── */
    function initFaqV2() {
        var faqTabs = document.getElementById('faqTabs');
        if (!faqTabs) return;

        var tabs = faqTabs.querySelectorAll('.faq-tab');
        var panels = document.querySelectorAll('.faq-panel');

        // Tab switching
        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                tabs.forEach(function(t) { t.classList.remove('active'); });
                panels.forEach(function(p) { p.classList.remove('active'); });
                tab.classList.add('active');
                var target = document.getElementById(tab.dataset.target);
                if (target) target.classList.add('active');
            });
        });

        // Arrow scroll
        var prevBtn = document.getElementById('faqPrev');
        var nextBtn = document.getElementById('faqNext');
        if (prevBtn) prevBtn.addEventListener('click', function() { faqTabs.scrollBy({left: -200, behavior: 'smooth'}); });
        if (nextBtn) nextBtn.addEventListener('click', function() { faqTabs.scrollBy({left: 200, behavior: 'smooth'}); });

        // Accordion
        document.querySelectorAll('.faq-item__q').forEach(function(q) {
            q.addEventListener('click', function() {
                var item = q.closest('.faq-item');
                var ans = item.querySelector('.faq-item__a');
                var wasOpen = item.classList.contains('open');

                // Close all in same panel
                item.parentElement.querySelectorAll('.faq-item').forEach(function(i) {
                    i.classList.remove('open');
                    i.querySelector('.faq-item__a').style.maxHeight = null;
                });

                // Toggle current
                if (!wasOpen) {
                    item.classList.add('open');
                    ans.style.maxHeight = ans.scrollHeight + 'px';
                }
            });
        });

        // Open first items
        document.querySelectorAll('.faq-item.open .faq-item__a').forEach(function(ans) {
            ans.style.maxHeight = ans.scrollHeight + 'px';
        });
    }

    /* ─── Testimonial V2 — Featured card switcher ─── */
    function initTestimonialV2() {
        var testiStrip = document.getElementById('testiStrip');
        if (!testiStrip) return;

        var avatars = testiStrip.querySelectorAll('.testi-avatar');
        var featMedia = document.getElementById('testiFeatMedia');
        var featName = document.getElementById('testiFeatName');
        var featRole = document.getElementById('testiFeatRole');
        var featQuote = document.getElementById('testiFeatQuote');

        avatars.forEach(function(btn) {
            btn.addEventListener('click', function() {
                avatars.forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');

                if (featMedia) {
                    featMedia.innerHTML = '<img src="' + btn.dataset.img + '" alt="' + btn.dataset.name + '">';
                }
                if (featName) featName.textContent = btn.dataset.name;
                if (featRole) featRole.textContent = btn.dataset.role;
                if (featQuote) featQuote.textContent = btn.dataset.quote;
            });
        });
    }

})();
