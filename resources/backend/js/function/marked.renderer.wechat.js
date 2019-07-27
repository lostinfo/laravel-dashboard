import marked from 'marked'

// https://marked.js.org/#/USING_PRO.md#renderer

let renderer = new marked.Renderer()

renderer.image = (src, title) => {
  return '<img src="' + src + '" alt="" style="max-width: 100%;vertical-align: bottom;" />'
}

renderer.paragraph = (text) => {
  return '<p style="font-size: 14px; color: #666666; padding: 10px 15px; line-height: 1.6em;">' + text + '</p>'
}

renderer.list = (body, ordered, start) => {
  return '<ul>' + body + '</ul>'
}

renderer.listitem = (text) => {
  return '<li style="font-size: 14px; color: #666666; margin: 1.2em 0; line-height: 1.6em;">' + text + '</li>'
}

export default renderer