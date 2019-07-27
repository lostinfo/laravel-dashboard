<template>
  <div>
    <el-card class="view-card">
      <div slot="header" class="view-card-header">
        <div class="header-title">
          <div>
            <slot name="header-title"><span>默认标题</span></slot>
          </div>
          <div class="header-btns">
            <slot name="header-button"></slot>
            <el-button type="warning" size="mini" icon="el-icon-download" v-if="canExport" @click="searchFormExportSubmit"></el-button>
          </div>
        </div>
        <el-form :inline="true" ref="searchRef" class="header-search" :model="searchModel" v-if="searchModel" size="mini">
          <div style="display: flex;flex-direction: row;">
            <div style="display: block;flex: 1;">
              <slot name="search-items"></slot>
            </div>
            <el-form-item style="display: flex;align-items: flex-end;">
              <el-button type="primary" icon="el-icon-search" @click="searchFormSubmit"></el-button>
              <el-button type="primary" plain icon="el-icon-refresh" @click="searchFormReset('searchRef')"></el-button>
            </el-form-item>
          </div>
        </el-form>
      </div>
      <el-table
        :data="listData"
        stripe
        @sort-change="handleSortChange"
        v-loading="listLoading"
        style="width: 100%">
        <el-table-column v-for="(field, index) in fields" :key="index" :label="field.label" :prop="field.key" :width="field.width || ''"
                         :sortable="field.sortable ? field.sortable : false" :align="field.align ? field.align : 'left'">
          <template slot-scope="scope">
            <template v-if="!field.template">
              {{scope.row[field.key]}}
            </template>
            <template v-else>
              <div v-html="field.template(scope.row)" v-if="field.key == undefined"></div>
              <div v-html="field.template(scope.row[field.key])" v-else></div>
            </template>
          </template>
        </el-table-column>
        <el-table-column label="操作" v-if="itemActions.length > 0" :width="itemActions.length * 100" align="center">
          <template slot-scope="scope">
            <template v-for="(action, index) in itemActions">
              <el-button v-show="!action.showAction || action.showAction(scope.row)" :key="index" size="mini"
                         :type="action.type"
                         @click="callAction(action.action, scope.row)"
                         style="margin-bottom: 5px">{{action.label}}
              </el-button>
            </template>
          </template>
        </el-table-column>
      </el-table>
    </el-card>
    <el-card class="view-card" v-if="showPaginate">
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page="currentPage"
        :page-sizes="[5, 10, 15, 20, 30, 40, 50]"
        :page-size="pageSize"
        layout="total, sizes, prev, pager, next, jumper"
        :total="total">
      </el-pagination>
    </el-card>
  </div>
</template>

<script>
  import fecha from 'fecha'
  export default {
    name: "Table",
    props: {
      searchModel: {
        type: Object,
        default() {
          return {}
        }
      },
      canExport: {
        type: Boolean,
        default() {
          return false
        }
      },
      showPaginate: {
        type: Boolean,
        default() {
          return false
        }
      },
      apiUrl: {
        type: String,
        required: true
      },
      fields: {
        typr: Array,
        required: true
      },
      itemActions: {
        typr: Array,
        default() {
          return []
        }
      },
    },
    data() {
      return {
        listLoading: false,
        listData: [],
        currentPage: 1,
        pageSize: 10,
        total: 0,
        order_by_column: 'id',
        order_by_direction: 'desc'
      }
    },
    created() {

    },
    mounted() {
      this.loadData()
    },
    methods: {
      loadData() {
        let that = this
        let query = {
          order_by_column: that.order_by_column,
          order_by_direction: that.order_by_direction,
        }
        if (that.showPaginate) {
          query.page_size = that.pageSize
          query.page = that.currentPage
        }
        for (let index in that.searchModel) {
          query[index] = that.searchModel[index]
        }
        that.listLoading = true
        that.axios.get(that.apiUrl, {params: query}).then(res => {
          if (that.showPaginate) {
            that.total = res.total
            that.currentPage = res.current_page
            that.listData = res.data
          } else {
            that.listData = res
          }
          that.listLoading = false
        })
      },
      callAction(action, item) {
        this.$emit('table-action', action, item)
      },
      searchFormSubmit() {
        this.currentPage = 1
        this.loadData()
      },
      handleSizeChange(val) {
        this.pageSize = val
        this.loadData()
      },
      handleCurrentChange(val) {
        this.currentPage = val
        this.loadData()
      },
      searchFormReset(ref) {
        this.$refs[ref].resetFields()
        this.searchFormSubmit()
      },
      // 排序:sortable=custom 远程请求, sortable=true当前页面排序
      handleSortChange(column, prop, order){
        this.order_by_column = column.prop;
        this.order_by_direction = column.order == 'ascending'? 'asc': 'desc';
        if(column.column && column.column.sortable){
          this.loadData()
        }
      },
      searchFormExportSubmit() {
        let that = this
        that.axios.get(that.apiUrl + '/export', {params: that.searchModel, responseType: 'blob'}).then(res => {
          that.download(res)
        })
      },
      download(blob) {
        let that = this
        const url = window.URL.createObjectURL(new Blob([blob], {type:'application/vnd.ms-excel'}))
        const link = document.createElement('a')

        link.href = url
        link.setAttribute('download', that.apiUrl + fecha.format(new Date(), 'YYYYMMDDhhmmssSSS') + '.xlsx')
        document.body.appendChild(link)
        link.click()
      },
    },
  }
</script>

<style scoped>
  .view-card-header{

  }
  .view-card-header .header-title{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    border-bottom: 1px solid #ebeef5;
    padding-bottom: 18px;
  }
  .view-card-header .header-search{
    padding-top: 18px;
    min-height: 36px;
  }
</style>