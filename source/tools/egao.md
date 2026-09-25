---
title: 好看的！！！
date: 2026-09-25 12:00:00
top_img: /assets/img/wallpaper/wallpaper-2.webp
description: 一段小视频。
comments: false
---

<div style="text-align:center;">

<video id="player" controls autoplay muted loop playsinline
       src="/assets/video/video.mp4"
       style="width:100%;max-width:900px;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.2);"></video>

<p style="color:#888;font-size:.9em;margin-top:12px;">点击画面可切换全屏</p>

</div>

<script>
(function () {
    'use strict';
    var video = document.getElementById('player');
    if (!video) return;

    function requestFullscreen(el) {
        var fn = el.requestFullscreen || el.webkitRequestFullscreen ||
            el.mozRequestFullScreen || el.msRequestFullscreen;
        if (fn) fn.call(el);
    }

    // 带声播放与全屏都需要用户手势，因此在点击时触发
    video.addEventListener('click', function () {
        video.muted = false;
        if (!document.fullscreenElement && !document.webkitFullscreenElement) {
            requestFullscreen(video);
        }
    });
})();
</script>
