<template>
  <div>
    <el-row v-if="user.roles_active.id === 'staffKabkota'" id="headline-news">
      <el-card class="box-card">
        <div slot="header">
          <span>Informasi Terbaru</span>
        </div>
        <div class="text item">
          <strong>Senin, 27 April 2020</strong> Unduh dokumen BNBA Penerima Bantuan Sosial Non DTKS untuk Kabupaten/Kota <a :href="link" target="_blank" style="text-decoration: underline">di sini</a>.
        </div>
      </el-card>
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
