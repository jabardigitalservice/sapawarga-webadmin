<template>
  <div>
    <e-navbar class="mb-4"></e-navbar>

    <div class="container">
      <div class="e-content">
        <div class="row flex-lg-nowrap">
          <div class="col content-wrapper">
            <slot></slot>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ENavbar from '@/pages/include/Navbar'

export default {
  components: { ENavbar },
  data () {
    return {}
  }
}
</script>
