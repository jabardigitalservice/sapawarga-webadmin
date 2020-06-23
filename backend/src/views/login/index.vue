<template>
  <div class="login-container">
    <el-form
      ref="loginForm"
      :model="loginForm"
      :rules="loginRules"
      class="login-form"
      auto-complete="on"
      label-position="left"
    >
      <div class="title-container">
        <img :src="logo" alt="LOGO">
      </div>

      <el-form-item prop="username">
        <span class="svg-container">
          <svg-icon icon-class="user" />
        </span>
        <el-input
          ref="username"
          v-model="loginForm.username"
          placeholder="Username"
          name="username"
          type="text"
          auto-complete="on"
        />
      </el-form-item>

      <el-form-item prop="password">
        <span class="svg-container">
          <svg-icon icon-class="password" />
        </span>
        <el-input
          :key="passwordType"
          ref="password"
          v-model="loginForm.password"
          :type="passwordType"
          placeholder="Kata sandi"
          name="password"
          auto-complete="on"
          @keyup.enter.native="handleLogin"
        />
        <span class="show-pwd" @click="showPwd">
          <svg-icon :icon-class="passwordType === 'password' ? 'eye' : 'eye-open'" />
        </span>
      </el-form-item>

      <el-button
        :loading="loading"
        type="primary"
        style="width:100%"
        @click.native.prevent="handleLogin"
      >{{ $t('label.login') }}</el-button>

      <hr class="line-separator">

      <h5 class="warning-text">{{ $t('label.call-admin-text') }}</h5>
      <el-button
        class="button-call-admin"
        size="large"
        style="width:100%"
        @click="callAdmin()"
      >
        <svg-icon icon-class="whatsapp" />
        {{ $t('label.call-admin') }}
      </el-button>
    </el-form>
  </div>
</template>

<script>

export default {
  name: 'Login',
  components: { },
  data() {
    const validateUsername = (rule, value, callback) => {
      if (value.length < 1) {
        callback(new Error('Username harus diisi'))
      } else {
        callback()
      }
    }
    const validatePassword = (rule, value, callback) => {
      if (value.length < 1) {
        callback(new Error('Kata sandi harus diisi'))
      } else {
        callback()
      }
    }
    return {
      logo: require('@/assets/logo.png'),
      loginForm: {
        username: '',
        password: ''
      },
      loginRules: {
        username: [
          { required: true, trigger: 'blur', validator: validateUsername }
        ],
        password: [
          { required: true, trigger: 'blur', validator: validatePassword }
        ]
      },
      passwordType: 'password',
      loading: false,
      showDialog: false,
      redirect: undefined,
      phone: process.env.VUE_APP_PHONE
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
    // window.addEventListener('storage', this.afterQRScan)
  },
  mounted() {
    if (this.loginForm.username === '') {
      this.$refs.username.focus
    } else if (this.loginForm.password === '') {
      this.$refs.password.focus
    }
  },
  destroyed() {
    // window.removeEventListener('storage', this.afterQRScan)
  },
  methods: {
    showPwd() {
      if (this.passwordType === 'password') {
        this.passwordType = ''
      } else {
        this.passwordType = 'password'
      }
      this.$nextTick(() => {
        this.$refs.password.focus()
      })
    },

    handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true
          this.$store
            .dispatch('user/login', this.loginForm)
            .then(async() => {
              this.$router.push({ path: '/profile' })
              this.loading = false
            })
            .catch(() => {
              this.loading = false
              this.$refs['loginForm'].resetFields()
            })
        } else {
          return false
        }
      })
    },

    callAdmin() {
      const link = 'https://s.id/HotlineSW'
      window.open(link, '_blank')
    }

  }
}
</script>
<style lang="scss" scoped>
.line-separator {
  margin: 25px 0;
  height:1px;
  border-width:0;
  background-color: #E0E0E0;
}
.title-container {
  margin-top: -50px;
}
.warning-text {
  color: #000000;
  font-size: 15px;
  line-height: 20px;
  word-spacing: 3px;
}
.button-call-admin {
  background: #219653;
  color: white;
}
.button-call-admin:hover {
  background: #41b674;
}
</style>
