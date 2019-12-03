<template>
  <div class="app-container" name="list-priority-berita">
    <el-row :gutter="10">
      <el-col :lg="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="4" style="margin-left: 10px">
            <el-button type="primary" :disabled="isDisabled" @click="dialogTableVisible = true">
              {{ $t('news.priority-news-add-header') }}
            </el-button>
          </el-col>
        </el-row>
        <div class="editor-container">
          <dnd-list :list1="listPriority" list1-title="List Berita Priority" />
        </div>
        <el-row :gutter="10">
          <el-col :xs="6" :sm="3" :md="2" >
            <el-button type="primary" @click="onSaveChange">
              {{ $t('crud.save-update') }}
            </el-button>
          </el-col>
          <el-col :span="2" style="margin-left: 85px">
            <router-link :to="{ path: '/news' }">
              <el-button type="primary">
                {{ $t('crud.back') }}
              </el-button>
            </router-link>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
    <el-dialog v-el-drag-dialog :visible.sync="dialogTableVisible" title="List Berita">
      <el-row>
        <ListFilter
          :list-query.sync="listQuery"
          :is-priority="true"
          @submit-search="getListBerita"
          @reset-search="resetFilter"
        />
        <el-table :data="listBerita">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
          <el-table-column property="title" label="Judul Berita" />
          <el-table-column property="channel.name" label="Sumber" />
          <el-table-column property="kabkota.name" label="Target Berita" />
          <el-table-column align="center" label="Actions">
            <template slot-scope="scope">
              <el-button type="white" size="mini" @click="addBeritaPriority(scope.row), dialogTableVisible = false">
                Tambah
              </el-button>
            </template>
          </el-table-column>
        </el-table>
        <pagination
          v-show="total>0"
          :total="total"
          :page.sync="listQuery.page"
          :limit.sync="listQuery.limit"
          @pagination="getListBerita"
        />
      </el-row>
    </el-dialog>
  </div>
</template>

<script>
import elDragDialog from '@/directive/el-dragDialog' // base on element-ui
import DndList from '@/components/DndList'
import Pagination from '@/components/Pagination'
import { fetchList, fetchListPriority, priorityBeritaUpdate } from '@/api/news'
import ListFilter from './_listfilter'
import { mapGetters } from 'vuex'

export default {
  directives: { elDragDialog },
  components: {
    Pagination,
    ListFilter,
    DndList
  },

  data() {
    return {
      listBerita: null,
      listPriority: [],
      total: 0,
      listLoading: true,
      listQuery: {
        title: null,
        search: null,
        channel_id: null,
        status: 10,
        page: 1,
        limit: 10
      },
      terms: false,
      dialogTableVisible: false
    }
  },

  computed: {
    isDisabled: function() {
      if (this.listPriority.length >= 5) {
        return !this.terms
      } else {
        return this.terms
      }
    },
    ...mapGetters([
      'user'
    ])
  },

  mounted() {
    this.getListPriority()
    this.getListBerita()
  },

  methods: {
    async getListPriority() {
      this.listLoading = true
      const dataPriority = []
      const listPriorityQuery = {
        kabkota_id: this.user.kabkota_id ? this.user.kabkota_id : null
      }
      await fetchListPriority(listPriorityQuery).then(async(response) => {
        await response.data.forEach((item, index) => {
          if (item !== null) {
            item['seq'] = index + 1
            dataPriority.push(item)
          }
        })
        this.listPriority = dataPriority
        this.listLoading = false
      })
    },

    getListBerita() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.listBerita = response.data.items
        this.total = response.data._meta.totalCount
      })
    },

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getListBerita()
    },

    addBeritaPriority(data) {
      const pos = this.listPriority.findIndex(record => record.id === data.id)
      if (pos === -1) {
        const seq = this.listPriority.length + 1
        data['seq'] = seq
        this.listPriority.push(data)
      } else {
        this.$message.success(this.$t('crud.news-selected'))
      }

      this.resetFilter()
    },

    async onSaveChange() {
      const data = []
      const kabkota_id = this.user.kabkota_id ? this.user.kabkota_id : null
      if (this.listPriority !== undefined) {
        this.listPriority.forEach((item, index) => {
          data.push({ 'news_id': item.id, 'seq': index + 1 })
        })
      }

      await priorityBeritaUpdate(kabkota_id, data)
      await this.$message.success(this.$t('crud.update-success'))
      await this.getListPriority()
    }
  }
}
</script>
<style>
.el-dialog{
  width: 80% !important;
}
</style>
