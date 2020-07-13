<template>
  <div class="wh100" v-if="admin">
    <div class="appbar" :class="isCollapse ? 'nav-collapse-appbar' : ''">
      <div class="center">
        <el-menu
          class="appbar-menu appbar-menu-center"
          mode="horizontal"
          background-color="#409eff"
          text-color="#FFF"
          active-text-color="#FFF"
          :default-active="menuGroupIndex + ''"
          @select="handleMenuGroupSelect"
        >
          <template v-for="(menuGroup, index) in menuGroups">
            <el-menu-item  :index="index + ''">{{menuGroup.group_name}}</el-menu-item>
          </template>
        </el-menu>
      </div>
      <div class="right">
        <el-menu
          class="appbar-menu appbar-menu-right"
          mode="horizontal"
          background-color="#409eff"
          text-color="#FFF"
          active-text-color="#FFF"
        >
          <el-menu-item index="1"><a href="/" target="_blank">首页</a></el-menu-item>
          <el-submenu index="2" :popper-append-to-body="true">
            <template slot="title"><span>{{admin.username}}</span></template>
            <el-menu-item @click.native="$router.replace({path:'/admin/me'})" index="2-1">个人中心</el-menu-item>
            <el-menu-item @click.native="logout" index="2-2">退出</el-menu-item>
          </el-submenu>
        </el-menu>
      </div>
    </div>
    <div class="paper" :class="isCollapse ? '' : 'open-appbar-collapse'">
      <div class="paper-herder">
        <img
          :src="logo"
          alt="logo">
        <span class="noselect">{{header_name}}</span>
      </div>
      <div class="paper-menu">
        <el-scrollbar style="position: absolute;top: 48px;bottom: 48px;width: 208px;">
          <Menu :collapse="isCollapse" :menus="menuGroups[menuGroupIndex].menus" v-if="menuGroups.length > 0"></Menu>
        </el-scrollbar>
      </div>
      <div class="paper-menu-btn">
        <div @click="changeNavStatus" class="icon-button">
          <i :class="isCollapse ? 'fa fa-indent' : 'fa fa-outdent'"></i>
        </div>
      </div>
    </div>
    <div class="example" :class="isCollapse ? 'nav-collapse-example' : ''">
      <el-scrollbar class="example-scrollbar">
        <el-row class="example-main wh100">
          <router-view v-on:newWidthChang="widthChange" v-on:changPathName="changPathName" :key="key"></router-view>
          <page-footer></page-footer>
        </el-row>
      </el-scrollbar>
    </div>
  </div>
</template>

<script type="text/ecmascript-6">
  import Menu from '../components/Menu.vue'
  // ***静态菜单***
  // import menuGroups from '../config/menu'
  export default {
    data() {
      return {
        menuGroups: [],
        menuGroupIndex: 0,
        navHidden: false,
        routerState: true,
        pathName: '主页',
        defaultActive: '/admin/index',
        isCollapse: false,
        logo: window.config.logo,
        header_name: window.config.header_name,
      }
    },
    components: {
      Menu
    },
    watch: {
      '$route'(to, from) {
        this.routeChange(to)
      }
    },
    computed: {
      key() {
        return this.$route.name !== undefined ? this.$route.name + +new Date() : this.$route + +new Date()
      },
      admin() {
        return this.$store.state.admin
      }
    },
    created: function () {
      let that = this
      that.defaultActive = that.$route.path
      that.routeChange(that.$route)

      let loadingInstance = that.$loading()
      // 验证是否登陆
      that.axios.post('/check').then(res => {
        loadingInstance.close()
        if (!res.status) {
          that.$store.commit('removeAuthorization')
          that.$router.push({path: '/admin/login'})
        } else {
          that.$store.commit('setAdmin', res.admin)
          // ***动态菜单***
          that.menuGroups = res.admin.menus
          let path_key = that.defaultActive.replace(/\d+/, '')
          for (let menu_group_index in that.menuGroups) {
            if (JSON.stringify(that.menuGroups[menu_group_index]).indexOf(path_key) >= 0) {
              that.menuGroupIndex = menu_group_index
              break
            }
          }
        }
      }).catch(error => {
        loadingInstance.close()
        that.$store.commit('removeAuthorization')
        that.$router.push({path: '/admin/login'})
      })
    },
    methods: {
      routeChange(route) {
        this.pathName = route.name
        document.title = window.config.header_name + '-' + this.pathName
      },
      logout: function () {
        let that = this
        this.$confirm("确认退出么？", '提示', {}).then(res => {
          that.axios.post('/logout').then(res => {
            that.$store.commit('removeAdmin')
            that.$store.commit('removeAuthorization')
            that.$message.success('退出成功')
            setTimeout(function () {
              that.$router.push({path: '/admin/login'})
            }, 2000)
          })
        }).catch(err => {
          console.log(err)
        })
      },
      changeNavStatus() {
        this.isCollapse = !this.isCollapse
      },
      widthChange(width) {
        // if (width <= 996) {
        //   this.navHidden = true
        // } else {
        //   this.navHidden = false
        // }
      },
      changPathName(pathName) {
        this.pathName = pathName
      },
      handleMenuGroupSelect(index) {
        this.menuGroupIndex = parseInt(index)
      }
    }
  }
