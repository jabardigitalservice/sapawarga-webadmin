<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload type="banner_photo" :initial-url="newsImportant.image_path_url" style="margin-bottom: 25px" @onUpload="photoUploaded" />
      </el-col>
      <el-col :xs="24" :sm="13" :lg="16">
        <el-form id="newsImportant" ref="newsImportant" :model="newsImportant" :rules="rules" :status-icon="true" label-width="150px" label-position="right">
          <el-form-item :label="$t('label.title')" prop="title">
            <el-input v-model="newsImportant.title" type="text" name="title" :placeholder="$t('label.newsImportant-title')" />
          </el-form-item>
          <el-form-item :label="$t('label.category')" prop="category_id">
            <InputCategory v-model="newsImportant.category_id" category-type="news_important" prop="category" />
          </el-form-item>
          <el-form-item :label="$t('label.newsImportant-description')">
            <el-input
              v-model="newsImportant.description"
              type="textarea"
              name="description"
              :rows="5"
              :placeholder="$t('label.newsImportant-description')"
            />
          </el-form-item>
          <el-form-item>
            <el-button v-if="isEdit" type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-create') }}</el-button>

            <router-link :to="'/news-important/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'
import InputCategory from '@/components/InputCategory'
export default {
  components: { AttachmentPhotoUpload, InputCategory },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      loading: false,
      newsImportant: {
        title: null,
        category_id: null,
        description: null
      },
      rules: {

      }
    }
  },
  methods: {
    photoUploaded() {

    }
  }
}
</script>
