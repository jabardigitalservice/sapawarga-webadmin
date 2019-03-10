<template>
  <div class="e-navlist" :class="classNames">
    <slot>
      <ul class="nav">
        <li class="nav-item active">
          <a href="#" class="nav-link" @click.prevent>
            <span>Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" @click.prevent>
            <span>Bookmarks</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" @click.prevent>
            <span>Messages</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" @click.prevent>
            <span>Settings</span>
          </a>
        </li>
      </ul>
    </slot>
  </div>
</template>

<script>
  export default {
    props: {
      activeBg: {
        type: Boolean,
        default: false
      },
      activeBold: {
        type: Boolean,
        default: false
      }
    },
    data: function() {
      return {
        classNames: {
          'e-navlist--active-bg': this.activeBg,
          'e-navlist--active-bold': this.activeBold
        }
      }
    }
  }
</script>

<style lang="scss">
  @import "../../scss/bootstrap/variables";

  $nav-color: $gray-600;
  $nav-active-bg-color: $nav-pills-link-active-color;
  $nav-active-bg-background: $nav-pills-link-active-bg;

  .e-navlist {

    .nav {
      display: flex;
      flex-flow: column nowrap;
    }

    .nav-item:not(:last-child) {
      margin-bottom: 3px;
    }

    .nav-link {

      &.disabled {
        opacity: 0.5;
      }
    }
  }

  .e-navlist.e-navlist--active-bg {

    .nav-link {
      color: $nav-color;
      background-color: transparent;
      padding: 0.5rem;
      border-radius: .25em;
      white-space: nowrap;

      transition: background-color 0.15s linear;
    }

    .active > .nav-link,
    .nav-link.active,
    .nav-link:hover {
      color: $nav-active-bg-color;
      background-color: $nav-active-bg-background;
    }
  }

  .e-navlist.e-navlist--active-bold {

    .nav-link {
      color: $body-color;
      // padding: 0.5rem;
    }

    .active > .nav-link,
    .nav-link.active {
      font-weight: bold;
    }
  }
</style>
