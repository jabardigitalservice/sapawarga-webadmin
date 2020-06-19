<template>
  <div class="mt-1">
    <el-table v-loading="listLoading" :data="list" border highlight-current-row style="width: 100%" :row-style="tableRowClassName">
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

      <el-table-column align="center" :label="$t('label.actions')">
        <template slot-scope="scope">
          <el-tooltip :content="$t('label.beneficiaries-detail')" placement="top">
            <el-button type="primary" icon="el-icon-view" size="small" @click="getDetail(scope.row.id)" />
          </el-tooltip>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

    <!-- show dialog detail -->
    <el-dialog
      :visible.sync="isDetail"
      width="80%"
      :close-on-click-modal="false"
      custom-class="dialog-custome"
      :modal-append-to-body="false"
      :append-to-body="true"
      top="5vh"
      style="margin-bottom: 30px"
    >
      <span slot="title" class="dialog-title detail-title" style="margin: 0; padding: 0">Detail Penerima Bantuan</span>
      <hr class="line-separator">
      <Preview :id-detail="idDetail" @closeDialog="closeDetail" />
    </el-dialog>
  </div>
</template>

<script>
import { fetchList } from '@/api/beneficiaries'
import Pagination from '@/components/Pagination'
import { formatCurrency } from '@/utils/formatNumber'
import Preview from './Preview'

export default {
  components: {
    Pagination,
    Preview
  },
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
    listQueryDomicile: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      isDetail: false,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 10
      }
    }
  },
  created() {
    this.getList()
  },
  methods: {
    formatCurrency,
    getList() {
      this.listLoading = true
      Object.assign(this.listQuery, this.listQueryDomicile)
      fetchList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },
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
    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },
    getDetail(value) {
      this.isDetail = true
      this.idDetail = value
    },

    closeDetail() {
      this.isDetail = false
    }
  }

}
</script>

<style lang="scss" scoped>
  .mt-1 {
    margin-top: 1rem;
  }
</style>
