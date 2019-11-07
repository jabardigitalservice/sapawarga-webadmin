<template>
  <div>
    <label class="custom-file-upload primary-custome"> {{ $t('label.select-file') }}
      <input ref="file" type="file" accept=".pdf, .doc, .docx, .ppt, .pptx, image/*" @change="handleFileUpload">
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
<style lang="scss" scoped>
	input[type="file"] {
    display: none;
  }

  .custom-file-upload {
    cursor: pointer;
    background: #FFFFFF;
    border: 1px solid #DCDFE6;
    border-color: #DCDFE6;
    color: #606266;
    -webkit-appearance: none;
    text-align: center;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    outline: none;
    -webkit-transition: .1s;
    transition: .1s;
    font-weight: 400;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    font-size: 14px;
    border-radius: 4px;
    width: 90px;
    display: inline-block;
		padding: 0px 0px;
    margin-bottom: 10px;
  }

  .import-file {
    display: block;
  }

  .primary-custome {
    color: white;
    background:#409eff;
    border-color: #409eff;
  }

  .primary-custome:hover {
    background: #46a6ff;
    border-color: #46a6ff;
    color: #FFFFFF;
  }

	.file-name {
		margin-left: 10px;
		padding: 7px;
		border-radius: 5px;
	}

	.file-name:hover {
		background: rgb(241, 243, 245);
		cursor: pointer;

		.remove {
			display: inline;
			margin-left: 50px;
			background:rgb(109, 102, 102);
			color: white;
			border-radius: 100%;
			padding: 0px 4px 1px 4px;
		}
	}

	.remove {
		display: none;
	}

</style>
