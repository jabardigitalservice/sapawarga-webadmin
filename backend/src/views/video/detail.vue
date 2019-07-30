<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">Detail Video</a></p>

    <el-row>
      <el-col :sm="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Data Video</span>
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
import moment from 'moment'
import { fetchRecord } from '@/api/survey'


export default {
  data() {
    return {
      tableDataRecord: [],
      record: null,
    }
  },
  created() {
    const id = this.$route.params && this.$route.params.id
    this.getDetail(id)
  },
  methods: {
    getDetail(id) {
      fetchRecord(id).then(response => {
        const { title, category, video_url, source } = response.data

        this.record = response.data

        this.tableDataRecord = [
          {
            title: 'Judul Video',
            content: title
          },
          {
            title: 'Kategori',
            content: category.name
          },
          {
            title: 'Sumber',
            content: source
          },
          {
            title: 'URL Survei',
            content: <a href={video_url} target='_blank'>{video_url}</a>
          },
        ]
      })
    }
  }
}
</script>
