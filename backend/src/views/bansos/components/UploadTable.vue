<template>
  <div>
    <div class="title-table">
      <el-row>
        <el-col :span="24">
          <div class="text-22 text-bold">{{ $t('label.beneficiaries-history-upload') }}</div>
        </el-col>
      </el-row>
    </div>

    <el-table
      v-loading="loadingVervalList"
      :data="sortedList"
      border
      fit
      :header-row-style="{'color': '#000', 'font-weight': 'bold' }"
      style="width: 100%"
      :row-class-name="tableRowClassName"
      @sort-change="changeSort"
    >
      <el-table-column type="index" align="center" :index="getTableRowNumbering" width="50" />
      <el-table-column
        prop="original_filename"
        sortable="custom"
        :label="$t('importDataManual.history-import-file-name')"
      />
      <el-table-column
        prop="timestamp"
        sortable="custom"
        :label="$t('importDataManual.history-import-created-at')"
      >
        <template slot-scope="{row}">{{ row.timestamp | moment('D MMMM YYYY H:mm') }}</template>
      </el-table-column>
      <el-table-column
        prop="notes"
        sortable="custom"
        :label="$t('importDataManual.history-import-status')"
      >
        <template slot-scope="{row}">
          <span :class="statusClassName(row)">{{ statusLabel(row.status) }}</span>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getVervalUploadList"
    />
  </div>
</template>

<script>
import { fetchUploadBnbaList } from '@/api/beneficiaries'
import Pagination from '@/components/Pagination'
export default {
  components: { Pagination },
  data() {
    return {
      total: 0,
      listQuery: {
        name: null,
        date: null,
        page: 1,
        limit: 10
      },
      vervalUploadList: null,
      loadingVervalList: true,
      sort_prop: 'data.approved',
      sort_order: 'descending'
    }
  },
  computed: {
    sortedList() {
      const prop = this.sort_prop
      const order = this.sort_order
      function compare(a, b) {
        if (a[prop] < b[prop]) {
          return order === 'ascending' ? -1 : 1
        }
        if (a[prop] > b[prop]) {
          return order === 'ascending' ? 1 : -1
        }
        return 0
      }
      if (this.vervalUploadList) {
        return this.vervalUploadList.map(x => x).sort(compare)
      } else {
        return []
      }
    }
  },
  created() {
    this.getVervalUploadList()
  },
  methods: {
    async getVervalUploadList() {
      this.loadingVervalList = true
      const response = await fetchUploadBnbaList(this.listQuery)
      console.log(response)

      this.vervalUploadList = response.data.items
      this.loadingVervalList = false
      this.total = response.data._meta.totalCount
    },
    getTableRowNumbering(index) {
      return (this.listQuery.page - 1) * this.listQuery.limit + (index + 1)
    },
    changeSort(e) {
      this.sort_prop = e.prop
      this.sort_order = e.order
    },
    statusClassName(row) {
      return row.status === 1 ? 'success-status' : ''
    },
    tableRowClassName({ row, rowIndex }) {
      return row.status === 20
        ? 'danger-row'
        : row.status === 21
          ? 'warning-row'
          : ''
    },
    statusLabel(status) {
      let label
      switch (status) {
        case 1:
          label = this.$t('importDataManual.history-import-status-success')
          break
        default:
          label = ''
          break
      }
      return label
    }
  }
}
</script>

<style lang="scss">
.title-table {
  padding-bottom: 1rem;
  border-bottom: 1px solid #e0e0e0;
}

.text-22 {
  font-size: 22px;
}

.text-bold {
  font-weight: bold;
}

.success-status {
  color: #67c23a;
}

.el-table .warning-row {
  background: rgb(250, 236, 216);
}

.el-table .danger-row {
  background: rgb(253, 226, 226);
}

.hover-row > td {
  background-color: initial !important;
}
</style>
