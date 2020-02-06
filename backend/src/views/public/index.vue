<template>
  <div class="news-important-public component-container">
    <el-row>
      <el-col :sm="{span:24}" :md="{span:24, offset:6}" :lg="{span:12, offset:6}">
        <div class="header">
          <p>{{ $t('categoriTypes.news_important') }}</p>
        </div>
        <img :src="data.image_path_url ? data.image_path_url : imageNone" alt="info-penting">
        <div class="text">
          <h2>{{ data.title }}</h2>
          <h5>{{ parsingDatetime(data.created_at, 'D MMMM YYYY HH:mm') }}</h5>
          <div id="content" v-html="data.content" />
          <div class="source_url">
            <p class="title">{{ $t('label.source') }}:</p>
            <a class="url" target="_blank" :href="data.source_url">
              <p>{{ data.source_url }}</p>
            </a>
          </div>
          <div v-if="length > 0">
            <p class="title source_url attachment-title">{{ $t('label.attachment') }}:</p>
            <div v-for="(item, index) in data.attachments" :key="index">
              <a :href="item.file_url" :target="target" @click="setTarget(item.name)">
                <el-button class="attachment" type="info" size="medium" icon="el-icon-download" circle />
                <span class="source_url">{{ item.name }}</span>
              </a>
            </div>
          </div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import { fetchRecord } from '@/api/newsImportant'
import { parsingDatetime } from '@/utils/datetimeToString'
const axios = require('axios')
export default {
  data() {
    return {
      data: [],
      imageNone: require('@/assets/placeholder.png'),
      target: '_self',
			length: null,
      id: null,
      url: process.env.VUE_APP_BASE_API
    }
  },
  mounted() {
		this.id = this.$route.query && this.$route.query.id
    this.getData(this.id)
  },
  methods: {
    parsingDatetime,
    setTarget(name) {
      const extension = name.split('.').pop()
      if (extension === 'jpg' || extension === 'png' || extension === 'jpeg' || extension === 'pdf') {
        this.target = '_blank'
      } else {
        this.target = '_self'
      }
    },
    async getData(id) {
      try {
        const response = await axios.get(this.url + `news-important/${id}`)
        this.data = response.data.data
        console.log(this.url)

      } catch(error) {
        console.log(error)
      }
    }
  }
}
</script>
