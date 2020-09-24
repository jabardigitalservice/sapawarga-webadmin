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

        <DashboardTitle :is-bnba="true" />
        <!-- show statistics -->
        <StatisticsBnba :is-loading="isLoadingSummary" :summary="dataSummary" />

        <ListFilterBnba :list-query.sync="listQuery" @display-search="displayFilter" @submit-search="getList" @reset-search="resetFilter" />
        <p v-if="display">DATA BERDASARKAN FILTER <span v-if="listQuery.nik">NIK <b>{{ listQuery.nik }}</b>,</span> <span v-if="listQuery.nama_krt">NAMA <b>{{ listQuery.nama_krt }}</b>,</span> <span v-if="listQuery.id_tipe_bansos">PINTU BANTUAN <b>{{ listQuery.name_tipe_bansos }}</b></span></p>
        <el-table v-loading="listLoading" :data="list" border stripe highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="right" :index="getTableRowNumbering" />

          <el-table-column prop="id_tipe_bansos" class-name="status-col" sortable="custom" :label="'Pintu Bantuan'" min-width="200px">
            <template slot-scope="{row}">
              {{ row.id_tipe_bansos | tipeBansosFilter }}
            </template>
          </el-table-column>

          <el-table-column prop="nama_krt" sortable="custom" :label="$t('label.beneficiaries-familyhead-name')" min-width="200px">
            <template slot-scope="{row}">
              <a @click="selectedRow = row">
                {{ row.nama_krt }}
              </a>
            </template>
          </el-table-column>
          <el-table-column prop="nik" sortable="custom" :label="$t('label.beneficiaries-nik')" min-width="175px">
            <template slot-scope="{row}">
              {{ row.nik }}
              <div v-if="row.nik === null || row.nik === '' || row.nik && row.nik.length !== 16" slot="reference" class="name-wrapper">
                <el-tag size="medium" type="danger">Format NIK tidak sesuai</el-tag>
              </div>
            </template>
          </el-table-column>

          <el-table-column prop="rw" sortable="custom" align="center" :label="$t('label.beneficiaries-rw')" min-width="70px" />

          <el-table-column prop="rt" sortable="custom" align="center" :label="$t('label.beneficiaries-rt')" min-width="70px" />

          <el-table-column prop="lapangan_usaha" sortable="custom" :label="$t('label.beneficiaries-job')" min-width="150px">
            <template slot-scope="{row}">
              {{ row.lapangan_usaha_type ? row.lapangan_usaha_type.title : '-' }}
            </template>
          </el-table-column>

          <el-table-column prop="penghasilan_sebelum_covid19" align="right" sortable="custom" :label="$t('label.beneficiaries-income-before')" min-width="150px">
            <template slot-scope="{row}">
              <span style="float: left">Rp.</span>
              {{ formatCurrency(row.penghasilan_sebelum_covid19) }}
            </template>
          </el-table-column>

          <el-table-column prop="penghasilan_setelah_covid" align="right" sortable="custom" :label="$t('label.beneficiaries-income-after')" min-width="150px">
            <template slot-scope="{row}">
              <span style="float: left">Rp.</span>
              {{ formatCurrency(row.penghasilan_setelah_covid) }}
            </template>
          </el-table-column>

          <!-- <el-table-column prop="nama_kab" sortable="custom" align="center" :label="$t('label.beneficiaries-domicile-kabkota')" min-width="175px" />
          <el-table-column prop="nama_kec" sortable="custom" align="center" :label="$t('label.beneficiaries-domicile-kecamatan')" min-width="175px" />
          <el-table-column prop="nama_kel" sortable="custom" align="center" :label="$t('label.beneficiaries-domicile-kelurahan')" min-width="175px" /> -->

          <el-table-column align="center" :label="$t('label.actions')" width="200px">
            <template slot-scope="{row}">
              <el-tooltip :content="$t('label.beneficiaries-detail')" placement="top">
                <el-button size="mini" type="primary" icon="el-icon-view" @click="selectedRow = row" />
              </el-tooltip>
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
      </el-col>
    </el-row>
    <ModalDetailBnba :rowdata="selectedRow" @close="closeDialog" />
  </div>
</template>

<script>
import { fetchBnbaTahapSatuSummary, fetchBnbaTahapSatuList, fetchCurrentTahap } from '@/api/beneficiaries'
import Pagination from '@/components/Pagination'
import i18n from '@/lang'
import StatisticsBnba from './components/StatisticsBnba'
import ModalDetailBnba from './components/ModalDetailBnba'
import ListFilterBnba from './_listfilterbnba'
import DashboardTitle from './components/DashboardTitle'
import { mapGetters } from 'vuex'

