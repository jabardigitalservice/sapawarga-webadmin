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
      items: []
    }
  },

  methods: {
    getList () {
      articlesService.getList().then(response => {
        this.items = response.data
      }).catch(error => alert(error))
    }
  },

  mounted() {
    this.getList()
  }
}
</script>
