<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col>
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.name" placeholder="Nama Lengkap" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-button type="primary" size="small" @click="advanceFilter">
            <span v-if="isActive">Sembunyikan Filter</span>
            <span v-else>Tambah Filter</span>
          </el-button>
          <el-button type="primary" size="small" @click="submitSearch">
            Cari
          </el-button>
          <el-button type="primary" size="small" @click="resetFilter">
            Reset
          </el-button>
        </el-col>
      </el-row>
      <div :class="(isActive) ? 'advance-filter-active' : 'advance-filter'" style="margin-top: 10px;">
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
        <el-row :gutter="10" type="flex" style="margin-top: 10px">
          <el-col class="filter-last-activity" :span="4">
            <span>Aktifitas Terakhir :</span>
          </el-col>
          <el-col v-permission="['admin','staffProv']">
            <el-date-picker
              v-model="date_range"
              type="daterange"
              style="width: -webkit-fill-available;"
              align="right"
              unlink-panels
              range-separator="To"
              value-format="yyyy-MM-dd"
              start-placeholder="Tanggal mulai"
              end-placeholder="Tanggal akhir"
              :picker-options="pickerOptions"
              @change="dateChange"
            />
          </el-col>
        </el-row>
      </div>
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

  data() {
    return {
      date_range: '',
      pickerOptions: {
        shortcuts: [{
          text: 'Last week',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: 'Last month',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: 'Last 3 months',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
            picker.$emit('pick', [start, end])
          }
        }]
      },
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
    }
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
</style>
