<template>
  <div>
    <el-row v-for="(element, index) in tableContentData" :key="index" :gutter="10">
      <el-col :xs="24" :sm="6">{{ element.title }} {{ device==='mobile'?':':'' }}</el-col>
      <el-col :xs="24" :sm="18">
        <div v-if="inputImage"><img :src="inputImage" alt="" :style="width"></div>
        <div v-else-if="inputList">
          <ul v-for="(data, arrayIndex) in element.content" :key="arrayIndex">
            <li><a :href="data.file_url" target="_blank" class="link-news-important">{{ data.name }}</a><br></li>
          </ul>
        </div>
        <div v-else-if="validUrl(element.content)"><a :href="element.content" target="_blank" class="link">{{ element.content }}</a></div>
        <div v-else-if="isContainHtmlTags(element.content)" class="is--rich-text" v-html="element.content" />
        <div v-else><span>{{ element.content }}</span></div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { isContainHtmlTags, validUrl } from '@/utils/validate'

export default {
  name: 'DetailData',
  props: {
    tableContentData: {
      type: Array,
      default: null,
      require: true
    },
    inputImage: {
      type: String,
      default: null
    },
    inputList: {
      type: Array,
      default: null
    },
    width: {
      type: String,
      default: null,
      require: false
    }
  },
  computed: {
    ...mapGetters([
      'device'
    ])
  },
  methods: {
    isContainHtmlTags,
    validUrl
  }
}
</script>

<style lang="scss" scoped>
.el-row {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  padding-bottom: 10px;
  border-bottom: 1px solid #e6ebf5;

  & img {
    width: 100%;
    height: auto;
    max-width: 300px;
  }

  & .el-col {
    hyphens: auto;
    word-wrap: break-word;
    overflow-wrap: break-word;

    & .is--rich-text {
      line-height: 23px;
    }
  }
}

@media screen and (max-width: 768px) {
  .el-row {
    display: block;

    & .el-col {
      &:first-child {
        margin-bottom: 10px;
      }
    }
  }
}
</style>
