<template>
  <div>
    <el-row v-if="user.roles_active.id === 'staffKabkota'">
      <a :href="link" target="_blank">
        <img src="https://firebasestorage.googleapis.com/v0/b/sapawarga-staging.appspot.com/o/admin-banner-01.png?alt=media&token=3ad9f723-a397-48c4-9c8e-41e6cfbf5d6c" width="100%">
      </a>
    </el-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { getLink } from '@/api/temporary'

export default {
  data() {
    return {
      link: null
    }
  },

  computed: {
    ...mapGetters([
      'user'
    ])
  },

  mounted() {
    this.getUrlDownload()
  },

  methods: {
    async getUrlDownload() {
      const code = this.user.kabkota.code_bps

      this.link = await getLink(code)
    }
  }
}
</script>

<style>
#headline-news .el-card__header {
  background-color: #F56C6C;
  color: #FFFFFF;
  font-weight: bold;
}
#headline-news .el-card__body {
  background-color: #FDF6EC;
}
</style>
