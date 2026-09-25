---
title: 音乐解锁
date: 2026-09-25 12:00:00
top_img: /assets/img/wallpaper/壁纸1.png
description: 在任何设备上解锁已购的加密音乐 —— 在浏览器中移除已购音乐的加密保护，支持在线/离线转换成 MP3。
---

<!--
  页面由 Butterfly 主题渲染，导航栏与页脚来自主题本身；
  下面只是把解锁应用挂载进来。应用资源（css/js/fonts）与本页同级，
  必须保持相对路径不变 —— Webpack 打包产物运行时按相对路径找 chunk 与 worker。
-->

<div id="loader-mask">
  <div id="loader"></div>
  <noscript>
    <h3 id="loader-js">请启用 JavaScript</h3>
  </noscript>
  <h3 id="loader-source">正在缓冲中，请勿离开！</h3>
  <div id="loader-tips-outdated" hidden>
    <h2>您可能在使用不受支持的<span style="color:#f00">过时</span>浏览器，这可能导致此应用无法正常工作。</h2>
    <h3>如果您使用双核浏览器，可以尝试切换到 <span style="color:#f00">「极速模式」</span> 解决此问题。</h3>
    <h3>或者，您可以尝试更换下方的几个浏览器之一。</h3>
  </div>
  <h3 id="loader-tips-timeout" hidden>音乐解锁采用了一些新特性！建议使用
    <a href="https://www.microsoft.com/zh-cn/edge" target="_blank" rel="noopener">Microsoft Edge Chromium</a>
    <a href="https://www.google.cn/chrome/" target="_blank" rel="noopener">Google Chrome</a>
    <a href="https://www.firefox.com.cn/" target="_blank" rel="noopener">Mozilla Firefox</a>
    | <a href="https://git.unlock-music.dev/um/web/wiki/使用提示" target="_blank" rel="noopener">使用提示</a>
  </h3>
</div>

<div id="app"></div>

<link href="css/chunk-vendors.094863c6.css" rel="stylesheet">
<link href="css/app.5388e39c.css" rel="stylesheet">
<link href="css/shell.css" rel="stylesheet">

<script src="loader.js"></script>
<script type="module" src="js/chunk-vendors.5ae508bd.js"></script>
<script type="module" src="js/app.7ee51236.js"></script>
<script>
  // 让不支持 module 的浏览器跳过下面两个 module 脚本（Vue CLI 生成的标准回退探测）
  !function () {
    var e = document, t = e.createElement("script");
    if (!("noModule" in t) && "onbeforeload" in t) {
      var n = !1;
      e.addEventListener("beforeload", function (e) {
        if (e.target === t) n = !0;
        else if (!e.target.hasAttribute("nomodule") || !n) return;
        e.preventDefault()
      }, !0),
        t.type = "module",
        t.src = ".",
        e.head.appendChild(t),
        t.remove()
    }
  }();
</script>
<script src="js/chunk-vendors-legacy.0c483a87.js" nomodule></script>
<script src="js/app-legacy.bce907eb.js" nomodule></script>
