/** Desktop WordPress dropdowns; parent links remain navigable. */
(function () {
    'use strict';
    var nav = document.querySelector('.desktop-navigation #nav');
    if (!nav) return;
    var desktop = window.matchMedia('(min-width: 900px)');
    var entries = [];

    function close(entry) {
        entry.item.classList.remove('is-open');
        entry.toggle.setAttribute('aria-expanded', 'false');
        entries.forEach(function (child) {
            if (child !== entry && entry.item.contains(child.item)) {
                child.item.classList.remove('is-open');
                child.toggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
    function open(entry) {
        if (!desktop.matches) return;
        entries.forEach(function (other) {
            if (other !== entry && other.item.parentElement === entry.item.parentElement) close(other);
        });
        entry.item.classList.add('is-open');
        entry.toggle.setAttribute('aria-expanded', 'true');
        // Keep right-edge dropdowns within the viewport.
        entry.submenu.classList.remove('opens-left');
        if (entry.submenu.getBoundingClientRect().right > document.documentElement.clientWidth - 8) {
            entry.submenu.classList.add('opens-left');
        }
    }
    nav.querySelectorAll('li').forEach(function (item, index) {
        var submenu = Array.from(item.children).find(function (child) { return child.matches('ul.sub-menu'); });
        var link = Array.from(item.children).find(function (child) { return child.matches('a'); });
        if (!submenu || !link) return;
        submenu.id = 'desktop-submenu-' + index;
        var toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'desktop-submenu-toggle';
        toggle.setAttribute('aria-label', 'Toggle submenu: ' + link.textContent.trim());
        toggle.setAttribute('aria-controls', submenu.id);
        toggle.setAttribute('aria-expanded', 'false');
        toggle.innerHTML = '<span class="fa fa-angle-down" aria-hidden="true"></span>';
        item.insertBefore(toggle, submenu);
        var entry = { item: item, submenu: submenu, toggle: toggle };
        entries.push(entry);
        item.addEventListener('pointerenter', function (event) {
            if (event.pointerType === 'mouse') open(entry);
        });
        item.addEventListener('pointerleave', function () {
            if (!item.contains(document.activeElement)) close(entry);
        });
        link.addEventListener('focus', function () { open(entry); });
        item.addEventListener('focusout', function (event) {
            if (!item.contains(event.relatedTarget)) close(entry);
        });
        toggle.addEventListener('click', function () {
            if (toggle.getAttribute('aria-expanded') === 'true') close(entry);
            else open(entry);
        });
        item.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                event.stopPropagation();
                close(entry);
                toggle.focus();
            } else if (event.key === 'ArrowDown' && (event.target === link || event.target === toggle)) {
                event.preventDefault();
                open(entry);
                var firstLink = submenu.querySelector('a');
                if (firstLink) firstLink.focus();
            }
        });
    });
    document.addEventListener('click', function (event) {
        if (!nav.contains(event.target)) entries.forEach(close);
    });
    desktop.addEventListener('change', function () { entries.forEach(close); });
    nav.classList.add('dropdowns-ready');
}());
