<template>
  <el-row>
    <el-card class="view-card">
      <el-form :model="adminModel" :rules="adminRules" ref="formRef" label-width="120px" v-loading="formLoading">
        <el-form-item label="管理员用户名" prop="username">
          <el-input v-model="adminModel.username" :disabled="id"></el-input>
        </el-form-item>
        <el-form-item prop="password">
          <template slot="label">
            密码
            <span>
              <el-tooltip class="item" effect="dark" content="为空则不更新密码" placement="top">
                <i class="fa fa-question-circle"></i>
              </el-tooltip>
            </span>
          </template>
          <el-input v-model="adminModel.password"></el-input>
        </el-form-item>
        <el-form-item label="是否超级管理员" prop="is_supper_admin">
          <el-checkbox v-model="adminModel.is_supper_admin" :true-label="1" :false-label="0"></el-checkbox>
        </el-form-item>
        <el-form-item label="角色" prop="roles">
          <el-checkbox-group v-model="adminModel.roles">
            <el-checkbox :label="role.id" v-for="(role, index) in role_options" :key="index">{{role.name}}</el-checkbox>
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
    name: "Admin",
    data() {
      return {
        formLoading: false,
        id: null,
        adminModel: {
          username: '',
          password: '',
          is_supper_admin: 0,
          roles: [],
        },
        adminRules: {
          username: [
            {required: true, message: '请输入管理员用户名', trigger: 'blur'}
          ],
          roles: [
            {required: true, message: '请选择角色', trigger: 'blur'}
          ],
          password: []
        },
        role_options: [],
      }
    },
    created() {

    },
    mounted() {
      this.getRoleOptions()
      if (this.$route.params.hasOwnProperty('id')) {
        this.id = this.$route.params.id
        this.getAdmin()
      } else {
        this.adminRules.password.push({required: true, message: '请填写密码', trigger: 'blur'})
      }
    },
    methods: {
      getRoleOptions() {
        let that = this
        that.axios.get('/roles/options').then(res => {
          that.role_options = res
        })
      },
      getAdmin() {
        let that = this
        that.formLoading = true
        that.axios.get('/admins/' + that.id).then(res => {
          that.formLoading = false
          that.adminModel = res
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
          that.axios.post('/admins', that.adminModel).then(res => {
            that.formLoading = false
            that.$message.success('提交成功')
            setTimeout(function () {
              that.$router.replace('/admin/admins')
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