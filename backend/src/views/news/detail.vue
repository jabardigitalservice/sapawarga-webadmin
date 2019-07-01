<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Data Berita</span>
          </div>
          <el-table stripe :data="tableDataNews" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/news'
export default {
  data() {
    return {
      tableDataNews: [],
      news: null
    }
  },
  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },
  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        console.log(response.data)
        const { status_label, title, created_at } = response.data
        this.news = response.data

        this.tableDataNews = [
          {
            title: 'Judul Berita',
            content: title || '-'
          },
          {
            title: 'Sumber',
            content: status_label || '-'
          },
          {
            title: 'Tanggal Berita',
            content: created_at || '-'
          },
          {
            title: 'Status',
            content: status_label || '-'
          },
          {
            title: 'Prioritas Berita',
            content: status_label || '-'
          },
          {
            title: 'URL Berita',
            content: status_label || '-'
          },
          {
            title: 'Konten Berita',
            content: status_label || '-'
          }
        ]
      })
    }
  }
}
</script>
