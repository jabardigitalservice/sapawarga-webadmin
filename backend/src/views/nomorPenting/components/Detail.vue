<template>
  <div class="components-container">
    <p class="warn-content"><a href="#">Nomor Telepon Penting</a></p>
    <el-row :gutter="20">
      <el-col :span="5">
        Gambar
      </el-col>
      <el-col :span="19">
        <el-form ref="form" :model="form" :rules="rules" label-width="160px">
          <el-form-item label="Nama Instansi" prop="name" required>
            <el-input v-model="form.name" />
          </el-form-item>

          <el-form-item label="Alamat Instansi" prop="address">
            <el-input v-model="form.address" />
          </el-form-item>

          <el-form-item label="Kategori Instansi" required prop="category_id">
            <InputCategory v-model="form.category_id"></InputCategory>
          </el-form-item>

          <el-form-item label="Deskripsi">
            <el-input v-model="form.description" type="textarea" rows="5" prop="description" />
          </el-form-item>

          <el-form-item label="Call Center" required prop="seq">
            <el-radio v-model="form.seq" :label="1000">Ya</el-radio>
            <el-radio v-model="form.seq" :label="1">Tidak</el-radio>
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

          <el-form-item label="Nomor Telepon" required prop="phone_numbers">
            <ListPhoneNumber v-model="form.phone_numbers" />
          </el-form-item>

          <el-form-item label="Koordinat Lokasi" prop="coordinates">
            <InputMap v-model="form.coordinates" />
          </el-form-item>

          <el-form-item>
            <el-button type="primary" @click="submitForm">{{ $t('crud.create') }}</el-button>
            <el-button>{{ $t('crud.cancel') }}</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, create, update } from '@/api/phonebooks'

import InputSelectArea from '@/components/InputSelectArea'
import InputMap from '@/components/InputMap'
import InputCategory from '@/components/InputCategory'

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
  phone_numbers: [],
  coordinates: [null, null]
}

export default {
  components: {
    InputSelectArea,
    InputMap,
    InputCategory,
    ListPhoneNumber
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorWilayah = (rule, value, callback) => {
      if (this.form.seq === 1 && (this.form.kabkota_id === null && this.form.kec_id === null && this.form.kel_id === null)) {
        callback(new Error('Wilayah harus diisi.'))
      }
      callback()
    }

    return {
      form: Object.assign({}, defaultForm),
      loading: false,
      rules: {
        name: [
          { required: true, message: 'Nama Instansi harus diisi.', trigger: 'blur' }
        ],
        address: [
          //
        ],
        category_id: [
          { required: true, message: 'Kategori Instansi harus diisi.', trigger: 'blur' }
        ],
        description: [
          //
        ],
        seq: [
          { required: true, message: 'Call Center harus diisi.', trigger: 'blur' }
        ],
        wilayah: [
          { validator: validatorWilayah, trigger: 'blur' }
        ],
        kec_id: [
          { required: true, message: 'Kecamatan harus diisi.', trigger: 'blur' }
        ],
        kel_id: [
          { required: true, message: 'Kelurahan harus diisi.', trigger: 'blur' }
        ],
        phone_numbers: [
          { required: true, message: 'Nomor Telepon harus diisi.', trigger: 'blur' }
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

        const { latitude, longitude } = response.data

        this.form.coordinates = [latitude, longitude]
      }).catch(err => {
        console.log(err)
      })
    },

    async submitForm() {
      const valid = await this.$refs.form.validate()

      console.log(valid)

      if (!valid) {
        return
      }

      const data = {}

      Object.assign(data, this.form)

      if (this.isEdit) {
        const id = this.$route.params && this.$route.params.id

        await update(id, data)
      } else {
        await create(data)
      }
    }
  }
}
</script>
