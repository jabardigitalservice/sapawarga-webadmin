<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="4">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.title" placeholder="Judul Usulan" />
          </el-form-item>
        </el-col>
        <el-col :span="4">
          <el-form-item style="margin-bottom: 0">
            <InputCategory v-model="listQuery.category_id" category-type="aspirasi" />
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
              <el-option value="5" label="Menunggu Persetujuan" />
              <el-option value="10" label="Dipublikasikan" />
              <el-option value="3" label="Ditolak" />

            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="8">
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
import InputCategory from '@/components/InputCategory'
import checkPermission from '@/utils/permission'

export default {
  components: { InputFilterArea, InputCategory },

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
