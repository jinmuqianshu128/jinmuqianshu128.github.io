/* ==========================================================================
   nav.js — 全站导航栏当前页高亮
   原先每个页面各自内联一段几乎相同的脚本，且它硬依赖 id="home-link"：
   任何页面漏写该 id 就会抛 TypeError。此处改为按 URL 自动匹配，无需 id。
   ========================================================================== */
(function () {
    'use strict';

    /** 把 /a/index.html、/a/、/a 统一成 /a，便于比较 */
    function normalize(pathname) {
        var p = String(pathname || '').replace(/index\.html$/, '');
        if (p.length > 1) {
            p = p.replace(/\/+$/, '');
        }
        return p || '/';
    }

    function highlightActiveLink() {
        var current = normalize(window.location.pathname);
        var links = document.querySelectorAll('.nav-link');

        Array.prototype.forEach.call(links, function (link) {
            var target;
            try {
                target = normalize(new URL(link.href, window.location.href).pathname);
            } catch (err) {
                return; // 无法解析的链接直接跳过，不影响其它链接
            }

            var isActive = target === current;
            link.classList.toggle('active', isActive);
            if (isActive) {
                link.setAttribute('aria-current', 'page');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', highlightActiveLink);
    } else {
        highlightActiveLink();
    }
})();
