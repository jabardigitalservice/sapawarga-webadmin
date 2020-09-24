<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col>
        <el-card>
          <div slot="header" class="clearfix header">
            <span>{{ $t('label.beneficiaries-detail-bansos') }}</span>
          </div>
          <el-table stripe :data="tableDataBeneficiaries" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="300" />
            <el-table-column prop="content" />
            <el-table-column prop="content">
              <template slot-scope="{row}">
                <div v-if="row.income_before" class="name-wrapper">
                  {{ formatCurrency(row.income_before, 'Rp. ') }}
                </div>
              </template>
            </el-table-column>
          </el-table>
          <el-row>
            <el-col :sm="24" :md="12" :lg="12">
              <div class="image-display">
                <p class="label">{{ $t('label.beneficiaries-image-ktp') }}</p>
                <img :src="imageKtp || imageNone" alt="" width="350px" height="230px">
              </div>
            </el-col>
            <el-col :sm="24" :md="12" :lg="12">
              <div class="image-display">
                <p class="label">{{ $t('label.beneficiaries-image-kk') }}</p>
                <img :src="imageKk || imageNone" alt="" width="350px" height="230px">
              </div>
            </el-col>
          </el-row>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/beneficiaries'
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
    getDetail(id) {
      fetchRecord(id).then(response => {
        const { nik, name, image_ktp_url, image_kk_url, status_verification, domicile_kabkota_name, domicile_kec_name, domicile_kel_name, domicile_rt, domicile_rw, total_family_members, job_type_name, income_before, status_verification_label } = response.data
        this.imageKtp = image_ktp_url
        this.imageKk = image_kk_url
        this.tableDataBeneficiaries = [
          {
            title: this.$t('label.beneficiaries-nik'),
            content: nik
          },
          {
            title: this.$t('label.beneficiaries-name'),
            content: name
          },
          {
            title: this.$t('label.beneficiaries-domicile-kabkota'),
            content: domicile_kabkota_name || '-'
          },
          {
            title: this.$t('label.beneficiaries-domicile-kecamatan'),
            content: domicile_kec_name || '-'
          },
          {
            title: this.$t('label.beneficiaries-domicile-kelurahan'),
            content: domicile_kel_name || '-'
          },
          {
            title: this.$t('label.beneficiaries-rw'),
            content: domicile_rw || '-'
          },
          {
            title: this.$t('label.beneficiaries-rt'),
            content: domicile_rt || '-'
          },
          {
            title: this.$t('label.beneficiaries-total-family'),
            content: total_family_members || '-'
          },
          {
            title: this.$t('label.beneficiaries-job'),
            content: job_type_name ? job_type_name.title : '-'
          },
          {
            title: this.$t('label.beneficiaries-income-before'),
            content: income_before ? this.formatCurrency(income_before, 'Rp. ') : '-'
          },
          {
            title: this.$t('label.beneficiaries-status'),
            content: (status_verification === 1 ? <el-tag type='warning'>{status_verification_label}</el-tag> : status_verification === 2 ? <el-tag type='danger'>{status_verification_label}</el-tag> : <el-tag type='success'>{status_verification_label}</el-tag>)
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
