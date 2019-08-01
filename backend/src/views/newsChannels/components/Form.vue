<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="form" :rules="rules" :status-icon="true" label-width="210px">

          <el-form-item label="Sumber Berita" prop="name">
            <el-input v-model="form.name" type="text" placeholder="Sumber Berita" />
          </el-form-item>

          <el-form-item label="Tautan Logo Sumber Berita" prop="icon_url">
            <el-input v-model="form.icon_url" type="text" placeholder="http://www" />
          </el-form-item>

          <el-form-item label="Tautan" prop="website">
            <el-input v-model="form.website" type="text" placeholder="http://www" />
          </el-form-item>

          <el-form-item>
            <el-button type="primary" :loading="loading" @click="submitProcess">{{ $t('crud.save-publish') }}</el-button>

            <router-link :to="'/news-channels/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, create } from '@/api/newsChannels'
import { containsWhitespace, validUrl } from '@/utils/validate'

const defaultForm = {
  name: null,
  website: null,
  icon_url: null,
  status: 10
}

export default {
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorTextWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Teks yang diisi tidak valid.'))
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
      form: Object.assign({}, defaultForm),
      loading: false,
      rules: {
        name: [
          { required: true, message: 'Judul sumber berita harus diisi.', trigger: 'blur' },
          { min: 10, message: 'Judul sumber berita minimal 10 karakter', trigger: 'blur' },
          { max: 100, message: 'Judul sumber berita maksimal 100 karakter', trigger: 'blur' },
          { validator: validatorTextWhitespace, trigger: 'blur' }
        ],
        website: [
          { required: true, message: 'URL harus diisi.', trigger: 'blur' },
          { validator: validatorUrl, trigger: 'blur' }
        ],
        icon_url: [
          { required: true, message: 'URL harus diisi.', trigger: 'blur' },
          { validator: validatorUrl, trigger: 'blur' }
        ]
      }
    }
  },
  mounted() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    } else {
      this.form = Object.assign({}, defaultForm)
    }
  },
  methods: {
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.form = response.data
      }).catch(err => console.log(err))
    },

    async submitProcess() {
      const valid = await this.$refs.form.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true

        const data = {}

        Object.assign(data, this.form)

        if (this.isEdit) {
          // TODO: edit
          /* const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.success(this.$t('crud.update-success'))

          this.$router.push('/news-channels/index') */
        } else {
          await create(data)
          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/news-channels/index')
        }
      } catch (err) {
        console.log(err)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
