<template>
  <div>
    <el-card class="box-card green">
      <div slot="header">
        <span>{{ $t('label.beneficiaries-upload-history') }}</span>
      </div>
      <div class="text item">
        <el-table
          v-loading="loading"
          :data="sortedList"
          border
          fit
          highlight-current-row
          style="width: 100%"
          :row-class-name="tableRowClassName"
          @sort-change="changeSort"
        >
          <el-table-column
            type="index"
            width="50"
            align="center"
            :index="getTableRowNumbering"
          />
          <el-table-column
            prop="bansos_type"
            sortable="custom"
            :label="$t('label.beneficiaries')"
            width="250"
          >
            <template slot-scope="{row}">{{ row.bansos_type }}</template>
          </el-table-column>
          <el-table-column
            prop="file_name"
            sortable="custom"
            :label="$t('label.beneficiaries-upload-filename')"
          />
          <el-table-column
            prop="notes"
            sortable="custom"
            :label="$t('label.beneficiaries-upload-status')"
          >
            <template slot-scope="{row}">
              <span :class="statusClassName(row)">{{ row.notes }}</span>
            </template>
          </el-table-column>
          <el-table-column
            prop="created_at"
            sortable="custom"
            :label="$t('label.beneficiaries-upload-date')"
          >
            <template slot-scope="{row}">{{ row.created_at | moment('D MMMM YYYY H:mm') }}</template>
          </el-table-column>
          <el-table-column align="center" :label="$t('label.actions')" width="200">
            <template slot-scope="{row}">
              <a v-if="row.status === '20' || row.status === '21'" :href="row.file_url">
                <el-tooltip
                  :content="$t('label.beneficiaries-download-invalid-file')"
                  placement="top"
                >
                  <el-button type="warning" size="mini">
                    <i class="el-icon-download el-icon-right" />
                    {{ $t('label.beneficiaries-download-invalid-file') }}
                  </el-button>
                </el-tooltip>
              </a>
            </template>
          </el-table-column>
        </el-table>
        <pagination
          v-show="total>0"
          :total="total"
          :page.sync="listQuery.page"
          :limit.sync="listQuery.limit"
          @pagination="getList"
        />
      </div>
    </el-card>
  </div>
</template>

<script>
import { uploadBansosList } from '@/api/bansos'
import Pagination from '@/components/Pagination'
import BeneficiariesType from '../statics/beneficiariesType'
export default {
  components: { Pagination },
  data() {
    return {
      list: null,
      loading: true,
      total: 0,
      listQuery: {
        page: 1,
        limit: 10
      },
      beneficiariesTypeList: null,

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
      if (this.list) {
        return this.list.map(x => x).sort(compare)
      } else {
        return []
      }
    }
  },
  created() {
    this.getList()
  },
  methods: {
    async getList() {
      this.loading = true
      const response = await uploadBansosList(this.listQuery)
      const data = []
      response.data.map(value => {
        const fileUrl =
          value.status === '20'
            ? value.invalid_file_url
            : value.status === '21'
              ? value.file_url
              : ''

        const notes =
          value.status === '0'
            ? this.$t('label.beneficiaries-import-start')
            : value.status === '-1'
              ? this.$t('label.beneficiaries-upload-error-process')
              : value.notes

        data.push({
          bansos_type: this.getTitle(value.bansos_type),
          target_upload: value.kabkota_name,
          created_at: value.created_at,
          file_url: fileUrl,
          status: value.status,
          notes: notes,
          file_name: value.original_filename,
          id: value.id
        })
      })
      this.list = data
      this.loading = false
    },
    tableRowClassName({ row, rowIndex }) {
      return row.status === '20'
        ? 'danger-row'
        : row.status === '21'
          ? 'warning-row'
          : ''
    },
    changeSort(e) {
      this.sort_prop = e.prop
      this.sort_order = e.order
    },
    getTableRowNumbering(index) {
      return (this.listQuery.page - 1) * this.listQuery.limit + (index + 1)
    },
    getTitle(typeId) {
      const beneficiariesType = new BeneficiariesType()
      const response = beneficiariesType.getAll(typeId)
      return `${response.type.toUpperCase().replace('_', ' ')} - ${
        response.name
      }`
    },
    statusClassName(row) {
      return row.status === '10' ? 'success-status' : ''
    }
  }
}
</script>

<style>

</style>
