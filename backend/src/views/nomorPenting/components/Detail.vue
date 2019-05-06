<template>
  <div class="components-container">
    <p class="warn-content"><a href="#">Nomor Telepon Penting</a></p>
    <el-row :gutter="20">
      <el-col :span="5">
        Gambar
      </el-col>
      <el-col :span="19">
        <el-form ref="form" :model="form" label-width="160px">
          <el-form-item label="Nama Instansi" required>
            <el-input v-model="form.name" />
          </el-form-item>

          <el-form-item label="Alamat Instansi">
            <el-input v-model="form.address" />
          </el-form-item>

          <el-form-item label="Kategori Instansi" required />

          <el-form-item label="Deskripsi" required>
            <el-input v-model="form.description" type="textarea" rows="5" />
          </el-form-item>

          <el-form-item label="Call Center" required>
            <el-radio v-model="form.seq" :label="1000">Ya</el-radio>
            <el-radio v-model="form.seq" :label="1">Tidak</el-radio>
          </el-form-item>

          <el-form-item label="Wilayah">
            <InputSelectArea
              :kabkota-id="form.kabkota_id"
              :kec-id="form.kec_id"
              :kel-id="form.kel_id"
              @changeKabkota="form.kabkota_id = $event"
              @changeKecamatan="form.kec_id = $event"
              @changeKelurahan="form.kel_id = $event"
            />
          </el-form-item>

          <el-form-item label="Nomor Telepon" required>
            <ListPhoneNumber v-model="form.phone_numbers" />
          </el-form-item>

          <el-form-item label="Koordinat Lokasi" />

          <el-form-item>
            <el-button type="primary">{{ $t('crud.create') }}</el-button>
            <el-button>{{ $t('crud.cancel') }}</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/phonebooks'

import InputSelectArea from '@/components/InputSelectArea'
import ListPhoneNumber from './ListPhoneNumber'

const defaultForm = {
  name: null,
  address: null,
  description: null,
  kabkota_id: null,
  kec_id: null,
  kel_id: null,
  seq: null,
  phone_numbers: [
    {
      'type': 'phone',
      'phone_number': '022-123456'
    },
    {
      'type': 'message',
      'phone_number': '022-098763'
    }
  ]
}

export default {
  components: {
    InputSelectArea,
    ListPhoneNumber
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      form: Object.assign({}, defaultForm),
      loading: false,
      userListOptions: [],
      rules: {
        //
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

    submitForm() {
      //
    }
  }
}
</script>
