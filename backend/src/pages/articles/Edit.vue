<template>
  <layout-default>
    <div class="row flex-lg-nowrap">
      <div class="col">
        <e-panel title="Create Article">
          <b-form>
            <b-form-group label="Brand:">
              <b-form-input
                      type="text"
                      v-model="form.brand"
                      placeholder="Brand" />
            </b-form-group>

            <b-form-group label="Model:">
              <b-form-input
                      type="text"
                      v-model="form.model"
                      placeholder="Model" />
            </b-form-group>

            <b-button type="button" variant="primary" v-promise-btn @click="submit">Submit</b-button>
            <b-button type="button" variant="danger" @click="form.reset()">Reset</b-button>

            <router-link to="/articles" class="btn btn-light">Cancel</router-link>
          </b-form>
        </e-panel>
      </div>
    </div>
  </layout-default>
</template>

<script>
import articlesService from '@/services/articles.service'

import Form from '@/lib/Form'

import LayoutDefault from '@/pages/layouts/Default'
import EPanel from '@/lib/components/panel'

export default {
  components: {
    LayoutDefault,
    EPanel
  },

  data () {
    return {
      loading: false,
      form: new Form({
        brand: null,
        model: null
      })
    }
  },

  created () {
    //
  },

  watch: {
    // '$route': 'fetchData'
  },

  methods: {
    submit () {
      return this.form.callService(articlesService, 'create')
        .then(() => alert('Created.'))
        .catch(error => alert(error))
    }
  }
}
</script>
