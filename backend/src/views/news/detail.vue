<template>
  <div class="app-container news-detail">
    <el-row :gutter="10">
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('news.news-content-header') }}</span>
          </div>
          <detail-data :table-content-data="tableDataNews" />
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import moment from 'moment'
import newsApi from '@/api/news'
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
      newsApi.fetchRecord(this.id).then(response => {
        const { status_label, title, channel, source_date, source_url, content, total_viewers, kabkota } = response.data
        this.news = response.data

        this.tableDataNews = [
          {
            title: this.$t('news.news-title'),
            content: title || 'Error'
          },
          {
            title: this.$t('label.source'),
            content: (channel ? channel.name : 'Error')
          },
          {
            title: this.$t('news.news-target'),
            content: kabkota ? kabkota.name : this.$t('label.area-jabar')
          },
          {
            title: this.$t('news.news-date'),
            content: (source_date ? moment(source_date).format('D MMMM YYYY') : 'Error')
          },
          {
            title: this.$t('label.status'),
            content: status_label || '-'
          },
          {
            title: this.$t('news.news-url'),
            content: source_url || 'Error'
          },
          {
            title: this.$t('label.news-content'),
            content: this.strip(content) || 'Error'
          },
          {
            title: this.$t('news.news-viewer'),
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
