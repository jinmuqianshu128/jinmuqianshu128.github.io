/* ==========================================================================
   sakura.js — 全站落樱粒子背景效果
   来源：原 js/script.js。该文件存在以下问题，此处一并修复：
     1. stopp() 的函数体缺少闭合花括号 —— `if (child) {...}` 掉到了函数外面，
        顶层引用未声明的 child 会立刻抛 ReferenceError，脚本从该行起中断。
     2. 递归动画使用已被废弃的 arguments.callee（严格模式下直接报错）。
     3. 用 window.onresize = ... 赋值，会覆盖页面其它脚本的同名处理器。
     4. 图片以 58 KB base64 硬编码在 JS 中，无法被浏览器单独缓存；
        现抽为 img/effects/petal.png。
     5. 未考虑系统「减弱动效」偏好，眩晕用户无法关闭效果。
   ========================================================================== */
(function () {
    'use strict';

    var PETAL_SRC = '/img/effects/petal.png';
    var PETAL_COUNT = 50;
    var PETAL_BASE_SIZE = 40;

    // 尊重系统的「减弱动效」设置
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    var petalImage = new Image();
    var rafId = null;
    var canvas = null;

    function Sakura(x, y, s, r, fn) {
        this.x = x;
        this.y = y;
        this.s = s;
        this.r = r;
        this.fn = fn;
    }

    Sakura.prototype.draw = function (cxt) {
        cxt.save();
        cxt.translate(this.x, this.y);
        cxt.rotate(this.r);
        cxt.drawImage(petalImage, 0, 0, PETAL_BASE_SIZE * this.s, PETAL_BASE_SIZE * this.s);
        cxt.restore();
    };

    Sakura.prototype.update = function () {
        this.x = this.fn.x(this.x, this.y);
        this.y = this.fn.y(this.y, this.y);
        this.r = this.fn.r(this.r);

        if (this.x > window.innerWidth || this.x < 0 ||
            this.y > window.innerHeight || this.y < 0) {
            this.r = getRandom('fnr');
            if (Math.random() > 0.4) {
                this.x = getRandom('x');
                this.y = 0;
                this.s = getRandom('s');
                this.r = getRandom('r');
            } else {
                this.x = window.innerWidth;
                this.y = getRandom('y');
                this.s = getRandom('s');
                this.r = getRandom('r');
            }
        }
    };

    function SakuraList() {
        this.list = [];
    }

    SakuraList.prototype.push = function (sakura) {
        this.list.push(sakura);
    };

    SakuraList.prototype.update = function () {
        for (var i = 0, len = this.list.length; i < len; i++) {
            this.list[i].update();
        }
    };

    SakuraList.prototype.draw = function (cxt) {
        for (var i = 0, len = this.list.length; i < len; i++) {
            this.list[i].draw(cxt);
        }
    };

    function getRandom(option) {
        var ret;
        var random;

        switch (option) {
            case 'x':
                ret = Math.random() * window.innerWidth;
                break;
            case 'y':
                ret = Math.random() * window.innerHeight;
                break;
            case 's':
                ret = Math.random();
                break;
            case 'r':
                ret = Math.random() * 6;
                break;
            case 'fnx':
                random = -0.5 + Math.random();
                ret = function (x) {
                    return x + 0.5 * random - 1.7;
                };
                break;
            case 'fny':
                random = 1.5 + Math.random() * 0.7;
                ret = function (x, y) {
                    return y + random;
                };
                break;
            case 'fnr':
                random = Math.random() * 0.03;
                ret = function (r) {
                    return r + random;
                };
                break;
            default:
                ret = 0;
        }
        return ret;
    }

    function loop(sakuraList, cxt) {
        cxt.clearRect(0, 0, canvas.width, canvas.height);
        sakuraList.update();
        sakuraList.draw(cxt);
        rafId = window.requestAnimationFrame(function () {
            loop(sakuraList, cxt);
        });
    }

    function resizeCanvas() {
        if (!canvas) {
            return;
        }
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    function stop() {
        if (rafId !== null) {
            window.cancelAnimationFrame(rafId);
            rafId = null;
        }
        if (canvas && canvas.parentNode) {
            canvas.parentNode.removeChild(canvas);
        }
        canvas = null;
        window.removeEventListener('resize', resizeCanvas);
        window.removeEventListener('pagehide', stop);
    }

    function start() {
        if (canvas) {
            return; // 避免重复挂载（脚本被二次加载时）
        }

        canvas = document.createElement('canvas');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        canvas.id = 'canvas_sakura';
        canvas.setAttribute('style', 'position:fixed;left:0;top:0;pointer-events:none;z-index:0;');
        document.body.appendChild(canvas);

        var cxt = canvas.getContext('2d');
        var sakuraList = new SakuraList();

        for (var i = 0; i < PETAL_COUNT; i++) {
            sakuraList.push(new Sakura(
                getRandom('x'),
                getRandom('y'),
                getRandom('s'),
                getRandom('r'),
                {
                    x: getRandom('fnx'),
                    y: getRandom('fny'),
                    r: getRandom('fnr')
                }
            ));
        }

        loop(sakuraList, cxt);

        window.addEventListener('resize', resizeCanvas);
        // 离开页面时清理，避免标签页切走后动画继续空转
        window.addEventListener('pagehide', stop);
    }

    petalImage.onload = start;
    petalImage.onerror = function () {
        // 图片加载失败时静默降级，不影响页面其它功能
    };
    petalImage.src = PETAL_SRC;
})();
