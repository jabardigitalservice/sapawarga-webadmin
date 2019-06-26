<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <!-- <el-alert
          v-if="form.status === 10"
          type="error"
          description="Data sudah aktif, Anda tidak bisa mengubah data ini."
          show-icon
          style="margin-bottom: 15px"
        /> -->

        <el-form ref="news" :model="news" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item label="Judul Berita" prop="title">
            <el-input v-model="news.title" type="text" placeholder="Judul Berita" />
          </el-form-item>

          <el-form-item label="Sumber" prop="source">
            <el-select v-model="news.source" placeholder="Pilih Sumber">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.value"
                :value="item.value"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="Tanggal Berita" prop="date">
            <el-date-picker
              v-model="news.date"
              type="date"
              :editable="false"
              :clearable="false"
              format="dd-MM-yyyy"
              placeholder="Pilih Tanggal"
            />
          </el-form-item>

          <el-form-item label="URL Berita" prop="external_url">
            <el-input v-model="news.external_url" type="text" placeholder="http://form.google.com" />
          </el-form-item>

          <el-form-item label="Konten Berita" prop="content">
            <el-input
              v-model="news.content"
              type="textarea"
              :rows="10"
              placeholder="Konten Berita"
            />
          </el-form-item>

          <el-form-item>
            <el-button type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-news') }}</el-button>
          </el-form-item>

        </el-form>

      </el-col>
    </el-row>
  </div>
</template>

<script>
import { containsWhitespace, validUrl } from '@/utils/validate'
export default {
  data() {
    const validatorTitleWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Judul Berita yang diisi tidak valid'))
      }
      callback()
    }

    const validatorTitleWhitespaceContent = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Judul Berita yang diisi tidak valid'))
      }
      callback()
    }

    const validatorUrl = (rule, value, callback) => {
      if (validUrl(value) === false) {
        callback(new Error('URL tidak valid.'))
      }

      callback()
    }

    return {
      loading: false,
      news: {
        title: null,
        source: null,
        date: null,
        external_url: null,
        content: null
      },
      options: [
        {
          value: 'Detik'
        },
        {
          value: 'Kompas'
        },
        {
          value: 'Tempo'
        },
        {
          value: 'Pikiran'
        },
        {
          value: 'Tribun News'
        },
        {
          value: 'Republika'
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
        source: [
          {
            required: true,
            message: 'Sumber Berita harus diisi',
            trigger: 'change'
          }
        ],
        date: [
          {
            required: true,
            message: 'Tanggal harus diisi',
            trigger: 'change'
          }
        ],
        external_url: [
          {
            required: true,
            message: 'URL Survey harus diisi',
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
    async submitForm() {
      const valid = await this.$refs.news.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true

        const data = {}

        Object.assign(data, this.news)

        // call api

      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
