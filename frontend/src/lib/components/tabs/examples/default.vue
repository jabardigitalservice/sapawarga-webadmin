<template>
  <div class="card">
    <div class="card-body pt-2">
      <e-tabs>
        <b-tabs no-fade>
          <b-tab title="Home" active></b-tab>
          <b-tab>
            <template slot="title">
              Inbox <span class='badge badge-light ml-1'>2</span>
            </template>
          </b-tab>
          <b-tab title="Settings"></b-tab>
        </b-tabs>
      </e-tabs>
    </div>
  </div>
</template>

<script>
  import ETabs from '../index'

  export default {
    components: { ETabs }
  }
</script>
