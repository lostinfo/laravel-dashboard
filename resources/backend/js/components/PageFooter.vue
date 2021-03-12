<template>
  <footer class="page-footer">
    <div class="footer-links">
      <a target="_blank" title="link1">link1</a>
      <a target="_blank" title="link2">link2</a>
    </div>
    <div class="footer-copyright">
      Copyright © 2020 teamName
    </div>
  </footer>
</template>

<script>
export default {
  name: "PageFooter",
  data() {
    return {}
  },
  created() {

  },
  mounted() {

  },
  methods: {},
}
</script>

<style scoped>
.page-footer {
  padding: 40px 24px;
  text-align: center;
  font-size: 14px;
  height: 150px;
}

.footer-links {
  margin-bottom: 8px;
}

.footer-links a:not(:last-child) {
  margin-right: 40px;
}

.footer-links a {
  color: rgba(0, 0, 0, .45);
  transition: all .3s;
}

.footer-links a:hover {
  color: rgba(0, 0, 0, .65);
}

.footer-copyright {
  color: rgba(0, 0, 0, .45);
  font-size: 14px;
}
</style>
