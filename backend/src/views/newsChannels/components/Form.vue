<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="form" :rules="rules" :status-icon="true" label-width="210px">

          <el-form-item label="Sumber Berita" :prop="validateName">
            <el-input v-model="form.name" type="text" placeholder="Sumber Berita" @focus="changePropName" />
          </el-form-item>

          <el-form-item label="Tautan Logo Sumber Berita" prop="icon_url">
            <el-input v-model="form.icon_url" type="text" placeholder="http://www" />
          </el-form-item>

          <el-form-item label="Tautan" :prop="validateWebsite">
            <el-input v-model="form.website" type="text" placeholder="http://www" @focus="changePropWebsite" />
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
      validateWebsite: 'website',
      validateName: 'name',
      rules: {
        name: [
          { required: true, message: 'Sumber Berita harus diisi.', trigger: 'blur' },
          { min: 5, message: 'Sumber Berita minimal 5 karakter', trigger: 'blur' },
          { max: 25, message: 'Sumber Berita maksimal 25 karakter', trigger: 'blur' },
          { validator: validatorTextWhitespace, trigger: 'blur' }
        ],
        errorName: [
          { required: true, message: 'Sumber Berita sudah digunakan', trigger: 'change' }
        ],
        website: [
          { required: true, message: 'URL harus diisi.', trigger: 'blur' },
          { validator: validatorUrl, trigger: 'blur' }
        ],
        errorWebsite: [
          { required: true, message: 'Website Sumber Berita sudah digunakan', trigger: 'change' }
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
      } catch (error) {
        const messageApi = error.response.data.data
        const messageList = []
        let messageJoin = null

        messageApi.forEach(element => {
          messageList.push(element.message)
          messageJoin = messageList.join(' Dan ')
        })
        this.$message.error(this.$t(messageJoin))

        if (messageApi[0].field === 'name' && messageApi[1].field === 'website') {
          this.form.name = null
          this.form.website = null
          this.validateName = 'errorName'
          this.validateWebsite = 'errorWebsite'
        } else if (messageApi[0].field === 'website') {
          this.form.website = null
          this.validateWebsite = 'errorWebsite'
        } else if (messageApi[0].field === 'name') {
          this.form.name = null
          this.validateName = 'errorName'
        }
      } finally {
        this.loading = false
      }
    },
    changePropName() {
      if (this.validateName === 'errorName') {
        this.validateName = 'name'
      } else {
        this.validateName = 'name'
      }
    },
    changePropWebsite() {
      if (this.validateWebsite === 'errorWebsite') {
        this.validateWebsite = 'website'
      } else {
        this.validateWebsite = 'website'
      }
    }

  }
}
</script>
