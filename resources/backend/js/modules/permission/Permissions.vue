<template>
  <el-row>
    <vue-table ref="table" :api-url="'/permissions'" show-paginate :search-model="searchModel" :fields="fields"
               :item-actions="itemActions" @table-action="tableActions">
      <template slot="header-title">
        <span>权限列表</span>
      </template>
      <template slot="header-button">
        <el-button type="primary" size="mini" icon="el-icon-refresh"
                   @click="refresh">刷新
        </el-button>
      </template>
      <template slot="search-items">
        <el-form-item label="权限名称" prop="name">
          <el-input
            placeholder="权限名称"
            v-model="searchModel.name">
          </el-input>
        </el-form-item>
      </template>
    </vue-table>
  </el-row>
</template>

<script>
  export default {
    name: "Permissions",
    data() {
      return {
        searchModel: {
          name: '',
        },
        fields: [
          {
            label: '#',
            key: 'id',
            sortable: true,
            width: 80
          },
          {
            label: '权限名称',
            key: 'name',
          },
          {
            label: '创建时间',
            key: 'created_at',
          },
        ],
        itemActions: [],
      }
    },
    created() {

    },
    mounted() {

    },
    methods: {
      tableActions(action, item) {
        let that = this

      },
      refresh() {
        let that = this
        that.axios.post('/permissions/refresh').then(res => {
          that.$message.success('刷新成功')
          that.$refs.table.loadData()
        })
      }
    },
  }
</script>

<style scoped>

</style>