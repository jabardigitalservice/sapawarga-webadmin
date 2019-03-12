<template>
  <layout-default>
    <div class="row flex-lg-nowrap">
      <div class="col">
        <e-panel title="Articles">
          <b-table class="fa-sort-icons table-rounded mt-3 mb-0"
                   :items="items"
                   :fields="fields"
                   :busy="loading"
                   responsive
                   bordered
                   show-empty>
            <template slot="empty">
              No data.
            </template>
          </b-table>
        </e-panel>
      </div>

      <div class="col-12 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="text-center px-xl-3">
              <router-link class="btn btn-success btn-block" to="/articles/create">New Article</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout-default>
</template>

<script>
import articlesService from '@/services/articles.service'

import LayoutDefault from '@/pages/layouts/Default'
import EPanel from '@/lib/components/panel'

const fields = [
  { key: 'id', label: 'ID', thClass: 'text-center', tdClass: 'text-center' },
  { key: 'brand', thClass: 'max-width', tdClass: 'text-nowrap' },
  { key: 'model', tdClass: 'text-nowrap', sortable: true }
]

export default {
  components: {
    LayoutDefault,
    EPanel
  },

  data () {
    return {
      loading: false,
      fields: fields,
      items: []
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
        this.items = response.data
      }).catch(error => alert(error))
        .finally(() => this.loading = false)
    }
  }
}
</script>
