<template>
  <e-navbar class="px-lg-4" :title="'TITLE'">
    <div slot="brand">
      <a class="e-logo mx-4" href="" @click.prevent>
        <span>Elements <small>stay simple</small></span>
      </a>
    </div>
    <div slot="collapse" class="d-md-flex">
      <ul class="navbar-nav mr-auto py-3 py-md-0">
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
      <form class="form-inline d-md-none d-lg-flex">
        <div class="input-with-ico">
          <i class="input-ico fa fa-fw fa-search"></i>
          <input class="form-control form-control-rounded" type="search" placeholder="Search">
        </div>
      </form>
    </div>
    <div slot="actions">
      <ul class="navbar-nav flex-nowrap flex-row">
        <li class="nav-item d-none d-md-inline-block">
          <a class="nav-link" href="" @click.prevent>
            <i class="fa fa-bell"></i>
          </a>
        </li>
        <b-nav-item-dropdown right>
          <template slot="text">
            <span class="d-none d-md-inline">Morty Smith</span>
            <span class="d-md-none fa fa-user-circle"></span>
          </template>
          <a class="dropdown-item d-md-none" href="" @click.prevent>
            <div class="d-flex justify-content-between align-items-center">
              <span>Alerts</span>
              <span class="badge badge-danger">3</span>
            </div>
          </a>
          <a class="dropdown-item" href="" @click.prevent>Profile</a>
          <a class="dropdown-item" href="" @click.prevent>Settings</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="" @click.prevent>Logout</a>
        </b-nav-item-dropdown>
      </ul>
    </div>
  </e-navbar>
</template>

<script>
  import ENavbar from '../index'

  export default {
    components: { ENavbar }
  }
</script>
