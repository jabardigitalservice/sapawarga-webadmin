<template>
  <div v-loading.fullScreen.lock="fullScreenLoading" class="app-container">
    <!-- <el-row v-if="user.roles_active.id === 'staffKabkota' || user.roles_active.id === 'staffKec'">
      <el-button type="text" @click="exportAll">
        <img
          src="https://firebasestorage.googleapis.com/v0/b/sapawarga-app.appspot.com/o/admin-banner-01.png?alt=media&token=2c606be5-7378-40ca-b147-f19b8b8539ea"
          width="100%"
        >
      </el-button>
    </el-row> -->

    <el-row>
      <el-col :sm="24" :md="12">
        <h3>{{ `${ $t('label.beneficiaries-download-search') } ${ areaLabelByFilter }` }}</h3>
      </el-col>
      <el-col :sm="24" :md="12">
        <el-button class="button-history float-right" type="success" plain @click="dialogTableVisible = true">{{ $t('beneficiaries.download-history') }}</el-button>
      </el-col>
    </el-row>

    <el-row>
      <el-card class="box-card" style="margin-bottom: 10px" :xs="24">
        <el-form>
          <el-row :gutter="10">
            <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="24">
              <el-form-item style="margin-bottom: 0">
                <el-input
                  v-model="listQuery.search"
                  :placeholder="`${$t('label.beneficiaries-download-search-area')} ${areaLabelByFilter}`"
                  clearable
                />
              </el-form-item>
            </el-col>
          </el-row>
        </el-form>
      </el-card>
      <el-col :span="24">
        <el-card class="box-card">
          <div slot="header">
            <el-row :gutter="10">
              <el-col :xs="24" :md="21">
                <span>{{ `${ $t('label.beneficiaries-download-list') } ${ areaLabelByFilter }` }}</span>
              </el-col>
              <el-col v-if="user.roles_active.id === 'staffKabkota' || user.roles_active.id === 'staffKec'" :xs="24" :md="3">
                <el-button
                  class="float-right"
                  type="success"
                  plain
                  icon="el-icon-download"
                  @click="exportBySubdistrict"
                >{{ $t('crud.export') }}</el-button>
              </el-col>
            </el-row>
          </div>
          <div class="text item">
            <el-table
              v-loading="listLoading"
              :data="sortedList.filter(data => !listQuery.search || data.name.toLowerCase().includes(listQuery.search.toLowerCase()))"
              border
              stripe
              highlight-current-row
              style="width: 100%"
              @sort-change="changeSort"
              @selection-change="selectChange"
            >
              <el-table-column type="selection" align="center" width="55" />
              <el-table-column
                type="index"
                width="50"
                align="center"
                :index="getTableRowNumbering"
              />
              <el-table-column
                prop="name"
                sortable="custom"
                :label="areaLabelByFilter"
                min-width="200px"
              >
                <template slot-scope="{row}">
                  <span>{{ row.name }}</span>
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
                    v-if="row.data.approved"
                    style="float: left"
                  >({{ formatNumber(percentage(row.data.approved, getTotalBenefeciaries(row.data))) }}%)</span>
                  {{ row.data.approved | currency }}
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
                    v-if="row.data.pending"
                    style="float: left"
                  >({{ formatNumber(percentage(row.data.pending, getTotalBenefeciaries(row.data))) }}%)</span>
                  {{ row.data.pending | currency }}
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
                  {{ getReject(row.data) | currency }}
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
                  <span v-if="row.data_baru">{{ row.data_baru.total | currency }}</span>
                </template>
              </el-table-column>
            </el-table>
          </div>
        </el-card>
      </el-col>
    </el-row>
    <el-dialog width="70%" :visible.sync="dialogTableVisible">
      <span slot="title" class="dialog-title">{{ $t('beneficiaries.download-history-verval') }}</span>
      <DialogDownloadHistory :source="'verval'" />
    </el-dialog>
  </div>
</template>

<script>
import { formatNumber } from '@/utils/formatNumber'
import { fetchDashboardList, fetchCurrentTahap } from '@/api/beneficiaries'
import { exportBansos } from '@/api/bansos'
import { mapGetters } from 'vuex'
import checkPermission from '@/utils/permission'
import Swal from 'sweetalert2'
import { Loading } from 'element-ui'
import DialogDownloadHistory from '../beneficiaries/components/DialogDownloadHistory'

