<template>
  <layout-default>
    <div class="row flex-lg-nowrap">
      <div class="col">
        <e-panel title="Create Article">
          <b-form @submit="submit" @reset="reset">
            <b-form-group label="Brand:">
              <b-form-input
                      type="text"
                      v-model="form.brand"
                      required
                      placeholder="Brand" />
            </b-form-group>

            <b-form-group label="Model:">
              <b-form-input
                      type="text"
                      v-model="form.model"
                      required
                      placeholder="Model" />
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
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
    fetchData () {
      this.loading = true

      articlesService.getList().then(response => {
        //
      }).catch(error => alert(error))
        .finally(() => this.loading = false)
    },

    submit () {
      //
    },

    reset () {
      //
    }
  }
}
</script>
