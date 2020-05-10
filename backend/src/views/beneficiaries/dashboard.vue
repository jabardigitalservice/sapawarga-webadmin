<template>
  <div class="app-container">
    <el-row>
      <el-col :lg="24">
        <!-- show statistics -->
        <DashboardStatistics :is-loading="isLoadingSummary" :summery="dataSummary" :filter="filter" />

        <button v-if="prevFilter.length" class="el-button el-button--primary el-button--small" @click="backDetail()">
          <i class="el-icon-arrow-left" /> Kembali ke Data {{ prevFilter.length-1 ? prevFilter[prevFilter.length-2].name : 'Utama' }}
        </button>
        <h3>Rekap Data {{ prevFilter.length ? prevFilter[prevFilter.length-1].name : '' }}</h3>
        <el-table v-loading="listLoading" :data="sortedList" border stripe highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="name" sortable="custom" :label="areaLabelByFilter" min-width="200px">
            <template slot-scope="{row}">
              <span style="cursor: pointer; color: blue" @click="openDetail(row.code_bps, row.rw, row.name)">{{ row.name }}</span>
            </template>
          </el-table-column>
          <el-table-column prop="data.approved" sortable="custom" :label="'Approval Kab/Kota'" min-width="180px">
            <template slot-scope="{row}">
              {{ formatThousands(row.data.approved_kabkota) }}
            </template>
          </el-table-column>
          <el-table-column prop="data.approved" sortable="custom" :label="'Approval Kec'" min-width="180px">
            <template slot-scope="{row}">
              {{ formatThousands(row.data.approved_kec) }}
            </template>
          </el-table-column>
          <el-table-column prop="data.approved" sortable="custom" :label="'Terverifikasi Kel/Desa/RW'" min-width="180px">
            <template slot-scope="{row}">
              {{ formatThousands(row.data.approved) }}
            </template>
          </el-table-column>
          <el-table-column prop="data.pending" sortable="custom" :label="$t('label.beneficiaries-unverified')" min-width="180px">
            <template slot-scope="{row}">
              {{ formatThousands(row.data.pending) }}
            </template>
          </el-table-column>
          <el-table-column prop="data.reject" sortable="custom" :label="$t('label.beneficiaries-reject')" min-width="180px">
            <template slot-scope="{row}">
              {{ formatThousands(getReject(row.data)) }}
            </template>
          </el-table-column>

        </el-table>

      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchDashboardSummary, fetchDashboardList } from '@/api/beneficiaries'
import { mapGetters } from 'vuex'
import DashboardStatistics from './components/DashboardStatistics'

export default {
  components: {
    DashboardStatistics
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
      list: null,
      total: 0,
      isLoadingSummary: true,
      dataSummary: null,
      listLoading: true,
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      },
      filter: {
        type: null,
        code_bps: null,
        rw: null
      },
      prevFilter: [],
      sort_prop: '',
      sort_order: 'ascending'
    }
  },
  computed: {
    ...mapGetters(['user']),
    areaLabelByFilter() {
      return 'Kabupaten / Kota'
    },
    sortedList() {
      const prop = this.sort_prop
      const order = this.sort_order
      const getApproved = this.getApproved
      const getPending = this.getPending
      const getReject = this.getReject
      function compare(a, b) {
        if (prop === 'data.approved') {
          if (getApproved(a.data) < getApproved(b.data)) {
            return order === 'ascending' ? -1 : 1
          }
          if (getApproved(a.data) > getApproved(b.data)) {
            return order === 'ascending' ? 1 : -1
          }
        } else if (prop === 'data.pending') {
          if (getPending(a.data) < getPending(b.data)) {
            return order === 'ascending' ? -1 : 1
          }
          if (getPending(a.data) > getPending(b.data)) {
            return order === 'ascending' ? 1 : -1
          }
        } else if (prop === 'data.reject') {
          if (getReject(a.data) < getReject(b.data)) {
            return order === 'ascending' ? -1 : 1
          }
          if (getReject(a.data) > getReject(b.data)) {
            return order === 'ascending' ? 1 : -1
          }
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
        return this.list.map((x) => x).sort(compare)
      } else {
        return []
      }
    }
  },
  created() {
    this.resetParams()
    this.getList()
    this.getSummary()
  },

  methods: {
    resetParams() {
      if (this.user.roles_active.id === 'staffProv' || this.user.roles_active.id === 'admin') {
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
      }
      if (this.user.kelurahan) {
        this.filter.type = 'kel'
        this.filter.code_bps = this.user.kelurahan.code_bps
      }
    },
    openDetail(code_bps, rw, name) {
      const prevFilter = {
        code_bps: this.filter.code_bps,
        type: this.filter.type,
        rw: this.filter.rw,
        name: name
      }
      this.filter.code_bps = code_bps
      this.filter.rw = rw
      if (this.filter.type === 'provinsi') {
        this.filter.type = 'kabkota'
      } else if (this.filter.type === 'kabkota') {
        this.filter.type = 'kec'
      } else if (this.filter.type === 'kec') {
        this.filter.type = 'kel'
      } else if (this.filter.type === 'kel') {
        this.filter.type = 'rw'
      } else {
        return
      }
      this.prevFilter.push(prevFilter)
      this.getSummary()
      this.getList()
    },
    backDetail() {
      if (this.prevFilter.length) {
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
      })
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
    },

    getTableRowNumbering(index) {
      return (index + 1)
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

    getApproved(data) {
      if (this.filter.type === 'provinsi' || this.filter.type === 'kabkota') {
        return data.approved_kabkota
      }
      if (this.filter.type === 'kec') {
        return data.approved_kabkota + data.approved_kec
      }
      if (this.filter.type === 'kel') {
        return data.approved_kabkota + data.approved_kec + data.approved
      }
      return data.approved_kabkota + data.approved_kec + data.approved
    },
    getPending(data) {
      if (this.filter.type === 'provinsi' || this.filter.type === 'kabkota') {
        return data.approved_kec + data.approved + data.pending
      }
      if (this.filter.type === 'kec') {
        return data.approved + data.pending
      }
      if (this.filter.type === 'kel') {
        return data.pending
      }
      return data.pending
    },
    getReject(data) {
      return data.rejected_kabkota + data.rejected_kec + data.rejected
    },
    getTotalBenefeciaries(data) {
      return this.getApproved(data) + this.getPending(data) + this.getReject(data)
    }
  }
}
</script>
