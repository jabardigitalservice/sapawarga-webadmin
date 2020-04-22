<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col>
        <el-card>
          <div slot="header" class="clearfix">
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
import { fetchRecord } from '@/api/beneficiaries'
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
      fetchRecord(id).then(response => {
        const { nik, name, domicile_kabkota_name, domicile_kec_name, domicile_kel_name, domicile_rt, domicile_rw, total_family_members, job_type_name, income_before, status_verification_label } = response.data
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
          },
          {
            title: this.$t('label.beneficiaries-total-family'),
            content: total_family_members || '-'
          },
          {
            title: this.$t('label.beneficiaries-job'),
            content: job_type_name ? job_type_name.name : '-'
          },
          {
            title: this.$t('label.beneficiaries-income-before'),
            content: income_before || '-'
          },
          {
            title: this.$t('label.beneficiaries-status'),
            content: status_verification_label || '-'
          }
        ]
      })
    }
  }
}
</script>
