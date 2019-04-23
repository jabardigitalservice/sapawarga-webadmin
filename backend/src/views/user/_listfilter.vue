<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="4">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.name" placeholder="Nama Pengguna" />
          </el-form-item>
        </el-col>
        <el-col :span="4">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.phone" placeholder="Nomor Telepon" />
          </el-form-item>
        </el-col>
        <el-col :span="4">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.status"
              clearable
              filterable
              placeholder="Pilih Status"
              style="width: 100%"
            >
              <el-option value="10" label="Aktif" />
              <el-option value="1" label="Tidak Aktif" />
              <el-option value="0" label="Pending" />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="8">
          <input-filter-area
            :enable-kabkota="checkPermission(['admin', 'staffProv'])"
            :enable-kecamatan="checkPermission(['admin', 'staffProv', 'staffKabkota'])"
            :enable-kelurahan="checkPermission(['admin', 'staffProv', 'staffKabkota', 'staffKec'])"
            :parent-id="filterAreaParentId"
            @changeKabkota="changeKabkota"
            @changeKecamatan="changeKecamatan"
            @changeKelurahan="changeKelurahan"
          />
        </el-col>
        <el-col :span="4">
          <el-button type="primary" size="small" @click="submitSearch">
            Cari
          </el-button>
          <el-button type="primary" size="small" @click="resetFilter">
            Reset
          </el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import InputFilterArea from '@/components/InputFilterArea'

import checkPermission from '@/utils/permission'

export default {
  components: { InputFilterArea },

  props: {
    listQuery: {
      default: null
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
      this.listQuery.kabkota_id = id
    },

    changeKecamatan(id) {
      this.listQuery.kec_id = id
    },

    changeKelurahan(id) {
      this.listQuery.kel_id = id
    }
  }
}
</script>
