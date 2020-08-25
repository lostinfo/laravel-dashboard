<template>
  <el-row>
    <el-row>
      <vue-table ref="table" :api-url="'/articles'" show-paginate :search-model="searchModel" :fields="fields"
                 :item-actions="itemActions" @table-action="tableActions">
        <template slot="header-title">
          <span>文章列表</span>
        </template>
        <template slot="header-button">
          <el-button type="primary" size="mini" icon="el-icon-circle-plus"
                     @click="$router.push({path:'/admin/article'})">添加
          </el-button>
        </template>
      </vue-table>
    </el-row>
  </el-row>
</template>

<script>
  export default {
    name: "Articles",
    data() {
      return {
        searchModel: {

        },
        fields: [
          {
            label: '#',
            key: 'id',
            sortable: true,
            width: 80,
          },
          {
            label: '标题',
            key: 'title',
            width: 400,
          },
          {
            label: '创建时间',
            key: 'created_at',
          },
        ],
        itemActions: [
          {
            action: 'show',
            label: '查看',
          },
          {
            action: 'edit',
            label: '编辑',
          },
          {
            action: 'delete',
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
      showAction(item) {
        window.open('/article/' + item.id, '_black')
      },
      editAction(item) {
        this.$router.push({path: '/admin/article/' + item.id})
      },
      deleteAction(item) {
        let that = this
        that.$confirm('此操作将永久删除该数据, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          that.axios.delete('/articles/' + item.id).then(res => {
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
