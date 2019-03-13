<template>
  <layout-default>
    <div class="row flex-lg-nowrap">
      <div class="col">
        <e-panel title="Edit Article">
          <b-form>
            <div class="row">
              <div class="col">
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
              </div>
            </div>
            <div class="row">
              <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary" v-promise-btn @click="submit">Submit</button>
                <button type="button" class="btn btn-light" @click="form.reset()">Reset</button>

                <router-link to="/articles" class="btn btn-light">Cancel</router-link>
              </div>
            </div>
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
    this.fetchData()
  },

  watch: {
    '$route': 'fetchData'
  },

  methods: {
    fetchData (to) {
      this.loading = true

      const id = this.$route.params.id

      return articlesService.getById(id)
        .then(response => Object.assign(this.form, response.data))
        .catch(error => alert(error))
        .finally(() => this.loading = false)
    },

    submit () {
      const id = this.$route.params.id

      return this.form.callService(articlesService.update(id, this.form.data()))
        .then(() => alert('Updated.'))
        .catch(error => alert(error))
    }
  }
}
</script>
