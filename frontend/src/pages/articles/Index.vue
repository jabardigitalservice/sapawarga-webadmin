<template>
  <layout-default>
    <e-panel title="Articles">
      <b-table class="fa-sort-icons table-rounded mt-3 mb-0"
               :items="items"
               :fields="fields"
               responsive
               bordered>
      </b-table>
    </e-panel>
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
