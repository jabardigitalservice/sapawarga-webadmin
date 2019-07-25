<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="video" :rules="rules" :statu-icon="true" label-width="160px">
          <el-form-item label="Judul Video" prop="title">
            <el-input v-model="video.title" type="text" name="title" placeholder="Judul Video, minimal 10 karakter" />
          </el-form-item>

          <el-form-item label="Kategori" prop="category_id">
            <InputCategory v-model="video.category_id" name="category_id" category-type="survey" prop="category" style="width: 100%" />
          </el-form-item>

          <el-form-item label="Target" prop="target">
            <el-select v-model="video.kabkota_id" name="target" placeholder="Pilih Target">
              <el-option
                v-for="item in area"
                :key="item.id"
                :value="item.id"
                :label="item.name"
              />
            </el-select>
          </el-form-item>
          
          <el-form-item label="Set Prioritas" prop="priority">
            <el-select v-model="video.seq" name="priority" placeholder="Pilih Prioritas">
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
import { containsWhitespace, validYoutubeUrl } from '@/utils/validate'

export default {
  components: {InputCategory},
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorTitleWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Judul Video yang diisi tidak valid'))
      }
      callback()
    }

    const validatorUrl = (rule, value, callback) => {
      if (validYoutubeUrl(value) === false) {
        callback(new Error('URL Video tidak valid'))
      }
      callback()
    }

    return {
      loading: false,
      video: {
        title: null,
        category_id: null,
        channel_id: null,
        source_url: null,
        priority: null,
      },
      options: {},
      priorityOptions: [
        { label: 1, value: 1 },
        { label: 2, value: 2 },
        { label: 3, value: 3 },
        { label: 4, value: 4 },
        { label: 5, value: 5 }
      ],
      statusOptions: [
        { label: 'Aktif', value: 10 },
        { label: 'Tidak aktif', value: 0 },
      ],
      rules: {
        title: [
          { required: true, message: 'Judul Video harus diisi', trigger: 'blur' },
          { min: 10, message: 'Judul Video minimal 10 karakter', trigger: 'blur' },
          { max: 100, message: 'Judul Video maksimal 100 karakter', trigger: 'blur' },
          { validator: validatorTitleWhitespace, trigger: 'blur' }
        ], 
        category_id: [
          { required: true, message: 'Kategori harus diisi', trigger: 'change' }
        ],
        priority: [
          { required: true, message: 'Prioritas harus diisi', trigger: 'change' }
        ],
        channel_id: [
          { required: true, message: 'Sumber harus diisi', trigger: 'change' }
        ],
        source_url: [
          { required: true, message: 'URL Video harus diisi', trigger: 'blur' },
          { validator: validatorUrl, trigger: 'blur' }
        ],
        status: [
          { required: true, message: 'Status harus diisi', trigger: 'change' }
        ],
        target: [
          { required: true, message: 'Target harus diisi', trigger: 'change' }
        ]
      }
    }
  }
}
</script>

