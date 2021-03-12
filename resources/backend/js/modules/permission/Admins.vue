<template>
  <el-row>
    <vue-table ref="table" :api-url="'/admins'" show-paginate :search-model="searchModel" :fields="fields"
               :item-actions="itemActions" @table-action="tableActions">
      <template slot="header-title">
        <span>管理员列表</span>
      </template>
      <template slot="header-button">
        <el-button type="primary" size="mini" icon="el-icon-circle-plus"
                   @click="$router.push({path:'/admin/admin'})">
        </el-button>
      </template>
      <template slot="search-items">
        <el-form-item label="名称" prop="username">
          <el-input
              placeholder="管理员名称"
              v-model="searchModel.username">
          </el-input>
        </el-form-item>
      </template>
    </vue-table>
  </el-row>
</template>

<script>
export default {
  name: "Admins",
  data() {
    return {
      searchModel: {
        username: '',
      },
      fields: [
        {
          label: '#',
          key: 'id',
          sortable: true,
          width: 80
        },
        {
          label: '管理员名称',
          key: 'username',
        },
        {
          label: '角色',
          // key: 'roles',
          template: ({roles}) => {
            let _template = '<div>'
            for (let i in roles) {
              _template += '<span style="' + (i > 0 ? 'margin-left: 10px;' : '') + '" class="el-tag el-tag--small el-tag--danger el-tag--light">' + roles[i].name + '</span>'
            }
            _template += '</div>'
            return _template
          }
        },
        {
          label: '是否激活',
          template: ({active}) => {
            return active ? '是' : '否'
          }
        },
        {
          label: '创建时间',
          key: 'created_at',
        },
      ],
      itemActions: [
        {
          action: 'edit',
          label: '编辑',
          type: 'primary',
          showAction: admin => {
            return !admin.is_supper_admin
          }
        },
        {
          action: 'delete',
          label: '删除',
          type: 'danger',
          showAction: admin => {
            return !admin.is_supper_admin
          }
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
      this.$router.push({path: '/admin/admin/' + item.id})
    },
    deleteAction(item) {
      let that = this
      that.$confirm('此操作将永久删除该数据, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        that.axios.post('/admins/' + item.id, {_method: 'delete'}).then(res => {
          that.$refs.table.loadData()
          that.$message.success('操作成功')
        }).catch(err => {
          console.log(err)
        })
      }).catch(() => {
      })
    },
  },
}
</script>

<style scoped>

</style>
