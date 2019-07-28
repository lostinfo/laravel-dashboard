<template>
  <el-menu :default-active="defaultActive" theme="dark" style="border-radius: 0;"
           :router="true" :unique-opened="true" :collapse="collapse">
    <template v-for="(item, index) in menus">
      <template v-if="item.unfolded">
        <el-submenu :index="index + ''">
          <template slot="title">
            <i :class="item.icon"></i>
            <span slot="title">{{item.name}}</span>
          </template>
          <el-menu-item-group>
            <template v-for="(menu, menuIndex) in item.children">
              <el-menu-item :index="menu.path">{{menu.name}}</el-menu-item>
            </template>
          </el-menu-item-group>
        </el-submenu>
      </template>
      <template v-else>
        <el-menu-item :index="item.path">
          <i :class="item.icon"></i>
          <span slot="title">{{item.name}}</span>
        </el-menu-item>
      </template>
    </template>
  </el-menu>
</template>

<script>
  export default {
    name: "Menu",
    props: {
      collapse: {
        type: Boolean,
        default: false
      },
      menus: {
        type: Array,
        required: true,
      }
    },
    data () {
      return {
        defaultActive: '',
      }
    },
    created() {
      this.defaultActive = this.$route.path
    },
  }
</script>

<style scoped>

</style>