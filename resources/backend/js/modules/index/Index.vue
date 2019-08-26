<template>
  <el-row v-loading="loading">
    <el-card class="view-card">
      <div slot="header">
        <span>数据汇总</span>
      </div>
      <div class="group_wrap">
        <div class="group_item" v-for="(item, index) in items" :key="index">
          <div class="title">{{item.label}}</div>
          <countTo :startVal="0" :endVal="item.value" class="number"></countTo>
        </div>
      </div>
    </el-card>
    <el-card class="view-card">
      <div slot="header" class="clearfix">
        <span>开发日志</span>
      </div>
      <div>
        <el-timeline>
          <el-timeline-item
            placement="top"
            v-for="(log_item, index) in devlog"
            :key="index"
            :timestamp="log_item.timestamp"
          >
            <el-card>
              <div class="log-item" v-for="(row, index) in log_item.content" :key="index">{{row}}</div>
            </el-card>
          </el-timeline-item>
        </el-timeline>
      </div>
    </el-card>
  </el-row>
</template>

<script>
  import countTo from 'vue-count-to'
  export default {
    name: "Index",
    data() {
      return {
        loading: false,
        items: [
          {
            label: '用户',
            value: 99999,
          },
          {
            label: '订单',
            value: 99999,
          },
          {
            label: '支付',
            value: 99999.00,
          },
        ],
        devlog: [
          {
            timestamp: '2019-07-30',
            content: [
              '动态菜单, 按角色设置菜单',
              '管理员中间件',
            ]
          },
          {
            timestamp: '2019-07-28',
            content: [
              '菜单分组',
              'bug 修复',
            ]
          },
          {
            timestamp: '2019-07-27',
            content: [
              '表格模板',
              'markdown 编辑器',
              '静态菜单',
              '权限管理',
            ]
          },
          {
            timestamp: '2019-08-22',
            content: [
              '权限别名',
            ]
          },
          {
            timestamp: '2019-08-26',
            content: [
              'v-permission 指令',
            ]
          },
        ]
      }
    },
    components: {
      countTo
    },
    created() {

    },
    mounted() {
      let that = this
    },
    methods: {
    }
  }
</script>

<style scoped lang="scss">
  @import "../../../../vendor/sass/variables";
  .group_wrap {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    /*justify-content: center;*/
  }

  .group_item {
    width: 190px;
    height: 100px;
    margin: 10px;
    text-align: center;
    border-radius: 5px;
    padding: 10px;
  }
  .group_item:nth-child(1) {
    background-color: $orange;
  }
  .group_item:nth-child(2) {
    background-color: $pink;
  }
  .group_item:nth-child(3) {
    background-color: $teal;
  }
  .group_item:nth-child(4) {
    background-color: $green;
  }

  .group_item .title {
    height: 60px;
    color: #ffffff;
    font-size: 26px;
  }

  .group_item .number {
    color: #FFFFFE;
    font-size: 26px;
  }

  .group_column {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .group_column ul {
    display: flex;
    flex-direction: row;
    height: 40px;
    margin: 0;
    padding: 0;
    line-height: 40px;
  }

  .group_column ul li {
    list-style-type: none;
    width: 25%;
  }

  .group_column ul .title {
    font-weight: 800;
  }

  .group_column ul:nth-child(n+2) {
    border-top: 1px solid #e6ebf5;
  }

  .log-item{
    line-height: 2em;
  }
</style>