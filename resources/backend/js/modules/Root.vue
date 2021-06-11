<template>
  <div class="app-wrapper" v-if="admin">
    <div class="appbar-container" :class="isCollapse ? 'nav-collapse-appbar' : ''">
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
            <el-menu-item :index="index + ''">{{ menuGroup.group_name }}</el-menu-item>
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
            <template slot="title"><span>{{ admin.username }}</span></template>
            <el-menu-item @click.native="$router.replace({path:'/admin/me'})" index="2-1">个人中心</el-menu-item>
            <el-menu-item @click.native="logout" index="2-2">退出</el-menu-item>
          </el-submenu>
        </el-menu>
      </div>
    </div>
    <div class="sidebar-contariner" :class="isCollapse ? '' : 'open-appbar-collapse'">
      <div class="sidebar-herder">
        <img
          :src="logo"
          alt="logo">
        <span class="noselect">{{ header_name }}</span>
      </div>
      <div class="sidebar-menu">
        <el-scrollbar style="position: absolute;top: 48px;bottom: 48px;width: 208px;">
          <Menu :collapse="isCollapse" :menus="menuGroups[menuGroupIndex].menus" v-if="menuGroups.length > 0"></Menu>
        </el-scrollbar>
      </div>
      <div class="sidebar-menu-btn">
        <div @click="changeNavStatus" class="icon-button">
          <i :class="isCollapse ? 'fa fa-indent' : 'fa fa-outdent'"></i>
        </div>
      </div>
    </div>
    <div class="main-container" :class="isCollapse ? 'nav-collapse-main-container' : ''">
      <el-scrollbar class="tags-view-container">
        <div class="tags-view-wrapper">
          <router-link
            v-for="tag in visitedViews"
            ref="tag"
            :key="tag.path"
            :class="isActive(tag)?'active':''"
            :to="{ path: tag.path, query: tag.query, fullPath: tag.fullPath }"
            tag="span"
            class="tags-view-item"
            @click.middle.native="!isAffix(tag)?closeSelectedTag(tag):''"
            @contextmenu.prevent.native="openTagsMenu(tag,$event)"
          >
            {{ tag.meta.title }}
            <span v-if="!isAffix(tag)" class="el-icon-close" @click.prevent.stop="closeSelectedTag(tag)"></span>
          </router-link>
        </div>
        <ul v-show="show_tags_menu" :style="{left:tags_menu_left+'px',top:tags_menu_top+'px'}" class="tags-menu">
          <!--          <li @click="refreshSelectedTag(selectedTag)">Refresh</li>-->
          <li v-if="!isAffix(selectedTag)" @click="closeSelectedTag(selectedTag)">Close</li>
          <li @click="closeOthersTags">Close Others</li>
          <li @click="closeAllTags(selectedTag)">Close All</li>
        </ul>
      </el-scrollbar>
      <el-scrollbar class="main-container-scrollbar">
        <el-row class="dashboard-container">
          <transition name="fade-transform" mode="out-in">
            <keep-alive :include="cachedViews">
              <router-view v-on:newWidthChang="widthChange" v-on:changPathName="changPathName"
                           v-on:closeView="closeView" :key="key"></router-view>
            </keep-alive>
          </transition>
          <page-footer></page-footer>
        </el-row>
      </el-scrollbar>
    </div>
  </div>
</template>

