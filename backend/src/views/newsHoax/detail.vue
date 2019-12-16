<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Detail Berita Counter Hoax</span>
          </div>
          <detail-data :tableContentData="tableDataNews" />
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import moment from 'moment'
import { fetchRecord } from '@/api/newsHoax'
import DetailData from '@/components/DetailData'

export default {
  components: {
    DetailData
  },
  data() {
    return {
      tableDataNews: [],
      news: null
    }
  },

  mounted() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },

  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        const { title, category, source_date, content, total_viewers } = response.data
        this.news = response.data

        this.tableDataNews = [
          {
            title: 'Judul Berita',
            content: title || 'Error'
          },
          {
            title: 'Kategori Berita',
            content: (category ? category.name : 'Error')
          },
          {
            title: 'Tanggal Berita',
            content: (source_date ? moment(source_date).format('D MMMM YYYY') : 'Error')
          },
          {
            title: 'Konten Berita',
            content: this.strip(content) || 'Error'
          },
          {
            title: 'Jumlah Pengunjung',
            content: (total_viewers) ? total_viewers + ' Pengunjung' : '-'
          }
        ]
      })
    },

    strip(html) {
      var tmp = document.createElement('DIV')
      tmp.innerHTML = html
      return tmp.textContent || tmp.innerText || ''
    }
  }
}
</script>

<style>
.link {
  color: blue;
  text-decoration: underline;
}
</style>
