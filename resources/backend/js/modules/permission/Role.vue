<template>
  <el-row>
    <el-card class="view-card">
      <el-form :model="roleModel" :rules="roleRules" ref="formRef" label-width="120px" v-loading="formLoading">
        <el-form-item label="角色名称" prop="name">
          <el-input v-model="roleModel.name"></el-input>
        </el-form-item>
        <el-form-item label="权限" prop="permissions">
          <el-checkbox-group v-model="roleModel.permissions">
            <el-checkbox :label="permission.id" v-for="(permission, index) in permission_options" :key="index">{{permission.name}}</el-checkbox>
          </el-checkbox-group>
        </el-form-item>
        <el-form-item>
          <el-button @click="submitClose">取消</el-button>
          <el-button type="primary" @click="submit">提交</el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </el-row>
</template>

<script>
  export default {
    name: "Role",
    data() {
      return {
        formLoading: false,
        id: null,
        roleModel: {
          name: '',
          permissions: []
        },
        roleRules: {
          name: [
            {required: true, message: '请输入角色名称', trigger: 'blur'}
          ],
        },
        permission_options: [],
      }
    },
    created() {

    },
    mounted() {
      this.getPermissionOptions()
      if (this.$route.params.hasOwnProperty('id')) {
        this.id = this.$route.params.id
        this.getRole()
      }
    },
    methods: {
      getPermissionOptions() {
        let that = this
        that.axios.get('/permissions/options').then(res => {
          that.permission_options = res
        })
      },
      getRole() {
        let that = this
        that.formLoading = true
        that.axios.get('/roles/' + that.id).then(res => {
          that.formLoading = false
          that.roleModel = res
        }).catch(err => {
          that.formLoading = false
        })
      },
      submitClose() {
        let that = this
        that.$router.back()
      },
      submit() {
        let that = this
        that.formLoading = true
        that.$refs.formRef.validate((valid) => {
          if (!valid) {
            that.formLoading = false
            return false
          }
          that.axios.post('/roles', that.roleModel).then(res => {
            that.formLoading = false
            that.$message.success('提交成功')
            setTimeout(function () {
              that.$router.replace('/admin/roles')
            }, 2000)
          }).catch(err => {
            that.formLoading = false
          })
        })
      },
    },
  }
</script>

<style>
  
</style>