export default {
  components: { DialogDownloadHistory },
  data() {
    return {
      dialogTableVisible: false,
      fullScreenLoading: false,
      list: null,
      total: 0,
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
      listQuery: {
        kode_kab: null,
        kode_kec: null,
        kode_kel: null,
        search: null
      },
      prevFilter: [],
      exportFields: {},
      sort_prop: 'data.approved',
      sort_order: 'descending',
      selectionQuery: {
        kode_kec: null,
        tahap_bantuan: null
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
      const getPending = this.getPending
      const getReject = this.getReject
      const getTotalBenefeciaries = this.getTotalBenefeciaries
      const percentage = this.percentage
      function compare(a, b) {
        if (prop === 'data.approved_kabkota') {
          if (
            percentage(a.data.approved_kabkota, getTotalBenefeciaries(a.data)) <
            percentage(b.data.approved_kabkota, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? -1 : 1
          }
          if (
            percentage(a.data.approved_kabkota, getTotalBenefeciaries(a.data)) >
            percentage(b.data.approved_kabkota, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? 1 : -1
          }
        } else if (prop === 'data.approved_kec') {
          if (
            percentage(a.data.approved_kec, getTotalBenefeciaries(a.data)) <
            percentage(b.data.approved_kec, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? -1 : 1
          }
          if (
            percentage(a.data.approved_kec, getTotalBenefeciaries(a.data)) >
            percentage(b.data.approved_kec, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? 1 : -1
          }
        } else if (prop === 'data.approved_kel') {
          if (
            percentage(a.data.approved_kel, getTotalBenefeciaries(a.data)) <
            percentage(b.data.approved_kel, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? -1 : 1
          }
          if (
            percentage(a.data.approved_kel, getTotalBenefeciaries(a.data)) >
            percentage(b.data.approved_kel, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? 1 : -1
          }
        } else if (prop === 'data.approved') {
          if (
            percentage(a.data.approved, getTotalBenefeciaries(a.data)) <
            percentage(b.data.approved, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? -1 : 1
          }
          if (
            percentage(a.data.approved, getTotalBenefeciaries(a.data)) >
            percentage(b.data.approved, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? 1 : -1
          }
        } else if (prop === 'data_baru.total') {
          var a_data_baru_total = a.data_baru ? a.data_baru.total || 0 : 0
          var b_data_baru_total = b.data_baru ? b.data_baru.total || 0 : 0
          if (
            percentage(a_data_baru_total, getTotalBenefeciaries(a.data)) <
            percentage(b_data_baru_total, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? -1 : 1
          }
          if (
            percentage(a_data_baru_total, getTotalBenefeciaries(a.data)) >
            percentage(b_data_baru_total, getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? 1 : -1
          }
        } else if (prop === 'data.pending') {
          if (
            percentage(getPending(a.data), getTotalBenefeciaries(a.data)) <
            percentage(getPending(b.data), getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? -1 : 1
          }
          if (
            percentage(getPending(a.data), getTotalBenefeciaries(a.data)) >
            percentage(getPending(b.data), getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? 1 : -1
          }
        } else if (prop === 'data.reject') {
          if (
            percentage(getReject(a.data), getTotalBenefeciaries(a.data)) <
            percentage(getReject(b.data), getTotalBenefeciaries(b.data))
          ) {
            return order === 'ascending' ? -1 : 1
          }
          if (
            percentage(getReject(a.data), getTotalBenefeciaries(a.data)) >
            percentage(getReject(b.data), getTotalBenefeciaries(b.data))
          ) {
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
        return this.list.map(x => x).sort(compare)
      } else {
        return []
      }
    }
  },
  created() {
    this.resetParams()
    this.getCurrentTahap()
    this.getList()
  },
  methods: {
    formatNumber,
    percentage(val, denom) {
      return denom ? (val / denom) * 100 : 0
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
      }
      if (this.user.kelurahan) {
        this.filter.type = 'kel'
        this.filter.code_bps = this.user.kelurahan.code_bps
      }
    },
    async getList() {
      this.listLoading = true
      const response = await fetchDashboardList(this.filter)
      this.list = response.data
      this.listLoading = false
    },
    getTotalBenefeciaries(data) {
      return (
        this.getApproved(data) + this.getPending(data) + this.getReject(data)
      )
    },
    getTableRowNumbering(index) {
      return index + 1
    },
    changeSort(e) {
      this.sort_prop = e.prop
      this.sort_order = e.order
    },
    changeKabkota(id) {
      this.listQuery.kode_kab = id
    },
    changeKecamatan(id) {
      this.listQuery.kode_kec = id
    },
    getApproved(data) {
      return (
        data.approved_kabkota +
        data.approved_kec +
        data.approved_kel +
        data.approved
      )
    },
    getPending(data) {
      return data.pending
    },
    getReject(data) {
      return (
        data.rejected_kabkota +
        data.rejected_kec +
        data.rejected_kel +
        data.rejected
      )
    },
    selectChange(data) {
      const result = []
      data.map(item => {
        const codeBps = item.code_bps !== '' ? item.code_bps : 0
        result.push(codeBps)
      })
      this.selectionQuery.kode_kec = result.join()
    },
    async exportData(params) {
      try {
        Loading.service({ fullScreen: true })
        const response = await exportBansos(params)
        if (response.status === 200) {
          Swal.fire({
            title: this.$t('label.beneficiaries-download-start-title-alert'),
            text: this.$t(
              'label.beneficiaries-download-start-description-alert'
            ),
            icon: 'success',
            button: 'OK'
          })
        }
        Loading.service({ fullScreen: true }).close()
      } catch (error) {
        Loading.service({ fullScreen: true }).close()
      }
    },
    exportBySubdistrict() {
      if (this.selectionQuery.kode_kec) {
        const params = this.selectionQuery
        this.exportData(params)
      } else {
        Swal.fire({
          text: `${this.$t('label.beneficiaries-select-region-alert')} ${this.areaLabelByFilter}`,
          icon: 'warning',
          button: 'OK'
        })
      }
    },
    exportAll() {
      const params = null
      this.exportData(params)
    },

    // get current tahap
    async getCurrentTahap() {
      const response = await fetchCurrentTahap()
      this.selectionQuery.tahap_bantuan = Number(response.data.current_tahap_bnba)
    }
  }
}
</script>
<style lang="scss" scoped>
  .dialog-title {
    font-weight: bold;
    text-align: left;
    font-size: 22px;
    float: left;
    padding: 20px;
    margin-bottom: 15px;
  }

  .button-history {
    display: block;
    margin: 10px 0;
  }

  .float-right {
    float: right;
  }
</style>
