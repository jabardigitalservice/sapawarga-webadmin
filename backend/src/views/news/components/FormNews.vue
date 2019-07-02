<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload type="news_photo" :initial-url="news.cover_url" style="margin-bottom: 25px" @onUpload="photoUploaded" />
      </el-col>
      <el-col :xs="24" :sm="16" :lg="19">
        <el-alert
          v-if="news.status === 10"
          type="error"
          description="Data sudah aktif, Anda tidak bisa mengubah data ini."
          show-icon
          style="margin-bottom: 15px"
        />

        <el-form ref="news" :model="news" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item label="Judul Berita" prop="title">
            <el-input v-model="news.title" type="text" placeholder="Judul Berita" />
          </el-form-item>

          <el-form-item label="Sumber" prop="channel_id">
            <el-select v-model="news.channel_id" placeholder="Pilih Sumber">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="Tanggal Berita" prop="source_date">
            <el-date-picker
              v-model="news.source_date"
              type="date"
              :editable="false"
              :clearable="false"
              format="dd-MM-yyyy"
              placeholder="Pilih Tanggal"
            />
          </el-form-item>

          <el-form-item v-if="isEdit" label="Status" prop="status">
            <el-select v-model="news.status" placeholder="Pilih status">
              <el-option
                v-for="item in statusOptions"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-form-item>

          <el-form-item v-if="isEdit" label="Set Prioritas" prop="featured">
            <el-select v-model="news.featured" placeholder="Pilih prioritas">
              <el-option
                v-for="item in featuredOptions"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="URL Berita" prop="source_url">
            <el-input v-model="news.source_url" type="text" placeholder="http://form.google.com" />
          </el-form-item>

          <el-form-item label="Konten Berita" prop="content">
            <div>
              <tinymce v-model="news.content" :height="300" />
            </div>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-news') }}</el-button>

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
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'
import { containsWhitespace, validUrl } from '@/utils/validate'
import { fetchRecord, create, update } from '@/api/news'
import Tinymce from '@/components/Tinymce'
import moment from 'moment'
export default {
  components: { Tinymce, AttachmentPhotoUpload },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorTitleWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Judul Berita yang diisi tidak valid'))
      }
      callback()
    }

    const validatorTitleWhitespaceContent = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Konten Berita yang diisi tidak valid'))
      }
      callback()
    }

    const validatorUrl = (rule, value, callback) => {
      if (validUrl(value) === false) {
        callback(new Error('URL tidak valid'))
      }

      callback()
    }

    return {
      loading: false,
      news: {
        title: null,
        channel_id: null,
        source_date: moment().startOf('day'),
        source_url: null,
        content: null,
        cover_path: null,
        cover_url: null
      },
      options: [
        {
          value: 1,
          label: 'Detik'
        },
        {
          value: 2,
          label: 'Kompas'
        },
        {
          value: 3,
          label: 'Tempo'
        },
        {
          value: 4,
          label: 'Pikiran'
        },
        {
          value: 5,
          label: 'Tribun News'
        },
        {
          value: 6,
          label: 'Republika'
        }
      ],
      rules: {
        title: [
          {
            required: true,
            message: 'Judul Berita harus diisi',
            trigger: 'blur'
          },
          {
            min: 10,
            message: 'Judul Berita minimal 10 karakter',
            trigger: 'blur'
          },
          {
            max: 100,
            message: 'Judul Berita maksimal 100 karakter',
            trigger: 'blur'
          },
          {
            validator: validatorTitleWhitespace,
            trigger: 'blur'
          }
        ],
        channel_id: [
          {
            required: true,
            message: 'Sumber Berita harus diisi',
            trigger: 'change'
          }
        ],
        source_date: [
          {
            required: true,
            message: 'Tanggal harus diisi',
            trigger: 'change'
          }
        ],
        source_url: [
          {
            required: true,
            message: 'URL Berita harus diisi',
            trigger: 'blur'
          },
          {
            validator: validatorUrl,
            trigger: 'blur'
          }
        ],
        content: [
          {
            required: true,
            message: 'Konten Berita harus diisi',
            trigger: 'blur'
          },
          {
            validator: validatorTitleWhitespaceContent,
            trigger: 'blur'
          }
        ]
      }
    }
  },
  methods: {
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.news = response.data
        console.log(response.data)
      }).catch(err => {
        console.log(err)
      })
    },

    photoUploaded(path, url) {
      this.news.cover_path = path
      console.log(this.news.cover_path)
    },

    async submitForm() {
      const valid = await this.$refs.news.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true

        const data = {}

        Object.assign(data, this.news)

        data.source_date = moment(data.source_date).format('YYYY-MM-DD')

        data.status = 0
        data.featured = false

        console.log(data)

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.success(this.$t('crud.create-success'))

          this.$route.push('/news/index')
        } else {
          await create(data)
          console.log(data)

          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/news/index')
        }
      } catch (e) {
        const imageError = e.response.data.data[0].field
        if (imageError === 'cover_path') {
          this.$message.error(this.$t('errors.news-image-null'))
        }
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
