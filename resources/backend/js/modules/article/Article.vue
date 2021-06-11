<template>
  <el-row>
    <el-card class="view-card">
      <el-form :model="articleModel" :rules="articleRules" ref="formRef" label-width="120px" v-loading="formLoading">
        <el-form-item label="标题" prop="title">
          <el-input v-model="articleModel.title"></el-input>
        </el-form-item>
        <el-form-item label="正文" prop="markdown">
          <vue-edit ref="editRef" :markdown="articleModel.markdown" :upload-url="'/files/article'"
                    :wrapper-class-name="'article-content'"></vue-edit>
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
  name: "Article",
  data() {
    return {
      formLoading: false,
      id: null,
      articleModel: {
        title: '',
        markdown: '',
        content: '',
      },
      articleRules: {
        title: [
          {required: true, message: '请输入标题', trigger: 'blur'}
        ],
        markdown: [
          {required: true, message: '请输入正文', trigger: 'blur'}
        ],
      }
    }
  },
  created() {

  },
  mounted() {
    if (this.$route.params.hasOwnProperty('id')) {
      this.id = this.$route.params.id
      this.getArticle()
    }
  },
  methods: {
    getArticle() {
      let that = this
      that.formLoading = true
      that.axios.get('/articles/' + that.id).then(res => {
        that.formLoading = false
        that.articleModel = res
        that.$refs.editRef.setSimplemdeValue(that.articleModel.markdown)
      }).catch(err => {
        that.formLoading = false
      })
    },
    submitClose() {
      let that = this
      that.$emit('closeView')
    },
    submit() {
      let that = this
      that.formLoading = true
      that.articleModel.markdown = that.$refs.editRef.getSimplemdeMarkdown()
      that.articleModel.content = that.$refs.editRef.getSimplemdeHtml()
      that.$refs.formRef.validate((valid) => {
        if (!valid) {
          that.formLoading = false
          return false
        }
        that.axios.post('/articles', that.articleModel).then(res => {
          that.formLoading = false
          that.$message.success('提交成功')
          setTimeout(function () {
            that.$emit('closeView', '/admin/articles')
          }, 2000)
        }).catch(err => {
          that.formLoading = false
        })
      })
    }
  },
}
</script>

<style scoped>

</style>
