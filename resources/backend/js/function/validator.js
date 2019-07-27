let checkMobile = (rule, value, callback) => {
  let mobile_reg = /^1[\d]{10}$/
  if (!mobile_reg.test(value)) {
    callback(new Error("手机号格式错误"))
  }
  callback()
}

let checkPasswordWhereEdit = (rule, value, callback) => {
  if (value.length > 0 && value.length < 6) {
    callback(new Error("长度不能小于6位"))
  }
  callback()
}

export {
  checkMobile,
  checkPasswordWhereEdit
}