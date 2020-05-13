<template>
  <el-dialog title="Detail Keluarga Penerima Manfaat" :append-to-body="true" :visible="rowdata != null" :close-on-press-escape="false" :show-close="false" :close-on-click-modal="false" @closed="modalClosed">
    <el-row v-if="rowdata" :gutter="24">
      <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix header">
            <span>{{ $t('label.beneficiaries-detail-bansos') }}</span>
            <el-button style="float: right" size="mini" type="default" icon="el-icon-close" @click="closeDialog()" />
          </div>
          <el-table stripe :data="tableDataBeneficiaries" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="250" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
      </el-col>
      <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
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
    <span slot="footer" class="dialog-footer">
      <el-button @click="closeDialog">Tutup</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
  props: {
    rowdata: {
      default: null,
      type: Object
    }
  },
  data() {
    return {
      tableDataBeneficiaries: [],
      tableData2Beneficiaries: []
    }
  },
  watch: {
    rowdata(row, oldrow) {
      if (!row) return
      this.tableDataBeneficiaries = [
        {
          title: this.$t('label.beneficiaries-nik'),
          content: row.nik
        },
        {
          title: 'Jenis Bantuan',
          content: this.tipeBansosFilter(row.id_tipe_bansos)
        },
        {
          title: 'Nama Kepala Keluarga',
          content: row.nama_krt
        },
        {
          title: 'Profesi',
          content: row.lapangan_usaha_type ? row.lapangan_usaha_type.title : '-'
        },
        {
          title: this.$t('label.beneficiaries-domicile-kabkota'),
          content: row.nama_kab || '-'
        },
        {
          title: this.$t('label.beneficiaries-domicile-kecamatan'),
          content: row.nama_kec || '-'
        },
        {
          title: this.$t('label.beneficiaries-domicile-kelurahan'),
          content: row.nama_kel || '-'
        },
        {
          title: this.$t('label.beneficiaries-rw'),
          content: row.rw || '-'
        },
        {
          title: this.$t('label.beneficiaries-rt'),
          content: row.rt || '-'
        },
        {
          title: this.$t('label.beneficiaries-total-family'),
          content: row.jumlah_art_tanggungan || '-'
        },
        {
          title: this.$t('label.beneficiaries-income-before'),
          content: row.penghasilan_sebelum_covid19 ? this.formatCurrency(row.penghasilan_sebelum_covid19, 'Rp. ') : '-'
        },
        {
          title: this.$t('label.beneficiaries-income-after'),
          content: row.penghasilan_setelah_covid ? this.formatCurrency(row.penghasilan_setelah_covid, 'Rp. ') : '-'
        }
      ]
      this.tableData2Beneficiaries = [
        {
          title: 'NIK Valid',
          content: row.is_nik_valid
        },
        {
          title: 'Alamat Lengkap',
          content: row.is_alamat_lengkap
        },
        {
          title: 'Manual',
          content: row.is_manual
        },
        {
          title: 'Dari Sapawarga',
          content: row.is_sapawarga
        },
        {
          title: 'Dari Pikobar',
          content: row.is_pikobar
        },
        {
          title: 'Sudah Clean',
          content: row.is_super_clean
        },
        {
          title: 'Data Sisa',
          content: row.is_data_sisa
        }
      ]
    }
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
    closeDialog() {
      this.$emit('close')
    },

    modalClosed() {
      this.$emit('close')
    }
  }
}
</script>
