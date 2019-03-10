<template>
  <layout-default>
    <div class="row">
      <div class="col-xs-12 col-sm-6 mx-auto">
        <div class="card">
          <div class="card-body">
            <b-alert variant="danger" dismissible>The password is invalid.</b-alert>

            <form onsubmit="return false;">
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
        email: null,
        password: null
      })
    }
  },

  methods: {
    makeLogin () {
      return this.form.callService(authService, 'makeLogin')
        .then(() => this.$router.push('/'))
        .catch(error => alert(error))
    }
  }
}
</script>
