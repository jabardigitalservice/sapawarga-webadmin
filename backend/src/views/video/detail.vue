<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">Detail Video</a></p>

    <el-row>
      <el-col :sm="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Data Video</span>
          </div>
          <el-table stripe :data="dataVideo" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>

      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/video'

export default {
  data() {
    return {
      dataVideo: [],
      record: null
    }
  },
  created() {
    const id = this.$route.params && this.$route.params.id
    this.getDetail(id)
  },
  methods: {
    getDetail(id) {
      fetchRecord(id).then(response => {
        const { title, category, video_url, source, seq, kabkota } = response.data

        this.record = response.data

        this.dataVideo = [
          {
            title: 'Judul Video',
            content: title
          },
          {
            title: 'Kategori',
            content: category.name
          },
          {
            title: 'Target Area Video',
            content: kabkota ? kabkota.name : 'JAWA BARAT'
          },
          {
            title: 'Set Prioritas',
            content: seq
          },
          {
            title: 'Sumber',
            content: source
          },
          {
            title: 'URL',
            content: <a href={video_url} style='color:blue' target='_blank'>{video_url}</a>
          }
        ]
      })
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
