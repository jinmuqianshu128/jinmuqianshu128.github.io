/**
 * 构建脚本。
 *
 * 不使用 `hexo generate` 命令，因为随 npm 安装的 hexo-cli@4.3.2
 * 无法在 Node 24 下正确加载 Hexo 8 的子命令（只会打印 usage）。
 * 这里直接调用 Hexo 的编程接口，行为等价且更稳定。
 */
const Hexo = require('hexo');

(async function main() {
  const hexo = new Hexo(process.cwd(), { silent: false });
  try {
    await hexo.init();
    await hexo.call('clean');
    await hexo.call('generate');
    await hexo.exit();
    console.log('\n构建完成，产物目录: public/');
    process.exit(0);
  } catch (err) {
    console.error('\n构建失败:');
    console.error(err && err.stack ? err.stack : err);
    try { await hexo.exit(); } catch (e) { /* ignore */ }
    process.exit(1);
  }
})();
