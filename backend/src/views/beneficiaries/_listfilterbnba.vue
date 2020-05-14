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
              <el-option value="1" label="PKH" />
              <el-option value="2" label="BPNT" />
              <el-option value="3" label="BPNT Perluasan" />
              <el-option value="4" label="Bansos Tunai (Kemensos)" />
              <el-option value="5" label="Bansos Presiden Sembako (BODEBEK)" />
              <el-option value="6" label="Bansos Provinsi" />
              <el-option value="7" label="Dana Desa" />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col v-if="!roles" :xs="{span:24, tag:'mb-10'}" :sm="24" :md="7">
          <input-filter-area-bps
            :parent-id="filterAreaParentId"
            :kabkota-id="listQuery.kode_kab"
            :kec-id="listQuery.kode_kec"
            :kel-id="listQuery.kode_kel"
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
      this.listQuery.kode_kab = id
      this.submitSearch()
    },

    changeKecamatan(id) {
      this.listQuery.kode_kec = id
      this.submitSearch()
    },

    changeKelurahan(id) {
      this.listQuery.kode_kel = id
      this.submitSearch()
    }
  }
}
</script>

