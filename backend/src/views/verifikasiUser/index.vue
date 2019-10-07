<template>
  <div class="verification-container">
    <el-form
      ref="confirmForm"
      :model="confirmForm"
      class="verification-form"
      auto-complete="on"
      label-position="left"
    >
      <div class="title-container">
        <img :src="logo" alt="LOGO">
        <div v-if="!verificationStatus">
          <h4><b>Verifikasi Akun Berhasil</b></h4>
        </div>
        <div else>
          <h4><b>Verifikasi Akun Gagal</b></h4>
        </div>
      </div>
    </el-form>
  </div>
</template>

<script>
import { verificationAkun } from '@/api/verificationAkun'

export default {
  name: 'VerificationUser',
  components: { },
  data() {
    return {
      logo: require('@/assets/logo.png'),
      loading: false,
      confirmForm: {
        id: '',
        auth_key: ''
      },
      verificationStatus: false
    }
  },
  watch: {
    $route: {
      handler: function(route) {
        this.redirect = route.query && route.query.redirect
      },
      immediate: true
    }
  },
  created() {
    const id = this.$route.query && this.$route.query.id
    if (!id) { this.$router.push({ path: this.redirect || '/login' }) }
    this.verification(this.$route.query.id, this.$route.query.auth_key)
  },
  mounted() {
  },
  methods: {
    verification(id, auth_key) {
      verificationAkun({
        'id': id,
        'auth_key': auth_key
      }).catch(() => {
        this.verificationStatus = true
      })
    }
  }
}
</script>
