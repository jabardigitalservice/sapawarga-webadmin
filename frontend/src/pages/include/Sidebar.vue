<template>
  <div class="e-sidebar col-12 col-lg-auto mb-3">
    <slot>
      <div class="card p-3">
        <e-navlist active-bg>
          <ul class="nav">
            <li class="nav-item">
              <router-link to="/home" class="nav-link px-2">
                <i class="fa fa-fw fa-bar-chart mr-1"></i>
                <span>Home</span>
              </router-link>
            </li>
          </ul>
        </e-navlist>
      </div>
    </slot>
    <slot name="nested"></slot>
  </div>
</template>

<script>
import ENavlist from '@/lib/components/navlist'

export default {
  components: { ENavlist }
}
</script>

<style lang="scss"></style>
