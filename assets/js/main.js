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
        initBlogFilter();
        initBlogSearch();
        initWhatsAppFloat();
        initJobApplyForm();
        initSwiper();
        initDoctorsCarousel();
        initCategoryNav();
        initJobsFilter();
        initFaqV2();
        initTestimonialV2();
        initHomeV2Scrollspy();
        initCopyrightYear();
    }

    /* ─── Copyright Year ─── */
    function initCopyrightYear() {
        var yearEl = document.getElementById('year');
        if (yearEl) yearEl.textContent = new Date().getFullYear();
    }

    /* ─── Category Nav (Technology Page) ─── */
    function initCategoryNav() {
        var catNav = document.getElementById('catNav');
        if (!catNav) return;

        var catLinks = catNav.querySelectorAll('.cat-link');
        var sections = [];

        catLinks.forEach(function(link) {
            var id = link.getAttribute('href').replace('#', '');
            var section = document.getElementById(id);
            if (section) sections.push({ el: section, link: link });
        });

        if (sections.length === 0) return;

        // Click handler for smooth scroll
        catLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var id = this.getAttribute('href').replace('#', '');
                var target = document.getElementById(id);
                if (target) {
                    var offset = catNav.offsetHeight + 72;
                    var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                }
            });
        });

        // Scroll spy
        var ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    var scrollPos = window.pageYOffset + catNav.offsetHeight + 100;
                    var current = sections[0];

                    sections.forEach(function(s) {
                        if (s.el.offsetTop <= scrollPos) {
                            current = s;
                        }
                    });

                    catLinks.forEach(function(l) { l.classList.remove('active'); });
                    if (current) current.link.classList.add('active');
                    ticking = false;
                });
                ticking = true;
            }
        });
    }

    /* ─── Doctors Carousel ─── */
    function initDoctorsCarousel() {
        var carousel = document.getElementById('docsCarousel');
        var prevBtn = document.getElementById('docsPrev');
        var nextBtn = document.getElementById('docsNext');
        if (!carousel || !prevBtn || !nextBtn) return;

        prevBtn.addEventListener('click', function() {
            carousel.scrollBy({ left: -300, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', function() {
            carousel.scrollBy({ left: 300, behavior: 'smooth' });
        });

        // Auto-scroll every 4 seconds
        var autoScroll = setInterval(function() {
            if (carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth - 4) {
                carousel.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                carousel.scrollBy({ left: 300, behavior: 'smooth' });
            }
        }, 4000);

        // Pause on hover
        carousel.addEventListener('mouseenter', function() {
            clearInterval(autoScroll);
        });

        carousel.addEventListener('mouseleave', function() {
            autoScroll = setInterval(function() {
                if (carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth - 4) {
                    carousel.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    carousel.scrollBy({ left: 300, behavior: 'smooth' });
                }
            }, 4000);
        });
    }

    /* ─── Mobile Menu ─── */
    function initMobileMenu() {
        var burger = document.getElementById('burger');
        var nav    = document.getElementById('navLinks');
        if (!burger || !nav) return;

        burger.addEventListener('click', function() {
            nav.classList.toggle('open');
            document.body.style.overflow = nav.classList.contains('open') ? 'hidden' : '';
        });

        // Close on link click
        nav.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                nav.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
    }

    /* ─── Sticky Header ─── */
    function initStickyHeader() {
        var header = document.getElementById('siteHeader');
        if (!header) return;

        var lastScroll = 0;
        var ticking = false;

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    var currentScroll = window.pageYOffset;

                    if (currentScroll > 80) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }

                    lastScroll = currentScroll;
                    ticking = false;
                });
                ticking = true;
            }
        });
    }

    /* ─── Accordion (generic) ─── */
    function initAccordion() {
        document.querySelectorAll('.accordion__trigger').forEach(function(trigger) {
            trigger.addEventListener('click', function() {
                var item = this.closest('.accordion__item');
                var wasOpen = item.classList.contains('accordion__item--active');

                // Close all
                document.querySelectorAll('.accordion__item').forEach(function(i) {
                    i.classList.remove('accordion__item--active');
                });

                // Toggle current
                if (!wasOpen) {
                    item.classList.add('accordion__item--active');
                }
            });
        });
    }

    /* ─── Smooth Scroll for anchor links ─── */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                var href = this.getAttribute('href');
                if (href === '#') return;

                var target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    var header = document.getElementById('siteHeader');
                    var offset = header ? header.offsetHeight : 0;
                    var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                }
            });
        });
    }

    /* ─── Filter Bar (Services/Treatments) ─── */
    function initFilterBar() {
        var filterBar = document.querySelector('.filter-bar');
        if (!filterBar) return;

        var buttons = filterBar.querySelectorAll('.filter-btn');
        var grid = document.querySelector('.svc-grid, .cards-grid, .posts-grid, .related__grid');

        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                buttons.forEach(function(b) { b.classList.remove('filter-btn--active'); });
                this.classList.add('filter-btn--active');

                // If AJAX filter exists, trigger it
                var category = this.dataset.category;
                if (category && typeof alyaFilterPosts === 'function') {
                    alyaFilterPosts(category);
                }
            });
        });
    }

    /* ─── Blog Filter (AJAX) ─── */
    function initBlogFilter() {
        window.alyaFilterPosts = function(category, containerId) {
            var container = document.getElementById(containerId || 'postsContainer');
            if (!container) return;

            var btn = document.querySelector('.filter-btn[data-category="' + category + '"]');
            if (btn) btn.classList.add('loading');

            fetch(alyaData.ajaxUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'alya_posts_filter',
                    category: category,
                    nonce: alyaData.nonce
                })
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    container.innerHTML = data.html;
                    // Re-init any components in new content
                    initPostCards();
                }
                if (btn) btn.classList.remove('loading');
            })
            .catch(function() {
                if (btn) btn.classList.remove('loading');
            });
        };
    }

    function initPostCards() {
        // Placeholder for any post-card initialization
    }

    /* ─── Blog Search ─── */
    function initBlogSearch() {
        var searchForm = document.querySelector('.search-form');
        if (!searchForm) return;

        var input = searchForm.querySelector('.search-form__input');
        var timer = null;

        input.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                var query = input.value.trim();
                if (query.length < 2) return;

                var container = document.getElementById('searchResults');
                if (!container) return;

                fetch(alyaData.ajaxUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'alya_search_posts',
                        s: query,
                        nonce: alyaData.nonce
                    })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.success) {
                        container.innerHTML = data.html;
                    }
                });
            }, 300);
        });
    }

    /* ─── Floating WhatsApp ─── */
    function initWhatsAppFloat() {
        var fab = document.getElementById('fab-wa');
        if (!fab) return;

        fab.addEventListener('click', function(e) {
            var phone = fab.getAttribute('data-phone') || '6281290000000';
            var msg = fab.getAttribute('data-message') || 'Halo Alya Esthetic, saya ingin konsultasi.';
            var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            var url = isMobile 
                ? 'https://api.whatsapp.com/send?phone=' + phone + '&text=' + encodeURIComponent(msg)
                : 'https://web.whatsapp.com/send?phone=' + phone + '&text=' + encodeURIComponent(msg);

            e.preventDefault();
            window.open(url, '_blank');
        });
    }

    /* ─── Jobs Filter (Career Page) ─── */
    function initJobsFilter() {
        var jobBtns = document.querySelectorAll('.job-chip, .job-tab');
        var jobCards = document.querySelectorAll('.job-card');
        if (!jobBtns.length || !jobCards.length) return;

        jobBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var filter = btn.dataset.filter || 'all';
                jobBtns.forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');

                jobCards.forEach(function(card) {
                    var cat = card.dataset.cat || card.dataset.category || 'all';
                    if (filter === 'all' || cat.indexOf(filter) > -1) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    /* ─── Job Apply Form ─── */
    function initJobApplyForm() {
        var form = document.getElementById('jobApplyForm');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            var submitBtn = form.querySelector('button[type="submit"]');
            var originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Mengirim...';

            var formData = new FormData(form);
            formData.append('action', 'alya_job_apply');
            formData.append('nonce', alyaData.nonce);

            fetch(alyaData.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                var msgEl = document.getElementById('applyResponse');
                if (msgEl) {
                    msgEl.className = 'apply-response ' + (data.success ? 'apply-response--success' : 'apply-response--error');
                    msgEl.textContent = data.data.message;
                    msgEl.style.display = 'block';
                }
                if (data.success) form.reset();
            })
            .catch(function() {
                var msgEl = document.getElementById('applyResponse');
                if (msgEl) {
                    msgEl.className = 'apply-response apply-response--error';
                    msgEl.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                    msgEl.style.display = 'block';
                }
            })
            .finally(function() {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }

    /* ─── Swiper Init ─── */
    function initSwiper() {
        if (typeof Swiper === 'undefined') return;

        // Testimonial Swiper
        var testiSwiper = document.getElementById('testimonial-swiper');
        if (testiSwiper) {
            new Swiper(testiSwiper, {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                },
            });
        }

        // Instagram Feed Swiper
        var igSwiper = document.getElementById('igSwiper');
        if (igSwiper) {
            new Swiper(igSwiper, {
                slidesPerView: 2,
                spaceBetween: 14,
                loop: true,
                autoplay: { delay: 3000, disableOnInteraction: false },
                breakpoints: {
                    480: { slidesPerView: 3 },
                    768: { slidesPerView: 4 },
                    1024: { slidesPerView: 6 },
                },
            });
        }

        // Related Posts Swiper
        var relatedSwiper = document.getElementById('relatedSwiper');
        if (relatedSwiper) {
            new Swiper(relatedSwiper, {
                slidesPerView: 1,
                spaceBetween: 24,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                },
            });
        }
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
                var parent = item.parentElement;
                if (parent) {
                    parent.querySelectorAll('.faq-item').forEach(function(i) {
                        i.classList.remove('open');
                        var innerAns = i.querySelector('.faq-item__a');
                        if (innerAns) innerAns.style.maxHeight = null;
                    });
                }

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

    /* ─── Home V2 Scrollspy ─── */
    function initHomeV2Scrollspy() {
        if (!document.body.classList.contains('home-v2')) return;

        var sectionIds = ['beranda','tentang','layanan','dokter','testimoni','faq','kontak'];
        var sections = sectionIds.map(function(id){ return document.getElementById(id); }).filter(Boolean);
        var navLinks = document.getElementById('navLinks');
        var links = navLinks ? navLinks.querySelectorAll('a[href^="#"]') : [];

        if (sections.length && links.length) {
            window.addEventListener('scroll', function(){
                var pos = window.scrollY + 140;
                sections.forEach(function(sec){
                    if (pos >= sec.offsetTop && pos < sec.offsetTop + sec.offsetHeight) {
                        links.forEach(function(l){ l.classList.remove('active'); });
                        var match = navLinks.querySelector('a[href="#' + sec.id + '"]');
                        if (match) match.classList.add('active');
                    }
                });
            });
        }
    }

})();