<template>
  <div class="app-container">
    <admin-headline-news />
    <h3>{{ $t('label.beneficiaries-download-search-subdistrict-title') }}</h3>

    <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

    <el-row>
      <el-col :span="24">
        <el-card class="box-card">
          <div slot="header">
            <el-row :gutter="10">
              <el-col :xs="24" :md="21">
                <span>{{ $t('label.beneficiaries-download-subdistrict-list-title') }}</span>
              </el-col>
              <el-col :xs="24" :md="3">
                <el-button type="success" plain icon="el-icon-download">{{ $t('crud.export') }}</el-button>
              </el-col>
            </el-row>
          </div>
          <div class="text item">
            <el-table v-loading="loading" :data="list" border stripe fit highlight-current-row style="width: 100%">
              <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
              <el-table-column prop="kecamatan" sortable="custom" :label="$t('label.beneficiaries-download-subdistrict')" />
              <el-table-column prop="terverifikasi" sortable="custom" align="center" :label="$t('label.beneficiaries-download-verified')" />
              <el-table-column prop="belum_terverifikasi" sortable="custom" align="center" :label="$t('label.beneficiaries-download-not-verified')" />
              <el-table-column prop="ditolak" sortable="custom" align="center" :label="$t('label.beneficiaries-download-rejected')" />
              <el-table-column prop="usulan_baru" sortable="custom" align="center" :label="$t('label.beneficiaries-download-new-proposal')" />
            </el-table>
            <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import AdminHeadlineNews from '@/components/AdminHeadlineNews'
import Pagination from '@/components/Pagination'
import ListFilter from './_listfilter'

export default {
  components: { AdminHeadlineNews, Pagination, ListFilter },
  data() {
    return {
      list: null,
      loading: true,
      total: 0,
      listQuery: {
        search: null,
        page: 1,
        limit: 10
      }
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.loading = true
      const data = [
        { id: 1, kecamatan: 'KEC CIMANGGUNG', terverifikasi: 1000, belum_terverifikasi: 500, ditolak: 10, usulan_baru: 5 },
        { id: 2, kecamatan: 'KEC CIMANGGUNG', terverifikasi: 1000, belum_terverifikasi: 500, ditolak: 10, usulan_baru: 5 }
      ]
      this.list = data
      this.loading = false
    },
    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)

      this.getList()
    },
    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    }
  }
}
</script>
