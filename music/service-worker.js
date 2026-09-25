/**
 * 音乐解锁 — Workbox 生成的 service worker
 *
 * 本文件由构建流程生成，请勿手工编辑；
 * 如需变更缓存策略，请修改 Workbox 构建配置后重新构建。
 *
 * 位置说明：本文件随音乐解锁应用一起位于 /music/ 下，
 * 因此它的作用域是 /music/，precache 清单中的相对 URL 也都相对该目录解析。
 */
importScripts("https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js");

importScripts(
  "precache-manifest.3817039ba5d0f29a32d504e815a76b32.js"
);

workbox.core.setCacheNameDetails({ prefix: "unlock-music" });

workbox.core.skipWaiting();

/**
 * workbox.precaching.precacheAndRoute() 会高效地缓存并响应清单中的 URL 请求。
 */
self.__precacheManifest = [].concat(self.__precacheManifest || []);
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});