<script type="text/ecmascript-6">
import Menu from '../components/Menu.vue'
import routes from "./routes"

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
      affixTags: [],
      show_tags_menu: false,
      tags_menu_left: 0,
      tags_menu_top: 0,
      selectedTag: {},
    }
  },
  components: {
    Menu
  },
  watch: {
    '$route'(to, from) {
      const {name} = this.$route
      if (name) {
        this.$store.dispatch('addView', this.$route)
      }
      const tags = this.$refs.tag
      if (tags) {
        this.$nextTick(() => {
          for (const tag of tags) {
            if (tag.to.path === this.$route.path) {
              // when query is different then update
              if (tag.to.fullPath !== this.$route.fullPath) {
                this.$store.dispatch('updateVisitedView', this.$route)
              }
              break
            }
          }
        })
      }
      this.routeChange(to)
    },
    show_tags_menu(value) {
      if (value) {
        document.body.addEventListener('click', this.closeTagsMenu)
      } else {
        document.body.removeEventListener('click', this.closeTagsMenu)
      }
    }
  },
  computed: {
    key() {
      return this.$route.path
    },
    admin() {
      return this.$store.state.admin
    },
    cachedViews() {
      return this.$store.state.cachedViews
    },
    visitedViews() {
      return this.$store.state.visitedViews
    },
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
  mounted() {
    this.initTags()
    this.addTags()
  },
  methods: {
    isActive(route) {
      return route.path === this.$route.path
    },
    isAffix(tag) {
      return tag.meta && tag.meta.affix
    },
    filterAffixTags(routes, basePath = '/') {
      let tags = []
      routes.forEach(route => {
        if (route.meta && route.meta.affix) {
          const tagPath = route.path
          tags.push({
            fullPath: tagPath,
            path: tagPath,
            name: route.name,
            meta: {...route.meta}
          })
        }
        if (route.children) {
          const tempTags = this.filterAffixTags(route.children, route.path)
          if (tempTags.length >= 1) {
            tags = [...tags, ...tempTags]
          }
        }
      })
      return tags
    },
    initTags() {
      const affixTags = this.affixTags = this.filterAffixTags(routes)
      for (const tag of affixTags) {
        // Must have tag name
        if (tag.name) {
          this.$store.dispatch('addVisitedView', tag)
        }
      }
    },
    addTags() {
      const {name} = this.$route
      if (name) {
        this.$store.dispatch('addView', this.$route)
      }
      return false
    },
    closeSelectedTag(view) {
      this.$store.dispatch('delView', view).then(({visitedViews}) => {
        if (this.isActive(view)) {
          this.toLastView(visitedViews, view)
        }
      })
    },
    closeOthersTags() {
      this.$router.push(this.selectedTag)
      this.$store.dispatch('delOthersViews', this.selectedTag).then(() => {
        this.moveToCurrentTag()
      })
    },
    closeAllTags(view) {
      this.$store.dispatch('delAllViews').then(({visitedViews}) => {
        if (this.affixTags.some(tag => tag.path === view.path)) {
          return
        }
        this.toLastView(visitedViews, view)
      })
    },
    moveToCurrentTag() {
      const tags = this.$refs.tag
      this.$nextTick(() => {
        for (const tag of tags) {
          if (tag.to.path === this.$route.path) {
            // when query is different then update
            if (tag.to.fullPath !== this.$route.fullPath) {
              this.$store.dispatch('updateVisitedView', this.$route)
            }
            break
          }
        }
      })
    },
    // todo redirect view
    // refreshSelectedTag(view) {
    //   this.$store.dispatch('delCachedView', view).then(() => {
    //     const {fullPath} = view
    //     this.$nextTick(() => {
    //       this.$router.replace({
    //         path: fullPath
    //       })
    //     })
    //   })
    // },
    toLastView(visitedViews, view) {
      const latestView = visitedViews.slice(-1)[0]
      if (latestView) {
        this.$router.push(latestView.fullPath)
      } else {
        this.$router.push('/admin/index')
      }
    },
    openTagsMenu(tag, e) {
      console.log(e)
      this.tags_menu_left = e.clientX
      this.tags_menu_top = e.clientY
      this.show_tags_menu = true
      this.selectedTag = tag
    },
    closeTagsMenu() {
      this.show_tags_menu = false
    },
    routeChange(route) {
      this.pathName = (route.meta && route.meta.title) ? route.meta.title : ''
      document.title = this.pathName + ' - ' + window.config.header_name
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
    closeView(to) {
      this.$store.dispatch('delView', this.$route).then(({visitedViews}) => {
        if (to) {
          this.$router.push(to)
        } else {
          this.toLastView(visitedViews, this.$route)
        }
      })
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
.appbar-container {
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

.appbar-container .left {
  display: flex;
  height: 100%;
}

.appbar-container .left .page-title {
  min-width: 10em;
  display: flex;
  height: 100%;
  font-size: 24px;
  line-height: 48px;
  flex: 1;
}

.appbar-container .center {
  flex: 1;
}

.appbar-container .right {
  display: flex;
  height: 100%;
}

.nav-collapse-appbar {
  left: 48px;
  /*transform: translateZ(0);*/
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

.sidebar-contariner {
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
  /*transform: translateZ(0);*/
  visibility: visible;
}

.sidebar-contariner::-webkit-scrollbar {
  display: none !important;
  width: 0 !important;
  height: 0 !important;
  -webkit-appearance: none;
  opacity: 0 !important;
}

.sidebar-herder {
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

.sidebar-herder img {
  width: 48px;
  height: 48px;
  padding: 10px;
  box-sizing: border-box;
}

.sidebar-menu {
  padding: 8px 0;
  width: 100%;
}

.sidebar-menu-btn {
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

.main-container {
  position: absolute;
  top: 48px;
  left: 208px;
  right: 0;
  bottom: 0;
  transition-duration: .45s;
}

.nav-collapse-main-container {
  left: 48px;
  /*transform: translateZ(0);*/
}

.main-container-scrollbar {
  position: absolute;
  top: 35px;
  left: 0;
  right: 0;
  bottom: 0;
}

.dashboard-container {
  padding: 15px;
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

.tags-view-container {
  height: 34px;
  width: 100%;
  background-color: #FFFFFF;
  box-shadow: 0 1px 6px rgba(0, 0, 0, .117647), 0 1px 4px rgba(0, 0, 0, .117647);
}

.tags-view-container .el-scrollbar__wrap {
  overflow-x: hidden;
}

.tags-view-container .tags-view-wrapper {
  height: 34px;
  width: 100%;
  display: flex;
  flex-wrap: nowrap;
  align-items: center;
}

.tags-view-container .tags-view-item {
  position: relative;
  height: 26px;
  line-height: 26px;
  border: 1px solid #D8DCE5;
  color: #495060;
  background: #FFFFFF;
  padding: 0 8px;
  font-size: 12px;
  margin-right: 10px;
  white-space: nowrap;
  cursor: pointer;
}

.tags-view-container .tags-view-item:first-child {
  margin-left: 15px;
}

.tags-view-container .tags-view-item.active {
  background-color: #42B983;
  color: #FFFFFF;
  border-color: #42B983;
}

.tags-view-container .tags-view-item.active::before {
  content: '';
  background: #fff;
  display: inline-block;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  position: relative;
  margin-right: 2px;
}

.tags-view-container .tags-view-item .el-icon-close {
  border-radius: 50%;
  text-align: center;
  position: relative;
  cursor: pointer;
  font-size: 12px;
  height: 16px;
  width: 16px;
  line-height: 16px;
  vertical-align: middle;
  top: -1px;
  right: -5px;
}

.tags-view-container .tags-view-item .el-icon-close:hover {
  background-color: #B4BCCC;
  color: #FFFFFF;
}

.tags-view-container .tags-menu {
  margin: 0;
  background: #fff;
  z-index: 3000;
  position: fixed;
  list-style-type: none;
  padding: 5px 0;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 400;
  color: #333;
  box-shadow: 2px 2px 3px 0 rgba(0, 0, 0, .3);
}

.tags-view-container .tags-menu li {
  margin: 0;
  padding: 7px 16px;
  cursor: pointer;
}

.tags-view-container .tags-menu li:hover {
  background: #eee;
}
</style>
