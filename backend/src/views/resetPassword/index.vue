<template>
  <div class="reset-password-container">
    <el-form
      v-if="!tokenExpired"
      ref="resetPasswordForm"
      :model="resetPasswordForm"
      :rules="resetPasswordRules"
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
          v-model="resetPasswordForm.password"
          :type="passwordType"
          placeholder="Kata sandi"
          name="password"
          auto-complete="on"
          @keyup.enter.native="handleResetPassword"
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
          v-model="resetPasswordForm.password_confirmation"
          :type="confirmPasswordType"
          placeholder="Ulangi Kata sandi"
          name="password_confirmation"
          auto-complete="on"
          @keyup.enter.native="handleResetPassword"
        />
        <span class="show-pwd" @click="showPwdConfirm">
          <svg-icon :icon-class="confirmPasswordType === 'password' ? 'eye' : 'eye-open'" />
        </span>
      </el-form-item>

      <el-button
        :loading="loading"
        type="primary"
        style="width:100%;margin-bottom:30px;"
        @click.native.prevent="handleResetPassword"
      >Ubah Kata Sandi</el-button>
    </el-form>
    <div v-else>
      <div class="title-container">
        <img :src="logo" alt="LOGO">
        <h4><b>Token Sudah Kedaluarsa</b></h4>
      </div>
    </div>
  </div>
</template>

<script>
import { checkToken, resetPassword } from '@/api/resetPassword'
import { Message } from 'element-ui'

export default {
  name: 'ResetPassword',
  components: { },
  data() {
    const validatePassword = (rule, value, callback) => {
      if (value.length < 1) {
        callback(new Error('Kata sandi harus diisi'))
      } else if (value.length < 5) {
        callback(new Error('Kata sandi minimal 5'))
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
      resetPasswordForm: {
        token: '',
        password: '',
        password_confirmation: ''
      },
      resetPasswordRules: {
        password: [
          {
            required: true,
            trigger: 'blur',
            validator: validatePassword
          },
          {
            validator: validatePassword,
            trigger: 'change'
          }
        ],
        password_confirmation: [
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
      tokenExpired: false,
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
    this.resetPasswordForm.token = token
    this.checkSessionToken(token)
  },
  mounted() {
    if (this.resetPasswordForm.password === '') {
      this.$refs.password.focus()
    } else if (this.resetPasswordForm.password_confirmation === '') {
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

    checkSessionToken(token) {
      checkToken({ 'token': token }).catch((data) => {
        this.tokenExpired = true
      })
    },

    handleResetPassword() {
      this.$refs.resetPasswordForm.validate(valid => {
        if (valid) {
          this.loading = true
          resetPassword(
            this.resetPasswordForm
          ).then((data) => {
            Message({
              message: 'Password berhasil dirubah',
              type: 'success',
              duration: 1 * 1000
            })
            setTimeout(() => {
              this.$router.go(-1)
            }, 1000)
            this.loading = false
            window.close()
            this.$router.push({ path: this.redirect || '/login' })
          }).catch((data) => {
            this.loading = false
            Message({
              message: 'Password gagal dirubah',
              type: 'error',
              duration: 1 * 1000
            })
          })
        } else {
          return false
        }
      })
    }
  }
}
</script>
