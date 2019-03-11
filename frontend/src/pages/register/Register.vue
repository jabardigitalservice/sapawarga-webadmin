<template>
  <layout-default>
    <div class="row">
      <div class="col-xs-12 col-sm-10 col-md-8 mx-auto">
        <e-panel title="Register">
          <b-alert variant="danger" :show="form.errors.any()" dismissible>Register failed.</b-alert>
          <b-alert variant="success" :show="success" dismissible>Register success, please check your email for confirm.</b-alert>

          <form>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Username</label>
              <div class="col-md-9">
                <b-input type="text" :state="form.getInputState('username')" v-model="form.username" placeholder="Username" />
                <b-form-invalid-feedback :state="form.getInputState('username')">
                  {{ form.errors.get('username') }}
                </b-form-invalid-feedback>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Email</label>
              <div class="col-md-9">
                <b-input type="text" :state="form.getInputState('email')" v-model="form.email" placeholder="Email" />
                <b-form-invalid-feedback :state="form.getInputState('email')">
                  {{ form.errors.get('email') }}
                </b-form-invalid-feedback>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Password</label>
              <div class="col-md-9">
                <b-input type="password" :state="form.getInputState('password')" v-model="form.password" placeholder="Password" />
                <b-form-invalid-feedback :state="form.getInputState('password')">
                  {{ form.errors.get('email') }}
                </b-form-invalid-feedback>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Confirm Password</label>
              <div class="col-md-9">
                <b-input type="password" :state="form.getInputState('password_confirm')" v-model="form.password_confirm" placeholder="Confirm Password" />
                <b-form-invalid-feedback :state="form.getInputState('password_confirm')">
                  {{ form.errors.get('email') }}
                </b-form-invalid-feedback>
              </div>
            </div>
            <hr class="mb-3">
            <div class="form-group row mb-0">
              <div class="col-md-10">
                <button type="button" class="btn btn-primary" v-promise-btn @click="makeRegister">Register</button>
              </div>
            </div>
          </form>
        </e-panel>
      </div>
    </div>
  </layout-default>
</template>

<script>
import Form from '@/lib/Form'

import authService from '@/services/auth.service'

import LayoutDefault from '@/pages/layouts/Default'
import EPanel from '@/lib/components/panel'

export default {
  components: {
    LayoutDefault,
    EPanel
  },

  data () {
    return {
      form: new Form({
        username: null,
        email: null,
        password: null,
        password_confirm: null
      }),
      success: false
    }
  },

  methods: {
    makeRegister () {
      return this.form.callService(authService, 'makeRegister')
        .then(() => {
          this.success = true
        })
        .catch(error => {
          if (error.status !== 422) {
            alert(error)
          }
        })
    }
  }
}
</script>
