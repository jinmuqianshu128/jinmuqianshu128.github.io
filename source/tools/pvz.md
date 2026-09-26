---
title: PVZ汉化版助手 - 植物大战僵尸汉化版辅助工具
date: 2026-09-26 12:00:00
top_img: /assets/img/wallpaper/wallpaper-dl.webp
description: 适用于《植物大战僵尸》汉化版的游戏辅助工具，支持阳光修改、植物无冷却、随意种植、子弹效果等，使用 C++ / DirectX 11 / Dear ImGui 编写，开源免费。
---

适用于《植物大战僵尸》汉化版的游戏辅助工具，使用 **C++ / DirectX 11 / Dear ImGui** 编写。

> 仅供技术学习与交流使用，请勿用于任何商业用途或联机环境。

## 功能

| 分类 | 功能 |
| --- | --- |
| 状态显示 | 当前阳光、僵尸数量、运行时长 |
| 阳光相关 | 输入阳光（最大 99999）、阳光 9999、初始阳光、阳光不减、阳光喷泉 |
| 种植相关 | 植物无冷却、随意种植、竖排种植、紫卡无限制、传送带无延迟 |
| 子弹效果 | 初始子弹 / 子弹加速 / 子弹叠加（三选一） |
| 单项无冷却 | 大嘴花、土豆雷、加农炮、磁力菇 |
| 其他 | 自动拾取、后台运行、一键通关、清除墓碑、脆皮僵尸、浓雾透视、陶罐透视、锁定黄油 |
| 界面 | 菜单主题：黑色 / 白色 / 紫色 |

## 使用方法

1. 先启动《植物大战僵尸》汉化版，进入游戏
2. 解压后运行 `PVZ ImGui.exe`
3. 菜单会出现在游戏画面上，鼠标点击即可开关

| 按键 | 作用 |
| --- | --- |
| `Ins` | 显示 / 隐藏菜单 |
| `End` | 安全退出（关闭所有修改并退出程序） |

## 下载

<div style="text-align:center;margin:28px 0;">
  <a href="https://github.com/jinmuqianshu128/PVZ-ImGui/releases/download/v1.0.0/PVZ-HanhuaHelper-v1.0.0.zip"
     style="display:inline-block;padding:14px 40px;background:#49b1f5;color:#fff;border-radius:8px;text-decoration:none;font-size:17px;box-shadow:0 4px 12px rgba(73,177,245,.35);">
    下载 v1.0.0
  </a>
</div>

<p style="text-align:center;color:#888;font-size:.9em;">
源码已在 GitHub 开源：<a href="https://github.com/jinmuqianshu128/PVZ-ImGui">jinmuqianshu128/PVZ-ImGui</a>
</p>

版本记录见 [更新说明](/tools/update.html)。

## 软件截图

![PVZ汉化版助手 主界面](/assets/img/screenshots/pvz-menu.webp)

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:12px;margin:16px 0;">
  <img src="/assets/img/screenshots/pvz-features.webp" alt="实用功能" style="width:100%;border-radius:8px;">
  <img src="/assets/img/screenshots/pvz-bullets.webp" alt="子弹效果" style="width:100%;border-radius:8px;">
  <img src="/assets/img/screenshots/pvz-cooldown.webp" alt="植物冷却" style="width:100%;border-radius:8px;">
  <img src="/assets/img/screenshots/pvz-others.webp" alt="其他功能" style="width:100%;border-radius:8px;">
</div>

## 注意事项

- 同时开启的功能过多时，游戏有概率崩溃，建议按需开启。
- 「子弹叠加」与「加农炮无冷却」互斥，不能同时启用。
- 「阳光喷泉」仅对白天关卡有效。
