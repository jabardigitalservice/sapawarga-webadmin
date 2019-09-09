<template>
  <div class="app-container" name="list-priority-berita">
    <el-row :gutter="20">
      <el-col :lg="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <el-button type="primary" @click="dialogTableVisible = true">
              Tambah Berita Priority
            </el-button>
          </el-col>
        </el-row>
        <div class="editor-container">
          <dnd-list :list1="list1" list1-title="List Berita Priority" />
        </div>
      </el-col>
    </el-row>
    <el-dialog v-el-drag-dialog :visible.sync="dialogTableVisible" title="List Berita" @dragDialog="handleDrag">
      <ListFilter
        :list-query.sync="listQuery"
        @submit-search="getList"
        @reset-search="resetFilter"
      />
      <el-table :data="list">
        <el-table-column property="title" label="Judul Berita" />
        <el-table-column property="channel.name" label="Sumber" />
        <!-- <el-table-column property="date" label="Date" width="150" /> -->
        <el-table-column align="center" label="Actions">
          <!-- <template slot-scope="scope"> -->
          <el-button type="white" size="mini">
            Tambah
          </el-button>
          <!-- </template> -->
        </el-table-column>
      </el-table>
    </el-dialog>
  </div>
</template>

<script>
import elDragDialog from '@/directive/el-dragDialog' // base on element-ui
import DndList from '@/components/DndList'
import { fetchList } from '@/api/news'
import ListFilter from './_listfilter'

export default {
  directives: { elDragDialog },
  components: {
    ListFilter,
    DndList
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
      list1: [],
      total: 0,
      listLoading: true,
      listQuery: {
        type: null,
        page: 1,
        limit: 10
      },
      dialogTableVisible: false,
      value: '',
      gridData: [{
        date: '2016-05-02',
        name: 'John 1',
        address: 'No.1518,  Jinshajiang Road, Putuo District'
      }, {
        date: '2016-05-04',
        name: 'John 2',
        address: 'No.1518,  Jinshajiang Road, Putuo District'
      }, {
        date: '2016-05-01',
        name: 'John 3',
        address: 'No.1518,  Jinshajiang Road, Putuo District'
      }, {
        date: '2016-05-03',
        name: 'John 4',
        address: 'No.1518,  Jinshajiang Road, Putuo District'
      }, {
        date: '2016-05-03',
        name: 'John 5',
        address: 'No.1518,  Jinshajiang Road, Putuo District'
      }]
    }
  },

  mounted() {
    this.getList()
  },

  methods: {
    getList() {
      this.listLoading = true
      this.list1 = this.gridData
      fetchList().then(response => {
        this.list = response.data.items
      })
    },

    handleDrag() {
      // this.$refs.select.blur()
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

    cellValueRenderer(row, column, cellValue, index) {
      let value = cellValue
      if (typeof row[column.property] === 'boolean') {
        if (cellValue === true) {
          value = 'Ya'
        } else {
          value = 'Tidak'
        }
      }
      return value
    }
  }
}
</script>
<style>
.el-dialog{
  width: 80% !important;
}
</style>
