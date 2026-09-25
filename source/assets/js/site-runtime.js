/*!
 * 站点运行时间
 *
 * 完全不依赖任何外部服务，纯本地计算，因此不存在超时或请求失败的问题。
 *
 * 用法：页面上任意元素加上 data-site-runtime 属性即可，
 * 脚本会每秒把「已运行 X 天 X 时 X 分 X 秒」写进去。
 *
 * 修改建站日期：改下面的 START。
 */
(function () {
    'use strict';

    // 建站时间（东八区）。想改起点只改这一行。
    var START = new Date('2025-01-01T00:00:00+08:00');

    var PAD = function (n) { return n < 10 ? '0' + n : String(n); };

    function elapsed() {
        var diff = Date.now() - START.getTime();
        if (diff < 0) diff = 0;

        var sec = Math.floor(diff / 1000);
        var days = Math.floor(sec / 86400);
        var hours = Math.floor((sec % 86400) / 3600);
        var mins = Math.floor((sec % 3600) / 60);
        var secs = sec % 60;

        return days + ' 天 ' + PAD(hours) + ' 时 ' + PAD(mins) + ' 分 ' + PAD(secs) + ' 秒';
    }

    function render() {
        var text = elapsed();
        var nodes = document.querySelectorAll('[data-site-runtime]');
        for (var i = 0; i < nodes.length; i++) {
            nodes[i].textContent = text;
        }
    }

    function boot() {
        render();
        // 秒钟走动；页面隐藏时停掉，省电
        var timer = setInterval(render, 1000);
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                clearInterval(timer);
            } else {
                render();
                timer = setInterval(render, 1000);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
