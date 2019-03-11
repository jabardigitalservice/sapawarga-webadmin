<template>
  <layout-default>
    <div class="row">
      <div class="col-xs-12 col-sm-6 mx-auto">
        <div class="card">
          <div class="card-body">
            <b-alert variant="danger" :show="form.errors.has('username') || form.errors.has('email') || form.errors.has('password')" dismissible>Register failed.</b-alert>

            <form>
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Username</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" v-model="form.username" placeholder="Username">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Email</label>
                <div class="col-md-9">
                  <input type="email" class="form-control" v-model="form.email" placeholder="Email">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Password</label>
                <div class="col-md-9">
                  <input type="password" class="form-control" v-model="form.password"  placeholder="Password">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Confirm Password</label>
                <div class="col-md-9">
                  <input type="password" class="form-control" v-model="form.password_confirm"  placeholder="Confirm Password">
                </div>
              </div>
              <hr class="mb-3">
              <div class="form-group row mb-0">
                <div class="col-md-10">
                  <button type="button" class="btn btn-primary" v-promise-btn @click="makeRegister">Register</button>
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
        email: null,
        password: null,
        password_confirm: null
      })
    }
  },

  methods: {
    makeRegister () {
      return this.form.callService(authService, 'makeRegister')
        .then(() => {
          alert('Success')
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
