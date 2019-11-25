import marked from 'marked'

// https://marked.js.org/#/USING_PRO.md#renderer

let renderer = new marked.Renderer()

renderer.image = (src, title) => {
  return '<img src="' + src + '" alt="" style="max-width: 100%;vertical-align: bottom;" />'
}

renderer.blockquote = (quote) => {
  return '<div style="padding: 8px 16px; background-color: #ecf8ff; border-radius: 4px; border-left: 5px solid #50bfff; margin: 20px 0;">' + quote + '</div>'
}

renderer.paragraph = (text) => {
  return '<p style="font-size: 14px; color: #333333; padding: 10px 0; line-height: 20px; margin: 0;">' + text + '</p>'
}

renderer.list = (body, ordered, start) => {
  return '<ul>' + body + '</ul>'
}

renderer.listitem = (text) => {
  return '<li style="font-size: 14px; color: #333333; margin: 16px 0; line-height: 20px;">' + text + '</li>'
}

renderer.table = (header, body) => {
  return '<table style="min-width: 100%;border: 1px solid #ddd;margin: 14px 0;box-sizing: border-box;border-collapse: collapse;"><thead style="border-collapse: collapse;box-sizing: border-box;">' + header + '</thead><tbody style="border-collapse: collapse;box-sizing: border-box;">' + body + '</tbody></table>'
}

renderer.tablerow = (content) => {
  return '<tr style="border-collapse: collapse;box-sizing: border-box;">' + content + '</tr>'
}

renderer.tablecell = (content, flags) => {
  let tag = 'td'
  let style = 'border: 1px solid #ddd; padding: 5px 14px 0; border-collapse: collapse; box-sizing: border-box;'
  if (flags.header) {
    tag = 'th'
    style += 'background: #f8f8f8;'
  }
  return '<' + tag + ' align="' + (flags.align ? flags.align : '') + '" style="' + style + '">' + content + '</' + tag + '>'
}

export default renderer