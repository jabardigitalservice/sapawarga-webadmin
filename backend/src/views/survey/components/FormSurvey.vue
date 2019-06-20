<template>
  <div>
    <el-row :gutter="20">
      <el-col :sm="24">
        <el-form ref="form" :model="form" :rules="rules" :status-icon="true" label-width="160px">

          <el-form-item label="Judul Survey" prop="title">
            <el-input v-model="form.title" type="text" placeholder="Judul Survey" />
          </el-form-item>

          <el-form-item label="Kategori" prop="category_id">
            <InputCategory v-model="form.category_id" category-type="survey" prop="category" />
          </el-form-item>

          <el-form-item label="Tanggal Mulai" prop="start_date">
            <el-date-picker
              v-model="form.start_date"
              type="date"
              :editable="false"
              :clearable="false"
              format="dd-MM-yyyy"
              placeholder="Pilih Tanggal"
            />
          </el-form-item>

          <el-form-item label="Tanggal Berakhir" prop="end_date">
            <el-date-picker
              v-model="form.end_date"
              type="date"
              :editable="false"
              :clearable="false"
              format="dd-MM-yyyy"
              placeholder="Pilih Tanggal"
            />
          </el-form-item>

          <el-form-item label="URL Survey" prop="external_url">
            <el-input v-model="form.external_url" type="text" placeholder="http://form.google.com" />
          </el-form-item>

          <el-form-item>
            <el-button v-if="form.status === null || form.status === 0" :loading="loading" @click="submitDraft">{{ $t('crud.draft') }}</el-button>
            <el-button type="primary" :loading="loading" @click="submitProcess">{{ $t('crud.save-publish') }}</el-button>

            <router-link :to="'/survey/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import moment from 'moment'

import { fetchRecord, create, update } from '@/api/survey'
import { validUrl } from '@/utils/validate'

import InputCategory from '@/components/InputCategory'

const defaultForm = {
  title: null,
  category_id: null,
  start_date: null,
  end_date: null,
  external_url: null,
  status: null
}

export default {
  components: {
    InputCategory
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorStartDate = (rule, value, callback) => {
      const startDate = moment(this.form.start_date)
      const endDate = moment(this.form.end_date)

      if (endDate.isBefore(startDate) === true) {
        callback(new Error('Tanggal Mulai harus sebelum Tanggal Selesai.'))
      }

      callback()
    }

    const validatorEndDate = (rule, value, callback) => {
      const startDate = moment(this.form.start_date)
      const endDate = moment(this.form.end_date)

      if (startDate.isAfter(endDate) === true) {
        callback(new Error('Tanggal Berakhir harus setelah Tanggal Mulai.'))
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
        title: [
          { required: true, message: 'Judul Survey harus diisi.', trigger: 'blur' }
        ],
        category_id: [
          { required: true, message: 'Kategori harus diisi.', trigger: 'change' }
        ],
        start_date: [
          { required: true, message: 'Tanggal Mulai harus diisi.', trigger: 'change' },
          { validator: validatorStartDate, trigger: 'change' }
        ],
        end_date: [
          { required: true, message: 'Tanggal Berakhir harus diisi.', trigger: 'change' },
          { validator: validatorEndDate, trigger: 'change' }
        ],
        external_url: [
          { required: true, message: 'URL Survey harus diisi.', trigger: 'blur' },
          { validator: validatorUrl, trigger: 'blur' }
        ]
      },
      tempRoute: {}
    }
  },
  computed: {
    //
  },
  created() {
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
      }).catch(err => {
        console.log(err)
      })
    },

    async submitDraft() {
      this.form.status = 0
      await this.submitForm()
    },

    async submitProcess() {
      this.form.status = 10
      await this.submitForm()
    },

    async submitForm() {
      const valid = await this.$refs.form.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true

        const data = {}

        Object.assign(data, this.form)

        data.start_date = moment(data.start_date).format('YYYY-MM-DD')
        data.end_date = moment(data.end_date).format('YYYY-MM-DD')

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.success(this.$t('crud.update-success'))

          this.$router.push('/survey/index')
        } else {
          await create(data)
          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/survey/index')
        }
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
