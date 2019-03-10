<template>
  <div class="navbar-wrapper">
    <div class="container">
      <e-navbar class="navbar border-0 card" :title="'My Application'">
        <div slot="brand">
          <router-link to="/" class="e-logo mx-4">
            <span>My Application</span>
          </router-link>
        </div>

        <div slot="collapse">
          <ul class="navbar-nav pt-3 pt-md-0">
            <li class="nav-item">
              <router-link to="/home" class="nav-link">Home</router-link>
            </li>
            <li v-if="loggedIn" class="nav-item">
              <router-link to="/articles" class="nav-link">Articles</router-link>
            </li>
          </ul>
        </div>

        <div slot="actions">
          <ul class="navbar-nav flex-nowrap flex-row">
            <li class="nav-item d-none d-md-inline-block">
              <a class="nav-link" href=""> <i class="fa fa-bell"></i> </a>
            </li>

            <b-nav-item-dropdown right>
              <template slot="text"> <span class="d-none d-md-inline">Account</span> <span class="d-md-none fa fa-user-circle"></span> </template>
              <a class="dropdown-item d-md-none" href="">
                <div class="d-flex justify-content-between align-items-center"> <span>Alerts</span> <span class="badge badge-danger">3</span> </div>
              </a>
              <router-link v-if="loggedIn === false" class="dropdown-item" to="/register">Register</router-link>
              <router-link v-if="loggedIn === false" class="dropdown-item" to="/login">Login</router-link>
              <a v-if="loggedIn" href="#" class="dropdown-item" @click.prevent="logout">Logout</a>
            </b-nav-item-dropdown>
          </ul>

        </div>
      </e-navbar>
    </div>
  </div>
</template>

<script>
import authService from '@/services/auth.service'

import ENavbar from '@/lib/components/navbar'

export default {
  components: { ENavbar },

  computed: {
    loggedIn () {
      return this.$store.state.auth.currentUser.id !== null
    },
  },

  methods: {
    logout () {
      return authService.makeLogout()
        .then(() => this.$router.push('/'))
        .catch(error => alert(error))
    }
  }
}
</script>

<style lang="scss"></style>
