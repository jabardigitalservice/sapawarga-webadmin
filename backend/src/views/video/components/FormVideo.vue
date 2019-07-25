<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="video" :rules="rules" :statu-icon="true" label-width="160px">
          <el-form-item label="Judul Video" prop="title">
            <el-input v-model="video.title" type="text" placeholder="Judul Video, minimal 10 karakter" />
          </el-form-item>

          <el-form-item label="Kategori" prop="category_id">
            <InputCategory v-model="video.category_id" category-type="survey" prop="category" style="width: 100%" />
          </el-form-item>

          <el-form-item label="Target" prop="target">
            <el-select v-model="video.target" placeholder="Pilih Target">
              
            </el-select>
          </el-form-item>

          <el-form-item label="Set Prioritas" prop="priority">
            <el-select v-model="video.priority" placeholder="Pilih Prioritas">
              <el-option
                v-for="item in priorityOptions"
                :key="item.id"
                :value="item.value"
                :label="item.label"
              />
            </el-select>
          </el-form-item> 

          <el-form-item label="Sumber" prop="channel_id">
            <el-select v-model="video.channel_id" placeholder="Pilih Sumber">
              <el-option
                v-for="item in options"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="URL Berita" prop="source_url">
            <el-input v-model="video.source_url" type="text" placeholder="https://www.youtube.com/watch?v=ejThfEGcN3I" />
          </el-form-item>

          <el-form-item label="Status" prop="status">
            <el-select v-model="video.status" placeholder="Pilih Status" style="width: 100%">
              <el-option
                v-for="item in statusOptions"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-form-item>

          <el-form-item>
            <el-button v-if="isEdit" type="primary" :loading="loading">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading">{{ $t('crud.save-video') }}</el-button>

            <router-link :to="'/video/index'">
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

