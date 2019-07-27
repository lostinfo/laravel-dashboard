<template>
  <el-row>
    <vue-table ref="table" :api-url="'/users'" show-paginate can-export :search-model="searchModel" :fields="fields"
               :item-actions="itemActions" @table-action="tableActions">
      <template slot="header-title">
        <span>用户列表</span>
      </template>
      <template slot="header-button">

      </template>
      <template slot="search-items">
        <el-form-item label="Name" prop="name">
          <el-input
            placeholder="Name"
            v-model="searchModel.name">
          </el-input>
        </el-form-item>
        <el-form-item label="Email" prop="email">
          <el-input
            placeholder="Email"
            v-model="searchModel.email">
          </el-input>
        </el-form-item>
        <el-form-item label="Phone" prop="phone">
          <el-input
            placeholder="Phone"
            v-model="searchModel.phone">
          </el-input>
        </el-form-item>
        <el-form-item label="Age" prop="age">
          <el-input
            placeholder="Age"
            v-model="searchModel.age">
          </el-input>
        </el-form-item>
        <el-form-item label="Created At" prop="created_at">
          <el-date-picker
            v-model="searchModel.created_at"
            type="datetimerange"
            value-format="yyyy-MM-dd HH:mm:ss"
            range-separator="-"
            start-placeholder="Start Date"
            end-placeholder="End Date">
          </el-date-picker>
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
          name: '',
          email: '',
          phone: '',
          age: '',
          created_at: [],
        },
        fields: [
          {
            label: '#',
            key: 'id',
            sortable: true,
            width: 80
          },
          {
            label: 'Avatar',
            key: 'avatar',
            width: 80,
            template: avatar => {
              return '<img src="' + avatar+ '" style="width: 40px; height: 40px; border-radius: 50%;">'
            }
          },
          {
            label: 'Name',
            key: 'name',
            width: 120,
          },
          {
            label: 'Email',
            key: 'email',
            width: 200,
          },
          {
            label: 'Phone',
            key: 'phone',
            width: 120,
          },
          {
            label: 'Age',
            key: 'age',
            width: 100,
            sortable: true,
          },
          {
            label: 'Address',
            key: 'address',
          },
          {
            label: 'Created At',
            key: 'created_at',
          },
        ],
        itemActions: [
          {
            action: 'info',
            type: 'primary',
            label: '详情',
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
      infoAction(item) {
        this.$router.push({path: '/admin/user/' + item.id})
      },
    },
  }
</script>

<style scoped>

</style>