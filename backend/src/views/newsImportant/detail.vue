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
import { fetchRecord } from '@/api/newsImportant'
import { render, validUrl } from '@/utils/htmlRender'
// import { validUrl } from '@/utils/validate'
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
            content: render(content)
          }, 
          {
            
          }
        ]
      })
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
