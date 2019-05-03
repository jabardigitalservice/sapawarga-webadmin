<template>
  <div class="container">
    <el-form ref="form" :model="form" label-width="120px">
      <el-form-item label="Nama Instansi">
        <el-input v-model="form.name"></el-input>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/phonebooks'

const defaultForm = {
  name: null
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
