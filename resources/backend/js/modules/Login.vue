<template>
  <el-row type="flex" class="row-bg" justify="center">
    <el-col :span="8" :xs="{span:20}">
      <el-form :model="loginForm" :roules="loginRules" ref="loginRef" label-positin="left" label-width="0px" class="" style="margin-top: 300px;">
        <h3 class="title">{{header_name}}</h3>
        <el-form-item prop="username">
          <el-input type="text" v-model="loginForm.username" auto-complete="off" placeholder="username" :autofocus="true"></el-input>
        </el-form-item>
        <el-form-item prop="password">
          <el-input type="password" v-model="loginForm.password" @keyup.native.13="loginFormSubmit('loginRef')" auto-complete="off" placeholder="password"></el-input>
        </el-form-item>
        <!--<el-checkbox v-model="loginForm.remember">Remember me</el-checkbox>-->
        <el-form-item>
          <el-button type="primary" style="width: 100%;" @click.native.prevent="loginFormSubmit('loginRef')"
                     :loading="logining">
            登录
          </el-button>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>
</template>

<script type="text/ecmascript-6">
  export default {
    username: 'Login',
    data() {
      return {
        logining: false,
        loginForm: {
          username: '',
          password: ''
        },
        loginRules: {
          username: [
            {required: true, type: 'string', message: "请输入用户名", trigger: "blur"}
          ],
          password: [
            {required: true, type: 'string', message: "请输入密码", trigger: "blur"}
          ]
        },
        header_name: window.config.header_name,
      }
    },
    methods: {
      loginFormSubmit(ref) {
        let that = this
        that.$refs[ref].validate((valid) => {
          console.log(valid)
          if (!valid) {
            console.log("submit error")
            return false
          }
          that.logining = true
          let loginParams = new URLSearchParams()
          loginParams.append('username', that.loginForm.username)
          loginParams.append('password', that.loginForm.password)
          that.axios.post('/login', loginParams).then(res => {
            that.$store.commit('setAdmin', res.admin)
            that.$store.commit('setAuthorization', res.authorization)
            that.$message.success('登录成功')
            setTimeout(function () {
              that.$router.push({path: '/admin/index'})
            })
            that.logining = false
          }).catch(err => {
            that.logining = false
          })
        })
      }
    }
  }
</script>

<style scoped>
  .title {
    text-align: center;
    margin: 15px 0;
    color: #409EFF;
  }
</style>