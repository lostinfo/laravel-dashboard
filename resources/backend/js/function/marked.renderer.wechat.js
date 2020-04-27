import marked from 'marked'
import hljs from 'highlight.js/lib/index'

const {escape} = require('./marked.helper')

// https://marked.js.org/#/USING_PRO.md#renderer

let renderer = new marked.Renderer()

renderer.image = (src, title) => {
  return '<img src="' + src + '" alt="" style="max-width: 100%;vertical-align: bottom;margin: 0;" />'
}

renderer.blockquote = (quote) => {
  return '<div style="padding: 8px 16px; background-color: #ecf8ff; border-radius: 4px; border-left: 5px solid #50bfff; margin-bottom: 20px;">' + quote + '</div>'
}

renderer.paragraph = (text) => {
  return '<p style="font-size: 14px; color: #333333; line-height: 20px;padding-bottom: 20px; margin: 0;">' + text + '</p>'
}

renderer.list = (body, ordered, start) => {
  return '<ul>' + body + '</ul>'
}

renderer.listitem = (text) => {
  return '<li style="font-size: 14px; line-height: 20px;color: #333333; margin: 16px 10px; ">' + text + '</li>'
}

renderer.table = (header, body) => {
  return '<table style="min-width: 100%;border: 1px solid #ddd;box-sizing: border-box;border-collapse: collapse;margin: 14px 10px;">' +
    '<thead style="border-collapse: collapse;box-sizing: border-box;">' + header + '</thead>' +
    '<tbody style="border-collapse: collapse;box-sizing: border-box;">' + body + '</tbody>' +
    '</table>'
}

renderer.tablerow = (content) => {
  return '<tr style="border-collapse: collapse;box-sizing: border-box;">' + content + '</tr>'
}

renderer.tablecell = (content, flags) => {
  let tag = 'td'
  let style = 'border: 1px solid #ddd; padding: 5px 14px; border-collapse: collapse; box-sizing: border-box;'
  if (flags.header) {
    tag = 'th'
    style += 'background: #f8f8f8;'
  }
  return '<' + tag + ' align="' + (flags.align ? flags.align : '') + '" style="' + style + '">' + content + '</' + tag + '>'
}

renderer.heading = (text, level, raw, slugger) => {
  return '<h' + level + ' id="' + slugger.slug(raw) + '" style="padding: 10px;">' + text + '</h' + level + '>'
}

renderer.code = (code, infostring, escaped) => {
  const lang = (infostring || '').match(/\S*/)[0]

  const out = (lang ? hljs.highlight(lang, code).value : hljs.highlightAuto(code).value)

  if (out != null && out !== code) {
    escaped = true
    code = out
  }

  let prestyle = "font-size: 14px; line-height: 20px; color: #ffffff; background-color: #002b36; padding: 14px 16px; margin: 10px 0;border-radius: 6px; overflow: auto;"

  if (!lang) {
    return '<pre style="' + prestyle + '"><code>'
      + (escaped ? code : escape(code, true))
      + '</code></pre>'
  }

  return '<pre style="' + prestyle + '"><code class="'
    + 'language-'
    + escape(lang, true)
    + '">'
    + (escaped ? code : escape(code, true))
    + '</code></pre>\n'
}

renderer.codespan = (text) => {
  return '<code>' + text + '</code>'
}

export default renderer
