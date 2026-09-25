---
title: 用 Hexo + Butterfly 把个人站改成博客
date: 2026-09-25 21:00:00
tags:
  - Hexo
  - Butterfly
  - 建站
categories:
  - 折腾记录
cover: /assets/img/wallpaper/壁纸2.png
top_img: /assets/img/wallpaper/壁纸2.png
description: 记录一次把纯手写 HTML 的个人站迁移到 Hexo 博客的完整过程，包括目录怎么分、资源路径为什么必须改、以及踩到的几个坑。
---

## 为什么换

原来的站点是纯手写的 HTML —— 一个首页、几个工具页、一个音乐解锁应用，全部靠在编辑器里直接敲标签。这样写的好处是零依赖，双击就能看；坏处也很明显：**发一篇文章要复制一份 HTML 改标题改正文**，日子久了根本不想写。

所以换成了 Hexo + [Butterfly](https://butterfly.js.org/)：正文写成 Markdown，构建时自动套上主题的模板，发文章只需要新建一个 `.md` 文件。

## 目录怎么分

Hexo 的约定很简单：`source/` 目录下的东西会被处理并输出到 `public/`。

```
source/
├── _posts/            博客文章（Markdown）
├── about/index.md     关于页
├── tools/             原有的工具页（原样保留的 HTML）
├── music/             音乐解锁应用
├── assets/            图片、样式、脚本、视频
└── 404.html …
```

## 踩到的第一个坑：资源路径冲突

Butterfly 主题自己就占用了根目录的 `/css/`、`/js/`、`/img/`。而原站点的样式表也正好放在 `/css/`。

两个来源的文件都会被输出到 `public/css/`，**同名就会互相覆盖**。

解决办法是把原有资源整体搬进 `/assets/`：

| 原来 | 现在 |
| --- | --- |
| `/css/base.css` | `/assets/css/base.css` |
| `/js/sakura.js` | `/assets/js/sakura.js` |
| `/img/avatar/vx.jpg` | `/assets/img/avatar/vx.jpg` |

然后全站做一次路径替换。这里有个细节：**音乐解锁应用的 Webpack 产物不能动** —— 它内部用的是相对路径（`css/`、`js/`、`fonts/`），一改就整个应用加载失败。所以替换时要把 `music/js`、`music/css`、`music/fonts` 三个目录排除掉。

## 第二个坑：纯 HTML 文件不要交给 Hexo 渲染

`tools/` 下是原封不动的 HTML 页面。Hexo 对没有匹配渲染器的文件会直接复制，但为了保险，还是在 `_config.yml` 里显式声明：

```yaml
skip_render:
  - 'tools/**'
  - 'music/**'
  - 'assets/**'
  - '404.html'
```

这样这些文件会被原样搬运，不会被当成模板解析。

## 第三个坑：service worker 的作用域

之前音乐解锁部署在根目录，会在访客浏览器里注册一个**作用域为 `/`** 的 service worker。现在应用搬到 `/music/`，那个旧 worker 依然会向老访客返回过期缓存。

处理办法是在根路径保留一个同名的清理脚本，让浏览器检查更新时拿到它，由它清空缓存并注销自己：

```javascript
self.addEventListener('activate', function () {
  event.waitUntil(
    caches.keys()
      .then(keys => Promise.all(keys.map(k => caches.delete(k))))
      .then(() => self.registration.unregister())
  )
})
```

## 现在的发布流程

写文章 → 提交 → GitHub Actions 自动构建并部署，本地不需要装任何环境。

```bash
# 本地预览（可选）
npm install
npx hexo server
```

---

这次迁移最花时间的其实不是 Hexo 本身，而是**把原有内容和主题的资源路径理清楚**。只要这一步做对了，后面写文章就是纯粹的享受了。
