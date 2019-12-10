<template>
  <div>
    <el-row v-for="(element, index) in tableContentData" :key="index" :gutter="10">
      <el-col :xs="24" :sm="6">{{ element.title }} {{ device==='mobile'?':':'' }}</el-col>
      <el-col :xs="24" :sm="18">
        <a v-if="validUrl(element.content)" :href="element.content" target="_blank" class="link">{{ element.content }}</a>
        <span v-else>{{ element.content }}</span>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'DetailData',
  props: {
    tableContentData: {
      type: Array,
      default: null,
      require: true
    }
  },
  computed: {
    ...mapGetters([
      'device'
    ])
  },
  methods: {
    validUrl(str) {
      var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i') // fragment locator
      return !!pattern.test(str)
    }
  }
}
</script>

<style lang="scss" scoped>
.el-row {
  margin-bottom: 10px;

  &:last-child {
      margin-bottom: 0;
  }
}
</style>
