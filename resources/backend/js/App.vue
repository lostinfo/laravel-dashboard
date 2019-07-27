<template>
  <div id="app" class="wh100">
    <router-view></router-view>
  </div>
</template>
<style>
  html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    overflow-x: hidden;
  }

  .wh100 {
    width: 100%;
    height: 100%;
  }
</style>
<script>
  export default {
    name: "App",
    data () {
      return {

      }
    }
  }
</script>

<style scoped>

</style>