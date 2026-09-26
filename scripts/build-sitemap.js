/**
 * 生成完整、规范的 sitemap.xml —— 在 hexo generate 之后运行。
 *
 * 为什么要自己做：
 *   hexo-generator-sitemap 只收录 posts 与部分页面，/archives/ 归档页会漏掉；
 *   它输出的 URL 还带 index.html 后缀（/about/index.html），不是搜索引擎偏好的规范形式。
 *
 * 本脚本扫描 public/ 下所有 HTML，排除不该收录的页面，输出：
 *   - sitemap.xml  （带 lastmod / changefreq / priority）
 *   - sitemap.txt  （纯 URL 列表，部分站长工具直接吃这个）
 *
 * 已接入 .github/workflows/pages.yml，每次部署自动执行。
 * 本地用法：
 *   node scripts/build-sitemap.js
 *   node scripts/build-sitemap.js --check   （只报告，不写文件）
 */
const fs = require('fs');
const path = require('path');

const PUB = path.join(__dirname, '..', 'public');
const SITE = 'https://jinmuqianshu128.github.io';
const CHECK_ONLY = process.argv.includes('--check');

// 不该出现在 sitemap 里的页面
const EXCLUDE = [
  /^404\.html$/,
  /^index[12]\.html$/,            // 旧文件名过渡页（自带 noindex）
  /^baidu_verify_/,               // 站长验证文件
  /^BingSiteAuth\.xml$/,
  /^google[0-9a-f]+\.html$/,
  /^tools\/tstools\.html$/,       // 纯跳转页，没有独立内容
  /^tools\/egao\.html$/,          // robots.txt 里已 Disallow，sitemap 必须保持一致
  /^admin\//,
];

function walk(dir, out) {
  for (const name of fs.readdirSync(dir)) {
    const full = path.join(dir, name);
    if (fs.statSync(full).isDirectory()) walk(full, out);
    else if (name.endsWith('.html')) out.push(full);
  }
  return out;
}

// 页面自带 noindex 的一律不提交，否则等于让搜索引擎抓了又丢
function hasNoindex(file) {
  const s = fs.readFileSync(file, 'utf8').slice(0, 8000);
  const metas = s.match(/<meta[^>]*>/gi) || [];
  return metas.some((m) => /name=["']robots["']/i.test(m) && /noindex/i.test(m));
}

// /about/index.html -> /about/   ;  index.html -> /
function toUrl(rel) {
  let u = rel.replace(/\\/g, '/');
  if (u === 'index.html') u = '';
  else if (u.endsWith('/index.html')) u = u.slice(0, -'index.html'.length);
  return SITE + '/' + encodeURI(u);
}

function priorityOf(rel) {
  const r = rel.replace(/\\/g, '/');
  if (r === 'index.html') return '1.0';
  if (/^\d{4}\/\d{2}\/\d{2}\//.test(r)) return '0.8';   // 文章
  if (r === 'about/index.html') return '0.7';
  if (r.startsWith('tools/')) return '0.7';
  if (r === 'music/index.html') return '0.6';
  if (r.startsWith('tags/') || r.startsWith('categories/')) return '0.4';
  if (r.startsWith('archives/')) return '0.3';
  return '0.5';
}

function changefreqOf(rel) {
  const r = rel.replace(/\\/g, '/');
  if (r === 'index.html') return 'weekly';
  if (/^\d{4}\/\d{2}\/\d{2}\//.test(r)) return 'monthly';
  // 归档页会随新文章不断变化
  if (r.startsWith('archives/')) return 'weekly';
  return 'monthly';
}

const lastmodOf = (file) => fs.statSync(file).mtime.toISOString().slice(0, 10);

const files = walk(PUB, []);
const entries = [];
const skipped = [];

for (const full of files) {
  const rel = path.relative(PUB, full).replace(/\\/g, '/');
  if (EXCLUDE.some((re) => re.test(rel))) { skipped.push([rel, '规则排除']); continue; }
  if (hasNoindex(full)) { skipped.push([rel, 'noindex']); continue; }
  entries.push({
    url: toUrl(rel),
    lastmod: lastmodOf(full),
    changefreq: changefreqOf(rel),
    priority: priorityOf(rel),
    rel,
  });
}

// 首页排最前，其余按 priority 降序 + URL 字典序，输出稳定便于 diff
entries.sort((a, b) => {
  if (a.rel === 'index.html') return -1;
  if (b.rel === 'index.html') return 1;
  const p = parseFloat(b.priority) - parseFloat(a.priority);
  return p !== 0 ? p : a.url.localeCompare(b.url);
});

const xml = [
  '<?xml version="1.0" encoding="UTF-8"?>',
  '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
  ...entries.map((e) => [
    '  <url>',
    '    <loc>' + e.url + '</loc>',
    '    <lastmod>' + e.lastmod + '</lastmod>',
    '    <changefreq>' + e.changefreq + '</changefreq>',
    '    <priority>' + e.priority + '</priority>',
    '  </url>',
  ].join('\n')),
  '</urlset>',
  '',
].join('\n');

const txt = entries.map((e) => e.url).join('\n') + '\n';

console.log('[sitemap] 扫描 HTML:', files.length, '| 收录:', entries.length, '| 排除:', skipped.length);
skipped.forEach(([rel, why]) => console.log('   - ' + rel + '  (' + why + ')'));
entries.forEach((e) => console.log('   [' + e.priority + '] ' + e.url));

if (CHECK_ONLY) {
  console.log('[sitemap] --check 模式，未写入');
  process.exit(0);
}

fs.writeFileSync(path.join(PUB, 'sitemap.xml'), xml, 'utf8');
fs.writeFileSync(path.join(PUB, 'sitemap.txt'), txt, 'utf8');
console.log('[sitemap] 已写入 sitemap.xml (' + xml.length + ' 字节)，sitemap.txt ' + entries.length + ' 条');
