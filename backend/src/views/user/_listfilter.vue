<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col>
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.name" placeholder="Nama Lengkap" />
          </el-form-item>
        </el-col>
        <el-col>
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.phone" placeholder="Nomor Telepon" />
          </el-form-item>
        </el-col>
        <el-col>
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
      </el-row>
      <div :class="(isActive) ? 'advance-filter-active' : 'advance-filter'" style="margin-top: 10px;">
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
        <el-row v-permission="['admin','staffProv']" :gutter="10" type="flex" style="margin-top: 10px">
          <el-col :span="10">
            <el-form-item>
              <span>Update Terakhir :</span>
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
          <el-col :span="14" class="filter-date">
            <span>Aktifitas Terakhir :</span>
            <el-row type="flex">
              <!--               <el-date-picker
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
              /> -->
              <el-col :span="10">
                <el-form-item>
                  <el-date-picker
                    v-model="start_start"
                    type="dates"
                    placeholder="Tanggal Mulai"
                    value-format="yyyy-MM-dd"
                  />
                </el-form-item>
              </el-col>
              <el-col :span="10">
                <el-form-item>
                  <el-date-picker
                    v-model="start_end"
                    type="dates"
                    placeholder="Tanggal Akhir"
                    value-format="yyyy-MM-dd"
                  />
                </el-form-item>
              </el-col>
            </el-row>
          </el-col>
        </el-row>
      </div>
      <el-row style="margin-top: 10px">
        <el-col>
          <el-button type="primary" size="small" style="float: right; margin: 2px;" @click="resetFilter">
            Reset
          </el-button>
          <el-button type="primary" size="small" style="float: right; margin: 2px;" @click="submitSearch">
            Cari
          </el-button>
          <el-button type="primary" size="small" style="float: left; margin: 2px;" @click="advanceFilter">
            <img src="@/assets/filter.svg" width="12" style="vertical-align: middle;">
            <span v-if="isActive">Sembunyikan Filter</span>
            <span v-else>Tambah Filter</span>
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
      start_start: '',
      start_end: '',
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
      this.date_range = ''
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
