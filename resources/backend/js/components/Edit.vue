<template>
  <div>
    <textarea id="editor"></textarea>
  </div>
</template>

<script>
import {default as SimpleMDE} from 'simplemde/dist/simplemde.min'
import marked from 'marked'

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
      autoDownloadFontAwesome: false,
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
      ],
      previewRender(plainText, preview) {
        return marked(plainText, {renderer: Renderer})
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
        editor.codemirror.replaceSelection("![](" + res.absolute_url + ")")
      }).catch(error => {
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
      return marked(that.getSimplemdeMarkdown(), {renderer: Renderer})
    },
  },
}
</script>

<style scoped>

</style>
