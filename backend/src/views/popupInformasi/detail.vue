<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Data Pop-Up Informasi</span>
          </div>
          <el-table stripe :data="tableDataPopUp" :show-header="false" style="width: 100%">
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
import { fetchRecord } from '@/api/popupInformasi'
import { validUrl } from '@/utils/validate'
export default {
  data() {
    return {
      tableDataPopUp: [],
      popup: null
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
        this.popup = response.data

        this.tableDataPopUp = [
          {
            title: 'Judul Pop-Up Informasi',
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
            title: 'URL Pop-Up Informasi',
            content: link_url || '-'
          }
        ]

        if (type === 'internal') {
          this.tableDataPopUp.pop()
        } else if (type === 'external') {
          this.tableDataPopUp.splice(2, 2)
        }
      })
    },

    validUrl(str) {
      return !!validUrl(str)
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
