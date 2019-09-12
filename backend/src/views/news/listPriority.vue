<template>
  <div class="app-container" name="list-priority-berita">
    <el-row :gutter="20">
      <el-col :lg="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="2">
            <router-link :to="{ path: '/news' }">
              <el-button type="primary">
                Kembali
              </el-button>
            </router-link>
          </el-col>
          <el-col :span="4" style="margin-left: 10px">
            <el-button type="primary" :disabled="isDisabled" @click="dialogTableVisible = true">
              Tambah Berita Priority
            </el-button>
          </el-col>
        </el-row>
        <div class="editor-container">
          <dnd-list :list1="listPriority" list1-title="List Berita Priority" />
        </div>
      </el-col>
    </el-row>
    <el-dialog v-el-drag-dialog :visible.sync="dialogTableVisible" title="List Berita">
      <ListFilter
        :list-query.sync="listQuery"
        @submit-search="getListBerita"
        @reset-search="resetFilter"
      />
      <el-table :data="listBerita">
        <el-table-column property="title" label="Judul Berita" />
        <el-table-column property="channel.name" label="Sumber" />
        <el-table-column align="center" label="Actions">
          <template slot-scope="scope">
            <el-button type="white" size="mini" @click="addBeritaPriority(scope.row), dialogTableVisible = false">
              Tambah
            </el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-dialog>
  </div>
</template>

<script>
import elDragDialog from '@/directive/el-dragDialog' // base on element-ui
import DndList from '@/components/DndList'
import { fetchList, fetchListPriority } from '@/api/news'
import ListFilter from './_listfilter'

export default {
  directives: { elDragDialog },
  components: {
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
        page: 1,
        limit: 10
      },
      terms: false,
      dialogTableVisible: false
    }
  },

  computed: {
    isDisabled: function() {
      const count_list = this.listPriority.length
      if (count_list === 5) {
        return !this.terms
      } else {
        return this.terms
      }
    }
  },

  mounted() {
    this.getListPriority()
    this.getListBerita()
  },

  methods: {
    getListPriority() {
      this.listLoading = true
      fetchListPriority().then(response => {
        this.listPriority = response.data.items
      })
    },

    getListBerita() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.listBerita = response.data.items
      })
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getListBerita()
    },

    addBeritaPriority(data) {
      const pos = this.listPriority.map(function(e) { return e.id }).indexOf(data.id)
      if (pos === -1) {
        this.listPriority.push(data)
      }
      this.resetFilter()
    },

    onSaveChange() {
      // console.log(this.list1)
      // console.log(ele)
    }
  }
}
</script>
<style>
.el-dialog{
  width: 80% !important;
}
</style>
