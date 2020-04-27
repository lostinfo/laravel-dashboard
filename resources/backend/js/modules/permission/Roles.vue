<template>
  <el-row>
    <vue-table ref="table" :api-url="'/roles'" show-paginate :search-model="searchModel" :fields="fields"
               :item-actions="itemActions" @table-action="tableActions">
      <template slot="header-title">
        <span>角色列表</span>
      </template>
      <template slot="header-button">
        <el-button type="primary" size="mini" icon="el-icon-circle-plus"
                   @click="$router.push({path:'/admin/role'})">添加
        </el-button>
      </template>
      <template slot="search-items">
        <el-form-item label="角色名称" prop="name">
          <el-input
            placeholder="角色名称"
            v-model="searchModel.name">
          </el-input>
        </el-form-item>
      </template>
    </vue-table>
  </el-row>
</template>

<script>
  export default {
    name: "Roles",
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
            label: '角色名称',
            key: 'name',
          },
          {
            label: '权限数量',
            key: 'permissions_count',
          },
          {
            label: '创建时间',
            key: 'created_at',
          },
        ],
        itemActions: [
          {
            action: 'edit',
            type: 'primary',
            label: '编辑',
          },
          {
            action: 'delete',
            type: 'danger',
            label: '删除',
          },
        ],
      }
    },
    created() {

    },
    mounted() {

    },
    methods: {
      tableActions(action, item) {
        let that = this
        that[action + 'Action'](item)
      },
      editAction(item) {
        this.$router.push({path: '/admin/role/' + item.id})
      },
      deleteAction(item) {
        let that = this
        that.$confirm('此操作将永久删除该数据, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          that.axios.post('/roles/' + item.id, {_method: 'delete'}).then(res => {
            that.$refs.table.loadData()
            that.$message.success('操作成功')
          }).catch(err => {
            console.log(err)
          })
        }).catch(() => {})
      },
    },
  }
</script>

<style scoped>

</style>
