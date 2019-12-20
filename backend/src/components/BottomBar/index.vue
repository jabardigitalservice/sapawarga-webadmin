<template>
  <el-tabs v-model="activeTab" v-if="device==='mobile'" @tab-click="handleClick" tab-position="bottom" stretch>
    <el-tab-pane v-for="(menu, index) in arrMenu" :label="menu.title" :name="menu.title" :key="index">
      <span slot="label"><i :class="menu.iconClass"></i></span>
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
        {title: 'User', iconClass:'el-icon-news'},
        {title: 'Config', iconClass:'el-icon-edit'},
        {title: 'Role', iconClass:'el-icon-printer'},
        {title: 'Task', iconClass:'el-icon-document'}
      ]
    };
  },
  
  computed: {
    ...mapGetters([
      'device'
    ])
  },

  methods: {
    handleClick(tab, event) {
    //@todo: Change route programmatically
    console.log('event triggered')
    }
  }
};
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