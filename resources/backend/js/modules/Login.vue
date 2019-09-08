<template>
  <div class="login-bg">
    <div class="login-wrapper">
      <el-form :model="loginForm" :rules="loginRules" ref="loginRef" label-positin="left" label-width="0px"
               class="login-form">
        <h3 class="title">{{header_name}}</h3>
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
  .login-bg {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/142996/slider-2.jpg);
    background-size: cover;
  }

  .login-wrapper {
    max-width: 360px;
    width: 100%;
    padding: 20px;
    background: linear-gradient(to bottom, rgb(46, 141, 197) 0%, rgba(0, 0, 0, 0.6) 100%);
    border-radius: 5px;
  }

  .login-form {
    width: 100%;
  }

  .title {
    text-align: center;
    margin: 10px 0 40px 0;
    color: #FFFFFF;
    font-size: 28px;
  }

  .login-btn {
    background-color: #607D8B;
    border-color: #607D8B;
    color: #FFFFFF;
  }

  .login-btn:hover {
    background-color: #607d8bc7;
    border-color: #607d8bc7;
  }
</style>
