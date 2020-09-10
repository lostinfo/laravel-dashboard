import ElementUI from 'element-ui'
import Vue from 'vue'

Vue.use(ElementUI)

Vue.prototype.$errors = (message, errors) => {
  let html = '<div class="message-errors">' +
    '<p>' + message + '</p>' +
    '<ul>'
  for (let column_key in errors) {
    for (let error_msg of errors[column_key]) {
      html += '<li>' + error_msg +'</li>'
    }
  }
  html += '</ul></div>'
  Vue.prototype.$message({
    type: 'error',
    dangerouslyUseHTMLString: true,
    message: html,
    duration: 10000,
    showClose: true
  })
}
