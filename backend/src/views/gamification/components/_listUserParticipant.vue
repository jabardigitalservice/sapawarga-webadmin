<template>
  <div>
    <el-table
      :data="listParticipant.items"
      style="width: 100%"
    >
      <el-table-column
        type="index"
        width="50"
        align="center"
        :index="getTableRowNumbering"
      />
      <el-table-column
        prop="user.name"
        :label="$t('label.name')"
        width="180"
      />
      <el-table-column
        prop="address"
        :label="$t('label.place')"
      >
        <template slot-scope="{row}">
          {{ getKedudukan(row.user) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="total_user_hit"
        label="Task"
        width="180"
      />
      <el-table-column
        prop="created_at"
        :label="$t('label.join-date')"
        :formatter="formatterCellDate"
        width="180"
      />
    </el-table>
    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" />
  </div>
</template>

<script>
import { parsingDatetime } from '@/utils/datetimeToString'
import Pagination from '@/components/Pagination'

export default {
  name: 'UserParticipant',
  components: { Pagination },
  props: {
    listParticipant: {
      type: Object,
      default: null,
      require: true
    },
    listQuery: {
      type: Object,
      default: null,
      require: true
    },
    total: {
      type: Number,
      default: 0,
      require: true
    }
  },
  methods: {
    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },
    formatterCellDate(row, column, cellValue, index) {
      const value = cellValue ? parsingDatetime(cellValue, 'DD MMMM YYYY') : '-'
      return value
    },
    getKedudukan(user) {
      const rw = _.get(user, 'rw', 'N/A')
      const kelurahan = _.get(user, 'kelurahan', 'N/A')
      const kecamatan = _.get(user, 'kecamatan')
      const kabkota = _.get(user, 'kabkota')
      return this.$t('users.users-role-text-staff-rw', [rw, kelurahan, kecamatan, kabkota])
    }
  }
}
</script>
