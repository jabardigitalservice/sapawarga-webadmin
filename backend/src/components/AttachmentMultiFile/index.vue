<template>
  <div>
    <label class="custom-file-upload primary-custome"> {{ $t('label.select-file') }}
      <input ref="file" class="input-multiple" type="file" accept=".pdf, .doc, .docx, .ppt, .pptx, image/*" @change="handleFileUpload">
    </label>
    <span v-if="file !== null" class="file-name">
      {{ file.name }}
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
      file: null
    }
  },
  created() {
    this.file = this.fileEdit
  },
  methods: {
    handleFileUpload(event) {
      this.file = this.$refs.file.files[0]

      this.onUpload()
    },
    async onUpload() {
      try {
        this.loading = true

        const formData = new FormData()

        formData.append('file', this.file)
        formData.append('type', 'news_important_attachment')

        const { data } = await upload(formData)
        const { path, url } = data

        this.$emit('onUpload', path, url)
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    removeFile(key) {
      this.file = null

      this.$emit('getId', key)
    }
  }
}
</script>
