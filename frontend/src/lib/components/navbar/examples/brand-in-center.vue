<template>
  <e-navbar class="px-lg-4" :title="'TITLE'" brand-in-center>
    <div slot="brand">
      <a class="e-logo mx-4 my-2" href="" @click.prevent>
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
      <form class="form-inline">
        <div class="input-with-ico">
          <i class="input-ico fa fa-fw fa-search"></i>
          <input class="form-control form-control-rounded" type="search" placeholder="Search" style="max-width: 170px">
        </div>
      </form>
    </div>
  </e-navbar>
</template>

<script>
  import ENavbar from '../index'

  export default {
    components: { ENavbar }
  }
</script>
