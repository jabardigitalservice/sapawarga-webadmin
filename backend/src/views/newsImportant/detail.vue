<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">{{$t('label.newsImportant-detail')}}</a></p>

    <el-row>
      <el-col :sm="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{$t('label.newsImportant-data')}}</span>
          </div>
          <el-table stripe :data="tableDataRecord" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>

      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/newsImportant'
export default {
  data () {
    return {
      tableDataRecord: []
    }
  },
  async created() {
    const id = await this.$route.params && this.$route.params.id
    await this.getDetail(id)
  },
  methods: {
    getDetail(id) {
      fetchRecord(id).then(response => {
        const {title, category, source_url, content} = response.data
        console.log(response.data)

        this.tableDataRecord = [
          {
            title: 'Judul',
            content: title
          },
          {
            title: 'Kategori',
            content: category.name
          },
          {
            title: 'Gambar',
            content: 'Kucing'
          },
          {
            title: 'Tautan',
            content: source_url
          },
          {
            title: 'Deskripsi',
            content: this.strip(content)
          }
        ]
      })
    },
    strip(html) {
      var tmp = document.createElement('DIV')
      tmp.innerHTML = html
      return tmp.textContent || tmp.innerText || ''
    },
  }
}
</script>
