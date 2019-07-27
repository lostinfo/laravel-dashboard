<template>
  <el-row>
    <el-card class="view-card" v-if="User">
      <div class="block-list">
        <title>User Info</title>
        <div class="block-list-content">
          <div class="item-row" v-for="(item, key) in User" :key="key">
            <label>{{key}}</label>
            <div class="value">{{item}}</div>
          </div>
        </div>
      </div>
      <div class="block-list">
        <title>操作</title>
        <div class="info-group-content">

        </div>
      </div>
    </el-card>
  </el-row>
</template>

<script>
  export default {
    name: "User",
    data() {
      return {
        id: null,
        User: null,
      }
    },
    created() {
      if (this.$route.params.hasOwnProperty('id')) {
        this.id = this.$route.params.id
        this.getUser()
      } else {
        this.$router.back()
      }1
    },
    mounted() {

    },
    methods: {
      getUser() {
        let that = this
        that.axios.get('/users/' + that.id).then(res => {
          that.User = res
        }).catch(err => {})
      }
    },
  }
</script>

<style scoped>
  
</style>