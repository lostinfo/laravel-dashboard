<template>
  <el-row class="login-container">
    <div class="header">
      <div class="left">
        <img :src="logo" alt="" class="logo">
        <span class="title">{{ header_name }}</span>
      </div>
      <div class="right">
        <span>Don't have account? <span class="text-link">Create Account</span></span>
      </div>
    </div>
    <div class="content">
      <div class="login-wrapper">
        <el-form :model="loginForm" :rules="loginRules" ref="loginRef" label-positin="left" label-width="0px"
                 class="login-form">
          <div class="title">Welcome Back</div>
          <el-form-item prop="username">
            <el-input type="text" v-model="loginForm.username" auto-complete="off" prefix-icon="el-icon-user"
                      placeholder="用户名" :autofocus="true"></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <el-input type="password" v-model="loginForm.password"
                      @keyup.native.13="loginFormSubmit('loginRef')"
                      auto-complete="off" prefix-icon="el-icon-lock" placeholder="密码"></el-input>
          </el-form-item>
          <!--<el-checkbox v-model="loginForm.remember">Remember me</el-checkbox>-->
          <el-form-item>
            <el-button class="login-btn" style="width: 100%;"
                       @click.native.prevent="loginFormSubmit('loginRef')"
                       :loading="logining">
              登录
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
    <page-footer></page-footer>
  </el-row>
</template>

<script type="text/ecmascript-6">
export default {
  name: 'Login',
  data() {
    return {
      logining: false,
      loginForm: {
        username: '',
        password: ''
      },
      loginRules: {
        username: [
          {required: true, message: '请输入用户名', trigger: 'blur'},
        ],
        password: [
          {required: true, message: '请输入密码', trigger: 'blur'},
        ]
      },
      logo: window.config.logo,
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
.login-container {
  width: 1140px;
  height: 100vh;
  padding: 0;
  margin: 0 auto
}

.login-container .header {
  height: 80px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.login-container .header .left {
  display: flex;
  align-items: center;
}

.login-container .header .left .logo {
  height: 48px;
  width: auto;
  object-fit: cover;
  vertical-align: middle;
  margin-right: 16px;
}

.login-container .header .left .title {
  color: #333333;
  font-weight: 600;
  font-size: 33px;
  font-family: Avenir, Helvetica Neue, Arial, Helvetica, sans-serif;
}

.text-link {
  color: #409eff;
}

.login-container .content {
  height: calc(100% - 230px);
  padding: 32px;
}

.login-container .login-wrapper {
  width: 480px;
  margin: 150px auto 0 auto;
}

.login-container .login-wrapper .login-form {

}

.login-container .login-wrapper .login-form .title{
  text-align: center;
  padding: 30px 50px;
  font-size: 18px;
  font-weight: bold;
}
</style>
