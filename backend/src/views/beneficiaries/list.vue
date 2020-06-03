<template>
  <div class="app-container">
    <el-row>
      <el-col :lg="24">
        <DashboardTitle :is-verification="true" />
        <div class="warn-content-warning">
          <p class="title">Pengumuman</p>
          <p>Proses verifikasi dan validasi (verval) data penerima bansos via Sapawarga PERIODE 2 kembali dibuka mulai Senin, 11 Mei 2020! <span class="link" @click="dialogVisible = true">Lihat Info Selengkapnya</span></p>
        </div>
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

        <el-table v-loading="listLoading" :data="list" border highlight-current-row style="width: 100%" :row-style="tableRowClassName" @sort-change="changeSort">
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

          <el-table-column header-align="center" :label="$t('label.actions')" width="200px" :cell-style="marginLeft">
            <template slot-scope="scope">
              <router-link :to="'/beneficiaries/detail/' +scope.row.id">
                <el-tooltip :content="$t('label.beneficiaries-detail')" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <el-tooltip v-if="scope.row.status_verification !== 1" :content="$t('label.beneficiaries-edit')" placement="top">
                <el-button type="warning" icon="el-icon-edit" size="small" @click="accessBlock('edit/' + scope.row.id)" />
              </el-tooltip>
              <el-tooltip v-else :content="$t('label.beneficiaries-validate')" placement="top">
                <el-button type="success" icon="el-icon-circle-check" size="small" :disabled="scope.row.status_verification !== 1" @click="accessBlock('verification/' + scope.row.id)" />
              </el-tooltip>
              <el-tooltip v-if="scope.row.status_verification === 1 && scope.row.domicile_rt === '' || scope.row.domicile_rt === null || scope.row.domicile_rw === '' || scope.row.domicile_rw === null || scope.row.domicile_address === '' || scope.row.domicile_address === null || scope.row.name === '' || scope.row.name === null" :content="$t('label.beneficiaries-uncomplete-domicile')" placement="top">
                <el-button type="info" icon="el-icon-edit-outline" size="small" :disabled="scope.row.status_verification !== 1" @click="updateDomicile(scope.row)" />
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
        <span slot="title" class="dialog-title">Sampurasun Pemerintah Desa, Ketua RW, PLD, PSM, dan Karang Taruna!</span>
        <p class="dialog-content space">Proses verifikasi dan validasi (verval) data penerima bansos via Sapawarga PERIODE 2 kembali dibuka mulai Senin, 11 Mei 2020!</p>
        <p class="dialog-content space"><b>Berikut merupakan peningkatan fitur dan kemudahan yang dapat digunakan oleh pengguna pada proses verval bansos di periode kedua : </b></p>
        <p class="dialog-content space">1. Pemerintah Desa atau Ketua RW dapat mengupdate/merubah status calon penerima bansos (dari ditolak menjadi terverifikasi, atau sebaliknya).</p>
        <p class="dialog-content space">2. Pembenahan terhadap permasalahan terkait KTP ganda dan data tersasar.</p>
        <p class="dialog-content space">3. Pengakomodasian pendaftaran penerima bansos non-KTP.</p>
        <p class="dialog-content space">4. Penyelesaian permasalahan error 422,413,504, dan 408 pada Admin Sapawarga tingkat desa dan aplikasi Sapawarga Ketua RW.</p>
        <p class="dialog-content space">Demikian pengumuman kami, dimohon agar maklum.</p>
        <p class="dialog-content space" style="margin-bottom: 30px">Mari dukung proses verifikasi dan validasi data penerima bantuan sosial melalui Sapawarga untuk pelayanan dan proses pemberian bansos yang lebih baik.</p>
        <p class="dialog-content space" style="margin-bottom: 30px">Hormat kami,</p>
        <p class="dialog-content"><b>Tim Sapawarga,</b></p>
        <p class="dialog-content" style="margin-top:-12px">Pemerintah Provinsi Jawa Barat</p>
        <p class="dialog-content">Hotline (Hanya Whatsapp)</p>
        <p class="dialog-content" style="margin-top:-12px">+62 812-2008-2668</p>
        <p class="dialog-content link"><a href="https://s.id/HotlineSW" style="color:blue">https://s.id/HotlineSW</a></p>
        <span slot="footer" class="dialog-footer">
          <el-button type="success" @click="dialogVisible = false">Tutup</el-button>
        </span>
      </el-dialog>
      <el-dialog
        :visible.sync="isEditDomicile"
        width="70%"
        :close-on-click-modal="false"
        @close="exitDialog"
      >
        <span slot="title" class="dialog-title">Perbaharui Data Domisili Calon Penerima Bantuan</span>
        <FormPersonal :beneficiaries="beneficiaries" :is-edit-domicile="true" :is-edit="true" :is-create="false" :disable-field="false" @closeDialog="closeDialog" />
      </el-dialog>
    </el-row>
  </div>
</template>

<script>
import { fetchSummary, fetchList } from '@/api/beneficiaries'
import DashboardTitle from './components/DashboardTitle'
import FormPersonal from './components/FormPersonal'
import Pagination from '@/components/Pagination'
import Statistics from './components/Statistics'
import ListFilter from './_listfilter'
import { mapGetters } from 'vuex'

export default {
  components: { Pagination, Statistics, ListFilter, FormPersonal, DashboardTitle },
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
      isEditDomicile: false,
      isLoadingSummary: true,
      dataSummary: null,
      listLoading: true,
      beneficiaries: null,
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
    tableRowClassName({ row, rowIndex }) {
      const invalidRt = row.domicile_rt === '' || row.domicile_rt === null
      const invalidRw = row.domicile_rw === '' || row.domicile_rw === null
      const invalidName = row.name === '' || row.name === null
      const invalidAddress = row.domicile_address === '' || row.domicile_address === null

      if (row.status_verification === 1 && invalidRt || invalidRw || invalidName || invalidAddress) {
        return 'background: #FBE6E5'
      }
      return ''
    },

    marginLeft() {
      return 'padding-left: 50px'
    },

    exitDialog() {
      this.getList()
    },

    updateDomicile(value) {
      this.isEditDomicile = true
      this.beneficiaries = value
    },

    closeDialog(value) {
      this.isEditDomicile = value
    },

    accessBlock(value) {
      this.$router.push('/beneficiaries/' + value)
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
    padding: 0 10px;
    font-size: 16px;
    .space {
      line-height: 25px;
    }
    .link {
      color: blue !important;
    }
  }
  .footer {
    padding-top: 10px;
  }
  .warn-content-warning {
    background: #2b823d;
    border-radius: 5px;
    padding: 1.5rem;
    word-spacing: .05rem;
    color: white;
    margin-bottom: 25px;

    .title {
      font-weight: 600;
    }

    .link {
      text-decoration: underline;
      cursor: pointer;
      color: white !important;
    }
  }
</style>
