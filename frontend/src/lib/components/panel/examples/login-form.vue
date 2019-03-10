<template>
  <e-panel>
    <template slot="title">
      <div class="h6 text-center w-100 mb-2">Sign In / Login</div>
    </template>
    <form>
      <div class="form-group">
        <input type="email" class="form-control" placeholder="Email">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Password">
      </div>
      <div class="form-group d-flex justify-content-between align-items-center">
        <a href="#" class="text-muted btn btn-link" @click.prevent>Need Help?</a>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <div class="form-group text-center m-0">
        <div class="btn-group">
          <button type="button" class="btn btn-outline-secondary">
            <i class="fa fa-fw fa-twitter"></i>
          </button>
          <button type="button" class="btn btn-outline-secondary">
            <i class="fa fa-fw fa-facebook"></i>
          </button>
          <button type="button" class="btn btn-outline-secondary">
            <i class="fa fa-fw fa-github"></i>
          </button>
        </div>
      </div>
    </form>
  </e-panel>
</template>

<script>
  import EPanel from '../index'

  export default {
    components: { EPanel },
    data: function() {
      return {}
    }
  }
</script>
