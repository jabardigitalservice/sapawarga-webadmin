<template>
  <div>
    <el-upload
      class="upload-demo"
      action="#"
      :accept="typeFile"
      :on-change="handleUpload"
      :on-remove="handleRemove"
      :before-remove="beforeRemove"
      multiple
      :limit="limitFile"
      :on-exceed="handleExceed"
      :file-list="fileList"
      :auto-upload="false"
      list-type="picture"
    >
      <el-button size="small" type="primary">{{ $t('label.click-upload') }}</el-button>
      <div slot="tip" class="el-upload__tip">{{ description }}</div>
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
    typeFile: {
      type: String,
      required: true
    },
    limitFile: {
      type: Number,
      required: true
    },
    filePath: {
      type: String,
      default: null
    },
    description: {
      type: String,
      default: null
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
    },
    filePath: {
      handler: function(value) {
        if (value !== null) {
          this.fileList.push({ name: value, url: value })
        }
      },
      immediate: true
    }
  },

  methods: {
    handleRemove(file, fileList) {
      this.fileList = []
      this.$emit('onRemove')
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
        this.fileList.push({ name: path, url: url })
      } catch (e) {
        if (e.response && e.response.status === 422) {
          this.$message({
            message: e.response.data.data.file[0],
            type: 'error'
          })

          return
        }
        this.fileList = []

        this.$message({
          message: this.$t('errors.internal-server-error'),
          type: 'error'
        })
      } finally {
        this.loading = false
      }
    },
    beforeRemove(file, fileList) {
      return this.$confirm(this.$t('message.confirmation-delete-file-message', [file.name]))
    }

  }
}
</script>
