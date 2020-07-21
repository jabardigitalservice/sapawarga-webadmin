<template>
  <div>
    <el-row v-if="user.roles_active.id === 'staffKabkota'">
      <el-carousel indicator-position="outside" :autoplay="true" trigger="click">
        <el-carousel-item v-for="(item, index) in bannerData" :key="index">
          <img :src="item" class="multiple-images">
        </el-carousel-item>
      </el-carousel>
      <!-- <a :href="link" target="_blank">
        <img src="https://firebasestorage.googleapis.com/v0/b/sapawarga-app.appspot.com/o/admin-banner-01.png?alt=media&token=2c606be5-7378-40ca-b147-f19b8b8539ea" width="100%">
      </a> -->
    </el-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { getLink } from '@/api/temporary'
import { PREFIX_FIREBASE_STORAGE } from '@/utils/constantVariable'

export default {
  data() {
    return {
      link: null,
      bannerData: [
        `${PREFIX_FIREBASE_STORAGE}banners%2Fbanner-1.png?alt=media&token=f8575a3e-8f16-491e-8d5b-ca78ca715c31`,
        `${PREFIX_FIREBASE_STORAGE}banners%2Fbanner-2.png?alt=media&token=d9472add-eafd-4c6d-87ee-c61c8f701d7d`
      ]
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
.multiple-images {
  width: 100%;
  height: 100%;
  display: block;
  border-radius: 7px;
  margin: auto;
}
</style>
