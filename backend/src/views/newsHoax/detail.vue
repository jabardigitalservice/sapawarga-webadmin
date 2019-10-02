<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Detail Berita Counter Hoax</span>
          </div>
          <el-table stripe :data="tableDataNews" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content">
              <template slot-scope="{row}">
                <a v-if="validUrl(row.content)" :href="row.content" target="_blank" class="link">{{ row.content }}</a>
                <span v-else>{{ row.content }}</span>
              </template>
            </el-table-column>
          </el-table>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import moment from 'moment'
import { fetchRecord } from '@/api/newsHoax'
export default {
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
    },

    validUrl(str) {
      var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i') // fragment locator
      return !!pattern.test(str)
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
