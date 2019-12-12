<template>
  <div class="app-container" name="chat-admin">
    <el-row :gutter="20">
      <el-col :lg="24">
        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="name" :label="$t('label.fullname')" min-width="150" />
          <el-table-column prop="phone" :label="$t('label.phone-number')" min-width="150" />
          <el-table-column prop="address" :label="$t('label.address')" min-width="150" />
          <el-table-column prop="last_access_at" :label="$t('label.last-access')" min-width="150" />

          <el-table-column align="center" :label="$t('label.actions')" min-width="150px">
            <template slot-scope="scope">
              <el-button type="info" size="mini" @click="onClickChat(scope.row.phone)">
                <img src="@/assets/gray-whatsapp.svg">
                <span>Chat</span>
              </el-button>
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchList } from '@/api/staff'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination

export default {
  components: {
    Pagination
  },

  props: {
    roleId: {
      type: String,
      default: null
    }
  },

  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        type: null,
        version: null,
        sort_by: 'created_at',
        sort_order: 'descending',
        page: 1,
        limit: 10
      }
    }
  },

  mounted() {
    this.getList()
  },

  methods: {
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
    },

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    },

    onClickChat(phone) {
      const url_link = 'https://wa.me/' + phone.replace(/^0+/, '62')
      window.open(url_link, '_blank')
    }
  }
}
</script>
