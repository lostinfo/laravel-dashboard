<template>
  <div>
    <textarea id="editor"></textarea>
  </div>
</template>

<script>
  import {default as SimpleMDE} from 'simplemde/dist/simplemde.min'
  import marked from 'marked'
  import axios from 'axios'

  let hljs = require('../../../vendor/js/highlight.min')
  marked.setOptions({
    highlight: (code) => {
      return hljs.highlightAuto(code).value
    },
  })
  import Renderer from '../function/marked.renderer.wechat'

  export default {
    name: "Edit",
    props: {
      markdown: {
        type: String,
        required: true
      },
      uploadUrl: {
        type: String,
        default() {
          return '/upload'
        }
      },
      wrapperClassName: {
        type: String,
        default() {
          return 'post-wrapper'
        }
      },
      wrapperStyles: {
        type: String,
        default() {
          return ''
        }
      }
    },
    data() {
      return {
        simplemde: null,
      }
    },
    mounted() {
      let that = this
      that.simplemde = new SimpleMDE({
        element: document.getElementById("editor"),
        autodownloadfontawesome: false,
        forceSync: true,
        initialValue: "",
        insertTexts: {
          image: ["![](https://", ")"],
          link: ["[", "](https://)"],
        },
        toolbar: [
          "bold", "italic", "strikethrough", "heading", "|",
          "quote", "unordered-list", "ordered-list", "|",
          // "link", "image", "table", "|",
          "image", "table", "|",
          "preview", "side-by-side", "fullscreen",
          {
            name: "upload_image",
            action: (editor) => {
              let _input_id = 'simplemde_upload_input_id_Nd8s'
              let _history = document.getElementById(_input_id)
              if (_history) editor.options.element.parentNode.removeChild(_history)
              let _input_element = document.createElement('input')
              _input_element.setAttribute('type', 'file')
              _input_element.setAttribute('accept', 'image/*')
              _input_element.setAttribute('id', _input_id)
              _input_element.setAttribute('style', 'display: none;')
              editor.options.element.parentNode.appendChild(_input_element)

              let _input = document.getElementById(_input_id)

              _input.addEventListener('change', () => {
                let file = _input.files[0]
                let formData = new FormData()
                formData.append('file', file)
                that.contentAddImage(formData, editor)
                editor.options.element.parentNode.removeChild(_input)
              })
              _input.click()
            },
            className: "fa fa-picture-o",
            title: "Upload Image",
          },
          {
            name: "135editor styles",
            action: (editor) => {
              let style_id = window.prompt("请输入135editor样式ID", "")
              that.get135Section(style_id).then(res => {
                editor.codemirror.replaceSelection(res)
              }).catch(err => {
                console.log(err)
              })
            },
            className: "fa fa-135",
            title: "135editor styles",
          },
        ],
        previewRender(plainText, preview) {
          return '<div class="' + that.wrapperClassName + '" style="' + that.wrapperStyles + '">' + marked(plainText, {renderer: Renderer}) + '</div>'
        },
      })
      // 阻止浏览器默认打开拖拽文件
      window.addEventListener("drop", function (e) {
        e = e || event
        if (e.target.className == "CodeMirror-scroll") {  // check wich element is our target
          e.preventDefault()
        }
      }, false)
      // 拖拽上传
      that.simplemde.codemirror.on('drop', function (editor, e) {
        if (!(e.dataTransfer && e.dataTransfer.files)) {
          that.$message.error('该浏览器不支持操作')
          return
        }
        let dataList = e.dataTransfer.files
        for (let i = 0; i < dataList.length; i++) {
          if (dataList[i].type.indexOf('image') === -1) {
            that.$message.error('仅支持Image上传')
            continue
          }
          let formData = new FormData()
          formData.append('file', dataList[i])
          that.contentAddImage(formData, that.simplemde)
        }
      })
      // 粘贴上传
      that.simplemde.codemirror.on('paste', function (editor, e) {
        if (!(e.clipboardData && e.clipboardData.items)) {
          that.$message.error('该浏览器不支持操作')
          return
        }
        let dataList = e.clipboardData.items
        for (let i = 0; i < dataList.length; i++) {
          if (dataList[i].kind === 'string') {
            dataList[i].getAsString(function (str) {
//                                console.log(str)
            })
          } else if (dataList[i].kind === 'file') {
            let file = dataList[i].getAsFile()
            let formData = new FormData()
            formData.append('file', file)
            that.contentAddImage(formData, that.simplemde)
          }
        }
      })
      that.$nextTick(() => {
        if (that.markdown !== '') that.setSimplemdeValue(that.markdown)
      })
    },
    methods: {
      contentAddImage(formData, editor) {
        let that = this
        that.axios.post(that.uploadUrl, formData).then(res => {
          // that.simplemde.value(that.simplemde.value() + "![](" + res.absolute_url + ")"
          editor.codemirror.replaceSelection("![](" + res.absolute_url + ")")
        }).catch(error => {
        })
      },
      get135Section(id) {
        let that = this
        return new Promise((resolve, reject) => {
          let axiosNew = axios.create({
            baseURL: 'https://www.135editor.com/',
            headers: {
              "Content-Type": "text/html; charset=UTF-8",
            }
          });
          axiosNew.get('/editor_styles/' + id + '.html', {
            headers: {
              // ":authority": "www.135editor.com",
              // ":method": "GET",
              // ":path": "/editor_styles/" + id + ".html",
              // ":scheme": "https",
              // "sec-fetch-mode": "navigate",
              // "sec-fetch-site": "same-origin",
              // "sec-fetch-user": "?1",
              // "upgrade-insecure-requests": "1",
              // "responseType": "document",
            }
          }).then(res => {
            let section = res.data.match(/\<section(.|\r|\n)*\>(.|\r|\n)*\<\/section\>/g)
            if (section.length < 1) {
              that.$message.error("获取样式内容失败")
              reject()
            } else {
              let sectionStr = section[0]
              let img_matchs = sectionStr.matchAll(/src="([-A-Za-z0-9+&@#/%?=~_|!:,.;\s]+)"\sdata-src="([-A-Za-z0-9+&@#/%?=~_|!:,.;\s]+)"/g)
              for (let img_match of img_matchs) {
                let tempStr = '==TEMPSTR=='
                let img_str = img_match[0]
                sectionStr = sectionStr.replace(img_str, tempStr)
                img_str = img_str.replace(img_match[1], img_match[2])
                sectionStr = sectionStr.replace(tempStr, img_str)
              }
              that.replaceHtmlSource(id, sectionStr).then(res => {
                resolve(res)
              }).catch(err => {
                resolve(sectionStr)
              })
            }
          }).catch(err => {
            reject(err)
          })
        })
      },
      replaceHtmlSource(id, html) {
        let that = this
        return new Promise((resolve, reject) => {
          // img、video、audit src
          // style background-image: url(url)
          // style background: url(url)
          let url_matchs = html.matchAll(/src="([-A-Za-z0-9+&@#/%?=~_|!:,.;\s]+)"|url\(([-A-Za-z0-9+&@#/%?=~_|!:,.;\s]+)\)/g)
          let sources = []
          for (let url_match of url_matchs) {
            if (url_match[1] !== undefined && sources.indexOf(url_match[1]) < 0) {
              sources.push(url_match[1])
            }
            if (url_match[2] !== undefined && sources.indexOf(url_match[2]) < 0) {
              sources.push(url_match[2])
            }
          }
          if (sources.length > 0) {
            that.axios.post('/files/135editor/'+id, {sources: sources}).then(res => {
              for (let item of res) {
                html = html.replace(item.from, item.to)
              }
              resolve(html)
            }).catch(err => {
              resolve(html)
            })
          } else {
            resolve(html)
          }
        })
      },
      setSimplemdeValue(value) {
        let that = this
        that.simplemde.value(value)
      },
      getSimplemdeMarkdown() {
        return this.simplemde.value()
      },
      getSimplemdeHtml() {
        let that = this
        return '<div class="' + that.wrapperClassName + '">' + marked(that.getSimplemdeMarkdown(), {renderer: Renderer}) + '</div>'
      },
    },
  }
</script>

<style scoped>
  @import "../../sass/simplemde.min.css";
  @import "../../../vendor/sass/highlight.min.css";
  @import "../../../vendor/sass/post.scss";
</style>

<style>
  .fa.fa-135:before{
    content: "135";
  }
</style>