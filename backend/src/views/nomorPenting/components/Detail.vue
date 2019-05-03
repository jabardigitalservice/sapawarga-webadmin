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
            <el-input v-model="form.name"></el-input>
          </el-form-item>

          <el-form-item label="Alamat Instansi">
            <el-input v-model="form.address"></el-input>
          </el-form-item>

          <el-form-item label="Deskripsi">
            <el-input type="textarea" v-model="form.description" rows="5"></el-input>
          </el-form-item>

          <el-form-item label="Wilayah">
            <InputSelectArea
                :kabkota-id="form.kabkota_id"
                :kec-id="form.kec_id"
                :kel-id="form.kel_id"
                @changeKabkota="form.kabkota_id = $event"
                @changeKecamatan="form.kec_id = $event"
                @changeKelurahan="form.kel_id = $event"
            ></InputSelectArea>
          </el-form-item>

          <el-form-item label="Nomor Telepon">
            <el-row v-for="row in form.phone_numbers" :key="row">
              <el-col :span="5">Telepon</el-col>
              <el-col :span="5">{{ row.phone_number }}</el-col>
              <el-col :span="5">{{ row.type }}</el-col>
              <el-col :span="5">Hapus</el-col>
            </el-row>
          </el-form-item>

          <el-form-item>
            <el-button type="primary">Create</el-button>
            <el-button>Cancel</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/phonebooks'

import InputSelectArea from '@/components/InputSelectArea'

const defaultForm = {
  name: null,
  address: null,
  description: null,
  kabkota_id: null,
  kec_id: null,
  kel_id: null,
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
    InputSelectArea
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
    },
  }
}
</script>
