<template>
  <div class="components-container">
    <p class="warn-content"><a href="#">Nomor Telepon Penting</a></p>
    <el-row :gutter="20">
      <el-col :sm="8" :lg="5">
        <AttachmentPhotoUpload type="phonebook_photo" :initial-url="form.cover_image_url" style="margin-bottom: 25px" @onUpload="photoUploaded" />
      </el-col>
      <el-col :sm="16" :lg="19">
        <el-form ref="form" :model="form" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item label="Nama Instansi" prop="name">
            <el-input v-model="form.name" placeholder="Contoh: Rumah Sakit Daerah Kota Tasikmalaya" />
          </el-form-item>

          <el-form-item label="Alamat Instansi" prop="address">
            <el-input v-model="form.address" />
          </el-form-item>

          <el-form-item label="Kategori Instansi" prop="category_id">
            <InputCategory v-model="form.category_id" category-type="phonebook" />
          </el-form-item>

          <el-form-item label="Deskripsi" prop="description">
            <el-input v-model="form.description" type="textarea" rows="5" />
          </el-form-item>

          <el-form-item label="Call Center" prop="seq">
            <el-radio v-model="form.seq" :label="1000" border @change="resetCallCenter">Ya</el-radio>
            <el-radio v-model="form.seq" :label="1" border @change="resetCallCenter">Tidak</el-radio>
          </el-form-item>

          <el-form-item v-if="form.seq === 1" label="Wilayah" prop="wilayah">
            <InputSelectArea
              :kabkota-id="form.kabkota_id"
              :kec-id="form.kec_id"
              :kel-id="form.kel_id"
              @changeKabkota="form.kabkota_id = $event"
              @changeKecamatan="form.kec_id = $event"
              @changeKelurahan="form.kel_id = $event"
            />
          </el-form-item>

          <el-form-item label="Nomor Telepon" prop="phone_numbers">
            <ListPhoneNumber v-model="form.phone_numbers" />
          </el-form-item>

          <el-form-item label="Koordinat Lokasi" prop="coordinates">
            <InputMap v-model="coordinates" />
          </el-form-item>

          <el-form-item>
            <el-button type="primary" :loading="loading" @click="submitForm">{{ isEdit ? $t('crud.save-update') : $t('crud.save-create') }}</el-button>
            <router-link :to="'/nomor-penting/index'">
              <el-button>{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, create, update } from '@/api/phonebooks'
import { validContainsSpecialCharacters, validCoordinate, containsWhitespace } from '@/utils/validate'

import InputSelectArea from '@/components/InputSelectArea'
import InputMap from '@/components/InputMap'
import InputCategory from '@/components/InputCategory'
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'

import ListPhoneNumber from './ListPhoneNumber'

const defaultForm = {
  name: null,
  address: null,
  description: null,
  category_id: null,
  kabkota_id: null,
  kec_id: null,
  kel_id: null,
  meta: null,
  seq: null,
  cover_image_path: null,
  cover_image_url: null,
  phone_numbers: [],
  latitude: null,
  longitude: null
}

export default {
  components: {
    InputSelectArea,
    InputMap,
    InputCategory,
    ListPhoneNumber,
    AttachmentPhotoUpload
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorNameNoSpecialCharacters = (rule, value, callback) => {
      if (validContainsSpecialCharacters(value)) {
        callback(new Error('Nama Instansi hanya boleh menggunakan huruf dan angka.'))
      }

      callback()
    }

    const validatorWilayah = (rule, value, callback) => {
      if (this.form.seq === 1 && (this.form.kabkota_id === null)) {
        callback(new Error('Wilayah harus diisi.'))
      }
      callback()
    }

    const validatorCoordinateRequired = (rule, value, callback) => {
      if (_.isEmpty(this.coordinates[0]) === false && _.isEmpty(this.coordinates[1]) === true) {
        callback(new Error('Koordinat Lokasi harus diisi.'))
      }

      if (_.isEmpty(this.coordinates[0]) === true && _.isEmpty(this.coordinates[1]) === false) {
        callback(new Error('Koordinat Lokasi harus diisi.'))
      }

      callback()
    }

    const validatorCoordinateInputNumber = (rule, value, callback) => {
      if (_.isEmpty(this.coordinates[0]) === false && validCoordinate(this.coordinates[0]) === false) {
        callback(new Error('Koordinat Lokasi hanya boleh menggunakan angka, titik, - atau +'))
      }

      if (_.isEmpty(this.coordinates[1]) === false && validCoordinate(this.coordinates[1]) === false) {
        callback(new Error('Koordinat Lokasi hanya boleh menggunakan angka, titik, - atau +'))
      }

      callback()
    }

    const whitespaceText = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Text yang diisi tidak valid.'))
      }
      callback()
    }

    const validatorCoordinateFinite = (rule, value, callback) => {
      if (_.isEmpty(this.coordinates[0]) === false && isFinite(this.coordinates[0]) === false) {
        callback(new Error('Koordinat Lokasi tidak sesuai.'))
      }

      if (_.isEmpty(this.coordinates[1]) === false && isFinite(this.coordinates[1]) === false) {
        callback(new Error('Koordinat Lokasi tidak sesuai.'))
      }

      callback()
    }

    return {
      modalAddPhoneNumberVisible: false,
      form: Object.assign({}, defaultForm),
      coordinates: [null, null],
      loading: false,
      rules: {
        name: [
          { required: true, message: 'Nama Instansi harus diisi.', trigger: 'blur' },
          { validator: validatorNameNoSpecialCharacters, trigger: 'blur' },
          { validator: whitespaceText, trigger: 'blur' }
        ],
        address: [
          { validator: whitespaceText, trigger: 'blur' }
        ],
        category_id: [
          { required: true, message: 'Kategori Instansi harus diisi.', trigger: 'change' }
        ],
        description: [
          { validator: whitespaceText, trigger: 'blur' }
        ],
        seq: [
          { required: true, message: 'Call Center harus diisi.', trigger: 'blur' }
        ],
        wilayah: [
          { validator: validatorWilayah, trigger: 'change' }
        ],
        coordinates: [
          { validator: validatorCoordinateRequired, trigger: 'change' },
          { validator: validatorCoordinateInputNumber, trigger: 'change' },
          { validator: validatorCoordinateFinite,
            trigger: 'change' }
        ],
        kec_id: [
          { required: true, message: 'Kecamatan harus diisi.', trigger: 'blur' }
        ],
        kel_id: [
          { required: true, message: 'Kelurahan harus diisi.', trigger: 'blur' }
        ],
        phone_numbers: [
          { required: true, message: 'Harus memiliki minimal 1 Nomor Telepon.', trigger: 'blur' }
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
      this.form.phone_numbers = []
    }
  },
  methods: {
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.form = response.data

        const { latitude, longitude } = response.data

        this.coordinates = [latitude, longitude]
      }).catch(err => {
        console.log(err)
      })
    },

    resetCallCenter(value) {
      if (value === 1000) {
        this.form.kabkota_id = null
        this.form.kec_id = null
        this.form.kel_id = null
      }
    },

    photoUploaded(path, url) {
      this.form.cover_image_path = path
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

        data.latitude = this.coordinates[0]
        data.longitude = this.coordinates[1]

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.success(this.$t('crud.update-success'))

          this.$router.push('/nomor-penting/index')
        } else {
          await create(data)
          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/nomor-penting/index')
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
