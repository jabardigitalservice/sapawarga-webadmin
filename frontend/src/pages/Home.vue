<template>
  <layout-default>
    <e-panel title="Welcome to My Application">
      Your homepage here.
    </e-panel>
  </layout-default>
</template>

<script>
import LayoutDefault from '@/pages/layouts/Default'
import EPanel from '@/lib/components/panel'

export default {
  components: {
    LayoutDefault,
    EPanel
  },

  data () {
    return {
      //
    }
  }
}
</script>
