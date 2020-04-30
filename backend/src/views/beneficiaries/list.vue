<template>
  <div class="app-container">
    <el-row>
      <el-col :lg="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <el-button type="primary" size="small" icon="el-icon-plus" @click="accessBlock('create')">
              {{ $t('route.beneficiaries-create') }}
            </el-button>
          </el-col>
        </el-row>

        <!-- show statistics -->
        <Statistics :is-loading="isLoadingSummary" :summery="dataSummary" />

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="name" sortable="custom" :label="$t('label.beneficiaries-name')" min-width="200px" />

          <el-table-column prop="nik" sortable="custom" :label="$t('label.beneficiaries-nik')" min-width="175px">
            <template slot-scope="{row}">
              {{ row.nik }}
              <div v-if="row.is_nik_valid === 0" slot="reference" class="name-wrapper">
                <el-tag size="medium" type="danger">Format NIK tidak sesuai</el-tag>
              </div>
            </template>
          </el-table-column>

          <el-table-column prop="domicile_rw" sortable="custom" align="center" :label="$t('label.beneficiaries-rw')" min-width="70px" />

          <el-table-column prop="domicile_rt" sortable="custom" align="center" :label="$t('label.beneficiaries-rt')" min-width="70px" />

          <el-table-column prop="income_before" sortable="custom" :label="$t('label.beneficiaries-income-before')" min-width="180px">
            <template slot-scope="{row}">
              {{ formatCurrency(row.income_before, 'Rp.') }}
            </template>
          </el-table-column>

          <el-table-column prop="income_after" sortable="custom" :label="$t('label.beneficiaries-income-after')" min-width="180px">
            <template slot-scope="{row}">
              {{ formatCurrency(row.income_after, 'Rp.') }}
            </template>
          </el-table-column>

          <el-table-column prop="status_verification" class-name="status-col" sortable="custom" :label="$t('label.beneficiaries-status')" min-width="150px">
            <template slot-scope="{row}">
              <el-tag :type="row.status_verification | statusFilter">
                {{ row.status_verification_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column align="center" :label="$t('label.actions')" width="200px">
            <template slot-scope="scope">
              <router-link :to="'/beneficiaries/detail/' +scope.row.id">
                <el-tooltip :content="$t('label.beneficiaries-detail')" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <el-tooltip :content="$t('label.beneficiaries-verivication')" placement="top">
                <el-button type="success" icon="el-icon-circle-check" size="small" :disabled="scope.row.status_verification !== 1" @click="accessBlock('verification/' + scope.row.id)" />
              </el-tooltip>
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
      </el-col>
      <el-dialog
        :visible.sync="dialogVisible"
        width="50%"
        center
      >
        <span slot="title" class="dialog-title">Sampurasun, Wargi Jabar!</span>
        <p class="dialog-content">Sehubungan dengan berakhirnya proses verifikasi dan validasi bansos Non DTKS Sapawarga pada periode pertama di bulan April, atas permintaan Pemerintah Kabupaten Sumedang melalui sekretaris Daerah, maka fitur verifikasi dan validasi bansos Non DTKS Sapawarga akan kami <b>tutup sementara.</b> Fitur akan kami buka kembali menjelang proses verifikasi dan validasi bansos Non DTKS Sapawarga pada periode kedua bulan Mei. Tanggal pembukaan kembali fitur akan kami umumkan segera.
        </p>
        <p class="dialog-content">Terima kasih telah saling membantu wargi Jabar yang membutuhkan dengan melakukan proses verifikasi dan validasi menggunakan aplikasi Sapawarga.</p>
        <p>Tim Sapawarga</p>
        <span slot="footer" class="dialog-footer">
          <el-button type="success" @click="dialogVisible = false">Tutup</el-button>
        </span>
      </el-dialog>
    </el-row>
  </div>
</template>

<script>
import { fetchSummary, fetchList } from '@/api/beneficiaries'
import Pagination from '@/components/Pagination'
import Statistics from './components/Statistics'
import ListFilter from './_listfilter'
import { mapGetters } from 'vuex'

export default {
  components: { Pagination, Statistics, ListFilter },
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
      dialogVisible: false,
      isLoadingSummary: true,
      dataSummary: null,
      listLoading: true,
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      },
      listQuery: {
        nik: null,
        name: null,
        sort_by: 'nik',
        sort_order: 'ascending',
        page: 1,
        limit: 10,
        status_verification: null,
        domicile_kabkota_bps_id: null,
        domicile_kec_bps_id: null,
        domicile_kel_bps_id: null,
        domicile_rw_like: null,
        domicile_rt_like: null
      }
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  created() {
    this.getList()
    this.getSummary()
  },

  methods: {
    accessBlock(value) {
      if (this.user.kabkota.code_bps === '3211') {
        this.dialogVisible = true
      } else {
        this.$router.push('/beneficiaries/' + value)
      }
    },
    // get summary statistics
    getSummary() {
      const querySummary = {
        domicile_kabkota_bps_id: this.user.kabkota ? this.user.kabkota.code_bps : null,
        domicile_kec_bps_id: this.user.kecamatan ? this.user.kecamatan.code_bps : null,
        domicile_kel_bps_id: this.user.kelurahan ? this.user.kelurahan.code_bps : null
      }

      this.isLoadingSummary = true
      fetchSummary(querySummary).then(response => {
        this.dataSummary = response.data
        this.isLoadingSummary = false
      })
    },
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
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
        return 'Rp. 0'
      }
    },

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
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
</style>
