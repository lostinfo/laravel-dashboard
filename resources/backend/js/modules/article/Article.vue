<template>
  <el-row>
    <vue-edit ref="editRef" :markdown="markdown" :upload-url="'/files/article'" :wrapper-class-name="'article-content'"></vue-edit>
  </el-row>
</template>

<script>
  export default {
    name: "Article",
    data() {
      return {
        markdown: ''
      }
    },
    created() {

    },
    mounted() {

    },
    methods: {},
  }
</script>

<style scoped>

</style>