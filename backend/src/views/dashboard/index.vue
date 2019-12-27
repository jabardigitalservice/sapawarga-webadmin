<template>
  <div class="dashboard-container">
    <component :is="currentRole" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import adminDashboard from './admin'
import editorDashboard from './editor'
import leaderDashboard from './leader'
import { RolesUser } from '@/utils/constantVariabel'

export default {
  name: 'Dashboard',
  components: {
    adminDashboard,
    editorDashboard,
    leaderDashboard
  },
  data() {
    return {
      currentRole: 'adminDashboard'
    }
  },
  computed: {
    ...mapGetters([
      'roles'
    ])
  },
  created() {
    if (this.roles.includes(RolesUser.ADMIN) || this.roles.includes(RolesUser.STAFFPROV) ||
    this.roles.includes(RolesUser.STAFFKABKOTA)) {
      this.currentRole
    } else if (this.roles.includes(RolesUser.LEADER)) {
      this.currentRole = 'leaderDashboard'
    } else {
      this.currentRole = 'editorDashboard'
    }
  }
}
</script>
