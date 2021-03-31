<template>
  <el-row>
    <div class="block-list">
      <div class="block-list-content">
        <div class="item-row">
          <label><i class="fa fa-user"></i></label>
          <div class="value">
            <span>{{ admin.username }}</span>
            <template v-if="admin.is_supper_admin">
              <el-tag type="danger" size="mini">超级管理员</el-tag>
            </template>
            <template v-else>
              <el-tag type="danger" size="mini" v-for="(role, index) in admin.roles" :key="index">{{ role.name }}
              </el-tag>
            </template>
          </div>
        </div>
        <div class="item-row">
          <label><i class="fa fa-clock-o"></i></label>
          <div class="value">{{ admin.created_at }}</div>
        </div>
        <div>
          <el-button type="danger" size="mini" @click="showRestPdDialog">重置密码</el-button>
        </div>
      </div>
    </div>
    <el-dialog
      title="修改密码"
      :visible.sync="show_reset_pd_dialog"
      :close-on-click-modal="false"
      width="60%"
      center>
      <el-form ref="reset" :model="resetPdModel" :rules="resetPaRules"
               label-width="120px" style="max-width: 960px;">
        <el-form-item label="原密码" prop="old_password">
          <el-input type="password" v-model="resetPdModel.old_password"></el-input>
        </el-form-item>
        <el-form-item label="新密码" prop="password">
          <el-input type="password" v-model="resetPdModel.password"></el-input>
        </el-form-item>
        <el-form-item label="确认密码" prop="confirm_passwprd">
          <el-input type="password" v-model="resetPdModel.confirm_passwprd"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer">
        <el-button type="primary" @click="resetPdSubmit('reset')">重置</el-button>
      </div>
    </el-dialog>
  </el-row>
</template>

<script>
export default {
  name: "Me",
  data() {
    let validateConfirmPassword = (rule, value, callback) => {
      if (value == this.resetPdModel.password) {
        callback()
      } else {
        callback(new Error('确认密码不一致'))
      }
    }
    return {
      resetPdModel: {
        old_password: '',
        password: '',
        confirm_passwprd: ''
      },
      resetPaRules: {
        old_password: [
          {required: true, message: '请输入原密码', trigger: 'blur'}
        ],
        password: [
          {required: true, message: '请输入新密码', trigger: 'blur'},
          {min: 5, message: '最少5位字符', trigger: 'blur'},
        ],
        confirm_passwprd: [
          {required: true, message: '请输入确认密码', trigger: 'blur'},
          {min: 5, message: '最少5位字符', trigger: 'blur'},
          {validator: validateConfirmPassword, trigger: 'blur'}
        ],
      },
      show_reset_pd_dialog: false,
    }
  },
  computed: {
    admin() {
      return this.$store.state.admin
    }
  },
  created() {

  },
  mounted() {

  },
  methods: {
    showRestPdDialog() {
      let that = this
      that.resetPdModel = {
        old_password: '',
        password: '',
        confirm_passwprd: '',
      }
      that.show_reset_pd_dialog = true
    },
    resetPdSubmit(ref) {
      let that = this
      that.$refs[ref].validate((valid) => {
        if (!valid) {
          console.log("submit error")
          return false
        }
        that.axios.post('/me/password', that.resetPdModel).then(res => {
          that.$message.success("重置成功")
          that.show_reset_pd_dialog = false
        })
      })
    }
  },
}
</script>

<style scoped>
.item-row label {
  width: 2em;
}

.item-row .el-tag {
  margin-left: 10px;
}
</style>
