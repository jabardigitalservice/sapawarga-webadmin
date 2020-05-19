<template>
  <el-dialog width="75%" :visible="rowdata != null" :close-on-press-escape="false" :show-close="false" :close-on-click-modal="false" @closed="modalClosed">
    <span slot="title" class="dialog-title">{{ $t('label.beneficiaries-bnba-detail-popup-title') }}
      <el-button class="close-button" size="mini" type="default" icon="el-icon-close" @click="closeDialog()" />
    </span>
    <el-row v-if="rowdata" class="table" :gutter="24">
      <el-col class="table" :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
        <el-table class="table" stripe :data="tableDataBeneficiaries" :show-header="false" :row-style="rowStyle" style="width: 100%">
          <el-table-column prop="title" width="250" />
          <el-table-column prop="content" />
        </el-table>
      </el-col>
      <el-col class="table" :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
        <el-table class="table" stripe :data="tableData2Beneficiaries" :show-header="false" :row-style="rowStyle">
          <el-table-column prop="title" />
          <el-table-column prop="content" />
        </el-table>
      </el-col>
    </el-row>
    <el-row>
      <p class="preview-title">{{ $t('label.beneficiaries-document') }}</p>
      <el-col :sm="24" :md="12" :lg="12">
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-image-ktp') }}</p>
          <img :src="imageNone" alt="" width="350px" height="220px">
        </div>
      </el-col>
    </el-row>
    <span slot="footer" class="dialog-footer">
      <el-button @click="closeDialog">{{ $t('crud.back') }}</el-button>
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
      tableData2Beneficiaries: [],
      imageNone: require('@/assets/none.png')
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
          title: this.$t('label.beneficiaries-name'),
          content: row.nama_krt
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
        }
      ]
      this.tableData2Beneficiaries = [
        {
          title: this.$t('label.beneficiaries-total-family'),
          content: row.jumlah_art_tanggungan
        },
        {
          title: this.$t('label.beneficiaries-job'),
          content: row.lapangan_usaha_type ? row.lapangan_usaha_type.title : '-'
        },
        {
          title: this.$t('label.beneficiaries-income-before'),
          content: row.penghasilan_sebelum_covid19 ? this.formatCurrency(row.penghasilan_sebelum_covid19, 'Rp. ') : '-'
        },
        {
          title: this.$t('label.beneficiaries-income-after'),
          content: row.penghasilan_setelah_covid ? this.formatCurrency(row.penghasilan_setelah_covid, 'Rp. ') : '-'
        },
        {
          title: this.$t('label.beneficiaries'),
          content: this.tipeBansosFilter(row.id_tipe_bansos)
        },
        {
          title: 'Status',
          content: row.status_kedudukan || '-'
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
        '7': 'Dana Desa',
        '8': 'Bansos Kabupaten/Kota'
      }
      return statusMap[status]
    },
    closeDialog() {
      this.$emit('close')
    },

    modalClosed() {
      this.$emit('close')
    },

    rowStyle() {
      return 'font-weight: bold '
    }
  }
}
</script>
<style lang="scss" scoped>
  .dialog-title {
    font-weight: bold;
    font-size: 22px;
  }
  .table {
    margin: 0px !important;
    padding: 0px !important;
  }

  .close-button {
    background: transparent;
    float: right;
    outline: none;
    border: none;
    font-size: 16px;
  }

  .preview-title {
    font-weight: bold;
    font-size: 16px;
    color: #67C23A;
  }

  .preview-content {
     margin-left: 10px;
    padding-top: 5px;
    .content {
      font-weight: bold;
    }
  }
</style>
