<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="video" :model="video" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item label="Judul Video" prop="title">
            <el-input v-model="video.title" type="text" name="title" placeholder="Judul Video, minimal 10 karakter" />
          </el-form-item>

          <el-form-item label="Kategori" prop="category_id">
            <InputCategory v-model="video.category_id" name="category_id" category-type="survey" prop="category" style="width: 100%" />
          </el-form-item>

          <el-form-item label="Target" prop="kabkota_id">
            <el-select v-model="video.kabkota_id" :disabled="checkStaff" placeholder="Pilih Target">
              <el-option 
                v-for="item in area"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="Set Prioritas" prop="seq">
            <el-select v-model="video.seq" filterable placeholder="Pilih Prioritas">
              <el-option
                v-for="item in priorityOptions"
                :key="item.id"
                :value="item.value"
                :label="item.label"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="Sumber" prop="source">
            <el-select v-model="video.source" name="source" placeholder="Pilih Sumber" disabled />
          </el-form-item>

          <el-form-item label="URL Berita" prop="video_url">
            <el-input v-model="video.video_url" type="text" name="video_url" placeholder="https://www.youtube.com/watch?v=ejThfEGcN3I" />
          </el-form-item>

          <el-form-item>
            <el-button v-if="isEdit" type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-video') }}</el-button>

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
import { requestArea } from '@/api/staff'
import { create, update, fetchRecord } from '@/api/video'
import checkPermission from '@/utils/permission'

export default {
  components: { InputCategory },
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
        source: 'YOUTUBE',
        video_url: null,
        kabkota_id: null,
        seq: null,
        status: null,
        kabkota: null
      },
      checkStaff: false,
      area: null,
      priorityOptions: [
        { label: 1, value: 1 },
        { label: 2, value: 2 },
        { label: 3, value: 3 },
        { label: 4, value: 4 },
        { label: 5, value: 5 }
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
        seq: [
          { required: true, message: 'Prioritas Berita harus diisi', trigger: 'change' }
        ],
        source: [
          { required: true, message: 'Sumber harus diisi', trigger: 'change' }
        ],
        video_url: [
          { required: true, message: 'URL Video harus diisi', trigger: 'blur' },
          { validator: validatorUrl, trigger: 'blur' }
        ],
        kabkota_id: [
          { required: true, message: 'Target harus diisi', trigger: 'change' }
        ]
      }
    }
  },
  created() {
    this.getArea()
  },
  methods: {
    getArea() {
      requestArea().then(response => {
        this.area = response.data.items
        this.area.unshift({ id: 1, name: 'JAWA BARAT' })
      })
    }
  }
}
</script>

