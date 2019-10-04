<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Data Banner</span>
          </div>
          <el-table stripe :data="tableDataBanner" :show-header="false" style="width: 100%">
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
import { fetchRecord } from '@/api/banner'
export default {
  data() {
    return {
      tableDataBanner: [],
      banner: null
    }
  },
  mounted() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },
  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        const { title, status_label, link_url, internal_category, internal_entity_name, type } = response.data
        this.banner = response.data

        this.tableDataBanner = [
          {
            title: 'Judul Banner',
            content: title || '-'
          },
          {
            title: 'Kategori',
            content: type || '-'
          },
          {
            title: 'Fitur',
            content: internal_category || '-'
          },
          {
            title: 'Judul Fitur',
            content: internal_entity_name || '-'
          },
          {
            title: 'Status',
            content: status_label || '-'
          },
          {
            title: 'URL Banner',
            content: link_url || '-'
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

<style>
.link {
  color: blue;
  text-decoration: underline;
}
</style>
