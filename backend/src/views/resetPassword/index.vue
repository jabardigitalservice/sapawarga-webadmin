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
        <h4><b>Masukan Kata Sandi Baru Anda</b></h4>
      </div>
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

      <el-form-item prop="password_confirmation">
        <span class="svg-container">
          <svg-icon icon-class="password" />
        </span>
        <el-input
          :key="confirmPasswordType"
          ref="password_confirmation"
          v-model="loginForm.password_confirmation"
          :type="confirmPasswordType"
          placeholder="Ulangi Kata sandi"
          name="password_confirmation"
          auto-complete="on"
          @keyup.enter.native="handleLogin"
        />
        <span class="show-pwd" @click="showPwdConfirm">
          <svg-icon :icon-class="confirmPasswordType === 'password' ? 'eye' : 'eye-open'" />
        </span>
      </el-form-item>

      <el-button
        :loading="loading"
        type="primary"
        style="width:100%;margin-bottom:30px;"
        @click.native.prevent="handleLogin"
      >Ubah Kata Sandi</el-button>
    </el-form>
  </div>
</template>

<script>
export default {
  name: 'Login',
  components: { },
  data() {
    const validatePassword = (rule, value, callback) => {
      if (value.length < 1) {
        callback(new Error('Kata sandi harus diisi'))
      } else {
        callback()
      }
    }
    const passwordValid = (rule, value, callback) => {
      if (value.length > 1) {
        if (value !== this.$refs.password.value) {
          callback(new Error('Kata sandi tidak sama'))
        } else {
          callback()
        }
      }
    }
    return {
      logo: require('@/assets/logo.png'),
      loginForm: {
        password: '',
        password_confirmation: ''
      },
      loginRules: {
        password: [
          { required: true, trigger: 'blur', validator: validatePassword }
        ],
        password_confirmation: [
          {
            required: true,
            trigger: 'blur',
            validator: validatePassword
          },
          {
            validator: passwordValid,
            trigger: 'change'
          }
        ]
      },
      passwordType: 'password',
      confirmPasswordType: 'password',
      loading: false,
      showDialog: false,
      redirect: undefined
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
    const token = this.$route.query && this.$route.query.token
    if (!token) { this.$router.push({ path: this.redirect || '/login' }) }
  },
  mounted() {
    if (this.loginForm.password === '') {
      this.$refs.password.focus()
    } else if (this.loginForm.password_confirmation === '') {
      this.$refs.password_confirmation.focus()
    }
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

    showPwdConfirm() {
      if (this.confirmPasswordType === 'password') {
        this.confirmPasswordType = ''
      } else {
        this.confirmPasswordType = 'password'
      }
      this.$nextTick(() => {
        this.$refs.password_confirmation.focus()
      })
    },

    handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true
          this.$store
            .dispatch('user/login', this.loginForm)
            .then(() => {
              this.$router.push({ path: this.redirect || '/login' })
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
    }
  }
}
</script>
