<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">{{ $t('label.newsImportant-detail') }}</a></p>

    <el-row>
      <el-col :sm="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.newsImportant-data') }}</span>
          </div>
          <detail-data :table-content-data="tableDataRecord" />

          <detail-data :table-content-data="tableImageAttachment" :input-image="image || imageNone" />

          <detail-data v-if="attachments.length > 0" :table-content-data="attachments" :input-list="attachments" />
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/newsImportant'
import { validUrl } from '@/utils/validate'
import DetailData from '@/components/DetailData'

export default {
  components: {
    DetailData
  },
  data() {
    return {
      tableDataRecord: [],
      tableImageAttachment: [],
      attachments: [],
      image: null,
      imageNone: require('@/assets/none.png'),
      check: null,
      lampiran: null
    }
  },
  async created() {
    const id = await this.$route.params && this.$route.params.id
    await this.getDetail(id)
  },
  methods: {
    validUrl,
    getDetail(id) {
      fetchRecord(id).then(response => {
        const { title, category, source_url, content, image_path_url, attachments, kabkota, likes_count } = response.data
        this.image = response.data.image_path_url
        this.check = response.data.attachments

        console.log(response.data)

        function logArrayAnswers(value, index, array) {
          return value
        }

        this.tableDataRecord = [
          {
            title: this.$t('label.newsImportant-title'),
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
            title: this.$t('label.link'),
            content: source_url
          },
          {
            title: this.$t('label.newsImportant-description'),
            content: content
          },
          {
            title: this.$t('label.newsImportant-likes-count'),
            content: likes_count
          },
          {
            title: this.$t('label.newsImportant-viewer'),
            content: 100
          }
        ]

        this.tableImageAttachment = [
          {
            title: this.$t('label.image'),
            content: image_path_url
          }
        ]

        this.attachments = [
          {
            title: this.$t('label.attachment'),
            content: attachments ? attachments.map(logArrayAnswers) : null
          }
        ]

        if (attachments.length < 1) {
          this.attachments.pop()
        }
      })
    }
  }
}
</script>
