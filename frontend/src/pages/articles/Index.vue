<template>
  <layout-default>
    <e-panel title="Articles">
      Article Index
    </e-panel>
  </layout-default>
</template>

<script>
import articlesService from '@/services/articles.service'

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
