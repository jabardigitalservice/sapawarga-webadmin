<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="video" :rules="rules" :statu-icon="true" label-width="160px">
          <el-form-item label="Judul Video" prop="title">
            <el-input v-model="video.title" type="text" placeholder="Judul Video" />
          </el-form-item>

          <el-form-item label="Kategori" prop="category_id">
            <InputCategory v-model="video.category_id" category-type="survey" prop="category" style="width: 100%" />
          </el-form-item>

          <el-form-item label="Sumber" prop="channel_id">
            <el-select v-model="video.channel_id" placeholder="Sumber">
              <el-option
                v-for="item in options"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="URL Berita" prop="source_url">
            <el-input v-model="video.source_url" type="text" placeholder="http://youtube.com" />
          </el-form-item>

          <el-form-item>
            <el-button v-if="isEdit" type="primary" :loading="loading">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading">{{ $t('crud.save-news') }}</el-button>

            <router-link :to="'/news/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import InputCategory from '@/components/InputCategory'

export default {
  components: {InputCategory},
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      loading: false,
      video: {
        title: null,
        category_id: null,
        channel_id: null,
        source_url: null
      },
      options: {},
      rules: {

      }
    }
  }
}
</script>

