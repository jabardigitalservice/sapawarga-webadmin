<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">{{ $t('label.newsImportant-detail') }}</a></p>

    <el-row>
      <el-col :sm="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.newsImportant-data') }}</span>
          </div>
          <el-table stripe :data="tableDataRecord" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content">
              <template slot-scope="{row}">
                <a v-if="validUrl(row.content)" :href="row.content" target="_blank" class="link-news-important">{{ row.content }}</a>
                <span v-else v-html="row.content" />
              </template>
            </el-table-column>
          </el-table>
          <el-table stripe :data="tableImageAttachment" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content">
              <img :src="image || imageNone" alt="" width="300" height="225">
            </el-table-column>
          </el-table>
          <el-table v-if="check" stripe :data="attachments" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content">
              <template slot-scope="{row}">
                <ul v-for="(data, index) in row.content" :key="index">
                  <li><a :href="data.file_url" target="_blank" class="link-news-important">{{ data.name }}</a><br></li>
                </ul>
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
import { validUrl } from '@/utils/htmlRender'

export default {
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
        const { title, category, source_url, content, image_path_url, attachments } = response.data
        this.image = response.data.image_path_url
        this.check = response.data.attachments

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
            title: this.$t('label.link'),
            content: source_url
          },
          {
            title: this.$t('label.newsImportant-description'),
            content: content
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
      })
    }
  }
}
</script>
