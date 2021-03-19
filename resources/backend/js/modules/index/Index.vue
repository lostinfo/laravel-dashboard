<template>
  <el-row class="dashboard-index-container" id="dashboard-index-container">
    <el-row :gutter="10">
      <el-col :lg="6" :md="12" class="quota-container" v-for="i in [0, 1, 2, 3]" :key="i" style="margin-bottom: 10px;">
        <div class="quota-content-container">
          <div class="quota-topbar">
            <div class="quota-title">
              <div class="title nav">{{ quotas[i].name }}</div>
              <div class="range">{{ quotas[i].range }}</div>
            </div>
          </div>
          <div class="quota-number-container">
            <div class="main-number-content">
              <div class="quota-number-title">{{ quotas[i].date_name }}</div>
              <div class="quota-number-content">
                <div class="quota-value">
                  <span class="quota-number">{{ quotas[i].value | numToLocaleString }}</span>
                  <span class="quota-number-unit">{{ quotas[i].unit }}</span>
                </div>
                <div class="mom-content">
                  <div class="mom-item">
                    <span>环比</span>
                    <span
                        :class="quotas[i].chain_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="quotas[i].chain_index > 0 ? 'green' : 'red'">{{ quotas[i].chain_index | abs }}%</span>
                  </div>
                  <div class="mom-item">
                    <span>同比</span>
                    <span
                        :class="quotas[i].an_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="quotas[i].an_index > 0 ? 'green' : 'red'">{{ quotas[i].an_index | abs }}%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </el-col>
    </el-row>
    <el-row :gutter="10">
      <el-col :lg="12" :md="24" class="quota-container is-charts" style="margin-bottom: 10px;">
        <div class="quota-content-container">
          <div class="quota-topbar">
            <div class="quota-title">
              <div class="title nav">{{ gmv.name }}</div>
              <div class="range">{{ gmv.range }}</div>
            </div>
          </div>
          <div class="quota-number-container">
            <div class="main-number-content">
              <div class="quota-number-title">{{ gmv.date_name }}</div>
              <div class="quota-number-content">
                <div class="quota-value">
                  <span class="quota-number">{{ gmv.value | numToLocaleString }}</span>
                  <span class="quota-number-unit">{{ gmv.unit }}</span>
                </div>
                <div class="mom-content">
                  <div class="mom-item">
                    <span>环比</span>
                    <span
                        :class="gmv.chain_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="gmv.chain_index > 0 ? 'green' : 'red'">{{ gmv.chain_index | abs }}%</span>
                  </div>
                  <div class="mom-item">
                    <span>同比</span>
                    <span :class="gmv.an_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="gmv.an_index > 0 ? 'green' : 'red'">{{ gmv.an_index | abs }}%</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="second-number-content">
              <div class="stat-content">
                <div class="stat-item">
                  <span>合计</span>
                  <span class="number">{{ gmv.sum }}</span>
                  <span class="unit">{{ gmv.sum_unit }}</span>
                </div>
                <div class="stat-item">
                  <span>均值</span>
                  <span class="number">{{ gmv.avg }}</span>
                  <span class="unit">{{ gmv.avg_unit }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="quota-charts-container" id="gmv" style="height: 233px;"></div>
        </div>
      </el-col>
      <el-col :lg="12" :md="24">
        <el-row :gutter="10">
          <el-col :span="12" class="quota-container" v-for="i in [4, 5, 6,7]" :key="i" style="margin-bottom: 10px;">
            <div class="quota-content-container">
              <div class="quota-topbar">
                <div class="quota-title">
                  <div class="title nav">{{ quotas[i].name }}</div>
                  <div class="range">{{ quotas[i].range }}</div>
                </div>
              </div>
              <div class="quota-number-container">
                <div class="main-number-content">
                  <div class="quota-number-title">{{ quotas[i].date_name }}</div>
                  <div class="quota-number-content">
                    <div class="quota-value">
                      <span class="quota-number">{{ quotas[i].value | numToLocaleString }}</span>
                      <span class="quota-number-unit">{{ quotas[i].unit }}</span>
                    </div>
                    <div class="mom-content">
                      <div class="mom-item">
                        <span>环比</span>
                        <span
                            :class="quotas[i].chain_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                        <span :class="quotas[i].chain_index > 0 ? 'green' : 'red'">{{
                            quotas[i].chain_index | abs
                          }}%</span>
                      </div>
                      <div class="mom-item">
                        <span>同比</span>
                        <span
                            :class="quotas[i].an_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                        <span :class="quotas[i].an_index > 0 ? 'green' : 'red'">{{ quotas[i].an_index | abs }}%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
    <el-row :gutter="10">
      <el-col :lg="12" :md="24" class="quota-container is-charts" style="margin-bottom: 10px;">
        <div class="quota-content-container">
          <div class="quota-topbar">
            <div class="quota-title">
              <div class="title nav">{{ gmv_month.name }}</div>
              <div class="range">{{ gmv_month.range }}</div>
            </div>
          </div>
          <div class="quota-number-container">
            <div class="main-number-content">
              <div class="quota-number-title">{{ gmv_month.date_name }}</div>
              <div class="quota-number-content">
                <div class="quota-value">
                  <span class="quota-number">{{ gmv_month.value | numToLocaleString }}</span>
                  <span class="quota-number-unit">{{ gmv_month.unit }}</span>
                </div>
                <div class="mom-content">
                  <div class="mom-item">
                    <span>环比</span>
                    <span
                        :class="gmv_month.chain_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="gmv_month.chain_index > 0 ? 'green' : 'red'">{{ gmv_month.chain_index | abs }}%</span>
                  </div>
                  <div class="mom-item">
                    <span>同比</span>
                    <span
                        :class="gmv_month.an_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="gmv_month.an_index > 0 ? 'green' : 'red'">{{ gmv_month.an_index | abs }}%</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="second-number-content">
              <div class="stat-content">
                <div class="stat-item">
                  <span>合计</span>
                  <span class="number">{{ gmv_month.sum }}</span>
                  <span class="unit">{{ gmv_month.sum_unit }}</span>
                </div>
                <div class="stat-item">
                  <span>均值</span>
                  <span class="number">{{ gmv_month.avg }}</span>
                  <span class="unit">{{ gmv_month.avg_unit }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="quota-charts-container" id="gmv-month" style="height: 233px;"></div>
        </div>
      </el-col>
      <el-col :lg="12" :md="24" class="quota-container is-charts" style="margin-bottom: 10px;">
        <div class="quota-content-container">
          <div class="quota-topbar">
            <div class="quota-title">
              <div class="title nav">{{ dau_week.name }}</div>
              <div class="range">{{ dau_week.range }}</div>
            </div>
          </div>
          <div class="quota-number-container">
            <div class="main-number-content">
              <div class="quota-number-title">{{ dau_week.date_name }}</div>
              <div class="quota-number-content">
                <div class="quota-value">
                  <span class="quota-number">{{ dau_week.value | numToLocaleString }}</span>
                  <span class="quota-number-unit">{{ dau_week.unit }}</span>
                </div>
                <div class="mom-content">
                  <div class="mom-item">
                    <span>环比</span>
                    <span
                        :class="dau_week.chain_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="dau_week.chain_index > 0 ? 'green' : 'red'">{{ dau_week.chain_index | abs }}%</span>
                  </div>
                  <div class="mom-item">
                    <span>同比</span>
                    <span
                        :class="dau_week.an_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="dau_week.an_index > 0 ? 'green' : 'red'">{{ dau_week.an_index | abs }}%</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="second-number-content">
              <div class="stat-content">
                <div class="stat-item">
                  <span>合计</span>
                  <span class="number">{{ dau_week.sum }}</span>
                  <span class="unit">{{ dau_week.sum_unit }}</span>
                </div>
                <div class="stat-item">
                  <span>均值</span>
                  <span class="number">{{ dau_week.avg }}</span>
                  <span class="unit">{{ dau_week.avg_unit }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="quota-charts-container" id="dau-week" style="height: 233px;"></div>
        </div>
      </el-col>
    </el-row>
    <el-row :gutter="10">
      <el-col :lg="12" :md="24" class="quota-container is-charts" style="margin-bottom: 10px;">
        <div class="quota-content-container">
          <div class="quota-topbar">
            <div class="quota-title">
              <div class="title nav">{{ client_dau_week.name }}</div>
              <div class="range">{{ client_dau_week.range }}</div>
            </div>
          </div>
          <div class="quota-charts-container" id="client-dau-week" style="height: 324px;"></div>
        </div>
      </el-col>
      <el-col :lg="12" :md="24" class="quota-container is-charts" style="margin-bottom: 10px;">
        <div class="quota-content-container">
          <div class="quota-topbar">
            <div class="quota-title">
              <div class="title nav">{{ register_week.name }}</div>
              <div class="range">{{ register_week.range }}</div>
            </div>
          </div>
          <div class="quota-number-container">
            <div class="main-number-content">
              <div class="quota-number-title">{{ register_week.date_name }}</div>
              <div class="quota-number-content">
                <div class="quota-value">
                  <span class="quota-number">{{ register_week.value | numToLocaleString }}</span>
                  <span class="quota-number-unit">{{ register_week.unit }}</span>
                </div>
                <div class="mom-content">
                  <div class="mom-item">
                    <span>环比</span>
                    <span
                        :class="register_week.chain_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="register_week.chain_index > 0 ? 'green' : 'red'">{{
                        register_week.chain_index | abs
                      }}%</span>
                  </div>
                  <div class="mom-item">
                    <span>同比</span>
                    <span
                        :class="register_week.an_index > 0 ? 'el-icon-caret-top green' : 'el-icon-caret-bottom red'"></span>
                    <span :class="register_week.an_index > 0 ? 'green' : 'red'">{{
                        register_week.an_index | abs
                      }}%</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="second-number-content">
              <div class="stat-content">
                <div class="stat-item">
                  <span>合计</span>
                  <span class="number">{{ register_week.sum }}</span>
                  <span class="unit">{{ register_week.sum_unit }}</span>
                </div>
                <div class="stat-item">
                  <span>均值</span>
                  <span class="number">{{ register_week.avg }}</span>
                  <span class="unit">{{ register_week.avg_unit }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="quota-charts-container" id="register-week" style="height: 233px;"></div>
        </div>
      </el-col>
    </el-row>
  </el-row>
</template>

<script>
import dayjs from 'dayjs'
import erd from 'element-resize-detector'

const today = dayjs().format('YYYY-MM-DD')
const today_range = today + '~' + today + '|' + '今日'
const last_week = dayjs().subtract(1, 'week').format('YYYY-MM-DD')
const last_week_range = last_week + '~' + today + '|' + '过去 7 天'
const last_month = dayjs().subtract(1, 'month').format('YYYY-MM-DD')
const last_month_range = last_month + '~' + today + '|' + '过去 30 天'
const three_months_ago = dayjs().subtract(3, 'month').format('YYYY-MM-DD')
const three_months_ago_range = three_months_ago + '~' + today + '|' + '上线至今'
export default {
  name: "Index",
  data() {
    return {
      loading: false,
      quotas: [
        {
          name: '全站流量',
          range: today_range,
          date_name: '今日',
          value: 3230,
          unit: '次',
          chain_index: 4.9,
          an_index: 3.87,
        },
        {
          name: '全站日活',
          range: today_range,
          date_name: '今日',
          value: 1826,
          unit: '人',
          chain_index: 5.29,
          an_index: 3.92,
        },
        {
          name: '注册用户数',
          range: three_months_ago_range,
          date_name: '今日',
          value: 9889,
          unit: '人',
          chain_index: -4.09,
          an_index: 5.07,
        },
        {
          name: '下单人数',
          range: today_range,
          date_name: '今日',
          value: 138,
          unit: '人',
          chain_index: -3.6,
          an_index: 1.46,
        },
        {
          name: '订单量',
          range: today_range,
          date_name: '今日',
          value: 375,
          unit: '次',
          chain_index: 2.34,
          an_index: 1.02,
        },
        {
          name: '下单转化率',
          range: today_range,
          date_name: '今日',
          value: 3.68,
          unit: '%',
          chain_index: -7.9,
          an_index: -3.06,
        },
        {
          name: '客单价',
          range: today_range,
          date_name: '今日',
          value: 4787,
          unit: '元',
          chain_index: -7.47,
          an_index: -7.24,
        },
        {
          name: '小程序平均使用时长',
          range: last_week_range,
          date_name: '今日',
          value: 2345.36,
          unit: '分钟',
          chain_index: 0.25,
          an_index: 0.19,
        },
      ],
      gmv: {
        name: 'GMV',
        range: last_week_range,
        date_name: '今日',
        value: 268.59,
        unit: '万',
        chain_index: -10.97,
        an_index: -7.18,
        sum: 1.7,
        sum_unit: '千万',
        avg: 345.34,
        avg_unit: '万',
      },
      gmv_month: {
        name: 'GMV近30天变化趋势',
        range: last_month_range,
        date_name: '今日',
        value: 59.59,
        unit: '万',
        chain_index: 3.97,
        an_index: -7.18,
        sum: 1.28,
        sum_unit: '亿',
        avg: 345.34,
        avg_unit: '万',
      },
      dau_week: {
        name: '过去7天日活',
        range: last_week_range,
        date_name: '今日',
        value: 5698,
        unit: '人',
        chain_index: 10.97,
        an_index: 8.18,
        sum: 8623,
        sum_unit: '人',
        avg: 1203,
        avg_unit: '人',
      },
      client_dau_week: {
        name: '各端过去7天日活',
        range: last_week_range,
        date_name: '',
      },
      register_week: {
        name: '过去7天新访问用户数',
        range: last_week_range,
        date_name: '今日',
        value: 896,
        unit: '人',
        chain_index: 1.28,
        an_index: 3.02,
        sum: 5690,
        sum_unit: '人',
        avg: 801,
        avg_unit: '人',
      },
      myEcharts: [],
    }
  },
  filters: {
    numToLocaleString: (num) => {
      return num.toLocaleString()
    },
    abs: (num) => {
      return Math.abs(num)
    },
  },
  created() {

  },
  mounted() {
    let that = this
    that.$nextTick(() => {
      that.initGvmChart()
      that.initGvmMonthChart()
      that.initDauWeekChart()
      that.initClientDauWeekChart()
      that.initRegisterWeekChart()
    })
    erd().listenTo(document.getElementById('dashboard-index-container'), element => {
      this.$nextTick(() => {
        for (let item of that.myEcharts) {
          item.resize()
        }
      })
    })
  },
  methods: {
    initGvmChart() {
      let that = this
      let myChart = that.$echarts.init(document.getElementById('gmv'))
      let option = {
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['支付订单金额总和'],
          bottom: 0,
          left: 'center'
        },
        xAxis: {
          type: 'category',
          data: [],
        },
        yAxis: {
          type: 'value',
          axisLabel: {
            formatter: function (value) {
              return (value / 10000) + '万'
            },
          },
        },
        series: [
          {
            name: '支付订单金额总和',
            data: [],
            type: 'line',
          }
        ],
        color: ['#409EFF'],
      }
      let now = dayjs()
      for (let i = 5; i >= 0; i--) {
        option.xAxis.data.push(now.subtract(i, 'day').format('M-D'))
        option.series[0].data.push(parseInt(Math.random() * 10000000))
      }
      myChart.setOption(option)
      that.myEcharts.push(myChart)
    },
    initGvmMonthChart() {
      let that = this
      let myChart = that.$echarts.init(document.getElementById('gmv-month'))
      let option = {
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['支付订单金额总和'],
          bottom: 0,
          left: 'center'
        },
        xAxis: {
          type: 'category',
          data: [],
        },
        yAxis: {
          type: 'value',
          axisLabel: {
            formatter: function (value) {
              return (value / 10000) + '万'
            },
          },
        },
        series: [
          {
            name: '支付订单金额总和',
            data: [],
            type: 'line',
          }
        ],
        color: ['#409EFF'],
      }
      let now = dayjs()
      for (let i = 31; i >= 0; i--) {
        option.xAxis.data.push(now.subtract(i, 'day').format('M-D'))
        option.series[0].data.push(parseInt(Math.random() * 10000000))
      }
      myChart.setOption(option)
      that.myEcharts.push(myChart)
    },
    initDauWeekChart() {
      let that = this
      let myChart = that.$echarts.init(document.getElementById('dau-week'))
      let option = {
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['全站流量的用户数'],
          bottom: 0,
          left: 'center'
        },
        xAxis: {
          type: 'category',
          data: [],
        },
        yAxis: {
          type: 'value',
        },
        series: [
          {
            name: '全站流量的用户数',
            data: [],
            type: 'line',
          }
        ],
        color: ['#409EFF'],
      }
      let now = dayjs()
      for (let i = 7; i >= 0; i--) {
        option.xAxis.data.push(now.subtract(i, 'day').format('M-D'))
        option.series[0].data.push(parseInt(Math.random() * 10000))
      }
      myChart.setOption(option)
      that.myEcharts.push(myChart)
    },
    initClientDauWeekChart() {
      let that = this
      let myChart = that.$echarts.init(document.getElementById('client-dau-week'))
      let option = {
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['Web端日活', 'App端日活', '小程序端日活'],
          bottom: 0,
          left: 'center'
        },
        xAxis: {
          type: 'category',
          data: [],
        },
        yAxis: {
          type: 'value',
        },
        series: [
          {
            name: 'Web端日活',
            data: [],
            type: 'line',
          },
          {
            name: 'App端日活',
            data: [],
            type: 'line',
          },
          {
            name: '小程序端日活',
            data: [],
            type: 'line',
          },
        ],
        color: ['#409EFF', '#91cc75', '#fac858', '#ee6666', '#73c0de', '#3ba272', '#fc8452', '#9a60b4', '#ea7ccc'],
      }
      let now = dayjs()
      for (let i = 7; i >= 0; i--) {
        option.xAxis.data.push(now.subtract(i, 'day').format('M-D'))
        option.series[0].data.push(parseInt(Math.random() * 3000))
        option.series[1].data.push(parseInt(Math.random() * 3000))
        option.series[2].data.push(parseInt(Math.random() * 3000))
      }
      myChart.setOption(option)
      that.myEcharts.push(myChart)
    },
    initRegisterWeekChart() {
      let that = this
      let myChart = that.$echarts.init(document.getElementById('register-week'))
      let option = {
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['全站新用户访问的用户数'],
          bottom: 0,
          left: 'center'
        },
        xAxis: {
          type: 'category',
          data: [],
        },
        yAxis: {
          type: 'value',
        },
        series: [
          {
            name: '全站流量的用户数',
            data: [],
            type: 'line',
          }
        ],
        color: ['#409EFF'],
      }
      let now = dayjs()
      for (let i = 7; i >= 0; i--) {
        option.xAxis.data.push(now.subtract(i, 'day').format('M-D'))
        option.series[0].data.push(parseInt(Math.random() * 200))
      }
      myChart.setOption(option)
      that.myEcharts.push(myChart)
    },
  }
}
</script>

