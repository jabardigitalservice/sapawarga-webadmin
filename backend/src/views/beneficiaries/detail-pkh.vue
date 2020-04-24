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
          </el-table>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecordGetPKH } from '@/api/beneficiaries'
export default {
  data() {
    return {
      tableDataBeneficiaries: []
    }
  },
  created() {
    const id = this.$route.params && this.$route.params.id
    this.getDetail(id)
  },
  methods: {
    getDetail(id) {
      fetchRecordGetPKH(id).then(response => {
        const { nik, name, no_kk, id_bdt, domicile_address, jenis_bantuan, image_ktp_url, image_kk_url, status_verification, domicile_kabkota_name, domicile_kec_name, domicile_kel_name, domicile_rt, domicile_rw, total_family_members, job_type_name, income_before, status_verification_label } = response.data
        this.tableDataBeneficiaries = [
          {
            title: this.$t('label.beneficiaries-name'),
            content: name
          },
          {
            title: this.$t('label.beneficiaries-nik'),
            content: nik
          },
          {
            title: this.$t('label.beneficiaries-no-kk'),
            content: no_kk
          },
          {
            title: this.$t('label.beneficiaries-id-bdt'),
            content: id_bdt
          },
          {
            title: this.$t('label.beneficiaries-type'),
            content: jenis_bantuan
          },
          {
            title: this.$t('label.address'),
            content: domicile_address
          },
          {
            title: this.$t('label.beneficiaries-rt-rw'),
            content: `${this.$t('label.beneficiaries-rt')} ${domicile_rt} / ${this.$t('label.beneficiaries-rw')} ${domicile_rw}`
          },
          {
            title: this.$t('label.beneficiaries-domicile-kabkota'),
            content: domicile_kabkota_name ? domicile_kabkota_name.name : '-'
          },
          {
            title: this.$t('label.beneficiaries-domicile-kecamatan'),
            content: domicile_kec_name ? domicile_kec_name.name : '-'
          },
          {
            title: this.$t('label.beneficiaries-domicile-kelurahan'),
            content: domicile_kel_name ? domicile_kel_name.name : '-'
          },
          {
            title: this.$t('label.beneficiaries-rw'),
            content: domicile_rw || '-'
          },
          {
            title: this.$t('label.beneficiaries-rt'),
            content: domicile_rt || '-'
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
