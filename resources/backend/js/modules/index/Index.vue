<template>
  <el-row v-loading="loading">
    <el-card class="view-card">
      <div slot="header" class="clearfix">
        <span>数据汇总</span>
      </div>
      <div class="group_wrap">
        <div class="group_item" v-for="(item, index) in items" :key="index">
          <div class="title">{{item.label}}</div>
          <countTo :startVal="0" :endVal="item.value" class="number"></countTo>
        </div>
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

<style scoped>
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
    background-color: #409eff8f;
    border-radius: 5px;
    padding: 10px;
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
</style>