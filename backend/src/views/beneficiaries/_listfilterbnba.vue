<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10">
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="3">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.nama_krt" placeholder="Nama Lengkap" @keyup.enter.native="submitSearch()" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="3">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.nik" placeholder="NIK" @keyup.enter.native="submitSearch()" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="3">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.id_tipe_bansos"
              clearable
              filterable
              placeholder="Pilih Tipe Bansos"
              style="width: 100%"
            >
              <el-option value="1" :label="$t('label.beneficiaries-pkh')" />
              <el-option value="2" :label="$t('label.beneficiaries-bpnt-basicfood')" />
              <el-option value="3" :label="$t('label.beneficiaries-bpnt-expansion')" />
              <el-option value="4" :label="$t('label.beneficiaries-kemensos')" />
              <el-option value="5" :label="$t('label.beneficiaries-president')" />
              <el-option value="6" :label="$t('label.beneficiaries-province')" />
              <el-option value="7" :label="$t('label.beneficiaries-village-fund')" />
              <el-option value="8" :label="$t('label.beneficiaries-city')" />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col v-if="!roles" :xs="{span:24, tag:'mb-10'}" :sm="24" :md="7">
          <input-filter-area-bps
            :parent-id="filterAreaParentId"
            :kabkota-id="listQuery.kode_kab"
            :kec-id="listQuery.kode_kec"
            :kel-id="listQuery.kode_kel"
            :is-bnba-staffprov="true"
            @changeKabkota="changeKabkota"
            @changeKecamatan="changeKecamatan"
            @changeKelurahan="changeKelurahan"
          />
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="2">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.rw" placeholder="RW" :disabled="listQuery.kel_id === null && !roles" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="2">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.rt" placeholder="RT" :disabled="listQuery.kel_id === null && !roles" @change="submitSearch()" />
          </el-form-item>
        </el-col>
        <el-col :xs="24" :sm="24" :md="4">
          <el-button type="primary" size="small" @click="submitSearch">
            {{ $t('crud.search') }}
          </el-button>
          <el-button type="primary" size="small" @click="resetFilter">
            {{ $t('crud.reset') }}
          </el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import InputFilterAreaBps from '@/components/InputFilterAreaBps'

import checkPermission from '@/utils/permission'
import { RolesUser, CODE_BPS_BANDUNG } from '@/utils/constantVariable'

export default {
  components: { InputFilterAreaBps },

  props: {
    listQuery: {
      type: Object,
      default: null
    }
  },

  data() {
    return {
      CODE_BPS_BANDUNG,
      RolesUser,
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

      if (checkPermission([this.RolesUser.ADMIN, this.RolesUser.STAFFPROV])) {
        return parseInt(CODE_BPS_BANDUNG)
      }

      return null
    }
  },

  methods: {
    checkPermission,

    submitSearch() {
      this.$emit('submit-search')
      this.$emit('display-search', this.listQuery)
    },

    resetFilter() {
      this.$emit('reset-search')
    },

    changeKabkota(id) {
      this.listQuery.kode_kab = id
    },

    changeKecamatan(id) {
      this.listQuery.kode_kec = id
    },

    changeKelurahan(id) {
      this.listQuery.kode_kel = id
    }
  }
}
</script>

