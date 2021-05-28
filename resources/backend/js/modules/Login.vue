<template>
  <el-row class="login-container">
    <div class="login-header">
      <div class="header">
        <div class="welcome">Hello,Welcome Back</div>
        <div class="app-name">
          <img :src="logo" alt="" class="logo">
          <span class="title">{{ header_name }}</span>
        </div>
      </div>
    </div>
    <div class="login-content">
      <div class="login-wrapper">
        <el-form :model="loginForm" :rules="loginRules" ref="loginRef" label-positin="left" label-width="0px"
                 class="login-form">
          <el-form-item prop="username">
            <el-input type="text" v-model="loginForm.username" auto-complete="off" prefix-icon="el-icon-user"
                      placeholder="用户名" :autofocus="true"></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <el-input type="password" v-model="loginForm.password"
                      @keyup.native.13="loginFormSubmit('loginRef')"
                      auto-complete="off" prefix-icon="el-icon-lock" placeholder="密码"></el-input>
          </el-form-item>
          <el-form-item class="submit-item">
            <el-button type="primary" style="width: 100%;"
                       @click.native.prevent="loginFormSubmit('loginRef')"
                       :loading="logining">
              登录
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
    <page-footer class="login-footer"></page-footer>
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

<style lang="scss" scoped>
@media screen and (min-width: 992px) {
  .login-header {
    font-size: 66px;
    line-height: 66px;
  }
}

@media screen and (max-width: 992px) {
  .login-header {
    font-size: 40px;
    line-height: 66px;
  }
}

.login-container {
  width: 100vw;
  height: 100vh;
  padding: 0;
  margin: 0 auto;

  .login-header {
    width: 100%;
    height: 0;
    padding-bottom: calc(max(100% * 0.33229167, 500px));
    background-image: url("/images/login-bg.png");
    background-size: cover;
    position: relative;
    background-position: center;

    .header {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: calc(100% - 155px);
      padding: 15px;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: space-around;
      align-items: center;
      text-align: center;

      .welcome {
        flex: 3;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: NotoSansHans;
        font-weight: 400;
        color: #FFFFFF;
        text-shadow: -2px 1px 0px rgba(0, 0, 0, 0.32);
      }

      .app-name {
        flex: 2;
        display: flex;
        justify-content: center;
        align-items: center;

        .logo {
          width: 66px;
          height: 66px;
          object-fit: contain;
          vertical-align: middle;
        }

        .title {
          padding-left: 20px;
          font-family: NotoSansHans;
          font-weight: 400;
          color: #FFFFFF;
          text-shadow: -2px 1px 0px rgba(0, 0, 0, 0.32);
        }
      }
    }
  }

  .login-content {
    position: relative;
    z-index: 10;
    display: flex;
    justify-content: center;
    margin-top: -154px;
    padding: 0 15px;

    .login-wrapper {
      width: 340px;
      background: rgba(255, 255, 255, 0.3);
      box-shadow: 3px 3px 7px 0px rgba(53, 72, 99, 0.15);
      border-radius: 10px;
      padding: 40px 50px;
    }
  }

  .login-footer {
    position: fixed;
    bottom: 0;
    width: 100%;
  }
}
</style>
