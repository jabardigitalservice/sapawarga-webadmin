<template>
  <div style="margin-bottom: 2rem">
    <el-form>
      <el-row :gutter="20">
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="6">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.name" placeholder="Cari Nama" @keyup.enter.native="submitSearch()" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="4">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.nik" placeholder="NIK" @keyup.enter.native="submitSearch" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="2">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.rw" placeholder="RW" :disabled="listQuery.kel_id === null && !roles" @keyup.enter.native="submitSearch" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="2">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.rt" placeholder="RT" :disabled="listQuery.kel_id === null && !roles" @keyup.enter.native="submitSearch" />
          </el-form-item>
        </el-col>
        <el-col :xs="24" :sm="24" :md="6">
          <el-button type="primary" size="small" @click="submitSearch">
            {{ $t('crud.search') }}
          </el-button>
          <el-button type="clear" size="small" @click="resetFilter">
            {{ $t('crud.reset') }}
          </el-button>
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import checkPermission from '@/utils/permission'

export default {
  props: {
    listQuery: {
      type: Object,
      default: null
    },
    isVerval: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      roles: checkPermission(['staffKel'])
    }
  },

  computed: {
    filterAreaParentId() {
      const authUser = this.$store.state.user

      if (checkPermission(['staffKabkota'])) {
        return parseInt(authUser.kabkota.code_bps)
      }

      if (checkPermission(['staffKec'])) {
        return parseInt(authUser.kecamatan.code_bps)
      }

      return null
    }
  },

  methods: {
    checkPermission,

    submitSearch() {
      this.$emit('submit-search')
    },

    resetFilter() {
      this.$emit('reset-search')
    },

    changeKabkota(id) {
      this.listQuery.domicile_kabkota_bps_id = id
    },

    changeKecamatan(id) {
      this.listQuery.domicile_kec_bps_id = id
    },

    changeKelurahan(id) {
      this.listQuery.domicile_kel_bps_id = id
    }
  }
}
</script>

