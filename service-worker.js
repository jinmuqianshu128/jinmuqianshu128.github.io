/**
 * 旧版 service worker 清理脚本（作用域：站点根目录）
 *
 * 背景：音乐解锁应用原先直接部署在站点根目录，会在访问者浏览器中注册一个
 * 作用域为 "/" 的 service worker，把首页、子页面等一并缓存下来。
 *
 * 该应用现已迁移到 /music/ 并自带独立的 service worker（作用域 /music/）。
 * 但根作用域的旧 worker 会继续向老访客提供过期缓存，并掩盖站点更新。
 *
 * 因此这里保留一个同路径的替身文件：老浏览器检查更新时会拿到本文件，
 * 由它清空所有缓存、注销自身并让页面重新加载一次，从而回到正常状态。
 * 全新访客不会注册到本文件（站点已无任何根作用域注册代码）。
 */
self.addEventListener('install', function () {
    self.skipWaiting();
});

self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys()
            .then(function (keys) {
                return Promise.all(keys.map(function (key) {
                    return caches.delete(key);
                }));
            })
            .then(function () {
                return self.registration.unregister();
            })
            .then(function () {
                return self.clients.matchAll({ type: 'window' });
            })
            .then(function (clients) {
                clients.forEach(function (client) {
                    client.navigate(client.url);
                });
            })
            .catch(function () {
                // 清理失败不影响页面本身的可用性
            })
    );
});
