<template>
  <div>
    <el-row>
      <el-carousel height="430px" indicator-position="outside" :autoplay="true" trigger="click">
        <el-carousel-item v-for="(item, index) in banners" :key="index">
          <img
            loading="lazy"
            :src="item"
            class="multiple-images"
          >
        </el-carousel-item>
      </el-carousel>
    </el-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { getLink } from '@/api/temporary'

export default {
  data() {
    return {
      link: null,
      bannerData: []
    }
  },

  computed: {
    ...mapGetters([
      'user',
      'banners'
    ])
  },

  mounted() {
    // this.getUrlDownload()
  },

  methods: {
    async getUrlDownload() {
      const code = this.user.kabkota ? this.user.kabkota.code_bps : ''

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
.multiple-images {
  width: 100%;
  height: 100%;
  display: block;
  border-radius: 7px;
  margin: auto;
}
</style>
