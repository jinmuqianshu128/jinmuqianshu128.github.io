/**
 * flink
 */

'use strict'

const { url_for, escapeHTML } = require('hexo-util')
const urlFor = url_for.bind(hexo)

const flinkFn = (args, content) => {
  const data = hexo.render.renderSync({ text: content, engine: 'yaml' })
  let result = ''

  data.forEach(item => {
    const className = item.class_name ? `<div class="flink-name">${escapeHTML(item.class_name)}</div>` : ''
    const classDesc = item.class_desc ? `<div class="flink-desc">${escapeHTML(item.class_desc)}</div>` : ''

    const listResult = item.link_list.map(link => `
      <div class="flink-list-item">
        <a href="${escapeHTML(link.link)}" title="${escapeHTML(link.name)}" target="_blank">
          <div class="flink-item-icon">
            <img class="no-lightbox" src="${escapeHTML(link.avatar)}" onerror='this.onerror=null;this.src="${urlFor(hexo.theme.config.error_img.flink)}"' alt="${escapeHTML(link.name)}" />
          </div>
          <div class="flink-item-name">${escapeHTML(link.name)}</div>
          <div class="flink-item-desc" title="${escapeHTML(link.descr)}">${escapeHTML(link.descr)}</div>
        </a>
      </div>`).join('')

    result += `${className}${classDesc}<div class="flink-list">${listResult}</div>`
  })

  return `<div class="flink">${result}</div>`
}

hexo.extend.tag.register('flink', flinkFn, { ends: true })
