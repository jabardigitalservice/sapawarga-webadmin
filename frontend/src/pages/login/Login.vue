<template>
  <layout-default>
    <div class="row">
      <div class="col-xs-12 col-sm-6 mx-auto">
        <div class="card">
          <div class="card-body">
            <b-alert variant="danger" :show="form.errors.has('username') || form.errors.has('password')" dismissible>Login failed.</b-alert>

            <form>
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Username</label>
                <div class="col-md-9">
                  <b-input type="text" v-model="form.username" placeholder="Username" />
                  <b-form-invalid-feedback :state="! form.errors.has('username')">
                    {{ form.errors.get('username') }}
                  </b-form-invalid-feedback>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Password</label>
                <div class="col-md-9">
                  <b-input type="password" v-model="form.password" placeholder="Password" />
                  <b-form-invalid-feedback :state="! form.errors.has('password')">
                    {{ form.errors.get('password') }}
                  </b-form-invalid-feedback>
                </div>
              </div>
              <hr class="mb-3">
              <div class="form-group row mb-0">
                <div class="col-md-10">
                  <button type="button" class="btn btn-primary" v-promise-btn @click="makeLogin">Login</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </layout-default>
</template>

<script>
import Form from '@/lib/Form'

import authService from '@/services/auth.service'

import LayoutDefault from '@/pages/layouts/Default'

export default {
  components: {
    LayoutDefault
  },

  data () {
    return {
      form: new Form({
        username: null,
        password: null
      })
    }
  },

  methods: {
    makeLogin () {
      return this.form.callService(authService, 'makeLogin')
        .then(() => this.$router.push('/'))
        .catch(error => {
          if (error.status !== 422) {
            alert(error)
          }
        })
    }
  }
}
</script>
