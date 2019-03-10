<template>
  <div class="d-flex justify-content-between">
    <div class="card p-3" style="flex-grow: 1;">
      <e-navlist active-bg>
        <ul class="nav">
          <li class="nav-item">
            <a href="" class="nav-link" @click.prevent>
              <i class="fa fa-fw fa-home mr-1"></i>
              <span>Home</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link" @click.prevent>
              <i class="fa fa-fw fa-bookmark mr-1"></i>
              <span>Bookmarks</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link" @click.prevent>
              <i class="fa fa-fw fa-envelope mr-1"></i>
              <span>Messages</span>
              <span class="badge badge-light ml-1">4</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link" @click.prevent>
              <i class="fa fa-fw fa-cog mr-1"></i>
              <span>Settings</span>
            </a>
          </li>
        </ul>
      </e-navlist>
    </div>
    <div class="card py-3 px-2 ml-3" v-if="!noTooltips">
      <e-navlist active-bg>
        <ul class="nav">
          <li class="nav-item" v-b-tooltip.hover.right="'Home'">
            <a href="" class="nav-link" @click.prevent>
              <i class="fa fa-fw fa-home"></i>
            </a>
          </li>
          <li class="nav-item" v-b-tooltip.hover.right="'Bookmarks'">
            <a href="" class="nav-link" @click.prevent>
              <i class="fa fa-fw fa-bookmark"></i>
            </a>
          </li>
          <li class="nav-item" v-b-tooltip.hover.right="'Messages'">
            <a href="" class="nav-link" @click.prevent>
              <i class="fa fa-fw fa-envelope"></i>
            </a>
          </li>
          <li class="nav-item" v-b-tooltip.hover.right="'Settings'">
            <a href="" class="nav-link" @click.prevent>
              <i class="fa fa-fw fa-cog"></i>
            </a>
          </li>
        </ul>
      </e-navlist>
    </div>
  </div>
</template>

<script>
  import ENavlist from '../index'

  export default {
    components: { ENavlist },
    props: {
      noTooltips: Boolean
    }
  }
</script>
