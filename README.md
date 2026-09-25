# 铁树不开花 · 个人站点

TS 工具箱（TS Tools）与「音乐解锁」的静态站点，部署于 GitHub Pages。

## 目录结构

```
/
├── index.html                  首页（站点入口）
├── index1.html                 历史地址过渡页 → 重定向到 /
├── index2.html                 历史地址过渡页 → 重定向到 /music/
├── 404.html                    自定义 404 页
├── robots.txt / sitemap.xml    搜索引擎配置
├── rss.xml                     站点订阅源
├── service-worker.js           旧版根作用域 SW 的清理脚本（详见文件内注释）
├── favicon.ico                 站点图标
├── BingSiteAuth.xml            必应站长验证（须位于根目录）
├── baidu_verify_*.html         百度站长验证（须位于根目录）
│
├── css/                        全站样式
│   ├── base.css                公共样式：变量、重置、导航栏、页脚
│   ├── home.css                首页
│   ├── myself.css              站长简介
│   ├── tstools.css             TS 工具箱介绍
│   ├── update.css              更新说明与下载
│   ├── download.css            Steam / Epic 下载引导页（共用）
│   └── egao.css                全屏视频页
│
├── js/                         全站脚本
│   ├── nav.js                  导航栏当前页高亮
│   ├── sakura.js               落樱粒子背景
│   ├── vendor/                 第三方库
│   └── legacy/                 历史遗留脚本（当前无页面引用）
│
├── img/                        图片资源
│   ├── avatar/                 头像
│   ├── wallpaper/              背景壁纸
│   ├── screenshots/            软件截图
│   ├── effects/                特效素材（花瓣）
│   ├── icons/                  PWA / 桌面图标
│   └── gallery/                图库杂项
│
├── video/                      视频素材
│
├── html/                       子页面
│   ├── tstools.html            TS 工具箱介绍
│   ├── update.html             更新说明与下载
│   ├── myself.html             站长简介
│   ├── steam.html              Steam 下载引导
│   ├── epic.html               Epic 下载引导
│   └── egao.html               全屏视频彩蛋
│
├── music/                      「音乐解锁」应用（自包含）
│   ├── index.html
│   ├── manifest.json           PWA 清单
│   ├── loader.js / service-worker.js / precache-manifest.*.js
│   ├── css/                    应用样式（Webpack 产物 + shell.css）
│   ├── js/                     应用脚本（Webpack 产物）
│   └── fonts/                  图标字体
│
└── seo/                        SEO 工具产物归档
    ├── map/                    站点地图生成器输出
    └── archive/                历史 sitemap / rss 版本
```

## 维护须知

- **`music/` 内部的 `css/`、`js/`、`fonts/` 与原 Webpack 构建产物之间是相对路径关系，
  必须与 `music/index.html` 保持同级**，否则应用会加载失败。
  该目录由构建流程产出，非必要请勿手工改动。
- 根目录的 `BingSiteAuth.xml`、`baidu_verify_*.html` 是搜索引擎的所有权验证文件，
  必须保留在根目录，不可移动。
- `html/` 目录名沿用站点历史地址（已被搜索引擎收录），如需改名请自行配置重定向。
- 页面导航栏的样式统一由 `css/base.css` 提供，脚本行为由 `js/nav.js` 提供，
  新增页面直接引用这两者即可，无需重复粘贴样式。

## 本地预览

站点使用以 `/` 开头的绝对路径，直接双击打开 HTML 文件会导致样式丢失，
请在项目根目录启动一个静态服务器后访问：

```bash
npx serve .
# 或
python -m http.server 8080
```
