<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10">
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="6">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.name" :placeholder="$t('users.users-fullname')" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="6">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.username" :placeholder="$t('users.users-username')" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="6">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.phone" :placeholder="$t('users.users-phone')" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="6">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.status"
              clearable
              filterable
              :placeholder="$t('label.status-select')"
              style="width: 100%"
            >
              <el-option value="10" :label="$t('label.active')" />
              <el-option value="0" :label="$t('label.inactive')" />
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
      <div :class="(isActive) ? 'advance-filter-active' : 'advance-filter'" style="margin-top: 10px;">
        <el-row :gutter="10" style="margin-top: 10px">
          <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="24">
            <input-filter-area
              :parent-id="filterAreaParentId"
              :kabkota-id="listQuery.kabkota_id"
              :kec-id="listQuery.kec_id"
              :kel-id="listQuery.kel_id"
              @changeKabkota="changeKabkota"
              @changeKecamatan="changeKecamatan"
              @changeKelurahan="changeKelurahan"
            />
          </el-col>
        </el-row>
        <el-row v-permission="['admin','staffProv']" :gutter="10">
          <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="8">
            <el-form-item style="margin-bottom: 0">
              <span>{{ $t('users.users-last-update') }} :</span>
              <el-select
                v-model="listQuery.profile_completed"
                clearable
                filterable
                :placeholder="$t('users.users-option-profile')"
                style="width: 100%"
              >
                <el-option value="true" :label="$t('users.users-profile-complete')" />
                <el-option value="false" :label="$t('users.users-profile-incomplete')" />
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="8">
            <el-form-item style="margin-bottom: 0">
              <span>{{ $t('users.users-last-activities') }} :</span>
              <el-date-picker
                v-model="listQuery.last_access_start"
                type="date"
                :placeholder="$t('label.start-date')"
                value-format="yyyy-MM-dd"
                class="last-access-start"
              />
            </el-form-item>
          </el-col>
          <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="8">
            <el-form-item style="margin-bottom: 0">
              <span v-if="device === 'desktop'">&nbsp;</span>
              <el-date-picker
                v-model="listQuery.last_access_end"
                type="date"
                :placeholder="$t('label.end-date')"
                value-format="yyyy-MM-dd"
                class="last-access-end"
              />
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <el-row style="margin-top: 10px">
        <el-col>
          <el-button type="primary" size="small" style="float: right; margin: 2px;" @click="resetFilter">
            {{ $t('crud.reset') }}
          </el-button>
          <el-button type="primary" size="small" style="float: right; margin: 2px;" @click="submitSearch">
            {{ $t('crud.search') }}
          </el-button>
          <el-button v-permission="['admin', 'staffProv', 'staffKabkota', 'staffKec']" type="primary" size="small" style="float: left; margin: 2px;" @click="advanceFilter">
            <img src="@/assets/filter.svg" width="12" style="vertical-align: middle;">
            <span v-if="isActive">{{ $t('users.users-filter-hide') }}</span>
            <span v-else>{{ $t('users.users-filter-add') }}</span>
          </el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import InputFilterArea from '@/components/InputFilterArea'
import permission from '@/directive/permission/index.js'
import checkPermission from '@/utils/permission'
import { mapGetters } from 'vuex'

export default {
  components: { InputFilterArea },
  directives: { permission },
  props: {
    listQuery: {
      type: Object,
      default: null
    }
  },

  data() {
    return {
      isActive: false
    }
  },

  computed: {
    filterAreaParentId() {
      const authUser = this.$store.state.user

      if (checkPermission(['staffKabkota'])) {
        return parseInt(authUser.kabkota_id)
      }

      if (checkPermission(['staffKec'])) {
        return parseInt(authUser.kec_id)
      }

      return null
    },

    ...mapGetters([
      'device'
    ])

  },

  methods: {
    checkPermission,

    dateChange() {
      this.listQuery.last_access_start = this.date_range[0]
      this.listQuery.last_access_end = this.date_range[1]
    },

    submitSearch() {
      this.$emit('submit-search')
    },

    resetFilter() {
      this.$emit('reset-search')
    },

    changeKabkota(id) {
      this.listQuery.kabkota_id = id
    },

    changeKecamatan(id) {
      this.listQuery.kec_id = id
    },

    changeKelurahan(id) {
      this.listQuery.kel_id = id
    },

    advanceFilter() {
      if (this.isActive) {
        this.isActive = false
      } else {
        this.isActive = true
      }
    }
  }
}
</script>

<style>
  .advance-filter-active {
    display: block;
  }
  .advance-filter {
    display: none;
  }
  .last-access-start {
    width: 100% !important;
  }
  .last-access-end {
    width: 100% !important;
  }
</style>
