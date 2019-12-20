<template>
  <el-tabs v-if="device==='mobile'" v-model="activeTab" tab-position="bottom" stretch @tab-click="handleClick">
    <el-tab-pane v-for="(menu, index) in arrMenu" :key="index" :label="menu.title" :name="menu.title">
      <span slot="label"><i :class="menu.iconClass" /></span>
    </el-tab-pane>
  </el-tabs>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data() {
    return {
      activeTab: 'User',
      arrMenu: [
        { title: 'User', iconClass: 'el-icon-news' },
        { title: 'Config', iconClass: 'el-icon-edit' },
        { title: 'Role', iconClass: 'el-icon-printer' },
        { title: 'Task', iconClass: 'el-icon-document' }
      ]
    }
  },

  computed: {
    ...mapGetters([
      'device'
    ])
  },

  methods: {
    handleClick(tab, event) {
    // @todo: Change route programmatically
      console.log('event triggered')
    }
  }
}
</script>

<style lang="scss" scoped>
@import "../../styles/variables.scss";

.el-tabs {
  left: 0;
  bottom: 0;
  width: 100%;
  overflow: hidden;
  position: fixed;
  z-index: $bottomBarZIndex;
  background-color: white;
}
</style>
