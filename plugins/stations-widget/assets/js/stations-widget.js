(function () {
    'use strict';
    function init(root) {
        if (root.fglswReady || !window.Swiper) return;
        root.fglswReady = true;
        var route = root.querySelector('.fglsw-route');
        var stage = root.querySelector('.fglsw-stage');
        var triggers = Array.from(root.querySelectorAll('.fglsw-trigger'));
        var jumps = Array.from(root.querySelectorAll('.fglsw-jumps button'));
        var active = null;
        function close(restore) {
            if (!active) return;
            var previous = active;
            active = null;
            previous.popup.hidden = true;
            previous.button.setAttribute('aria-expanded', 'false');
            if (restore) previous.button.focus({ preventScroll: true });
        }
        function position() {
            if (!active) return;
            var bounds = stage.getBoundingClientRect();
            var button = active.button.getBoundingClientRect();
            var popup = active.popup;
            var center = button.left + button.width / 2 - bounds.left;
            var left = Math.max(8, Math.min(center - popup.offsetWidth + 32, bounds.width - popup.offsetWidth - 8));
            popup.style.left = left + 'px';
            popup.style.top = Math.max(0, button.bottom - bounds.top - 44 - popup.offsetHeight) + 'px';
            var tail = popup.querySelector('.fglsw-popover-tail');
            tail.style.right = Math.max(0, Math.min(popup.offsetWidth - tail.offsetWidth, popup.offsetWidth - (center - left) - 32)) + 'px';
        }
        function currentPhase(swiper) {
            var slide = swiper.slides[swiper.activeIndex];
            var phase = slide ? slide.dataset.phase : '';
            jumps.forEach(function (button) {
                if (button.dataset.phase === phase) button.setAttribute('aria-current', 'true');
                else button.removeAttribute('aria-current');
            });
        }
        var swiper = new window.Swiper(route, {
            slidesPerView: 'auto', slidesPerGroup: 1, spaceBetween: 0,
            speed: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 300,
            watchOverflow: true,
            navigation: { prevEl: root.querySelector('.fglsw-prev'), nextEl: root.querySelector('.fglsw-next') },
            scrollbar: { el: root.querySelector('.fglsw-scrollbar'), draggable: true, hide: false },
            a11y: { enabled: true, containerMessage: 'Stations along the route', itemRoleDescriptionMessage: 'station' },
            on: {
                init: currentPhase,
                slideChange: function (instance) { close(false); currentPhase(instance); },
                sliderFirstMove: function () { close(false); },
                resize: function () { close(false); }
            }
        });
        root.fglswSwiper = swiper;
        triggers.forEach(function (button, index) {
            button.addEventListener('click', function () {
                if (!swiper.allowClick) return;
                if (active && active.button === button) { close(false); return; }
                close(false);
                var popup = document.getElementById(button.getAttribute('aria-controls'));
                if (!popup) return;
                active = { button: button, popup: popup };
                button.setAttribute('aria-expanded', 'true');
                popup.hidden = false;
                position();
                popup.querySelector('.fglsw-close').focus({ preventScroll: true });
            });
            button.addEventListener('keydown', function (event) {
                var next;
                if (event.key === 'ArrowRight') next = Math.min(triggers.length - 1, index + 1);
                if (event.key === 'ArrowLeft') next = Math.max(0, index - 1);
                if (event.key === 'Home') next = 0;
                if (event.key === 'End') next = triggers.length - 1;
                if (next !== undefined) { event.preventDefault(); swiper.slideTo(next, 0); triggers[next].focus({ preventScroll: true }); }
            });
            button.addEventListener('focus', function () {
                var bounds = route.getBoundingClientRect();
                var item = button.getBoundingClientRect();
                if (item.left < bounds.left || item.right > bounds.right) swiper.slideTo(index, 0);
            });
        });
        jumps.forEach(function (button) {
            button.addEventListener('click', function () {
                close(false);
                swiper.slideTo(Number(button.dataset.index));
                jumps.forEach(function (other) { other.removeAttribute('aria-current'); });
                button.setAttribute('aria-current', 'true');
            });
        });
        root.querySelectorAll('.fglsw-close').forEach(function (button) { button.addEventListener('click', function () { close(true); }); });
        root.addEventListener('keydown', function (event) { if (event.key === 'Escape' && active) { event.preventDefault(); close(true); } });
        document.addEventListener('click', function (event) { if (active && !active.popup.contains(event.target) && !active.button.contains(event.target)) close(false); });
        root.addEventListener('focusout', function (event) { if (active && !root.contains(event.relatedTarget)) close(false); });
    }
    function start() { document.querySelectorAll('.fglsw').forEach(init); }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start);
    else start();
}());
