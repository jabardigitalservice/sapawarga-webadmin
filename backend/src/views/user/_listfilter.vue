<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-collapse accordion>
        <el-row :gutter="10" type="flex">
          <el-col>
            <el-form-item style="margin-bottom: 0">
              <el-input v-model="listQuery.name" placeholder="Nama Lengkap" />
            </el-form-item>
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
        <el-collapse-item title="" id="user-filter">
          <template slot="title">
            <el-button class="more-btn" type="primary" size="small">
              Advance Filter
            </el-button>
          </template>
          <el-row :gutter="10" type="flex">
            <el-col :span="8">
              <el-form-item style="margin-bottom: 0">
                <el-input v-model="listQuery.phone" placeholder="Nomor Telepon" />
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item style="margin-bottom: 0">
                <el-select
                  v-model="listQuery.status"
                  clearable
                  filterable
                  placeholder="Pilih Status"
                  style="width: 100%"
                >
                  <el-option value="10" label="Aktif" />
                  <el-option value="0" label="Tidak Aktif" />
                </el-select>
              </el-form-item>
            </el-col>
            <el-col v-permission="['admin','staffProv']" :span="8">
              <el-form-item style="margin-bottom: 0">
                <el-select
                  v-model="listQuery.profile_completed"
                  clearable
                  filterable
                  placeholder="Pilih Kelengkapan Profile"
                  style="width: 100%"
                >
                  <el-option value="true" label="Lengkap" />
                  <el-option value="false" label="Tidak Lengkap" />
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>
          <el-row :gutter="10" type="flex" style="margin-top: 10px">
            <el-col :span="24">
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
        </el-collapse-item>
      </el-collapse>
    </el-form>
  </el-card>
</template>

<script>
import InputFilterArea from '@/components/InputFilterArea'
import permission from '@/directive/permission/index.js'
import checkPermission from '@/utils/permission'

export default {
  components: { InputFilterArea },
  directives: { permission },
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

<style lang="scss" scoped>
  .more-btn{
    float:right;
    border:none;
    margin-right:.5rem;
  }

  .el-collapse-item__arrow {
    display: none;
  }
</style>