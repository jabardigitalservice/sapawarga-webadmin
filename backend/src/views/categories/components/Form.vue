<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="form" :rules="rules" :status-icon="true" label-width="160px">

          <el-form-item label="Nama Kategori" prop="name">
            <el-input v-model="form.name" type="text" placeholder="Nama Kategori" />
          </el-form-item>

          <el-form-item label="Fitur" prop="type">
            <el-select v-model="form.type" placeholder="Pilih Fitur">
              <el-option
                v-for="item in optionType"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="Status" prop="status">
            <el-select v-model="form.status" placeholder="Pilih Status">
              <el-option
                v-for="item in optionStatus"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" :loading="loading" @click="submitProcess">{{ $t('crud.save-publish') }}</el-button>

            <router-link :to="'/categories/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, create, update, fetchTypes } from '@/api/categories'
import { containsWhitespace } from '@/utils/validate'

const defaultForm = {
  name: null,
  type: null,
  status: null
}

export default {
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorTitleWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Judul kategori yang diisi tidak valid.'))
      }

      callback()
    }

    return {
      form: Object.assign({}, defaultForm),
      loading: false,
      rules: {
        name: [
          { required: true, message: 'Judul kategori harus diisi.', trigger: 'blur' },
          { min: 10, message: 'Judul kategori minimal 10 karakter', trigger: 'blur' },
          { max: 100, message: 'Judul kategori maksimal 100 karakter', trigger: 'blur' },
          { validator: validatorTitleWhitespace, trigger: 'blur' }
        ],
        type: [
          { required: true, message: 'Fitur harus diisi.', trigger: 'change' }
        ],
        status: [
          { required: true, message: 'Status harus diisi.', trigger: 'change' }
        ]
      },
      tempRoute: {},
      optionType: [],
      optionStatus: [
        {
          id: 10,
          name: 'Enable'
        },
        {
          id: 0,
          name: 'Disable'
        }
      ]
    }
  },
  mounted() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    } else {
      this.form = Object.assign({}, defaultForm)
    }
    this.fetchDataTypes()
  },
  methods: {
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.form = response.data
      }).catch(err => console.log(err))
    },

    fetchDataTypes() {
      fetchTypes().then(response => {
        this.optionType = response.data
      }).catch(err => console.error(err))
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
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.success(this.$t('crud.update-success'))

          this.$router.push('/categories/index')
        } else {
          await create(data)
          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/categories/index')
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
