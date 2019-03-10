<template>
  <div class="card px-3">
    <e-tabs nested>
      <b-tabs no-fade>
        <b-tab title="Home" active>
          <ul class="nav">
            <li class="nav-item">
              <a href="#" class="nav-link" @click.prevent>
                <span>My Profile</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" @click.prevent>
                <span>Friends</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" @click.prevent>
                <span>News</span>
              </a>
            </li>
          </ul>
        </b-tab>
        <b-tab title="Bookmarks">
          <ul class="nav">
            <li class="nav-item">
              <a href="#" class="nav-link" @click.prevent>
                <span>Posts</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" @click.prevent>
                <span>People</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" @click.prevent>
                <span>Documents</span>
              </a>
            </li>
          </ul>
        </b-tab>
        <b-tab>
          <template slot="title">
            Messages <span class='badge badge-light ml-1'>2</span>
          </template>
          <ul class="nav">
            <li class="nav-item">
              <a href="#" class="nav-link" @click.prevent>
                <span>Inbox</span>
                <span class="badge badge-light">2</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" @click.prevent>
                <span>Sent</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" @click.prevent>
                <span>Drafts</span>
              </a>
            </li>
          </ul>
        </b-tab>
      </b-tabs>
    </e-tabs>
  </div>
</template>

<script>
  import ETabs from '../index'

  export default {
    components: { ETabs }
  }
</script>
