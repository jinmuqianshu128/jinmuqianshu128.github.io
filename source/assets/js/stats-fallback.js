/*!
 * 站点统计兜底
 *
 * 本站的访客数、总浏览量由不蒜子（busuanzi.ibruce.info）提供。
 * 它需要额外发起一次跨域取数请求，若该请求被网络或拦截插件挡住，
 * 页面上的数字会永远停留在加载动画上。
 *
 * 这里做一次兜底：若一段时间后元素里仍只有加载图标，就显示 --，
 * 至少不会一直转圈。（能正常取到数字时本脚本不做任何事。）
 */
(function () {
    'use strict';

    var TARGETS = [
        'busuanzi_value_site_uv',
        'busuanzi_value_site_pv',
        'busuanzi_value_page_pv'
    ];
    var TIMEOUT = 6000;

    function stillSpinning(el) {
        if (!el) return false;
        // 主题在未取到值时放的是一个旋转图标
        if (el.querySelector && el.querySelector('.fa-spinner, .fa-spin')) return true;
        var text = (el.textContent || '').trim();
        return text === '' || text === '0';
    }

    function fallback() {
        var changed = false;
        TARGETS.forEach(function (id) {
            var el = document.getElementById(id);
            if (stillSpinning(el)) {
                el.textContent = '--';
                changed = true;
            }
        });
        return changed;
    }

    // 先等不蒜子把数值写进去；超时仍未写入则兜底
    setTimeout(fallback, TIMEOUT);
})();
