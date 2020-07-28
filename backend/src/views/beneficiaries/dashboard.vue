<template>
  <div class="app-container">
    <el-row>
      <el-col :lg="24">
        <el-dropdown size="large" trigger="click" placement="bottom-end" split-button type="primary" class="dropdown" @command="handleCommand">
          {{ $t('beneficiaries.show-stage') }} <b>{{ tahapDisplay }}</b>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item v-for="item in listTahap" :key="item.value" :command="{label: item.label, value: item.value}">{{ item.label }}</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>

        <DashboardTitle :is-dashboard="true" />

        <DashboardStatistics
          :is-loading="isLoadingSummary"
          :summary="dataSummary"
          :filter="filter"
        />

        <!-- upload data manual -->
        <!-- check if user.kabkota.code_bps is not equal CODE_BPS_SUMEDANG OR if role STAFFKABKOTA AND user kabkota equal CODE_BPS_SUMEDANG -->
        <!-- <template v-if="user.kabkota.code_bps !== CODE_BPS_SUMEDANG || (checkPermission([RolesUser.STAFFKABKOTA]) && user.kabkota.code_bps === CODE_BPS_SUMEDANG)">
          <UploadDataManual v-if="checkPermission([RolesUser.STAFFKABKOTA, RolesUser.STAFFKEC])" />
        </template> -->

        <template v-if="!isLoadListUser">
          <el-card class="box-card" style="margin-bottom: 10px">
            <el-form>
              <el-row :gutter="10">
                <template v-if="!roles">
                  <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="3">Filter Data</el-col>
                  <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="12">
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
                </template>
                <el-col :xs="{ span:24, tag:'mb-10' }" :sm="24" :md="3">
                  <json-excel
                    class="btn btn-default"
                    :data="sortedList"
                    :fields="exportFields"
                    worksheet="Data"
                    name="sapawarga-dashboard-bansos.xls"
                  >
                    <el-button type="success" icon="el-icon-download">
                      Export Data
                    </el-button>
                  </json-excel>
                </el-col>
              </el-row>
            </el-form>
          </el-card>
        </template>

        <template v-else>
          <ListFilterUsers :list-query.sync="listQueryUsers" @submit-search="getListUsers" @reset-search="resetFilterUsers" />
        </template>

        <button
          v-if="prevFilter.length"
          class="el-button el-button--primary el-button--small"
          @click="backDetail(prevFilter)"
        >
          <i class="el-icon-arrow-left" />
          Kembali ke Data {{ prevFilter.length-1 ? prevFilter[prevFilter.length-2].name : 'Utama' }}
        </button>

        <template v-if="!isLoadListUser">
          <h3>Rekap Data {{ prevFilter.length ? prevFilter[prevFilter.length-1].name : '' }}</h3>
          <el-table
            v-loading="listLoading"
            :data="sortedList"
            border
            stripe
            highlight-current-row
            style="width: 100%"
            @sort-change="changeSort"
          >
            <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

            <el-table-column
              prop="name"
              sortable="custom"
              :label="areaLabelByFilter"
              min-width="200px"
            >
              <template slot-scope="{row}">
                <span
                  style="cursor: pointer; color: blue"
                  @click="openDetail(row.code_bps, row.rw, row.name, row)"
                >{{ row.name }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="data.approved"
              align="right"
              sortable="custom"
              :label="$t('label.beneficiaries-verified-rw')"
              min-width="180px"
            >
              <template slot-scope="{row}">
                <span
                  v-if="getApproved(row.data)"
                  style="float: left"
                >({{ formatNumber(percentage(getApproved(row.data), getTotalBenefeciaries(row.data))) }}%)</span>
                {{ formatThousands(getApproved(row.data)) }}
              </template>
            </el-table-column>
            <el-table-column
              prop="data.pending"
              align="right"
              sortable="custom"
              :label="$t('label.beneficiaries-unverified')"
              min-width="180px"
            >
              <template slot-scope="{row}">
                <span
                  v-if="getPending(row.data)"
                  style="float: left"
                >({{ formatNumber(percentage(getPending(row.data), getTotalBenefeciaries(row.data))) }}%)</span>
                {{ formatThousands(getPending(row.data)) }}
              </template>
            </el-table-column>
            <el-table-column
              prop="data.reject"
              align="right"
              sortable="custom"
              :label="$t('label.beneficiaries-reject')"
              min-width="180px"
            >
              <template slot-scope="{row}">
                <span
                  v-if="getReject(row.data)"
                  style="float: left"
                >({{ formatNumber(percentage(getReject(row.data), getTotalBenefeciaries(row.data))) }}%)</span>
                {{ formatThousands(getReject(row.data)) }}
              </template>
            </el-table-column>
            <el-table-column
              prop="data_baru.total"
              align="right"
              sortable="custom"
              :label="$t('label.beneficiaries-newdata')"
              min-width="180px"
            >
              <template slot-scope="{row}">
                <span
                  v-if="row.data_baru && row.data_baru.total"
                  style="float: left"
                >({{ formatNumber(percentage(row.data_baru.total, getTotalBenefeciaries(row.data))) }}%)</span>
                {{ row.data_baru ? formatThousands(row.data_baru.total) : '-' }}
              </template>
            </el-table-column>
          </el-table>
        </template>

        <template v-else>
          <!-- show list users -->
          <ListUserVerification ref="listUserVerification" :list-query-domicile="listQueryUsers" />
        </template>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { formatNumber } from '@/utils/formatNumber'
import { fetchDashboardSummary, fetchDashboardList, fetchCurrentTahap } from '@/api/beneficiaries'
import { RolesUser, CODE_BPS_SUMEDANG } from '@/utils/constantVariable'
import { mapGetters } from 'vuex'
import DashboardStatistics from './components/DashboardStatistics'
// import UploadDataManual from './components/UploadDataManual/index'
import checkPermission from '@/utils/permission'
import InputFilterAreaBps from '@/components/InputFilterAreaBps'
import JsonExcel from 'vue-json-excel'
import DashboardTitle from './components/DashboardTitle'
import ListUserVerification from './components/ListUserVerification'
import ListFilterUsers from './components/_listFilterUsers'

export default {
  components: {
    InputFilterAreaBps,
    JsonExcel,
    DashboardStatistics,
    // UploadDataManual,
    DashboardTitle,
    ListUserVerification,
    ListFilterUsers
  },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '3': 'success',
        '2': 'danger',
        '1': 'warning'
      }
      return statusMap[status]
    }
  },
  props: {
    roleId: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      CODE_BPS_SUMEDANG,
      RolesUser,
      list: null,
      total: 0,
      isLoadingSummary: true,
      dataSummary: null,
      listLoading: true,
      listTahap: [],
      tahapDisplay: null,
      roles: checkPermission(['staffKel']),
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      },
      filter: {
        tahap: null,
        type: null,
        code_bps: null,
        rw: null
      },
      listQuery: {
        kode_kab: null,
        kode_kec: null,
        kode_kel: null
      },
      prevFilter: [],
      exportFields: {},
      sort_prop: 'data.approved',
      sort_order: 'descending',
      isLoadListUser: false,
      listQueryUsers: {
        nik: null,
        domicile_kec_bps_id: null,
        domicile_kel_bps_id: null,
        domicile_rw: null,
        domicile_rt: null,
        tahap: null
      }
    }
  },
  computed: {
    ...mapGetters(['user']),
    filterAreaParentId() {
      const authUser = this.$store.state.user

      if (checkPermission(['staffKabkota'])) {
        return parseInt(authUser.kabkota.code_bps)
      }

      if (checkPermission(['staffKec'])) {
        return parseInt(authUser.kecamatan.code_bps)
      }

      return null
    },
    areaLabelByFilter() {
      switch (this.filter.type) {
        case 'provinsi':
          return this.$t('label.area-kabkota')
        case 'kabkota':
          return this.$t('label.area-kec')
        case 'kec':
          return this.$t('label.area-kel')
        case 'kel':
          return this.$t('label.area-rw')
        case 'rw':
          return this.$t('label.area-rt')
      }
      return this.$t('label.area')
    },
    sortedList() {
      const prop = this.sort_prop
      const order = this.sort_order
      const getApproved = this.getApproved
      const getPending = this.getPending
      const getReject = this.getReject
      const getTotalBenefeciaries = this.getTotalBenefeciaries
      const percentage = this.percentage
      const getCompareOrder = this.getCompareOrder
      function compare(a, b) {
        if (prop === 'data.approved') {
          return getCompareOrder(
            percentage(getApproved(a.data), getTotalBenefeciaries(a.data)),
            percentage(getApproved(b.data), getTotalBenefeciaries(b.data)),
            order
          )
        } else if (prop === 'data_baru.total') {
          var a_data_baru_total = a.data_baru ? a.data_baru.total || 0 : 0
          var b_data_baru_total = b.data_baru ? b.data_baru.total || 0 : 0
          return getCompareOrder(
            percentage(a_data_baru_total, getTotalBenefeciaries(a.data)),
            percentage(b_data_baru_total, getTotalBenefeciaries(b.data)),
            order
          )
        } else if (prop === 'data.pending') {
          return getCompareOrder(
            percentage(getPending(a.data), getTotalBenefeciaries(a.data)),
            percentage(getPending(b.data), getTotalBenefeciaries(b.data)),
            order
          )
        } else if (prop === 'data.reject') {
          return getCompareOrder(
            percentage(getReject(a.data), getTotalBenefeciaries(a.data)),
            percentage(getReject(b.data), getTotalBenefeciaries(b.data)),
            order
          )
        } else {
          if (a[prop] < b[prop]) {
            return order === 'ascending' ? -1 : 1
          }
          if (a[prop] > b[prop]) {
            return order === 'ascending' ? 1 : -1
          }
        }
        return 0
      }
      if (this.list) {
        return this.list.map(x => x).sort(compare)
      } else {
        return []
      }
    }
  },
  async created() {
    await this.getStep()
    this.resetParams()
    this.getList()
    this.getSummary()
  },

  methods: {
    checkPermission,
    formatNumber,
    handleCommand(command) {
      this.listQueryUsers.tahap = command.value
      this.filter.tahap = command.value
      this.tahapDisplay = command.label
      this.getList()
      this.getSummary()

      if (this.$refs.listUserVerification) {
        this.getListUsers()
      }
    },

    async getStep() {
      await fetchCurrentTahap().then(response => {
        this.listQueryUsers.tahap = response.data.current_tahap_verval
        this.filter.tahap = response.data.current_tahap_verval
        this.tahapDisplay = this.$t('beneficiaries.stage') + this.filter.tahap
        for (let i = 1; i <= this.filter.tahap; i++) {
          const data = {
            value: i,
            label: this.$t('beneficiaries.stage') + i
          }
          this.listTahap.push(data)
        }
      })
    },

    getCompareOrder(data1, data2, order) {
      if (data1 < data2) {
        return order === 'ascending' ? -1 : 1
      }
      if (data1 > data2) {
        return order === 'ascending' ? 1 : -1
      }
    },
    percentage(val, denom) {
      if (denom) {
        return (val / denom) * 100
      }
      return 0
    },
    resetParams() {
      if (
        this.user.roles_active.id === 'staffProv' ||
        this.user.roles_active.id === 'admin'
      ) {
        this.filter.type = 'provinsi'
        this.filter.code_bps = '32'
      }
      if (this.user.kabkota) {
        this.filter.type = 'kabkota'
        this.filter.code_bps = this.user.kabkota.code_bps
      }
      if (this.user.kecamatan) {
        this.filter.type = 'kec'
        this.filter.code_bps = this.user.kecamatan.code_bps
        // set list query users
        this.listQueryUsers.domicile_kec_bps_id = this.user.kecamatan.code_bps
      }
      if (this.user.kelurahan) {
        this.filter.type = 'kel'
        this.filter.code_bps = this.user.kelurahan.code_bps
        // set list query users
        this.listQueryUsers.domicile_kel_bps_id = this.user.kelurahan.code_bps
      }
    },
    openDetail(code_bps, rw, name, row) {
      this.isLoadListUser = false

      const prevFilter = {
        code_bps: this.filter.code_bps,
        type: this.filter.type,
        rw: this.filter.rw,
        name: name,
        tahap: this.filter.tahap
      }
      this.filter.code_bps = code_bps
      this.filter.rw = rw
      if (this.filter.type === 'provinsi') {
        this.filter.type = 'kabkota'
      } else if (this.filter.type === 'kabkota') {
        this.filter.type = 'kec'
        // set list query users
        this.listQueryUsers.domicile_kec_bps_id = code_bps
      } else if (this.filter.type === 'kec') {
        this.filter.type = 'kel'
        // set list query users
        this.listQueryUsers.domicile_kel_bps_id = code_bps || 'no_data'
      } else if (this.filter.type === 'kel') {
        this.filter.type = 'rw'
        // set list query users
        this.listQueryUsers.domicile_rw = rw || 'no_data'
      } else if (this.filter.type === 'rw') {
        // show list users
        this.isLoadListUser = true
        // set list query users
        this.listQueryUsers.domicile_rt = row.rt || 'no_data'
      } else {
        return
      }
      this.prevFilter.push(prevFilter)
      this.getSummary()
      this.getList()
    },
    backDetail(value) {
      if (this.prevFilter.length) {
        this.isLoadListUser = false
        this.filter = this.prevFilter.pop()
        this.getSummary()
        this.getList()
      }
    },
    // get summary statistics
    getSummary() {
      this.isLoadingSummary = true
      fetchDashboardSummary(this.filter).then(response => {
        this.dataSummary = response.data
        this.isLoadingSummary = false
      })
    },
    getList() {
      this.listLoading = true
      fetchDashboardList(this.filter).then(response => {
        this.list = response.data
        this.listLoading = false
        this.loadExportFields()
      })
    },
    getListUsers() {
      this.$refs.listUserVerification.getList()
    },
    resetFilterUsers() {
      this.listQueryUsers.nik = null
      this.$refs.listUserVerification.getList()
    },

    loadExportFields() {
      this.exportFields = {}
      this.exportFields[this.areaLabelByFilter] = 'name'
      // this.exportFields[this.$t('label.beneficiaries-verified-kabkota')] = 'data.approved_kabkota'
      // this.exportFields['Persentase (1) %'] = {
      //   field: 'data',
      //   callback: (data) => {
      //     return this.percentage(data.approved_kabkota, this.getTotalBenefeciaries(data))
      //   }
      // }
      // this.exportFields[this.$t('label.beneficiaries-verified-kec')] = 'data.approved_kec'
      // this.exportFields['Persentase (2) %'] = {
      //   field: 'data',
      //   callback: (data) => {
      //     return this.percentage(data.approved_kec, this.getTotalBenefeciaries(data))
      //   }
      // }
      // this.exportFields[this.$t('label.beneficiaries-verified-kel')] = 'data.approved_kel'
      // this.exportFields['Persentase (3) %'] = {
      //   field: 'data',
      //   callback: (data) => {
      //     return this.percentage(data.approved_kel, this.getTotalBenefeciaries(data))
      //   }
      // }
      this.exportFields[this.$t('label.beneficiaries-verified-rw')] = {
        field: 'data',
        callback: data => {
          return this.getApproved(data)
        }
      }
      this.exportFields['Persentase Terverifikasi %'] = {
        field: 'data',
        callback: data => {
          return this.formatNumber(
            this.percentage(
              this.getApproved(data),
              this.getTotalBenefeciaries(data)
            )
          )
        }
      }
      this.exportFields[this.$t('label.beneficiaries-unverified')] = {
        field: 'data',
        callback: data => {
          return this.getPending(data)
        }
      }
      this.exportFields['Persentase Belum Terverifikasi %'] = {
        field: 'data',
        callback: data => {
          return this.formatNumber(
            this.percentage(
              this.getPending(data),
              this.getTotalBenefeciaries(data)
            )
          )
        }
      }
      this.exportFields[this.$t('label.beneficiaries-reject')] = {
        field: 'data',
        callback: data => {
          return this.getReject(data)
        }
      }
      this.exportFields['Persentase Ditolak %'] = {
        field: 'data',
        callback: data => {
          return this.formatNumber(
            this.percentage(
              this.getReject(data),
              this.getTotalBenefeciaries(data)
            )
          )
        }
      }
      this.exportFields[this.$t('label.beneficiaries-newdata')] =
        'data_baru.total'
      this.exportFields['Persentase Data Usulan Baru %'] = {
        callback: row => {
          return this.formatNumber(
            this.percentage(
              row.data_baru.total,
              this.getTotalBenefeciaries(row.data)
            )
          )
        }
      }
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
    },

    getTableRowNumbering(index) {
      return index + 1
    },

    formatThousands(value, prefix) {
      if (value) {
        const number_string = value.toString()
        const split = number_string.split(',')
        const modulo = split[0].length % 3
        let rupiah = split[0].substr(0, modulo)
        const thousand = split[0].substr(modulo).match(/\d{3}/gi)

        if (thousand) {
          const separator = modulo ? '.' : ''
          rupiah += separator + thousand.join('.')
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah
        return rupiah
      } else {
        return '-'
      }
    },

    changeSort(e) {
      this.sort_prop = e.prop
      this.sort_order = e.order
    },

    changeKabkota(id) {
      this.listQuery.kode_kab = id
      if (id && id !== '') {
        this.openDetail(id)
      } else {
        this.backDetail()
      }
    },

    changeKecamatan(id) {
      this.listQuery.kode_kec = id
      if (id && id !== '') {
        this.openDetail(id)
      } else {
        this.backDetail()
      }
    },

    changeKelurahan(id) {
      this.listQuery.kode_kel = id
      if (id && id !== '') {
        this.openDetail(id)
      } else {
        this.backDetail()
      }
    },

    getApproved(data) {
      return (
        data.approved +
        data.rejected_kel +
        data.approved_kel +
        data.rejected_kec +
        data.approved_kec +
        data.rejected_kabkota +
        data.approved_kabkota
      )
    },
    getPending(data) {
      return data.pending
    },
    getReject(data) {
      return data.rejected
    },
    getTotalBenefeciaries(data) {
      return (
        this.getApproved(data) + this.getPending(data) + this.getReject(data)
      )
    },
    open() {
      this.$alert(this.$t('label.beneficiaries-dashboard-alert'), {
        confirmButtonText: 'OK',
        type: 'warning'
      })
    }
  }
}
</script>
<style lang="scss" scope>
.button-step {
  padding: 13px 40px;
}
.dropdown {
  margin-top: 15px;
  margin-bottom: 100px;
  display: block;
  float: right;
}
</style>
