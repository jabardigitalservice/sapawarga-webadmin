<template>
  <div>
    <div v-if="isMonitoringBnba">
      <h2 class="dashboard-title">{{ $t('label.beneficiaries-monitoring-main-title') }}</h2>
      <div class="warn-content-warning">
        <p>
          <span>
            <i class="el-icon-info" />
          </span>
          <span>{{ $t('label.beneficiaries-monitoring-info') }}</span>
        </p>
      </div>
    </div>
    <div v-if="isDashboard">
      <h2 class="dashboard-title">{{ $t('label.beneficiaries-statistic-title') }}</h2>
      <div class="warn-content-warning">
        <p class="title">
          <span>
            <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
          </span>
          <span>{{ $t('label.beneficiaries-notes-display') }}</span>
          <span
            v-if="user.roles_active.id === 'staffProv' || user.roles_active.id === 'admin'"
          >{{ $t('label.beneficiaries-note-jabar') }}</span>
          <span
            v-else-if="user.roles_active.id === 'staffKabkota'"
          >{{ $t('label.beneficiaries-note-kabkota') }}</span>
          <span
            v-else-if="user.roles_active.id === 'staffKec'"
          >{{ $t('label.beneficiaries-note-kec') }}</span>
          <span
            v-else-if="user.roles_active.id === 'staffKel'"
          >{{ $t('label.beneficiaries-note-kel') }}</span>
        </p>
        <p class="content">{{ $t('label.beneficiaries-note-content') }}</p>
      </div>
    </div>
    <div v-if="isBnba">
      <h2 class="dashboard-title">{{ $t('label.beneficiaries-note-bnba-title') }}</h2>
      <div class="warn-content-warning">
        <p class="title">
          <span>
            <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
          </span>
          <span>{{ $t('label.beneficiaries-notes-display-bnba') }}</span>
          <span
            v-if="user.roles_active.id === 'staffProv' || user.roles_active.id === 'admin'"
          >{{ $t('label.beneficiaries-note-jabar') }}</span>
          <span
            v-else-if="user.roles_active.id === 'staffKabkota'"
          >{{ $t('label.beneficiaries-note-kabkota') }}</span>
          <span
            v-else-if="user.roles_active.id === 'staffKec'"
          >{{ $t('label.beneficiaries-note-kec') }}</span>
          <span
            v-else-if="user.roles_active.id === 'staffKel'"
          >{{ $t('label.beneficiaries-note-kel') }}</span>
        </p>
        <p class="content">{{ $t('label.beneficiaries-note-bnba-content') }}</p>
      </div>
    </div>
    <div v-if="isVerification">
      <h2 class="dashboard-title">{{ $t('label.beneficiaries-note-verification-title') }}</h2>
      <div class="warn-content-warning">
        <p class="title">
          <span>
            <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
          </span>
          <span>{{ $t('label.beneficiaries-notes-display-verification') }}</span>
          <span
            v-if="user.roles_active.id === 'staffProv' || user.roles_active.id === 'admin'"
          >{{ $t('label.beneficiaries-note-jabar') }}</span>
          <span
            v-else-if="user.roles_active.id === 'staffKabkota'"
          >{{ $t('label.beneficiaries-note-kabkota') }}</span>
          <span
            v-else-if="user.roles_active.id === 'staffKec'"
          >{{ $t('label.beneficiaries-note-kec') }}</span>
          <span
            v-else-if="user.roles_active.id === 'staffKel'"
          >{{ $t('label.beneficiaries-note-kel') }}</span>
        </p>
        <p class="content">{{ $t('label.beneficiaries-note-verification-content') }}</p>
      </div>
    </div>
    <div v-if="listType === 'approved'">
      <div v-if="rolesKel">
        <h2 class="dashboard-title">{{ $t('label.beneficiaries-note-approved-title') }}</h2>
        <div class="warn-content-warning">
          <p class="title">
            <span>
              <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
            </span>
            <span>{{ $t('label.beneficiaries-notes-display-approved') }}</span>
          </p>
          <p class="content">{{ $t('label.beneficiaries-note-approved-content') }}</p>
        </div>
      </div>
      <div v-if="rolesKec">
        <h2 class="dashboard-title">{{ $t('label.beneficiaries-note-approved-title-kec') }}</h2>
        <div class="warn-content-warning">
          <p class="title">
            <span>
              <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
            </span>
            <span>{{ $t('label.beneficiaries-notes-display-approved-kec') }}</span>
          </p>
          <p class="content">{{ $t('label.beneficiaries-note-approved-content-kec') }}</p>
        </div>
      </div>
      <div v-if="rolesKabkota">
        <h2 class="dashboard-title">{{ $t('label.beneficiaries-note-approved-title-kabkota') }}</h2>
        <div class="warn-content-warning">
          <p class="title">
            <span>
              <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
            </span>
            <span>{{ $t('label.beneficiaries-notes-display-approved-kabkota') }}</span>
          </p>
          <p class="content">{{ $t('label.beneficiaries-note-approved-content-kabkota') }}</p>
        </div>
      </div>
    </div>
    <div v-if="listType === 'pending'">
      <div v-if="rolesKel">
        <h2 class="dashboard-title">{{ $t('label.beneficiaries-note-pending-title') }}</h2>
        <div class="warn-content-warning">
          <p class="title">
            <span>
              <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
            </span>
            <span>{{ $t('label.beneficiaries-notes-display-pending') }}</span>
          </p>
          <p class="content">{{ $t('label.beneficiaries-note-pending-content') }}</p>
        </div>
      </div>
      <div v-if="rolesKec">
        <h2 class="dashboard-title">{{ $t('label.beneficiaries-note-pending-title-kec') }}</h2>
        <div class="warn-content-warning">
          <p class="title">
            <span>
              <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
            </span>
            <span>{{ $t('label.beneficiaries-notes-display-pending-kec') }}</span>
          </p>
          <p class="content">{{ $t('label.beneficiaries-note-pending-content-kec') }}</p>
        </div>
      </div>
      <div v-if="rolesKabkota">
        <h2 class="dashboard-title">{{ $t('label.beneficiaries-note-pending-title-kabkota') }}</h2>
        <div class="warn-content-warning">
          <p class="title">
            <span>
              <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
            </span>
            <span>{{ $t('label.beneficiaries-notes-display-pending-kabkota') }}</span>
          </p>
          <p class="content">{{ $t('label.beneficiaries-note-pending-content-kabkota') }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { RolesUser } from '@/utils/constantVariable'
import checkPermission from '@/utils/permission'
import { mapGetters } from 'vuex'
export default {
  props: {
    isMonitoringBnba: {
      type: Boolean,
      default: false
    },
    isDashboard: {
      type: Boolean,
      default: false
    },
    isBnba: {
      type: Boolean,
      default: false
    },
    isVerification: {
      type: Boolean,
      default: false
    },
    listType: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      rolesKel: checkPermission([RolesUser.STAFFKEL]),
      rolesKec: checkPermission([RolesUser.STAFFKEC]),
      rolesKabkota: checkPermission([RolesUser.STAFFKABKOTA])
    }
  },
  computed: {
    ...mapGetters(['user', 'roles'])
  }
}
</script>
<style lang="scss" scoped>
.warn-content-warning {
  background: #fff3d2;
  border: 1.5px solid rgba(226, 194, 124, 0.938);
  border-radius: 5px;
  padding: 0.5rem 1.5rem;
  word-spacing: 0.05rem;
  color: black;
  margin-bottom: 25px;

  p {
    margin: 10px 0;
  }

  .title {
    font-weight: 600;
  }

  .content {
    padding-left: 1.5rem;
    line-height: 1.4;
  }

  .link {
    text-decoration: underline;
    cursor: pointer;
    color: white !important;
  }
}
</style>
