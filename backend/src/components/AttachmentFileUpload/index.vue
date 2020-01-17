<template>
  <div>
    <el-upload
      class="upload-demo"
      action="#"
      accept=" .jpg, .jpeg, .png"
      :on-change="handleUpload"
      :on-remove="handleRemove"
      :before-remove="beforeRemove"
      multiple
      :limit="limitFile"
      :on-exceed="handleExceed"
      :file-list="fileList"
      :auto-upload="false"
    >
      <el-button size="small" type="primary">Click to upload</el-button>
      <div slot="tip" class="el-upload__tip">jpg/png/jpeg files with a size less than 500kb</div>
    </el-upload>
  </div>
</template>

<script>
import { upload } from '@/api/attachments'

export default {
  props: {
    initialUrl: { // eslint-disable-line
      default: null
    },
    type: {
      type: String,
      required: true
    },
    limitFile: {
      type: Number,
      required: true
    },
    listInformation: {
      type: Array,
      default: function() { return [] }
    }
  },
  data() {
    return {
      image_default: require('@/assets/none.png'),
      image: null,
      image_url: null,
      loading: false,
      fileList: []
    }
  },
  watch: {
    initialUrl: {
      handler: function(value) {
        this.image_url = value
      },
      immediate: true
    }
  },

  methods: {
    handleRemove(file, fileList) {
      console.log(file, fileList)
    },
    handleExceed(files, fileList) {
      this.$message.warning(this.$t('errors.max-file-upload', [this.limitFile]))
    },
    async handleUpload(file, fileList) {
      this.loading = true

      try {
        const formData = new FormData()

        formData.append('file', file.raw, file.raw.name)
        formData.append('type', this.type)

        const { data } = await upload(formData)
        const { path, url } = data

        this.image_url = url

        this.$emit('onUpload', path, url)
        // {name: 'food.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}
      } catch (e) {
        if (e.response && e.response.status === 422) {
          this.$message({
            message: e.response.data.data.file[0],
            type: 'error'
          })

          return
        }

        this.$message({
          message: this.$t('errors.internal-server-error'),
          type: 'error'
        })
      } finally {
        this.loading = false
      }
    },
    beforeRemove(file, fileList) {
      return this.$confirm(`Cancel the transfert of ${file.name} ?`)
    }

  }
}
</script>