</script>

<style>
  .appbar {
    height: 48px;
    position: absolute;
    left: 208px;
    right: 0;
    top: 0;
    width: auto;
    color: #fff;
    background-color: #409eff;
    z-index: 3;
    transition-duration: .45s;
    display: flex;
    justify-content: space-between;
    animation-timing-function: linear;
  }

  .appbar .left {
    display: flex;
    height: 100%;
  }

  .appbar .left .page-title {
    min-width: 10em;
    display: flex;
    height: 100%;
    font-size: 24px;
    line-height: 48px;
    flex: 1;
  }

  .appbar .center {
    flex: 1;
  }

  .appbar .right {
    display: flex;
    height: 100%;
  }

  .nav-collapse-appbar {
    left: 48px;
    transform: translateZ(0);
  }

  .appbar-menu-center > .el-menu-item.is-active {
    background-color: rgb(51, 126, 204) !important;
  }

  .appbar-menu-right {
    border-bottom: none !important;
  }

  .appbar-menu-right .el-submenu__title,
  .appbar-menu-right .el-menu-item {
    border-bottom: none !important;
  }

  .appbar-menu.el-menu--horizontal > .el-menu-item,
  .appbar-menu.el-menu--horizontal > .el-submenu .el-submenu__title {
    height: 48px;
    line-height: 48px;
  }

  .paper {
    position: absolute;
    width: 48px;
    top: 0;
    bottom: 0;
    left: 0;
    overflow: auto;
    box-shadow: 0 1px 6px rgba(0, 0, 0, .117647), 0 1px 4px rgba(0, 0, 0, .117647);
    z-index: 4;
    transition-duration: .45s;
    animation-timing-function: linear;
    background-color: #ffffff;
  }

  .open-appbar-collapse {
    width: 208px;
    transform: translateZ(0);
    visibility: visible;
  }

  .paper::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
    -webkit-appearance: none;
    opacity: 0 !important;
  }

  .paper-herder {
    height: 48px;
    display: flex;
    align-items: center;
    width: 100%;
    color: #fff;
    background-color: #409eff;
    z-index: 3;
    font-size: 16px;
    font-weight: bold;
    line-height: 48px;
    box-sizing: border-box;
    overflow: hidden;
    white-space: nowrap;
  }

  .paper-herder img {
    width: 48px;
    height: 48px;
    padding: 10px;
    box-sizing: border-box;
  }

  .paper-menu {
    padding: 8px 0;
    width: 100%;
  }

  .paper-menu-btn {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    border-top: 1px solid #f0f0f0;
  }

  .icon-button {
    width: 48px;
    height: 48px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    color: #303133;
    transition-duration: .3s;
    transition-timing-function: cubic-bezier(.23, 1, .32, 1);
    transform: translateZ(0);
  }

  .example {
    position: absolute;
    top: 48px;
    left: 208px;
    right: 0;
    bottom: 0;
    transition-duration: .45s;
  }

  .nav-collapse-example {
    left: 48px;
    transform: translateZ(0);
  }

  .example-scrollbar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }

  .example-main {
    padding: 20px;
  }

  .main-header {
    margin: -20px;
    background-color: #FFFFFF;
    padding: 20px;
  }

  .el-menu {
    border-right: none;
  }

  .el-scrollbar__wrap {
    overflow-x: auto;
  }

  .el-select-dropdown__wrap {
    overflow: scroll;
  }
</style>
