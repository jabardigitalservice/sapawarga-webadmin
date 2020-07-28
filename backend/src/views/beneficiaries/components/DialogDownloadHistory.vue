<template>
  <div>
    <el-table v-loading="listLoading" :data="data" stripe>
      <el-table-column
        type="index"
        sortable="custom"
        width="50"
        align="center"
        label="No"
        :index="getTableRowNumbering"
      />
      <el-table-column property="start_at" :label="$t('beneficiaries.download-date')" width="200">
        <template slot-scope="{row}">
          {{ row.start_at | moment('D MMMM YYYY, HH:mm') }}
        </template>
      </el-table-column>
      <el-table-column property="name" :label="$t('label.beneficiaries-upload-status')" width="250">
        <template slot-scope="{row}">
          <el-progress :percentage="(isNaN(row.aggregate.total_row_processed * 100 / row.aggregate.total_row_count) === true) ? 100 : parseInt(row.aggregate.total_row_processed * 100 / row.aggregate.total_row_count)" />
        </template>
      </el-table-column>
      <el-table-column property="done_at" :label="$t('beneficiaries.print-date')" width="200">
        <template slot-scope="{row}">
          <div v-if="row.done_at">{{ row.done_at | moment('D MMMM YYYY, HH:mm') }}</div>
          <div v-else> - </div>
        </template>
      </el-table-column>
      <el-table-column property="final_url" :label="$t('beneficiaries.link')">
        <template slot-scope="{row}">
          <a :href="row.final_url" target="_blank" rel="noopener noreferrer">{{ row.final_url || '-' }}</a>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script>
import { fetchDownloadStatus, fetchDownloadStatusBnba } from '@/api/beneficiaries'
export default {
  props: {
    dialogTableVisible: {
      type: Boolean,
      default: false
    },
    source: {
      type: String,
      default: null
    },
    params: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      data: null,
      listLoading: false
    }
  },
  created() {
    this.getDataStatus()
  },
  methods: {
    getTableRowNumbering(index) {
      return index + 1
    },
    async getDataStatus() {
      this.listLoading = true
      const params = {
        limit: 10
      }
      const paramsFinal = Object.assign(params, this.params)

      const response = this.source === 'bnba' ? await fetchDownloadStatusBnba(paramsFinal) : await fetchDownloadStatus(paramsFinal)
      this.data = response.data.items
      this.listLoading = false
    }
  }
}
</script>
