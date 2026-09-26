---
title: PVZ汉化版助手 v1.0.0 发布
date: 2026-09-26 12:00:00
tags:
  - PVZ汉化版助手
  - 开源
  - 更新日志
categories:
  - 软件更新
cover: /assets/img/wallpaper/wallpaper-dl.webp
top_img: /assets/img/wallpaper/wallpaper-dl.webp
description: PVZ汉化版助手 v1.0.0 发布，并已以 MIT 协议开源全部源码。这是一个适用于《植物大战僵尸》汉化版的游戏辅助工具，使用 C++ / DirectX 11 / Dear ImGui 编写。
---

## 这是什么

**PVZ汉化版助手**是一个适用于《植物大战僵尸》汉化版的游戏辅助工具，使用 C++ / DirectX 11 / Dear ImGui 编写。

它通过读取游戏进程内存来实时获取状态，并在游戏画面上叠加一个可交互的菜单。

## v1.0.0 包含的功能

| 分类 | 功能 |
| --- | --- |
| 状态显示 | 当前阳光、僵尸数量、运行时长 |
| 阳光相关 | 输入阳光、阳光 9999、初始阳光、阳光不减、阳光喷泉 |
| 种植相关 | 植物无冷却、随意种植、竖排种植、紫卡无限制、传送带无延迟 |
| 子弹效果 | 初始子弹 / 子弹加速 / 子弹叠加 |
| 单项无冷却 | 大嘴花、土豆雷、加农炮、磁力菇 |
| 其他 | 自动拾取、后台运行、一键通关、清除墓碑、脆皮僵尸、浓雾透视、陶罐透视、锁定黄油 |
| 界面 | 黑色 / 白色 / 紫色三套主题 |

## 快捷键

| 按键 | 作用 |
| --- | --- |
| `Ins` | 显示 / 隐藏菜单 |
| `End` | 安全退出 |

## 源码已开源

全部源码已经在 GitHub 上以 **MIT 协议**开源，包括：

- `main.cpp` —— 程序入口：等待游戏启动、创建 D3D11 设备与覆盖窗口
- `Memory/` —— 内存读写封装
- `Menu/` —— 菜单界面与功能逻辑
- `Patch/` —— 内存补丁
- `ReadProcess/` —— 进程查找与句柄获取
- `ImGui/` —— Dear ImGui 1.92.9（第三方库，同样为 MIT 协议）

仓库地址：<https://github.com/jinmuqianshu128/PVZ-ImGui>

编译产物（`Debug/`、`Release/`、`.obj`）没有放进版本控制，需要用 Visual Studio 自行编译。

## 下载

<div style="text-align:center;margin:28px 0;">
  <a href="https://github.com/jinmuqianshu128/PVZ-ImGui/releases/download/v1.0.0/PVZ-HanhuaHelper-v1.0.0.zip"
     style="display:inline-block;padding:14px 32px;background:#49b1f5;color:#fff;border-radius:8px;text-decoration:none;font-size:17px;">
    下载 v1.0.0
  </a>
</div>

## 注意事项

- 同时开启的功能过多时，游戏有概率崩溃，建议按需开启。
- 「子弹叠加」与「加农炮无冷却」互斥，不能同时启用。
- 「阳光喷泉」仅对白天关卡有效。

---

**免责声明**：本工具仅供技术学习与交流使用，请勿用于任何商业用途或联机环境。