export default {
  components: { Pagination, StatisticsBnba, ListFilterBnba, ModalDetailBnba, DashboardTitle },
  filters: {
    tipeBansosFilter(status) {
      const statusMap = {
        '1': i18n.t('label.beneficiaries-pkh'),
        '2': i18n.t('label.beneficiaries-bpnt-basicfood'),
        '3': i18n.t('label.beneficiaries-bpnt-expansion'),
        '4': i18n.t('label.beneficiaries-kemensos'),
        '5': i18n.t('label.beneficiaries-president'),
        '6': i18n.t('label.beneficiaries-province'),
        '7': i18n.t('label.beneficiaries-village-fund'),
        '8': i18n.t('label.beneficiaries-city')
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
      display: false,
      list: null,
      total: 0,
      isLoadingSummary: true,
      dataSummary: null,
      listLoading: true,
      listTahap: [],
      tahapDisplay: null,
      modalDetailBnbaVisible: false,
      selectedRow: null,
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      },
      listQuery: {
        nik: null,
        nama_krt: null,
        sort_by: null,
        sort_order: null,
        page: 1,
        limit: 10,
        id_tipe_bansos: null,
        name_tipe_bansos: null,
        kode_kab: null,
        kode_kec: null,
        kode_kel: null,
        rw: null,
        rt: null,
        tahap: null
      }
    }
  },
  computed: {
    ...mapGetters(['user']),
    isFilterProv() {
      return !this.listQuery.kode_kab && !this.listQuery.kode_kec && !this.listQuery.kode_kel
    },
    isFilterKab() {
      return this.listQuery.kode_kab && !this.listQuery.kode_kec && !this.listQuery.kode_kel
    },
    isFilterKec() {
      return this.listQuery.kode_kab && this.listQuery.kode_kec && !this.listQuery.kode_kel
    },
    isFilterKel() {
      return this.listQuery.kode_kab && this.listQuery.kode_kec && this.listQuery.kode_kel
    }
  },
  async created() {
    this.listQuery.kode_kab = this.user.kabkota ? this.user.kabkota.code_bps : null
    this.listQuery.kode_kec = this.user.kecamatan ? this.user.kecamatan.code_bps : null
    this.listQuery.kode_kel = this.user.kelurahan ? this.user.kelurahan.code_bps : null
    await this.getStep()
    this.getList()
  },

  methods: {
    handleCommand(command) {
      this.listQuery.tahap = command.value
      this.tahapDisplay = command.label
      this.getList()
    },

    displayFilter(value) {
      if (value.id_tipe_bansos === '1') {
        this.listQuery.name_tipe_bansos = this.$t('label.beneficiaries-pkh')
      } else if (value.id_tipe_bansos === '2') {
        this.listQuery.name_tipe_bansos = this.$t('label.beneficiaries-bpnt-basicfood')
      } else if (value.id_tipe_bansos === '3') {
        this.listQuery.name_tipe_bansos = this.$t('label.beneficiaries-bpnt-expansion')
      } else if (value.id_tipe_bansos === '4') {
        this.listQuery.name_tipe_bansos = this.$t('label.beneficiaries-kemensos')
      } else if (value.id_tipe_bansos === '5') {
        this.listQuery.name_tipe_bansos = this.$t('label.beneficiaries-president')
      } else if (value.id_tipe_bansos === '6') {
        this.listQuery.name_tipe_bansos = this.$t('label.beneficiaries-province')
      } else if (value.id_tipe_bansos === '7') {
        this.listQuery.name_tipe_bansos = this.$t('label.beneficiaries-village-fund')
      } else if (value.id_tipe_bansos === '8') {
        this.listQuery.name_tipe_bansos = this.$t('label.beneficiaries-city')
      }
      this.display = true
    },
    // get summary statistics
    getSummary() {
      this.isLoadingSummary = true
      fetchBnbaTahapSatuSummary(this.listQuery).then(response => {
        this.dataSummary = response.data
        this.isLoadingSummary = false
      })
    },
    async getList() {
      this.getSummary()
      this.listLoading = true
      await fetchBnbaTahapSatuList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },

    async resetFilter() {
      this.display = false
      const tahap = this.listQuery.tahap

      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.listQuery.kode_kab = this.user.kabkota ? this.user.kabkota.code_bps : null
      this.listQuery.kode_kec = this.user.kecamatan ? this.user.kecamatan.code_bps : null
      this.listQuery.kode_kel = this.user.kelurahan ? this.user.kelurahan.code_bps : null

      // set tahap
      this.listQuery.tahap = tahap
      this.getList()
    },

    async getStep() {
      await fetchCurrentTahap().then(response => {
        this.listQuery.tahap = response.data.current_tahap_bnba
        this.tahapDisplay = this.$t('beneficiaries.stage') + this.listQuery.tahap
        for (let i = 1; i <= this.listQuery.tahap; i++) {
          const data = {
            value: i,
            label: this.$t('beneficiaries.stage') + i
          }
          this.listTahap.push(data)
        }
      })
    },

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    formatCurrency(value, prefix) {
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
        return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '')
      } else {
        return prefix === undefined ? 0 : 'Rp. 0'
      }
    },

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    },

    closeDialog() {
      this.selectedRow = null
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
    padding: 10px;
  }
  .dialog-content {
    font-size: 16px;
    line-height: 25px;
  }

  .dropdown {
    margin-top: 15px;
    margin-bottom: 100px;
    display: block;
    float: right;
  }
</style>
