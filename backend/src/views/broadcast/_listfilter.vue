<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10">
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="6">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.title" placeholder="Judul Pesan" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="4">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.status"
              clearable
              filterable
              placeholder="Pilih Status"
              style="width: 100%"
            >
              <el-option value="10" :label="$t('label.status-published')" />
              <el-option value="5" :label="$t('label.status-scheduled')" />
              <el-option value="0" :label="$t('label.status-draft')" />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="8">
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
        <el-col :xs="24" :sm="24" :md="6">
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
import InputFilterArea from '@/components/InputFilterArea'

import checkPermission from '@/utils/permission'

export default {
  components: { InputFilterArea },

  props: {
    listQuery: {
      type: Object,
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

