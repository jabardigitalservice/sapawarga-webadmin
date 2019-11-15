<template>
  <div>
    <label class="custom-file-upload primary-custome"> {{ $t('label.select-file') }}
      <input ref="file" class="input-multiple" type="file" accept=".pdf, .doc, .docx, .ppt, .pptx, image/*" @change="handleFileUpload">
    </label>
    <span v-if="fileAccept !== null" class="file-name">
      {{ fileAccept }}
      <el-tooltip class="item" effect="dark" content="Hapus lampiran" placement="right">
        <span class="remove" @click="removeFile(index)">x</span>
      </el-tooltip>
    </span>
  </div>
</template>
<script>
import { upload } from '@/api/attachments'
export default {
  props: {
    fileEdit: {
      default: null,
      type: Object
    },
    index: {
      default: null,
      type: Number
    }
  },
  data() {
    return {
      fileSend: null,
      fileAccept: null
    }
  },
  created() {
    this.fileAccept = this.fileEdit.name
  },
  methods: {
    handleFileUpload(event) {
      this.fileSend = this.$refs.file.files[0]

      this.onUpload()
    },
    async onUpload() {
      try {
        this.loading = true

        const formData = new FormData()

        formData.append('file', this.fileSend)
        formData.append('type', 'news_important_attachment')

        const { data } = await upload(formData)
        const { path, url } = data

        this.fileAccept = path.replace('general/', '')

        this.$emit('onUpload', path, url)
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    removeFile(key) {
      this.fileSend = null
      this.fileAccept = null

      this.$emit('getId', key)
    }
  }
}
</script>