<style scoped lang="scss">
.dashboard-index-container {
  font-weight: 400;
  position: relative;
  color: #606266;
  font-size: 14px;
  line-height: 1.42857143;
}

.quota-container {

}

.quota-content-container {
  background: #fff;
  box-shadow: 0 2px 11px 0 rgba(190, 202, 218, .17);
  border: 2px #fff solid;
  border-radius: 3px;
  padding: 14px 20px;
  height: 100%;
}

.quota-content-container:hover {
  border: 2px solid #409EFF;
}

.quota-title .title {
  font-weight: bold;
  font-size: 14px;
  color: #303133;
  line-height: 2;
}

.quota-title .range {
  font-size: 12px;
  color: #909399;
}

.quota-number-container {
  padding-top: 15px;
  display: flex;
}

.quota-number-container .main-number-content {
  flex: 1;
}

.quota-number-container .second-number-content {
  padding: 12px 0 12px 11px;
  border-left: 1px solid #E9F0F7;
}

.quota-number-title {

}

.quota-value {
  vertical-align: bottom;
}

.quota-number {
  font-size: 40px;
  color: #303133;
  font-weight: 400;
}

.quota-number-unit {
  font-size: 12px;
}

.mom-content {
  display: flex;
  justify-content: flex-start;
  font-size: 12px;
  margin-top: 10px;
}

.mom-content .mom-item {
  margin-right: 10px;
}

.mom-content .mom-item .green {
  color: #2DCA93;
}

.mom-content .mom-item .red {
  color: #FC6772;
}

.stat-content {
  font-size: 12px;
}

.stat-content .stat-item {
  vertical-align: bottom;
}

.stat-content .stat-item .number {
  color: #303133;
  font-size: 18px;
}

.stat-content .stat-item .unit {
  font-weight: 300;
}

.is-charts .quota-number-content {
  display: flex;
  justify-content: flex-start;
}

.is-charts .mom-content {
  margin-top: 0;
  margin-left: 10px;
  flex-direction: column;
  justify-content: space-around;
  align-items: flex-start;
}
</style>