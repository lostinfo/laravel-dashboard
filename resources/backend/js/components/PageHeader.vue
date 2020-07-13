<template>
  <div class="page-header">
    <div class="page-heading">
      <div class="page-header-heading-left">
        <span class="page-header-heading-title">{{title}}</span>
        <span class="page-header-heading-sub-title">{{subTitle}}</span>
      </div>
    </div>
    <div class="page-header-content">
      <slot name="content"></slot>
    </div>
  </div>
</template>

<script>
  export default {
    name: "PageHeader",
    props: {
      title: {
        type: String,
        required: true
      },
      subTitle: {
        type: String,
        required: false,
        default: ''
      },
    },
    created() {

    },
    mounted() {

    },
    methods: {},
  }
</script>

<style scoped>
  .page-header {
    margin: -20px -20px 20px -20px;
    padding: 15px 20px;
    background-color: #FFFFFF;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, .1);
  }

  .page-heading {
    margin-top: 8px;
  }

  .page-header-heading-left {
    display: table-cell;
    vertical-align: bottom;
  }

  .page-header-heading-title {
    margin-right: 12px;
    margin-bottom: 0;
    color: rgba(0, 0, 0, 0.85);
    font-weight: 600;
    font-size: 20px;
    line-height: 32px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .page-header-content {
    padding-top: 12px;
    font-size: 14px;
    color: #333333;
  }
</style>
