<template>
  <div class="login-container">
    <el-form
      ref="confirmForm"
      :model="confirmForm"
      class="login-form"
      auto-complete="on"
      label-position="left"
    >
      <div class="title-container">
        <img :src="logo" alt="LOGO">
        <h4><b>Aktifkan Akun Anda</b></h4>
      </div>
      <el-button
        :loading="loading"
        type="primary"
        style="width:100%;margin-bottom:30px;"
        @click.native.prevent="handleLogin"
      >Aktifkan Akun</el-button>
    </el-form>
  </div>
</template>

<script>
export default {
  name: 'VerifikasiUser',
  components: { },
  data() {
    return {
      logo: require('@/assets/logo.png'),
      loading: false,
      confirmForm: {
        id: '',
        auth_key: ''
      },
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
    const auth_key = this.$route.query && this.$route.query.auth_key
    if (!auth_key) { this.$router.push({ path: this.redirect || '/login' }) }
    this.confirmForm.id = this.$route.query.id
    this.confirmForm.auth_key = this.$route.query.auth_key
  },
  mounted() {
  },
  methods: {

  }
}
</script>
