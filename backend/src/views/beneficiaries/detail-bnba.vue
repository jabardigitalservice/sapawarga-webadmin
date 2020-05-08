<template>
  <div class="app-container">
    <el-row :gutter="24">
      <el-col :xs="24" :sm="24" :md="15" :lg="15" :xl="15">
        <el-card>
          <div slot="header" class="clearfix header">
            <span>{{ $t('label.beneficiaries-detail-bansos') }}</span>
          </div>
          <el-table stripe :data="tableDataBeneficiaries" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="250" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
      </el-col>
      <el-col :xs="24" :sm="24" :md="9" :lg="9" :xl="9">
        <el-card>
          <div slot="header" class="clearfix header">
            <span>Status</span>
          </div>
          <el-table stripe :data="tableData2Beneficiaries" :show-header="false">
            <el-table-column prop="title" />
            <el-table-column prop="content">
              <template slot-scope="{row}">
                {{ row.content == 1 ? 'Ya' : '-' }}
              </template>
            </el-table-column>
          </el-table>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecordBnba } from '@/api/beneficiaries'
export default {
  components: {
  },
  data() {
    return {
      tableDataBeneficiaries: [],
      imageNone: require('@/assets/none.png'),
      imageKtp: null,
      imageKk: null
    }
  },
  created() {
    const id = this.$route.params && this.$route.params.id
    this.getDetail(id)
  },
  methods: {
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
    tipeBansosFilter(status) {
      const statusMap = {
        '1': 'PKH',
        '2': 'BPNT',
        '3': 'BPNT Perluasan',
        '4': 'Bansos Tunai (Kemensos)',
        '5': 'Bansos Presiden Sembako (BODEBEK)',
        '6': 'Bansos Provinsi',
        '7': 'Dana Desa'
      }
      return statusMap[status]
    },
    getDetail(id) {
      fetchRecordBnba(id).then(response => {
        const { id_tipe_bansos, nik, nama_krt, lapangan_usaha_type, nama_kab, nama_kec, nama_kel, rt, rw, jumlah_art_tanggungan, penghasilan_sebelum_covid19, penghasilan_setelah_covid,
          is_nik_valid, is_alamat_lengkap, is_manual, is_sapawarga, is_pikobar, is_super_clean, is_data_sisa
        } = response.data
        this.tableDataBeneficiaries = [
          {
            title: this.$t('label.beneficiaries-nik'),
            content: nik
          },
          {
            title: 'Jenis Bantuan',
            content: this.tipeBansosFilter(id_tipe_bansos)
          },
          {
            title: 'Nama Kepala Keluarga',
            content: nama_krt
          },
          {
            title: 'Profesi',
            content: lapangan_usaha_type ? lapangan_usaha_type.title : '-'
          },
          {
            title: this.$t('label.beneficiaries-domicile-kabkota'),
            content: nama_kab || '-'
          },
          {
            title: this.$t('label.beneficiaries-domicile-kecamatan'),
            content: nama_kec || '-'
          },
          {
            title: this.$t('label.beneficiaries-domicile-kelurahan'),
            content: nama_kel || '-'
          },
          {
            title: this.$t('label.beneficiaries-rw'),
            content: rw || '-'
          },
          {
            title: this.$t('label.beneficiaries-rt'),
            content: rt || '-'
          },
          {
            title: this.$t('label.beneficiaries-total-family'),
            content: jumlah_art_tanggungan || '-'
          },
          {
            title: this.$t('label.beneficiaries-income-before'),
            content: penghasilan_sebelum_covid19 ? this.formatCurrency(penghasilan_sebelum_covid19, 'Rp. ') : '-'
          },
          {
            title: this.$t('label.beneficiaries-income-after'),
            content: penghasilan_setelah_covid ? this.formatCurrency(penghasilan_setelah_covid, 'Rp. ') : '-'
          }
        ]
        this.tableData2Beneficiaries = [
          {
            title: 'NIK Valid',
            content: is_nik_valid
          },
          {
            title: 'Alamat Lengkap',
            content: is_alamat_lengkap
          },
          {
            title: 'Manual',
            content: is_manual
          },
          {
            title: 'Dari Sapawarga',
            content: is_sapawarga
          },
          {
            title: 'Dari Pikobar',
            content: is_pikobar
          },
          {
            title: 'Sudah Clean',
            content: is_super_clean
          },
          {
            title: 'Data Sisa',
            content: is_data_sisa
          }
        ]
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.label {
  font: 0.9em Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, Arial, sans-serif;
  color: #606266;
  font-weight: bold;
}
.image-display {
  margin-left: 10px;
}
.header {
  font-weight: bold;
}
</style>
