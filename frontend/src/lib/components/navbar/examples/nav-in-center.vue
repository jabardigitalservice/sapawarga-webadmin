<template>
  <e-navbar class="px-lg-4" :title="'TITLE'" nav-in-center>
    <div slot="brand">
      <a class="e-logo mx-4" href="" @click.prevent>
        <span>Elements <small>stay simple</small></span>
      </a>
    </div>
    <div slot="collapse">
      <ul class="navbar-nav pt-3 pt-md-0">
        <li class="nav-item active">
          <a class="nav-link" href="" @click.prevent>Overview</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="" @click.prevent>Bootstrap</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="" @click.prevent>Pages</a>
        </li>
      </ul>
    </div>
    <div slot="actions">
      <button class="btn btn-success" type="button">
        <i class="fa fa-user-circle"></i>
        <span class="d-none d-md-inline-block">Morty Smith</span>
      </button>
    </div>
  </e-navbar>
</template>

<script>
  import ENavbar from '../index'

  export default {
    components: { ENavbar }
  }
</script>
