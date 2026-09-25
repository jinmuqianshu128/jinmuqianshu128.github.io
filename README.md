# 铁树不开花

个人站点与博客，基于 [Hexo](https://hexo.io/) + [Butterfly](https://butterfly.js.org/) 构建，通过 GitHub Actions 自动部署到 GitHub Pages。

线上地址：<https://jinmuqianshu128.github.io/>

## 写一篇新文章

在 `source/_posts/` 下新建 `.md` 文件：

```markdown
---
title: 文章标题
date: 2026-09-25 21:00:00
tags:
  - 标签一
categories:
  - 分类一
cover: /assets/img/wallpaper/壁纸2.png
---

正文从这里开始。
```

提交并推送到 `main` 后，GitHub Actions 会自动构建并发布，不需要在本地做任何操作。

也可以直接用命令行创建（需要本地已 `npm install`）：

```bash
npx hexo new "文章标题"
```

## 本地预览

```bash
npm install
npx hexo server
# 打开 http://localhost:4000
```

只构建不启动服务：

```bash
npx hexo generate    # 产物在 public/
npx hexo clean       # 清掉缓存与 public/
```

## 目录说明

```
.
├── _config.yml               Hexo 主配置（站点标题、网址、插件等）
├── _config.butterfly.yml     Butterfly 主题配置（菜单、头像、封面等）
├── scaffolds/                新建文章的模板
├── themes/butterfly/         主题（随仓库提交，保证本地与云端构建一致）
└── source/
    ├── _posts/               博客文章
    ├── about/index.md        关于页
    ├── tools/                独立的工具页面（原样保留的 HTML）
    ├── music/                音乐解锁应用（Webpack 构建产物，勿手改其 css/js/fonts）
    ├── assets/               图片、样式、脚本、视频
    │   ├── css/  js/
    │   ├── img/  (avatar / wallpaper / screenshots / effects / icons / gallery)
    │   └── video/
    ├── 404.html
    └── robots.txt
```

## 两个容易踩的坑

**一、`/assets/` 不能挪回根目录。**
Butterfly 主题自己会占用 `/css/`、`/js/`、`/img/`，两边同名文件会互相覆盖，所以站点的自有资源一律放在 `/assets/` 下。

**二、`music/` 里的相对路径不能改。**
音乐解锁是 Webpack 打包的产物，运行时按相对路径找 `css/`、`js/`、`fonts/`、worker。移动文件或做全局路径替换都会让它加载失败。同理，它自带的 `service-worker.js` 作用域是 `/music/`。

根目录另有一个 `service-worker.js`（会从 `source/` 复制过去），用于清理早期版本注册在根作用域的旧缓存，不要删除。

## 部署

`.github/workflows/pages.yml` 会在推送到 `main` 时执行：

1. `npm ci` 安装依赖
2. `npx hexo generate` 生成静态站点到 `public/`
3. 上传并部署到 GitHub Pages

仓库的 Pages 设置需要是 **Source: GitHub Actions**（而不是从分支直接发布）。
