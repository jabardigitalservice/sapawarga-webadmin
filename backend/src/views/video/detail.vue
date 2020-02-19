<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">{{ $t('label.video-detail') }}</a></p>

    <el-row>
      <el-col :sm="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.video-data') }}</span>
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
            title: this.$t('label.video-title'),
            content: title
          },
          {
            title: this.$t('label.category'),
            content: category.name
          },
          {
            title: this.$t('label.target'),
            content: kabkota ? kabkota.name : this.$t('label.area-jabar')
          },
          {
            title: this.$t('label.video-set-priority'),
            content: seq
          },
          {
            title: this.$t('label.source'),
            content: source
          },
          {
            title: this.$t('label.video-url'),
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
