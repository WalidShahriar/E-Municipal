document.addEventListener('DOMContentLoaded', function () {
    const mqDesktop = window.matchMedia('(min-width: 1200px)');

    // Dropdown toggle for desktop
    function initDesktopDropdowns() {
        const items = document.querySelectorAll('#nav_2 .nav-item > p');
        items.forEach(p => {
            p.addEventListener('click', (e) => {
                // only active on desktop
                if (!mqDesktop.matches) return;

                const li = p.parentElement;
                const alreadyOpen = li.classList.contains('open');

                // close other open
                document.querySelectorAll('#nav_2 .nav-item.open').forEach(o => {
                    if (o !== li) o.classList.remove('open');
                });

                if (alreadyOpen) {
                    li.classList.remove('open');
                    p.setAttribute('aria-expanded', 'false');
                } else {
                    li.classList.add('open');
                    p.setAttribute('aria-expanded', 'true');
                }
            });
        });

        // close when clicking outside
        document.addEventListener('click', (evt) => {
            if (!mqDesktop.matches) return;
            const nav = document.getElementById('nav_2');
            if (!nav) return;
            if (!nav.contains(evt.target)) {
                document.querySelectorAll('#nav_2 .nav-item.open').forEach(o => o.classList.remove('open'));
            }
        });
    }

    initDesktopDropdowns();

    // mobile sidebar behavior
    const hamburger = document.getElementById('hamburger_btn');
    const sidebar = document.getElementById('mobile_sidebar');
    const overlay = document.getElementById('mobile_sidebar_overlay');
    const mobileClose = document.getElementById('mobile_close');

    function openSidebar() {
        if (!sidebar || !overlay) return;
        sidebar.classList.add('open');
        overlay.classList.add('open');
        sidebar.setAttribute('aria-hidden', 'false');
        hamburger.setAttribute('aria-expanded', 'true');
        // prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        if (!sidebar || !overlay) return;
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        sidebar.setAttribute('aria-hidden', 'true');
        if (hamburger) hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (hamburger) {
        hamburger.addEventListener('click', (e) => {
            openSidebar();
        });
    }

    if (mobileClose) {
        mobileClose.addEventListener('click', () => closeSidebar());
    }

    if (overlay) {
        overlay.addEventListener('click', () => closeSidebar());
    }

    // Mobile nav is now properly styled with vertical layout

    // Mobile submenu toggles inside the sidebar
    const mobileToggles = document.querySelectorAll('#mobile_nav .mobile-toggle');
    mobileToggles.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const li = btn.parentElement;
            const isOpen = li.classList.contains('open');
            if (isOpen) {
                li.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
            } else {
                li.classList.add('open');
                btn.setAttribute('aria-expanded', 'true');
                // ensure submenu is visible in viewport
                if (li.scrollIntoView) li.scrollIntoView({behavior: 'smooth', block: 'nearest'});
            }
        });
    });

    // Close sidebar on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeSidebar();
    });

    // On resize, ensure body scroll restored when moving from mobile to desktop
    window.addEventListener('resize', () => {
        if (window.matchMedia('(min-width: 1200px)').matches) {
            // close sidebar if open
            if (sidebar && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        }
    });
});
