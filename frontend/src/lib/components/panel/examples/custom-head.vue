<template>
  <e-panel>
    <template slot="head">
      <div class="h6 font-weight-bold text-center">Custom Head</div>
      <hr>
    </template>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </e-panel>
</template>

<script>
  import EPanel from '../index'

  export default {
    components: { EPanel }
  }
</script>
