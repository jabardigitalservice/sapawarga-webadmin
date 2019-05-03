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

const defaultForm = {
  name: null,
  address: null,
  description: null
}

export default {
  components: {
    //
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
