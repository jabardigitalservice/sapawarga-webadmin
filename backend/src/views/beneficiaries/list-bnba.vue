<template>
  <div class="app-container">
    <el-row>
      <el-col :lg="24">
        <!-- show statistics -->
        <StatisticsBnba :is-loading="isLoadingSummary" :summery="dataSummary" />

        <ListFilterBnba :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="right" :index="getTableRowNumbering" />

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
              <div v-if="row.is_nik_valid === 0" slot="reference" class="name-wrapper">
                <el-tag size="medium" type="danger">Format NIK tidak sesuai</el-tag>
              </div>
            </template>
          </el-table-column>

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

          <el-table-column prop="id_tipe_bansos" class-name="status-col" sortable="custom" :label="'Bantuan'" min-width="150px">
            <template slot-scope="{row}">
              {{ row.id_tipe_bansos | tipeBansosFilter }}
            </template>
          </el-table-column>

          <el-table-column prop="nama_kab" sortable="custom" align="center" :label="$t('label.beneficiaries-domicile-kabkota')" min-width="175px" />
          <el-table-column prop="nama_kec" sortable="custom" align="center" :label="$t('label.beneficiaries-domicile-kecamatan')" min-width="175px" />
          <el-table-column prop="nama_kel" sortable="custom" align="center" :label="$t('label.beneficiaries-domicile-kelurahan')" min-width="175px" />
          <el-table-column prop="rw" sortable="custom" align="center" :label="$t('label.beneficiaries-rw')" min-width="70px" />

          <el-table-column prop="rt" sortable="custom" align="center" :label="$t('label.beneficiaries-rt')" min-width="70px" />

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
    <ModalDetailBnba :rowdata="selectedRow" @close="closeDialog" />
  </div>
</template>

<script>
import { fetchBnbaTahapSatuSummary, fetchBnbaTahapSatuList } from '@/api/beneficiaries'
import Pagination from '@/components/Pagination'
import StatisticsBnba from './components/StatisticsBnba'
import ModalDetailBnba from './components/ModalDetailBnba'
import ListFilterBnba from './_listfilterbnba'
import { mapGetters } from 'vuex'

export default {
  components: { Pagination, StatisticsBnba, ListFilterBnba, ModalDetailBnba },
  filters: {
    tipeBansosFilter(status) {
      const statusMap = {
        '1': 'PKH',
        '2': 'BPNT',
        '3': 'BPNT Perluasan',
        '4': 'Bansos Tunai (Kemensos)',
        '5': 'Bansos Presiden Sembako (BODEBEK)',
        '6': 'Bansos Provinsi',
        '7': 'Dana Desa',
        '8': 'Bansos Kabupaten/Kota'
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
        sort_by: 'nik',
        sort_order: 'ascending',
        page: 1,
        limit: 10,
        id_tipe_bansos: null,
        kode_kab: null,
        kode_kec: null,
        kode_kel: null,
        rw: null,
        rt: null
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
  created() {
    this.listQuery.kode_kab = this.user.kabkota ? this.user.kabkota.code_bps : null
    this.listQuery.kode_kec = this.user.kecamatan ? this.user.kecamatan.code_bps : null
    this.listQuery.kode_kel = this.user.kelurahan ? this.user.kelurahan.code_bps : null
    this.getList()
  },

  methods: {
    accessBlock(value) {
      if (this.user.kabkota !== null) {
        if (this.user.kabkota.code_bps === '3211') {
          this.dialogVisible = true
        } else {
          this.$router.push('/beneficiaries/' + value)
        }
      } else {
        this.$router.push('/beneficiaries/' + value)
      }
    },
    // get summary statistics
    getSummary() {
      this.isLoadingSummary = true
      fetchBnbaTahapSatuSummary(this.listQuery).then(response => {
        this.dataSummary = response.data
        this.isLoadingSummary = false
      })
    },
    getList() {
      this.getSummary()
      this.listLoading = true
      fetchBnbaTahapSatuList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.listQuery.kode_kab = this.user.kabkota ? this.user.kabkota.code_bps : null
      this.listQuery.kode_kec = this.user.kecamatan ? this.user.kecamatan.code_bps : null
      this.listQuery.kode_kel = this.user.kelurahan ? this.user.kelurahan.code_bps : null
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
</style>
