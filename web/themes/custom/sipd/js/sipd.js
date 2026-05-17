/**
 * @file
 * sikd behaviors.
 */
(function (Drupal) {

  'use strict';

  Drupal.behaviors.sipd = {
    attach (context, settings) {

      // Main navigation interactions (homepage menu block).
      document.querySelectorAll('.top-header-section', context).forEach(function (headerEl) {
        if (headerEl.dataset.sipdMenuInit === '1') {
          return;
        }
        headerEl.dataset.sipdMenuInit = '1';

        const hamburger = headerEl.querySelector('#hamburger');
        const mobileMenu = headerEl.querySelector('#mobile-menu');

        if (hamburger && mobileMenu) {
          hamburger.addEventListener('click', function () {
            const isOpen = hamburger.classList.toggle('open');
            mobileMenu.classList.toggle('open', isOpen);
            hamburger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
          });
        }

        function setSubmenuState(menuItem, shouldOpen) {
          menuItem.classList.toggle('is-open', shouldOpen);
          const btn = menuItem.querySelector('.submenu-toggle');
          const dropdown = menuItem.querySelector('.megamenu-dropdown');
          if (btn) {
            btn.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
          }
          if (dropdown) {
            dropdown.setAttribute('aria-hidden', shouldOpen ? 'false' : 'true');
          }
        }

        function closeSiblingSubmenus(currentItem) {
          headerEl.querySelectorAll('.has-megamenu.is-open').forEach(function (item) {
            if (item !== currentItem) {
              setSubmenuState(item, false);
            }
          });
        }

        // First click opens submenu; second click follows parent link.
        headerEl.querySelectorAll('.has-megamenu > a').forEach(function (parentLink) {
          parentLink.addEventListener('click', function (event) {
            const menuItem = parentLink.closest('.has-megamenu');
            if (!menuItem) {
              return;
            }

            if (!menuItem.classList.contains('is-open')) {
              event.preventDefault();
              closeSiblingSubmenus(menuItem);
              setSubmenuState(menuItem, true);
            }
          });

          parentLink.addEventListener('keydown', function (event) {
            if (event.key !== 'ArrowDown') {
              return;
            }
            const menuItem = parentLink.closest('.has-megamenu');
            if (!menuItem) {
              return;
            }
            event.preventDefault();
            closeSiblingSubmenus(menuItem);
            setSubmenuState(menuItem, true);
            const firstSubLink = menuItem.querySelector('.megamenu-dropdown a');
            if (firstSubLink) {
              firstSubLink.focus();
            }
          });
        });

        headerEl.querySelectorAll('.submenu-toggle').forEach(function (toggleBtn) {
          const toggleSubmenu = function () {
            const menuItem = toggleBtn.closest('.has-megamenu');
            if (!menuItem) {
              return;
            }
            const shouldOpen = !menuItem.classList.contains('is-open');
            closeSiblingSubmenus(menuItem);
            setSubmenuState(menuItem, shouldOpen);
          };

          toggleBtn.addEventListener('click', function () {
            toggleSubmenu();
          });

          toggleBtn.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter' && event.key !== ' ') {
              return;
            }
            event.preventDefault();
            toggleSubmenu();
          });
        });

        // Click outside closes any opened submenu.
        document.addEventListener('click', function (event) {
          if (headerEl.contains(event.target)) {
            return;
          }
          headerEl.querySelectorAll('.has-megamenu.is-open').forEach(function (item) {
            setSubmenuState(item, false);
          });
        });

        // Escape closes opened submenu and returns focus to its toggle.
        headerEl.addEventListener('keydown', function (event) {
          if (event.key !== 'Escape') {
            return;
          }
          const opened = headerEl.querySelector('.has-megamenu.is-open');
          if (!opened) {
            return;
          }
          setSubmenuState(opened, false);
          const btn = opened.querySelector('.submenu-toggle');
          if (btn) {
            btn.focus();
          }
        });
      });

      // Office Tour slider
      if (typeof Splide !== 'undefined') {
        document.querySelectorAll('.office-tour-section.splide', context).forEach(function (el) {
          if (!el.classList.contains('splide-initialized')) {
            new Splide(el).mount();
            el.classList.add('splide-initialized');
          }
        });
        // Testimonials slider
        document.querySelectorAll('.testimonials-section.splide', context).forEach(function (el) {
          if (!el.classList.contains('splide-initialized')) {
            let options = {};
            if (el.dataset.splide) {
              try {
                options = JSON.parse(el.dataset.splide.replace(/'/g, '"'));
              } catch (e) {}
            }
            new Splide(el, options).mount();
            el.classList.add('splide-initialized');
          }
        });
        // Generic SDC slider component
        document.querySelectorAll('.sdc-slider.splide', context).forEach(function (el) {
          if (!el.classList.contains('splide-initialized')) {
            let options = {};
            if (el.dataset.splide) {
              try {
                options = JSON.parse(el.dataset.splide);
              } catch (e) {}
            }
            new Splide(el, options).mount();
            el.classList.add('splide-initialized');
          }
        });
      } else {
        console.warn('Splide library not loaded');
      }

    }
  };

} (Drupal));
