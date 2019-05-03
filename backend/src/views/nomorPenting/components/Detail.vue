<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="postForm" :rules="rules" class="form-container">
    </el-form>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/phonebooks'

const defaultForm = {
  //
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
      postForm: Object.assign({}, defaultForm),
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
      this.postForm = Object.assign({}, defaultForm)
    }
  },
  methods: {
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.postForm = response.data
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
